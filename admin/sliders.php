<?php
define('NETSDIAL', true);
require_once dirname(__DIR__) . '/config/config.php';
requireAdmin();
$admin_page_title = 'Slider Management';

if (isset($_GET['delete'])) {
    $s = db()->fetchOne("SELECT image FROM sliders WHERE id=?",[(int)$_GET['delete']]);
    if ($s && $s['image']) @unlink(dirname(__DIR__).'/'.$s['image']);
    db()->execute("DELETE FROM sliders WHERE id=?",([(int)$_GET['delete']]));
    redirect('/admin/sliders.php?msg=Slide+deleted');
}
if (isset($_GET['toggle'])) {
    $cur = db()->fetchOne("SELECT is_active FROM sliders WHERE id=?",[(int)$_GET['toggle']]);
    db()->execute("UPDATE sliders SET is_active=? WHERE id=?",[$cur['is_active']?0:1,(int)$_GET['toggle']]);
    redirect('/admin/sliders.php?msg=Slide+toggled');
}

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $img = '';
    if (!empty($_FILES['image']['name'])) {
        $ext  = strtolower(pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION));
        $name = 'slide-'.time().'.'.$ext;
        $dest = dirname(__DIR__).'/uploads/sliders/'.$name;
        if (move_uploaded_file($_FILES['image']['tmp_name'],$dest)) $img='uploads/sliders/'.$name;
    }
    if ($_POST['sid']) {
        $old = db()->fetchOne("SELECT image FROM sliders WHERE id=?",[(int)$_POST['sid']]);
        if (!$img) $img = $old['image']??'';
        db()->execute("UPDATE sliders SET title=?,subtitle=?,button_text=?,button_link=?,image=?,sort_order=?,is_active=? WHERE id=?",
            [cleanInput($_POST['title']),cleanInput($_POST['subtitle']),cleanInput($_POST['button_text']),cleanInput($_POST['button_link']),
             $img,(int)$_POST['sort_order'],isset($_POST['is_active'])?1:0,(int)$_POST['sid']]);
    } else {
        db()->insert("INSERT INTO sliders (title,subtitle,button_text,button_link,image,sort_order,is_active) VALUES (?,?,?,?,?,?,?)",
            [cleanInput($_POST['title']),cleanInput($_POST['subtitle']),cleanInput($_POST['button_text']),cleanInput($_POST['button_link']),
             $img,(int)$_POST['sort_order'],isset($_POST['is_active'])?1:0]);
    }
    redirect('/admin/sliders.php?msg=Slide+saved');
}

$sliders = db()->fetchAll("SELECT * FROM sliders ORDER BY sort_order ASC");
$edit_s  = null;
if (isset($_GET['edit'])) $edit_s = db()->fetchOne("SELECT * FROM sliders WHERE id=?",[(int)$_GET['edit']]);
include __DIR__ . '/includes/admin-header.php';
?>
<?php if (isset($_GET['msg'])): ?><div class="admin-alert admin-alert-success" data-auto-dismiss><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars(urldecode($_GET['msg'])); ?></div><?php endif; ?>

