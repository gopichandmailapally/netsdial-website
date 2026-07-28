<?php
defined('NETSDIAL') or die('Direct access not allowed');

$current_page = basename($_SERVER['PHP_SELF']);
$page_url     = $_SERVER['REQUEST_URI'] ?? '/';

// Settings
$site_name    = getSetting('site_name', 'NetsDial');
$site_phone   = getSetting('site_phone', '9966499144');
$site_email   = getSetting('site_email', 'netsdial@gmail.com');
$logo_path    = getSetting('logo_path', 'assets/images/logo.png');
$favicon_path = getSetting('favicon_path', 'assets/images/favicon.png');

// Page meta (individual pages may override)
$page_title       = $page_title       ?? getSetting('meta_title', 'NetsDial – India\'s Largest Russea™ HDPE Net Wholesale Supplier | Hyderabad');
$page_description = $page_description ?? getSetting('meta_description', 'NetsDial by GCM Enterprises is India\'s #1 wholesale supplier of Russea™ HDPE pigeon nets, balcony safety nets, cricket nets, invisible grills and artificial grass. Supplying entire India from Hyderabad.');
$page_keywords    = $page_keywords    ?? getSetting('meta_keywords', 'pigeon net wholesale hyderabad, russea hdpe nets, safety net suppliers india, cricket net wholesale, balcony safety net hyderabad, invisible grill supplier, gcm enterprises');
$page_og_image    = $page_og_image    ?? SITE_URL . '/assets/images/og-image.jpg';

// Canonical URL
$canonical = SITE_URL . strtok($page_url, '?');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- Primary SEO -->
<title><?php echo htmlspecialchars($page_title); ?></title>
<meta name="description" content="<?php echo htmlspecialchars($page_description); ?>">
<meta name="keywords"    content="<?php echo htmlspecialchars($page_keywords); ?>">
<meta name="author"      content="NetsDial - GCM Enterprises, Hyderabad">
<meta name="robots"      content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
<link rel="canonical"    href="<?php echo $canonical; ?>">

<!-- Geo Targeting – India-wide with Hyderabad origin -->
<meta name="geo.region"        content="IN-TG">
<meta name="geo.placename"     content="Hyderabad, Telangana, India">
<meta name="geo.position"      content="17.3850;78.4867">
<meta name="ICBM"              content="17.3850, 78.4867">
<meta name="coverage"          content="India">
<meta name="distribution"      content="Global">
<meta name="target"            content="all">
<meta name="HandheldFriendly"  content="True">
<meta name="MobileOptimized"   content="320">

<!-- Open Graph -->
<meta property="og:type"        content="website">
<meta property="og:locale"      content="en_IN">
<meta property="og:site_name"   content="NetsDial – Russea™ Net Suppliers India">
<meta property="og:title"       content="<?php echo htmlspecialchars($page_title); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars($page_description); ?>">
<meta property="og:image"       content="<?php echo $page_og_image; ?>">
<meta property="og:url"         content="<?php echo $canonical; ?>">

<!-- Twitter Card -->
<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:site"        content="@netsdial">
<meta name="twitter:title"       content="<?php echo htmlspecialchars($page_title); ?>">
<meta name="twitter:description" content="<?php echo htmlspecialchars($page_description); ?>">
<meta name="twitter:image"       content="<?php echo $page_og_image; ?>">

<!-- Favicon -->
<link rel="icon"             type="image/png" href="<?php echo SITE_URL.'/'.$favicon_path; ?>">
<link rel="apple-touch-icon"                  href="<?php echo SITE_URL.'/'.$favicon_path; ?>">

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<!-- Icon & Animation libraries -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.css">

<!-- Site CSS -->
<link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
<link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/menu.css">

