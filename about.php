<?php
define('NETSDIAL', true);
require_once __DIR__ . '/config/config.php';
trackVisitor();

$page_title       = 'About NetsDial – India\'s Largest Russea™ HDPE Net Wholesale Supplier | GCM Enterprises Hyderabad';
$page_description = 'NetsDial managed by GCM Enterprises is India\'s largest wholesale supplier of Russea™ HDPE nets. HDPE Braided, Twisted & Knotted pigeon nets, safety nets, cricket nets, invisible grills & artificial grass. Supplying all 28 states from Hyderabad, South India.';
$page_keywords    = 'about netsdial, gcm enterprises hyderabad, russea hdpe net wholesale india, largest net supplier south india, wholesale pigeon net supplier, hdpe braided net wholesale india, cricket net wholesale supplier india, russea brand nets, netsdial gcm enterprises karmanghat hyderabad';
$breadcrumb = [['Home',SITE_URL],['About','']];
include __DIR__ . '/includes/header.php';
?>

<!-- Page Hero -->
<section class="page-hero" style="background:linear-gradient(135deg,#1a1a2e 0%,#16213e 50%,#0f3460 100%)">
  <div class="page-hero-bg"></div>
  <div class="container page-hero-content">
    <div class="breadcrumb"><?php echo buildBreadcrumb($breadcrumb); ?></div>
    <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,107,0,.2);border:1px solid rgba(255,107,0,.4);color:#FF8C42;padding:6px 18px;border-radius:99px;font-size:.8rem;font-weight:700;margin-bottom:16px">
      <i class="fas fa-trademark"></i> Russea™ Authorised Wholesale Supplier &nbsp;|&nbsp; South India's Largest Net Supplier
    </div>
    <h1>About <span class="gradient-text">NetsDial</span></h1>
    <p style="max-width:680px;margin-inline:auto">
      Managed by <strong>GCM Enterprises</strong> — India's Largest Russea™ HDPE Net Wholesale Supplier.<br>
      HDPE Braided · HDPE Twisted · HDPE Knotted Nets · Supplying all 28 States from Hyderabad, South India.
    </p>
  </div>
</section>

<!-- Wholesale Announcement -->
<div class="wholesale-banner">
  <div class="container">
    <strong>🏆 We are NET SUPPLIERS, not installers</strong> &nbsp;|&nbsp;
    Wholesale Russea™ HDPE Nets &nbsp;|&nbsp;
    Largest from South India &nbsp;|&nbsp;
    <strong>PAN India Delivery to All 28 States</strong>
  </div>
</div>

<!-- Our Story -->
<section class="section-padding">
  <div class="container">
    <div class="about-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center">
      <div>
        <span class="section-badge">Our Story</span>
        <h2>India's Largest <span class="gradient-text">Russea™ Net Wholesale</span> Supplier</h2>
        <p style="font-size:1.05rem;line-height:1.8;margin-bottom:20px">
          <strong>NetsDial</strong>, managed by <strong>GCM Enterprises</strong>, was founded with a single mission:
          to bring premium quality <strong>Russea™</strong> branded HDPE nets to every dealer and business across
          India at the best wholesale prices. From our base in Karmanghat, Hyderabad, we have grown into
          <strong>South India's largest net wholesale supplier</strong> with a dealer network spanning all 28 states.
        </p>
        <p style="line-height:1.8;margin-bottom:20px">
          We are the authorised wholesale partner for <strong>Russea™</strong> branded nets —
          India's most trusted HDPE net trademark. We supply HDPE Braided Nets, HDPE Twisted Nets, and
          HDPE Knotted Nets for safety, bird control, sports, and home fittings.
          <strong>Every product we supply carries the Russea™ trademark.</strong>
        </p>
        <p style="line-height:1.8;margin-bottom:24px;color:var(--primary);font-weight:600">
          ⚠️ We are wholesale net SUPPLIERS, not installers.
          We supply to dealers, contractors and bulk buyers PAN India.
        </p>
        <div style="display:flex;gap:16px;flex-wrap:wrap">
          <div style="text-align:center;background:var(--off-white);padding:20px 28px;border-radius:var(--radius-lg);border:2px solid var(--primary)"><div style="font-size:2rem;font-weight:900;color:var(--primary)">10+</div><div style="font-size:.85rem;color:var(--text-light)">Years in Business</div></div>
          <div style="text-align:center;background:var(--off-white);padding:20px 28px;border-radius:var(--radius-lg);border:1px solid var(--border)"><div style="font-size:2rem;font-weight:900;color:var(--primary)">10,000+</div><div style="font-size:.85rem;color:var(--text-light)">Dealers PAN India</div></div>
          <div style="text-align:center;background:var(--off-white);padding:20px 28px;border-radius:var(--radius-lg);border:1px solid var(--border)"><div style="font-size:2rem;font-weight:900;color:var(--primary)">28</div><div style="font-size:.85rem;color:var(--text-light)">States Supplied</div></div>
          <div style="text-align:center;background:var(--off-white);padding:20px 28px;border-radius:var(--radius-lg);border:1px solid var(--border)"><div style="font-size:2rem;font-weight:900;color:var(--primary)">#1</div><div style="font-size:.85rem;color:var(--text-light)">South India Supplier</div></div>
        </div>
      </div>
      <div>
        <img src="<?php echo SITE_URL; ?>/assets/images/services/about-team.jpg" alt="NetsDial GCM Enterprises Team" style="width:100%;border-radius:var(--radius-xl);box-shadow:var(--shadow-xl)" onerror="this.src='https://images.unsplash.com/photo-1552664730-d307ca884978?w=600&q=80'">
      </div>
    </div>
  </div>
