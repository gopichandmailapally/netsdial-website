<?php
/**
 * ============================================================================
 * NETSDIAL — HIGH PERFORMANCE O(1) XML SITEMAP ENGINE (5,254,116 URLs)
 * ============================================================================
 * Strict Business & Geo-Scope Compliance: "Feasible Location Service System"
 *  1. Hyderabad Local (Cloth Hangers & Residential Balconies): 52,884 URLs
 *  2. TS & AP (Invisible Grills 100% Locations): 535,296 URLs
 *  3. 500 KM Radius (Box Cricket & Commercial High-Rise): 604,800 URLs
 *  4. PAN India (Construction Safety, Russea HDPE Wholesale): 4,061,136 URLs
 *  TOTAL FEASIBLE URLS: Exactly 5,254,116 URLs across 132 chunked sitemaps
 * ============================================================================
 */

// Disable session headers for pristine crawler caching
ini_set("session.use_cookies", 0);
header_remove("Set-Cookie");
header_remove("Pragma");
header_remove("Expires");

header("Content-Type: application/xml; charset=UTF-8");
header("Cache-Control: public, max-age=86400");
header("X-Robots-Tag: noindex, follow");

require_once __DIR__ . "/includes/feasible_location_service_system.php";

$base  = "https://netsdial.com";
$today = date("Y-m-d");

$URLS_PER_SITEMAP = 40000;
$TOTAL_SITEMAPS   = 132;

// Robust page detection from query string OR request URI (/sitemap-42.xml)
$page = null;
if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
    $page = intval($_GET["page"]);
} elseif (preg_match('/sitemap-(\d+)\.xml/i', $_SERVER["REQUEST_URI"] ?? "", $m)) {
    $page = intval($m[1]);
}

