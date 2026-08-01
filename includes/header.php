<?php
defined('NETSDIAL') or die('Direct access not allowed');

$current_page = basename($_SERVER['PHP_SELF']);
$page_url     = $_SERVER['REQUEST_URI'] ?? '/';

// Settings
$site_name    = getSetting('site_name', 'NetsDial');
$site_phone   = getSetting('site_phone', '9966499144');
$site_email   = getSetting('site_email', 'contact@netsdial.com');
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

<!-- ═══════════════════════════════════════════════════════
     SCHEMA.ORG – COMPREHENSIVE STRUCTURED DATA
     Feeds Google Gemini, ChatGPT, Perplexity, Grok, Claude
════════════════════════════════════════════════════════ -->

<!-- 1. Organization + LocalBusiness (Primary Entity) -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": ["LocalBusiness", "Store", "Organization"],
  "@id": "<?php echo SITE_URL; ?>/#organization",
  "name": "NetsDial",
  "legalName": "GCM Enterprises",
  "alternateName": ["GCM Enterprises", "NetsDial Hyderabad", "Russea Net Suppliers", "NetsDial Safety Nets"],
  "description": "India's largest Russea™ HDPE net wholesale supplier and dealer. NetsDial by GCM Enterprises supplies pigeon nets, balcony safety nets, bird control nets, cricket practice nets, invisible grills, artificial grass, and provides complete sports ground setup (planning, supply, installation, handover) across all Indian states since 2013.",
  "url": "<?php echo SITE_URL; ?>",
  "logo": {
    "@type": "ImageObject",
    "url": "<?php echo SITE_URL.'/'.$logo_path; ?>",
    "width": 200,
    "height": 60
  },
  "image": [
    "<?php echo SITE_URL; ?>/assets/images/sliders/slider-1-safety-nets.jpg",
    "<?php echo SITE_URL; ?>/assets/images/sliders/slider-5-box-cricket.jpg",
    "<?php echo SITE_URL; ?>/assets/images/services/pigeon-netting.jpg"
  ],
  "telephone": "+91<?php echo $site_phone; ?>",
  "email": "<?php echo $site_email; ?>",
  "foundingDate": "2013",
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
    "latitude": "17.3338",
    "longitude": "78.5215"
  },
  "hasMap": "https://maps.google.com/?q=NetsDial+GCM+Enterprises+Karmanghat+Hyderabad",
  "openingHoursSpecification": [
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
      "opens": "09:00",
      "closes": "20:00"
    },
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": "Sunday",
      "opens": "10:00",
      "closes": "17:00"
    }
  ],
  "priceRange": "₹₹",
  "currenciesAccepted": "INR",
  "paymentAccepted": "Cash, Bank Transfer, UPI, Cheque",
  "areaServed": [
    {"@type":"Country","name":"India"},
    {"@type":"State","name":"Telangana"},
    {"@type":"State","name":"Andhra Pradesh"},
    {"@type":"State","name":"Karnataka"},
    {"@type":"State","name":"Tamil Nadu"},
    {"@type":"State","name":"Maharashtra"},
    {"@type":"State","name":"Delhi"}
  ],
  "knowsAbout": [
    "HDPE Safety Nets", "Pigeon Netting", "Bird Control Nets", "Balcony Safety Nets",
    "Cricket Practice Nets", "Box Cricket Setup", "Invisible Grills", "Artificial Grass",
    "Sports Ground Construction", "Football Turf Installation", "Net Wholesale Suppliers India"
  ],
  "hasOfferCatalog": {
    "@type": "OfferCatalog",
    "name": "Russea™ HDPE Net Products & Services",
    "itemListElement": [
      {"@type":"Offer","itemOffered":{"@type":"Product","name":"Russea™ HDPE Pigeon Nets","description":"UV-stabilized HDPE pigeon nets in 30mm, 40mm, 45mm, 50mm mesh. Available in 1.5mm, 2mm, 2.5mm thickness."}},
      {"@type":"Offer","itemOffered":{"@type":"Product","name":"Russea™ Balcony Safety Nets","description":"High-strength HDPE balcony safety nets for apartments and high-rise buildings."}},
      {"@type":"Offer","itemOffered":{"@type":"Product","name":"Russea™ Cricket Practice Nets","description":"HDPE knotted cricket nets in 40mm, 45mm, 50mm mesh for practice nets and box cricket."}},
      {"@type":"Offer","itemOffered":{"@type":"Product","name":"Russea™ Bird Control Nets","description":"Anti-bird HDPE nets for commercial buildings, warehouses, solar panels."}},
      {"@type":"Offer","itemOffered":{"@type":"Service","name":"Box Cricket Ground Setup","description":"Complete box cricket ground construction: steel structure, nets, artificial turf, flooring. ₹220–₹300 per sq ft."}},
      {"@type":"Offer","itemOffered":{"@type":"Service","name":"Football Turf Installation","description":"7-a-side, 5-a-side, 9-a-side football turf ground construction with artificial grass."}},
      {"@type":"Offer","itemOffered":{"@type":"Product","name":"SS Invisible Grills","description":"Stainless steel vertical wire invisible grill system for balconies. ₹120–₹180 per sq ft."}},
      {"@type":"Offer","itemOffered":{"@type":"Product","name":"Artificial Grass","description":"25mm to 50mm synthetic grass in single and double layer. ₹30–₹135 per sq ft."}}
    ]
  },
  "brand": {
    "@type": "Brand",
    "name": "Russea™",
    "description": "Russea™ is a registered trademark HDPE net brand. Products include HDPE Braided Nets, HDPE Twisted Nets, and HDPE Knotted Nets – all UV-stabilized and weather-resistant."
  },
  "sameAs": [
    "<?php echo getSetting('facebook_url','https://facebook.com/netsdial'); ?>",
    "<?php echo getSetting('instagram_url','https://instagram.com/netsdial'); ?>",
    "<?php echo getSetting('youtube_url','https://youtube.com/@netsdial'); ?>",
    "<?php echo getSetting('linkedin_url','https://linkedin.com/company/netsdial'); ?>"
  ],
  "contactPoint": [
    {
      "@type": "ContactPoint",
      "telephone": "+91<?php echo $site_phone; ?>",
      "contactType": "sales",
      "areaServed": "IN",
      "availableLanguage": ["English", "Telugu", "Hindi"],
      "contactOption": ["TollFree", "HearingImpairedSupported"]
    },
    {
      "@type": "ContactPoint",
      "telephone": "+91<?php echo $site_phone; ?>",
      "contactType": "customer service",
      "areaServed": "IN",
      "availableLanguage": ["English", "Telugu", "Hindi"]
    }
  ],
  "numberOfEmployees": {"@type":"QuantitativeValue","value": 50},
  "slogan": "South India's #1 Russea™ HDPE Net Wholesale Supplier – Sales, Supply & Installation PAN India"
}
</script>

