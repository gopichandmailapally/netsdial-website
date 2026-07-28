<?php
/**
 * NetsDial - Main Configuration
 * GCM Enterprises | netsdial@gmail.com
 */

// Prevent direct access
if (!defined('NETSDIAL')) {
    define('NETSDIAL', true);
}

// ── Site Paths ────────────────────────────────────────────────
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'netsdial.com';
define('SITE_URL', $protocol . '://' . $host);
define('ROOT_PATH', dirname(__DIR__));
define('ASSETS_URL', SITE_URL . '/assets');
define('UPLOADS_URL', SITE_URL . '/uploads');

// ── Contact Details ──────────────────────────────────────────
define('SITE_PHONE', '9966499144');
define('SITE_PHONE_LINK', 'tel:+919966499144');
define('SITE_WHATSAPP', 'https://wa.me/919966499144');
define('SITE_EMAIL', 'netsdial@gmail.com');
define('SITE_EMAIL_LINK', 'mailto:netsdial@gmail.com');
define('COMPANY_NAME', 'GCM Enterprises');
define('BRAND_NAME', 'Russea™');
define('TRADEMARK', 'Russea™');
define('BRAND_TAGLINE', 'India\'s Largest Wholesale Russea™ HDPE Net Suppliers | South India #1');
define('WHOLESALE_MSG', 'Wholesale Russea™ HDPE Net Suppliers | PAN India Delivery | Largest from South India');
define('SITE_ADDRESS', 'Plot No.91, Road Number 2, Sri Ram Nagar Colony, Karmanghat, Saroornagar - 500035, Hyderabad, Telangana, India');

// ── Load Database ─────────────────────────────────────────────
require_once ROOT_PATH . '/config/database.php';

// ── Session ───────────────────────────────────────────────────
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ── Timezone ──────────────────────────────────────────────────
date_default_timezone_set('Asia/Kolkata');

// ── Error Reporting (set to 0 in production) ──────────────────
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// ── Main Menu Pages ───────────────────────────────────────────
define('MAIN_MENU', [
    ['title' => 'Home',       'url' => '/',             'icon' => 'fa-home'],
    ['title' => 'About',      'url' => '/about.php',    'icon' => 'fa-info-circle'],
    ['title' => 'Services',   'url' => '/services.php', 'icon' => 'fa-tools', 'has_mega' => true],
    ['title' => 'Gallery',    'url' => '/gallery.php',  'icon' => 'fa-images'],
    ['title' => 'Videos',     'url' => '/videos.php',   'icon' => 'fa-video'],
    ['title' => 'Estimation', 'url' => '/estimation.php','icon' => 'fa-calculator'],
    ['title' => 'Reviews',    'url' => '/reviews.php',  'icon' => 'fa-star'],
    ['title' => 'Blogs',      'url' => '/blogs.php',    'icon' => 'fa-blog'],
    ['title' => "FAQ's",      'url' => '/faq.php',      'icon' => 'fa-question-circle'],
    ['title' => 'Contact',    'url' => '/contact.php',  'icon' => 'fa-envelope'],
]);

// ── Service Categories ────────────────────────────────────────
define('SERVICE_CATEGORIES', [
    'Safety & Bird Control' => ['icon' => 'fa-shield-alt', 'color' => '#FF6B00'],
    'Home Fittings'         => ['icon' => 'fa-home',       'color' => '#2196F3'],
    'Sports & Recreation'   => ['icon' => 'fa-futbol',     'color' => '#4CAF50'],
]);

// ── Helper Functions ──────────────────────────────────────────
function slugify($text) {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9\-]/', '-', $text);
    $text = preg_replace('/-+/', '-', $text);
    return trim($text, '-');
}

