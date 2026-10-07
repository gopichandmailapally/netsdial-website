<?php
/**
 * NetsDial - Services Directory & Service Hub
 * Handles:
 *  - /services.php                               (All Services Directory)
 *  - /services.php?service={slug}                (Service Product Details)
 *  - /services.php?district={slug}               (District Services Overview)
 *  - /services.php?district={slug}&area={slug}   (Area Services Overview)
 *  - /services.php?q={query}                     (Service Search)
 */
define('NETSDIAL', true);
require_once __DIR__ . '/config/config.php';
trackVisitor();

function is_core_installation_hub($state, $district_slug) {
    $state_norm = strtolower(trim($state ?? ''));
    if ($state_norm === 'telangana' || $state_norm === 'andhra pradesh') {
        return true;
    }
    $hub_slugs = ['chennai', 'bangalore', 'bengaluru', 'pune', 'hyderabad', 'visakhapatnam', 'vijayawada'];
    return in_array(strtolower(trim($district_slug ?? '')), $hub_slugs);
}

function is_russea_brand($slug) {
    // Only nets, ropes, and twines are Russea™ branded
    $russea_slugs = [
        'pigeon-netting',
        'bird-netting',
        'anti-bird-nets',
        'balcony-safety-nets',
        'children-safety-nets',
        'sports-practice-nets',
        'box-cricket-nets'
    ];
    return in_array($slug, $russea_slugs);
}


// 1. Capture and sanitize inputs
$district_slug = cleanInput($_GET['district'] ?? '');
$area_slug     = cleanInput($_GET['area'] ?? '');
$service_slug  = cleanInput($_GET['service'] ?? '');
$search_q      = cleanInput($_GET['q'] ?? '');

// Fallback regex matching from REQUEST_URI if accessed via Nginx rewritten paths
$uri = strtok($_SERVER['REQUEST_URI'] ?? '', '?');
if (empty($district_slug) && preg_match('#^/services/([a-z0-9-]+)/([a-z0-9-]+)/?$#i', $uri, $m)) {
    $district_slug = cleanInput($m[1]);
    $area_slug     = cleanInput($m[2]);
} elseif (empty($district_slug) && preg_match('#^/services/([a-z0-9-]+)/?$#i', $uri, $m)) {
    $district_slug = cleanInput($m[1]);
}

// 2. Fetch Base Data
$all_categories = ['All', 'Safety & Bird Control', 'Sports & Recreation', 'Home Fittings'];
$category_filter = cleanInput($_GET['category'] ?? 'All');

// Service metadata mapping (icon, colors, gradients)
$service_meta = [
    'pigeon-netting'             => ['fa-dove',         'linear-gradient(135deg,#0f2027,#203a43,#2c5364)', '#4ecdc4', '0.80mm - 1.00mm', '25mm - 30mm', '₹12 - ₹25 / sq ft'],
    'bird-netting'               => ['fa-feather-alt',  'linear-gradient(135deg,#1a1a2e,#16213e,#0f3460)', '#74b9ff', '0.80mm - 1.20mm', '20mm - 40mm', '₹14 - ₹28 / sq ft'],
    'anti-bird-nets'             => ['fa-shield-alt',   'linear-gradient(135deg,#2d3561,#c05c7e,#f3826f)', '#fd79a8', '1.00mm - 1.50mm', '25mm - 50mm', '₹15 - ₹30 / sq ft'],
    'balcony-safety-nets'        => ['fa-home',         'linear-gradient(135deg,#134e5e,#1a5276,#1f618d)', '#00cec9', '1.50mm - 2.50mm', '40mm - 50mm', '₹18 - ₹35 / sq ft'],
    'children-safety-nets'       => ['fa-child',        'linear-gradient(135deg,#11998e,#38ef7d,#11998e)', '#00b894', '2.00mm - 3.00mm', '40mm - 45mm', '₹20 - ₹38 / sq ft'],
    'pigeon-spikes'              => ['fa-thumbtack',    'linear-gradient(135deg,#373b44,#4286f4,#373b44)', '#74b9ff', 'SS 304 Grade',     '100mm - 120mm', '₹65 - ₹110 / ft'],
    'anti-bird-spikes'           => ['fa-bolt',         'linear-gradient(135deg,#642b73,#c6426e,#642b73)', '#fd79a8', 'Polycarb / SS',    '110mm Width',   '₹70 - ₹120 / ft'],
    'polycarbonate-spikes'       => ['fa-layer-group',  'linear-gradient(135deg,#1c1c1c,#414345,#1c1c1c)', '#b2bec3', 'Virgin Polycarb',  'UV Stabilized', '₹55 - ₹95 / ft'],
    'ss-bird-spikes'             => ['fa-star',         'linear-gradient(135deg,#0f3460,#533483,#0f3460)', '#a29bfe', 'Marine SS 316',    'Rust Proof',    '₹90 - ₹150 / ft'],
    'invisible-grills'           => ['fa-border-all',   'linear-gradient(135deg,#232526,#414345,#232526)', '#dfe6e9', '2.5mm - 3.0mm SS', '2" / 3" Gap',     '₹110 - ₹150 / sq ft'],
    'ss-invisible-grills'        => ['fa-bars',         'linear-gradient(135deg,#1a1a1a,#3d5a80,#1a1a1a)', '#74b9ff', 'SS 316 Marine',    'Nylon Coated',  '₹120 - ₹165 / sq ft'],
    'cloth-hangers-installation' => ['fa-tshirt',       'linear-gradient(135deg,#2c3e50,#4ca1af,#2c3e50)', '#81ecec', 'SS Pulley Pipes',  '4ft - 8ft 6-pipe', '₹1,800 - ₹3,500 set'],
    'ss-cloth-hangers'           => ['fa-wind',         'linear-gradient(135deg,#1a1a2e,#4a90a4,#1a1a2e)', '#74b9ff', 'Rustproof SS 202/304', 'Ceiling Mounted', '₹2,200 - ₹4,200 set'],
    'artificial-grass'           => ['fa-seedling',     'linear-gradient(135deg,#134e5e,#71b280,#134e5e)', '#00b894', '25mm - 50mm Pile', 'Multi-Tone UV',  '₹45 - ₹95 / sq ft'],
    'artificial-turf'            => ['fa-leaf',         'linear-gradient(135deg,#0a3d2e,#1e8449,#0a3d2e)', '#55efc4', '40mm - 60mm FIFA', 'Heavy Density',  '₹75 - ₹140 / sq ft'],
    'cricket-ground-pitch-turf'  => ['fa-baseball-ball','linear-gradient(135deg,#1b2631,#2e4057,#3d5a80)', '#fdcb6e', '15mm - 20mm Dense', 'Non-Directional', '₹60 - ₹120 / sq ft'],
    'sports-practice-nets'       => ['fa-table-tennis', 'linear-gradient(135deg,#1a1a2e,#533483,#c84b31)', '#fd79a8', '1.5mm - 2.5mm Braided', '40mm - 45mm BCCI', '₹18 - ₹36 / sq ft'],
    'box-cricket-nets'           => ['fa-th',           'linear-gradient(135deg,#0f2027,#2c5364,#0f2027)', '#74b9ff', '2.5mm - 3.0mm Braided', '40mm BCCI Pitch', '₹22 - ₹42 / sq ft'],
    'box-cricket-setup'          => ['fa-building',     'linear-gradient(135deg,#1b2631,#2e4057,#1b2631)', '#fdcb6e', 'Turnkey GI Cages', '100x60 - 120x70', '₹3.5L - ₹9.5L Turnkey']
];

