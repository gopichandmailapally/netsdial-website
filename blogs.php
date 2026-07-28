<?php
define('NETSDIAL', true);
require_once __DIR__ . '/config/config.php';
trackVisitor();

$page_title       = 'Blog - NetsDial | Tips on Pigeon Nets, Safety Nets, Cricket Nets & More';
$page_description = 'Read expert articles on pigeon net installation, balcony safety nets, invisible grills, cricket net setup, artificial grass, and wholesale net buying guides from NetsDial Hyderabad.';
$page_keywords    = 'pigeon net blog, safety net tips, cricket net guide, balcony safety net information, russe nets hyderabad, net supplier blog india';
$breadcrumb = [['Home',SITE_URL],['Blogs','']];

$per_page = 9;
$page = max(1,(int)($_GET['page']??1));
$offset = ($page-1)*$per_page;
$cat_filter = cleanInput($_GET['cat']??'');
$where = $cat_filter ? "AND category=?" : "";
$params = $cat_filter ? [$cat_filter] : [];
$total  = db()->fetchOne("SELECT COUNT(*) as c FROM blogs WHERE status='published' $where",$params)['c']??0;
$blogs  = db()->fetchAll("SELECT * FROM blogs WHERE status='published' $where ORDER BY created_at DESC LIMIT $per_page OFFSET $offset", $params);
$pages  = ceil($total/$per_page);
$cats   = db()->fetchAll("SELECT DISTINCT category,COUNT(*) as cnt FROM blogs WHERE status='published' AND category!='' GROUP BY category ORDER BY cnt DESC");
$featured = db()->fetchAll("SELECT * FROM blogs WHERE status='published' AND featured=1 ORDER BY created_at DESC LIMIT 3");

include __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="container page-hero-content">
    <div class="breadcrumb"><?php echo buildBreadcrumb($breadcrumb); ?></div>
    <h1>Net Expert <span class="gradient-text">Blog</span></h1>
    <p>Tips, guides, and insights on nets, safety, and sports installations from NetsDial experts</p>
  </div>
</section>

