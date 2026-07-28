<?php
/**
 * NetsDial - Visitor Tracking API
 * Tracks page views, live visitors, location, time spent
 */
define('NETSDIAL', true);
require_once dirname(__DIR__) . '/config/config.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';
$input  = json_decode(file_get_contents('php://input'), true) ?? [];

switch ($action) {
    case 'track':
        trackVisitor($input);
        break;
    case 'heartbeat':
        heartbeat($input);
        break;
    case 'leave':
        visitorLeave($input);
        break;
    case 'live_count':
        echo json_encode(['count' => getLiveCount()]);
        break;
    default:
        echo json_encode(['ok' => true]);
}

function trackVisitor($data) {
    $session_id = cleanInput($data['session_id'] ?? '');
    $page_url   = substr(cleanInput($data['page_url'] ?? ''), 0, 500);
    $page_title = substr(cleanInput($data['page_title'] ?? ''), 0, 300);
    $referrer   = substr(cleanInput($data['referrer'] ?? ''), 0, 500);
    $ip         = $_SERVER['REMOTE_ADDR'] ?? '';
    $ua         = $_SERVER['HTTP_USER_AGENT'] ?? '';

    if (!$session_id) { echo json_encode(['ok' => false]); return; }

    $device  = getDeviceType($ua);
    $browser = getBrowser($ua);

    // Check if session exists
    $existing = db()->fetchOne(
        "SELECT id, pages_visited FROM visitors WHERE session_id = ?",
        [$session_id]
    );

    if ($existing) {
        // Update existing visitor
        db()->execute(
            "UPDATE visitors SET last_page=?, pages_visited=pages_visited+1, is_live=1, updated_at=NOW() WHERE session_id=?",
            [$page_url, $session_id]
        );
        $visitor_id = $existing['id'];
    } else {
        // Get location from IP (simple)
        $location = getIpLocation($ip);

        $visitor_id = db()->insert(
            "INSERT INTO visitors (session_id, ip_address, country, state, city, latitude, longitude, user_agent, device_type, browser, referrer, first_page, last_page, is_live) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)",
            [$session_id, $ip, $location['country'], $location['state'], $location['city'],
             $location['lat'], $location['lon'], substr($ua, 0, 500), $device, $browser,
             $referrer, $page_url, $page_url]
        );
    }

    // Log page
    if ($visitor_id) {
        db()->insert(
            "INSERT INTO visitor_pages (visitor_id, page_url, page_title) VALUES (?, ?, ?)",
            [$visitor_id, $page_url, $page_title]
        );
    }

    echo json_encode(['ok' => true, 'visitor_id' => $visitor_id]);
}

function heartbeat($data) {
    $session_id = cleanInput($data['session_id'] ?? '');
    if (!$session_id) { echo json_encode(['ok' => false]); return; }
    db()->execute(
        "UPDATE visitors SET is_live=1, time_spent=time_spent+30, updated_at=NOW() WHERE session_id=?",
        [$session_id]
    );
    echo json_encode(['ok' => true]);
}

function visitorLeave($data) {
    $session_id = cleanInput($data['session_id'] ?? '');
    if (!$session_id) { echo json_encode(['ok' => false]); return; }
    db()->execute(
        "UPDATE visitors SET is_live=0, updated_at=NOW() WHERE session_id=?",
        [$session_id]
    );
    echo json_encode(['ok' => true]);
}

function getLiveCount() {
    // Consider live if updated in last 2 minutes
    $count = db()->fetchOne(
        "SELECT COUNT(*) as cnt FROM visitors WHERE is_live=1 AND updated_at >= DATE_SUB(NOW(), INTERVAL 2 MINUTE)"
    );
    return max(1, (int)($count['cnt'] ?? 1));
}

function getIpLocation($ip) {
    // Default/fallback
    $default = ['country' => 'India', 'state' => 'Telangana', 'city' => 'Hyderabad', 'lat' => 17.3850, 'lon' => 78.4867];
    if (in_array($ip, ['127.0.0.1', '::1', 'localhost'])) return $default;

    // Try ip-api.com (free tier - 45 req/min)
    $ctx = stream_context_create(['http' => ['timeout' => 2]]);
    try {
        $json = @file_get_contents("http://ip-api.com/json/{$ip}?fields=status,country,regionName,city,lat,lon", false, $ctx);
        if ($json) {
            $data = json_decode($json, true);
            if ($data && $data['status'] === 'success') {
                return [
                    'country' => $data['country'] ?? 'India',
                    'state'   => $data['regionName'] ?? 'Telangana',
                    'city'    => $data['city'] ?? 'Hyderabad',
                    'lat'     => $data['lat'] ?? 17.385,
                    'lon'     => $data['lon'] ?? 78.487,
                ];
            }
        }
    } catch (Exception $e) { }
    return $default;
}
