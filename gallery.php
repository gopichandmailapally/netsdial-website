<?php
define('NETSDIAL', true);
require_once __DIR__ . '/config/config.php';
trackVisitor();

$page_title       = 'Gallery - NetsDial Hyderabad | Pigeon Nets, Safety Nets, Invisible Grills, Cricket Nets';
$page_description = 'View our installation gallery. NetsDial supplies Russe™ brand pigeon nets, balcony safety nets, invisible grills, cloth hangers, cricket nets, and artificial grass across Hyderabad and India.';
$page_keywords    = 'netsdial gallery, pigeon net photos hyderabad, balcony safety net gallery, invisible grill photos, cricket net photos, artificial grass gallery hyderabad';
$breadcrumb = [['Home',SITE_URL],['Gallery','']];

$cat_filter = cleanInput($_GET['cat'] ?? 'all');
$where = $cat_filter !== 'all' ? "AND category = ?" : "";
$params = $cat_filter !== 'all' ? [$cat_filter] : [];

$sql = "SELECT * FROM gallery WHERE is_active=1 $where ORDER BY sort_order ASC, id DESC";
$images = db()->fetchAll($sql, $params);
$cats   = db()->fetchAll("SELECT DISTINCT category FROM gallery WHERE is_active=1 ORDER BY category");

include __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="container page-hero-content">
    <div class="breadcrumb"><?php echo buildBreadcrumb($breadcrumb); ?></div>
    <h1>Our Work <span class="gradient-text">Gallery</span></h1>
    <p>Browse through our installations — Russe™ quality nets across Hyderabad and India</p>
  </div>
</section>

<section class="section-padding">
  <div class="container">
    <!-- Filter Tabs -->
    <div class="gallery-filters" style="display:flex;gap:10px;flex-wrap:wrap;justify-content:center;margin-bottom:40px">
      <a href="?cat=all" class="gallery-filter-btn <?php echo $cat_filter==='all'?'active':''; ?>">All</a>
      <?php foreach ($cats as $c): ?>
      <a href="?cat=<?php echo urlencode($c['category']); ?>" class="gallery-filter-btn <?php echo $cat_filter===$c['category']?'active':''; ?>"><?php echo htmlspecialchars($c['category']); ?></a>
      <?php endforeach; ?>
    </div>

    <?php if (!empty($images)): ?>
    <div class="gallery-masonry" style="columns:4;gap:16px;column-fill:initial" id="galleryGrid">
      <?php foreach ($images as $img): ?>
      <div class="gallery-item" style="break-inside:avoid;margin-bottom:16px;border-radius:var(--radius-lg);overflow:hidden;position:relative;cursor:pointer" onclick="openLightbox('<?php echo htmlspecialchars($img['image_path']); ?>','<?php echo htmlspecialchars(addslashes($img['title'])); ?>')">
        <img src="/<?php echo htmlspecialchars($img['image_path']); ?>" alt="<?php echo htmlspecialchars($img['title']); ?>" style="width:100%;display:block;transition:transform .4s" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&q=60'">
        <div class="gallery-overlay" style="position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.8),transparent);opacity:0;transition:.3s;display:flex;flex-direction:column;justify-content:flex-end;padding:14px">
          <div style="color:#fff;font-size:.88rem;font-weight:600"><?php echo htmlspecialchars($img['title']); ?></div>
          <div style="color:rgba(255,255,255,.7);font-size:.75rem"><?php echo htmlspecialchars($img['category']); ?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <!-- Placeholder gallery when no images in DB -->
    <div style="text-align:center;padding:60px;color:var(--text-light)">
      <i class="fas fa-images" style="font-size:4rem;margin-bottom:20px;opacity:.3"></i>
      <p>Gallery images will appear here once added from the admin panel.</p>
      <p style="margin-top:8px">Visit <a href="/admin/gallery.php">Admin Gallery</a> to upload images.</p>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- Lightbox -->
<div id="lightbox" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.95);z-index:9999;align-items:center;justify-content:center;padding:20px" onclick="closeLightbox(event)">
  <button onclick="closeLightbox()" style="position:absolute;top:20px;right:20px;background:rgba(255,255,255,.1);border:none;color:#fff;width:44px;height:44px;border-radius:50%;font-size:1.2rem;cursor:pointer"><i class="fas fa-times"></i></button>
  <button onclick="prevImg()" style="position:absolute;left:20px;top:50%;transform:translateY(-50%);background:rgba(255,255,255,.1);border:none;color:#fff;width:50px;height:50px;border-radius:50%;font-size:1.5rem;cursor:pointer"><i class="fas fa-chevron-left"></i></button>
  <button onclick="nextImg()" style="position:absolute;right:20px;top:50%;transform:translateY(-50%);background:rgba(255,255,255,.1);border:none;color:#fff;width:50px;height:50px;border-radius:50%;font-size:1.5rem;cursor:pointer"><i class="fas fa-chevron-right"></i></button>
  <div style="max-width:90vw;max-height:90vh;text-align:center">
    <img id="lightboxImg" src="" style="max-width:100%;max-height:80vh;border-radius:var(--radius-lg);object-fit:contain">
    <p id="lightboxCaption" style="color:#fff;margin-top:12px;font-size:.95rem"></p>
  </div>
</div>

<style>
.gallery-filter-btn { padding:8px 20px;border-radius:99px;border:2px solid var(--border);background:#fff;color:var(--text-medium);text-decoration:none;font-size:.88rem;font-weight:600;transition:all .2s; }
.gallery-filter-btn.active,.gallery-filter-btn:hover { background:var(--primary);border-color:var(--primary);color:#fff; }
.gallery-item:hover img { transform:scale(1.05); }
.gallery-item:hover .gallery-overlay { opacity:1!important; }
@media(max-width:1024px){.gallery-masonry{columns:3!important}}
@media(max-width:768px){.gallery-masonry{columns:2!important}}
@media(max-width:480px){.gallery-masonry{columns:1!important}}
</style>

<script>
const imgs = <?php echo json_encode(array_values(array_map(fn($i) => ['src'=>'/'.$i['image_path'],'cap'=>$i['title']], $images))); ?>;
let cur = 0;

function openLightbox(src, cap) {
  cur = imgs.findIndex(i => i.src === '/' + src.replace(/^\//,'')) ?? 0;
  showImg(cur);
  document.getElementById('lightbox').style.display = 'flex';
  document.body.style.overflow = 'hidden';
}
function closeLightbox(e) {
  if (!e || e.target === document.getElementById('lightbox') || e.target.tagName === 'BUTTON' || e.target.tagName === 'I') {
    document.getElementById('lightbox').style.display = 'none';
    document.body.style.overflow = '';
  }
}
function showImg(i) { if (!imgs[i]) return; document.getElementById('lightboxImg').src = imgs[i].src; document.getElementById('lightboxCaption').textContent = imgs[i].cap; }
function nextImg() { cur = (cur+1)%imgs.length; showImg(cur); }
function prevImg() { cur = (cur-1+imgs.length)%imgs.length; showImg(cur); }
document.addEventListener('keydown', e => { if (e.key==='ArrowRight') nextImg(); else if (e.key==='ArrowLeft') prevImg(); else if (e.key==='Escape') document.getElementById('lightbox').style.display='none'; });
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
