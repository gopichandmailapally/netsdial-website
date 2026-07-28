<?php
define('NETSDIAL', true);
require_once dirname(__DIR__) . '/config/config.php';
requireAdmin();
$admin_page_title = 'Gallery Management';

if (isset($_GET['delete'])) {
    $img = db()->fetchOne("SELECT image_path FROM gallery WHERE id=?",[(int)$_GET['delete']]);
    if ($img && $img['image_path']) @unlink(dirname(__DIR__).'/'.$img['image_path']);
    db()->execute("DELETE FROM gallery WHERE id=?",[(int)$_GET['delete']]);
    redirect('/admin/gallery.php?msg=Image+deleted');
}
if (isset($_GET['toggle'])) {
    $cur = db()->fetchOne("SELECT is_active FROM gallery WHERE id=?",[(int)$_GET['toggle']]);
    db()->execute("UPDATE gallery SET is_active=? WHERE id=?",[$cur['is_active']?0:1,(int)$_GET['toggle']]);
    redirect('/admin/gallery.php?msg=Visibility+toggled');
}

if ($_SERVER['REQUEST_METHOD']==='POST' && !empty($_FILES['images']['name'][0])) {
    $cat  = cleanInput($_POST['category']??'General');
    $sort = (int)($_POST['sort_order']??0);
    foreach ($_FILES['images']['name'] as $i=>$fname) {
        if (!$fname) continue;
        $ext  = strtolower(pathinfo($fname,PATHINFO_EXTENSION));
        $safe = 'gallery-'.time().'-'.mt_rand(100,999).'.'.$ext;
        $dest = dirname(__DIR__).'/uploads/gallery/'.$safe;
        if (move_uploaded_file($_FILES['images']['tmp_name'][$i],$dest)) {
            $title = cleanInput($_POST['title']??pathinfo($fname,PATHINFO_FILENAME));
            db()->insert("INSERT INTO gallery (title,image_path,category,sort_order,is_active) VALUES (?,?,?,?,1)",[$title,'uploads/gallery/'.$safe,$cat,$sort+$i]);
        }
    }
    redirect('/admin/gallery.php?msg=Images+uploaded');
}

if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['update_caption'])) {
    db()->execute("UPDATE gallery SET title=?,category=? WHERE id=?",
        [cleanInput($_POST['title']),cleanInput($_POST['category']),(int)$_POST['id']]);
    redirect('/admin/gallery.php?msg=Updated');
}

$gallery = db()->fetchAll("SELECT * FROM gallery ORDER BY sort_order ASC, id DESC");
include __DIR__ . '/includes/admin-header.php';
?>
<?php if (isset($_GET['msg'])): ?><div class="admin-alert admin-alert-success" data-auto-dismiss><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars(urldecode($_GET['msg'])); ?></div><?php endif; ?>

<div class="admin-card mb-24">
  <div class="admin-card-header"><div class="admin-card-title"><i class="fas fa-cloud-upload-alt"></i> Upload Images</div></div>
  <div class="admin-card-body">
    <form method="POST" enctype="multipart/form-data">
      <div class="admin-form-row">
        <div class="admin-form-group"><label>Caption / Title</label><input type="text" name="title" class="admin-form-control" placeholder="e.g. Pigeon Net Installation in Kukatpally"></div>
        <div class="admin-form-group"><label>Category</label>
          <select name="category" class="admin-form-control">
            <option>Pigeon Nets</option><option>Balcony Safety Nets</option><option>Invisible Grills</option>
            <option>Cloth Hangers</option><option>Artificial Grass</option><option>Cricket Nets</option>
            <option>Sports Nets</option><option>General</option>
          </select>
        </div>
        <div class="admin-form-group"><label>Sort Order</label><input type="number" name="sort_order" class="admin-form-control" value="0" min="0"></div>
      </div>
      <div class="admin-form-group">
        <label>Select Images (Multiple)</label>
        <div id="dropzone" style="border:2px dashed var(--border);border-radius:var(--radius-lg);padding:40px;text-align:center;cursor:pointer;transition:all .3s;background:var(--off-white)">
          <i class="fas fa-cloud-upload-alt" style="font-size:2.5rem;color:var(--primary);margin-bottom:12px"></i>
          <p style="color:var(--text-light)">Drag & Drop images here or click to select</p>
          <input type="file" name="images[]" id="imageInput" multiple accept="image/*" style="opacity:0;position:absolute;inset:0;width:100%;height:100%;cursor:pointer">
        </div>
        <div id="preview" style="display:flex;flex-wrap:wrap;gap:10px;margin-top:12px"></div>
      </div>
      <button type="submit" class="btn-admin btn-admin-primary"><i class="fas fa-upload"></i> Upload</button>
    </form>
  </div>
