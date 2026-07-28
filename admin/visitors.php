<?php
define('NETSDIAL', true);
require_once dirname(__DIR__) . '/config/config.php';
requireAdmin();
$admin_page_title = 'Visitor Analytics';

$total     = db()->fetchOne("SELECT COUNT(*) as c FROM visitors")['c'] ?? 0;
$today     = db()->fetchOne("SELECT COUNT(*) as c FROM visitors WHERE DATE(created_at)=CURDATE()")['c'] ?? 0;
$this_week = db()->fetchOne("SELECT COUNT(*) as c FROM visitors WHERE created_at>=DATE_SUB(NOW(),INTERVAL 7 DAY)")['c'] ?? 0;
$live      = db()->fetchOne("SELECT COUNT(*) as c FROM visitors WHERE is_live=1 AND updated_at>=DATE_SUB(NOW(),INTERVAL 2 MINUTE)")['c'] ?? 0;
$mobile    = db()->fetchOne("SELECT COUNT(*) as c FROM visitors WHERE device_type='Mobile'")['c'] ?? 0;
$desktop   = db()->fetchOne("SELECT COUNT(*) as c FROM visitors WHERE device_type='Desktop'")['c'] ?? 0;

$recent_visitors = db()->fetchAll("SELECT * FROM visitors ORDER BY updated_at DESC LIMIT 50");
$live_visitors   = db()->fetchAll("SELECT * FROM visitors WHERE is_live=1 AND updated_at>=DATE_SUB(NOW(),INTERVAL 2 MINUTE) ORDER BY updated_at DESC LIMIT 20");
$top_pages       = db()->fetchAll("SELECT page_url, COUNT(*) as cnt FROM visitor_pages GROUP BY page_url ORDER BY cnt DESC LIMIT 15");
$top_cities      = db()->fetchAll("SELECT city, COUNT(*) as cnt FROM visitors WHERE city!='' GROUP BY city ORDER BY cnt DESC LIMIT 10");
$by_day          = db()->fetchAll("SELECT DATE(created_at) as d, COUNT(*) as c FROM visitors WHERE created_at>=DATE_SUB(NOW(),INTERVAL 30 DAY) GROUP BY DATE(created_at) ORDER BY d");

include __DIR__ . '/includes/admin-header.php';
?>