<!-- 2. WebSite with SearchAction -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "@id": "<?php echo SITE_URL; ?>/#website",
  "name": "NetsDial – Russea™ Safety Nets Hyderabad",
  "url": "<?php echo SITE_URL; ?>",
  "description": "NetsDial is India's largest Russea™ HDPE net wholesale dealer. Pigeon nets, safety nets, cricket nets, invisible grills, artificial grass, box cricket & football turf setup. PAN India supply from Hyderabad.",
  "publisher": {"@id": "<?php echo SITE_URL; ?>/#organization"},
  "inLanguage": "en-IN",
  "potentialAction": {
    "@type": "SearchAction",
    "target": {
      "@type": "EntryPoint",
      "urlTemplate": "<?php echo SITE_URL; ?>/services.php?q={search_term_string}"
    },
    "query-input": "required name=search_term_string"
  }
}
</script>

<!-- 3. FAQPage – feeds Google rich results and AI Q&A -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What is NetsDial?",
      "acceptedAnswer": {"@type":"Answer","text":"NetsDial is India's largest Russea™ HDPE net wholesale supplier and dealer, managed by GCM Enterprises, headquartered in Karmanghat, Hyderabad, Telangana. We supply pigeon nets, safety nets, cricket practice nets, invisible grills, artificial grass, and provide complete sports ground setup services PAN India since 2013."}
    },
    {
      "@type": "Question",
      "name": "What types of nets does NetsDial supply?",
      "acceptedAnswer": {"@type":"Answer","text":"NetsDial supplies Russea™ brand HDPE Braided Nets, HDPE Twisted Nets, and HDPE Knotted Nets including: pigeon nets, balcony safety nets, bird control nets, cricket practice nets, box cricket nets, sports practice nets, anti-bird nets, children safety nets, construction safety nets, and more."}
    },
    {
      "@type": "Question",
      "name": "How much does pigeon net installation cost in Hyderabad?",
      "acceptedAnswer": {"@type":"Answer","text":"Pigeon net cost in Hyderabad: Below 100 sq ft is ₹1,500 flat (with installation). For 100–250 sq ft: ₹16–₹30 per sq ft. For 250–500 sq ft: ₹14–₹26 per sq ft. For 500–1,000 sq ft: ₹12–₹24 per sq ft. For 1,000–5,000 sq ft: ₹10–₹20 per sq ft. Call +91 9966499144 for exact pricing."}
    },
    {
      "@type": "Question",
      "name": "Does NetsDial do installation or only supply?",
      "acceptedAnswer": {"@type":"Answer","text":"NetsDial provides complete sales, supply, and installation services for all safety nets, bird nets, invisible grills, and cloth hangers. For sports projects (box cricket, football turf), we provide end-to-end ground setup including planning, civil coordination, net supply, installation, and full handover."}
    },
    {
      "@type": "Question",
      "name": "What is the Russea™ brand?",
      "acceptedAnswer": {"@type":"Answer","text":"Russea™ is a registered trademark HDPE net brand supplied exclusively by NetsDial (GCM Enterprises). All Russea™ nets are UV-stabilized, weather-resistant, and available in Braided, Twisted, and Knotted varieties in multiple mesh sizes (30mm, 40mm, 45mm, 50mm) and thicknesses (1.5mm, 2mm, 2.5mm, 3mm)."}
    },
    {
      "@type": "Question",
      "name": "Does NetsDial serve cities outside Hyderabad?",
      "acceptedAnswer": {"@type":"Answer","text":"Yes. NetsDial serves PAN India – all 28 states and 8 Union Territories. Primary markets include Hyderabad, Visakhapatnam, Vijayawada, Tirupati, Warangal, Karimnagar, Bengaluru, Chennai, Mumbai, Pune, Delhi NCR, and all other Indian cities. We have 10,000+ dealer partners across India."}
    },
    {
      "@type": "Question",
      "name": "How much does box cricket ground setup cost?",
      "acceptedAnswer": {"@type":"Answer","text":"Box cricket complete ground setup (including net, grass, steel structure, and flooring) costs ₹220–₹300 per sq ft. The price depends on ground size and structure height (20ft, 25ft, 30ft, 35ft, 40ft). Call +91 9966499144 for a detailed estimate."}
    },
    {
      "@type": "Question",
      "name": "How much do invisible grills cost in Hyderabad?",
      "acceptedAnswer": {"@type":"Answer","text":"Invisible grill cost in Hyderabad: 1.5mm SS wire – ₹120–₹150 per sq ft. 2mm SS wire – ₹130–₹160 per sq ft. 2.5mm SS wire – ₹140–₹170 per sq ft. 3mm SS wire – ₹150–₹180 per sq ft. Available in 2-inch and 3-inch line gap options. Call +91 9966499144 for exact pricing."}
    },
    {
      "@type": "Question",
      "name": "How do I contact NetsDial?",
      "acceptedAnswer": {"@type":"Answer","text":"Contact NetsDial at: Phone/WhatsApp: +91 9966499144. Email: contact@netsdial.com. Address: Plot No.91, Road No.2, Sri Ram Nagar Colony, Karmanghat, Saroornagar – 500035, Hyderabad, Telangana, India. Business hours: Monday–Saturday 9 AM – 8 PM, Sunday 10 AM – 5 PM."}
    },
    {
      "@type": "Question",
      "name": "What is artificial grass price per sq ft in Hyderabad?",
      "acceptedAnswer": {"@type":"Answer","text":"Artificial grass price in Hyderabad: 25mm Single Layer – ₹30–₹40 per sq ft. 30mm Single Layer – ₹33–₹43 per sq ft. 40mm Single Layer – ₹36–₹46 per sq ft. 50mm Double Layer – ₹45–₹55 per sq ft. Football Grass (50mm Double) – ₹75–₹100 per sq ft. Sports Turf (25mm) – ₹95–₹135 per sq ft. Call +91 9966499144 for best price."}
    }
  ]
}
</script>