// 3. Determine View Mode
$mode = 'directory';
$district = null;
$area = null;
$single_service = null;

if (!empty($district_slug)) {
    $district = db()->fetchOne('SELECT * FROM districts WHERE slug = ? AND is_active = 1', [$district_slug]);
    if ($district && !empty($area_slug)) {
        $area = db()->fetchOne('SELECT * FROM areas WHERE district_id = ? AND slug = ? AND is_active = 1', [$district['id'], $area_slug]);
        if ($area) {
            $mode = 'area';
        } else {
            $mode = 'district';
        }
    } elseif ($district) {
        $mode = 'district';
    }
} elseif (!empty($service_slug)) {
    $single_service = db()->fetchOne('SELECT * FROM service_keywords WHERE slug = ? AND is_active = 1', [$service_slug]);
    if ($single_service) {
        $mode = 'service';
    }
}

// 4. Mode-Specific SEO & Meta Tags
if ($mode === 'area') {
    $is_hub = is_core_installation_hub($district['state'] ?? '', $district['slug'] ?? '');
    if ($is_hub) {
        $page_title       = "Russea™ Net Supply & Installation in {$area['name']}, {$district['name']} | NetsDial";
        $page_description = "Certified supply & doorstep installation of genuine Russea™ safety nets, pigeon netting, invisible grills and cloth hangers in {$area['name']}, {$district['name']}. Same-day inspection & quote.";
    } else {
        $page_title       = "Russea™ HDPE Net Wholesale Supply in {$area['name']}, {$district['name']} | NetsDial";
        $page_description = "Direct material roll supply of Russea™ HDPE nets dispatched to {$area['name']}, {$district['name']}. Pan-India turnkey installation available for cricket net grounds (≥ 13,200 sq ft / 4 bags).";
    }
    $page_keywords    = "{$area['name']} safety nets, pigeon nets {$area['name']}, russea net dealer {$district['name']}, netsdial {$area['name']}";
    $breadcrumb       = [
        ['Home', SITE_URL],
        ['Services', SITE_URL . '/services.php'],
        [$district['name'], SITE_URL . '/services.php?district=' . $district['slug']],
        [$area['name'], '']
    ];
} elseif ($mode === 'district') {
    $is_hub = is_core_installation_hub($district['state'] ?? '', $district['slug'] ?? '');
    if ($is_hub) {
        $page_title       = "Russea™ Net Supply & Installation Hub in {$district['name']}, {$district['state']} | NetsDial";
        $page_description = "Official supply and certified doorstep installation of Russea™ HDPE nets, pigeon netting, balcony safety nets, invisible grills & sports turf across {$district['name']}.";
    } else {
        $page_title       = "Russea™ HDPE Net Wholesale Supply in {$district['name']}, {$district['state']} | NetsDial";
        $page_description = "Factory direct wholesale roll supply of Russea™ HDPE nets to {$district['name']}, {$district['state']}. On-site installation across India for cricket nets ≥ 13,200 sq ft (4 bags).";
    }
    $page_keywords    = "{$district['name']} net wholesale, russea nets {$district['name']}, balcony safety nets {$district['name']}, sports nets {$district['name']}";
    $breadcrumb       = [
        ['Home', SITE_URL],
        ['Services', SITE_URL . '/services.php'],
        [$district['name'], '']
    ];
} elseif ($mode === 'service') {
    $svc_name = $single_service['name'];
    $slug = $single_service['slug'];
    if (is_russea_brand($slug)) {
        $page_title       = "Russea™ {$svc_name} – Factory Direct Wholesale Supply & Setup | NetsDial";
        $page_description = "Source genuine Russea™ {$svc_name} directly from NetsDial (GCM Enterprises). 100% virgin HDPE, UV 600 KLY stabilization, certified 5-year warranty. Wholesale rolls & turnkey setup PAN India.";
        $page_keywords    = "russea {$slug}, wholesale {$svc_name}, hdpe {$svc_name} manufacturers, buy {$svc_name} india";
    } elseif ($slug === 'invisible-grills' || $slug === 'ss-invisible-grills') {
        $page_title       = "{$svc_name} (SS 316 Marine Grade) – Supply & Installation | NetsDial";
        $page_description = "High-tensile SS 316 marine grade invisible grills for balconies and windows. 400+ kg breaking load, rust-proof, unobstructed views. Direct supply and certified installation by NetsDial (GCM Enterprises).";
        $page_keywords    = "invisible grills, ss invisible grills, balcony invisible grills cost, ss 316 wire grills, netsdial";
    } elseif ($slug === 'cloth-hangers-installation' || $slug === 'ss-cloth-hangers') {
        $page_title       = "{$svc_name} (Ceiling Pulley System) – Supply & Installation | NetsDial";
        $page_description = "Rust-proof stainless steel ceiling cloth drying hangers with dual-pulley gear systems. Space-saving, high load bearing (up to 30 kg). Direct supply and professional installation by NetsDial.";
        $page_keywords    = "cloth drying hangers, ceiling cloth hangers, ss cloth hangers, balcony cloth dryer, netsdial";
    } elseif ($slug === 'artificial-grass' || $slug === 'artificial-turf' || $slug === 'cricket-ground-pitch-turf') {
        $page_title       = "{$svc_name} (25mm–50mm High Density) – Supply & Turf Laying | NetsDial";
        $page_description = "High-density multi-tone artificial grass and FIFA-spec sports turf for box cricket, football grounds, and balconies. Heavy double latex backing, all-weather UV protection. Turnkey supply & laying by NetsDial.";
        $page_keywords    = "artificial grass, football turf, cricket pitch turf, synthetic grass price, box cricket turf, netsdial";
    } elseif ($slug === 'box-cricket-setup') {
        $page_title       = "Turnkey Box Cricket Ground Setup – Commercial Arena Construction | NetsDial";
        $page_description = "End-to-end commercial box cricket arena construction: GI steel structure, genuine Russea™ heavy braided enclosure netting, high-density artificial grass turf, and LED sports lighting. Complete turnkey handover in 7–14 days by NetsDial.";
        $page_keywords    = "box cricket ground setup cost, box cricket construction, cricket turf construction contractors, netsdial";
    } else {
        $page_title       = "{$svc_name} – Supply & Professional Installation | NetsDial";
        $page_description = "Professional supply and installation of {$svc_name} across India. Direct wholesale pricing and certified durability by NetsDial (GCM Enterprises).";
        $page_keywords    = "{$slug}, wholesale {$svc_name}, buy {$svc_name} india, netsdial";
    }
    $breadcrumb       = [
        ['Home', SITE_URL],
        ['Services', SITE_URL . '/services.php'],
        [$svc_name, '']
    ];
} else {
    $page_title       = "Russea™ HDPE Net Products & Wholesale Services | South India's #1 Net Supplier | NetsDial";
    $page_description = "NetsDial by GCM Enterprises is India's largest wholesale distributor of Russea™ HDPE nets. Pigeon netting, balcony safety nets, cricket cages, invisible grills and turf setup across 28 states.";
    $page_keywords    = "russea net wholesale, hdpe net suppliers india, pigeon net wholesale hyderabad, box cricket ground setup cost, invisible grill wholesale";
    $breadcrumb       = [
        ['Home', SITE_URL],
        ['Services', '']
    ];
}

