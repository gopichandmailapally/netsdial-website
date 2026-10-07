<?php
/**
 * ============================================================================
 * NETSDIAL — HIGH PERFORMANCE DYNAMIC SEO ROUTER
 * ============================================================================
 * Handles 5,250,000+ SEO URLs strictly enforcing:
 * "Feasible Location Service System"
 * ============================================================================
 */

define("NETSDIAL", true);
require_once __DIR__ . "/config/config.php";
require_once __DIR__ . "/includes/feasible_location_service_system.php";
require_once __DIR__ . "/includes/geo_resolver.php";

$uri = $_SERVER["REQUEST_URI"] ?? "/";
$cleanUri = trim(parse_url($uri, PHP_URL_PATH), "/");

// 1. Static PHP files handling
if (!empty($cleanUri) && file_exists(__DIR__ . "/" . $cleanUri . ".php")) {
    require __DIR__ . "/" . $cleanUri . ".php";
    exit;
}
if (!empty($cleanUri) && file_exists(__DIR__ . "/" . $cleanUri)) {
    return false; // let web server handle static file
}

// 2. Parse SEO URL patterns:
// Pattern A: /{service}-{intent}-in-{location}
// Pattern B: /{service}-in-{location}
$service_slug  = "";
$intent_slug   = "dealers";
$location_slug = "";
$matched = false;

if (preg_match('/^([a-z0-9-]+)-in-([a-z0-9-]+)$/i', $cleanUri, $m)) {
    $service_and_intent = $m[1];
    $location_slug      = $m[2];

    foreach (FeasibleLocationServiceSystem::$SERVICES as $s_slug => $s_data) {
        if ($service_and_intent === $s_slug) {
            $service_slug = $s_slug;
            $intent_slug  = "dealers";
            $matched = true;
            break;
        }
        if (str_starts_with($service_and_intent, $s_slug . "-")) {
            $possible_intent = substr($service_and_intent, strlen($s_slug) + 1);
            $service_slug = $s_slug;
            $intent_slug  = $possible_intent;
            $matched = true;
            break;
        }
    }
}

// Pattern C: /services/{district}/{area}/{keyword}/
if (!$matched && preg_match('/^services\/([a-z0-9-]+)\/([a-z0-9-]+)\/([a-z0-9-]+)$/i', $cleanUri, $m)) {
    $location_slug = $m[2];
    $service_slug  = $m[3];
    $intent_slug   = "dealers";
    $matched = true;
}

if ($matched && !empty($service_slug) && !empty($location_slug)) {
    // Resolve location name, district, state
    $geo_file = __DIR__ . "/includes/geo_taxonomy.json";
    $geo = file_exists($geo_file) ? json_decode(file_get_contents($geo_file), true) : ["districts" => [], "areas" => []];
    
    $loc_name = $geo["areas"][$location_slug] ?? ($geo["districts"][$location_slug] ?? ucwords(str_replace('-', ' ', $location_slug)));
    $resolved_geo = resolveSmartGeoLocation($location_slug, $loc_name);
    
    $parts = array_map('trim', explode(',', $resolved_geo));
    $area_name     = $parts[0] ?? ucwords(str_replace('-', ' ', $location_slug));
    $district_name = $parts[1] ?? $area_name;
    $state_name    = $parts[2] ?? ($parts[1] ?? 'India');

    // STRICT EVALUATION VIA FEASIBLE LOCATION SERVICE SYSTEM
    $eval = FeasibleLocationServiceSystem::evaluateServiceLocation($service_slug, $area_name, $district_name, $state_name);

    if (!$eval["allowed"]) {
        http_response_code(404);
        $page_meta_title = "Service Not Available in this Location - NetsDial";
        include __DIR__ . '/includes/header.php';
        echo '<div class="section container py-5 text-center">';
        echo '<div style="max-width:600px;margin:0 auto;background:#fff;padding:40px;border-radius:12px;box-shadow:0 4px 20px rgba(0,0,0,0.08);">';
        echo '<i class="fas fa-info-circle text-warning" style="font-size:48px;margin-bottom:20px;"></i>';
        echo '<h2 style="font-size:24px;color:#1e293b;margin-bottom:12px;">Service Geo-Scope Notice</h2>';
        echo '<p style="color:#64748b;font-size:16px;line-height:1.6;">' . htmlspecialchars($eval["reason"]) . '</p>';
        echo '<div style="margin-top:25px;"><a href="/" class="btn btn-primary px-4 py-2">Explore Available Services</a></div>';
        echo '</div></div>';
        include __DIR__ . '/includes/footer.php';
        exit;
    }

    // Set variables for service.php template
    $_GET['service']     = $service_slug;
    $_GET['keyword']     = $service_slug;
    $_GET['intent']      = $intent_slug;
    $_GET['area']        = $location_slug;
    $_GET['district']    = strtolower(str_replace(' ', '-', $district_name));
    $_GET['area_name']   = $area_name;
    $_GET['city_name']   = $district_name;
    $_GET['state_name']  = $state_name;
    $_GET['eval_data']   = $eval;

    require __DIR__ . '/service.php';
    exit;
}

// 3. Fallback to index.php or 404
if (empty($cleanUri)) {
    require __DIR__ . '/index.php';
    exit;
}

http_response_code(404);
include __DIR__ . '/includes/header.php';
echo '<div class="section container py-5 text-center"><h1>404 — Page Not Found</h1><a href="/" class="btn btn-primary mt-3">Back to Home</a></div>';
include __DIR__ . '/includes/footer.php';
