<?php
/**
 * NetsDial Admin - Dashboard
 */
define('NETSDIAL', true);
require_once dirname(__DIR__) . '/config/config.php';
requireAdmin();

$admin_page_title = 'Dashboard';

// Stats
$total_contacts  = db()->fetchOne("SELECT COUNT(*) as c FROM contacts")['c'] ?? 0;
$unread_contacts = db()->fetchOne("SELECT COUNT(*) as c FROM contacts WHERE is_read=0")['c'] ?? 0;
$total_reviews   = db()->fetchOne("SELECT COUNT(*) as c FROM reviews WHERE is_approved=1")['c'] ?? 0;
$pending_reviews = db()->fetchOne("SELECT COUNT(*) as c FROM reviews WHERE is_approved=0")['c'] ?? 0;
$total_blogs     = db()->fetchOne("SELECT COUNT(*) as c FROM blogs WHERE is_published=1")['c'] ?? 0;
$total_visitors  = db()->fetchOne("SELECT COUNT(*) as c FROM visitors")['c'] ?? 0;
$live_visitors   = db()->fetchOne("SELECT COUNT(*) as c FROM visitors WHERE is_live=1 AND updated_at >= DATE_SUB(NOW(), INTERVAL 2 MINUTE)")['c'] ?? 0;
$today_visitors  = db()->fetchOne("SELECT COUNT(*) as c FROM visitors WHERE DATE(created_at)=CURDATE()")['c'] ?? 0;
$total_gallery   = db()->fetchOne("SELECT COUNT(*) as c FROM gallery WHERE is_active=1")['c'] ?? 0;
$total_offers    = db()->fetchOne("SELECT COUNT(*) as c FROM offers WHERE is_active=1")['c'] ?? 0;
$visitor_count   = getVisitorCount();

// Recent contacts
$recent_contacts = db()->fetchAll("SELECT * FROM contacts ORDER BY created_at DESC LIMIT 8");
// Recent reviews
$recent_reviews  = db()->fetchAll("SELECT * FROM reviews ORDER BY created_at DESC LIMIT 5");
// Live visitors
$live_list       = db()->fetchAll("SELECT * FROM visitors WHERE is_live=1 AND updated_at >= DATE_SUB(NOW(), INTERVAL 2 MINUTE) ORDER BY updated_at DESC LIMIT 10");
// Traffic by day (last 7 days)
$traffic_days = db()->fetchAll("SELECT DATE(created_at) as d, COUNT(*) as c FROM visitors WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) GROUP BY DATE(created_at) ORDER BY d");

include __DIR__ . '/includes/admin-header.php';
?>

<?php if (isset($_GET['msg'])): ?>
<div class="admin-alert admin-alert-success" data-auto-dismiss>
  <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($_GET['msg']); ?>
</div>
<?php endif; ?>