// Fetch all active services
$services_sql = 'SELECT * FROM service_keywords WHERE is_active = 1';
$sql_params = [];
if (!empty($search_q)) {
    $services_sql .= ' AND (name LIKE ? OR short_desc LIKE ? OR category LIKE ?)';
    $term = '%' . $search_q . '%';
    $sql_params = [$term, $term, $term];
} elseif ($category_filter !== 'All' && in_array($category_filter, $all_categories)) {
    $services_sql .= ' AND category = ?';
    $sql_params = [$category_filter];
}
$services_sql .= ' ORDER BY sort_order ASC, id ASC';
$services_list = db()->fetchAll($services_sql, $sql_params);

// Fetch top metro districts for city navigation
$top_districts = db()->fetchAll('SELECT id, name, slug, state FROM districts WHERE is_active = 1 ORDER BY sort_order ASC, id ASC LIMIT 24');

include __DIR__ . '/includes/header.php';
?>

<!-- ── Breadcrumb Bar ────────────────────────────────────────── -->
<div class="breadcrumb-bar" style="background:var(--off-white);padding:14px 0;border-bottom:1px solid var(--border)">
  <div class="container">
    <div class="breadcrumb" style="font-size:.9rem;display:flex;align-items:center;gap:8px;flex-wrap:wrap;color:var(--text-medium)">
      <?php foreach ($breadcrumb as $idx => $bc): ?>
        <?php if ($idx > 0): ?><span class="sep" style="color:#ccc"><i class="fas fa-chevron-right" style="font-size:.75rem"></i></span><?php endif; ?>
        <?php if (!empty($bc[1])): ?>
          <a href="<?php echo htmlspecialchars($bc[1]); ?>" style="color:var(--text-dark);text-decoration:none;font-weight:500"><?php echo htmlspecialchars($bc[0]); ?></a>
        <?php else: ?>
          <span class="current" style="color:var(--primary);font-weight:700"><?php echo htmlspecialchars($bc[0]); ?></span>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<!-- ── Wholesale Announcement Ribbon ────────────────────────── -->
<div class="wholesale-banner" style="background:linear-gradient(90deg,#e65100,#f57c00);color:#ffffff !important;padding:10px 0;font-size:.95rem;text-align:center;box-shadow:var(--shadow-sm);border-bottom:1px solid rgba(255,255,255,0.25)">
  <div class="container" style="color:#ffffff !important;display:flex;align-items:center;justify-content:center;flex-wrap:wrap;gap:8px 14px">
    <span class="wholesale-banner-item" style="color:#ffffff !important;font-weight:800;letter-spacing:0.02em"><i class="fas fa-trademark"></i> Russea™ Authorized Wholesale Supplier</span>
    <span class="banner-sep" style="color:rgba(255,255,255,0.7)">|</span>
    <span class="wholesale-banner-item" style="color:#ffffff !important;font-weight:600">HDPE Braided · Twisted · Knotted Nets</span>
    <span class="banner-sep" style="color:rgba(255,255,255,0.7)">|</span>
    <span class="wholesale-banner-item" style="color:#ffffff !important;font-weight:600">South India's Largest Net Supply Hub</span>
    <span class="banner-sep" style="color:rgba(255,255,255,0.7)">|</span>
    <span class="wholesale-banner-item" style="color:#ffffff !important;font-weight:800">PAN India Delivery to All 28 States</span>
    <span class="banner-sep" style="color:rgba(255,255,255,0.7)">|</span>
    <a href="tel:+919966499144" style="color:#ffffff !important;background:rgba(0,0,0,0.25);padding:4px 14px;border-radius:99px;text-decoration:none;font-weight:800;display:inline-flex;align-items:center;gap:6px;border:1px solid rgba(255,255,255,0.4)"><i class="fas fa-phone-alt" style="color:#ffffff !important"></i> +91 99664 99144</a>
  </div>
</div>

<?php if ($mode === 'directory'): ?>
<!-- ═══════════════════════════════════════════════════════════
     MODE: MASTER SERVICES DIRECTORY
════════════════════════════════════════════════════════════ -->

<!-- Hero Section -->
<section class="page-hero" style="background:linear-gradient(135deg,#0a1128 0%,#16213e 50%,#1f4068 100%);color:#fff;padding:60px 0 50px;text-align:center;position:relative;overflow:hidden">
  <div class="container" style="position:relative;z-index:2;max-width:900px">
    <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,107,0,.25);border:1px solid rgba(255,107,0,.6);color:#FF8C42;padding:6px 18px;border-radius:99px;font-size:.82rem;font-weight:700;letter-spacing:.05em;margin-bottom:18px">
      <i class="fas fa-shield-alt"></i> Russea™ Industrial Technical Netting & Turnkey Sports Cages
    </div>
    <h1 style="font-size:clamp(1.8rem,4vw,2.9rem);font-weight:900;line-height:1.2;margin-bottom:16px;color:#fff">
      Russea™ HDPE Net Solutions & <span style="color:#FF8C42">Wholesale Services</span>
    </h1>
    <p style="font-size:1.05rem;line-height:1.7;color:rgba(255,255,255,.85);margin-bottom:28px;max-width:760px;margin-inline:auto">
      Source certified 100% Virgin HDPE netting rolls, SS 316 invisible grills, and turnkey box cricket / football sports turf setups directly from <strong>NetsDial (GCM Enterprises)</strong> — India's premier wholesale distribution hub.
    </p>

    <!-- Search Form -->
    <form action="<?php echo SITE_URL; ?>/services.php" method="GET" style="max-width:600px;margin:0 auto 20px;display:flex;gap:8px;background:rgba(255,255,255,.12);backdrop-filter:blur(10px);padding:8px;border-radius:99px;border:1px solid rgba(255,255,255,.25)">
      <input type="text" name="q" value="<?php echo htmlspecialchars($search_q); ?>" placeholder="Search nets, cricket turf, invisible grills, bird spikes..." style="flex:1;background:transparent;border:none;outline:none;padding:10px 20px;color:#fff;font-size:1rem">
      <button type="submit" class="btn btn-primary" style="border-radius:99px;padding:10px 24px;border:none;cursor:pointer;font-weight:700">
        <i class="fas fa-search"></i> Search
      </button>
    </form>
    <?php if (!empty($search_q)): ?>
      <p style="font-size:.9rem;color:#FF8C42">Showing results for: <strong>"<?php echo htmlspecialchars($search_q); ?>"</strong> &nbsp;|&nbsp; <a href="<?php echo SITE_URL; ?>/services.php" style="color:#fff;text-decoration:underline">Clear Search</a></p>
    <?php endif; ?>
  </div>