<!-- Schema.org – Organization / WholesaleStore -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": ["Organization", "Store"],
  "name": "NetsDial",
  "alternateName": ["GCM Enterprises", "Russea™ Net Suppliers", "NetsDial Hyderabad"],
  "url": "<?php echo SITE_URL; ?>",
  "logo": "<?php echo SITE_URL.'/'.$logo_path; ?>",
  "image": "<?php echo SITE_URL; ?>/assets/images/og-image.jpg",
  "description": "India's largest wholesale supplier of Russea™ HDPE pigeon nets, balcony safety nets, bird control nets, cricket nets, invisible grills and artificial grass. Managed by GCM Enterprises, Hyderabad. Supplying dealers and businesses PAN India.",
  "telephone": "+91<?php echo $site_phone; ?>",
  "email": "<?php echo $site_email; ?>",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Plot No.91, Road Number 2, Sri Ram Nagar Colony, Karmanghat, Saroornagar",
    "addressLocality": "Hyderabad",
    "addressRegion": "Telangana",
    "postalCode": "500035",
    "addressCountry": "IN"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": "17.3850",
    "longitude": "78.4867"
  },
  "openingHoursSpecification": [
    { "@type": "OpeningHoursSpecification", "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"], "opens": "09:00", "closes": "20:00" }
  ],
  "priceRange": "₹₹",
  "areaServed": {
    "@type": "Country",
    "name": "India"
  },
  "hasOfferCatalog": {
    "@type": "OfferCatalog",
    "name": "Russea™ HDPE Net Products",
    "itemListElement": [
      {"@type":"Offer","itemOffered":{"@type":"Product","name":"Russea™ HDPE Pigeon Nets – Wholesale"}},
      {"@type":"Offer","itemOffered":{"@type":"Product","name":"Russea™ Balcony Safety Nets – Wholesale"}},
      {"@type":"Offer","itemOffered":{"@type":"Product","name":"Russea™ Cricket Nets – Wholesale"}},
      {"@type":"Offer","itemOffered":{"@type":"Product","name":"Russea™ Bird Control Nets – Wholesale"}},
      {"@type":"Offer","itemOffered":{"@type":"Product","name":"Russea™ Artificial Grass – Wholesale"}}
    ]
  },
  "sameAs": [
    "<?php echo getSetting('facebook_url','#'); ?>",
    "<?php echo getSetting('instagram_url','#'); ?>",
    "<?php echo getSetting('youtube_url','#'); ?>"
  ],
  "brand": {
    "@type": "Brand",
    "name": "Russea™",
    "description": "Registered trademark HDPE net brand. Braided, Twisted and Knotted HDPE nets."
  }
}
</script>

<?php echo getSetting('google_analytics', ''); ?>
<meta name="google-site-verification" content="<?php echo getSetting('google_search_console',''); ?>">
</head>
<body>

<!-- ── Top Bar ──────────────────────────────────────────────── -->
<div class="top-bar">
  <div class="container">
    <div class="top-bar-left">
      <a href="tel:+91<?php echo $site_phone; ?>" class="top-contact">
        <i class="fas fa-phone-alt"></i>
        <span>+91 <?php echo chunk_split($site_phone, 5, ' '); ?></span>
      </a>
      <a href="mailto:<?php echo $site_email; ?>" class="top-contact">
        <i class="fas fa-envelope"></i>
        <span><?php echo $site_email; ?></span>
      </a>
      <span class="top-contact top-address-hide">
        <i class="fas fa-map-marker-alt"></i>
        <span>Karmanghat, Hyderabad – 500035</span>
      </span>
    </div>
    <div class="top-bar-right">
      <span class="top-badge top-badge-brand">
        <i class="fas fa-trademark"></i> Russea™ Authorised Wholesale Supplier
      </span>
      <span class="top-badge">
        <i class="fas fa-truck"></i> PAN India Delivery
      </span>
      <span class="top-badge top-badge-hide">
        <i class="fas fa-award"></i> Largest from South India
      </span>
      <a href="<?php echo SITE_WHATSAPP; ?>" target="_blank" rel="noopener" class="top-whatsapp">
        <i class="fab fa-whatsapp"></i> WhatsApp
      </a>
    </div>
  </div>
</div>

<!-- ── Marquee ─────────────────────────────────────────────── -->
<div class="marquee-bar">
  <div class="marquee-content" aria-hidden="true">
    <?php
    $marquee_default = '🏆 India\'s Largest Russea™ HDPE Net Wholesale Supplier &nbsp;|&nbsp; 🚛 PAN India Delivery &nbsp;|&nbsp; 🏅 Russea™ Authorised Wholesale Dealers &nbsp;|&nbsp; 🏏 Largest Cricket Net Suppliers from South India &nbsp;|&nbsp; 🛡️ HDPE Braided, Twisted &amp; Knotted Nets &nbsp;|&nbsp; 📞 Call +91 9966499144 for Wholesale Pricing &nbsp;|&nbsp; 🌐 Supplying All 28 States &amp; UTs &nbsp;|&nbsp; ⚡ 10,000+ Dealer Network PAN India &nbsp;|&nbsp; 🏆 GCM Enterprises – Trusted Since 2013';
    $marquee_text = getSetting('marquee_text', $marquee_default);
    ?>
    <span><?php echo $marquee_text; ?></span>
    <span aria-hidden="true"><?php echo $marquee_text; ?></span>
  </div>
