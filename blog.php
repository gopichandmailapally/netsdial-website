<?php
define('NETSDIAL', true);
require_once __DIR__ . '/config/config.php';
trackVisitor();

$slug = cleanInput($_GET['slug'] ?? '');
if (!$slug) { header('Location: /blogs'); exit; }

$blog = db()->fetchOne("SELECT * FROM blogs WHERE slug=? AND status='published'", [$slug]);
if (!$blog) { http_response_code(404); include __DIR__ . '/includes/header.php'; echo '<div class="container" style="padding:80px 0;text-align:center"><h2>Article Not Found</h2><a href="/blogs" class="btn-primary">Back to Blog</a></div>'; include __DIR__ . '/includes/footer.php'; exit; }

$page_title       = $blog['meta_title'] ?: ($blog['title'] . ' | NetsDial Blog');
$page_description = $blog['meta_description'] ?: substr(strip_tags($blog['content']),0,160);
$page_keywords    = $blog['tags'] ?: 'pigeon nets hyderabad, safety nets, cricket nets, russe nets';
$breadcrumb       = [['Home',SITE_URL],['Blogs',SITE_URL.'/blogs'],[$blog['title'],'']];

$related = db()->fetchAll("SELECT * FROM blogs WHERE status='published' AND id!=? AND category=? ORDER BY RAND() LIMIT 3", [(int)$blog['id'],$blog['category']?:'']);
include __DIR__ . '/includes/header.php';
?>

<section class="page-hero" style="min-height:400px">
  <?php if ($blog['image']): ?><div style="position:absolute;inset:0;background:url('/<?php echo htmlspecialchars($blog['image']); ?>') center/cover;opacity:.25"></div><?php endif; ?>
  <div class="container page-hero-content" style="max-width:800px">
    <div class="breadcrumb"><?php echo buildBreadcrumb($breadcrumb); ?></div>
    <?php if ($blog['category']): ?><span class="section-badge" style="display:inline-block;margin-bottom:12px"><?php echo htmlspecialchars($blog['category']); ?></span><?php endif; ?>
    <h1 style="font-size:clamp(1.5rem,4vw,2.4rem)"><?php echo htmlspecialchars($blog['title']); ?></h1>
    <div style="display:flex;gap:20px;flex-wrap:wrap;font-size:.85rem;opacity:.8;margin-top:12px">
      <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($blog['author']?:'NetsDial Team'); ?></span>
      <span><i class="fas fa-calendar-alt"></i> <?php echo date('d F Y',strtotime($blog['created_at'])); ?></span>
      <?php if ($blog['tags']): ?><span><i class="fas fa-tags"></i> <?php echo htmlspecialchars($blog['tags']); ?></span><?php endif; ?>
    </div>
  </div>
</section>

<section class="section-padding">
  <div class="container">
    <div style="display:grid;grid-template-columns:1fr 300px;gap:40px;max-width:1100px;margin:0 auto">
      <!-- Article Content -->
      <article>
        <?php if ($blog['image']): ?>
        <img src="/<?php echo htmlspecialchars($blog['image']); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>" style="width:100%;border-radius:var(--radius-lg);margin-bottom:32px;object-fit:cover;max-height:450px">
        <?php endif; ?>

        <div class="blog-body" style="font-size:1.02rem;line-height:1.85;color:var(--text-medium)">
          <?php echo nl2br(htmlspecialchars($blog['content'])); ?>
        </div>

        <!-- Share -->
        <div style="margin-top:40px;padding-top:24px;border-top:1px solid var(--border);display:flex;gap:12px;align-items:center;flex-wrap:wrap">
          <span style="font-weight:600">Share:</span>
          <?php $pageUrl = SITE_URL . '/blog/' . $blog['slug']; ?>
          <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($pageUrl); ?>" target="_blank" class="btn-secondary btn-sm"><i class="fab fa-facebook"></i> Facebook</a>
          <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($pageUrl); ?>&text=<?php echo urlencode($blog['title']); ?>" target="_blank" class="btn-secondary btn-sm"><i class="fab fa-twitter"></i> Twitter</a>
          <a href="https://wa.me/?text=<?php echo urlencode($blog['title'].' - '.$pageUrl); ?>" target="_blank" class="btn-secondary btn-sm"><i class="fab fa-whatsapp"></i> WhatsApp</a>
        </div>
      </article>

      <!-- Sidebar -->
      <aside>
        <div style="background:#fff;border:1px solid var(--border);border-radius:var(--radius-lg);padding:24px;margin-bottom:24px;position:sticky;top:90px">
          <h4 style="margin-bottom:16px;padding-bottom:12px;border-bottom:2px solid var(--primary)">Get Free Quote</h4>
          <p style="font-size:.88rem;color:var(--text-light);margin-bottom:16px">Need Russe™ nets for your home or business? Get wholesale pricing today.</p>
          <a href="tel:+91<?php echo getSetting('site_phone','9966499144'); ?>" class="btn-primary" style="display:block;text-align:center;margin-bottom:12px"><i class="fas fa-phone"></i> +91 <?php echo getSetting('site_phone','9966499144'); ?></a>
          <a href="https://wa.me/91<?php echo getSetting('site_phone','9966499144'); ?>" target="_blank" class="btn-secondary" style="display:block;text-align:center;background:#25D366;color:#fff;border-color:#25D366"><i class="fab fa-whatsapp"></i> WhatsApp</a>
        </div>

        <?php if (!empty($related)): ?>
        <div style="background:#fff;border:1px solid var(--border);border-radius:var(--radius-lg);padding:24px">
          <h4 style="margin-bottom:16px;padding-bottom:12px;border-bottom:2px solid var(--primary)">Related Articles</h4>
          <?php foreach ($related as $r): ?>
          <div style="margin-bottom:16px;padding-bottom:16px;border-bottom:1px solid var(--border)">
            <?php if ($r['image']): ?><img src="/<?php echo htmlspecialchars($r['image']); ?>" style="width:100%;height:80px;object-fit:cover;border-radius:var(--radius);margin-bottom:8px"><?php endif; ?>
            <a href="/blog/<?php echo htmlspecialchars($r['slug']); ?>" style="font-weight:600;font-size:.88rem;text-decoration:none;color:var(--text-dark);line-height:1.5"><?php echo htmlspecialchars($r['title']); ?></a>
            <div style="font-size:.75rem;color:var(--text-lighter);margin-top:4px"><?php echo date('d M Y',strtotime($r['created_at'])); ?></div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </aside>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