</section>

<!-- Category Filter Tabs -->
<div style="background:#fff;border-bottom:1px solid var(--border);position:sticky;top:70px;z-index:100;box-shadow:var(--shadow-sm)">
  <div class="container" style="display:flex;gap:12px;overflow-x:auto;padding:12px 15px;scrollbar-width:none;align-items:center;justify-content:center">
    <?php foreach ($all_categories as $cat): ?>
      <a href="<?php echo SITE_URL; ?>/services.php<?php echo $cat !== 'All' ? '?category=' . urlencode($cat) : ''; ?>"
         class="filter-tab-btn"
         style="padding:8px 20px;border-radius:99px;font-size:.88rem;font-weight:700;text-decoration:none;white-space:nowrap;transition:all .3s;<?php echo $category_filter === $cat ? 'background:var(--primary);color:#fff;box-shadow:0 4px 12px rgba(255,107,0,.3);' : 'background:var(--off-white);color:var(--text-dark);border:1px solid var(--border);'; ?>">
        <?php echo htmlspecialchars($cat); ?>
      </a>
    <?php endforeach; ?>
  </div>
</div>

<!-- Services Grid Section -->
<section class="section section-padding" style="background:var(--off-white);padding:50px 0">
  <div class="container">

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:30px;flex-wrap:wrap;gap:15px">
      <div>
        <h2 style="font-size:1.6rem;font-weight:800;color:var(--text-dark);margin-bottom:4px">
          <?php echo $category_filter !== 'All' ? htmlspecialchars($category_filter) : 'All Products &amp; Turnkey Services'; ?>
        </h2>
        <p style="color:var(--text-medium);font-size:.92rem">
          Showing <?php echo count($services_list); ?> certified wholesale solutions with direct factory specs
        </p>
      </div>
      <div style="display:flex;gap:10px">
        <a href="tel:+919966499144" class="btn btn-primary" style="font-size:.85rem;padding:8px 18px">
          <i class="fas fa-phone-alt"></i> Call Hotline
        </a>
        <a href="<?php echo SITE_URL; ?>/estimation.php" class="btn btn-secondary" style="font-size:.85rem;padding:8px 18px">
          <i class="fas fa-calculator"></i> Rate Calculator
        </a>
      </div>
    </div>

    <!-- Cards Grid -->
    <div class="services-grid">
      <?php foreach ($services_list as $svc):
        $meta = $service_meta[$svc['slug']] ?? ['fa-shield-alt', 'linear-gradient(135deg,#1a1a1a,#333,#1a1a1a)', '#FF6B00', '1.0mm - 2.5mm', 'Custom Mesh', 'Wholesale Rates'];
        $img_file = '/assets/images/services/' . $svc['slug'] . '.jpg';
        $service_url = SITE_URL . '/services.php?service=' . $svc['slug'];
      ?>
      <div class="service-card" data-aos="fade-up" style="background:#fff;border-radius:var(--radius-lg);overflow:hidden;box-shadow:var(--shadow-md);border:1px solid var(--border);display:flex;flex-direction:column">
        
        <!-- Image Wrap -->
        <div class="service-card-img-wrap" style="height:210px;position:relative;overflow:hidden;background:<?php echo $meta[1]; ?>">
          <img src="<?php echo $img_file; ?>"
               alt="<?php echo is_russea_brand($svc['slug']) ? 'Russea™ ' : ''; ?><?php echo htmlspecialchars($svc['name']); ?>"
               class="service-card-img"
               style="width:100%;height:100%;object-fit:cover;display:block;transition:transform .5s"
               loading="lazy" decoding="async"
               onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
          <div style="display:none;position:absolute;inset:0;background:<?php echo $meta[1]; ?>;align-items:center;justify-content:center">
            <i class="fas <?php echo $meta[0]; ?>" style="font-size:3.5rem;color:<?php echo $meta[2]; ?>;opacity:0.9"></i>
          </div>
          <span class="service-card-badge" style="position:absolute;top:12px;left:12px;background:var(--primary);color:#fff;padding:4px 12px;border-radius:99px;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;z-index:2">
            <?php echo htmlspecialchars($svc['category']); ?>
          </span>
          <span style="position:absolute;bottom:10px;right:10px;background:rgba(0,0,0,.7);backdrop-filter:blur(4px);color:#fff;font-size:.75rem;padding:3px 10px;border-radius:6px;font-weight:600">
            <?php if (is_russea_brand($svc['slug'])): ?>
              <i class="fas fa-certificate" style="color:#FF8C42"></i> Russea™ Genuine
            <?php elseif (in_array($svc['slug'], ['invisible-grills', 'ss-invisible-grills'])): ?>
              <i class="fas fa-shield-alt" style="color:#74b9ff"></i> SS 316 Marine Grade
            <?php elseif (in_array($svc['slug'], ['cloth-hangers-installation', 'ss-cloth-hangers'])): ?>
              <i class="fas fa-tshirt" style="color:#81ecec"></i> Rust-Proof SS
            <?php elseif (in_array($svc['slug'], ['artificial-grass', 'artificial-turf', 'cricket-ground-pitch-turf'])): ?>
              <i class="fas fa-leaf" style="color:#55efc4"></i> High Density Turf
            <?php elseif ($svc['slug'] === 'box-cricket-setup'): ?>
              <i class="fas fa-trophy" style="color:#fdcb6e"></i> Turnkey Arena
            <?php else: ?>
              <i class="fas fa-bolt" style="color:#fd79a8"></i> Polycarb / SS
            <?php endif; ?>
          </span>
        </div>

        <!-- Body -->
        <div class="service-card-body" style="padding:22px;flex:1;display:flex;flex-direction:column">
          <h3 style="font-size:1.2rem;font-weight:800;color:var(--text-dark);margin-bottom:8px;line-height:1.3">
            <?php echo htmlspecialchars($svc['name']); ?>
          </h3>
          <p style="font-size:.9rem;color:var(--text-medium);line-height:1.6;margin-bottom:16px;flex:1">
            <?php echo htmlspecialchars($svc['short_desc']); ?>
          </p>

          <!-- Specifications Mini-Table -->
          <div style="background:var(--off-white);padding:10px 14px;border-radius:8px;font-size:.82rem;margin-bottom:18px;border:1px solid rgba(0,0,0,.05)">
            <div style="display:flex;justify-content:space-between;margin-bottom:4px">
              <span style="color:var(--text-light)">Thickness / Type:</span>
              <strong style="color:var(--text-dark)"><?php echo $meta[3]; ?></strong>
            </div>
            <div style="display:flex;justify-content:space-between;margin-bottom:4px">
              <span style="color:var(--text-light)">Mesh / Dimension:</span>
              <strong style="color:var(--text-dark)"><?php echo $meta[4]; ?></strong>
            </div>
            <div style="display:flex;justify-content:space-between">
              <span style="color:var(--text-light)">Wholesale Benchmark:</span>
              <strong style="color:var(--primary)"><?php echo $meta[5]; ?></strong>
            </div>
          </div>

          <!-- Buttons -->
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
            <a href="<?php echo $service_url; ?>" class="btn btn-secondary" style="padding:10px 12px;font-size:.85rem;text-align:center;font-weight:700">
              Specs & Details
            </a>
            <a href="tel:+919966499144" class="btn btn-primary" style="padding:10px 12px;font-size:.85rem;text-align:center;font-weight:700">
              <i class="fas fa-phone-alt"></i> Buy Wholesale
            </a>
          </div>

        </div>
      </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<!-- ── Nationwide City & District Directory ──────────────────── -->