<!-- ── Stats Grid ─────────────────────────────────────────── -->
<div class="admin-stats-grid">
  <div class="admin-stat-card" style="--card-color:linear-gradient(135deg,#FF6B00,#FF8C42);--card-icon-bg:rgba(255,107,0,.1);--card-icon-color:#FF6B00">
    <div class="stat-card-icon"><i class="fas fa-users"></i></div>
    <div class="stat-card-info">
      <div class="stat-card-num"><?php echo number_format($visitor_count); ?></div>
      <div class="stat-card-label">Total Visitors</div>
      <div class="stat-card-change up"><i class="fas fa-arrow-up"></i> <?php echo $today_visitors; ?> today</div>
    </div>
  </div>
  <div class="admin-stat-card" style="--card-color:linear-gradient(135deg,#10B981,#34D399);--card-icon-bg:rgba(16,185,129,.1);--card-icon-color:#10B981">
    <div class="stat-card-icon"><i class="fas fa-circle"></i></div>
    <div class="stat-card-info">
      <div class="stat-card-num" style="color:#10B981"><?php echo $live_visitors; ?></div>
      <div class="stat-card-label">Live Visitors Now</div>
      <div class="stat-card-change up"><i class="fas fa-signal"></i> Real-time</div>
    </div>
  </div>
  <div class="admin-stat-card" style="--card-color:linear-gradient(135deg,#3B82F6,#60A5FA);--card-icon-bg:rgba(59,130,246,.1);--card-icon-color:#3B82F6">
    <div class="stat-card-icon"><i class="fas fa-envelope"></i></div>
    <div class="stat-card-info">
      <div class="stat-card-num"><?php echo $total_contacts; ?></div>
      <div class="stat-card-label">Total Enquiries</div>
      <div class="stat-card-change" style="color:#3B82F6"><?php echo $unread_contacts; ?> unread</div>
    </div>
  </div>
  <div class="admin-stat-card" style="--card-color:linear-gradient(135deg,#F59E0B,#FCD34D);--card-icon-bg:rgba(245,158,11,.1);--card-icon-color:#F59E0B">
    <div class="stat-card-icon"><i class="fas fa-star"></i></div>
    <div class="stat-card-info">
      <div class="stat-card-num"><?php echo $total_reviews; ?></div>
      <div class="stat-card-label">Published Reviews</div>
      <div class="stat-card-change" style="color:#F59E0B"><?php echo $pending_reviews; ?> pending</div>
    </div>
  </div>
  <div class="admin-stat-card" style="--card-color:linear-gradient(135deg,#8B5CF6,#A78BFA);--card-icon-bg:rgba(139,92,246,.1);--card-icon-color:#8B5CF6">
    <div class="stat-card-icon"><i class="fas fa-blog"></i></div>
    <div class="stat-card-info">
      <div class="stat-card-num"><?php echo $total_blogs; ?></div>
      <div class="stat-card-label">Published Blogs</div>
    </div>
  </div>
  <div class="admin-stat-card" style="--card-color:linear-gradient(135deg,#EF4444,#F87171);--card-icon-bg:rgba(239,68,68,.1);--card-icon-color:#EF4444">
    <div class="stat-card-icon"><i class="fas fa-images"></i></div>
    <div class="stat-card-info">
      <div class="stat-card-num"><?php echo $total_gallery; ?></div>
      <div class="stat-card-label">Gallery Images</div>
    </div>
  </div>
  <div class="admin-stat-card" style="--card-color:linear-gradient(135deg,#14B8A6,#5EEAD4);--card-icon-bg:rgba(20,184,166,.1);--card-icon-color:#14B8A6">
    <div class="stat-card-icon"><i class="fas fa-tags"></i></div>
    <div class="stat-card-info">
      <div class="stat-card-num"><?php echo $total_offers; ?></div>
      <div class="stat-card-label">Active Offers</div>
    </div>
  </div>
  <div class="admin-stat-card" style="--card-color:linear-gradient(135deg,#F97316,#FB923C);--card-icon-bg:rgba(249,115,22,.1);--card-icon-color:#F97316">
    <div class="stat-card-icon"><i class="fas fa-file-alt"></i></div>
    <div class="stat-card-info">
      <div class="stat-card-num">2,850+</div>
      <div class="stat-card-label">Service Pages</div>
    </div>
  </div>
</div>

<!-- ── Quick Actions ──────────────────────────────────────── -->
<div class="admin-card mb-24">
  <div class="admin-card-header">
    <div class="admin-card-title"><i class="fas fa-bolt"></i> Quick Actions</div>
  </div>
  <div class="admin-card-body">
    <div style="display:flex;gap:12px;flex-wrap:wrap">
      <a href="blogs.php?action=new" class="btn-admin btn-admin-primary"><i class="fas fa-plus"></i> New Blog Post</a>
      <a href="offers.php?action=new" class="btn-admin btn-admin-warning"><i class="fas fa-tag"></i> Create Offer</a>
      <a href="quotations.php?action=new" class="btn-admin btn-admin-success"><i class="fas fa-file-invoice"></i> New Quotation</a>
      <a href="gallery.php?action=upload" class="btn-admin btn-admin-info"><i class="fas fa-upload"></i> Upload Images</a>
      <a href="sliders.php" class="btn-admin btn-admin-secondary"><i class="fas fa-images"></i> Manage Sliders</a>
      <a href="seo.php" class="btn-admin btn-admin-secondary"><i class="fas fa-search"></i> SEO Manager</a>
      <a href="settings.php" class="btn-admin btn-admin-secondary"><i class="fas fa-cog"></i> Settings</a>
      <a href="/" target="_blank" class="btn-admin btn-admin-secondary"><i class="fas fa-external-link-alt"></i> View Website</a>
    </div>
  </div>
