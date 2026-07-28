<?php
/**
 * NetsDial - Menu AJAX API
 * Returns areas and keywords for mega menu
 */
define('NETSDIAL', true);
require_once dirname(__DIR__) . '/config/config.php';

header('Content-Type: application/json');
header('Cache-Control: public, max-age=3600');

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'areas':
        $district_id = (int)($_GET['district_id'] ?? 0);
        if (!$district_id) {
            echo json_encode([]);
            exit;
        }
        $areas = db()->fetchAll(
            "SELECT id, name, slug FROM areas WHERE district_id = ? AND is_active = 1 ORDER BY sort_order",
            [$district_id]
        );
        echo json_encode($areas);
        break;

    case 'districts':
        $districts = db()->fetchAll(
            "SELECT id, name, slug, state FROM districts WHERE is_active = 1 ORDER BY sort_order"
        );
        echo json_encode($districts);
        break;

    case 'keywords':
        $keywords = db()->fetchAll(
            "SELECT id, name, slug, icon, category FROM service_keywords WHERE is_active = 1 ORDER BY sort_order"
        );
        echo json_encode($keywords);
        break;

    default:
        echo json_encode(['error' => 'Invalid action']);
}