<div class="admin-card mb-24">
  <div class="admin-card-header"><div class="admin-card-title"><i class="fas fa-<?php echo $edit_s?'edit':'plus'; ?>"></i> <?php echo $edit_s?'Edit Slide':'Add New Slide'; ?></div></div>
  <div class="admin-card-body">
    <form method="POST" enctype="multipart/form-data">
      <input type="hidden" name="sid" value="<?php echo $edit_s['id']??0; ?>">
      <div class="admin-form-row">
        <div class="admin-form-group" style="flex:2"><label>Slide Title *</label><input type="text" name="title" class="admin-form-control" required value="<?php echo htmlspecialchars($edit_s['title']??''); ?>" placeholder="e.g. Premium Pigeon Nets | Russe™ Branded"></div>
        <div class="admin-form-group"><label>Sort Order</label><input type="number" name="sort_order" class="admin-form-control" value="<?php echo $edit_s['sort_order']??0; ?>" min="0"></div>
      </div>
      <div class="admin-form-group"><label>Subtitle</label><input type="text" name="subtitle" class="admin-form-control" value="<?php echo htmlspecialchars($edit_s['subtitle']??''); ?>" placeholder="e.g. Wholesale Suppliers | All India Delivery"></div>
      <div class="admin-form-row">
        <div class="admin-form-group"><label>Button Text</label><input type="text" name="button_text" class="admin-form-control" value="<?php echo htmlspecialchars($edit_s['button_text']??'Get Free Quote'); ?>"></div>
        <div class="admin-form-group"><label>Button Link</label><input type="text" name="button_link" class="admin-form-control" value="<?php echo htmlspecialchars($edit_s['button_link']??'/contact'); ?>" placeholder="/contact or full URL"></div>
      </div>
      <div class="admin-form-row">
        <div class="admin-form-group">
          <label>Slide Background Image (16:9 recommended)</label>
          <?php if (!empty($edit_s['image'])): ?><img src="/<?php echo htmlspecialchars($edit_s['image']); ?>" style="height:80px;object-fit:cover;border-radius:var(--radius);margin-bottom:8px;display:block;aspect-ratio:16/9;width:auto"><?php endif; ?>
          <input type="file" name="image" class="admin-form-control" accept="image/*">
          <div class="form-hint">Best size: 1920×1080px (16:9). PNG or JPG.</div>
        </div>
        <div class="admin-form-group" style="display:flex;align-items:center;padding-top:24px">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer"><input type="checkbox" name="is_active" <?php echo !empty($edit_s)?($edit_s['is_active']?'checked':''):'checked'; ?>> Active Slide</label>
        </div>
      </div>
      <div style="display:flex;gap:12px">
        <button type="submit" class="btn-admin btn-admin-primary"><i class="fas fa-save"></i> Save Slide</button>
        <?php if ($edit_s): ?><a href="sliders.php" class="btn-admin btn-admin-secondary">Cancel Edit</a><?php endif; ?>
      </div>
    </form>
  </div>
</div>

<div class="admin-card">
  <div class="admin-card-header"><div class="admin-card-title"><i class="fas fa-images"></i> All Slides (<?php echo count($sliders); ?>/6 recommended)</div></div>
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:16px;padding:16px">
    <?php foreach ($sliders as $sl): ?>
    <div style="border:2px solid var(--border);border-radius:var(--radius-lg);overflow:hidden;background:#fff;position:relative">
      <div style="position:relative;aspect-ratio:16/9;background:#111;overflow:hidden">
        <?php if ($sl['image']): ?>
        <img src="/<?php echo htmlspecialchars($sl['image']); ?>" style="width:100%;height:100%;object-fit:cover;opacity:.8">
        <?php else: ?>
        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:2rem"><i class="fas fa-image"></i></div>
        <?php endif; ?>
        <div style="position:absolute;inset:0;background:linear-gradient(to bottom,transparent 40%,rgba(0,0,0,.8));display:flex;flex-direction:column;justify-content:flex-end;padding:14px">
          <div style="color:#FF6B00;font-weight:700;font-size:.85rem"><?php echo htmlspecialchars($sl['title']); ?></div>
          <div style="color:#fff;font-size:.75rem;margin-top:4px;opacity:.9"><?php echo htmlspecialchars($sl['subtitle']?:''); ?></div>
        </div>
        <div style="position:absolute;top:8px;right:8px"><span class="status-badge <?php echo $sl['is_active']?'badge-success':'badge-dark'; ?>" style="font-size:.65rem"><?php echo $sl['is_active']?'Active':'Hidden'; ?></span></div>
        <div style="position:absolute;top:8px;left:8px"><span class="status-badge badge-info" style="font-size:.65rem">#<?php echo $sl['sort_order']; ?></span></div>
      </div>
      <div style="padding:12px;display:flex;gap:8px">
        <a href="?edit=<?php echo $sl['id']; ?>" class="btn-admin btn-admin-info btn-admin-sm"><i class="fas fa-edit"></i> Edit</a>
        <a href="?toggle=<?php echo $sl['id']; ?>" class="btn-admin btn-admin-secondary btn-admin-sm"><i class="fas fa-eye<?php echo $sl['is_active']?'':'-slash'; ?>"></i></a>
        <a href="?delete=<?php echo $sl['id']; ?>" class="btn-admin btn-admin-danger btn-admin-sm" data-confirm="Delete this slide?"><i class="fas fa-trash"></i></a>
      </div>
    </div>
    <?php endforeach; ?>
    <?php if (empty($sliders)): ?><div style="grid-column:1/-1;text-align:center;padding:40px;color:var(--text-light)">No slides yet. Add your first slide above.</div><?php endif; ?>
  </div>
</div>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
