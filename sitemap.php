<?php
define('NETSDIAL', true);
require_once __DIR__ . '/config/config.php';

header('Content-Type: application/xml; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";

$base = SITE_URL;
$today = date('Y-m-d');

$urls = [];

// Main pages
$main_pages = ['/', '/about.php', '/faq.php', '/estimation.php', '/gallery.php', '/videos.php', '/reviews.php', '/blogs.php', '/contact.php'];
foreach ($main_pages as $page) {
    $urls[] = ['loc' => $base . $page, 'priority' => '1.0', 'changefreq' => 'weekly'];
}

// Blog posts
$blogs = db()->fetchAll("SELECT slug, updated_at FROM blogs WHERE status='published'");
foreach ($blogs as $b) {
    $urls[] = ['loc' => $base . '/blog/' . $b['slug'], 'priority' => '0.7', 'changefreq' => 'monthly', 'lastmod' => date('Y-m-d', strtotime($b['updated_at']))];
}

// Service pages
$districts = db()->fetchAll("SELECT * FROM districts WHERE is_active=1 ORDER BY sort_order");
$keywords  = db()->fetchAll("SELECT * FROM service_keywords WHERE is_active=1 ORDER BY sort_order");

foreach ($districts as $d) {
    $areas = db()->fetchAll("SELECT * FROM areas WHERE district_id=? AND is_active=1", [(int)$d['id']]);
    foreach ($areas as $a) {
        foreach ($keywords as $k) {
            $url = $base . '/services/' . $d['slug'] . '/' . $a['slug'] . '/' . $k['slug'] . '/';
            $urls[] = ['loc' => $url, 'priority' => '0.8', 'changefreq' => 'monthly'];
        }
    }
}

?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($urls as $u): ?>
  <url>
    <loc><?php echo htmlspecialchars($u['loc']); ?></loc>
    <lastmod><?php echo $u['lastmod'] ?? $today; ?></lastmod>
    <changefreq><?php echo $u['changefreq']; ?></changefreq>
    <priority><?php echo $u['priority']; ?></priority>
  </url>
<?php endforeach; ?>
</urlset>