</div>

<!-- ── Main Grid ──────────────────────────────────────────── -->
<div style="display:grid;grid-template-columns:2fr 1fr;gap:24px">

  <!-- Recent Enquiries -->
  <div class="admin-card">
    <div class="admin-card-header">
      <div class="admin-card-title"><i class="fas fa-envelope"></i> Recent Enquiries</div>
      <a href="contacts.php" class="btn-admin btn-admin-secondary btn-admin-sm">View All</a>
    </div>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr><th>Name</th><th>Phone</th><th>Service</th><th>Location</th><th>Status</th><th>Time</th><th></th></tr>
        </thead>
        <tbody>
          <?php foreach ($recent_contacts as $c): ?>
          <tr>
            <td><strong><?php echo htmlspecialchars($c['name']); ?></strong></td>
            <td><a href="tel:+91<?php echo htmlspecialchars($c['phone']); ?>" style="color:var(--primary)"><?php echo htmlspecialchars($c['phone']); ?></a></td>
            <td><span style="font-size:.8rem"><?php echo htmlspecialchars(substr($c['service'] ?: 'General', 0, 25)); ?></span></td>
            <td><span style="font-size:.8rem;color:var(--text-light)"><?php echo htmlspecialchars(substr($c['location'] ?: '-', 0, 20)); ?></span></td>
            <td>
              <span class="status-badge <?php echo $c['is_read'] ? 'badge-success' : 'badge-warning'; ?>">
                <?php echo $c['is_read'] ? 'Read' : 'New'; ?>
              </span>
            </td>
            <td style="font-size:.78rem;color:var(--text-light)"><?php echo timeAgo($c['created_at']); ?></td>
            <td>
              <a href="contacts.php?id=<?php echo $c['id']; ?>" class="btn-admin btn-admin-info btn-admin-sm btn-admin-icon"><i class="fas fa-eye"></i></a>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php if (empty($recent_contacts)): ?>
          <tr><td colspan="7" style="text-align:center;color:var(--text-light);padding:30px">No enquiries yet</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Live Visitors + Pending Reviews -->
  <div>
    <!-- Live Visitors -->
    <div class="admin-card mb-24">
      <div class="admin-card-header">
        <div class="admin-card-title"><i class="fas fa-circle" style="color:#10B981;font-size:.7rem"></i> Live Visitors (<?php echo $live_visitors; ?>)</div>
        <a href="visitors.php" class="btn-admin btn-admin-secondary btn-admin-sm">Details</a>
      </div>
      <div class="admin-card-body" style="max-height:280px;overflow-y:auto">
        <?php if (!empty($live_list)): ?>
          <?php foreach ($live_list as $v): ?>
          <div class="visitor-row">
            <div class="visitor-dot"></div>
            <div style="flex:1;min-width:0">
              <div class="visitor-page"><?php echo htmlspecialchars(parse_url($v['last_page'] ?? '/', PHP_URL_PATH)); ?></div>
              <div class="visitor-location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars(($v['city'] ?: 'Unknown') . ', ' . ($v['country'] ?: 'India')); ?> | <?php echo htmlspecialchars($v['device_type'] ?? 'Unknown'); ?></div>
            </div>
            <div class="visitor-time"><?php echo round(($v['time_spent'] ?? 0) / 60, 1); ?>m</div>
          </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p style="text-align:center;color:var(--text-light);padding:20px">No live visitors right now</p>
        <?php endif; ?>
      </div>
    </div>

    <!-- Pending Reviews -->
    <div class="admin-card">
      <div class="admin-card-header">
        <div class="admin-card-title"><i class="fas fa-star"></i> Pending Reviews (<?php echo $pending_reviews; ?>)</div>
        <a href="reviews.php?filter=pending" class="btn-admin btn-admin-secondary btn-admin-sm">View All</a>
      </div>
      <div class="admin-card-body">
        <?php foreach ($recent_reviews as $r): ?>
        <div style="padding:10px 0;border-bottom:1px solid var(--border)">
          <div style="display:flex;justify-content:space-between;margin-bottom:4px">
            <strong style="font-size:.88rem"><?php echo htmlspecialchars($r['customer_name']); ?></strong>
            <span class="status-badge <?php echo $r['is_approved'] ? 'badge-success' : 'badge-warning'; ?>"><?php echo $r['is_approved'] ? 'Approved' : 'Pending'; ?></span>
          </div>
          <div class="stars-display" style="font-size:.8rem"><?php echo str_repeat('★', $r['rating']); ?></div>
          <p style="font-size:.82rem;color:var(--text-light);margin-top:4px"><?php echo htmlspecialchars(substr($r['review_text'], 0, 80)); ?>...</p>
          <?php if (!$r['is_approved']): ?>
          <div style="display:flex;gap:6px;margin-top:8px">
            <a href="reviews.php?approve=<?php echo $r['id']; ?>" class="btn-admin btn-admin-success btn-admin-sm"><i class="fas fa-check"></i> Approve</a>
            <a href="reviews.php?delete=<?php echo $r['id']; ?>" class="btn-admin btn-admin-danger btn-admin-sm" data-confirm="Delete this review?"><i class="fas fa-trash"></i></a>
          </div>
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
        <?php if (empty($recent_reviews)): ?>
        <p style="text-align:center;color:var(--text-light);padding:16px">No reviews yet</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- ── SEO Quick Tips ──────────────────────────────────────── -->