// ── SUB-SITEMAP (sitemap-1.xml through sitemap-132.xml) ─────────────────────
if ($page !== null && $page >= 1) {
    $page = min($TOTAL_SITEMAPS, max(1, $page));

    // Load Taxonomy
    $geo_file = __DIR__ . "/includes/geo_taxonomy.json";
    $geo = file_exists($geo_file) ? json_decode(file_get_contents($geo_file), true) : ["districts" => [], "areas" => []];
    $districts = $geo["districts"] ?? [];
    $areas = $geo["areas"] ?? [];

    $hyd_areas = [];
    $ts_ap_areas = [];
    $radius_500_areas = [];
    $pan_india_areas = [];

    foreach ($areas as $slug => $name) {
        $pan_india_areas[$slug] = $name;
        $full = strtolower($name);
        if (stripos($full, "telangana") !== false || stripos($full, "hyderabad") !== false) {
            if (stripos($full, "hyderabad") !== false || stripos($full, "ranga reddy") !== false || stripos($full, "medchal") !== false || stripos($full, "kukatpally") !== false || stripos($full, "gachibowli") !== false) {
                $hyd_areas[$slug] = $name;
            }
            $ts_ap_areas[$slug] = $name;
            $radius_500_areas[$slug] = $name;
        } elseif (stripos($full, "andhra pradesh") !== false) {
            $ts_ap_areas[$slug] = $name;
            $radius_500_areas[$slug] = $name;
        } elseif (stripos($full, "karnataka") !== false || stripos($full, "maharashtra") !== false) {
            $radius_500_areas[$slug] = $name;
        }
    }
    foreach ($districts as $slug => $name) {
        if (!isset($pan_india_areas[$slug])) {
            $pan_india_areas[$slug] = $name;
        }
    }

    $hyd_keys   = array_keys($hyd_areas);
    $tsap_keys  = array_keys($ts_ap_areas);
    $r500_keys  = array_keys($radius_500_areas);
    $pan_keys   = array_keys($pan_india_areas);

    $pan_services  = array_values(array_keys(array_filter(FeasibleLocationServiceSystem::$SERVICES, fn($s) => $s["scope"] === FeasibleLocationServiceSystem::SCOPE_PAN_INDIA)));
    $r500_services = array_values(array_keys(array_filter(FeasibleLocationServiceSystem::$SERVICES, fn($s) => $s["scope"] === FeasibleLocationServiceSystem::SCOPE_RADIUS_500KM)));
    $tsap_services = array_values(array_keys(array_filter(FeasibleLocationServiceSystem::$SERVICES, fn($s) => $s["scope"] === FeasibleLocationServiceSystem::SCOPE_TS_AP_ONLY)));
    $hyd_services  = array_values(array_keys(array_filter(FeasibleLocationServiceSystem::$SERVICES, fn($s) => $s["scope"] === FeasibleLocationServiceSystem::SCOPE_HYDERABAD_ONLY)));

    $hyd_intents  = FeasibleLocationServiceSystem::$INTENTS_HYDERABAD;
    $tsap_intents = FeasibleLocationServiceSystem::$INTENTS_TS_AP;
    $r500_intents = FeasibleLocationServiceSystem::$INTENTS_500KM;
    $pan_intents  = FeasibleLocationServiceSystem::$INTENTS_PAN_INDIA;

    $c1 = count($hyd_keys) * count($hyd_services) * count($hyd_intents);         // 52,884
    $c2 = count($tsap_keys) * count($tsap_services) * count($tsap_intents);     // 535,296
    $c3 = count($r500_keys) * count($r500_services) * count($r500_intents);     // 604,800
    $c4 = count($pan_keys) * count($pan_services) * count($pan_intents);         // 4,061,136
    $total_urls = $c1 + $c2 + $c3 + $c4;                                        // 5,254,116

    $start = ($page - 1) * $URLS_PER_SITEMAP;
    $end   = min($total_urls, $start + $URLS_PER_SITEMAP);

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

    if ($page === 1) {
        $main_pages = [
            "/"                  => ["1.0", "daily"],
            "/about.php"         => ["0.9", "weekly"],
            "/about-netsdial.php"=> ["0.9", "weekly"],
            "/faq.php"           => ["0.8", "weekly"],
            "/estimation.php"    => ["0.9", "weekly"],
            "/gallery.php"       => ["0.7", "weekly"],
            "/videos.php"        => ["0.7", "weekly"],
            "/reviews.php"       => ["0.8", "weekly"],
            "/blogs.php"         => ["0.8", "daily"],
            "/contact.php"       => ["0.9", "weekly"],
            "/services.php"      => ["0.9", "weekly"],
            "/llms.txt"          => ["0.5", "monthly"]
        ];
        foreach ($main_pages as $p => [$pri, $cf]) {
            echo "  <url><loc>" . htmlspecialchars($base . $p) . "</loc><lastmod>{$today}</lastmod><changefreq>{$cf}</changefreq><priority>{$pri}</priority></url>\n";
        }
    }

    $SI_hyd  = count($hyd_services) * count($hyd_intents);
    $I_hyd   = count($hyd_intents);

    $SI_tsap = count($tsap_services) * count($tsap_intents);
    $I_tsap  = count($tsap_intents);

    $SI_r500 = count($r500_services) * count($r500_intents);
    $I_r500  = count($r500_intents);

    $SI_pan  = count($pan_services) * count($pan_intents);
    $I_pan   = count($pan_intents);

    // O(1) Direct Mathematical Generator Loop
    for ($g = $start; $g < $end; $g++) {
        $idx = $g;
        if ($idx < $c1) {
            $loc_idx    = intdiv($idx, $SI_hyd);
            $rem        = $idx % $SI_hyd;
            $svc_idx    = intdiv($rem, $I_hyd);
            $int_idx    = $rem % $I_hyd;
            $loc = $hyd_keys[$loc_idx];
            $svc = $hyd_services[$svc_idx];
            $int = $hyd_intents[$int_idx];
            $pri = "0.8";
        } else {
            $idx -= $c1;
            if ($idx < $c2) {
                $loc_idx    = intdiv($idx, $SI_tsap);
                $rem        = $idx % $SI_tsap;
                $svc_idx    = intdiv($rem, $I_tsap);
                $int_idx    = $rem % $I_tsap;
                $loc = $tsap_keys[$loc_idx];
                $svc = $tsap_services[$svc_idx];
                $int = $tsap_intents[$int_idx];
                $pri = "0.8";
            } else {
                $idx -= $c2;
                if ($idx < $c3) {
                    $loc_idx    = intdiv($idx, $SI_r500);
                    $rem        = $idx % $SI_r500;
                    $svc_idx    = intdiv($rem, $I_r500);
                    $int_idx    = $rem % $I_r500;
                    $loc = $r500_keys[$loc_idx];
                    $svc = $r500_services[$svc_idx];
                    $int = $r500_intents[$int_idx];
                    $pri = "0.8";
                } else {
                    $idx -= $c3;
                    $loc_idx    = intdiv($idx, $SI_pan);
                    $rem        = $idx % $SI_pan;
                    $svc_idx    = intdiv($rem, $I_pan);
                    $int_idx    = $rem % $I_pan;
                    $loc = $pan_keys[$loc_idx];
                    $svc = $pan_services[$svc_idx];
                    $int = $pan_intents[$int_idx];
                    $pri = "0.7";
                }
            }
        }
        echo "  <url><loc>{$base}/{$svc}-{$int}-in-{$loc}</loc><lastmod>{$today}</lastmod><changefreq>weekly</changefreq><priority>{$pri}</priority></url>\n";
    }

    echo "</urlset>\n";
    exit;
}

// ── MASTER SITEMAP INDEX (https://netsdial.com/sitemap.xml) ─────────────────
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
echo "<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
for ($i = 1; $i <= $TOTAL_SITEMAPS; $i++) {
    echo "  <sitemap>\n";
    echo "    <loc>" . htmlspecialchars($base . "/sitemap-{$i}.xml") . "</loc>\n";
    echo "    <lastmod>{$today}</lastmod>\n";
    echo "  </sitemap>\n";
}
echo "</sitemapindex>\n";
