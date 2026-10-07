<?php
/**
 * NetsDial - Dynamic Service Page
 * URL: /services/{district}/{area}/{keyword}/
 * SEO-optimized with all 250+ keywords and 150+ locations
 */
define('NETSDIAL', true);
require_once __DIR__ . '/config/config.php';

// Get URL parameters
$district_slug = cleanInput($_GET['district'] ?? '');
$area_slug     = cleanInput($_GET['area'] ?? '');
$keyword_slug  = cleanInput($_GET['keyword'] ?? '');

// Validate slugs
if (!$district_slug || !$area_slug || !$keyword_slug) {
    header('Location: /services.php', true, 302);
    exit;
}

require_once __DIR__ . '/includes/feasible_location_service_system.php';
require_once __DIR__ . '/includes/geo_resolver.php';

// Check if already evaluated by router
if (!empty($_GET['eval_data'])) {
    $eval         = $_GET['eval_data'];
    $city_name    = $_GET['city_name'] ?? 'Hyderabad';
    $area_name    = $_GET['area_name'] ?? 'Kukatpally';
    $state_name   = $_GET['state_name'] ?? 'Telangana';
    $keyword_name = $eval['service_name'] ?? ucwords(str_replace('-', ' ', $keyword_slug));
    $keyword      = ['name' => $keyword_name, 'slug' => $keyword_slug, 'category' => 'General'];
    $district     = ['name' => $city_name, 'slug' => $district_slug, 'state' => $state_name, 'id' => 1];
    $area         = ['name' => $area_name, 'slug' => $area_slug, 'id' => 1];
} else {
    // Fetch data from DB or Geo Resolver
    $district = db()->fetchOne("SELECT * FROM districts WHERE slug = ? AND is_active = 1", [$district_slug]);
    $area     = db()->fetchOne("SELECT * FROM areas WHERE slug = ? AND is_active = 1", [$area_slug]);
    $keyword  = db()->fetchOne("SELECT * FROM service_keywords WHERE slug = ? AND is_active = 1", [$keyword_slug]);

    if (!$keyword) {
        $svc_data = FeasibleLocationServiceSystem::$SERVICES[$keyword_slug] ?? null;
        if ($svc_data) {
            $keyword = ['name' => $svc_data['name'], 'slug' => $keyword_slug, 'category' => $svc_data['cat']];
        }
    }

    if (!$area || !$district) {
        $geo_file = __DIR__ . "/includes/geo_taxonomy.json";
        $geo = file_exists($geo_file) ? json_decode(file_get_contents($geo_file), true) : ["districts" => [], "areas" => []];
        $loc_name = $geo["areas"][$area_slug] ?? ($geo["districts"][$district_slug] ?? ucwords(str_replace('-', ' ', $area_slug)));
        $resolved_geo = resolveSmartGeoLocation($area_slug, $loc_name);
        $parts = array_map('trim', explode(',', $resolved_geo));
        $area_name     = $parts[0] ?? ucwords(str_replace('-', ' ', $area_slug));
        $district_name = $parts[1] ?? $area_name;
        $state_name    = $parts[2] ?? ($parts[1] ?? 'India');
        $district = ['name' => $district_name, 'slug' => $district_slug, 'state' => $state_name, 'id' => 1];
        $area     = ['name' => $area_name, 'slug' => $area_slug, 'id' => 1];
        $city_name = $district_name;
    } else {
        $city_name    = $district['name'];
        $area_name    = $area['name'];
        $state_name   = $district['state'] ?? 'India';
    }

    $keyword_name = $keyword['name'] ?? ucwords(str_replace('-', ' ', $keyword_slug));

    // STRICT EVALUATION VIA FEASIBLE LOCATION SERVICE SYSTEM
    $eval = FeasibleLocationServiceSystem::evaluateServiceLocation($keyword_slug, $area_name, $city_name, $state_name);
    if (!$eval['allowed']) {
        http_response_code(404);
        $page_meta_title = "Service Not Available in this Location - NetsDial";
        include __DIR__ . '/includes/header.php';
        echo '<div class="section container py-5 text-center">';
        echo '<div style="max-width:600px;margin:0 auto;background:#fff;padding:40px;border-radius:12px;box-shadow:0 4px 20px rgba(0,0,0,0.08);">';
        echo '<i class="fas fa-info-circle text-warning" style="font-size:48px;margin-bottom:20px;"></i>';
        echo '<h2 style="font-size:24px;color:#1e293b;margin-bottom:12px;">Service Geo-Scope Notice</h2>';
        echo '<p style="color:#64748b;font-size:16px;line-height:1.6;">' . htmlspecialchars($eval["reason"]) . '</p>';
        echo '<div style="margin-top:25px;"><a href="/" class="btn btn-primary px-4 py-2">Explore Available Services</a></div>';
        echo '</div></div>';
        include __DIR__ . '/includes/footer.php';
        exit;
    }
}

// Strict Brand Boundary: Russea™ is exclusively for technical netting and ropes
$russea_net_slugs = [
    'pigeon-netting',
    'bird-netting',
    'anti-bird-nets',
    'balcony-safety-nets',
    'children-safety-nets',
    'sports-practice-nets',
    'box-cricket-nets'
];
$is_russea_service = in_array($keyword_slug, $russea_net_slugs);
$brand_prefix = $is_russea_service ? 'Russea™ ' : '';

// Always append city name for SEO ("Pigeon Net in Kukatpally, Hyderabad")
$page_title_base = $keyword_name . ' in ' . $area_name . ', ' . $city_name;

// SEO – rich, wholesale-focused meta
$is_sports = ($keyword['category'] === 'Sports & Recreation');
if ($is_sports) {
    if ($keyword_slug === 'box-cricket-setup') {
        $page_title = $page_title_base . ' | Turnkey Ground Construction & Setup | NetsDial';
        $page_description = "Commercial box cricket arena construction in {$area_name}, {$city_name}: GI steel structure, genuine Russea™ heavy braided enclosure nets, sports turf & LED lighting by NetsDial. Call +91 9966499144.";
    } elseif (in_array($keyword_slug, ['artificial-grass', 'artificial-turf', 'cricket-ground-pitch-turf'])) {
        $page_title = $page_title_base . ' | Synthetic Sports Turf Supply & Laying | NetsDial';
        $page_description = "High-density {$keyword_name} wholesale supply & installation in {$area_name}, {$city_name}. All-weather UV-resistant synthetic turf by NetsDial. Call +91 9966499144.";
    } else {
        $page_title = $page_title_base . ' | Ground Planning, Supply & Setup | NetsDial';
        $page_description = "Complete {$brand_prefix}{$keyword_name} solution in {$area_name}, {$city_name} — ground planning, supply of Russea™ HDPE nets, installation & full arena setup by NetsDial. Call +91 9966499144.";
    }
} else {
    if ($is_russea_service) {
        $page_title = $page_title_base . ' | Russea™ Net Sales, Supply & Installation | NetsDial';
        $page_description = "Russea™ {$keyword_name} sales, supply & doorstep installation in {$area_name}, {$city_name}, {$state_name}. NetsDial by GCM Enterprises — India's largest Russea™ HDPE net wholesale distributor. Call +91 9966499144.";
    } elseif (in_array($keyword_slug, ['invisible-grills', 'ss-invisible-grills'])) {
        $page_title = $page_title_base . ' | SS 316 Marine Invisible Grills Supply & Installation | NetsDial';
        $page_description = "High-tensile SS 316 marine-grade {$keyword_name} supply & certified doorstep installation in {$area_name}, {$city_name}, {$state_name}. 400kg+ break load balcony safety by NetsDial. Call +91 9966499144.";
    } elseif (in_array($keyword_slug, ['cloth-hangers-installation', 'ss-cloth-hangers'])) {
        $page_title = $page_title_base . ' | SS Ceiling Cloth Hangers Installation | NetsDial';
        $page_description = "Heavy-duty rust-proof stainless steel {$keyword_name} in {$area_name}, {$city_name}, {$state_name}. Ceiling pull-down & wall-mounted drying systems by NetsDial. Call +91 9966499144.";
    } else {
        $page_title = $page_title_base . ' | Bird Spikes Supply & Installation | NetsDial';
        $page_description = "High-grade {$keyword_name} supply & installation in {$area_name}, {$city_name}, {$state_name}. SS 304 pins & UV polycarbonate bird deterrent by NetsDial. Call +91 9966499144.";
    }
}

// City-specific meta keywords
$page_keywords = strtolower(
    ($is_russea_service ? "russea {$keyword_name} {$area_name}, russea hdpe nets {$city_name}, hdpe braided {$keyword_name} {$state_name}, hdpe twisted net {$city_name}, " : "") .
    "{$keyword_name} wholesale {$city_name}, {$keyword_name} in {$area_name}, " .
    "{$keyword_name} in {$city_name}, {$keyword_name} near me, {$keyword_name} price {$area_name}, " .
    "{$keyword_name} cost {$city_name}, best {$keyword_name} {$area_name}, {$keyword_name} dealers {$city_name}, " .
    "buy {$keyword_name} {$area_name}, {$keyword_name} suppliers {$city_name}, netsdial {$city_name}, " .
    "gcm enterprises {$city_name}, {$keyword_name} {$state_name}, wholesale {$keyword_name} {$state_name}, " .
    "{$keyword_name} hyderabad, {$keyword_name} india wholesale"
);

