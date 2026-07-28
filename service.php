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

// Fetch data from DB
$district = db()->fetchOne("SELECT * FROM districts WHERE slug = ? AND is_active = 1", [$district_slug]);
$area     = db()->fetchOne("SELECT * FROM areas WHERE slug = ? AND is_active = 1", [$area_slug]);
$keyword  = db()->fetchOne("SELECT * FROM service_keywords WHERE slug = ? AND is_active = 1", [$keyword_slug]);

// 404 if not found
if (!$district || !$area || !$keyword) {
    http_response_code(404);
    $page_meta_title = "Page Not Found - NetsDial";
    include __DIR__ . '/includes/header.php';
    echo '<div class="section container"><h1>404 - Page Not Found</h1><a href="/" class="btn btn-primary">Go Home</a></div>';
    include __DIR__ . '/includes/footer.php';
    exit;
}

// Build page content variables
$city_name    = $district['name'];
$area_name    = $area['name'];
$keyword_name = $keyword['name'];
// Always append city name for SEO ("Pigeon Net in Kukatpally, Hyderabad")
$page_title   = $keyword_name . ' in ' . $area_name . ', ' . $city_name;

// SEO – rich, wholesale-focused meta
$page_title       = $page_title . ' | Russea™ HDPE Net Wholesale Supplier | NetsDial Hyderabad';
$page_description = "Buy Russea™ branded {$keyword_name} in {$area_name}, {$city_name} — wholesale prices from NetsDial by GCM Enterprises. India's largest Russea™ HDPE net supplier. HDPE Braided, Twisted & Knotted nets. Call +91 9966499144 for bulk pricing.";
$page_keywords    = strtolower(
    "russea {$keyword_name} {$area_name}, {$keyword_name} wholesale {$city_name}, {$keyword_name} in {$area_name}, " .
    "{$keyword_name} in {$city_name}, {$keyword_name} near me, {$keyword_name} price {$area_name}, " .
    "{$keyword_name} cost {$city_name}, best {$keyword_name} {$area_name}, {$keyword_name} dealers {$city_name}, " .
    "buy {$keyword_name} {$area_name}, {$keyword_name} suppliers {$city_name}, russea hdpe nets {$city_name}, " .
    "hdpe braided {$keyword_name}, hdpe twisted net {$city_name}, netsdial {$city_name}, gcm enterprises {$city_name}, " .
    "{$keyword_name} hyderabad, {$keyword_name} telangana, {$keyword_name} india wholesale"
);

// Related keywords for this service
$related_keywords = db()->fetchAll("SELECT name, slug FROM service_keywords WHERE slug != ? AND is_active=1 ORDER BY sort_order LIMIT 6", [$keyword_slug]);
// Other areas in same district
$other_areas = db()->fetchAll("SELECT name, slug FROM areas WHERE district_id = ? AND slug != ? AND is_active=1 ORDER BY sort_order LIMIT 10", [$district['id'], $area_slug]);
// All districts (for cross-links)
$all_districts = db()->fetchAll("SELECT name, slug FROM districts WHERE is_active=1 ORDER BY sort_order LIMIT 10");

// Build extended keyword variations for SEO content
$keyword_variations = [
    $keyword_name . ' in ' . $area_name,
    'Russea™ ' . $keyword_name . ' in ' . $city_name,
    $keyword_name . ' near me',
    $keyword_name . ' price ' . $area_name,
    $keyword_name . ' cost ' . $city_name,
    'buy ' . $keyword_name . ' ' . $area_name,
    'best ' . $keyword_name . ' ' . $area_name,
    $keyword_name . ' wholesale ' . $city_name,
    $keyword_name . ' dealers ' . $city_name,
    $keyword_name . ' suppliers ' . $city_name,
    'HDPE ' . $keyword_name . ' ' . $city_name,
    'Russea™ HDPE ' . $keyword_name . ' ' . $area_name,
    'wholesale ' . $keyword_name . ' South India',
    $keyword_name . ' Hyderabad',
    $keyword_name . ' Telangana',
    $keyword_name . ' India',
];

// Service image
$service_img = SITE_URL . '/assets/images/services/' . str_replace('-', '-', $keyword_slug) . '.jpg';