<!-- 4. BreadcrumbList for current page -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {"@type":"ListItem","position":1,"name":"NetsDial Home","item":"<?php echo SITE_URL; ?>/"},
    {"@type":"ListItem","position":2,"name":"<?php echo htmlspecialchars($page_title ?? 'Services'); ?>","item":"<?php echo SITE_URL . '/' . ltrim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/'); ?>"}
  ]
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
        <span>+91 <?php echo $site_phone; ?></span>
      </a>
      <a href="mailto:<?php echo $site_email; ?>" class="top-contact">
        <i class="fas fa-envelope"></i>
        <span><?php echo $site_email; ?></span>
      </a>
      <span class="top-contact top-address-hide">
        <i class="fas fa-map-marker-alt"></i>
        <span>Karmanghat, Hyderabad</span>
      </span>
    </div>
    <div class="top-bar-right">
      <span class="top-badge top-badge-brand">
        <i class="fas fa-trademark"></i> Russea™ Wholesale Supplier
      </span>
      <span class="top-badge top-badge-hide">
        <i class="fas fa-truck"></i> PAN India Delivery
      </span>
      <span class="top-badge top-badge-hide">
        <i class="fas fa-award"></i> South India #1
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
    $marquee_default = '🏆 Sports Nets Sales · Supply · Installation · Ground Planning &amp; Setup &nbsp;|&nbsp; 🚛 PAN India Delivery – All 28 States &nbsp;|&nbsp; 🏅 Russea™ Authorised Wholesale Dealers &nbsp;|&nbsp; 🏟️ Complete Sports Ground Setup – Box Cricket · Football Turf · Cricket Practice Nets &nbsp;|&nbsp; 🛡️ HDPE Braided, Twisted &amp; Knotted Nets &nbsp;|&nbsp; 📞 Call +91 9966499144 &nbsp;|&nbsp; 📧 contact@netsdial.com &nbsp;|&nbsp; 🏏 Largest Cricket Net Suppliers from South India &nbsp;|&nbsp; ⚡ 10,000+ Dealer Network PAN India &nbsp;|&nbsp; 🏆 GCM Enterprises – Trusted Since 2013';
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
                    <span style="font-size:.72rem;font-weight:400;color:#aaa;margin-left:8px"><?php echo db()->fetchOne("SELECT COUNT(*) as c FROM districts WHERE is_active=1")['c']; ?> cities across India</span>
                  </h4>
                  <div class="mega-columns">

                    <!-- Level 2: Districts with search -->
                    <div class="mega-col mega-col-districts">
                      <h5><i class="fas fa-city"></i> District / City</h5>
                      <!-- Search box -->
                      <div class="district-search-wrap">
                        <i class="fas fa-search"></i>
                        <input type="text" id="districtSearch" placeholder="Search city..." autocomplete="off">
                      </div>
                      <ul class="district-list" id="districtList">
                        <?php
                        // Load ALL districts ordered by sort_order, grouped visually
                        $all_districts = db()->fetchAll("SELECT id,name,slug,state FROM districts WHERE is_active=1 ORDER BY sort_order,name");
                        $current_state = '';
                        foreach ($all_districts as $i => $dist):
                          $is_first = $i === 0;
                        ?>
                        <li class="district-item <?php echo $is_first?'active':''; ?>"
                            data-district-id="<?php echo $dist['id']; ?>"
                            data-district-slug="<?php echo $dist['slug']; ?>"
                            data-state="<?php echo htmlspecialchars($dist['state']); ?>"
                            data-name="<?php echo strtolower(htmlspecialchars($dist['name'])); ?>">
                          <span><?php echo htmlspecialchars($dist['name']); ?></span>
                          <i class="fas fa-chevron-right"></i>
                        </li>
                        <?php endforeach; ?>
                      </ul>
                      <div class="district-count-info" id="districtCount">
                        Showing <span id="districtVisible"><?php echo count($all_districts); ?></span> cities
                      </div>
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
