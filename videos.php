<?php
define('NETSDIAL', true);
require_once __DIR__ . '/config/config.php';
trackVisitor();

$page_title       = 'Videos - NetsDial | Pigeon Net, Safety Net & Cricket Net Installation Videos Hyderabad';
$page_description = 'Watch NetsDial installation videos. See how Russe™ pigeon nets, balcony safety nets, invisible grills, and cricket nets are installed by experts across Hyderabad.';
$page_keywords    = 'netsdial videos, pigeon net installation video hyderabad, safety net video, cricket net installation video, invisible grill installation video';
$breadcrumb = [['Home',SITE_URL],['Videos','']];

$videos = db()->fetchAll("SELECT * FROM videos WHERE is_active=1 ORDER BY sort_order ASC, id DESC");
include __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="container page-hero-content">
    <div class="breadcrumb"><?php echo buildBreadcrumb($breadcrumb); ?></div>
    <h1>Installation <span class="gradient-text">Videos</span></h1>
    <p>See our Russe™ net installations in action — from pigeon nets to cricket grounds</p>
  </div>
</section>

<section class="section-padding">
  <div class="container">
    <?php if (!empty($videos)): ?>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:24px">
      <?php foreach ($videos as $v): ?>
      <div class="video-card" style="background:#fff;border-radius:var(--radius-lg);overflow:hidden;box-shadow:var(--shadow-sm);border:1px solid var(--border);transition:all .3s">
        <?php
        $yt_id = '';
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $v['video_url'], $m)) {
            $yt_id = $m[1];
        }
        ?>
        <div style="position:relative;aspect-ratio:16/9;overflow:hidden;background:#000;cursor:pointer" onclick="playVideo(this,'<?php echo $yt_id ?: $v['video_url']; ?>')">
          <?php if ($yt_id): ?>
          <img src="https://img.youtube.com/vi/<?php echo $yt_id; ?>/maxresdefault.jpg" alt="<?php echo htmlspecialchars($v['title']); ?>" style="width:100%;height:100%;object-fit:cover;transition:transform .4s">
          <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,.3)">
            <div style="width:70px;height:70px;background:#FF6B00;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.8rem;transition:transform .3s"><i class="fas fa-play" style="margin-left:5px"></i></div>
          </div>
          <?php else: ?>
          <video src="<?php echo htmlspecialchars($v['video_url']); ?>" style="width:100%;height:100%;object-fit:cover"></video>
          <?php endif; ?>
        </div>
        <div style="padding:20px">
          <h3 style="font-size:1rem;margin-bottom:8px;line-height:1.5"><?php echo htmlspecialchars($v['title']); ?></h3>
          <?php if ($v['description']): ?><p style="font-size:.85rem;color:var(--text-light);line-height:1.6"><?php echo htmlspecialchars(substr($v['description'],0,120)); ?></p><?php endif; ?>
          <div style="display:flex;gap:10px;margin-top:14px">
            <a href="<?php echo htmlspecialchars($v['video_url']); ?>" target="_blank" class="btn-secondary" style="font-size:.82rem;padding:7px 16px"><i class="fab fa-youtube" style="color:#FF0000"></i> Watch on YouTube</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <!-- Sample YouTube Embeds as placeholder -->
    <div style="text-align:center;padding:60px 0">
      <i class="fab fa-youtube" style="font-size:4rem;color:#FF0000;margin-bottom:20px"></i>
      <h3>Videos Coming Soon</h3>
      <p style="color:var(--text-light);margin-bottom:24px">Installation videos will be added here. Add them from the <a href="/admin/">admin panel</a>.</p>
      <div style="display:flex;gap:20px;justify-content:center;flex-wrap:wrap">
        <a href="https://www.youtube.com/@netsdial" target="_blank" class="btn-primary"><i class="fab fa-youtube"></i> Visit Our YouTube Channel</a>
        <a href="https://wa.me/91<?php echo getSetting('site_phone','9966499144'); ?>" target="_blank" class="btn-secondary"><i class="fab fa-whatsapp"></i> WhatsApp Us</a>
      </div>
    </div>
    <?php endif; ?>

    <!-- CTA -->
    <div style="margin-top:60px;background:linear-gradient(135deg,#FF6B00,#FF8C42);border-radius:var(--radius-xl);padding:40px;text-align:center;color:#fff">
      <h3>Want to See More?</h3>
      <p style="opacity:.9;margin-bottom:20px">Subscribe to our YouTube channel for installation guides, product reviews, and tips</p>
      <a href="https://www.youtube.com/@netsdial" target="_blank" style="background:#fff;color:#FF6B00;padding:12px 32px;border-radius:99px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:10px"><i class="fab fa-youtube" style="color:#FF0000;font-size:1.3rem"></i> Subscribe on YouTube</a>
    </div>
  </div>
</section>

<!-- Video Modal -->
<div id="videoModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.95);z-index:9999;align-items:center;justify-content:center" onclick="if(event.target===this)closeVideo()">
  <button onclick="closeVideo()" style="position:absolute;top:20px;right:20px;background:rgba(255,255,255,.1);border:none;color:#fff;width:44px;height:44px;border-radius:50%;font-size:1.2rem;cursor:pointer"><i class="fas fa-times"></i></button>
  <div style="width:90vw;max-width:900px">
    <div id="videoEmbed" style="aspect-ratio:16/9;background:#000;border-radius:var(--radius-lg);overflow:hidden"></div>
  </div>
</div>

<script>
function playVideo(el, vidId) {
  const modal = document.getElementById('videoModal');
  const embed = document.getElementById('videoEmbed');
  if (vidId.length === 11) {
    embed.innerHTML = `<iframe src="https://www.youtube.com/embed/${vidId}?autoplay=1&rel=0" width="100%" height="100%" frameborder="0" allow="autoplay;fullscreen" style="width:100%;height:100%"></iframe>`;
  } else {
    embed.innerHTML = `<video src="${vidId}" autoplay controls style="width:100%;height:100%"></video>`;
  }
  modal.style.display = 'flex';
}
function closeVideo() {
  document.getElementById('videoModal').style.display = 'none';
  document.getElementById('videoEmbed').innerHTML = '';
}
document.addEventListener('keydown', e => { if (e.key==='Escape') closeVideo(); });
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
