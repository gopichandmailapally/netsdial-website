<?php
define('NETSDIAL', true);
require_once __DIR__ . '/config/config.php';
$page_meta_title = "Customer Reviews - NetsDial | 150+ Verified Reviews | Russea™ Net Suppliers Hyderabad";
$page_meta_desc  = "Read 150+ verified customer reviews for NetsDial - India's largest Russea™ safety net suppliers. Rate us and share your experience. 4.9/5 average rating.";
$page_meta_kw    = "netsdial reviews, pigeon net reviews hyderabad, safety net customer reviews, russea net reviews, netsdial ratings";

$per_page  = 15;
$page_num  = max(1, (int)($_GET['page'] ?? 1));
$offset    = ($page_num - 1) * $per_page;
$total     = db()->fetchOne("SELECT COUNT(*) as cnt FROM reviews WHERE is_approved=1")['cnt'] ?? 0;
$reviews   = db()->fetchAll("SELECT * FROM reviews WHERE is_approved=1 ORDER BY is_featured DESC, created_at DESC LIMIT $per_page OFFSET $offset");
$avg_rating= db()->fetchOne("SELECT AVG(rating) as avg FROM reviews WHERE is_approved=1")['avg'] ?? 5;
$pages     = ceil($total / $per_page);

include __DIR__ . '/includes/header.php';
?>

<div class="breadcrumb-bar"><div class="container"><div class="breadcrumb"><a href="/">Home</a><span class="sep"><i class="fas fa-chevron-right"></i></span><span class="current">Customer Reviews</span></div></div></div>

<div class="page-hero">
  <div class="container">
    <h1>Customer <span>Reviews</span></h1>
    <div style="display:flex;align-items:center;justify-content:center;gap:16px;margin-top:16px;flex-wrap:wrap">
      <span style="font-size:3rem;font-weight:900;color:var(--primary-light)"><?php echo number_format($avg_rating, 1); ?></span>
      <div>
        <div style="color:#F59E0B;font-size:1.3rem">★★★★★</div>
        <p style="color:rgba(255,255,255,.8)">Based on <?php echo $total; ?> verified reviews</p>
      </div>
    </div>
  </div>
</div>