</section>

<!-- What We Supply -->
<section class="section-padding" style="background:var(--off-white)">
  <div class="container">
    <div class="section-header">
      <span class="section-badge">Russea™ Products</span>
      <h2>Our <span class="gradient-text">Russea™</span> Wholesale Product Range</h2>
      <p>Every product carries the Russea™ registered trademark — HDPE Braided, Twisted &amp; Knotted nets built to last</p>
    </div>
    <div class="services-grid" style="grid-template-columns:repeat(auto-fill,minmax(280px,1fr))">
      <?php
      $products = [
        ['fa-shield-alt','Safety & Pigeon Nets','HDPE Braided Pigeon Nets, Balcony Safety Nets, Children Safety Nets. All UV stabilized, weather resistant.','#FF6B00'],
        ['fa-crow','Bird Control Products','Anti-Bird Nets, Pigeon Spikes (SS & Polycarbonate), Bird Barriers. Humane & permanent solutions.','#8B5CF6'],
        ['fa-home','Invisible Grills','SS Wire Invisible Grills for balconies and windows. Aesthetic safety without bars.','#10B981'],
        ['fa-tshirt','Cloth Hangers','SS Ceiling & Wall Mounted Cloth Hangers. Space-saving, rust-free solutions.','#3B82F6'],
        ['fa-leaf','Artificial Grass & Turf','Russe™ brand artificial grass in 25mm-50mm pile heights. Single & double layer.','#22C55E'],
        ['fa-baseball-ball','Cricket & Sports Nets','HDPE Cricket Nets, Football Nets, Volleyball Nets, Box Cricket Setup nets. Professional grade.','#EF4444'],
      ];
      foreach ($products as $p):
      ?>
      <div class="service-card" style="--card-accent:<?php echo $p[3]; ?>">
        <div class="service-icon" style="background:<?php echo $p[3]; ?>20;color:<?php echo $p[3]; ?>"><i class="fas <?php echo $p[0]; ?>"></i></div>
        <h3><?php echo $p[1]; ?></h3>
        <p><?php echo $p[2]; ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Why Choose Us -->
