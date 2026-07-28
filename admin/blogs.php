<?php
define('NETSDIAL', true);
require_once dirname(__DIR__) . '/config/config.php';
requireAdmin();
$admin_page_title = 'Blog Management';

if (isset($_GET['delete'])) {
    db()->execute("DELETE FROM blogs WHERE id=?", [(int)$_GET['delete']]);
    redirect('/admin/blogs.php?msg=Post+deleted');
}
if (isset($_GET['toggle'])) {
    $cur = db()->fetchOne("SELECT status FROM blogs WHERE id=?", [(int)$_GET['toggle']]);
    $new = ($cur['status'] ?? 'draft') === 'published' ? 'draft' : 'published';
    db()->execute("UPDATE blogs SET status=? WHERE id=?", [$new, (int)$_GET['toggle']]);
    redirect('/admin/blogs.php?msg=Status+updated');
}

$action = $_GET['action'] ?? 'list';
$edit_b = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $edit_b = db()->fetchOne("SELECT * FROM blogs WHERE id=?", [(int)$_GET['id']]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $slug = $_POST['slug'] ?: slugify($_POST['title']);
    $img  = '';
    if (!empty($_FILES['image']['name'])) {
        $ext  = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $name = slugify($_POST['title']) . '-' . time() . '.' . $ext;
        $dest = dirname(__DIR__) . '/uploads/blogs/' . $name;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $dest)) $img = 'uploads/blogs/' . $name;
    }

    if ($_POST['bid']) {
        $old = db()->fetchOne("SELECT image FROM blogs WHERE id=?", [(int)$_POST['bid']]);
        if (!$img) $img = $old['image'] ?? '';
        db()->execute(
            "UPDATE blogs SET title=?,slug=?,content=?,excerpt=?,author=?,category=?,tags=?,image=?,meta_title=?,meta_description=?,status=?,featured=?,updated_at=NOW() WHERE id=?",
            [cleanInput($_POST['title']), $slug, $_POST['content'], cleanInput($_POST['excerpt']),
             cleanInput($_POST['author']), cleanInput($_POST['category']), cleanInput($_POST['tags']),
             $img, cleanInput($_POST['meta_title']), cleanInput($_POST['meta_description']),
             cleanInput($_POST['status']), isset($_POST['featured'])?1:0, (int)$_POST['bid']]
        );
    } else {
        db()->insert(
            "INSERT INTO blogs (title,slug,content,excerpt,author,category,tags,image,meta_title,meta_description,status,featured) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)",
            [cleanInput($_POST['title']), $slug, $_POST['content'], cleanInput($_POST['excerpt']),
             cleanInput($_POST['author']), cleanInput($_POST['category']), cleanInput($_POST['tags']),
             $img, cleanInput($_POST['meta_title']), cleanInput($_POST['meta_description']),
             cleanInput($_POST['status']), isset($_POST['featured'])?1:0]
        );
    }
    redirect('/admin/blogs.php?msg=' . urlencode('Blog post saved'));
}

$blogs = db()->fetchAll("SELECT * FROM blogs ORDER BY created_at DESC");
include __DIR__ . '/includes/admin-header.php';
?>
<?php if (isset($_GET['msg'])): ?><div class="admin-alert admin-alert-success" data-auto-dismiss><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars(urldecode($_GET['msg'])); ?></div><?php endif; ?>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
  <div></div>
  <div style="display:flex;gap:12px">
    <a href="?action=list" class="btn-admin <?php echo $action==='list'?'btn-admin-primary':'btn-admin-secondary'; ?>"><i class="fas fa-list"></i> All Posts</a>
    <a href="?action=new" class="btn-admin <?php echo in_array($action,['new','edit'])?'btn-admin-primary':'btn-admin-secondary'; ?>"><i class="fas fa-plus"></i> New Post</a>
  </div>
</div>