<section class="section">
  <div class="container">

    <!-- Rating Summary -->
    <div style="background:var(--white);border:1px solid var(--border);border-radius:var(--radius-xl);padding:36px;margin-bottom:48px;display:grid;grid-template-columns:1fr 2fr;gap:40px;align-items:center" data-aos="fade-up">
      <div style="text-align:center">
        <div style="font-size:5rem;font-weight:900;color:var(--primary);line-height:1"><?php echo number_format($avg_rating, 1); ?></div>
        <div style="color:#F59E0B;font-size:1.8rem;margin:8px 0">★★★★★</div>
        <p style="color:var(--text-light)"><?php echo $total; ?> Reviews</p>
      </div>
      <div>
        <?php
        $star_counts = db()->fetchAll("SELECT rating, COUNT(*) as cnt FROM reviews WHERE is_approved=1 GROUP BY rating ORDER BY rating DESC");
        $star_map = [];
        foreach ($star_counts as $sc) $star_map[$sc['rating']] = $sc['cnt'];
        for ($s = 5; $s >= 1; $s--):
          $cnt = $star_map[$s] ?? 0;
          $pct = $total > 0 ? round(($cnt / $total) * 100) : 0;
        ?>
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px">
          <span style="font-weight:600;white-space:nowrap;min-width:50px"><?php echo $s; ?> ★</span>
          <div style="flex:1;background:var(--light-gray);border-radius:99px;height:10px;overflow:hidden">
            <div style="height:100%;background:#F59E0B;width:<?php echo $pct; ?>%;border-radius:99px;transition:width .5s ease"></div>
          </div>
          <span style="min-width:30px;color:var(--text-light);font-size:.85rem"><?php echo $cnt; ?></span>
        </div>
        <?php endfor; ?>
      </div>
    </div>

    <!-- Reviews Grid -->
    <div class="reviews-grid">
      <?php foreach ($reviews as $rev): ?>
      <div class="review-card" data-aos="fade-up">
        <?php if ($rev['is_featured']): ?>
        <div style="position:absolute;top:14px;right:14px;background:var(--primary);color:var(--white);padding:3px 10px;border-radius:var(--radius-full);font-size:.72rem;font-weight:700"><i class="fas fa-star"></i> Featured</div>
        <?php endif; ?>
        <div class="review-stars">
          <?php for ($i = 1; $i <= 5; $i++): ?><i class="fas fa-star <?php echo $i <= $rev['rating'] ? 'active' : ''; ?>"></i><?php endfor; ?>
        </div>
        <p class="review-text">"<?php echo htmlspecialchars(substr($rev['review_text'], 0, 280)) . (strlen($rev['review_text']) > 280 ? '...' : ''); ?>"</p>
        <?php if ($rev['admin_reply']): ?>
        <div style="background:rgba(255,107,0,.05);border-left:3px solid var(--primary);padding:10px 14px;margin-bottom:14px;border-radius:0 var(--radius-sm) var(--radius-sm) 0;font-size:.85rem">
          <strong style="color:var(--primary)"><i class="fas fa-reply"></i> NetsDial Team:</strong>
          <p style="margin-top:4px;color:var(--text-medium)"><?php echo htmlspecialchars($rev['admin_reply']); ?></p>
        </div>
        <?php endif; ?>
        <div class="reviewer">
          <div class="reviewer-avatar"><?php echo strtoupper(substr($rev['customer_name'], 0, 1)); ?></div>
          <div>
            <div class="reviewer-name"><?php echo htmlspecialchars($rev['customer_name']); ?></div>
            <div class="reviewer-location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($rev['customer_location'] ?: 'India'); ?></div>
            <div class="reviewer-service"><?php echo htmlspecialchars($rev['service_used'] ?: 'NetsDial Customer'); ?></div>
          </div>
          <div style="margin-left:auto;font-size:.75rem;color:var(--text-light)"><?php echo timeAgo($rev['created_at']); ?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if ($pages > 1): ?>
    <div style="display:flex;justify-content:center;gap:8px;margin-top:40px">
      <?php for ($p = 1; $p <= $pages; $p++): ?>
      <a href="?page=<?php echo $p; ?>" style="width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid <?php echo $p == $page_num ? 'var(--primary)' : 'var(--border)'; ?>;color:<?php echo $p == $page_num ? 'var(--white)' : 'var(--text-dark)'; ?>;background:<?php echo $p == $page_num ? 'var(--primary)' : 'var(--white)'; ?>;font-weight:700;transition:all .2s"><?php echo $p; ?></a>
      <?php endfor; ?>
    </div>
    <?php endif; ?>

    <!-- Write Review Form -->
    <div id="write-review" style="margin-top:60px;max-width:700px;margin-left:auto;margin-right:auto">
      <div class="section-header">
        <span class="section-badge"><i class="fas fa-pen"></i> Share Your Experience</span>
        <h2 class="section-title">Write a <span class="highlight">Review</span></h2>
        <p class="section-subtitle">Your feedback helps others make better decisions. Reviews are verified before publishing.</p>
      </div>
      <div class="quick-contact-card">
        <form id="reviewForm" action="/api/review.php" method="POST">
          <input type="text" name="website" style="display:none" tabindex="-1">
          <div style="margin-bottom:20px">
            <label class="fw-600">Your Rating *</label>
            <div class="star-rating" style="margin-top:8px">
              <input type="radio" id="s5" name="rating" value="5" required><label for="s5">★</label>
              <input type="radio" id="s4" name="rating" value="4"><label for="s4">★</label>
              <input type="radio" id="s3" name="rating" value="3"><label for="s3">★</label>
              <input type="radio" id="s2" name="rating" value="2"><label for="s2">★</label>
              <input type="radio" id="s1" name="rating" value="1"><label for="s1">★</label>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group form-icon"><label>Name *</label><i class="fas fa-user"></i><input type="text" name="name" class="form-control" placeholder="Your name" required></div>
            <div class="form-group form-icon"><label>Phone</label><i class="fas fa-phone"></i><input type="tel" name="phone" class="form-control" placeholder="Mobile (optional)"></div>
          </div>
          <div class="form-row">
            <div class="form-group form-icon"><label>Email</label><i class="fas fa-envelope"></i><input type="email" name="email" class="form-control" placeholder="Email (optional)"></div>
            <div class="form-group form-icon"><label>Location</label><i class="fas fa-map-marker-alt"></i><input type="text" name="location" class="form-control" placeholder="Area, City"></div>
          </div>
          <div class="form-group">
            <label>Service Used</label>
            <select name="service" class="form-control">
              <option value="">Select service</option>
              <option>Pigeon Netting</option><option>Balcony Safety Nets</option><option>Children Safety Nets</option>
              <option>Anti Bird Nets</option><option>Pigeon Spikes</option><option>Invisible Grills</option>
              <option>SS Invisible Grills</option><option>Cloth Hangers</option><option>Artificial Grass</option>
              <option>Cricket Nets</option><option>Box Cricket Setup</option><option>Other</option>
            </select>
          </div>
          <div class="form-group">
            <label>Your Review * <span style="color:var(--text-light);font-weight:400">(min 20 chars)</span></label>
            <textarea name="review" class="form-control" rows="5" placeholder="Share your experience with our products and service..." required minlength="20"></textarea>
          </div>
          <button type="submit" class="btn btn-primary w-100 btn-lg"><i class="fas fa-star"></i> Submit Your Review</button>
          <p style="font-size:.78rem;color:var(--text-light);text-align:center;margin-top:10px"><i class="fas fa-shield-alt"></i> Reviews are verified by our team before publishing.</p>
        </form>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