<section class="section" style="padding:60px 0;background:#fff;border-top:1px solid var(--border)">
  <div class="container">
    <div style="text-align:center;max-width:750px;margin:0 auto 35px">
      <span class="section-badge"><i class="fas fa-map-marker-alt"></i> Pan-India Presence</span>
      <h2 style="font-size:1.8rem;font-weight:800;color:var(--text-dark);margin:10px 0">
        Supplying <span style="color:var(--primary)">All 28 States & 755+ Districts</span>
      </h2>
      <p style="color:var(--text-medium);font-size:.95rem">
        NetsDial provides direct wholesale roll dispatch and turnkey installation services across all major cities and industrial belts in India. Select your city to explore local availability:
      </p>
    </div>

    <!-- Cities Grid -->
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:12px;margin-bottom:35px">
      <?php foreach ($top_districts as $td): ?>
      <a href="<?php echo SITE_URL; ?>/services.php?district=<?php echo $td['slug']; ?>"
         style="display:flex;align-items:center;justify-content:space-between;padding:12px 16px;background:var(--off-white);border:1px solid var(--border);border-radius:var(--radius-md);text-decoration:none;color:var(--text-dark);font-size:.9rem;font-weight:600;transition:all .2s">
        <span><i class="fas fa-map-pin" style="margin-right:8px;color:#FF8C42;font-size:.8rem"></i><?php echo htmlspecialchars($td['name']); ?></span>
        <i class="fas fa-arrow-right" style="font-size:.75rem;opacity:.7"></i>
      </a>
      <?php endforeach; ?>
    </div>

    <!-- Commercial Features Grid -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:24px;margin-top:50px">
      <div style="padding:26px;background:var(--off-white);border-radius:var(--radius-lg);border-left:4px solid var(--primary)">
        <h4 style="font-size:1.1rem;font-weight:800;margin-bottom:8px"><i class="fas fa-industry" style="color:var(--primary)"></i> 100% Virgin HDPE Extrusion</h4>
        <p style="font-size:.88rem;color:var(--text-medium);line-height:1.6">Zero recycled materials. Every Russea™ roll features certified UV 600 KLY stabilization for 6 to 9 years extreme outdoor weather endurance.</p>
      </div>
      <div style="padding:26px;background:var(--off-white);border-radius:var(--radius-lg);border-left:4px solid #00b894">
        <h4 style="font-size:1.1rem;font-weight:800;margin-bottom:8px"><i class="fas fa-truck" style="color:#00b894"></i> Pan-India Dispatch Hub</h4>
        <p style="font-size:.88rem;color:var(--text-medium);line-height:1.6">Centrally dispatched from our Hyderabad master warehouse with door-delivery logistics to contractors, dealers, and builders across all 28 states.</p>
      </div>
      <div style="padding:26px;background:var(--off-white);border-radius:var(--radius-lg);border-left:4px solid #0984e3">
        <h4 style="font-size:1.1rem;font-weight:800;margin-bottom:8px"><i class="fas fa-trophy" style="color:#0984e3"></i> Turnkey Box Cricket & Turf</h4>
        <p style="font-size:.88rem;color:var(--text-medium);line-height:1.6">Full project execution: GI pipe cages (25–35 ft truss), BCCI-spec netting, FIFA artificial grass, and LED floodlighting setup.</p>
      </div>
    </div>

  </div>
</section>

<?php elseif ($mode === 'service'): ?>
<!-- ═══════════════════════════════════════════════════════════
     MODE: SINGLE SERVICE DEEP-DIVE
════════════════════════════════════════════════════════════ -->
<?php
$svc = $single_service;
$meta = $service_meta[$svc['slug']] ?? ['fa-shield-alt', 'linear-gradient(135deg,#1a1a1a,#333,#1a1a1a)', '#FF6B00', '1.0mm - 2.5mm', 'Custom Mesh', 'Wholesale Rates'];
$img_file = '/assets/images/services/' . $svc['slug'] . '.jpg';
?>

