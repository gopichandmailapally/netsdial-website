<?php
define('NETSDIAL', true);
require_once __DIR__ . '/config/config.php';

$base  = SITE_URL;
$today = date('Y-m-d');

// ── Sitemap Index mode: /sitemap.php?index=1  ────────────────────
// ── Individual sitemap:  /sitemap.php?page=N  ────────────────────
// ── Default (no param):  return sitemap index ────────────────────

$URLS_PER_SITEMAP = 40000; // stay well under 50k Google limit

if (isset($_GET['page'])) {
    // ── Single paginated sitemap ──────────────────────────────────
    $page   = max(1, (int)$_GET['page']);
    $offset = ($page - 1) * $URLS_PER_SITEMAP;

    header('Content-Type: application/xml; charset=UTF-8');
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";

    $urls = [];

    if ($page === 1) {
        // Main pages on first sitemap
        foreach (['/', '/about.php', '/faq.php', '/estimation.php', '/gallery.php', '/videos.php', '/reviews.php', '/blogs.php', '/contact.php'] as $p) {
            $urls[] = ['loc' => $base . $p, 'pri' => '1.0', 'cf' => 'weekly'];
        }
        $blogs = db()->fetchAll("SELECT slug, updated_at FROM blogs WHERE status='published' ORDER BY updated_at DESC LIMIT 500");
        foreach ($blogs as $b) {
            $urls[] = ['loc' => $base . '/blog/' . $b['slug'], 'pri' => '0.7', 'cf' => 'monthly', 'lm' => date('Y-m-d', strtotime($b['updated_at']))];
        }
    }

    // Paginated service pages
    $sql = "SELECT d.slug as ds, a.slug as as2, k.slug as ks
            FROM areas a
            JOIN districts d ON a.district_id=d.id
            CROSS JOIN service_keywords k
            WHERE a.is_active=1 AND d.is_active=1 AND k.is_active=1
            ORDER BY d.id, a.id, k.id
            LIMIT ? OFFSET ?";
    $svcOffset = ($page === 1) ? max(0, $offset - 9) : $offset;
    $rows = db()->fetchAll($sql, [$URLS_PER_SITEMAP, $svcOffset]);
    foreach ($rows as $r) {
        $urls[] = ['loc' => $base . '/services/' . $r['ds'] . '/' . $r['as2'] . '/' . $r['ks'] . '/', 'pri' => '0.8', 'cf' => 'monthly'];
    }

    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ($urls as $u) {
        echo "  <url>\n";
        echo "    <loc>" . htmlspecialchars($u['loc']) . "</loc>\n";
        echo "    <lastmod>" . ($u['lm'] ?? $today) . "</lastmod>\n";
        echo "    <changefreq>" . $u['cf'] . "</changefreq>\n";
        echo "    <priority>" . $u['pri'] . "</priority>\n";
        echo "  </url>\n";
    }
    echo '</urlset>';
    exit;
}

// ── Sitemap Index ─────────────────────────────────────────────────
$total_services = db()->fetchOne("SELECT COUNT(*) as cnt FROM areas a JOIN districts d ON a.district_id=d.id CROSS JOIN service_keywords k WHERE a.is_active=1 AND d.is_active=1 AND k.is_active=1")['cnt'];
$total_urls     = $total_services + 520; // +main pages + blogs
$total_pages    = ceil($total_urls / $URLS_PER_SITEMAP);

header('Content-Type: application/xml; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
for ($i = 1; $i <= $total_pages; $i++) {
    echo "  <sitemap>\n";
    echo "    <loc>" . htmlspecialchars($base . "/sitemap.php?page=$i") . "</loc>\n";
    echo "    <lastmod>$today</lastmod>\n";
    echo "  </sitemap>\n";
}
echo '</sitemapindex>';
