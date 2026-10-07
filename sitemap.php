<?php
/**
 * ============================================================================
 * NETSDIAL — MASTER XML SITEMAP ENGINE (5,250,000+ FEASIBLE URLs)
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

// Check if requested a specific sitemap page (e.g. sitemap-1.xml or ?page=1)
if (isset($_GET["page"])) {
    $page = max(1, min($TOTAL_SITEMAPS, intval($_GET["page"])));
    
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

    $start_offset = ($page - 1) * $URLS_PER_SITEMAP;
    $end_offset   = $start_offset + $URLS_PER_SITEMAP;
    $cursor = 0;

    // Generator 1: Hyderabad Local
    foreach ($hyd_areas as $loc_slug => $loc_name) {
        foreach ($hyd_services as $svc) {
            foreach (FeasibleLocationServiceSystem::$INTENTS_HYDERABAD as $intent) {
                $cursor++;
                if ($cursor > $start_offset && $cursor <= $end_offset) {
                    echo "  <url><loc>{$base}/{$svc}-{$intent}-in-{$loc_slug}</loc><lastmod>{$today}</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>\n";
                }
                if ($cursor > $end_offset) break 3;
            }
        }
    }

    // Generator 2: TS & AP
    if ($cursor <= $end_offset) {
        foreach ($ts_ap_areas as $loc_slug => $loc_name) {
            foreach ($tsap_services as $svc) {
                foreach (FeasibleLocationServiceSystem::$INTENTS_TS_AP as $intent) {
                    $cursor++;
                    if ($cursor > $start_offset && $cursor <= $end_offset) {
                        echo "  <url><loc>{$base}/{$svc}-{$intent}-in-{$loc_slug}</loc><lastmod>{$today}</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>\n";
                    }
                    if ($cursor > $end_offset) break 3;
                }
            }
        }
    }

    // Generator 3: 500 KM Radius
    if ($cursor <= $end_offset) {
        foreach ($radius_500_areas as $loc_slug => $loc_name) {
            foreach ($r500_services as $svc) {
                foreach (FeasibleLocationServiceSystem::$INTENTS_500KM as $intent) {
                    $cursor++;
                    if ($cursor > $start_offset && $cursor <= $end_offset) {
                        echo "  <url><loc>{$base}/{$svc}-{$intent}-in-{$loc_slug}</loc><lastmod>{$today}</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>\n";
                    }
                    if ($cursor > $end_offset) break 3;
                }
            }
        }
    }

    // Generator 4: PAN India Supply
    if ($cursor <= $end_offset) {
        foreach ($pan_india_areas as $loc_slug => $loc_name) {
            foreach ($pan_services as $svc) {
                foreach (FeasibleLocationServiceSystem::$INTENTS_PAN_INDIA as $intent) {
                    $cursor++;
                    if ($cursor > $start_offset && $cursor <= $end_offset) {
                        echo "  <url><loc>{$base}/{$svc}-{$intent}-in-{$loc_slug}</loc><lastmod>{$today}</lastmod><changefreq>weekly</changefreq><priority>0.7</priority></url>\n";
                    }
                    if ($cursor > $end_offset) break 3;
                }
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