<section class="page-hero" style="background:linear-gradient(135deg,#0a1128 0%,#16213e 50%,#1f4068 100%);color:#fff;padding:60px 0 50px;text-align:center">
  <div class="container" style="max-width:850px">
    <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,107,0,.25);border:1px solid rgba(255,107,0,.6);color:#FF8C42;padding:6px 18px;border-radius:99px;font-size:.82rem;font-weight:700;margin-bottom:18px">
      <?php if (is_russea_brand($svc['slug'])): ?>
        <i class="fas fa-certificate"></i> Russea™ Certified Wholesale Specification
      <?php elseif (in_array($svc['slug'], ['invisible-grills', 'ss-invisible-grills'])): ?>
        <i class="fas fa-shield-alt"></i> SS 316 Marine Grade Architectural Specification
      <?php elseif (in_array($svc['slug'], ['cloth-hangers-installation', 'ss-cloth-hangers'])): ?>
        <i class="fas fa-tshirt"></i> Stainless Steel Ceiling Pulley System
      <?php elseif (in_array($svc['slug'], ['artificial-grass', 'artificial-turf', 'cricket-ground-pitch-turf'])): ?>
        <i class="fas fa-seedling"></i> High-Density All-Weather Sports &amp; Landscape Turf
      <?php elseif ($svc['slug'] === 'box-cricket-setup'): ?>
        <i class="fas fa-trophy"></i> Turnkey Sports Arena Construction
      <?php else: ?>
        <i class="fas fa-thumbtack"></i> 100% Virgin Polycarbonate &amp; SS Specification
      <?php endif; ?>
    </div>
    <h1 style="font-size:clamp(1.8rem,4vw,2.8rem);font-weight:900;line-height:1.25;margin-bottom:16px;color:#fff">
      <?php if (is_russea_brand($svc['slug'])): ?>
        Russea™ <span style="color:#FF8C42"><?php echo htmlspecialchars($svc['name']); ?></span>
      <?php elseif ($svc['slug'] === 'box-cricket-setup'): ?>
        Turnkey <span style="color:#FF8C42">Box Cricket Ground Setup</span>
      <?php else: ?>
        <span style="color:#FF8C42"><?php echo htmlspecialchars($svc['name']); ?></span>
      <?php endif; ?>
    </h1>
    <p style="font-size:1.05rem;line-height:1.7;color:rgba(255,255,255,.85);margin-bottom:28px">
      <?php echo htmlspecialchars($svc['short_desc']); ?>
    </p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
      <a href="tel:+919966499144" class="btn btn-primary btn-lg">
        <i class="fas fa-phone-alt"></i> Get Wholesale Pricing
      </a>
      <a href="https://api.whatsapp.com/send?phone=919966499144&text=Hello%20NetsDial,%20I%20am%20interested%20in%20<?php echo urlencode((is_russea_brand($svc['slug']) ? 'Russea ' : '') . $svc['name']); ?>%20rates." target="_blank" rel="noopener" class="btn btn-whatsapp btn-lg">
        <i class="fab fa-whatsapp"></i> WhatsApp Inquiry
      </a>
      <a href="<?php echo SITE_URL; ?>/services.php" class="btn btn-secondary btn-lg">
        <i class="fas fa-th"></i> All Services
      </a>
    </div>
  </div>
</section>

<!-- Service Details Section -->
<section class="section section-padding" style="background:#fff;padding:60px 0">
  <div class="container">
    <div style="display:grid;grid-template-columns:1.1fr 0.9fr;gap:50px;align-items:start">
      
      <div>
        <span class="section-badge"><?php echo htmlspecialchars($svc['category']); ?></span>
        <h2 style="font-size:1.8rem;font-weight:800;color:var(--text-dark);margin:12px 0 16px">
          Technical Engineering & Manufacturing Standards
        </h2>
        <p style="font-size:1rem;color:var(--text-medium);line-height:1.8;margin-bottom:20px">
          <?php if (is_russea_brand($svc['slug'])): ?>
            Manufactured by <strong>Russea Technical Fibres</strong> and distributed nationally by <strong>NetsDial (GCM Enterprises)</strong>, our genuine Russea™ <?php echo htmlspecialchars($svc['name']); ?> incorporates 100% virgin polymer granules treated with <strong>Grade-A 600 KLY HALS (Hindered Amine Light Stabilizers)</strong> for unprecedented UV and weather resilience.
          <?php elseif (in_array($svc['slug'], ['invisible-grills', 'ss-invisible-grills'])): ?>
            Supplied and installed by <strong>NetsDial (GCM Enterprises)</strong>, our <?php echo htmlspecialchars($svc['name']); ?> utilizes high-tensile <strong>AISI 316 Marine Grade Stainless Steel Wire Rope</strong> encased in transparent UV-resistant nylon coating. Tested for 400+ kg breaking load, offering modern transparent fall safety without blocking views or breezes.
          <?php elseif (in_array($svc['slug'], ['cloth-hangers-installation', 'ss-cloth-hangers'])): ?>
            Supplied and installed by <strong>NetsDial (GCM Enterprises)</strong>, our <?php echo htmlspecialchars($svc['name']); ?> features premium <strong>Rust-Proof Stainless Steel Pipes</strong> connected via precision high-strength pulley mechanisms. Perfect for modern apartments to dry clothes effortlessly without taking up balcony floor space.
          <?php elseif (in_array($svc['slug'], ['artificial-grass', 'artificial-turf', 'cricket-ground-pitch-turf'])): ?>
            Supplied and laid by <strong>NetsDial (GCM Enterprises)</strong>, our <?php echo htmlspecialchars($svc['name']); ?> incorporates high-density <strong>Virgin Polyethylene (PE) &amp; Polypropylene (PP)</strong> synthetic fibres with multi-tone natural coloration and heavy double-layer latex backing with drainage perforations.
          <?php elseif ($svc['slug'] === 'box-cricket-setup'): ?>
            Engineered and executed by <strong>NetsDial (GCM Enterprises)</strong>, our turnkey box cricket grounds combine heavy-gauge GI structural steel framing, authentic <strong>Russea™ Heavy-Duty Braided Enclosure Nets</strong>, certified shock-absorbing artificial turf, and high-mast LED illumination for complete commercial arena operation.
          <?php else: ?>
            Supplied and installed by <strong>NetsDial (GCM Enterprises)</strong>, our <?php echo htmlspecialchars($svc['name']); ?> features 100% virgin UV-stabilized polycarbonate base strips with high-grade marine stainless steel deterrent rods.
          <?php endif; ?>
        </p>

        <!-- Product Specs Table -->
        <div style="background:var(--off-white);border-radius:var(--radius-lg);padding:24px;border:1px solid var(--border);margin-bottom:25px">
          <h4 style="font-size:1.1rem;font-weight:800;color:var(--text-dark);margin-bottom:16px">
            <i class="fas fa-list-check" style="color:var(--primary)"></i> Factory Specifications
          </h4>
          <table style="width:100%;border-collapse:collapse;font-size:.92rem">
            <tr style="border-bottom:1px solid #eee">
              <td style="padding:10px 0;color:var(--text-medium)"><strong>Material Base:</strong></td>
              <td style="padding:10px 0;text-align:right;font-weight:600">
                <?php if (is_russea_brand($svc['slug'])): ?>
                  100% Virgin High-Density Polyethylene (HDPE)
                <?php elseif (in_array($svc['slug'], ['invisible-grills', 'ss-invisible-grills'])): ?>
                  AISI 316 Marine Grade Stainless Steel (Nylon Coated)
                <?php elseif (in_array($svc['slug'], ['cloth-hangers-installation', 'ss-cloth-hangers'])): ?>
                  Rust-Proof Stainless Steel (SS 202/304 Grade)
                <?php elseif (in_array($svc['slug'], ['artificial-grass', 'artificial-turf', 'cricket-ground-pitch-turf'])): ?>
                  Virgin Polyethylene (PE) &amp; Polypropylene (PP)
                <?php elseif ($svc['slug'] === 'box-cricket-setup'): ?>
                  GI Structural Steel + Russea™ Braided Nets + Sports Turf
                <?php else: ?>
                  Virgin Polycarbonate Base + SS 304/316 Steel Spikes
                <?php endif; ?>
              </td>
            </tr>
            <tr style="border-bottom:1px solid #eee">
              <td style="padding:10px 0;color:var(--text-medium)"><strong>Durability / Treatment:</strong></td>
              <td style="padding:10px 0;text-align:right;font-weight:600">
                <?php if (is_russea_brand($svc['slug'])): ?>
                  600 KLY HALS (6–9 Years Weather Endurance)
                <?php elseif (in_array($svc['slug'], ['invisible-grills', 'ss-invisible-grills'])): ?>
                  400+ kg Breaking Load, Rust-Proof Marine Tested
                <?php elseif (in_array($svc['slug'], ['cloth-hangers-installation', 'ss-cloth-hangers'])): ?>
                  Heavy-Duty Pulley Gear (Up to 30 kg Wet Laundry)
                <?php elseif (in_array($svc['slug'], ['artificial-grass', 'artificial-turf', 'cricket-ground-pitch-turf'])): ?>
                  Double Latex Backing &amp; UV All-Weather Resilience
                <?php elseif ($svc['slug'] === 'box-cricket-setup'): ?>
                  Commercial Arena Grade (Heavy Wind &amp; Impact Rated)
                <?php else: ?>
                  100% Rust-Proof &amp; Non-Conductive Base
                <?php endif; ?>
              </td>
            </tr>
            <tr style="border-bottom:1px solid #eee">
              <td style="padding:10px 0;color:var(--text-medium)"><strong>Standard Thickness:</strong></td>
              <td style="padding:10px 0;text-align:right;font-weight:600"><?php echo $meta[3]; ?></td>
            </tr>
            <tr style="border-bottom:1px solid #eee">
              <td style="padding:10px 0;color:var(--text-medium)"><strong>Mesh / Gauge:</strong></td>
              <td style="padding:10px 0;text-align:right;font-weight:600"><?php echo $meta[4]; ?></td>
            </tr>
            <tr style="border-bottom:1px solid #eee">
              <td style="padding:10px 0;color:var(--text-medium)"><strong>Quality Benchmark:</strong></td>
              <td style="padding:10px 0;text-align:right;font-weight:600">ISO 9001:2015 Quality Tested</td>
            </tr>
            <tr>
              <td style="padding:10px 0;color:var(--text-medium)"><strong>Warranty:</strong></td>
              <td style="padding:10px 0;text-align:right;font-weight:700;color:#00b894">5-Year Comprehensive Warranty</td>
            </tr>
          </table>
        </div>

      </div>

      <!-- Image & Fast Quote Box -->
      <div>
        <div style="border-radius:var(--radius-lg);overflow:hidden;box-shadow:var(--shadow-lg);margin-bottom:25px">
          <img src="<?php echo $img_file; ?>" alt="<?php echo is_russea_brand($svc['slug']) ? 'Russea™ ' : ''; ?><?php echo htmlspecialchars($svc['name']); ?>" style="width:100%;height:320px;object-fit:cover;display:block">
        </div>

        <div style="background:var(--off-white);padding:26px;border-radius:var(--radius-lg);border:1px solid var(--border);text-align:center">
          <h3 style="font-size:1.3rem;font-weight:800;color:var(--text-dark);margin-bottom:8px">Order Factory Rolls Direct</h3>
          <p style="font-size:.9rem;color:var(--text-medium);margin-bottom:20px">Wholesale roll orders dispatched within 24 hours PAN India.</p>
          <div style="font-size:1.6rem;font-weight:900;color:var(--primary);margin-bottom:16px">
            <?php echo $meta[5]; ?>
          </div>
          <a href="tel:+919966499144" class="btn btn-primary btn-block" style="font-size:1rem;padding:12px;font-weight:700;margin-bottom:10px">
            <i class="fas fa-phone-alt"></i> Call +91 99664 99144
          </a>
          <a href="<?php echo SITE_URL; ?>/estimation.php" class="btn btn-secondary btn-block" style="font-size:.9rem;padding:10px">
            <i class="fas fa-calculator"></i> Calculate Exact Price
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