<div class="admin-card mt-24">
  <div class="admin-card-header">
    <div class="admin-card-title"><i class="fas fa-lightbulb" style="color:#F59E0B"></i> SEO Suggestions & Quick Tips</div>
  </div>
  <div class="admin-card-body">
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px">
      <?php
      $seo_tips = [
        ['fa-file-alt','Create Local Content','Add blog posts targeting "Pigeon netting in [Area]" for every location page to boost ranking.'],
        ['fa-star','Get More Reviews','Email verified customers to leave Google reviews. More reviews = better local SEO ranking.'],
        ['fa-sitemap','Submit Sitemap','Submit your sitemap.xml to Google Search Console for faster indexing of all 2850+ pages.'],
        ['fa-mobile-alt','Mobile Speed','Ensure all service pages load in under 3 seconds on mobile. Use WebP images.'],
        ['fa-link','Internal Linking','Each service page should link to 5+ related service pages. This improves crawl depth.'],
        ['fa-map-marker-alt','Google Business','Keep Google Business Profile updated with latest photos, posts and responses.'],
        ['fa-share-alt','Social Signals','Share new blog posts on Facebook, Instagram. Social signals help SEO indirectly.'],
        ['fa-chart-line','Track Rankings','Check keyword positions weekly using Google Search Console. Target position 1-3.'],
      ];
      foreach ($seo_tips as $t): ?>
      <div style="padding:16px;background:var(--off-white);border-radius:var(--radius);border:1px solid var(--border)">
        <div style="display:flex;align-items:flex-start;gap:12px">
          <i class="fas <?php echo $t[0]; ?>" style="color:var(--primary);margin-top:2px;font-size:1rem"></i>
          <div>
            <div style="font-weight:700;font-size:.88rem;margin-bottom:4px"><?php echo $t[1]; ?></div>
            <div style="font-size:.8rem;color:var(--text-medium)"><?php echo $t[2]; ?></div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div style="margin-top:20px;padding:16px;background:rgba(255,107,0,.05);border:1px solid rgba(255,107,0,.15);border-radius:var(--radius)">
      <strong style="color:var(--primary)"><i class="fas fa-trophy"></i> Your SEO Goal:</strong>
      <p style="font-size:.9rem;margin-top:4px">Rank #1 for "Pigeon Netting in [every area of Hyderabad]", "Safety Nets Hyderabad", "Bird Netting Vizag", and all service+location combinations across Telangana & Andhra Pradesh.</p>
    </div>
  </div>
</div>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