// Schema markup for service page — wholesale product focus
$schema = json_encode([
    "@context" => "https://schema.org",
    "@type"    => ["Product", "Service"],
    "name"     => "Russea™ " . $keyword_name . " – Wholesale Supply in " . $area_name . ", " . $city_name,
    "brand"    => ["@type" => "Brand", "name" => "Russea™"],
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
<div class="wholesale-banner">
  <div class="container">
    <strong>Russea™ <?php echo htmlspecialchars($keyword_name); ?> – Wholesale Supply</strong>
    &nbsp;|&nbsp; HDPE Braided · Twisted · Knotted Nets
    &nbsp;|&nbsp; India's Largest Supplier from South India
    &nbsp;|&nbsp; <a href="tel:+919966499144" style="color:#FF8C42;font-weight:700">+91 9966499144</a>
  </div>
</div>

<!-- Page Hero -->
<div class="page-hero" style="background-image:linear-gradient(135deg,rgba(10,10,30,.85) 0%,rgba(255,107,0,.25) 100%),url('<?php echo $service_img; ?>');background-size:cover;background-position:center;min-height:380px;display:flex;align-items:center">
  <div class="container" style="text-align:center">
    <!-- Russea™ badge -->
    <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,107,0,.2);border:1px solid rgba(255,107,0,.5);color:#FF8C42;padding:6px 18px;border-radius:99px;font-size:.82rem;font-weight:700;letter-spacing:.06em;margin-bottom:16px">
      <i class="fas fa-trademark"></i> Russea™ Wholesale Supplier &nbsp;|&nbsp;
      <i class="fas fa-truck"></i> PAN India Delivery &nbsp;|&nbsp;
      <i class="fas fa-award"></i> South India's Largest
    </div>
    <h1 style="color:#fff;font-size:clamp(1.5rem,4vw,2.6rem);line-height:1.25;margin-bottom:12px">
      <?php echo htmlspecialchars($keyword_name); ?> in
      <span style="color:#FF8C42"><?php echo htmlspecialchars($area_name); ?></span>,
      <?php echo htmlspecialchars($city_name); ?>
    </h1>
    <p style="color:rgba(255,255,255,.85);font-size:1rem;margin-bottom:24px;max-width:680px;margin-inline:auto">
      Russea™ HDPE <?php echo htmlspecialchars($keyword_name); ?> — Wholesale prices from India's largest net supplier.
      GCM Enterprises, Hyderabad. Supplying dealers &amp; businesses across India.
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
               onerror="this.style.display='none'" loading="lazy">
        </div>

        <!-- Russea™ Product Box -->
        <div class="russea-product-box" data-aos="fade-up">
          <div style="display:flex;align-items:center;gap:16px;margin-bottom:16px">
            <div style="width:56px;height:56px;background:linear-gradient(135deg,#FF6B00,#FF8C42);border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.4rem"><i class="fas fa-trademark"></i></div>
            <div>
              <div style="font-size:1.1rem;font-weight:800;color:var(--primary)">Russea™ <?php echo htmlspecialchars($keyword_name); ?></div>
              <div style="font-size:.8rem;color:var(--text-light)">Registered Trademark · HDPE Braided / Twisted / Knotted</div>
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

        <!-- About This Service -->
        <div class="sidebar-card" data-aos="fade-up" style="position:static">
          <h2 style="font-size:1.3rem;margin-bottom:16px">
            <?php echo htmlspecialchars($keyword_name); ?> in <?php echo htmlspecialchars($area_name); ?>, <?php echo htmlspecialchars($city_name); ?>
          </h2>
          <p>
            Looking for premium <strong>Russea™ <?php echo htmlspecialchars($keyword_name); ?></strong> in
            <strong><?php echo htmlspecialchars($area_name); ?>, <?php echo htmlspecialchars($city_name); ?></strong>?
            <strong>NetsDial</strong> by GCM Enterprises is India's largest wholesale supplier of
            <strong>Russea™</strong> HDPE nets — supplying dealers, contractors and businesses across India.
          </p>
          <br>
          <p>
            We supply <strong>Russea™ <?php echo htmlspecialchars($keyword_name); ?></strong> to
            <?php echo htmlspecialchars($area_name); ?> and the entire <?php echo htmlspecialchars($city_name); ?> region
            at unbeatable wholesale prices. Our nets are manufactured from 100% virgin HDPE (High-Density Polyethylene),
            UV stabilized and designed for long-term performance in India's climate conditions.
          </p>
          <br>
          <p><strong>We are net suppliers, not installers.</strong> We supply to local dealers, installation contractors,
          builders and bulk buyers. Our Russea™ brand covers HDPE Braided Nets, HDPE Twisted Nets and HDPE Knotted Nets —
          the three main construction methods for premium netting products.</p>
          <br>
          <p><strong>Why choose Russea™ <?php echo htmlspecialchars($keyword_name); ?> from NetsDial in <?php echo htmlspecialchars($area_name); ?>?</strong></p>
          <ul style="margin:12px 0 0 4px;line-height:2.2">
            <li><i class="fas fa-check-circle" style="color:var(--success)"></i> &nbsp;Official Russea™ brand — registered trademark, guaranteed quality</li>
            <li><i class="fas fa-check-circle" style="color:var(--success)"></i> &nbsp;HDPE Braided, Twisted &amp; Knotted nets in all sizes</li>
            <li><i class="fas fa-check-circle" style="color:var(--success)"></i> &nbsp;Wholesale pricing — best rates in <?php echo htmlspecialchars($city_name); ?></li>
            <li><i class="fas fa-check-circle" style="color:var(--success)"></i> &nbsp;Fast delivery to <?php echo htmlspecialchars($area_name); ?> &amp; nearby areas</li>
            <li><i class="fas fa-check-circle" style="color:var(--success)"></i> &nbsp;GST invoices &amp; warranty cards with every order</li>
            <li><i class="fas fa-check-circle" style="color:var(--success)"></i> &nbsp;India's largest net supplier from South India</li>
            <li><i class="fas fa-check-circle" style="color:var(--success)"></i> &nbsp;10,000+ dealers serviced PAN India</li>
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
          <h3 style="margin-bottom:20px">Product Features - Russea™ <?php echo htmlspecialchars($keyword_name); ?></h3>
          <div class="features-grid" style="grid-template-columns:repeat(auto-fill,minmax(240px,1fr))">
            <div class="feature-card">
              <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
              <h4>UV Stabilized</h4>
              <p>100% UV stabilized HDPE material. Resists sun damage for 5-10 years.</p>
            </div>
            <div class="feature-card">
              <div class="feature-icon"><i class="fas fa-water"></i></div>
              <h4>Weatherproof</h4>
              <p>Rain, wind and humidity resistant. Perfect for <?php echo htmlspecialchars($city_name); ?> climate.</p>
            </div>
            <div class="feature-card">
              <div class="feature-icon"><i class="fas fa-dumbbell"></i></div>
              <h4>High Strength</h4>
              <p>High tensile HDPE fiber with excellent breaking strength.</p>
            </div>
            <div class="feature-card">
              <div class="feature-icon"><i class="fas fa-certificate"></i></div>
              <h4>Russea™ Brand</h4>
              <p>Genuine Russea™ trademark quality. India's most trusted net brand.</p>
            </div>
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

        <!-- Other Districts -->
        <div data-aos="fade-up" style="margin-top:24px">
          <h4 style="margin-bottom:14px"><?php echo htmlspecialchars($keyword_name); ?> in Other Cities</h4>
          <div class="keyword-tags">
            <?php foreach ($all_districts as $ad): ?>
            <?php if ($ad['slug'] !== $district_slug): ?>
            <a href="<?php echo SITE_URL; ?>/services/<?php echo $ad['slug']; ?>/<?php echo $area_slug; ?>/<?php echo $keyword_slug; ?>/" class="keyword-tag">
              <i class="fas fa-city"></i> <?php echo htmlspecialchars($keyword_name); ?> in <?php echo htmlspecialchars($ad['name']); ?>
            </a>
            <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Contact CTA -->
        <div style="background:var(--gradient-primary);border-radius:var(--radius-xl);padding:36px;margin-top:36px;color:var(--white);text-align:center" data-aos="fade-up">
          <h3 style="color:var(--white);margin-bottom:12px">Get <?php echo htmlspecialchars($keyword_name); ?> in <?php echo htmlspecialchars($area_name); ?></h3>
          <p style="color:rgba(255,255,255,.85);margin-bottom:24px">Contact us now for best wholesale price on Russea™ <?php echo htmlspecialchars($keyword_name); ?>.</p>
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
            ["What is the price of {$keyword_name} in {$area_name}?", "The price of {$keyword_name} in {$area_name}, {$city_name} depends on the quantity and specifications. For below 100 sqft, starting from ₹1500. For 100-250 sqft: ₹16-30/sqft. Contact us for exact pricing based on your requirements."],
            ["Do you supply {$keyword_name} to {$area_name}?", "Yes! NetsDial supplies premium Russea™ {$keyword_name} to {$area_name} and all areas of {$city_name}. Delivery within 1-3 working days."],
            ["Is Russea™ brand {$keyword_name} good quality?", "Russea™ is India's trusted HDPE net brand. All Russea™ {$keyword_name} are UV stabilized, weather resistant and high-strength. Life expectancy: 5-10 years."],
            ["Can I get {$keyword_name} installation in {$city_name}?", "We are primarily wholesale suppliers. We can guide you to professional installation partners in {$area_name}. For bulk orders, installation assistance is available in Hyderabad."],
            ["Do you provide warranty for {$keyword_name}?", "Yes! Russea™ {$keyword_name} comes with manufacturer warranty. Warranty cards can be generated for all purchases. Contact us for warranty details."],
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