<div class="admin-stats-grid" style="grid-template-columns:repeat(auto-fill,minmax(180px,1fr))">
  <div class="admin-stat-card" style="--card-color:linear-gradient(135deg,#FF6B00,#FF8C42);--card-icon-bg:rgba(255,107,0,.1);--card-icon-color:#FF6B00">
    <div class="stat-card-icon"><i class="fas fa-users"></i></div>
    <div class="stat-card-info"><div class="stat-card-num"><?php echo number_format(getVisitorCount()); ?></div><div class="stat-card-label">Total Visitors</div></div>
  </div>
  <div class="admin-stat-card" style="--card-color:linear-gradient(135deg,#10B981,#34D399);--card-icon-bg:rgba(16,185,129,.1);--card-icon-color:#10B981">
    <div class="stat-card-icon"><i class="fas fa-circle"></i></div>
    <div class="stat-card-info"><div class="stat-card-num" style="color:#10B981"><?php echo $live; ?></div><div class="stat-card-label">Live Now</div></div>
  </div>
  <div class="admin-stat-card">
    <div class="stat-card-icon" style="background:rgba(59,130,246,.1);color:#3B82F6"><i class="fas fa-calendar-day"></i></div>
    <div class="stat-card-info"><div class="stat-card-num"><?php echo $today; ?></div><div class="stat-card-label">Today</div></div>
  </div>
  <div class="admin-stat-card">
    <div class="stat-card-icon" style="background:rgba(139,92,246,.1);color:#8B5CF6"><i class="fas fa-calendar-week"></i></div>
    <div class="stat-card-info"><div class="stat-card-num"><?php echo $this_week; ?></div><div class="stat-card-label">This Week</div></div>
  </div>
  <div class="admin-stat-card">
    <div class="stat-card-icon" style="background:rgba(245,158,11,.1);color:#F59E0B"><i class="fas fa-mobile-alt"></i></div>
    <div class="stat-card-info"><div class="stat-card-num"><?php echo $mobile; ?></div><div class="stat-card-label">Mobile Users</div></div>
  </div>
  <div class="admin-stat-card">
    <div class="stat-card-icon" style="background:rgba(20,184,166,.1);color:#14B8A6"><i class="fas fa-desktop"></i></div>
    <div class="stat-card-info"><div class="stat-card-num"><?php echo $desktop; ?></div><div class="stat-card-label">Desktop Users</div></div>
  </div>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:24px">
  <!-- Recent Visitors -->
  <div class="admin-card">
    <div class="admin-card-header">
      <div class="admin-card-title"><i class="fas fa-history"></i> Recent Visitors</div>
      <span class="status-badge badge-success"><?php echo $live; ?> Live</span>
    </div>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead><tr><th>Status</th><th>Location</th><th>Device</th><th>Pages</th><th>Time</th><th>Visited</th></tr></thead>
        <tbody>
          <?php foreach ($recent_visitors as $v): ?>
          <tr>
            <td><?php if ($v['is_live']): ?><span class="visitor-dot"></span><?php else: ?><span style="width:8px;height:8px;border-radius:50%;background:#CBD5E1;display:inline-block"></span><?php endif; ?></td>
            <td>
              <div style="font-size:.85rem;font-weight:600"><?php echo htmlspecialchars(($v['city']?:'-') . ', ' . ($v['country']?:'India')); ?></div>
              <div style="font-size:.72rem;color:var(--text-light)"><?php echo htmlspecialchars($v['ip_address']); ?></div>
              <?php if ($v['latitude'] && $v['longitude']): ?>
              <div style="font-size:.7rem;color:var(--primary)"><?php echo $v['latitude']; ?>, <?php echo $v['longitude']; ?></div>
              <?php endif; ?>
            </td>
            <td><span class="status-badge badge-info" style="font-size:.7rem"><?php echo htmlspecialchars($v['device_type']?:'?'); ?></span></td>
            <td><?php echo $v['pages_visited']; ?></td>
            <td style="font-size:.78rem"><?php echo round($v['time_spent']/60,1); ?>m</td>
            <td style="font-size:.78rem;color:var(--text-light)"><?php echo timeAgo($v['created_at']); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Right Column -->
  <div>
    <!-- Top Pages -->
    <div class="admin-card mb-24">
      <div class="admin-card-header"><div class="admin-card-title"><i class="fas fa-chart-bar"></i> Top Pages</div></div>
      <div class="admin-card-body">
        <?php foreach ($top_pages as $tp): ?>
        <div style="margin-bottom:10px">
          <div style="display:flex;justify-content:space-between;margin-bottom:4px;font-size:.82rem">
            <span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;flex:1;color:var(--text-medium)"><?php echo htmlspecialchars(parse_url($tp['page_url'],PHP_URL_PATH)?:'/'); ?></span>
            <strong style="margin-left:8px"><?php echo $tp['cnt']; ?></strong>
          </div>
          <div style="background:var(--border);border-radius:99px;height:5px;overflow:hidden">
            <div style="height:100%;background:var(--primary);width:<?php echo min(100, round($tp['cnt'] / max(1,$top_pages[0]['cnt']) * 100)); ?>%;border-radius:99px"></div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Top Cities -->
    <div class="admin-card">
      <div class="admin-card-header"><div class="admin-card-title"><i class="fas fa-map-marker-alt"></i> Top Cities</div></div>
      <div class="admin-card-body">
        <?php foreach ($top_cities as $tc): ?>
        <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border);font-size:.88rem">
          <span><?php echo htmlspecialchars($tc['city']); ?></span>
          <strong><?php echo $tc['cnt']; ?></strong>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<!-- Auto-refresh live count -->
<script>
setInterval(() => {
  fetch('/api/visitor.php?action=live_count')
    .then(r=>r.json())
    .then(d => { /* update if needed */ });
}, 30000);
</script>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