<?php elseif ($mode === 'district' || $mode === 'area'): ?>
<!-- ═══════════════════════════════════════════════════════════
     MODE: DISTRICT / AREA OVERVIEW
════════════════════════════════════════════════════════════ -->
<?php
$loc_title = $mode === 'area' ? $area['name'] . ', ' . $district['name'] : $district['name'] . ', ' . $district['state'];
// Fetch areas for this district
$district_areas = db()->fetchAll('SELECT id, name, slug FROM areas WHERE district_id = ? AND is_active = 1 ORDER BY sort_order ASC, name ASC LIMIT 36', [$district['id']]);
$active_area_slug = $area ? $area['slug'] : (!empty($district_areas) ? $district_areas[0]['slug'] : 'main');
?>

<?php $is_hub_loc = is_core_installation_hub($district['state'] ?? '', $district['slug'] ?? ''); ?>
<section class="page-hero" style="background:linear-gradient(135deg,#0a1128 0%,#16213e 50%,#1f4068 100%);color:#fff;padding:60px 0 50px;text-align:center">
  <div class="container" style="max-width:850px">
    <div style="display:inline-flex;align-items:center;gap:8px;background:<?php echo $is_hub_loc ? 'rgba(0,184,148,.25)' : 'rgba(255,107,0,.25)'; ?>;border:1px solid <?php echo $is_hub_loc ? 'rgba(0,184,148,.6)' : 'rgba(255,107,0,.6)'; ?>;color:<?php echo $is_hub_loc ? '#55efc4' : '#FF8C42'; ?>;padding:6px 18px;border-radius:99px;font-size:.82rem;font-weight:700;margin-bottom:18px">
      <?php if ($is_hub_loc): ?>
        <i class="fas fa-check-circle"></i> Full Supply &amp; Doorstep Installation Hub
      <?php else: ?>
        <i class="fas fa-truck"></i> Pan-India Material Supply &amp; Specialized Arena Setup
      <?php endif; ?>
    </div>
    <h1 style="font-size:clamp(1.8rem,4vw,2.8rem);font-weight:900;line-height:1.25;margin-bottom:16px;color:#fff">
      <?php if ($is_hub_loc): ?>
        Net Supply &amp; Installation in <span style="color:#FF8C42"><?php echo htmlspecialchars($loc_title); ?></span>
      <?php else: ?>
        Russea™ Net Wholesale Supply in <span style="color:#FF8C42"><?php echo htmlspecialchars($loc_title); ?></span>
      <?php endif; ?>
    </h1>
    <p style="font-size:1.05rem;line-height:1.7;color:rgba(255,255,255,.85);margin-bottom:28px">
      <?php if ($is_hub_loc): ?>
        Complete sales, fast supply, and certified doorstep installation for all safety nets, pigeon nets, invisible grills, cloth drying hangers, and sports turf across <?php echo htmlspecialchars($loc_title); ?>. Dispatched &amp; installed directly by NetsDial technicians.
      <?php else: ?>
        Fast factory-direct material roll dispatch across all 28 states within 24–48 hours. Certified turnkey installation available nationwide for Cricket Nets &amp; Commercial Box Cricket Grounds (Orders &ge; 13,200 SQ FT / 4 Bags).
      <?php endif; ?>
    </p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
      <a href="tel:+919966499144" class="btn btn-primary btn-lg">
        <i class="fas fa-phone-alt"></i> Call <?php echo htmlspecialchars($district['name']); ?> Desk
      </a>
      <a href="<?php echo SITE_URL; ?>/services.php" class="btn btn-secondary btn-lg">
        <i class="fas fa-th"></i> All Services
      </a>
    </div>
  </div>
