<?php
defined('NETSDIAL') or die('Direct access not allowed');
requireAdmin();
$admin_name = $_SESSION['admin_name'] ?? 'Admin';
$admin_role = $_SESSION['admin_role'] ?? 'admin';
$current    = basename($_SERVER['PHP_SELF']);

// Unread contacts count
$unread_contacts = db()->fetchOne("SELECT COUNT(*) as cnt FROM contacts WHERE is_read=0")['cnt'] ?? 0;
$pending_reviews = db()->fetchOne("SELECT COUNT(*) as cnt FROM reviews WHERE is_approved=0")['cnt'] ?? 0;
$live_visitors   = db()->fetchOne("SELECT COUNT(*) as cnt FROM visitors WHERE is_live=1 AND updated_at >= DATE_SUB(NOW(), INTERVAL 2 MINUTE)")['cnt'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $admin_page_title ?? 'Admin Panel'; ?> - NetsDial Admin</title>
  <meta name="robots" content="noindex, nofollow">
  <link rel="icon" type="image/png" href="/assets/images/favicon.png">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="/assets/css/admin.css">
  <?php echo $admin_extra_css ?? ''; ?>
</head>
<body class="admin-body">

<!-- Sidebar -->
<aside class="admin-sidebar" id="adminSidebar">
  <div class="sidebar-header">
    <img src="/assets/images/logo.png" alt="NetsDial" class="sidebar-logo" onerror="this.src='/assets/images/favicon.png'">
    <button class="sidebar-close" onclick="toggleSidebar()"><i class="fas fa-times"></i></button>
  </div>

  <div class="sidebar-admin-info">
    <div class="admin-avatar"><?php echo strtoupper(substr($admin_name, 0, 1)); ?></div>
    <div>
      <div class="admin-name"><?php echo htmlspecialchars($admin_name); ?></div>
      <div class="admin-role-badge"><?php echo ucfirst($admin_role); ?></div>
    </div>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-section-title">Main</div>
    <a href="/admin/" class="nav-item <?php echo $current === 'index.php' ? 'active' : ''; ?>">
      <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
    </a>
    <a href="/admin/visitors.php" class="nav-item <?php echo $current === 'visitors.php' ? 'active' : ''; ?>">
      <i class="fas fa-users"></i><span>Visitors</span>
      <?php if ($live_visitors > 0): ?><span class="badge badge-green"><?php echo $live_visitors; ?> Live</span><?php endif; ?>
    </a>
    <a href="/admin/contacts.php" class="nav-item <?php echo $current === 'contacts.php' ? 'active' : ''; ?>">
      <i class="fas fa-envelope"></i><span>Contacts</span>
      <?php if ($unread_contacts > 0): ?><span class="badge"><?php echo $unread_contacts; ?></span><?php endif; ?>
    </a>

    <div class="nav-section-title">Content</div>
    <a href="/admin/reviews.php" class="nav-item <?php echo $current === 'reviews.php' ? 'active' : ''; ?>">
      <i class="fas fa-star"></i><span>Reviews</span>
      <?php if ($pending_reviews > 0): ?><span class="badge badge-orange"><?php echo $pending_reviews; ?></span><?php endif; ?>
    </a>
    <a href="/admin/blogs.php" class="nav-item <?php echo $current === 'blogs.php' ? 'active' : ''; ?>">
      <i class="fas fa-blog"></i><span>Blogs</span>
    </a>
    <a href="/admin/gallery.php" class="nav-item <?php echo $current === 'gallery.php' ? 'active' : ''; ?>">
      <i class="fas fa-images"></i><span>Gallery</span>
    </a>
    <a href="/admin/videos.php" class="nav-item <?php echo $current === 'videos.php' ? 'active' : ''; ?>">
      <i class="fas fa-video"></i><span>Videos</span>
    </a>
    <a href="/admin/sliders.php" class="nav-item <?php echo $current === 'sliders.php' ? 'active' : ''; ?>">
      <i class="fas fa-images"></i><span>Sliders</span>
    </a>
    <a href="/admin/offers.php" class="nav-item <?php echo $current === 'offers.php' ? 'active' : ''; ?>">
      <i class="fas fa-tags"></i><span>Offers & Coupons</span>
    </a>

    <div class="nav-section-title">Business</div>
    <a href="/admin/quotations.php" class="nav-item <?php echo $current === 'quotations.php' ? 'active' : ''; ?>">
      <i class="fas fa-file-invoice"></i><span>Quotations / Bills</span>
    </a>
    <a href="/admin/estimation-rates.php" class="nav-item <?php echo $current === 'estimation-rates.php' ? 'active' : ''; ?>">
      <i class="fas fa-calculator"></i><span>Estimation Rates</span>
    </a>
    <a href="/admin/floor-plans.php" class="nav-item <?php echo $current === 'floor-plans.php' ? 'active' : ''; ?>">
      <i class="fas fa-drafting-compass"></i><span>Floor Plan Builder</span>
    </a>

    <div class="nav-section-title">Site Management</div>
    <a href="/admin/seo.php" class="nav-item <?php echo $current === 'seo.php' ? 'active' : ''; ?>">
      <i class="fas fa-search"></i><span>SEO Manager</span>
    </a>
    <a href="/admin/settings.php" class="nav-item <?php echo $current === 'settings.php' ? 'active' : ''; ?>">
      <i class="fas fa-cog"></i><span>Site Settings</span>
    </a>
    <a href="/admin/users.php" class="nav-item <?php echo $current === 'users.php' ? 'active' : ''; ?>">
      <i class="fas fa-user-shield"></i><span>Admin Users</span>
    </a>

    <div style="margin-top:20px;padding:0 12px">
      <a href="/" target="_blank" class="nav-item" style="background:rgba(255,107,0,.1);color:var(--primary)">
        <i class="fas fa-external-link-alt"></i><span>View Website</span>
      </a>
      <a href="/admin/logout.php" class="nav-item" style="color:#EF4444;background:rgba(239,68,68,.08)">
        <i class="fas fa-sign-out-alt"></i><span>Logout</span>
      </a>
    </div>
  </nav>
</aside>

<!-- Sidebar Overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- Main Content -->
<div class="admin-main">
  <!-- Top Bar -->
  <header class="admin-topbar">
    <button class="topbar-toggle" onclick="toggleSidebar()">
      <i class="fas fa-bars"></i>
    </button>
    <div class="topbar-title"><?php echo $admin_page_title ?? 'Dashboard'; ?></div>
    <div class="topbar-right">
      <div class="topbar-stat"><i class="fas fa-circle" style="color:#4ade80;font-size:.6rem"></i> <?php echo $live_visitors; ?> Live</div>
      <?php if ($unread_contacts > 0): ?>
      <a href="/admin/contacts.php" class="topbar-notif"><i class="fas fa-envelope"></i><span><?php echo $unread_contacts; ?></span></a>
      <?php endif; ?>
      <?php if ($pending_reviews > 0): ?>
      <a href="/admin/reviews.php" class="topbar-notif" style="background:#F59E0B"><i class="fas fa-star"></i><span><?php echo $pending_reviews; ?></span></a>
      <?php endif; ?>
      <span class="topbar-admin"><i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($admin_name); ?></span>
    </div>
  </header>

  <div class="admin-content">
