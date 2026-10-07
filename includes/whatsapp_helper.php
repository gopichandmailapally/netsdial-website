<?php
/**
 * Smart Dynamic WhatsApp Helper for NetsDial
 * Generates rich, high-converting WhatsApp inquiry messages tailored to the specific product/service, location, and page.
 * Format matches GCM Enterprises standard:
 * 
 * Hi NetsDial, I would like to inquire about *[Service]* in *[Location]*.
 * • Service: [Service]
 * • Location: [Location]
 * • Page: [Full URL]
 * • Website: www.netsdial.com
 * [Pricing/Technical prompt]
 */

require_once __DIR__ . '/geo_resolver.php';

if (!function_exists('getNetsdialPageContext')) {
function getNetsdialPageContext($customService = null, $customLocation = null) {
    global $page_meta_title, $page_title, $current_service, $area_name, $area_slug, $service_title, $district, $area, $district_slug, $city_name, $state_name;

    $uri = $_SERVER['REQUEST_URI'] ?? '';
    $script = basename($_SERVER['SCRIPT_NAME'] ?? '');
    $cleanUri = trim(strtok($uri, '?'), '/');
    $title = $page_meta_title ?? ($page_title ?? '');

    // 1. Detect Service
    $service = $customService;
    if (empty($service) && !empty($service_title)) {
        $service = $service_title;
    }
    if (empty($service) && !empty($current_service['name'])) {
        $service = $current_service['name'];
    }

    if (empty($service)) {
        if (preg_match('#^services/[a-z0-9-]+/[a-z0-9-]+/([a-z0-9-]+)#i', $cleanUri, $m)) {
            $slug = $m[1];
            $svcMap = [
                'cloth-hangers-installation' => 'Balcony & Ceiling Cloth Drying Hanger',
                'cloth-drying-hanger' => 'Balcony & Ceiling Cloth Drying Hanger',
                'balcony-safety-nets' => 'Balcony Safety Nets Installation',
                'pigeon-safety-nets' => 'Pigeon Safety Nets & Netting',
                'pigeon-net-for-balcony' => 'Pigeon Net for Balcony',
                'pigeon-nets' => 'Pigeon Safety Nets',
                'invisible-grill-for-balcony' => 'Invisible Grill for Balcony',
                'invisible-grills' => 'Stainless Steel 316 Invisible Grills',
                'children-safety-nets' => 'Children Safety Nets for Balcony & Stairs',
                'anti-bird-nets' => 'Anti-Bird Protection Netting',
                'cricket-nets' => 'Cricket Practice Pitch Nets',
                'cricket-practice-nets' => 'Cricket Practice Net Installation',
                'sports-nets' => 'Sports & Court Perimeter Netting',
                'box-cricket-nets' => 'Box Cricket Ground Setup & Netting',
                'duct-area-safety-nets' => 'Duct Area Safety Nets',
                'pulley-cloth-drying-hanger' => 'Pulley Cloth Drying Hanger',
                'bird-spikes' => 'Anti-Bird & Pigeon Spikes',
                'industrial-safety-nets' => 'Industrial & Construction Safety Nets',
                'fall-safety-nets' => 'Fall Protection Safety Nets',
                'monkey-safety-nets' => 'Monkey Protection Safety Nets',
                'staircase-safety-nets' => 'Staircase Safety Nets',
                'swimming-pool-safety-nets' => 'Swimming Pool Safety Nets'
            ];
            $service = $svcMap[$slug] ?? ucwords(str_replace('-', ' ', $slug));
        } elseif (preg_match('/^([a-z0-9-]+)-in-([a-z0-9-]+)/', $cleanUri, $m)) {
            $slug = $m[1];
            $service = ucwords(str_replace('-', ' ', $slug));
        }
    }

    if (empty($service)) {
        $check = strtolower($title . ' ' . $cleanUri . ' ' . $script);
        if (strpos($check, 'cloth-hanger') !== false || strpos($check, 'drying-hanger') !== false || strpos($check, 'pulley-cloth') !== false) {
            $service = 'Balcony & Ceiling Cloth Drying Hanger';
        } elseif (strpos($check, 'box-cricket') !== false || strpos($check, 'box cricket') !== false) {
            $service = 'Box Cricket Ground Setup & Netting';
        } elseif (strpos($check, 'cricket') !== false) {
            $service = 'Box Cricket & Practice Pitch Nets';
        } elseif (strpos($check, 'balcony') !== false) {
            $service = 'Balcony Safety Nets Installation';
        } elseif (strpos($check, 'bird') !== false || strpos($check, 'pigeon') !== false) {
            $service = 'Anti-Bird & Pigeon Netting';
        } elseif (strpos($check, 'invisible-grill') !== false || strpos($check, 'grill') !== false) {
            $service = 'Stainless Steel Invisible Grills';
        } elseif (strpos($check, 'sports') !== false) {
            $service = 'Sports Ground & Perimeter Netting';
        } elseif (strpos($check, 'turf') !== false || strpos($check, 'grass') !== false) {
            $service = 'Artificial Grass Turf & Sports Flooring';
        } elseif (!empty($title)) {
            $cleaned = preg_replace('/[–—|\-].*$/', '', $title);
            $service = trim($cleaned) ?: 'Russea™ HDPE Safety Nets';
        } else {
            $service = 'Russea™ HDPE Safety Nets & Grills';
        }
    }

    // 2. Detect Granular Geographic Location
    $location = '';
    if (!empty($customLocation)) {
        $location = resolveSmartGeoLocation($customLocation);
    }
    
    if (empty($location)) {
        if (!empty($area_name) && !empty($city_name)) {
            $locSt = (!empty($state_name) && $state_name !== 'India') ? $state_name : '';
            if (!empty($locSt)) {
                $location = $area_name . ', ' . $city_name . ', ' . $locSt;
            } else {
                $location = resolveSmartGeoLocation(($area_slug ?? $area_name) . ', ' . ($district_slug ?? $city_name));
            }
        } elseif (!empty($_GET['district']) && !empty($_GET['area'])) {
            $location = resolveSmartGeoLocation($_GET['area'] . ', ' . $_GET['district']);
        } elseif (!empty($area_slug) && !empty($district_slug)) {
            $location = resolveSmartGeoLocation($area_slug . ', ' . $district_slug);
        } elseif (preg_match('#^services/([a-z0-9-]+)/([a-z0-9-]+)/#i', $cleanUri, $m)) {
            $location = resolveSmartGeoLocation($m[2] . ', ' . $m[1]);
        } elseif (preg_match('#^services/([a-z0-9-]+)/?$#i', $cleanUri, $m)) {
            $location = resolveSmartGeoLocation($m[1]);
        } elseif (!empty($_GET['area'])) {
            $location = resolveSmartGeoLocation($_GET['area'], 'Hyderabad, Telangana (All Areas & Cyberabad)');
        } elseif (!empty($area_slug)) {
            $location = resolveSmartGeoLocation($area_slug, 'Hyderabad, Telangana (All Areas & Cyberabad)');
        } elseif (!empty($area_name)) {
            $location = resolveSmartGeoLocation($area_name, 'Hyderabad, Telangana (All Areas & Cyberabad)');
        } elseif (preg_match('/-in-([a-z0-9-]+)/', $cleanUri, $m)) {
            $location = resolveSmartGeoLocation($m[1], 'Hyderabad, Telangana (All Areas & Cyberabad)');
        }
    }

    if (empty($location)) {
        $checkLoc = strtolower(($title ?? '') . ' ' . $cleanUri . ' ' . $script);
        $location = resolveSmartGeoLocation($checkLoc, 'Hyderabad, Telangana (Pan-India Wholesale & Retail Supply)');
    }

    // 3. Determine Pricing / Prompt Text
    $searchKey = strtolower($service . ' ' . $cleanUri . ' ' . $script);
    if (strpos($searchKey, 'hanger') !== false || strpos($searchKey, 'drying') !== false) {
        $pricingText = 'Please share pricing per piece / set, model options, technical specifications, and installation availability.';
    } elseif (strpos($searchKey, 'spike') !== false) {
        $pricingText = 'Please share pricing per piece / per strip, technical specifications, and installation availability.';
    } elseif (strpos($searchKey, 'box cricket') !== false || strpos($searchKey, 'turf') !== false) {
        $pricingText = 'Please share turnkey court setup cost / pricing per sq.ft, technical specifications, and installation availability.';
    } else {
        $pricingText = 'Please share pricing per sq.ft, warranty details, and same-day installation availability.';
    }

    // 4. Build Full Canonical URL Reference
    $host = $_SERVER['HTTP_HOST'] ?? 'www.netsdial.com';
    $pageUrl = 'https://' . $host . '/' . ltrim($uri, '/');

    return [
        'service'      => $service,
        'location'     => $location,
        'page_url'     => $pageUrl,
        'website'      => 'www.netsdial.com',
        'company'      => 'NetsDial',
        'pricing_text' => $pricingText
    ];
}
}

if (!function_exists('getGcmPageContext')) {
function getGcmPageContext($customService = null, $customLocation = null) {
    return getNetsdialPageContext($customService, $customLocation);
}
}

if (!function_exists('getNetsdialWhatsAppUrl')) {
function getNetsdialWhatsAppUrl($customService = null, $customLocation = null, $phone = '919966499144') {
    $ctx = getNetsdialPageContext($customService, $customLocation);

    $msg = "Hi " . $ctx['company'] . ", I would like to inquire about *" . $ctx['service'] . "* in *" . $ctx['location'] . "*.

"
         . "• Service: " . $ctx['service'] . "
"
         . "• Location: " . $ctx['location'] . "
"
         . "• Page: " . $ctx['page_url'] . "
"
         . "• Website: " . $ctx['website'] . "

"
         . $ctx['pricing_text'];

    return "https://wa.me/" . $phone . "?text=" . rawurlencode($msg);
}
}

if (!function_exists('getGcmWhatsAppUrl')) {
function getGcmWhatsAppUrl($customService = null, $customLocation = null, $phone = '919966499144') {
    return getNetsdialWhatsAppUrl($customService, $customLocation, $phone);
}
}
