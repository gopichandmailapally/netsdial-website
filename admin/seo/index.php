<?php
define('NETSDIAL', true);
require_once dirname(dirname(__DIR__)) . '/config/config.php';
requireAdmin();
$admin_page_title = 'SEO Manager';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keys = ['meta_title','meta_description','meta_keywords','google_analytics','google_search_console'];
    foreach ($keys as $k) {
        $v = cleanInput($_POST[$k] ?? '');
        db()->execute("INSERT INTO settings (setting_key,setting_value,setting_group) VALUES (?,?,'seo') ON DUPLICATE KEY UPDATE setting_value=?", [$k,$v,$v]);
    }
    redirect('/admin/seo/?msg=SEO+settings+saved');
}

$meta_title           = getSetting('meta_title','');
$meta_description     = getSetting('meta_description','');
$meta_keywords        = getSetting('meta_keywords','');
$google_analytics     = getSetting('google_analytics','');
$google_search_console= getSetting('google_search_console','');

include dirname(__DIR__) . '/includes/admin-header.php';
?>
<?php if (isset($_GET['msg'])): ?><div class="admin-alert admin-alert-success" data-auto-dismiss><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars(urldecode($_GET['msg'])); ?></div><?php endif; ?>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:24px">
  <div>
    <div class="admin-card mb-24">
      <div class="admin-card-header"><div class="admin-card-title"><i class="fas fa-search"></i> Global SEO Settings</div></div>
      <div class="admin-card-body">
        <form method="POST">
          <div class="admin-form-group">
            <label>Default Meta Title <span style="font-size:.75rem;color:var(--text-lighter)">(60 chars ideal)</span></label>
            <input type="text" name="meta_title" class="admin-form-control" value="<?php echo htmlspecialchars($meta_title); ?>" id="metaTitle" oninput="updateSeoPreview()" placeholder="NetsDial - India's Largest Russe™ Net Wholesale Supplier | Hyderabad">
            <div style="font-size:.75rem;color:var(--text-lighter);margin-top:4px" id="titleCount">0/60 chars</div>
          </div>
          <div class="admin-form-group">
            <label>Default Meta Description <span style="font-size:.75rem;color:var(--text-lighter)">(155 chars ideal)</span></label>
            <textarea name="meta_description" class="admin-form-control" rows="3" id="metaDesc" oninput="updateSeoPreview()" placeholder="NetsDial supplies Russe™ branded HDPE pigeon nets, safety nets, cricket nets wholesale across India. Best prices, bulk orders, PAN India delivery."><?php echo htmlspecialchars($meta_description); ?></textarea>
            <div style="font-size:.75rem;color:var(--text-lighter);margin-top:4px" id="descCount">0/155 chars</div>
          </div>
          <div class="admin-form-group">
            <label>Default Meta Keywords</label>
            <textarea name="meta_keywords" class="admin-form-control" rows="3" placeholder="pigeon net hyderabad, safety nets supplier india, russe nets, cricket net wholesale..."><?php echo htmlspecialchars($meta_keywords); ?></textarea>
          </div>
          <div class="admin-form-group">
            <label>Google Analytics Code (GA4)</label>
            <textarea name="google_analytics" class="admin-form-control" rows="4" placeholder="<!-- Google tag (gtag.js) --> <script async src='...'> ..."></textarea>
          </div>
          <div class="admin-form-group">
            <label>Google Search Console Verification</label>
            <input type="text" name="google_search_console" class="admin-form-control" value="<?php echo htmlspecialchars($google_search_console); ?>" placeholder="google-site-verification=...">
          </div>
          <button type="submit" class="btn-admin btn-admin-primary btn-admin-lg"><i class="fas fa-save"></i> Save SEO Settings</button>
        </form>
      </div>
    </div>

    <!-- SERP Preview -->
    <div class="admin-card">
      <div class="admin-card-header"><div class="admin-card-title"><i class="fas fa-eye"></i> Google SERP Preview</div></div>
      <div class="admin-card-body">
        <div style="font-family:Arial,sans-serif;padding:16px;background:#fff;border-radius:10px;border:1px solid #e5e7eb">
          <div style="font-size:.75rem;color:#006621;margin-bottom:4px"><?php echo SITE_URL; ?></div>
          <div id="previewTitle" style="font-size:1.1rem;color:#1a0dab;font-weight:400;cursor:pointer;max-width:600px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?php echo htmlspecialchars($meta_title ?: 'NetsDial - Your Meta Title Here'); ?></div>
          <div id="previewDesc" style="font-size:.85rem;color:#545454;margin-top:4px;line-height:1.5;max-width:600px"><?php echo htmlspecialchars($meta_description ?: 'Your meta description will appear here. Write 155 characters to describe your page clearly to search engine users.'); ?></div>
        </div>
      </div>
    </div>
  </div>

  <!-- SEO Tips Sidebar -->
  <div>
    <div class="admin-card mb-24">
      <div class="admin-card-header"><div class="admin-card-title"><i class="fas fa-lightbulb" style="color:#F59E0B"></i> SEO Best Practices</div></div>
      <div class="admin-card-body">
        <?php
        $tips = [
          ['Target "Pigeon Net Hyderabad" as your #1 keyword — search volume is high.','high'],
          ['Include "Russe™" brand in meta titles for brand recognition.','medium'],
          ['Each service+area page should have unique, 300+ word content.','high'],
          ['Add alt text to all images with relevant keywords.','medium'],
          ['Get your Google Business Profile verified for Hyderabad.','high'],
          ['Build backlinks from local Hyderabad business directories.','medium'],
          ['Submit sitemap.php to Google Search Console.','high'],
          ['Add FAQ schema to all service pages for rich snippets.','medium'],
          ['Use "near me" variations in your content — high mobile searches.','high'],
          ['Page speed should be under 3 seconds — compress all images.','medium'],
        ];
        foreach ($tips as $t):
        ?>
        <div style="display:flex;gap:10px;margin-bottom:12px;padding-bottom:12px;border-bottom:1px solid var(--border);align-items:flex-start">
          <span style="color:<?php echo $t[1]==='high'?'#EF4444':'#F59E0B'; ?>;font-size:.7rem;margin-top:4px">●</span>
          <span style="font-size:.82rem;line-height:1.6;color:var(--text-medium)"><?php echo $t[0]; ?></span>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="admin-card">
      <div class="admin-card-header"><div class="admin-card-title"><i class="fas fa-map-marker-alt"></i> Quick Actions</div></div>
      <div class="admin-card-body">
        <a href="/sitemap.php" target="_blank" class="btn-admin btn-admin-primary" style="display:block;text-align:center;margin-bottom:10px"><i class="fas fa-sitemap"></i> View XML Sitemap</a>
        <a href="https://search.google.com/search-console" target="_blank" class="btn-admin btn-admin-secondary" style="display:block;text-align:center;margin-bottom:10px"><i class="fab fa-google"></i> Google Search Console</a>
        <a href="https://pagespeed.web.dev/" target="_blank" class="btn-admin btn-admin-secondary" style="display:block;text-align:center"><i class="fas fa-tachometer-alt"></i> Test Page Speed</a>
      </div>
    </div>
  </div>
</div>

<script>
function updateSeoPreview() {
  const t = document.getElementById('metaTitle').value;
  const d = document.getElementById('metaDesc').value;
  document.getElementById('previewTitle').textContent = t || 'Your Meta Title Here';
  document.getElementById('previewDesc').textContent  = d || 'Your meta description will appear here...';
  document.getElementById('titleCount').textContent = t.length + '/60 chars';
  document.getElementById('titleCount').style.color = t.length > 60 ? '#EF4444' : t.length > 50 ? '#10B981' : 'var(--text-lighter)';
  document.getElementById('descCount').textContent  = d.length + '/155 chars';
  document.getElementById('descCount').style.color  = d.length > 155 ? '#EF4444' : d.length > 130 ? '#10B981' : 'var(--text-lighter)';
}
updateSeoPreview();
</script>

<?php include dirname(__DIR__) . '/includes/admin-footer.php'; ?>