// Related keywords for this service
$related_keywords = db()->fetchAll("SELECT name, slug FROM service_keywords WHERE slug != ? AND is_active=1 ORDER BY sort_order LIMIT 6", [$keyword_slug]);
// Other areas in same district
$other_areas = db()->fetchAll("SELECT name, slug FROM areas WHERE district_id = ? AND slug != ? AND is_active=1 ORDER BY sort_order LIMIT 10", [$district['id'], $area_slug]);
// More cities across India (for cross-state links)
$all_districts = db()->fetchAll("SELECT name, slug, state FROM districts WHERE is_active=1 ORDER BY RAND() LIMIT 12");

// Build extended keyword variations for SEO content – all city-specific
$keyword_variations = [
    $keyword_name . ' in ' . $area_name,
    ($is_russea_service ? 'Russea™ ' : '') . $keyword_name . ' in ' . $city_name,
    $keyword_name . ' near me in ' . $area_name,
    $keyword_name . ' price in ' . $area_name,
    $keyword_name . ' cost in ' . $city_name,
    'buy ' . $keyword_name . ' in ' . $area_name,
    'best ' . $keyword_name . ' in ' . $area_name,
    $keyword_name . ' wholesale ' . $city_name,
    $keyword_name . ' dealers in ' . $city_name,
    $keyword_name . ' suppliers ' . $city_name,
    ($is_russea_service ? 'HDPE ' . $keyword_name . ' ' . $city_name : $keyword_name . ' installation ' . $city_name),
    ($is_russea_service ? 'Russea™ HDPE ' . $keyword_name . ' ' . $area_name : $keyword_name . ' price ' . $area_name),
    'wholesale ' . $keyword_name . ' ' . $state_name,
    $keyword_name . ' ' . $state_name,
    $keyword_name . ' India supply',
    ($is_russea_service ? 'Russea™ nets supplier in ' . $city_name : 'NetsDial supplier in ' . $city_name),
];

// Service image
$service_img = SITE_URL . '/assets/images/services/' . str_replace('-', '-', $keyword_slug) . '.jpg';

// Schema markup for service page
$schema = json_encode([
    "@context" => "https://schema.org",
    "@type"    => ["Product", "Service"],
    "name"     => ($is_russea_service ? "Russea™ " : "") . $keyword_name . " – Wholesale Supply & Installation in " . $area_name . ", " . $city_name,
    "brand"    => ["@type" => "Brand", "name" => ($is_russea_service ? "Russea™" : "NetsDial")],
    "offers"   => [
        "@type"         => "Offer",
        "priceCurrency" => "INR",
        "availability"  => "https://schema.org/InStock",
        "seller"        => ["@type" => "Organization", "name" => "NetsDial – GCM Enterprises"]
    ],
    "provider" => [
        "@type"     => "Organization",
        "name"      => "NetsDial – GCM Enterprises",
        "telephone" => "+91" . SITE_PHONE,
        "url"       => SITE_URL,
        "address"   => [
            "@type"           => "PostalAddress",
            "streetAddress"   => "Plot No.91, Road No.2, Sri Ram Nagar Colony, Karmanghat, Saroornagar",
            "addressLocality" => "Hyderabad",
            "addressRegion"   => "Telangana",
            "postalCode"      => "500035",
            "addressCountry"  => "IN"
        ]
    ],
    "areaServed"  => ["India", $city_name, $area_name],
    "description" => $page_description,
    "url"         => SITE_URL . "/services/{$district_slug}/{$area_slug}/{$keyword_slug}/"
]);

include __DIR__ . '/includes/header.php';

// Output schema
echo '<script type="application/ld+json">' . $schema . '</script>';
?>

<!-- Breadcrumb -->
<div class="breadcrumb-bar">
  <div class="container">
    <div class="breadcrumb">
      <a href="<?php echo SITE_URL; ?>/">Home</a>
      <span class="sep"><i class="fas fa-chevron-right"></i></span>
      <a href="<?php echo SITE_URL; ?>/services.php">Services</a>
      <span class="sep"><i class="fas fa-chevron-right"></i></span>
      <a href="<?php echo SITE_URL; ?>/services.php?district=<?php echo $district_slug; ?>"><?php echo htmlspecialchars($city_name); ?></a>
      <span class="sep"><i class="fas fa-chevron-right"></i></span>
      <a href="<?php echo SITE_URL; ?>/services.php?district=<?php echo $district_slug; ?>&area=<?php echo $area_slug; ?>"><?php echo htmlspecialchars($area_name); ?></a>
      <span class="sep"><i class="fas fa-chevron-right"></i></span>
      <span class="current"><?php echo htmlspecialchars($keyword_name); ?></span>
    </div>
  </div>
</div>

<!-- Wholesale Strip -->
<div class="wholesale-banner" style="background:linear-gradient(90deg,#e65100,#f57c00);color:#ffffff !important;padding:10px 0;font-size:.95rem;text-align:center;box-shadow:var(--shadow-sm);border-bottom:1px solid rgba(255,255,255,0.25)">
  <div class="container" style="color:#ffffff !important;display:flex;align-items:center;justify-content:center;flex-wrap:wrap;gap:8px 14px">
    <?php if ($is_russea_service): ?>
      <span class="wholesale-banner-item" style="color:#ffffff !important;font-weight:800"><i class="fas fa-trademark"></i> Russea™ <?php echo htmlspecialchars($keyword_name); ?> – Wholesale Supply</span>
      <span class="banner-sep" style="color:rgba(255,255,255,0.7)">|</span>
      <span class="wholesale-banner-item" style="color:#ffffff !important;font-weight:600">HDPE Braided · Twisted · Knotted Nets</span>
      <span class="banner-sep" style="color:rgba(255,255,255,0.7)">|</span>
      <span class="wholesale-banner-item" style="color:#ffffff !important;font-weight:600">South India's Largest Net Supply Hub</span>
    <?php elseif (in_array($keyword_slug, ['invisible-grills', 'ss-invisible-grills'])): ?>
      <span class="wholesale-banner-item" style="color:#ffffff !important;font-weight:800"><i class="fas fa-shield-alt"></i> SS 316 Marine Grade Invisible Grills</span>
      <span class="banner-sep" style="color:rgba(255,255,255,0.7)">|</span>
      <span class="wholesale-banner-item" style="color:#ffffff !important;font-weight:600">Break Load 400kg+ · Uncompromised Balcony Safety</span>
      <span class="banner-sep" style="color:rgba(255,255,255,0.7)">|</span>
      <span class="wholesale-banner-item" style="color:#ffffff !important;font-weight:600">Telangana, AP, Chennai, Bangalore &amp; Pune Hubs</span>
    <?php elseif (in_array($keyword_slug, ['cloth-hangers-installation', 'ss-cloth-hangers'])): ?>
      <span class="wholesale-banner-item" style="color:#ffffff !important;font-weight:800"><i class="fas fa-tshirt"></i> Heavy-Duty SS Ceiling Cloth Drying Hangers</span>
      <span class="banner-sep" style="color:rgba(255,255,255,0.7)">|</span>
      <span class="wholesale-banner-item" style="color:#ffffff !important;font-weight:600">Rust-Proof Stainless Steel · Individual Pulley System</span>
      <span class="banner-sep" style="color:rgba(255,255,255,0.7)">|</span>
      <span class="wholesale-banner-item" style="color:#ffffff !important;font-weight:600">Doorstep Installation</span>
    <?php elseif (in_array($keyword_slug, ['artificial-grass', 'artificial-turf', 'cricket-ground-pitch-turf'])): ?>
      <span class="wholesale-banner-item" style="color:#ffffff !important;font-weight:800"><i class="fas fa-leaf"></i> High-Density Synthetic Sports Turf &amp; Artificial Grass</span>
      <span class="banner-sep" style="color:rgba(255,255,255,0.7)">|</span>
      <span class="wholesale-banner-item" style="color:#ffffff !important;font-weight:600">25mm to 50mm Pile · UV Protected &amp; All-Weather Drainage</span>
      <span class="banner-sep" style="color:rgba(255,255,255,0.7)">|</span>
      <span class="wholesale-banner-item" style="color:#ffffff !important;font-weight:600">Wholesale Supply &amp; Turnkey Arena Installation</span>
    <?php else: ?>
      <span class="wholesale-banner-item" style="color:#ffffff !important;font-weight:800"><i class="fas fa-dove"></i> Professional <?php echo htmlspecialchars($keyword_name); ?></span>
      <span class="banner-sep" style="color:rgba(255,255,255,0.7)">|</span>
      <span class="wholesale-banner-item" style="color:#ffffff !important;font-weight:600">SS 304 High-Tensile Pins · Polycarbonate Base</span>
      <span class="banner-sep" style="color:rgba(255,255,255,0.7)">|</span>
      <span class="wholesale-banner-item" style="color:#ffffff !important;font-weight:600">Wholesale Supply &amp; Expert Fitting</span>
    <?php endif; ?>
    <span class="banner-sep" style="color:rgba(255,255,255,0.7)">|</span>
    <a href="tel:+919966499144" style="color:#ffffff !important;background:rgba(0,0,0,0.25);padding:4px 14px;border-radius:99px;text-decoration:none;font-weight:800;display:inline-flex;align-items:center;gap:6px;border:1px solid rgba(255,255,255,0.4)"><i class="fas fa-phone-alt" style="color:#ffffff !important"></i> +91 99664 99144</a>
  </div>