<section class="section-padding">
  <div class="container">
    <div class="section-header">
      <span class="section-badge">Why NetsDial</span>
      <h2>Why Choose Us as Your <span class="gradient-text">Net Supplier?</span></h2>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:24px">
      <?php
      $whys = [
        ['fa-trademark','Russe™ Trademark Quality','Every net we supply carries the registered Russe™ trademark — your assurance of premium HDPE quality.'],
        ['fa-warehouse','Wholesale Pricing','Direct from manufacturer to dealers and bulk buyers. No middleman markup. Best prices for retailers.'],
        ['fa-truck','PAN India Supply','We supply to all 28 states and 8 UTs. Fast, reliable delivery from our Hyderabad warehouse.'],
        ['fa-certificate','HDPE Specialists','HDPE Braided, HDPE Twisted, HDPE Knotted nets — we manufacture and supply every variant.'],
        ['fa-award','Largest Cricket Net Supplier','South India\'s #1 wholesale supplier of cricket nets. Bulk orders welcome from grounds and clubs.'],
        ['fa-headset','Dedicated Support','Our expert team helps you choose the right product, size, and specification for your requirement.'],
      ];
      foreach ($whys as $w):
      ?>
      <div class="feature-card" style="display:flex;gap:20px;padding:28px;background:#fff;border-radius:var(--radius-lg);border:1px solid var(--border);box-shadow:var(--shadow-sm)">
        <div style="width:56px;height:56px;min-width:56px;background:linear-gradient(135deg,#FF6B00,#FF8C42);border-radius:var(--radius-lg);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.25rem"><i class="fas <?php echo $w[0]; ?>"></i></div>
        <div><h4 style="margin-bottom:8px;font-size:1rem"><?php echo $w[1]; ?></h4><p style="font-size:.9rem;color:var(--text-light);line-height:1.7"><?php echo $w[2]; ?></p></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Company Details -->
<section class="section-padding" style="background:linear-gradient(135deg,#1a1a2e,#0f3460);color:#fff">
  <div class="container">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center">
      <div>
        <span class="section-badge" style="background:rgba(255,107,0,.2);color:#FF8C42;border-color:rgba(255,107,0,.3)">Company Details</span>
        <h2 style="color:#fff;margin-bottom:24px">GCM Enterprises</h2>
        <p style="color:rgba(255,255,255,.8);line-height:1.8;margin-bottom:24px">GCM Enterprises is the parent company managing NetsDial. We are registered wholesale suppliers of Russe™ branded HDPE nets. Our manufacturing facility and warehouse are located in Karmanghat, Saroornagar, Hyderabad.</p>
        <div style="space-y:12px">
          <?php foreach ([
            ['fa-map-marker-alt','Office','Plot No.91, Road Number 2, Sri Ram Nagar Colony, Karmanghat, Saroornagar - 500035, Hyderabad, Telangana, India'],
            ['fa-phone','Phone','+91 '.getSetting('site_phone','9966499144')],
            ['fa-envelope','Email',getSetting('site_email','netsdial@gmail.com')],
          ] as $d): ?>
          <div style="display:flex;gap:16px;margin-bottom:16px;align-items:flex-start">
            <div style="width:40px;height:40px;min-width:40px;background:rgba(255,107,0,.2);border-radius:var(--radius);display:flex;align-items:center;justify-content:center;color:#FF6B00;font-size:1rem"><i class="fas <?php echo $d[0]; ?>"></i></div>
            <div><div style="font-size:.8rem;color:rgba(255,255,255,.5);margin-bottom:2px"><?php echo $d[1]; ?></div><div style="color:#fff"><?php echo htmlspecialchars($d[2]); ?></div></div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3807.744!2d78.528!3d17.338!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTfCsDIwJzE2LjgiTiA3OMKwMzEnNDEuMSJF!5e0!3m2!1sen!2sin!4v1000000000000" width="100%" height="350" style="border:0;border-radius:var(--radius-lg);box-shadow:var(--shadow-lg)" allowfullscreen="" loading="lazy"></iframe>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="section-padding">
  <div class="container">
    <div style="text-align:center;max-width:600px;margin:0 auto">
      <h2>Ready to Partner with India's Largest Net Supplier?</h2>
      <p style="margin-bottom:32px;color:var(--text-light)">Contact us for bulk orders, dealer pricing, and custom requirements. We supply Russe™ nets across India.</p>
      <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap">
        <a href="/contact" class="btn-primary btn-lg">Get Wholesale Pricing</a>
        <a href="tel:+91<?php echo getSetting('site_phone','9966499144'); ?>" class="btn-secondary btn-lg"><i class="fas fa-phone"></i> Call Now</a>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
