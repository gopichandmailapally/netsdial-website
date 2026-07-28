<?php
define('NETSDIAL', true);
require_once dirname(__DIR__) . '/config/config.php';
requireAdmin();
$admin_page_title = 'Site Settings';

// Save settings
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $group = cleanInput($_POST['group'] ?? 'general');
    $keys  = $_POST['keys'] ?? [];
    $vals  = $_POST['vals'] ?? [];
    foreach ($keys as $i => $key) {
        $val = $vals[$i] ?? '';
        // Handle file upload for logo/favicon
        if (in_array($key, ['logo_path','favicon_path','footer_logo_path']) && !empty($_FILES[$key]['name'])) {
            $ext  = strtolower(pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION));
            $dest = dirname(__DIR__) . '/uploads/logos/' . $key . '.' . $ext;
            if (move_uploaded_file($_FILES[$key]['tmp_name'], $dest)) {
                $val = 'uploads/logos/' . $key . '.' . $ext;
            }
        }
        db()->execute("INSERT INTO settings (setting_key,setting_value,setting_group) VALUES (?,?,?) ON DUPLICATE KEY UPDATE setting_value=?, setting_group=?", [$key, $val, $group, $val, $group]);
    }
    redirect('/admin/settings.php?group=' . $group . '&msg=Settings+saved');
}

$group = cleanInput($_GET['group'] ?? 'general');
$settings_all = db()->fetchAll("SELECT * FROM settings ORDER BY setting_group, setting_key");
$settings_map = [];
foreach ($settings_all as $s) $settings_map[$s['setting_key']] = $s['setting_value'];

function s($key, $default='') { global $settings_map; return $settings_map[$key] ?? $default; }

$groups = [
  'general' => ['icon'=>'fa-cog', 'label'=>'General'],
  'seo'     => ['icon'=>'fa-search', 'label'=>'SEO Settings'],
  'email'   => ['icon'=>'fa-envelope', 'label'=>'Email / SMTP'],
  'social'  => ['icon'=>'fa-share-alt', 'label'=>'Social Media'],
];

include __DIR__ . '/includes/admin-header.php';
?>

<?php if (isset($_GET['msg'])): ?>
<div class="admin-alert admin-alert-success" data-auto-dismiss><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars(urldecode($_GET['msg'])); ?></div>
<?php endif; ?>

<div style="display:flex;gap:12px;margin-bottom:24px;flex-wrap:wrap">
  <?php foreach ($groups as $gk => $gv): ?>
  <a href="?group=<?php echo $gk; ?>" class="btn-admin <?php echo $group===$gk ? 'btn-admin-primary':'btn-admin-secondary'; ?>"><i class="fas <?php echo $gv['icon']; ?>"></i> <?php echo $gv['label']; ?></a>
  <?php endforeach; ?>
</div>

<div class="admin-card">
  <div class="admin-card-header">
    <div class="admin-card-title"><i class="fas <?php echo $groups[$group]['icon'] ?? 'fa-cog'; ?>"></i> <?php echo $groups[$group]['label'] ?? 'Settings'; ?></div>
  </div>
  <div class="admin-card-body">
    <form method="POST" enctype="multipart/form-data">
      <input type="hidden" name="group" value="<?php echo $group; ?>">

      <?php if ($group === 'general'): ?>
      <?php
      $fields = [
        ['site_name','Site Name','text'],['site_tagline','Site Tagline','text'],['site_url','Site URL','url'],
        ['site_phone','Phone Number','text'],['site_whatsapp','WhatsApp Number','text'],['site_email','Email Address','email'],
        ['site_address','Office Address','textarea'],['company_name','Company Name','text'],
        ['company_gstin','GSTIN Number','text'],['company_pan','PAN Number','text'],
        ['company_reg_no','Company Reg No','text'],['visitor_count_base','Visitor Base Count','number'],
        ['marquee_text','Marquee Text','textarea'],
        ['logo_path','Logo (PNG)','file-logo'],['favicon_path','Favicon (PNG)','file-logo'],['footer_logo_path','Footer Logo (PNG)','file-logo'],
      ];
      ?>
      <?php elseif ($group === 'seo'): ?>
      <?php
      $fields = [
        ['meta_title','Default Meta Title','text'],['meta_description','Default Meta Description','textarea'],
        ['meta_keywords','Default Meta Keywords','textarea'],
        ['google_analytics','Google Analytics Code','textarea'],['google_search_console','Search Console Verification','textarea'],
      ];
      ?>
      <?php elseif ($group === 'email'): ?>
      <?php
      $fields = [
        ['smtp_host','SMTP Host','text'],['smtp_port','SMTP Port','number'],
        ['smtp_user','SMTP Username','email'],['smtp_pass','SMTP Password','password'],['smtp_name','From Name','text'],
      ];
      ?>
      <?php elseif ($group === 'social'): ?>
      <?php
      $fields = [
        ['facebook_url','Facebook URL','url'],['instagram_url','Instagram URL','url'],
        ['youtube_url','YouTube URL','url'],['twitter_url','Twitter/X URL','url'],
      ];
      ?>
      <?php endif; ?>

      <?php foreach ($fields as $idx => $f): ?>
      <input type="hidden" name="keys[<?php echo $idx; ?>]" value="<?php echo $f[0]; ?>">
      <div class="admin-form-group">
        <label><?php echo $f[1]; ?></label>
        <?php if ($f[2] === 'textarea'): ?>
          <textarea name="vals[<?php echo $idx; ?>]" class="admin-form-control" rows="4"><?php echo htmlspecialchars(s($f[0])); ?></textarea>
        <?php elseif ($f[2] === 'file-logo'): ?>
          <div style="display:flex;gap:14px;align-items:center">
            <?php $cur = s($f[0]); ?>
            <?php if ($cur): ?><img src="/<?php echo htmlspecialchars($cur); ?>" style="height:50px;object-fit:contain;border:1px solid var(--border);border-radius:var(--radius);padding:4px" onerror="this.style.display='none'"><?php endif; ?>
            <input type="file" name="<?php echo $f[0]; ?>" class="admin-form-control" accept="image/png,image/jpeg" style="flex:1">
          </div>
          <div class="form-hint">Current path: <?php echo htmlspecialchars($cur ?: 'Not set'); ?></div>
          <input type="hidden" name="vals[<?php echo $idx; ?>]" value="<?php echo htmlspecialchars($cur); ?>">
        <?php elseif ($f[2] === 'password'): ?>
          <input type="password" name="vals[<?php echo $idx; ?>]" class="admin-form-control" placeholder="Leave blank to keep current" autocomplete="new-password">
        <?php else: ?>
          <input type="<?php echo $f[2]; ?>" name="vals[<?php echo $idx; ?>]" class="admin-form-control" value="<?php echo htmlspecialchars(s($f[0])); ?>">
        <?php endif; ?>
      </div>
      <?php endforeach; ?>

      <button type="submit" class="btn-admin btn-admin-primary btn-admin-lg"><i class="fas fa-save"></i> Save <?php echo $groups[$group]['label']; ?></button>
    </form>
  </div>
</div>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