</div>

<!-- Page Hero -->
<div class="page-hero" style="background-image:linear-gradient(135deg,rgba(10,10,30,.85) 0%,rgba(255,107,0,.25) 100%),url('<?php echo $service_img; ?>');background-size:cover;background-position:center;min-height:380px;display:flex;align-items:center">
  <div class="container" style="text-align:center">
    <!-- Brand & Service Badge -->
    <?php if ($is_russea_service): ?>
      <div class="hero-trust-badge" style="display:inline-flex;align-items:center;justify-content:center;flex-wrap:wrap;gap:6px 12px;background:rgba(255,107,0,.2);border:1px solid rgba(255,107,0,.5);color:#FF8C42;padding:6px 18px;border-radius:99px;font-size:.82rem;font-weight:700;letter-spacing:.04em;margin-bottom:16px;max-width:96%">
        <span class="hero-badge-item"><i class="fas fa-trademark"></i> Russea™ Wholesale Supplier</span>
        <span class="badge-sep">•</span>
        <span class="hero-badge-item"><i class="fas fa-truck"></i> PAN India Delivery</span>
        <span class="badge-sep">•</span>
        <span class="hero-badge-item"><i class="fas fa-award"></i> South India's Largest Net Supplier</span>
      </div>
    <?php elseif (in_array($keyword_slug, ['invisible-grills', 'ss-invisible-grills'])): ?>
      <div class="hero-trust-badge" style="display:inline-flex;align-items:center;justify-content:center;flex-wrap:wrap;gap:6px 12px;background:rgba(116,185,255,.2);border:1px solid rgba(116,185,255,.5);color:#74b9ff;padding:6px 18px;border-radius:99px;font-size:.82rem;font-weight:700;letter-spacing:.04em;margin-bottom:16px;max-width:96%">
        <span class="hero-badge-item"><i class="fas fa-shield-alt"></i> SS 316 Marine Grade</span>
        <span class="badge-sep">•</span>
        <span class="hero-badge-item"><i class="fas fa-tools"></i> Certified Doorstep Installation</span>
        <span class="badge-sep">•</span>
        <span class="hero-badge-item"><i class="fas fa-award"></i> Managed by GCM Enterprises</span>
      </div>
    <?php elseif (in_array($keyword_slug, ['cloth-hangers-installation', 'ss-cloth-hangers'])): ?>
      <div class="hero-trust-badge" style="display:inline-flex;align-items:center;justify-content:center;flex-wrap:wrap;gap:6px 12px;background:rgba(129,236,236,.2);border:1px solid rgba(129,236,236,.5);color:#81ecec;padding:6px 18px;border-radius:99px;font-size:.82rem;font-weight:700;letter-spacing:.04em;margin-bottom:16px;max-width:96%">
        <span class="hero-badge-item"><i class="fas fa-tshirt"></i> Rust-Proof Stainless Steel</span>
        <span class="badge-sep">•</span>
        <span class="hero-badge-item"><i class="fas fa-home"></i> Ceiling Pull-Down System</span>
        <span class="badge-sep">•</span>
        <span class="hero-badge-item"><i class="fas fa-check-circle"></i> Complete Installation</span>
      </div>
    <?php elseif (in_array($keyword_slug, ['artificial-grass', 'artificial-turf', 'cricket-ground-pitch-turf'])): ?>
      <div class="hero-trust-badge" style="display:inline-flex;align-items:center;justify-content:center;flex-wrap:wrap;gap:6px 12px;background:rgba(85,239,196,.2);border:1px solid rgba(85,239,196,.5);color:#55efc4;padding:6px 18px;border-radius:99px;font-size:.82rem;font-weight:700;letter-spacing:.04em;margin-bottom:16px;max-width:96%">
        <span class="hero-badge-item"><i class="fas fa-leaf"></i> High-Density Sports Turf</span>
        <span class="badge-sep">•</span>
        <span class="hero-badge-item"><i class="fas fa-truck"></i> Wholesale Rolls PAN India</span>
        <span class="badge-sep">•</span>
        <span class="hero-badge-item"><i class="fas fa-trophy"></i> Turnkey Arena Execution</span>
      </div>
    <?php else: ?>
      <div class="hero-trust-badge" style="display:inline-flex;align-items:center;justify-content:center;flex-wrap:wrap;gap:6px 12px;background:rgba(253,121,168,.2);border:1px solid rgba(253,121,168,.5);color:#fd79a8;padding:6px 18px;border-radius:99px;font-size:.82rem;font-weight:700;letter-spacing:.04em;margin-bottom:16px;max-width:96%">
        <span class="hero-badge-item"><i class="fas fa-dove"></i> 100% Effective Bird Deterrent</span>
        <span class="badge-sep">•</span>
        <span class="hero-badge-item"><i class="fas fa-shield-alt"></i> SS 304 &amp; Polycarbonate</span>
        <span class="badge-sep">•</span>
        <span class="hero-badge-item"><i class="fas fa-truck"></i> Wholesale &amp; Installation</span>
      </div>
    <?php endif; ?>
    <h1 style="color:#fff;font-size:clamp(1.5rem,4vw,2.6rem);line-height:1.25;margin-bottom:12px">
      <?php echo htmlspecialchars($keyword_name); ?> in
      <span style="color:#FF8C42"><?php echo htmlspecialchars($area_name); ?></span>,
      <?php echo htmlspecialchars($city_name); ?>
    </h1>
    <p style="color:rgba(255,255,255,.85);font-size:1rem;margin-bottom:24px;max-width:680px;margin-inline:auto">
      <?php echo $is_sports ? 'Complete ground planning, supply &amp; installation of' : 'Sales, supply &amp; installation of'; ?>
      <strong><?php echo ($is_russea_service ? 'Russea™ ' : '') . htmlspecialchars($keyword_name); ?></strong> in <?php echo htmlspecialchars($area_name); ?>.
      GCM Enterprises, Hyderabad — serving all of India.
    </p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
      <a href="tel:+91<?php echo SITE_PHONE; ?>" class="btn btn-primary btn-lg">
        <i class="fas fa-phone-alt"></i> Wholesale Enquiry
      </a>
      <a href="<?php echo SITE_WHATSAPP; ?>" target="_blank" rel="noopener" class="btn btn-whatsapp btn-lg">
        <i class="fab fa-whatsapp"></i> WhatsApp
      </a>
      <a href="<?php echo SITE_URL; ?>/estimation.php" class="btn btn-secondary btn-lg">
        <i class="fas fa-calculator"></i> Get Estimate
      </a>
    </div>
  </div>
</div>