<section class="section-padding">
  <div class="container">
    <div style="display:grid;grid-template-columns:1fr 320px;gap:40px">
      <!-- Blog Grid -->
      <div>
        <?php if (!empty($blogs)): ?>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:24px">
          <?php foreach ($blogs as $b): ?>
          <article class="blog-card">
            <div class="blog-img">
              <?php if ($b['image']): ?>
              <img src="/<?php echo htmlspecialchars($b['image']); ?>" alt="<?php echo htmlspecialchars($b['title']); ?>" loading="lazy">
              <?php else: ?>
              <div style="background:linear-gradient(135deg,#FF6B00,#FF8C42);height:100%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:3rem"><i class="fas fa-newspaper"></i></div>
              <?php endif; ?>
              <?php if ($b['category']): ?><span class="blog-cat"><?php echo htmlspecialchars($b['category']); ?></span><?php endif; ?>
            </div>
            <div class="blog-content">
              <div class="blog-meta"><span><i class="fas fa-calendar-alt"></i> <?php echo date('d M Y',strtotime($b['created_at'])); ?></span><span><i class="fas fa-user"></i> <?php echo htmlspecialchars($b['author']?:'NetsDial Team'); ?></span></div>
              <h3 class="blog-title"><a href="/blog/<?php echo htmlspecialchars($b['slug']); ?>"><?php echo htmlspecialchars($b['title']); ?></a></h3>
              <p class="blog-excerpt"><?php echo htmlspecialchars(substr($b['excerpt']?:strip_tags($b['content']),0,120)); ?>...</p>
              <a href="/blog/<?php echo htmlspecialchars($b['slug']); ?>" class="blog-read-more">Read More <i class="fas fa-arrow-right"></i></a>
            </div>
          </article>
          <?php endforeach; ?>
        </div>

        <?php if ($pages > 1): ?>
        <div class="pagination" style="display:flex;gap:8px;justify-content:center;margin-top:40px;flex-wrap:wrap">
          <?php for ($p=1;$p<=$pages;$p++): ?>
          <a href="?page=<?php echo $p; ?><?php echo $cat_filter?'&cat='.urlencode($cat_filter):''; ?>" class="page-btn <?php echo $p===$page?'active':''; ?>" style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;border-radius:var(--radius);border:1px solid var(--border);text-decoration:none;font-weight:600;color:var(--text-medium);<?php echo $p===$page?'background:var(--primary);color:#fff;border-color:var(--primary)':''; ?>"><?php echo $p; ?></a>
          <?php endfor; ?>
        </div>
        <?php endif; ?>

        <?php else: ?>
        <!-- Placeholder blog posts -->
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:24px">
          <?php
          $sample_posts = [
            ['How Much Does Pigeon Net Cost in Hyderabad? Complete Price Guide 2025','pigeon-net-cost-hyderabad','Safety Nets','Want to know the exact cost of pigeon nets in Hyderabad? We break down pricing by material, size, and area — including Russe™ HDPE nets wholesale rates.','2025-04-01'],
            ['5 Reasons Why Invisible Grills are Better Than Traditional Safety Grills','invisible-grills-vs-traditional','Invisible Grills','Invisible grills are revolutionizing balcony safety in Hyderabad. Here\'s why homeowners in Jubilee Hills, Gachibowli, and HITEC City are switching.','2025-04-08'],
            ['Complete Guide to Setting Up a Box Cricket Ground with Nets','box-cricket-ground-setup-guide','Cricket Nets','Planning a box cricket business? This guide covers net selection, turf, structure, and flooring costs for Hyderabad\'s growing box cricket market.','2025-04-15'],
            ['HDPE vs Nylon Pigeon Nets: Which is Better for Hyderabad Apartments?','hdpe-vs-nylon-pigeon-nets','Safety Nets','A detailed comparison of HDPE and nylon pigeon nets for residential use. Russe™ HDPE nets are UV-stabilized for Hyderabad\'s hot climate.','2025-04-22'],
            ['Artificial Grass Installation: A Complete Buyer\'s Guide for Hyderabad','artificial-grass-installation-guide','Artificial Grass','Planning artificial grass for your balcony, terrace, or garden in Hyderabad? This buyer\'s guide covers pile heights, types, and Russe™ brand pricing.','2025-04-29'],
            ['Anti-Bird Nets for Solar Panels: Why You Need Them in Hyderabad','anti-bird-nets-solar-panels-hyderabad','Bird Control','Pigeons nesting under solar panels can reduce efficiency by 30%. Learn how Russe™ anti-bird nets protect your solar investment in Hyderabad.','2025-05-06'],
          ];
          foreach ($sample_posts as $sp):
          ?>
          <article class="blog-card">
            <div class="blog-img" style="height:180px;background:linear-gradient(135deg,#FF6B00,#FF8C42);display:flex;align-items:center;justify-content:center;color:#fff;font-size:2.5rem">
              <i class="fas fa-newspaper"></i>
              <span class="blog-cat"><?php echo $sp[2]; ?></span>
            </div>
            <div class="blog-content">
              <div class="blog-meta"><span><i class="fas fa-calendar-alt"></i> <?php echo date('d M Y',strtotime($sp[4])); ?></span></div>
              <h3 class="blog-title"><a href="/blog/<?php echo $sp[1]; ?>"><?php echo $sp[0]; ?></a></h3>
              <p class="blog-excerpt"><?php echo substr($sp[3],0,100); ?>...</p>
              <a href="/blog/<?php echo $sp[1]; ?>" class="blog-read-more">Read More <i class="fas fa-arrow-right"></i></a>
            </div>
          </article>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>

      <!-- Sidebar -->
      <aside>
        <!-- Categories -->
        <div style="background:#fff;border:1px solid var(--border);border-radius:var(--radius-lg);padding:24px;margin-bottom:24px">
          <h3 style="font-size:1rem;margin-bottom:16px;padding-bottom:12px;border-bottom:2px solid var(--primary)">Categories</h3>
          <a href="blogs.php" class="sidebar-cat-link <?php echo !$cat_filter?'active':''; ?>">All Posts <span>(<?php echo $total; ?>)</span></a>
          <?php foreach ($cats as $c): ?>
          <a href="?cat=<?php echo urlencode($c['category']); ?>" class="sidebar-cat-link <?php echo $cat_filter===$c['category']?'active':''; ?>"><?php echo htmlspecialchars($c['category']); ?> <span>(<?php echo $c['cnt']; ?>)</span></a>
          <?php endforeach; ?>
        </div>

        <!-- Popular Keywords -->
        <div style="background:#fff;border:1px solid var(--border);border-radius:var(--radius-lg);padding:24px;margin-bottom:24px">
          <h3 style="font-size:1rem;margin-bottom:16px;padding-bottom:12px;border-bottom:2px solid var(--primary)">Popular Topics</h3>
          <div style="display:flex;flex-wrap:wrap;gap:8px">
            <?php
            $tags = ['Pigeon Nets','Balcony Safety Nets','Invisible Grills','Cricket Nets','Artificial Grass','Bird Control','HDPE Nets','Russe™ Brand','Hyderabad','Wholesale Nets'];
            foreach ($tags as $t): ?>
            <a href="/blogs?q=<?php echo urlencode($t); ?>" style="background:var(--off-white);padding:5px 12px;border-radius:99px;font-size:.78rem;text-decoration:none;color:var(--text-medium);border:1px solid var(--border);transition:.2s" onmouseover="this.style.background='var(--primary)';this.style.color='#fff'" onmouseout="this.style.background='var(--off-white)';this.style.color='var(--text-medium)'"><?php echo $t; ?></a>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Contact Box -->
        <div style="background:linear-gradient(135deg,#FF6B00,#FF8C42);border-radius:var(--radius-lg);padding:24px;color:#fff;text-align:center">
          <i class="fas fa-headset" style="font-size:2rem;margin-bottom:12px;display:block"></i>
          <h4>Need Net Supply?</h4>
          <p style="opacity:.9;font-size:.88rem;margin-bottom:16px">Talk to our wholesale experts for the best Russe™ net prices</p>
          <a href="tel:+91<?php echo getSetting('site_phone','9966499144'); ?>" style="background:#fff;color:#FF6B00;padding:10px 24px;border-radius:99px;font-weight:700;text-decoration:none;display:block">📞 Call Now</a>
        </div>
      </aside>
    </div>
  </div>
</section>

<style>
.sidebar-cat-link { display:flex;justify-content:space-between;padding:8px 12px;border-radius:var(--radius);text-decoration:none;color:var(--text-medium);font-size:.88rem;transition:.2s;margin-bottom:4px; }
.sidebar-cat-link:hover,.sidebar-cat-link.active { background:var(--primary-light);color:var(--primary);font-weight:600; }
.sidebar-cat-link span { font-weight:700;color:var(--text-lighter);font-size:.8rem; }
</style>

<?php include __DIR__ . '/includes/footer.php'; ?>