</section>

<!-- Areas in District -->
<?php if (!empty($district_areas)): ?>
<div style="background:var(--off-white);padding:20px 0;border-bottom:1px solid var(--border)">
  <div class="container">
    <div style="font-size:.85rem;font-weight:700;color:var(--text-medium);margin-bottom:10px;text-transform:uppercase;letter-spacing:.05em">
      <i class="fas fa-location-dot" style="color:var(--primary)"></i> Localities in <?php echo htmlspecialchars($district['name']); ?>:
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap">
      <?php foreach ($district_areas as $da): ?>
        <a href="<?php echo SITE_URL; ?>/services.php?district=<?php echo $district['slug']; ?>&area=<?php echo $da['slug']; ?>"
           style="padding:6px 14px;border-radius:99px;font-size:.82rem;font-weight:600;text-decoration:none;<?php echo ($area && $area['slug'] === $da['slug']) ? 'background:var(--primary);color:#fff;' : 'background:#fff;color:var(--text-dark);border:1px solid var(--border);'; ?>">
          <?php echo htmlspecialchars($da['name']); ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Services Available in Location Grid -->
<section class="section section-padding" style="background:#fff;padding:50px 0">
  <div class="container">
    <h2 style="font-size:1.6rem;font-weight:800;color:var(--text-dark);margin-bottom:8px">
      All Netting & Sports Services in <?php echo htmlspecialchars($loc_title); ?>
    </h2>
    <p style="color:var(--text-medium);font-size:.92rem;margin-bottom:30px">
      Click any service below to view localized pricing, warranty terms, and booking options for <?php echo htmlspecialchars($loc_title); ?>:
    </p>

    <div class="services-grid">
      <?php foreach ($services_list as $svc):
        $meta = $service_meta[$svc['slug']] ?? ['fa-shield-alt', 'linear-gradient(135deg,#1a1a1a,#333,#1a1a1a)', '#FF6B00', '1.0mm - 2.5mm', 'Custom Mesh', 'Wholesale Rates'];
        $img_file = '/assets/images/services/' . $svc['slug'] . '.jpg';
        $loc_service_url = SITE_URL . '/services/' . $district['slug'] . '/' . $active_area_slug . '/' . $svc['slug'] . '/';
      ?>
      <div class="service-card" style="background:#fff;border-radius:var(--radius-lg);overflow:hidden;box-shadow:var(--shadow-md);border:1px solid var(--border);display:flex;flex-direction:column">
        <div class="service-card-img-wrap" style="height:180px;position:relative;overflow:hidden;background:<?php echo $meta[1]; ?>">
          <img src="<?php echo $img_file; ?>" alt="<?php echo htmlspecialchars($svc['name']); ?> in <?php echo htmlspecialchars($district['name']); ?>" class="service-card-img" style="width:100%;height:100%;object-fit:cover" loading="lazy" decoding="async">
          <span class="service-card-badge" style="position:absolute;top:10px;left:10px;background:var(--primary);color:#fff;padding:3px 10px;border-radius:99px;font-size:.7rem;font-weight:700">
            <?php echo htmlspecialchars($svc['category']); ?>
          </span>
        </div>
        <div class="service-card-body" style="padding:20px;flex:1;display:flex;flex-direction:column">
          <h3 style="font-size:1.15rem;font-weight:800;color:var(--text-dark);margin-bottom:6px">
            <?php echo htmlspecialchars($svc['name']); ?>
          </h3>
          <p style="font-size:.85rem;color:var(--text-medium);line-height:1.5;margin-bottom:14px;flex:1">
            <?php echo htmlspecialchars($svc['short_desc']); ?>
          </p>
          <div style="margin-bottom:10px;font-size:.78rem;font-weight:700">
            <?php if ($is_hub_loc): ?>
              <span style="color:#00b894"><i class="fas fa-tools"></i> Supply &amp; Doorstep Installation</span>
            <?php elseif (in_array($svc['slug'], ['cricket-practice-nets', 'box-cricket-nets', 'box-cricket-setup'])): ?>
              <span style="color:#fdcb6e"><i class="fas fa-trophy"></i> Nationwide Setup (&ge; 13,200 sq ft)</span>
            <?php else: ?>
              <span style="color:#0984e3"><i class="fas fa-truck"></i> Factory Material Roll Supply</span>
            <?php endif; ?>
          </div>
          <a href="<?php echo $loc_service_url; ?>" class="btn btn-primary btn-block" style="font-size:.85rem;padding:9px;text-align:center;font-weight:700">
            View Details in <?php echo htmlspecialchars($mode === 'area' ? $area['name'] : $district['name']); ?> <i class="fas fa-arrow-right" style="margin-left:6px"></i>
          </a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<?php endif; ?>

<!-- ── Contact / Inquiry Banner ──────────────────────────────── -->
<section style="background:linear-gradient(135deg,#FF6B00,#FF8C42);color:#fff;padding:45px 0;text-align:center">
  <div class="container" style="max-width:800px">
    <h2 style="font-size:1.8rem;font-weight:900;color:#fff;margin-bottom:12px">Need Wholesale Net Rolls or Project Estimation?</h2>
    <p style="font-size:1.05rem;color:rgba(255,255,255,.9);margin-bottom:24px">
      Direct factory rates for contractors, builders, dealers, and sports clubs across India.
    </p>
    <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap">
      <a href="tel:+919966499144" class="btn" style="background:#fff;color:var(--primary);font-weight:800;padding:12px 28px;border-radius:var(--radius-md);box-shadow:var(--shadow-md)">
        <i class="fas fa-phone-alt"></i> Call +91 99664 99144
      </a>
      <a href="https://api.whatsapp.com/send?phone=919966499144&text=Hello%20NetsDial,%20I%20would%20like%20a%20wholesale%20quotation%20for%20Russea%20nets." target="_blank" rel="noopener" class="btn btn-whatsapp" style="padding:12px 28px">
        <i class="fab fa-whatsapp"></i> WhatsApp Us
      </a>
      <a href="<?php echo SITE_URL; ?>/contact.php" class="btn btn-secondary" style="background:rgba(0,0,0,.3);border-color:rgba(255,255,255,.5);color:#fff;padding:12px 28px">
        <i class="fas fa-envelope"></i> Send Inquiry
      </a>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