<!-- Main Content -->
<section class="section">
  <div class="container">
    <div class="service-page-content">

      <!-- Main Content -->
      <div class="service-main">

        <!-- Overview -->
        <div data-aos="fade-up">
          <span class="section-badge"><i class="fas <?php echo $keyword['icon']; ?>"></i> <?php echo htmlspecialchars($keyword['category']); ?></span>
          <h2 style="margin:12px 0"><?php echo htmlspecialchars($keyword_name); ?> in <?php echo htmlspecialchars($area_name); ?>, <?php echo htmlspecialchars($city_name); ?></h2>
          <p style="font-size:1.05rem;margin-bottom:20px"><?php echo htmlspecialchars($keyword['short_desc']); ?></p>
          <img src="<?php echo $service_img; ?>"
               alt="<?php echo htmlspecialchars($page_title); ?>"
               style="width:100%;border-radius:var(--radius-lg);margin-bottom:24px;max-height:400px;object-fit:cover"
               onerror="this.style.display='none'" loading="lazy" decoding="async">
        </div>

        <!-- Product Specifications Box -->
        <?php if ($is_russea_service): ?>
        <div class="russea-product-box" data-aos="fade-up">
          <div style="display:flex;align-items:center;gap:16px;margin-bottom:16px">
            <div style="width:56px;height:56px;background:linear-gradient(135deg,#FF6B00,#FF8C42);border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.4rem"><i class="fas fa-trademark"></i></div>
            <div>
              <div style="font-size:1.1rem;font-weight:800;color:var(--primary)">Russea™ <?php echo htmlspecialchars($keyword_name); ?></div>
              <div style="font-size:.8rem;color:var(--text-light)">Registered Trademark · 100% Virgin HDPE Braided / Twisted / Knotted Netting</div>
            </div>
          </div>
          <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:12px">
            <?php
            $badges = [
              ['fa-award','Wholesale Supplier','Authorized Russea™ dealer'],
              ['fa-truck','PAN India','Supply to all 28 states'],
              ['fa-industry','HDPE Quality','UV-stabilized, weatherproof'],
              ['fa-certificate','Trademark','Russea™ registered brand'],
            ];
            foreach ($badges as $b): ?>
            <div style="display:flex;gap:10px;align-items:flex-start;padding:10px;background:rgba(255,107,0,.05);border-radius:var(--radius-md)">
              <i class="fas <?php echo $b[0]; ?>" style="color:var(--primary);margin-top:2px"></i>
              <div><strong style="font-size:.82rem"><?php echo $b[1]; ?></strong><br><span style="font-size:.75rem;color:var(--text-light)"><?php echo $b[2]; ?></span></div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php else: ?>
        <div class="russea-product-box" data-aos="fade-up" style="background:linear-gradient(135deg,#f8f9fa,#f1f5f9);border-color:#334155">
          <div style="display:flex;align-items:center;gap:16px;margin-bottom:16px">
            <div style="width:56px;height:56px;background:linear-gradient(135deg,#1e293b,#334155);border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.4rem">
              <i class="fas <?php echo $keyword['icon'] ?? 'fa-shield-alt'; ?>"></i>
            </div>
            <div>
              <div style="font-size:1.1rem;font-weight:800;color:#1e293b"><?php echo htmlspecialchars($keyword_name); ?></div>
              <div style="font-size:.8rem;color:var(--text-light)">Certified Materials · Direct Wholesale Rates &amp; Professional Installation</div>
            </div>
          </div>
          <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:12px">
            <div style="display:flex;gap:10px;align-items:flex-start;padding:10px;background:rgba(30,41,59,.05);border-radius:var(--radius-md)">
              <i class="fas fa-shield-alt" style="color:#1e293b;margin-top:2px"></i>
              <div><strong style="font-size:.82rem">Premium Quality</strong><br><span style="font-size:.75rem;color:var(--text-light)">Certified high-durability spec</span></div>
            </div>
            <div style="display:flex;gap:10px;align-items:flex-start;padding:10px;background:rgba(30,41,59,.05);border-radius:var(--radius-md)">
              <i class="fas fa-tools" style="color:#1e293b;margin-top:2px"></i>
              <div><strong style="font-size:.82rem">Doorstep Installation</strong><br><span style="font-size:.75rem;color:var(--text-light)">Telangana, AP, Chennai, Blr, Pune</span></div>
            </div>
            <div style="display:flex;gap:10px;align-items:flex-start;padding:10px;background:rgba(30,41,59,.05);border-radius:var(--radius-md)">
              <i class="fas fa-truck" style="color:#1e293b;margin-top:2px"></i>
              <div><strong style="font-size:.82rem">PAN India Supply</strong><br><span style="font-size:.75rem;color:var(--text-light)">Bulk delivery to all 28 states</span></div>
            </div>
            <div style="display:flex;gap:10px;align-items:flex-start;padding:10px;background:rgba(30,41,59,.05);border-radius:var(--radius-md)">
              <i class="fas fa-award" style="color:#1e293b;margin-top:2px"></i>
              <div><strong style="font-size:.82rem">GCM Enterprises</strong><br><span style="font-size:.75rem;color:var(--text-light)">Trusted service since 2013</span></div>
            </div>
          </div>
        </div>
        <?php endif; ?>

        <!-- About This Service -->
        <div class="sidebar-card" data-aos="fade-up" style="position:static">
          <h2 style="font-size:1.3rem;margin-bottom:16px">
            <?php echo htmlspecialchars($keyword_name); ?> in <?php echo htmlspecialchars($area_name); ?>, <?php echo htmlspecialchars($city_name); ?>
          </h2>
          <?php if ($is_russea_service): ?>
          <p>
            Looking for genuine <strong>Russea™ <?php echo htmlspecialchars($keyword_name); ?></strong> in
            <strong><?php echo htmlspecialchars($area_name); ?>, <?php echo htmlspecialchars($city_name); ?></strong>?
            <strong>NetsDial</strong> by GCM Enterprises is India's largest wholesale supplier of
            <strong>Russea™</strong> HDPE nets — supplying dealers, contractors and commercial buyers across India.
          </p>
          <br>
          <p>
            We supply <strong>Russea™ <?php echo htmlspecialchars($keyword_name); ?></strong> to
            <?php echo htmlspecialchars($area_name); ?> and the entire <?php echo htmlspecialchars($city_name); ?> region
            at direct factory wholesale prices. Our netting rolls are crafted from 100% virgin HDPE (High-Density Polyethylene),
            UV stabilized and tested for extreme weather durability.
          </p>
          <?php elseif (in_array($keyword_slug, ['invisible-grills', 'ss-invisible-grills'])): ?>
          <p>
            Looking for certified <strong><?php echo htmlspecialchars($keyword_name); ?></strong> in
            <strong><?php echo htmlspecialchars($area_name); ?>, <?php echo htmlspecialchars($city_name); ?></strong>?
            <strong>NetsDial</strong> by GCM Enterprises is South India's premier supplier and installation specialist for
            high-tensile <strong>SS 316 Marine Grade Invisible Grills</strong> for balconies, windows, staircases and high-rise apartments.
          </p>
          <br>
          <p>
            Our invisible grills feature 2mm to 3mm high-tensile 316 stainless steel wire cables capable of withstanding 400kg+ breaking loads,
            sheathed in clear virgin nylon for zero rust and complete bird &amp; fall protection without blocking your scenic views.
          </p>
          <?php elseif (in_array($keyword_slug, ['cloth-hangers-installation', 'ss-cloth-hangers'])): ?>
          <p>
            Looking for premium <strong><?php echo htmlspecialchars($keyword_name); ?></strong> in
            <strong><?php echo htmlspecialchars($area_name); ?>, <?php echo htmlspecialchars($city_name); ?></strong>?
            <strong>NetsDial</strong> provides heavy-duty stainless steel ceiling cloth drying systems and wall-mounted hangers
            with expert doorstep installation across <?php echo htmlspecialchars($city_name); ?>.
          </p>
          <br>
          <p>
            Engineered with rust-proof SS tubes and smooth individual nylon lowering pulleys, our systems maximize 100% of your balcony
            floor space while handling heavy daily laundry loads effortlessly.
          </p>
          <?php elseif (in_array($keyword_slug, ['artificial-grass', 'artificial-turf', 'cricket-ground-pitch-turf'])): ?>
          <p>
            Looking for high-density <strong><?php echo htmlspecialchars($keyword_name); ?></strong> in
            <strong><?php echo htmlspecialchars($area_name); ?>, <?php echo htmlspecialchars($city_name); ?></strong>?
            <strong>NetsDial</strong> supplies and installs certified synthetic turf rolls (25mm to 50mm pile)
            for sports arenas, box cricket pitches, residential balconies, terraces, and commercial lawns.
          </p>
          <br>
          <p>
            Equipped with multi-tone natural thatch, UV stabilization, fire-retardant backing, and perforated drainage holes for instant rainwater clearance.
          </p>
          <?php else: ?>
          <p>
            Looking for professional <strong><?php echo htmlspecialchars($keyword_name); ?></strong> in
            <strong><?php echo htmlspecialchars($area_name); ?>, <?php echo htmlspecialchars($city_name); ?></strong>?
            <strong>NetsDial</strong> supplies and installs high-grade SS 304 stainless steel and virgin polycarbonate bird deterrent spikes.
          </p>
          <br>
          <p>
            Our spikes deliver 100% humane, zero-maintenance bird exclusion for parapet walls, window ledges, AC compressors, and structural beams.
          </p>
          <?php endif; ?>
          <br>
          <?php if ($is_sports): ?>
          <p>We offer <strong>complete sports arena and ground solutions</strong> — from initial site planning and floor plan design, to
          net supply, installation and full ground setup. Whether it's a turnkey box cricket arena, football turf or cricket practice
          nets, NetsDial handles the entire project from concept to handover across <?php echo htmlspecialchars($state_name); ?>.</p>
          <?php elseif ($is_russea_service): ?>
          <p>NetsDial covers the complete cycle — <strong>sales, wholesale supply and certified installation</strong> of genuine Russea™ branded nets
          for residential, commercial and industrial properties across <?php echo htmlspecialchars($state_name); ?>.
          Our Russea™ range includes HDPE Braided Nets, HDPE Twisted Nets and HDPE Knotted Nets — engineered from 100% virgin polymer with high breaking strength.</p>
          <?php else: ?>
          <p>NetsDial provides <strong>certified supply and professional doorstep installation</strong> of <?php echo htmlspecialchars($keyword_name); ?>
          for residential apartments, villas, and commercial properties across <?php echo htmlspecialchars($state_name); ?>.
          Every installation utilizes premium, corrosion-resistant components and heavy-duty anchors for maximum security.</p>
          <?php endif; ?>
          <br>
          <?php
          // Unique state-specific paragraph
          if ($is_russea_service) {
            $state_intros = [
              'Telangana'         => "As the leading Russea™ net supplier in Telangana, NetsDial delivers across all 33 districts including {$area_name} in {$city_name}. Headquartered in Karmanghat, Hyderabad, we supply wholesale rolls and turnkey doorstep installation across entire Telangana.",
              'Andhra Pradesh'    => "Andhra Pradesh's booming construction sector drives strong demand for genuine Russea™ HDPE nets. NetsDial by GCM Enterprises provides wholesale supply and certified doorstep installation across all 26 districts of AP including {$area_name} in {$city_name}.",
              'Karnataka'         => "Karnataka's residential zones and IT corridors in Bengaluru, Mysuru and Mangaluru create constant demand for certified netting. NetsDial delivers genuine Russea™ HDPE nets wholesale across Karnataka, reaching {$area_name} in {$city_name}.",
              'Tamil Nadu'        => "Tamil Nadu — from Chennai to Coimbatore and Madurai — has a growing market for HDPE safety and sports nets. NetsDial supplies Russea™ branded nets wholesale to dealers across Tamil Nadu including {$area_name} in {$city_name}.",
              'Maharashtra'       => "From Pune to Mumbai and across Maharashtra, NetsDial delivers genuine Russea™ HDPE nets wholesale to dealers and contractors, reaching {$area_name} in {$city_name}.",
            ];
            $intro = $state_intros[$state_name] ?? "NetsDial by GCM Enterprises supplies genuine Russea™ HDPE nets wholesale across India, reaching every corner including {$area_name} in {$city_name}, {$state_name}. We are South India's largest net supplier — delivering direct factory quality at wholesale prices.";
          } else {
            $intro = "NetsDial by GCM Enterprises delivers certified {$keyword_name} supply and precision doorstep installation across {$area_name}, {$city_name}, and all major hubs in Telangana, Andhra Pradesh, Chennai, Bangalore, and Pune. We combine high-grade components with direct wholesale pricing.";
          }
          ?>
          <p style="background:rgba(255,107,0,.06);border-left:4px solid var(--primary);padding:14px 16px;border-radius:0 8px 8px 0;margin:12px 0"><?php echo $intro; ?></p>
          <br>
          <p><strong>Why choose <?php echo ($is_russea_service ? 'Russea™ ' : ''); ?><?php echo htmlspecialchars($keyword_name); ?> from NetsDial in <?php echo htmlspecialchars($area_name); ?>?</strong></p>
          <ul style="margin:12px 0 0 4px;line-height:2.2">
            <?php if ($is_russea_service): ?>
              <li><i class="fas fa-check-circle" style="color:var(--success)"></i> &nbsp;Official Russea™ brand — registered trademark, 100% virgin HDPE quality</li>
              <li><i class="fas fa-check-circle" style="color:var(--success)"></i> &nbsp;HDPE Braided, Twisted &amp; Knotted nets — all mesh sizes &amp; thickness available</li>
            <?php elseif (in_array($keyword_slug, ['invisible-grills', 'ss-invisible-grills'])): ?>
              <li><i class="fas fa-check-circle" style="color:var(--success)"></i> &nbsp;High-tensile SS 316 marine-grade wire rope with transparent protective nylon coating</li>
              <li><i class="fas fa-check-circle" style="color:var(--success)"></i> &nbsp;400kg+ breaking load capacity per cable with tamper-proof heavy aluminium tracks</li>
            <?php elseif (in_array($keyword_slug, ['cloth-hangers-installation', 'ss-cloth-hangers'])): ?>
              <li><i class="fas fa-check-circle" style="color:var(--success)"></i> &nbsp;Rust-free heavy gauge stainless steel pipes with nylon braided lowering ropes</li>
              <li><i class="fas fa-check-circle" style="color:var(--success)"></i> &nbsp;Smooth individual pulley mechanism for effortless ceiling-mount operation</li>
            <?php elseif (in_array($keyword_slug, ['artificial-grass', 'artificial-turf', 'cricket-ground-pitch-turf'])): ?>
              <li><i class="fas fa-check-circle" style="color:var(--success)"></i> &nbsp;UV stabilized multi-tone synthetic turf with high stitch density (25mm to 50mm)</li>
              <li><i class="fas fa-check-circle" style="color:var(--success)"></i> &nbsp;Built-in rapid drainage holes, zero watering, fire-retardant &amp; pet friendly</li>
            <?php else: ?>
              <li><i class="fas fa-check-circle" style="color:var(--success)"></i> &nbsp;High-tensile SS 304 spikes on UV-resistant virgin polycarbonate base</li>
              <li><i class="fas fa-check-circle" style="color:var(--success)"></i> &nbsp;100% humane, weatherproof deterrent for ledges, AC outdoor units &amp; parapets</li>
            <?php endif; ?>
            <li><i class="fas fa-check-circle" style="color:var(--success)"></i> &nbsp;Wholesale pricing — best direct rates for <?php echo htmlspecialchars($city_name); ?>, <?php echo htmlspecialchars($state_name); ?></li>
            <li><i class="fas fa-check-circle" style="color:var(--success)"></i> &nbsp;Fast delivery &amp; doorstep service in <?php echo htmlspecialchars($area_name); ?> &amp; all <?php echo htmlspecialchars($city_name); ?> areas</li>
            <li><i class="fas fa-check-circle" style="color:var(--success)"></i> &nbsp;GST tax invoices &amp; warranty documentation with every project</li>
            <li><i class="fas fa-check-circle" style="color:var(--success)"></i> &nbsp;<?php echo $is_sports ? 'Turnkey arena setup: planning → GI structure → Russea™ netting → turf → handover' : 'Sales, wholesale supply &amp; certified doorstep installation'; ?></li>
            <li><i class="fas fa-check-circle" style="color:var(--success)"></i> &nbsp;Bulk orders welcome — special rates for contractors &amp; dealers</li>
          </ul>
        </div>

        <!-- Keyword Tags for SEO -->
        <div data-aos="fade-up" style="margin:28px 0">
          <h4 style="margin-bottom:14px">Related Searches</h4>
          <div class="keyword-tags">
            <?php foreach ($keyword_variations as $kv): ?>
            <span class="keyword-tag"><i class="fas fa-search"></i><?php echo htmlspecialchars($kv); ?></span>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Features -->
        <div data-aos="fade-up">
          <h3 style="margin-bottom:20px">Product Features - <?php echo ($is_russea_service ? 'Russea™ ' : ''); ?><?php echo htmlspecialchars($keyword_name); ?></h3>
          <div class="features-grid" style="grid-template-columns:repeat(auto-fill,minmax(240px,1fr))">
            <?php if ($is_russea_service): ?>
              <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                <h4>UV Stabilized HDPE</h4>
                <p>100% UV stabilized virgin HDPE fiber. Resists harsh solar exposure for 5–10 years.</p>
              </div>
              <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-water"></i></div>
                <h4>Weatherproof Netting</h4>
                <p>Zero moisture absorption, rot-proof and humidity resistant in all seasons.</p>
              </div>
              <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-dumbbell"></i></div>
                <h4>High Tensile Strength</h4>
                <p>Exceptional breaking load capacity with secure heat-set knotted or braided strands.</p>
              </div>
              <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-certificate"></i></div>
                <h4>Russea™ Authentic</h4>
                <p>Genuine registered trademark netting from South India's largest wholesale distributor.</p>
              </div>
            <?php elseif (in_array($keyword_slug, ['invisible-grills', 'ss-invisible-grills'])): ?>
              <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                <h4>SS 316 Marine Grade</h4>
                <p>Ultra-durable 316 stainless steel core resistant to coastal rust and outdoor corrosion.</p>
              </div>
              <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-eye"></i></div>
                <h4>Unblocked Balcony View</h4>
                <p>Sleek 2mm–3mm transparent aesthetic maintains wide scenic panoramic views.</p>
              </div>
              <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-weight-hanging"></i></div>
                <h4>400kg+ Tensile Capacity</h4>
                <p>Engineered for high-rise child safety, pet protection and anti-fall security.</p>
              </div>
              <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-tools"></i></div>
                <h4>Certified Installation</h4>
                <p>Professional anchor fastening with anodized heavy aluminium track profiles.</p>
              </div>
            <?php elseif (in_array($keyword_slug, ['cloth-hangers-installation', 'ss-cloth-hangers'])): ?>
              <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-tshirt"></i></div>
                <h4>Stainless Steel Pipes</h4>
                <p>Heavy gauge rust-proof SS tubes built for heavy daily laundry loads.</p>
              </div>
              <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-arrows-alt-v"></i></div>
                <h4>Individual Pulley System</h4>
                <p>Lower or raise individual rods smoothly without strain or bending.</p>
              </div>
              <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-compress-arrows-alt"></i></div>
                <h4>Space Maximization</h4>
                <p>Reclaims 100% floor space in balconies, utility spaces and corridors.</p>
              </div>
              <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-check-circle"></i></div>
                <h4>Doorstep Fitting</h4>
                <p>Precision ceiling mount installation with durable heavy-duty anchor fasteners.</p>
              </div>
            <?php elseif (in_array($keyword_slug, ['artificial-grass', 'artificial-turf', 'cricket-ground-pitch-turf'])): ?>
              <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-leaf"></i></div>
                <h4>High Density &amp; Pile</h4>
                <p>Premium 25mm to 50mm realistic synthetic blades with natural multi-tone look.</p>
              </div>
              <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-tint-slash"></i></div>
                <h4>Rapid Drainage</h4>
                <p>Perforated backing allows instant rainwater drainage with zero mud accumulation.</p>
              </div>
              <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-sun"></i></div>
                <h4>UV Protected</h4>
                <p>Colorfast polymers resist yellowing and fading under harsh sun exposure.</p>
              </div>
              <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-running"></i></div>
                <h4>High Footfall Ready</h4>
                <p>Engineered for sports grounds, box cricket pitches, commercial terraces &amp; villas.</p>
              </div>
            <?php else: ?>
              <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                <h4>SS 304 High Tensile Pins</h4>
                <p>Corrosion-proof stainless steel spikes that remain rigid and effective for years.</p>
              </div>
              <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-cube"></i></div>
                <h4>Virgin Polycarbonate</h4>
                <p>Bendable UV-stabilized base adapts easily to curved ledges, pipes and parapets.</p>
              </div>
              <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-dove"></i></div>
                <h4>100% Humane Deterrent</h4>
                <p>Prevents roosting and perching without causing physical harm to birds.</p>
              </div>
              <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-wrench"></i></div>
                <h4>Easy Installation</h4>
                <p>Rapid fastening using silicone sealant, screws, or heavy-duty cable ties.</p>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Other Areas in District -->
        <div data-aos="fade-up" style="margin-top:36px">
          <h3 style="margin-bottom:16px"><?php echo htmlspecialchars($keyword_name); ?> in Other Areas of <?php echo htmlspecialchars($city_name); ?></h3>
          <div class="keyword-tags">
            <?php foreach ($other_areas as $oa): ?>
            <a href="<?php echo SITE_URL; ?>/services/<?php echo $district_slug; ?>/<?php echo $oa['slug']; ?>/<?php echo $keyword_slug; ?>/" class="keyword-tag">
              <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($keyword_name); ?> in <?php echo htmlspecialchars($oa['name']); ?>
            </a>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Other Cities Across India -->
        <div data-aos="fade-up" style="margin-top:24px">
          <h4 style="margin-bottom:6px"><?php echo htmlspecialchars($keyword_name); ?> — Other Cities Across India</h4>
          <p style="color:var(--gray-400);font-size:.85rem;margin-bottom:12px">NetsDial supplies Russea™ nets PAN India. Find your city:</p>
          <div class="keyword-tags">
            <?php foreach ($all_districts as $ad): ?>
            <?php if ($ad['slug'] !== $district_slug): ?>
            <a href="<?php echo SITE_URL; ?>/services/<?php echo $ad['slug']; ?>/" class="keyword-tag">
              <i class="fas fa-city"></i> <?php echo htmlspecialchars($keyword_name); ?> in <?php echo htmlspecialchars($ad['name']); ?><?php if (!empty($ad['state']) && $ad['state'] !== $district['state']): ?> <small style="opacity:.7">(<?php echo htmlspecialchars($ad['state']); ?>)</small><?php endif; ?>
            </a>
            <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- State-wise Coverage Highlight -->
        <div data-aos="fade-up" style="margin-top:20px;background:linear-gradient(135deg,#fff8f0,#fff);border:1px solid #ffe4c8;border-radius:12px;padding:18px">
          <h5 style="color:var(--primary);margin-bottom:10px"><i class="fas fa-map-marked-alt"></i> We Supply Across All India</h5>
          <p style="font-size:.85rem;color:var(--gray-500);margin:0">
            Telangana · Andhra Pradesh · Karnataka · Tamil Nadu · Kerala · Maharashtra ·
            Delhi NCR · Uttar Pradesh · Rajasthan · Gujarat · West Bengal · Madhya Pradesh ·
            Punjab · Haryana · Odisha · Bihar · Jharkhand · Chhattisgarh · Assam &amp; more
          </p>
        </div>

        <!-- Contact CTA -->
        <div style="background:var(--gradient-primary);border-radius:var(--radius-xl);padding:36px;margin-top:36px;color:var(--white);text-align:center" data-aos="fade-up">
          <h3 style="color:var(--white);margin-bottom:12px">Get <?php echo htmlspecialchars($keyword_name); ?> in <?php echo htmlspecialchars($area_name); ?></h3>
          <p style="color:rgba(255,255,255,.85);margin-bottom:24px">Contact us now for best wholesale price on <?php echo $is_russea_service ? 'Russea™ ' : ''; ?><?php echo htmlspecialchars($keyword_name); ?>.</p>
          <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
            <a href="tel:+91<?php echo SITE_PHONE; ?>" class="btn btn-outline-white btn-lg"><i class="fas fa-phone-alt"></i> <?php echo SITE_PHONE; ?></a>
            <a href="<?php echo SITE_WHATSAPP; ?>" target="_blank" class="btn btn-whatsapp btn-lg"><i class="fab fa-whatsapp"></i> WhatsApp</a>
          </div>
        </div>

        <!-- FAQ Section -->
        <div data-aos="fade-up" style="margin-top:40px">
          <h3 style="margin-bottom:20px">FAQ - <?php echo htmlspecialchars($keyword_name); ?> in <?php echo htmlspecialchars($city_name); ?></h3>
          <?php
          $faqs_service = [
            ["What is the price of {$keyword_name} in {$area_name}?", "The price of {$keyword_name} in {$area_name}, {$city_name} depends on quantity, specifications and installation scope. Contact our team at +91 9966499144 for instant site estimation and wholesale quotes."],
            ["Do you supply {$keyword_name} to {$area_name}?", "Yes! NetsDial supplies premium " . ($is_russea_service ? "Russea™ " : "") . "{$keyword_name} to {$area_name} and across {$city_name}. Fast dispatch and direct delivery within 1-3 working days."],
            ["Is " . ($is_russea_service ? "Russea™ " : "") . "{$keyword_name} durable and weather resistant?", ($is_russea_service ? "Yes, Russea™ is India's most trusted HDPE net brand. All Russea™ {$keyword_name} are 100% virgin UV stabilized HDPE, weather resistant, high-strength with 5-10 years durability." : "Yes! All {$keyword_name} materials supplied and installed by NetsDial are engineered with high-grade components for long-term outdoor durability, weather resistance, and safety compliance.")],
            ["Can I get {$keyword_name} installation in {$city_name}?", "Yes! NetsDial offers sales, wholesale supply and certified doorstep installation across {$city_name}, throughout Telangana and Andhra Pradesh, Chennai, Bangalore, and Pune. For turnkey box cricket arenas, we provide nationwide setup for orders of 13,200 sqft and above. Call +91 9966499144 for site consultation."],
            ["Do you provide warranty for {$keyword_name}?", "Yes! " . ($is_russea_service ? "Russea™ {$keyword_name} comes with official manufacturer warranty." : "All {$keyword_name} installations and materials come with verified warranty coverage.") . " Digital invoices and warranty cards are provided with every order."],
          ];
          foreach ($faqs_service as $faq):
            $faq[0] = str_replace(['{$keyword_name}', '{$area_name}', '{$city_name}'], [$keyword_name, $area_name, $city_name], $faq[0]);
            $faq[1] = str_replace(['{$keyword_name}', '{$area_name}', '{$city_name}'], [$keyword_name, $area_name, $city_name], $faq[1]);
          ?>
          <div class="faq-item">
            <div class="faq-question">
              <span><?php echo htmlspecialchars($faq[0]); ?></span>
              <div class="faq-icon"><i class="fas fa-plus"></i></div>
            </div>
            <div class="faq-answer"><?php echo htmlspecialchars($faq[1]); ?></div>
          </div>
          <?php endforeach; ?>

          <!-- Schema FAQ markup -->
          <script type="application/ld+json">
          {"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
            <?php
            $schema_faqs = [];
            foreach ($faqs_service as $faq) {
              $schema_faqs[] = '{"@type":"Question","name":' . json_encode($faq[0]) . ',"acceptedAnswer":{"@type":"Answer","text":' . json_encode($faq[1]) . '}}';
            }
            echo implode(',', $schema_faqs);
            ?>
          ]}
          </script>
        </div>


