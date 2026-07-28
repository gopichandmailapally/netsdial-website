<?php
define('NETSDIAL', true);
require_once dirname(__DIR__) . '/config/config.php';
requireAdmin();
$admin_page_title = 'Video Management';

if (isset($_GET['delete'])) {
    db()->execute("DELETE FROM videos WHERE id=?",[(int)$_GET['delete']]);
    redirect('/admin/videos.php?msg=Video+deleted');
}
if (isset($_GET['toggle'])) {
    $cur = db()->fetchOne("SELECT is_active FROM videos WHERE id=?",[(int)$_GET['toggle']]);
    db()->execute("UPDATE videos SET is_active=? WHERE id=?",[$cur['is_active']?0:1,(int)$_GET['toggle']]);
    redirect('/admin/videos.php?msg=Toggled');
}
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $yt = cleanInput($_POST['video_url']);
    if ($_POST['vid']) {
        db()->execute("UPDATE videos SET title=?,description=?,video_url=?,sort_order=?,is_active=? WHERE id=?",
            [cleanInput($_POST['title']),cleanInput($_POST['description']),$yt,(int)$_POST['sort_order'],isset($_POST['is_active'])?1:0,(int)$_POST['vid']]);
    } else {
        db()->insert("INSERT INTO videos (title,description,video_url,sort_order,is_active) VALUES (?,?,?,?,?)",
            [cleanInput($_POST['title']),cleanInput($_POST['description']),$yt,(int)$_POST['sort_order'],isset($_POST['is_active'])?1:0]);
    }
    redirect('/admin/videos.php?msg=Video+saved');
}

$videos = db()->fetchAll("SELECT * FROM videos ORDER BY sort_order ASC, id DESC");
$edit_v = null;
if (isset($_GET['edit'])) $edit_v = db()->fetchOne("SELECT * FROM videos WHERE id=?",[(int)$_GET['edit']]);
include __DIR__ . '/includes/admin-header.php';
?>
<?php if (isset($_GET['msg'])): ?><div class="admin-alert admin-alert-success" data-auto-dismiss><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars(urldecode($_GET['msg'])); ?></div><?php endif; ?>

<div class="admin-card mb-24">
  <div class="admin-card-header"><div class="admin-card-title"><i class="fab fa-youtube"></i> <?php echo $edit_v?'Edit Video':'Add New Video'; ?></div></div>
  <div class="admin-card-body">
    <form method="POST">
      <input type="hidden" name="vid" value="<?php echo $edit_v['id']??0; ?>">
      <div class="admin-form-row">
        <div class="admin-form-group" style="flex:2"><label>Video Title *</label><input type="text" name="title" class="admin-form-control" required value="<?php echo htmlspecialchars($edit_v['title']??''); ?>"></div>
        <div class="admin-form-group"><label>Sort Order</label><input type="number" name="sort_order" class="admin-form-control" value="<?php echo $edit_v['sort_order']??0; ?>" min="0"></div>
      </div>
      <div class="admin-form-group"><label>YouTube URL or Video URL *</label><input type="url" name="video_url" class="admin-form-control" required value="<?php echo htmlspecialchars($edit_v['video_url']??''); ?>" placeholder="https://www.youtube.com/watch?v=..."></div>
      <div class="admin-form-group"><label>Description</label><textarea name="description" class="admin-form-control" rows="3"><?php echo htmlspecialchars($edit_v['description']??''); ?></textarea></div>
      <label style="display:flex;align-items:center;gap:8px;margin-bottom:16px;cursor:pointer"><input type="checkbox" name="is_active" <?php echo !empty($edit_v)?($edit_v['is_active']?'checked':''):'checked'; ?>> Active</label>
      <button type="submit" class="btn-admin btn-admin-primary"><i class="fas fa-save"></i> Save Video</button>
      <?php if ($edit_v): ?><a href="videos.php" class="btn-admin btn-admin-secondary" style="margin-left:12px">Cancel</a><?php endif; ?>
    </form>
  </div>
</div>

<div class="admin-card">
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead><tr><th>Thumbnail</th><th>Title</th><th>URL</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        <?php foreach ($videos as $v):
        $yt_id = '';
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/',$v['video_url'],$m)) $yt_id=$m[1];
        ?>
        <tr>
          <td><?php if ($yt_id): ?><img src="https://img.youtube.com/vi/<?php echo $yt_id; ?>/default.jpg" style="width:80px;height:45px;object-fit:cover;border-radius:6px"><?php else: ?><div style="width:80px;height:45px;background:#111;border-radius:6px;display:flex;align-items:center;justify-content:center"><i class="fab fa-youtube" style="color:#FF0000"></i></div><?php endif; ?></td>
          <td><strong><?php echo htmlspecialchars($v['title']); ?></strong><br><span style="font-size:.75rem;color:var(--text-lighter)"><?php echo htmlspecialchars(substr($v['description']?:'',0,60)); ?></span></td>
          <td style="font-size:.8rem;max-width:200px;overflow:hidden;text-overflow:ellipsis"><a href="<?php echo htmlspecialchars($v['video_url']); ?>" target="_blank" style="color:var(--primary)"><?php echo htmlspecialchars(substr($v['video_url'],0,40)); ?>...</a></td>
          <td><span class="status-badge <?php echo $v['is_active']?'badge-success':'badge-dark'; ?>"><?php echo $v['is_active']?'Active':'Hidden'; ?></span></td>
          <td>
            <div class="actions">
              <a href="?edit=<?php echo $v['id']; ?>" class="btn-admin btn-admin-info btn-admin-icon"><i class="fas fa-edit"></i></a>
              <a href="?toggle=<?php echo $v['id']; ?>" class="btn-admin btn-admin-secondary btn-admin-icon"><i class="fas fa-eye<?php echo $v['is_active']?'':'-slash'; ?>"></i></a>
              <a href="?delete=<?php echo $v['id']; ?>" class="btn-admin btn-admin-danger btn-admin-icon" data-confirm="Delete?"><i class="fas fa-trash"></i></a>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($videos)): ?><tr><td colspan="5" style="text-align:center;padding:30px;color:var(--text-light)">No videos yet.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