</div>

<!-- ── Header / Navbar ─────────────────────────────────────── -->
<header class="site-header" id="siteHeader">
  <div class="container">
    <div class="header-inner">

      <!-- Logo -->
      <a href="<?php echo SITE_URL; ?>/" class="site-logo" title="NetsDial – Russea™ HDPE Net Wholesale Suppliers">
        <img src="<?php echo SITE_URL.'/'.$logo_path; ?>"
             alt="NetsDial – Russea™ Net Wholesale Suppliers Hyderabad India"
             width="200" height="60" loading="eager">
      </a>

      <!-- Mobile Toggle -->
      <button class="nav-toggle" id="navToggle" aria-label="Toggle Navigation" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>

      <!-- Navigation -->
      <nav class="main-nav" id="mainNav" role="navigation" aria-label="Main Navigation">
        <ul class="nav-list">
          <li class="nav-item <?php echo ($current_page=='index.php'||$page_url=='/')?'active':''; ?>">
            <a href="<?php echo SITE_URL; ?>/" class="nav-link"><i class="fas fa-home"></i> Home</a>
          </li>
          <li class="nav-item <?php echo $current_page=='about.php'?'active':''; ?>">
            <a href="<?php echo SITE_URL; ?>/about.php" class="nav-link"><i class="fas fa-info-circle"></i> About</a>
          </li>

          <!-- ── SERVICES: 4-Level Mega Menu ── -->
          <li class="nav-item has-mega <?php echo (str_contains($page_url,'/services/')||$current_page=='services.php')?'active':''; ?>">
            <a href="<?php echo SITE_URL; ?>/services.php" class="nav-link">
              <i class="fas fa-shield-alt"></i> Services <i class="fas fa-chevron-down arrow-icon"></i>
            </a>

            <div class="mega-menu" id="megaMenu" role="region" aria-label="Services Menu">
              <div class="mega-inner">

                <!-- Quick Services Grid -->
                <div class="mega-quick-services">
                  <h4 class="mega-section-title">
                    <i class="fas fa-star" style="color:#FF6B00"></i>
                    Russea™ Products – Wholesale Supply
                  </h4>
                  <div class="quick-services-grid">
                    <?php
                    $quick_services = db()->fetchAll("SELECT name,slug,icon,category FROM service_keywords WHERE is_active=1 ORDER BY sort_order LIMIT 19");
                    foreach ($quick_services as $qs): ?>
                    <a href="<?php echo SITE_URL; ?>/services.php?service=<?php echo $qs['slug']; ?>" class="quick-service-item">
                      <i class="fas <?php echo $qs['icon'] ?: 'fa-shield-alt'; ?>"></i>
                      <span><?php echo htmlspecialchars($qs['name']); ?></span>
                    </a>
                    <?php endforeach; ?>
                  </div>
                  <!-- Wholesale badge in mega -->
                  <div class="mega-wholesale-strip">
                    <i class="fas fa-truck"></i> Wholesale Russea™ HDPE Nets &nbsp;·&nbsp;
                    <i class="fas fa-award"></i> Largest Supplier South India &nbsp;·&nbsp;
                    <i class="fas fa-map-marked-alt"></i> PAN India Delivery
                  </div>
                </div>

                <!-- Location Drill-Down: District → Area → Keyword -->
                <div class="mega-location-nav">
                  <h4 class="mega-section-title">
                    <i class="fas fa-map-marker-alt" style="color:#FF6B00"></i>
                    Find Russea™ Nets Near You
                  </h4>
                  <div class="mega-columns">

                    <!-- Level 2: Districts -->
                    <div class="mega-col mega-col-districts">
                      <h5><i class="fas fa-city"></i> District / City</h5>
                      <ul class="district-list" id="districtList">
                        <?php
                        $districts = db()->fetchAll("SELECT id,name,slug FROM districts WHERE is_active=1 ORDER BY sort_order LIMIT 25");
                        foreach ($districts as $i => $dist): ?>
                        <li class="district-item <?php echo $i===0?'active':''; ?>"
                            data-district-id="<?php echo $dist['id']; ?>"
                            data-district-slug="<?php echo $dist['slug']; ?>">
                          <span><?php echo htmlspecialchars($dist['name']); ?></span>
                          <i class="fas fa-chevron-right"></i>
                        </li>
                        <?php endforeach; ?>
                      </ul>
                    </div>

                    <!-- Level 3: Areas (AJAX) -->
                    <div class="mega-col mega-col-areas" id="megaAreasCol">
                      <h5><i class="fas fa-map-pin"></i> Area / Locality</h5>
                      <ul class="area-list" id="areaList">
                        <li class="area-placeholder"><i class="fas fa-arrow-left"></i> Select a district</li>
                      </ul>
                    </div>

                    <!-- Level 4: Keywords (AJAX) -->
                    <div class="mega-col mega-col-keywords" id="megaKeywordsCol">
                      <h5><i class="fas fa-tag"></i> Service / Product</h5>
                      <ul class="keyword-list" id="keywordList">
                        <li class="keyword-placeholder"><i class="fas fa-arrow-left"></i> Select an area</li>
                      </ul>
                    </div>

                  </div>
                </div>

              </div><!-- /.mega-inner -->

              <!-- Mega Footer CTA -->
              <div class="mega-footer">
                <div class="mega-cta-left">
                  <i class="fas fa-phone-alt"></i>
                  <div>
                    <span>Wholesale Enquiry</span>
                    <a href="tel:+91<?php echo $site_phone; ?>">+91 <?php echo $site_phone; ?></a>
                  </div>
                </div>
                <div class="mega-cta-links">
                  <a href="<?php echo SITE_URL; ?>/estimation.php"><i class="fas fa-calculator"></i> Get Estimate</a>
                  <a href="<?php echo SITE_URL; ?>/contact.php"><i class="fas fa-envelope"></i> Bulk Order</a>
                  <a href="<?php echo SITE_WHATSAPP; ?>" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                </div>
              </div>

            </div><!-- /.mega-menu -->
          </li><!-- /.has-mega -->

          <li class="nav-item <?php echo $current_page=='gallery.php'?'active':''; ?>">
            <a href="<?php echo SITE_URL; ?>/gallery.php" class="nav-link"><i class="fas fa-images"></i> Gallery</a>
          </li>
          <li class="nav-item <?php echo $current_page=='videos.php'?'active':''; ?>">
            <a href="<?php echo SITE_URL; ?>/videos.php" class="nav-link"><i class="fas fa-video"></i> Videos</a>
          </li>
          <li class="nav-item <?php echo $current_page=='estimation.php'?'active':''; ?>">
            <a href="<?php echo SITE_URL; ?>/estimation.php" class="nav-link"><i class="fas fa-calculator"></i> Estimation</a>
          </li>
          <li class="nav-item <?php echo $current_page=='reviews.php'?'active':''; ?>">
            <a href="<?php echo SITE_URL; ?>/reviews.php" class="nav-link"><i class="fas fa-star"></i> Reviews</a>
          </li>
          <li class="nav-item <?php echo $current_page=='blogs.php'?'active':''; ?>">
            <a href="<?php echo SITE_URL; ?>/blogs.php" class="nav-link"><i class="fas fa-blog"></i> Blogs</a>
          </li>
          <li class="nav-item <?php echo $current_page=='faq.php'?'active':''; ?>">
            <a href="<?php echo SITE_URL; ?>/faq.php" class="nav-link"><i class="fas fa-question-circle"></i> FAQ's</a>
          </li>
          <li class="nav-item <?php echo $current_page=='contact.php'?'active':''; ?>">
            <a href="<?php echo SITE_URL; ?>/contact.php" class="nav-link nav-cta">
              <i class="fas fa-envelope"></i> Contact
            </a>
          </li>
        </ul>
      </nav><!-- /.main-nav -->

    </div><!-- /.header-inner -->
  </div><!-- /.container -->
</header>

<!-- ── Mobile Overlay ─────────────────────────────────────── -->
<div class="nav-overlay" id="navOverlay" aria-hidden="true"></div>
