<?php require_once __DIR__ . '/whatsapp_helper.php'; ?>
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
$page_description = $page_description ?? getSetting('meta_description', 'NetsDial by GCM Enterprises is India\'s #1 wholesale supplier of Russea™ HDPE pigeon nets, balcony safety nets, cricket nets, along with SS 316 invisible grills, ceiling cloth hangers and artificial grass turf. Supplying entire India from Hyderabad.');
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
<link rel="describedby" href="https://netsdial.com/llms.txt" type="text/markdown">

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

<!-- Site CSS (Cache-busted with filemtime) -->
<link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css?v=<?php echo filemtime(dirname(__DIR__) . "/assets/css/style.css"); ?>">
<link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/menu.css?v=<?php echo filemtime(dirname(__DIR__) . "/assets/css/menu.css"); ?>">

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
  "isicV4": "1394",
  "additionalType": ["http://www.wikidata.org/entity/Q131498", "http://www.wikidata.org/entity/Q1447", "http://www.wikidata.org/entity/Q41605"],
  "knowsAbout": [
    "Russea Net Wholesale Suppliers India", "HDPE Net Dealers in Hyderabad", "Pigeon Net Wholesale Suppliers", "Safety Net Distributors India", "Factory Price HDPE Nets Wholesale", "Box Cricket Ground Setup Cost in India", "Box Cricket Construction Contractors", "Football Turf Installation Company", "Cricket Turf Setup Cost", "Commercial Sports Arena Netting", "Balcony Safety Nets Supply and Installation", "Anti Bird Netting Wholesale", "High Rise Apartment Safety Nets", "SS 316 Invisible Grill Suppliers", "Invisible Grill Installation Cost per Sq Ft", "Ceiling Cloth Hanger Installation", 
    "HDPE Safety Nets", "Pigeon Netting", "Bird Control Nets", "Balcony Safety Nets",
    "Cricket Practice Nets", "Box Cricket Setup", "Invisible Grills", "Artificial Grass",
    "Sports Ground Construction", "Football Turf Installation", "Net Wholesale Suppliers India"
  ],
  "hasOfferCatalog": {
    "@type": "OfferCatalog",
    "name": "NetsDial Products & Turnkey Services",
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
    "https://www.russea.in/",
    "https://gcm.enterprises/",
    "https://www.gcmenterprises.net/",
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
      "acceptedAnswer": {"@type":"Answer","text":"NetsDial provides complete doorstep supply and installation for all residential safety nets, bird nets, SS 316 invisible grills, and ceiling cloth hangers across all 33 districts of Telangana, all 26 districts of Andhra Pradesh, Chennai, Bangalore, and Pune. For Cricket Practice Nets and Commercial Box Cricket Grounds, on-site installation is provided nationwide across any state/city in India for commercial orders of 13,200 SQ FT (4 bags) and above. For all other regions, factory-direct material roll supply is dispatched PAN India."}
    },
    {
      "@type": "Question",
      "name": "Which cities does NetsDial provide doorstep installation in?",
      "acceptedAnswer": {"@type":"Answer","text":"NetsDial provides direct doorstep installation for all catalog services across: 1) All 33 districts of Telangana (Hyderabad, Warangal, Karimnagar, Nizamabad, etc.), 2) All 26 districts of Andhra Pradesh (Visakhapatnam, Vijayawada, Guntur, Tirupati, Nellore, etc.), and 3) Metro hubs in Chennai, Bangalore, and Pune. Additionally, specialized cricket net and sports arena installations are completed in any city or state across India for orders of 13,200 SQ FT (4 bags) and above."}
    },
    {
      "@type": "Question",
      "name": "What is the Russea™ brand?",
      "acceptedAnswer": {"@type":"Answer","text":"Russea™ is a registered trademark brand exclusively for HDPE technical nets and ropes. All Russea™ netting and rope products are UV-stabilized, weather-resistant, and manufactured from 100% virgin HDPE with Grade-A 600 KLY HALS. Other architectural and sports offerings by NetsDial—including SS 316 invisible grills, ceiling cloth drying hangers, and artificial grass/sports turf—are premium architectural and turf fittings supplied and installed by NetsDial / GCM Enterprises, and are not Russea™ branded."}
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
      "acceptedAnswer": {"@type":"Answer","text":"Contact NetsDial at: Phone/WhatsApp: +91 9966499144. Email: netsdial@gmail.com. Address: Plot No.91, Road No.2, Sri Ram Nagar Colony, Karmanghat, Saroornagar – 500035, Hyderabad, Telangana, India. Business hours: Monday–Saturday 9 AM – 8 PM, Sunday 10 AM – 5 PM."}
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
<script src="/content-protect.js"></script>
<script src="/assets/js/geo_resolver.js"></script>
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
      <a href="<?php echo getNetsdialWhatsAppUrl(); ?>" target="_blank" rel="noopener" class="top-whatsapp">
        <i class="fab fa-whatsapp"></i> WhatsApp
      </a>
    </div>
  </div>
</div>

<!-- ── Marquee ─────────────────────────────────────────────── -->
<div class="marquee-bar">
  <div class="marquee-content" aria-hidden="true">
    <?php
    $marquee_default = '🏆 Sports Nets Sales · Supply · Installation · Ground Planning &amp; Setup &nbsp;|&nbsp; 🚛 PAN India Delivery – All 28 States &nbsp;|&nbsp; 🏅 Russea™ Authorised Wholesale Dealers &nbsp;|&nbsp; 🏟️ Complete Sports Ground Setup – Box Cricket · Football Turf · Cricket Practice Nets &nbsp;|&nbsp; 🛡️ HDPE Braided, Twisted &amp; Knotted Nets &nbsp;|&nbsp; 📞 Call +91 9966499144 &nbsp;|&nbsp; 📧 netsdial@gmail.com &nbsp;|&nbsp; 🏏 Largest Cricket Net Suppliers from South India &nbsp;|&nbsp; ⚡ 10,000+ Dealer Network PAN India &nbsp;|&nbsp; 🏆 GCM Enterprises – Trusted Since 2013';
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
                    <!-- ── SERVICES: High-Converting Mega Menu ── -->
          <li class="nav-item has-mega <?php echo (str_contains($page_url,'/services/')||$current_page=='services.php')?'active':''; ?>">
            <a href="<?php echo SITE_URL; ?>/services.php" class="nav-link">
              <i class="fas fa-shield-alt"></i> Services <i class="fas fa-chevron-down arrow-icon"></i>
            </a>

            <div class="mega-menu" id="megaMenu" role="region" aria-label="Services Menu">
              <div class="mega-inner">

                <!-- ══ LEFT PANEL: Clean Product Categories (No Duplicates) ══ -->
                <div class="mega-catalog">
                  <div class="mega-header-row">
                    <h4 class="mega-title"><i class="fas fa-layer-group"></i> Products &amp; Services Catalog</h4>
                    <a href="<?php echo SITE_URL; ?>/services.php" class="mega-view-all">All Products <i class="fas fa-arrow-right"></i></a>
                  </div>

                  <div class="catalog-categories-grid">

                    <!-- Category 1: Bird & Balcony Protection -->
                    <div class="catalog-cat-block">
                      <div class="cat-block-title">
                        <i class="fas fa-shield-alt"></i> Russea™ Bird &amp; Balcony Nets
                      </div>
                      <ul class="cat-product-list">
                        <li><a href="<?php echo SITE_URL; ?>/services.php?service=pigeon-netting"><i class="fas fa-chevron-right"></i> Pigeon Netting <span class="cat-tag">Bestseller</span></a></li>
                        <li><a href="<?php echo SITE_URL; ?>/services.php?service=balcony-safety-nets"><i class="fas fa-chevron-right"></i> Russea™ Balcony Safety Nets</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/services.php?service=anti-bird-nets"><i class="fas fa-chevron-right"></i> Russea™ Anti Bird Nets</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/services.php?service=children-safety-nets"><i class="fas fa-chevron-right"></i> Russea™ Children Safety Nets</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/services.php?service=ss-bird-spikes"><i class="fas fa-chevron-right"></i> Bird Spikes (SS &amp; Polycarbonate)</a></li>
                      </ul>
                    </div>

                    <!-- Category 2: Sports Arenas & Cricket Setup -->
                    <div class="catalog-cat-block">
                      <div class="cat-block-title">
                        <i class="fas fa-baseball-ball"></i> Sports Arenas &amp; Turf Setup
                      </div>
                      <ul class="cat-product-list">
                        <li><a href="<?php echo SITE_URL; ?>/services.php?service=cricket-practice-nets"><i class="fas fa-chevron-right"></i> Cricket Practice Nets <span class="cat-tag tag-wholesale">Wholesale</span></a></li>
                        <li><a href="<?php echo SITE_URL; ?>/services.php?service=box-cricket-setup"><i class="fas fa-chevron-right"></i> Box Cricket Ground Setup <span class="cat-tag tag-hot">₹220/sq ft</span></a></li>
                        <li><a href="<?php echo SITE_URL; ?>/services.php?service=box-cricket-nets"><i class="fas fa-chevron-right"></i> Russea™ Box Cricket Nets</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/services.php?service=artificial-grass"><i class="fas fa-chevron-right"></i> Artificial Grass (25mm–50mm)</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/services.php?service=artificial-turf"><i class="fas fa-chevron-right"></i> Football Turf &amp; Pitch Grass</a></li>
                      </ul>
                    </div>

                    <!-- Category 3: Invisible Grills & Home Fittings -->
                    <div class="catalog-cat-block">
                      <div class="cat-block-title">
                        <i class="fas fa-home"></i> Invisible Grills &amp; Cloth Hangers
                      </div>
                      <ul class="cat-product-list">
                        <li><a href="<?php echo SITE_URL; ?>/services.php?service=invisible-grills"><i class="fas fa-chevron-right"></i> Invisible Grills (Balcony)</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/services.php?service=ss-invisible-grills"><i class="fas fa-chevron-right"></i> SS 316 Marine Grade Grills</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/services.php?service=cloth-hangers-installation"><i class="fas fa-chevron-right"></i> Ceiling Cloth Drying Hangers</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/services.php?service=ss-cloth-hangers"><i class="fas fa-chevron-right"></i> Stainless Steel Pull-Down Hangers</a></li>
                      </ul>
                    </div>

                    <!-- Category 4: Russea™ Wholesale Net Materials -->
                    <div class="catalog-cat-block">
                      <div class="cat-block-title">
                        <i class="fas fa-industry"></i> Russea™ Wholesale Nets &amp; Ropes
                      </div>
                      <ul class="cat-product-list">
                        <li><a href="<?php echo SITE_URL; ?>/services.php?service=pigeon-netting"><i class="fas fa-chevron-right"></i> Russea™ HDPE Braided Net Rolls</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/services.php?service=anti-bird-nets"><i class="fas fa-chevron-right"></i> Russea™ HDPE Twisted Netting</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/services.php?service=sports-practice-nets"><i class="fas fa-chevron-right"></i> Russea™ High-Tensile Knotted Nets</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/services.php?service=box-cricket-nets"><i class="fas fa-chevron-right"></i> Russea™ Braided Ropes &amp; Twine</a></li>
                      </ul>
                    </div>

                  </div><!-- /.catalog-categories-grid -->

                  <div class="mega-wholesale-strip">
                    <span><i class="fas fa-truck"></i> PAN India Delivery – All 28 States</span>
                    <span><i class="fas fa-award"></i> Genuine Russea™ Nets &amp; Ropes</span>
                    <span><i class="fas fa-warehouse"></i> 10,000+ Dealers Supplied</span>
                  </div>
                </div><!-- /.mega-catalog -->


                <!-- ══ RIGHT PANEL: Nationwide Delivery Hub (State ➔ District/City) ══ -->
                <div class="mega-location-hub">
                  <div class="mega-header-row">
                    <h4 class="mega-title"><i class="fas fa-map-marked-alt"></i> Find Nets in Your City</h4>
                    <span class="mega-city-count">755+ Cities Across India</span>
                  </div>

                  <!-- Instant City Search -->
                  <div class="mega-search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" id="megaCitySearch" placeholder="Type your city (e.g. Hyderabad, Mumbai, Bangalore...)" autocomplete="off">
                  </div>

                                    <!-- Core Installation Hubs (All Services) -->
                  <div class="mega-core-hubs">
                    <div class="core-hubs-title">
                      <span><i class="fas fa-tools"></i> <strong>Full Doorstep Installation Hubs:</strong></span>
                      <span class="hub-tag-badge">All Services</span>
                    </div>
                    <div class="core-hubs-pills">
                      <a href="<?php echo SITE_URL; ?>/services.php?district=hyderabad" class="core-hub-pill">Hyderabad (HQ)</a>
                      <a href="<?php echo SITE_URL; ?>/services.php?district=chennai" class="core-hub-pill">Chennai</a>
                      <a href="<?php echo SITE_URL; ?>/services.php?district=bangalore" class="core-hub-pill">Bangalore</a>
                      <a href="<?php echo SITE_URL; ?>/services.php?district=pune" class="core-hub-pill">Pune</a>
                      <a href="<?php echo SITE_URL; ?>/services.php?district=visakhapatnam" class="core-hub-pill">Visakhapatnam</a>
                      <a href="<?php echo SITE_URL; ?>/services.php?district=vijayawada" class="core-hub-pill">Vijayawada</a>
                      <a href="<?php echo SITE_URL; ?>/services.php" class="core-hub-pill state-pill" onclick="event.preventDefault();document.getElementById('megaStateSelect').value='Telangana';document.getElementById('megaStateSelect').dispatchEvent(new Event('change'));">Telangana (All 33)</a>
                      <a href="<?php echo SITE_URL; ?>/services.php" class="core-hub-pill state-pill" onclick="event.preventDefault();document.getElementById('megaStateSelect').value='Andhra Pradesh';document.getElementById('megaStateSelect').dispatchEvent(new Event('change'));">Andhra Pradesh (All 26)</a>
                    </div>
                  </div>

<!-- State Selector -->
                  <div class="mega-state-bar">
                    <label for="megaStateSelect"><i class="fas fa-flag"></i> Select State:</label>
                    <select id="megaStateSelect" class="mega-state-dropdown">
                      <?php
                      $priority_states = ['Telangana','Andhra Pradesh','Karnataka','Maharashtra','Tamil Nadu','Delhi','Gujarat','Uttar Pradesh','Rajasthan','Kerala','West Bengal','Madhya Pradesh'];
                      $all_states_query = db()->fetchAll("SELECT DISTINCT state FROM districts WHERE is_active=1 ORDER BY state");
                      $state_names = array_column($all_states_query, 'state');

                      $ordered_states = array_unique(array_merge($priority_states, $state_names));
                      foreach ($ordered_states as $st):
                        if (empty($st)) continue;
                        $is_selected = ($st === 'Telangana') ? 'selected' : '';
                      ?>
                        <option value="<?php echo htmlspecialchars($st); ?>" <?php echo $is_selected; ?>>
                          <?php echo htmlspecialchars($st); ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <!-- City / District Grid (Instant filterable) -->
                  <div class="mega-city-box">
                    <div class="mega-city-grid" id="megaCityGrid">
                      <!-- Populated automatically by JS from preloaded data -->
                    </div>
                    <div class="mega-all-cities-link">
                      <a href="<?php echo SITE_URL; ?>/services.php" id="stateHubLink">
                        <i class="fas fa-external-link-alt"></i> View All Cities in <span id="stateHubName">Telangana</span> ➔
                      </a>
                    </div>
                  </div>

                  <!-- Fast Track Action Cards -->
                  <div class="mega-action-cards">
                    <a href="<?php echo SITE_URL; ?>/contact.php" class="mega-action-card card-dealer">
                      <div class="action-icon"><i class="fas fa-user-shield"></i></div>
                      <div class="action-text">
                        <strong>Dealer / Contractor Inquiry</strong>
                        <span>Get Russea™ wholesale catalog &amp; roll pricing</span>
                      </div>
                      <i class="fas fa-chevron-right action-arrow"></i>
                    </a>
                    <a href="<?php echo SITE_URL; ?>/estimation.php" class="mega-action-card card-calc">
                      <div class="action-icon"><i class="fas fa-calculator"></i></div>
                      <div class="action-text">
                        <strong>Instant Online Cost Estimator</strong>
                        <span>Calculate Box Cricket &amp; Balcony Net pricing</span>
                      </div>
                      <i class="fas fa-chevron-right action-arrow"></i>
                    </a>
                  </div>

                </div><!-- /.mega-location-hub -->

              </div><!-- /.mega-inner -->

              <!-- Mega Footer CTA -->
              <div class="mega-footer">
                <div class="mega-cta-left">
                  <i class="fas fa-headset"></i>
                  <div>
                    <span>Wholesale &amp; Dealer Support Desk</span>
                    <a href="tel:+91<?php echo $site_phone; ?>">+91 <?php echo $site_phone; ?></a>
                  </div>
                </div>
                <div class="mega-cta-links">
                  <a href="<?php echo SITE_URL; ?>/estimation.php"><i class="fas fa-calculator"></i> Price Estimator</a>
                  <a href="<?php echo SITE_URL; ?>/contact.php"><i class="fas fa-file-invoice"></i> Bulk Order Quote</a>
                  <a href="<?php echo getNetsdialWhatsAppUrl(); ?>" target="_blank" class="mega-btn-whatsapp"><i class="fab fa-whatsapp"></i> WhatsApp Direct</a>
                </div>
              </div>

                          <!-- Mega Delivery Policy Strip -->
              <div class="mega-policy-strip">
                <span><i class="fas fa-truck-moving" style="color:var(--primary)"></i> <strong>Material Supply:</strong> PAN India (All 28 States)</span>
                <span><i class="fas fa-hammer" style="color:#00b894"></i> <strong>Doorstep Installation Hubs:</strong> Telangana (All 33), AP (All 26), Chennai, Bangalore, Pune</span>
                <span><i class="fas fa-baseball-ball" style="color:#fdcb6e"></i> <strong>Cricket Nets Pan-India Setup:</strong> Available anywhere in India for &ge; 13,200 SFT (4 Bags)</span>
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
<?php
// Preload districts grouped by state for instant 0ms client switching
$dist_rows = db()->fetchAll("SELECT name, slug, state FROM districts WHERE is_active=1 ORDER BY sort_order, name");
$grouped_districts = [];
foreach ($dist_rows as $dr) {
    $st = $dr['state'] ?: 'Other';
    if (!isset($grouped_districts[$st])) $grouped_districts[$st] = [];
    $grouped_districts[$st][] = ['n' => $dr['name'], 's' => $dr['slug']];
}
?>
<script id="megaDistrictsData" type="application/json">
<?php echo json_encode($grouped_districts, JSON_UNESCAPED_UNICODE); ?>
</script>

</header>

<!-- ── Mobile Overlay ─────────────────────────────────────── -->
<div class="nav-overlay" id="navOverlay" aria-hidden="true"></div>