<?php if ($action === 'new' || $action === 'edit'): ?>
<div class="admin-card">
  <div class="admin-card-header"><div class="admin-card-title"><i class="fas fa-pen-nib"></i> <?php echo $edit_b?'Edit Post':'New Blog Post'; ?></div></div>
  <div class="admin-card-body">
    <form method="POST" enctype="multipart/form-data">
      <input type="hidden" name="bid" value="<?php echo $edit_b['id']??0; ?>">
      <div class="admin-form-row">
        <div class="admin-form-group" style="flex:2"><label>Title *</label><input type="text" name="title" class="admin-form-control" required value="<?php echo htmlspecialchars($edit_b['title']??''); ?>" oninput="autoSlug(this)"></div>
        <div class="admin-form-group"><label>Status</label><select name="status" class="admin-form-control"><?php foreach (['published','draft'] as $st): ?><option value="<?php echo $st; ?>" <?php echo ($edit_b['status']??'draft')===$st?'selected':''; ?>><?php echo ucfirst($st); ?></option><?php endforeach; ?></select></div>
      </div>
      <div class="admin-form-row">
        <div class="admin-form-group"><label>URL Slug</label><input type="text" name="slug" id="slug" class="admin-form-control" value="<?php echo htmlspecialchars($edit_b['slug']??''); ?>" placeholder="auto-generated"></div>
        <div class="admin-form-group"><label>Category</label><input type="text" name="category" class="admin-form-control" value="<?php echo htmlspecialchars($edit_b['category']??''); ?>" placeholder="e.g. Safety Nets, Bird Control"></div>
        <div class="admin-form-group"><label>Author</label><input type="text" name="author" class="admin-form-control" value="<?php echo htmlspecialchars($edit_b['author']??'NetsDial Team'); ?>"></div>
      </div>
      <div class="admin-form-group"><label>Excerpt (Short Description)</label><textarea name="excerpt" class="admin-form-control" rows="2"><?php echo htmlspecialchars($edit_b['excerpt']??''); ?></textarea></div>
      <div class="admin-form-group"><label>Tags (comma-separated)</label><input type="text" name="tags" class="admin-form-control" value="<?php echo htmlspecialchars($edit_b['tags']??''); ?>" placeholder="pigeon net, balcony safety, hyderabad"></div>
      <div class="admin-form-group">
        <label>Blog Content *</label>
        <textarea name="content" id="blogContent" class="admin-form-control" rows="18"><?php echo htmlspecialchars($edit_b['content']??''); ?></textarea>
      </div>
      <div class="admin-form-row">
        <div class="admin-form-group"><label>Featured Image</label>
          <?php if (!empty($edit_b['image'])): ?><img src="/<?php echo htmlspecialchars($edit_b['image']); ?>" style="height:60px;object-fit:cover;border-radius:var(--radius);margin-bottom:8px;display:block"><?php endif; ?>
          <input type="file" name="image" class="admin-form-control" accept="image/*">
        </div>
        <div class="admin-form-group"><label>Meta Title</label><input type="text" name="meta_title" class="admin-form-control" value="<?php echo htmlspecialchars($edit_b['meta_title']??''); ?>"></div>
      </div>
      <div class="admin-form-group"><label>Meta Description</label><textarea name="meta_description" class="admin-form-control" rows="2"><?php echo htmlspecialchars($edit_b['meta_description']??''); ?></textarea></div>
      <div class="admin-form-group" style="display:flex;align-items:center;gap:10px">
        <label style="margin:0"><input type="checkbox" name="featured" <?php echo !empty($edit_b['featured'])?'checked':''; ?>> Featured Post</label>
      </div>
      <div style="display:flex;gap:12px;margin-top:8px">
        <button type="submit" class="btn-admin btn-admin-primary btn-admin-lg"><i class="fas fa-save"></i> Save Post</button>
        <a href="blogs.php" class="btn-admin btn-admin-secondary btn-admin-lg">Cancel</a>
      </div>
    </form>
  </div>
</div>
<script>
function autoSlug(el) {
  const slug = document.getElementById('slug');
  if (!slug.dataset.manual) {
    slug.value = el.value.toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/^-|-$/g,'');
  }
}
document.getElementById('slug')?.addEventListener('input', function() { this.dataset.manual = 1; });
</script>

<?php else: ?>
<div class="admin-card">
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead><tr><th>Image</th><th>Title</th><th>Category</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
      <tbody>
        <?php foreach ($blogs as $b): ?>
        <tr>
          <td><?php if ($b['image']): ?><img src="/<?php echo htmlspecialchars($b['image']); ?>" style="width:55px;height:38px;object-fit:cover;border-radius:6px"><?php else: ?><div style="width:55px;height:38px;background:var(--off-white);border-radius:6px;display:flex;align-items:center;justify-content:center;color:var(--text-lighter)"><i class="fas fa-image"></i></div><?php endif; ?></td>
          <td>
            <strong><?php echo htmlspecialchars($b['title']); ?></strong>
            <?php if ($b['featured']): ?><span class="status-badge badge-warning" style="font-size:.65rem">Featured</span><?php endif; ?>
            <div style="font-size:.75rem;color:var(--text-lighter)"><?php echo htmlspecialchars($b['slug']); ?></div>
          </td>
          <td style="font-size:.85rem"><?php echo htmlspecialchars($b['category']?:'General'); ?></td>
          <td><span class="status-badge <?php echo $b['status']==='published'?'badge-success':'badge-dark'; ?>"><?php echo ucfirst($b['status']); ?></span></td>
          <td style="font-size:.8rem;color:var(--text-light)"><?php echo date('d M Y',strtotime($b['created_at'])); ?></td>
          <td>
            <div class="actions">
              <a href="?action=edit&id=<?php echo $b['id']; ?>" class="btn-admin btn-admin-info btn-admin-icon"><i class="fas fa-edit"></i></a>
              <a href="?toggle=<?php echo $b['id']; ?>" class="btn-admin btn-admin-secondary btn-admin-icon"><i class="fas fa-<?php echo $b['status']==='published'?'eye-slash':'eye'; ?>"></i></a>
              <a href="/blog/<?php echo $b['slug']; ?>" target="_blank" class="btn-admin btn-admin-success btn-admin-icon"><i class="fas fa-external-link-alt"></i></a>
              <a href="?delete=<?php echo $b['id']; ?>" class="btn-admin btn-admin-danger btn-admin-icon" data-confirm="Delete this post?"><i class="fas fa-trash"></i></a>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($blogs)): ?><tr><td colspan="6" style="text-align:center;padding:30px;color:var(--text-light)">No blog posts yet. <a href="?action=new">Write your first post!</a></td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php endif; ?>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