<?php if ($keyword['category'] === 'Sports & Recreation'): ?>
<?php
  $is_football = in_array($keyword_slug, ['artificial-grass','artificial-turf','cricket-ground-pitch-turf']);
  $is_cricket  = in_array($keyword_slug, ['box-cricket-nets','box-cricket-setup','sports-practice-nets']);
?>

<!-- ═══════ SPORTS SETUP GUIDE (injected for Sports & Recreation keywords) ═══════ -->
<div data-aos="fade-up" style="margin-top:48px">

  <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px">
    <div style="width:44px;height:44px;background:linear-gradient(135deg,#16a34a,#22c55e);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.2rem;flex-shrink:0">
      <i class="fas fa-futbol"></i>
    </div>
    <div>
      <div style="font-size:.75rem;font-weight:700;color:#16a34a;text-transform:uppercase;letter-spacing:.08em">Complete Setup Guide</div>
      <h3 style="margin:0;font-size:1.4rem">Commercial Sports Turf – Types &amp; Configurations</h3>
    </div>
  </div>
  <p style="color:var(--text-light);margin-bottom:28px">
    When building commercial sports turf facilities, standard dimensions, player configurations, and setup variations
    dictate how grounds are designed and constructed. Use this guide to choose the right setup for your project in
    <strong><?php echo htmlspecialchars($area_name . ', ' . $city_name); ?></strong>.
  </p>

  <?php if ($is_football || !$is_cricket): ?>
  <!-- ── SECTION 1: Football Turf Types ── -->
  <h4 style="font-size:1.15rem;font-weight:700;border-left:4px solid #16a34a;padding-left:12px;margin-bottom:20px">
    <i class="fas fa-futbol" style="color:#16a34a"></i> &nbsp;1. Types of Football Turf Grounds
  </h4>

  <!-- Standard formats grid -->
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px;margin-bottom:24px">

    <?php
    $football_types = [
      ['5-a-Side Turf', 'fas fa-users', '#3b82f6', 'Futsal Format',
       '~15m × 25m to 20m × 30m<br><small style="color:var(--text-light)">(approx. 4,000 – 6,500 sq. ft.)</small>',
       'Highly popular in urban centres with space constraints. High turnover, faster gameplay, lower installation and lighting costs.'],
      ['6-a-Side Turf', 'fas fa-users', '#8b5cf6', 'Mid-size Format',
       '~20m × 35m to 22m × 40m<br><small style="color:var(--text-light)">(approx. 7,500 – 9,500 sq. ft.)</small>',
       'Middle-ground solution for spaces slightly too small for a standard 7-a-side pitch.'],
      ['7-a-Side Turf', 'fas fa-star', '#f59e0b', 'Standard Commercial',
       '~30m × 50m to 35m × 55m<br><small style="color:var(--text-light)">(approx. 16,000 – 21,000 sq. ft.)</small>',
       '<strong>Most commercially lucrative</strong> for recreational leagues and corporate bookings.'],
      ['8/9-a-Side Turf', 'fas fa-users', '#ec4899', 'Academy Format',
       '~40m × 60m to 45m × 65m<br><small style="color:var(--text-light)">(approx. 25,000 – 32,000 sq. ft.)</small>',
       'Built by semi-professional academies or large sports complexes.'],
      ['11-a-Side Pitch', 'fas fa-trophy', '#dc2626', 'FIFA Standard',
       '~68m × 105m<br><small style="color:var(--text-light)">(approx. 70,000+ sq. ft.)</small>',
       'Professional stadiums, official academy grounds and tournament facilities.'],
    ];
    foreach ($football_types as $ft): ?>
    <div style="border:1px solid var(--border);border-radius:var(--radius-lg);padding:18px;background:#fff;position:relative;overflow:hidden">
      <div style="position:absolute;top:0;right:0;width:60px;height:60px;background:<?php echo $ft[2]; ?>;opacity:.08;border-radius:0 var(--radius-lg) 0 100%"></div>
      <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px">
        <div style="width:36px;height:36px;background:<?php echo $ft[2]; ?>;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:.95rem;flex-shrink:0">
          <i class="<?php echo $ft[1]; ?>"></i>
        </div>
        <div>
          <div style="font-weight:800;font-size:.95rem"><?php echo $ft[0]; ?></div>
          <div style="font-size:.72rem;color:<?php echo $ft[2]; ?>;font-weight:600;text-transform:uppercase;letter-spacing:.05em"><?php echo $ft[3]; ?></div>
        </div>
      </div>
      <div style="font-size:.82rem;font-weight:600;color:var(--text-dark);margin-bottom:8px"><?php echo $ft[4]; ?></div>
      <p style="font-size:.8rem;color:var(--text-light);margin:0;line-height:1.55"><?php echo $ft[5]; ?></p>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Modular & Multi-sport -->
  <h5 style="font-weight:700;margin-bottom:14px;color:var(--text-dark)">Operational &amp; Modular Variations</h5>
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:14px;margin-bottom:36px">
    <div style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);border:1px solid #86efac;border-radius:var(--radius-lg);padding:18px">
      <div style="font-weight:700;margin-bottom:8px;color:#16a34a"><i class="fas fa-divide"></i> &nbsp;Multi-Divisible Turf (Modular Partition System)</div>
      <p style="font-size:.82rem;margin:0;color:#15803d;line-height:1.6">
        Constructing a large <strong>7-a-side or 9-a-side field</strong> equipped with <strong>retractable dividing net systems</strong>.
        One 7-a-side pitch can be split into two 5-a-side grounds simultaneously to double booking potential during peak hours.
      </p>
    </div>
    <div style="background:linear-gradient(135deg,#fefce8,#fef9c3);border:1px solid #fde047;border-radius:var(--radius-lg);padding:18px">
      <div style="font-weight:700;margin-bottom:8px;color:#ca8a04"><i class="fas fa-layer-group"></i> &nbsp;Multi-Sport Hybrid Turf</div>
      <p style="font-size:.82rem;margin:0;color:#92400e;line-height:1.6">
        Turf fields marked for both football and box cricket using multi-colored line markings —
        white for football, yellow/red for cricket crease lines. Maximizes utility of a single installation.
      </p>
    </div>
  </div>
  <?php endif; ?>

  <?php if ($is_cricket || !$is_football): ?>
  <!-- ── SECTION 2: Box Cricket Setup Types ── -->
  <h4 style="font-size:1.15rem;font-weight:700;border-left:4px solid #f97316;padding-left:12px;margin-bottom:20px">
    <i class="fas fa-baseball-ball" style="color:#f97316"></i> &nbsp;2. Types of Box Cricket Setups
  </h4>

  <!-- A. Structural types -->
  <h5 style="font-weight:700;margin-bottom:14px;color:var(--text-dark)">A. By Structural &amp; Frame Setup</h5>
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:14px;margin-bottom:24px">
    <?php
    $cricket_structures = [
      ['Full Cage Box Setup', 'fas fa-cube', '#f97316', 'Top Covered',
       'Fully enclosed on all four sides and completely roofed with high-density perimeter netting (typically 40mm–50mm square mesh).',
       'Keeps the ball entirely contained. Ideal for high-density commercial spaces or multi-story rooftops.'],
      ['Open-Top / High-Wall', 'fas fa-arrows-alt-v', '#0ea5e9', 'Side Nets Only',
       'High side walls (20ft–30ft nets) without a top net cover.',
       'Feels more open for high-lofted shots but requires a larger perimeter buffer zone.'],
      ['Rooftop Box Setup', 'fas fa-home', '#8b5cf6', 'Terrace Build',
       'Built on commercial building terraces using lightweight MS/GI pipe framing attached via chemical anchoring to prevent roof penetration.',
       'Maximizes unused terrace area without major structural changes.'],
      ['Indoor / Warehouse', 'fas fa-warehouse', '#10b981', 'Climate Controlled',
       'Built inside industrial sheds or indoor commercial centres using truss structures and ceiling suspension networks.',
       'Enables year-round, climate-controlled play regardless of rain or heat.'],
    ];
    foreach ($cricket_structures as $cs): ?>
    <div style="border:1px solid var(--border);border-radius:var(--radius-lg);padding:18px;background:#fff">
      <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px">
        <div style="width:36px;height:36px;background:<?php echo $cs[2]; ?>;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:.9rem;flex-shrink:0">
          <i class="<?php echo $cs[1]; ?>"></i>
        </div>
        <div>
          <div style="font-weight:800;font-size:.88rem"><?php echo $cs[0]; ?></div>
          <div style="font-size:.7rem;color:<?php echo $cs[2]; ?>;font-weight:600;text-transform:uppercase"><?php echo $cs[3]; ?></div>
        </div>
      </div>
      <p style="font-size:.8rem;color:var(--text-dark);margin-bottom:8px"><?php echo $cs[4]; ?></p>
      <p style="font-size:.78rem;color:var(--text-light);margin:0"><strong>Advantage:</strong> <?php echo $cs[5]; ?></p>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- B. Pitch layout types -->
  <h5 style="font-weight:700;margin-bottom:14px;color:var(--text-dark)">B. By Pitch &amp; Outfield Layout</h5>
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:14px;margin-bottom:24px">
    <div style="border:1px solid #fed7aa;border-radius:var(--radius-lg);padding:18px;background:#fff7ed">
      <div style="font-weight:700;color:#ea580c;margin-bottom:6px"><i class="fas fa-circle"></i> &nbsp;Single Central Pitch Layout</div>
      <p style="font-size:.8rem;margin:0;line-height:1.6;color:#7c2d12">
        A single central pitch (usually 20–22 yards) centred inside a standard 50ft × 80ft or 60ft × 100ft netted arena,
        with synthetic grass spanning both the pitch and outfield.
      </p>
    </div>
    <div style="border:1px solid #bbf7d0;border-radius:var(--radius-lg);padding:18px;background:#f0fdf4">
      <div style="font-weight:700;color:#16a34a;margin-bottom:6px"><i class="fas fa-columns"></i> &nbsp;Multi-Lane / Twin Setup</div>
      <p style="font-size:.8rem;margin:0;line-height:1.6;color:#14532d">
        Two or more parallel box cricket grounds sharing a central dividing net partition,
        optimizing land usage and shared lighting infrastructure.
      </p>
    </div>
    <div style="border:1px solid #c7d2fe;border-radius:var(--radius-lg);padding:18px;background:#eef2ff">
      <div style="font-weight:700;color:#4f46e5;margin-bottom:6px"><i class="fas fa-layer-group"></i> &nbsp;Dual-Turf System (Differentiated Pitch)</div>
      <p style="font-size:.8rem;margin-bottom:6px;line-height:1.6;color:#312e81">
        <strong>Pitch Area:</strong> High-density, short-pile non-infill turf (12mm–15mm curly grass or needle-punch carpet) over a concrete pad for true ball bounce and seam movement.
      </p>
      <p style="font-size:.8rem;margin:0;line-height:1.6;color:#312e81">
        <strong>Outfield Area:</strong> Taller sports turf (25mm–40mm) with rubber granule + silica sand infill for player cushioning and sliding.
      </p>
    </div>
  </div>
  <?php endif; ?>

  <!-- ── SECTION 3: Turf Spec & Infill Table ── -->
  <h4 style="font-size:1.15rem;font-weight:700;border-left:4px solid #0ea5e9;padding-left:12px;margin-bottom:16px">
    <i class="fas fa-table" style="color:#0ea5e9"></i> &nbsp;Turf Specification &amp; Infill Comparison
  </h4>
  <div style="overflow-x:auto;border-radius:var(--radius-lg);border:1px solid var(--border);margin-bottom:8px">
    <table style="width:100%;border-collapse:collapse;font-size:.85rem">
      <thead>
        <tr style="background:linear-gradient(135deg,#1e293b,#334155);color:#fff">
          <th style="padding:14px 18px;text-align:left;font-weight:600">Turf Type</th>
          <th style="padding:14px 18px;text-align:left;font-weight:600">Fiber Height</th>
          <th style="padding:14px 18px;text-align:left;font-weight:600">Primary Infill</th>
          <th style="padding:14px 18px;text-align:left;font-weight:600">Best For</th>
        </tr>
      </thead>
      <tbody>
        <tr style="border-bottom:1px solid var(--border)">
          <td style="padding:14px 18px;font-weight:700;color:#16a34a"><i class="fas fa-leaf" style="margin-right:6px"></i>Monofilament Grass</td>
          <td style="padding:14px 18px">40mm – 50mm</td>
          <td style="padding:14px 18px">Silica Sand + SBR Rubber<br><small style="color:var(--text-light)">(Styrene-Butadiene Rubber)</small></td>
          <td style="padding:14px 18px"><span style="background:#dcfce7;color:#16a34a;padding:3px 10px;border-radius:99px;font-size:.78rem;font-weight:600">Football &amp; Multi-Sport</span></td>
        </tr>
        <tr style="border-bottom:1px solid var(--border);background:#f8f9fa">
          <td style="padding:14px 18px;font-weight:700;color:#f97316"><i class="fas fa-leaf" style="margin-right:6px"></i>Fibrillated Grass</td>
          <td style="padding:14px 18px">30mm – 40mm</td>
          <td style="padding:14px 18px">Silica Sand + SBR Rubber<br><small style="color:var(--text-light)">(Styrene-Butadiene Rubber)</small></td>
          <td style="padding:14px 18px"><span style="background:#fff7ed;color:#f97316;padding:3px 10px;border-radius:99px;font-size:.78rem;font-weight:600">High-Traffic Cricket Outfields</span></td>
        </tr>
        <tr>
          <td style="padding:14px 18px;font-weight:700;color:#0ea5e9"><i class="fas fa-leaf" style="margin-right:6px"></i>Non-Infill Curly Grass</td>
          <td style="padding:14px 18px">12mm – 15mm</td>
          <td style="padding:14px 18px">None (Direct Stick)<br><small style="color:var(--text-light)">Glued directly to concrete pad</small></td>
          <td style="padding:14px 18px"><span style="background:#e0f2fe;color:#0ea5e9;padding:3px 10px;border-radius:99px;font-size:.78rem;font-weight:600">Fast Cricket Batting Pitches</span></td>
        </tr>
      </tbody>
    </table>
  </div>
  <p style="font-size:.78rem;color:var(--text-light);margin-top:8px">
    <i class="fas fa-info-circle"></i> &nbsp;SBR = Styrene-Butadiene Rubber granules used as shock-absorption infill layer.
    All Russea™ HDPE sports nets are compatible with every turf type listed above.
    <a href="<?php echo SITE_URL; ?>/estimation.php" style="color:var(--primary)">Use our estimation calculator</a> or
    <a href="tel:+91<?php echo SITE_PHONE; ?>" style="color:var(--primary)">call <?php echo SITE_PHONE; ?></a> for exact project pricing.
  </p>

