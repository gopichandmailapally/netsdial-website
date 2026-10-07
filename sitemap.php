<?php
/**
 * ============================================================================
 * NETSDIAL — MASTER XML SITEMAP ENGINE (5,254,116 FEASIBLE URLs)
 * ============================================================================
 * Generates valid chunked XML sitemaps adhering strictly to:
 * "Feasible Location Service System"
 * ============================================================================
 */

// Disable PHP session headers for clean crawler caching
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

// Robust page detection from query string OR request URI
$page = null;
if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
    $page = intval($_GET["page"]);
} elseif (preg_match('/sitemap-(\d+)\.xml/i', $_SERVER["REQUEST_URI"] ?? "", $m)) {
    $page = intval($m[1]);
}

// If sub-sitemap requested (e.g. /sitemap-1.xml or ?page=1)
if ($page !== null && $page >= 1) {
    $page = min($TOTAL_SITEMAPS, $page);
    
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

    if ($page === 1) {
        // Output Core Static Pages
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

    $pan_services  = array_keys(array_filter(FeasibleLocationServiceSystem::$SERVICES, fn($s) => $s["scope"] === FeasibleLocationServiceSystem::SCOPE_PAN_INDIA));
    $r500_services = array_keys(array_filter(FeasibleLocationServiceSystem::$SERVICES, fn($s) => $s["scope"] === FeasibleLocationServiceSystem::SCOPE_RADIUS_500KM));
    $tsap_services = array_keys(array_filter(FeasibleLocationServiceSystem::$SERVICES, fn($s) => $s["scope"] === FeasibleLocationServiceSystem::SCOPE_TS_AP_ONLY));
    $hyd_services  = array_keys(array_filter(FeasibleLocationServiceSystem::$SERVICES, fn($s) => $s["scope"] === FeasibleLocationServiceSystem::SCOPE_HYDERABAD_ONLY));

    $start = ($page - 1) * $URLS_PER_SITEMAP;
    $end   = $start + $URLS_PER_SITEMAP;
    $idx   = 0;

    // Generator 1: Hyderabad Local
    foreach ($hyd_areas as $l => $n) {
        foreach ($hyd_services as $s) {
            foreach (FeasibleLocationServiceSystem::$INTENTS_HYDERABAD as $i) {
                if ($idx >= $start && $idx < $end) {
                    echo "  <url><loc>{$base}/{$s}-{$i}-in-{$l}</loc><lastmod>{$today}</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>\n";
                }
                $idx++;
                if ($idx >= $end) { echo "</urlset>\n"; exit; }
            }
        }
    }

    // Generator 2: TS & AP
    foreach ($ts_ap_areas as $l => $n) {
        foreach ($tsap_services as $s) {
            foreach (FeasibleLocationServiceSystem::$INTENTS_TS_AP as $i) {
                if ($idx >= $start && $idx < $end) {
                    echo "  <url><loc>{$base}/{$s}-{$i}-in-{$l}</loc><lastmod>{$today}</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>\n";
                }
                $idx++;
                if ($idx >= $end) { echo "</urlset>\n"; exit; }
            }
        }
    }

    // Generator 3: 500 KM Radius
    foreach ($radius_500_areas as $l => $n) {
        foreach ($r500_services as $s) {
            foreach (FeasibleLocationServiceSystem::$INTENTS_500KM as $i) {
                if ($idx >= $start && $idx < $end) {
                    echo "  <url><loc>{$base}/{$s}-{$i}-in-{$l}</loc><lastmod>{$today}</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>\n";
                }
                $idx++;
                if ($idx >= $end) { echo "</urlset>\n"; exit; }
            }
        }
    }

    // Generator 4: PAN India Supply
    foreach ($pan_india_areas as $l => $n) {
        foreach ($pan_services as $s) {
            foreach (FeasibleLocationServiceSystem::$INTENTS_PAN_INDIA as $i) {
                if ($idx >= $start && $idx < $end) {
                    echo "  <url><loc>{$base}/{$s}-{$i}-in-{$l}</loc><lastmod>{$today}</lastmod><changefreq>weekly</changefreq><priority>0.7</priority></url>\n";
                }
                $idx++;
                if ($idx >= $end) { echo "</urlset>\n"; exit; }
            }
        }
    }

    echo "</urlset>\n";
    exit;
}

// ── Default: Master Sitemap Index (Clean .xml paths for Google Search Console) ──────
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
echo "<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
for ($i = 1; $i <= $TOTAL_SITEMAPS; $i++) {
    echo "  <sitemap>\n";
    echo "    <loc>" . htmlspecialchars($base . "/sitemap-{$i}.xml") . "</loc>\n";
    echo "    <lastmod>{$today}</lastmod>\n";
    echo "  </sitemap>\n";
}
echo "</sitemapindex>\n";