function cleanInput($data) {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

function generateServicePageTitle($keyword, $area, $district) {
    return $keyword . ' in ' . $area . ', ' . $district;
}

function generateServiceSlug($keyword_slug, $area_slug, $district_slug) {
    return "/services/{$district_slug}/{$area_slug}/{$keyword_slug}/";
}

function formatPhone($phone) {
    return preg_replace('/[^0-9]/', '', $phone);
}

function getMetaTitle($page_title, $suffix = '') {
    $site = 'NetsDial - ' . TRADEMARK . ' Net Suppliers';
    return $page_title . ($suffix ? ' | ' . $suffix : '') . ' | ' . $site;
}

function getServiceMetaDesc($keyword, $area, $district) {
    return "Buy premium {$keyword} in {$area}, {$district} from NetsDial - Authorized " . TRADEMARK . " HDPE net wholesale suppliers. Best price, quality guarantee. Call: " . SITE_PHONE;
}

function formatCurrency($amount) {
    return '₹' . number_format($amount, 0, '.', ',');
}

function timeAgo($datetime) {
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    if ($diff->y > 0) return $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
    if ($diff->m > 0) return $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
    if ($diff->d > 0) return $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
    if ($diff->h > 0) return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
    return 'Just now';
}

function getStars($rating) {
    $html = '';
    for ($i = 1; $i <= 5; $i++) {
        $html .= '<i class="fas fa-star' . ($i <= $rating ? ' active' : '') . '"></i>';
    }
    return $html;
}

function redirect($url, $code = 302) {
    header("Location: $url", true, $code);
    exit;
}

function isAdmin() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function requireAdmin() {
    if (!isAdmin()) {
        redirect('/admin/login.php');
    }
}

function getVisitorCount() {
    $base = (int) getSetting('visitor_count_base', 102098);
    $actual = db()->fetchOne("SELECT COUNT(*) as cnt FROM visitors")['cnt'] ?? 0;
    return $base + $actual;
}

function getDeviceType($ua) {
    if (preg_match('/Mobile|Android|iPhone|iPad/i', $ua)) return 'Mobile';
    if (preg_match('/Tablet|iPad/i', $ua)) return 'Tablet';
    return 'Desktop';
}

function getBrowser($ua) {
    if (str_contains($ua, 'Chrome')) return 'Chrome';
    if (str_contains($ua, 'Firefox')) return 'Firefox';
    if (str_contains($ua, 'Safari')) return 'Safari';
    if (str_contains($ua, 'Edge')) return 'Edge';
    return 'Other';
}

function generateQutotationNo() {
    $year  = date('Y');
    $month = date('m');
    $count = db()->fetchOne("SELECT COUNT(*) as cnt FROM quotations WHERE YEAR(created_at) = YEAR(NOW())")['cnt'] ?? 0;
    return 'ND/' . $year . '/' . $month . '/' . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
}

function buildBreadcrumb(array $items) {
    $html = '<ol class="breadcrumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">';
    foreach ($items as $i => $item) {
        $pos = $i + 1;
        if ($item[1]) {
            $html .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="' . htmlspecialchars($item[1]) . '" itemprop="item"><span itemprop="name">' . htmlspecialchars($item[0]) . '</span></a><meta itemprop="position" content="' . $pos . '"/></li>';
        } else {
            $html .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">' . htmlspecialchars($item[0]) . '</span><meta itemprop="position" content="' . $pos . '"/></li>';
        }
        if ($i < count($items) - 1) $html .= '<li class="sep"><i class="fas fa-chevron-right"></i></li>';
    }
    return $html . '</ol>';
}

function trackVisitor() {
    if (php_sapi_name() === 'cli') return;
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['visit_id'])) {
        $ip      = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $ip      = trim(explode(',', $ip)[0]);
        $ua      = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $ref     = $_SERVER['HTTP_REFERER'] ?? '';
        $page    = $_SERVER['REQUEST_URI'] ?? '/';
        $session = session_id();
        $device  = getDeviceType($ua);
        $browser = getBrowser($ua);

        $existing = db()->fetchOne("SELECT id FROM visitors WHERE session_id=?", [$session]);
        if ($existing) {
            $_SESSION['visit_id'] = $existing['id'];
            db()->execute("UPDATE visitors SET is_live=1, updated_at=NOW(), pages_visited=pages_visited+1 WHERE id=?", [$existing['id']]);
        } else {
            $vid = db()->insert(
                "INSERT INTO visitors (session_id,ip_address,user_agent,device_type,browser,referrer,first_page,is_live) VALUES (?,?,?,?,?,?,?,1)",
                [$session, $ip, $ua, $device, $browser, $ref, $page]
            );
            $_SESSION['visit_id'] = $vid;
            // Async geo lookup – fire and forget
            @file_get_contents("http://ip-api.com/json/$ip?fields=country,city,lat,lon");
        }

        try {
            db()->insert("INSERT INTO visitor_pages (visitor_id,page_url) VALUES (?,?)", [$_SESSION['visit_id'], $page]);
        } catch(Exception $e) {}
    }
}