</div>
<!-- ═══════ END SPORTS SETUP GUIDE ═══════ -->
<?php endif; ?>

      </div><!-- end service-main -->

      <!-- Sidebar -->
      <div class="service-sidebar">

        <!-- Quick Contact -->
        <div class="sidebar-card">
          <h4>Quick Enquiry</h4>
          <form action="<?php echo SITE_URL; ?>/api/contact.php" method="POST" data-ajax="true">
            <input type="hidden" name="service" value="<?php echo htmlspecialchars($keyword_name); ?>">
            <input type="hidden" name="location" value="<?php echo htmlspecialchars($area_name . ', ' . $city_name); ?>">
            <input type="hidden" name="source_page" value="<?php echo htmlspecialchars(SITE_URL . $_SERVER['REQUEST_URI']); ?>">
            <input type="text" name="website" style="display:none" tabindex="-1">
            <div class="form-group form-icon">
              <i class="fas fa-user"></i>
              <input type="text" name="name" class="form-control" placeholder="Your Name *" required>
            </div>
            <div class="form-group form-icon">
              <i class="fas fa-phone"></i>
              <input type="tel" name="phone" class="form-control" placeholder="Phone Number *" required maxlength="10">
            </div>
            <div class="form-group">
              <textarea name="message" class="form-control" rows="3" placeholder="Requirements..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">
              <i class="fas fa-paper-plane"></i> Get Quote
            </button>
          </form>
          <div class="form-success" style="display:none">
            <i class="fas fa-check-circle" style="color:var(--success)"></i>
            <p>Thank you! We'll call you within 2 hours.</p>
          </div>
        </div>

        <!-- Contact Buttons -->
        <div class="sidebar-card" style="background:var(--secondary);color:var(--white)">
          <h4 style="color:var(--white)">Contact Now</h4>
          <a href="tel:+91<?php echo SITE_PHONE; ?>" class="btn btn-primary w-100" style="margin-bottom:10px">
            <i class="fas fa-phone-alt"></i> Call: <?php echo SITE_PHONE; ?>
          </a>
          <a href="<?php echo SITE_WHATSAPP; ?>" target="_blank" class="btn btn-whatsapp w-100">
            <i class="fab fa-whatsapp"></i> WhatsApp Us
          </a>
        </div>

        <!-- Related Services -->
        <div class="sidebar-card">
          <h4>Related Services</h4>
          <div class="sidebar-links">
            <?php foreach ($related_keywords as $rk): ?>
            <a href="<?php echo SITE_URL; ?>/services/<?php echo $district_slug; ?>/<?php echo $area_slug; ?>/<?php echo $rk['slug']; ?>/">
              <i class="fas fa-chevron-right"></i><?php echo htmlspecialchars($rk['name']); ?>
            </a>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- All Services -->
        <div class="sidebar-card">
          <h4>All Services in <?php echo htmlspecialchars($city_name); ?></h4>
          <div class="sidebar-links">
            <?php
            $all_kw = db()->fetchAll("SELECT name, slug FROM service_keywords WHERE is_active=1 ORDER BY sort_order");
            foreach ($all_kw as $kw):
            ?>
            <a href="<?php echo SITE_URL; ?>/services/<?php echo $district_slug; ?>/<?php echo $area_slug; ?>/<?php echo $kw['slug']; ?>/">
              <i class="fas fa-chevron-right"></i><?php echo htmlspecialchars($kw['name']); ?> in <?php echo htmlspecialchars($area_name); ?>
            </a>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Estimation CTA -->
        <div class="sidebar-card" style="background:rgba(255,107,0,.05);border:1px solid rgba(255,107,0,.2)">
          <h4>Calculate Cost</h4>
          <p style="font-size:.88rem;margin-bottom:14px">Use our free estimation calculator for exact pricing.</p>
          <a href="<?php echo SITE_URL; ?>/estimation.php" class="btn btn-outline-primary w-100">
            <i class="fas fa-calculator"></i> Open Calculator
          </a>
        </div>

      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