</div>

<div class="admin-card">
  <div class="admin-card-header"><div class="admin-card-title"><i class="fas fa-images"></i> Gallery Images (<?php echo count($gallery); ?>)</div></div>
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:16px;padding:16px">
    <?php foreach ($gallery as $img): ?>
    <div class="gallery-admin-card" style="background:#fff;border:1px solid var(--border);border-radius:var(--radius-lg);overflow:hidden">
      <div style="position:relative">
        <img src="/<?php echo htmlspecialchars($img['image_path']); ?>" style="width:100%;height:150px;object-fit:cover;display:block" onerror="this.style.background='#f0f0f0';this.removeAttribute('src')">
        <?php if (!$img['is_active']): ?><div style="position:absolute;inset:0;background:rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;color:#fff;font-size:.8rem">Hidden</div><?php endif; ?>
      </div>
      <div style="padding:10px">
        <div style="font-size:.8rem;font-weight:600;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;margin-bottom:4px" title="<?php echo htmlspecialchars($img['title']); ?>"><?php echo htmlspecialchars($img['title']); ?></div>
        <div style="font-size:.72rem;color:var(--text-lighter);margin-bottom:8px"><?php echo htmlspecialchars($img['category']); ?></div>
        <div style="display:flex;gap:6px">
          <a href="?toggle=<?php echo $img['id']; ?>" class="btn-admin btn-admin-secondary btn-admin-icon btn-admin-sm" title="Toggle"><i class="fas fa-eye<?php echo $img['is_active']?'':'-slash'; ?>"></i></a>
          <a href="?delete=<?php echo $img['id']; ?>" class="btn-admin btn-admin-danger btn-admin-icon btn-admin-sm" data-confirm="Delete?" title="Delete"><i class="fas fa-trash"></i></a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
    <?php if (empty($gallery)): ?><div style="grid-column:1/-1;text-align:center;padding:40px;color:var(--text-light)">No images yet. Upload your first image above.</div><?php endif; ?>
  </div>
</div>

<script>
const dz = document.getElementById('dropzone');
const ip = document.getElementById('imageInput');
const pr = document.getElementById('preview');

dz.addEventListener('dragover', e=>{ e.preventDefault(); dz.style.borderColor='var(--primary)'; });
dz.addEventListener('dragleave', ()=>dz.style.borderColor='var(--border)');
dz.addEventListener('drop', e=>{ e.preventDefault(); dz.style.borderColor='var(--border)'; showPreview(e.dataTransfer.files); });
ip.addEventListener('change', ()=>showPreview(ip.files));

function showPreview(files) {
  pr.innerHTML = '';
  [...files].forEach(f=>{
    const r = new FileReader();
    r.onload = e=>{ const d = document.createElement('div'); d.style='position:relative'; d.innerHTML=`<img src="${e.target.result}" style="width:80px;height:80px;object-fit:cover;border-radius:8px;display:block"><span style="position:absolute;bottom:2px;left:0;right:0;text-align:center;font-size:.55rem;background:rgba(0,0,0,.5);color:#fff;padding:2px;border-radius:0 0 8px 8px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis">${f.name}</span>`; pr.appendChild(d); };
    r.readAsDataURL(f);
  });
}
</script>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
