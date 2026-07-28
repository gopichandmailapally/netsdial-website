<?php
/**
 * NetsDial - Home Page
 * GCM Enterprises | Russea™ Net Suppliers
 */
define('NETSDIAL', true);
require_once __DIR__ . '/config/config.php';

// SEO Meta
$page_title       = "NetsDial – India's Largest Russea™ HDPE Net Wholesale Supplier | Pigeon Nets | Safety Nets | Cricket Nets | Hyderabad";
$page_description = "NetsDial by GCM Enterprises is India's #1 wholesale supplier of Russea™ HDPE nets — pigeon netting, balcony safety nets, bird control nets, invisible grills, cricket nets & artificial grass. Supplying dealers & businesses PAN India from Hyderabad. Call +91 9966499144.";
$page_keywords    = "russea hdpe net wholesale supplier india, pigeon net wholesale hyderabad, balcony safety net supplier india, cricket net wholesale south india, bird control net supplier hyderabad, invisible grill wholesale, artificial grass wholesale india, gcm enterprises hyderabad, hdpe braided net supplier, hdpe twisted net wholesale, largest net supplier south india, pigeon netting hyderabad, safety nets hyderabad, bird netting hyderabad, anti bird net supplier, box cricket net wholesale";

// Fetch data
$sliders      = db()->fetchAll("SELECT * FROM sliders WHERE is_active=1 ORDER BY sort_order LIMIT 6");
$offers       = db()->fetchAll("SELECT * FROM offers WHERE is_active=1 AND (valid_to IS NULL OR valid_to >= CURDATE()) ORDER BY id DESC LIMIT 4");
$services     = db()->fetchAll("SELECT * FROM service_keywords WHERE is_active=1 ORDER BY sort_order");
$feat_reviews = db()->fetchAll("SELECT * FROM reviews WHERE is_approved=1 AND is_featured=1 ORDER BY created_at DESC LIMIT 9");
$all_reviews  = db()->fetchAll("SELECT * FROM reviews WHERE is_approved=1 ORDER BY created_at DESC LIMIT 12");
$latest_blogs = db()->fetchAll("SELECT id,title,slug,excerpt,image_path,category,author,created_at FROM blogs WHERE is_published=1 ORDER BY created_at DESC LIMIT 6");
$gallery_imgs = db()->fetchAll("SELECT * FROM gallery WHERE is_active=1 ORDER BY sort_order LIMIT 8");

include __DIR__ . '/includes/header.php';
?>

<!-- ═══════════════════════════════════════════════════════
     HERO SLIDER (16:9 Aspect Ratio)
════════════════════════════════════════════════════════ -->
<section class="hero-slider">
  <div class="swiper hero-swiper">
    <div class="swiper-wrapper">
      <?php if (!empty($sliders)): ?>
        <?php foreach ($sliders as $slide): ?>
        <div class="swiper-slide">
          <?php
          $slideBg = (!empty($slide['image_path']) && $slide['image_path'] !== '')
            ? 'background-image:url(\'' . SITE_URL . '/' . htmlspecialchars($slide['image_path']) . '\');background-color:#1a1a2e'
            : 'background:linear-gradient(135deg,#1a1a2e 0%,#16213e 50%,#0f3460 100%)';
          ?>
          <div class="slide-bg" style="<?php echo $slideBg; ?>"></div>
          <div class="slide-overlay"></div>
          <div class="slide-content container">
            <span class="slide-badge">
              <i class="fas fa-certificate"></i> Russea™ Authorized Dealer
            </span>
            <h1 class="slide-title">
              <?php
              $words = explode(' ', $slide['title'], 2);
              echo '<span class="orange">' . htmlspecialchars($words[0]) . '</span>';
              echo isset($words[1]) ? ' ' . htmlspecialchars($words[1]) : '';
              ?>
            </h1>
            <p class="slide-text"><?php echo htmlspecialchars($slide['subtitle']); ?></p>
            <div class="slide-btns">
              <a href="<?php echo SITE_URL . '/' . htmlspecialchars($slide['button_link']); ?>" class="btn btn-primary btn-lg">
                <i class="fas fa-phone-alt"></i> <?php echo htmlspecialchars($slide['button_text']); ?>
              </a>
              <a href="<?php echo SITE_WHATSAPP; ?>" target="_blank" class="btn btn-whatsapp btn-lg">
                <i class="fab fa-whatsapp"></i> WhatsApp Us
              </a>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Default slides when no DB data -->
        <?php
        $default_slides = [
          ['Pigeon Netting Solutions', 'India\'s #1 Russea™ HDPE Pigeon Net Wholesale Suppliers. Best quality, Lowest Price, Free Delivery.', 'linear-gradient(135deg,#0f2027 0%,#203a43 50%,#2c5364 100%)'],
          ['Balcony Safety Nets', 'Protect your loved ones with Russea™ Premium Balcony Safety Nets. Child & Pet Friendly. UV Stabilized.', 'linear-gradient(135deg,#1a1a2e 0%,#16213e 50%,#0f3460 100%)'],
          ['Invisible Grills', 'Modern Stainless Steel Invisible Grills for Balconies & Windows. Maintain your view, ensure safety.', 'linear-gradient(135deg,#0d0d0d 0%,#1a1a1a 50%,#2d2d2d 100%)'],
          ['Artificial Grass & Turf', 'Premium Artificial Grass for Homes, Terraces & Sports Grounds. Low maintenance, high durability.', 'linear-gradient(135deg,#134e5e 0%,#1a5276 50%,#1f618d 100%)'],
          ['Box Cricket Setup', 'Complete Box Cricket Ground Construction. Nets + Turf + Structure + Flooring.', 'linear-gradient(135deg,#1b2631 0%,#2e4057 50%,#3d5a80 100%)'],
          ['SS Cloth Hangers', 'Premium SS Cloth Drying Systems for Balconies. Space-saving & weather-proof. Easy operation.', 'linear-gradient(135deg,#2c3e50 0%,#3d5a6e 50%,#4a7089 100%)'],
        ];
        foreach ($default_slides as $ds): ?>
        <div class="swiper-slide">
          <div class="slide-bg" style="background:<?php echo $ds[2]; ?>"></div>
          <div class="slide-overlay"></div>
          <div class="slide-content container">
            <span class="slide-badge"><i class="fas fa-certificate"></i> Russea™ Authorized Dealer</span>
            <h1 class="slide-title"><span class="orange"><?php echo explode(' ', $ds[0])[0]; ?></span> <?php echo implode(' ', array_slice(explode(' ', $ds[0]), 1)); ?></h1>
            <p class="slide-text"><?php echo $ds[1]; ?></p>
            <div class="slide-btns">
              <a href="contact.php" class="btn btn-primary btn-lg"><i class="fas fa-phone-alt"></i> Get Free Quote</a>
              <a href="<?php echo SITE_WHATSAPP; ?>" target="_blank" class="btn btn-whatsapp btn-lg"><i class="fab fa-whatsapp"></i> WhatsApp</a>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
  </div>
</section>

<!-- ── Wholesale Announcement Strip ───────────────────────── -->
<div class="wholesale-banner">
  <div class="container">
    <strong>🏆 India's Largest Wholesale Supplier of Russea™ HDPE Nets</strong>
    &nbsp;|&nbsp; HDPE Braided · HDPE Twisted · HDPE Knotted Nets
    &nbsp;|&nbsp; Managed by <strong>GCM Enterprises</strong>, Hyderabad
    &nbsp;|&nbsp; <strong>PAN India Delivery</strong> &nbsp;|&nbsp;
    <a href="tel:+919966499144" style="color:#FF8C42;font-weight:700">📞 +91 9966499144</a>
  </div>
</div>

<!-- ═══════════════════════════════════════════════════════
     QUICK CONTACT + OFFERS (Side by Side)
════════════════════════════════════════════════════════ -->
<section class="contact-offer-row">
  <div class="container">
    <div class="contact-offer-grid">

      <!-- Quick Contact Form -->
      <div class="quick-contact-card" data-aos="fade-right">
        <h3>Get <span>Free Quote</span> Now</h3>
        <p>Fill the form below and our expert will contact you within 2-4 hours.</p>
        <form action="<?php echo SITE_URL; ?>/api/contact.php" method="POST" data-ajax="true" id="quickContactForm">
          <input type="hidden" name="source_page" value="<?php echo htmlspecialchars(SITE_URL . '/'); ?>">
          <input type="text" name="website" style="display:none" tabindex="-1" autocomplete="off"> <!-- Honeypot -->

          <div class="form-row">
            <div class="form-group form-icon">
              <label>Your Name *</label>
              <i class="fas fa-user"></i>
              <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
            </div>
            <div class="form-group form-icon">
              <label>Phone Number *</label>
              <i class="fas fa-phone"></i>
              <input type="tel" name="phone" class="form-control" placeholder="10-digit mobile no." required maxlength="10">
            </div>
          </div>

          <div class="form-group form-icon">
            <label>Email Address</label>
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" class="form-control" placeholder="Your email (optional)">
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Service Required</label>
              <select name="service" class="form-control">
                <option value="">Select Service</option>
                <optgroup label="Safety & Bird Control">
                  <option>Pigeon Netting</option>
                  <option>Bird Netting</option>
                  <option>Anti Bird Nets</option>
                  <option>Balcony Safety Nets</option>
                  <option>Children Safety Nets</option>
                  <option>Pigeon Spikes</option>
                  <option>Anti Bird Spikes</option>
                  <option>SS Bird Spikes</option>
                  <option>Polycarbonate Spikes</option>
                </optgroup>
                <optgroup label="Home Fittings">
                  <option>Invisible Grills</option>
                  <option>SS Invisible Grills</option>
                  <option>Cloth Hangers Installation</option>
                  <option>SS Cloth Hangers</option>
                </optgroup>
                <optgroup label="Sports & Recreation">
                  <option>Artificial Grass</option>
                  <option>Artificial Turf</option>
                  <option>Cricket Ground Pitch Turf</option>
                  <option>Sports Practice Nets</option>
                  <option>Box Cricket Nets</option>
                  <option>Box Cricket Setup</option>
                </optgroup>
              </select>
            </div>
            <div class="form-group form-icon">
              <label>Your Location</label>
              <i class="fas fa-map-marker-alt"></i>
              <input type="text" name="location" class="form-control" placeholder="Area, City">
            </div>
          </div>

          <div class="form-group">
            <label>Message / Requirements</label>
            <textarea name="message" class="form-control" rows="3" placeholder="Describe your requirements..."></textarea>
          </div>

          <button type="submit" class="btn btn-primary w-100">
            <i class="fas fa-paper-plane"></i> Send Enquiry — Get Free Quote
          </button>

          <p style="font-size:.78rem;color:#9CA3AF;text-align:center;margin-top:10px">
            <i class="fas fa-lock"></i> 100% Privacy Protected. We never spam.
          </p>
        </form>
        <div class="form-success">
          <i class="fas fa-check-circle" style="color:var(--success);font-size:3rem;display:block;margin-bottom:12px"></i>
          <h4>Thank You!</h4>
          <p>We received your enquiry. Our team will call you within <strong>2-4 hours</strong>.</p>
          <a href="<?php echo SITE_WHATSAPP; ?>" target="_blank" class="btn btn-whatsapp mt-16">
            <i class="fab fa-whatsapp"></i> WhatsApp for Faster Response
          </a>
        </div>
      </div>

      <!-- Offers Panel -->
      <div class="offers-card" data-aos="fade-left">
        <h3><i class="fas fa-tags"></i> Special Offers</h3>
        <p>Exclusive deals for our valued customers. Grab these limited-time offers!</p>
        <?php if (!empty($offers)): ?>
          <?php foreach ($offers as $offer): ?>
          <div class="offer-item">
            <div class="offer-top">
              <span class="offer-title"><?php echo htmlspecialchars($offer['title']); ?></span>
              <span class="offer-discount">
                <?php if ($offer['discount_type'] === 'percentage'): ?>
                  <?php echo (int)$offer['discount_value']; ?>% OFF
                <?php elseif ($offer['discount_type'] === 'fixed'): ?>
                  ₹<?php echo number_format($offer['discount_value']); ?> OFF
                <?php else: ?>
                  FREE SERVICE
                <?php endif; ?>
              </span>
            </div>
            <p class="offer-desc"><?php echo htmlspecialchars($offer['description']); ?></p>
            <?php if ($offer['coupon_code']): ?>
            <div class="offer-code" title="Click to copy">
              <i class="fas fa-ticket-alt"></i>
              <span class="code-text"><?php echo htmlspecialchars($offer['coupon_code']); ?></span>
              <i class="fas fa-copy" style="font-size:.7rem;opacity:.6"></i>
            </div>
            <?php endif; ?>
            <?php if ($offer['valid_to']): ?>
            <p class="offer-valid"><i class="fas fa-clock"></i> Valid till: <?php echo date('d M Y', strtotime($offer['valid_to'])); ?></p>
            <?php endif; ?>
          </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="offer-item">
            <div class="offer-top">
              <span class="offer-title">Summer Special — 15% OFF</span>
              <span class="offer-discount">15% OFF</span>
            </div>
            <p class="offer-desc">Get 15% off on all pigeon netting and safety net orders above ₹5000.</p>
            <div class="offer-code"><i class="fas fa-ticket-alt"></i><span class="code-text">SUMMER15</span><i class="fas fa-copy" style="font-size:.7rem;opacity:.6"></i></div>
          </div>
          <div class="offer-item">
            <div class="offer-top">
              <span class="offer-title">Free Installation Offer</span>
              <span class="offer-discount">FREE</span>
            </div>
            <p class="offer-desc">Free professional installation on 300+ sq ft safety net purchases.</p>
            <div class="offer-code"><i class="fas fa-ticket-alt"></i><span class="code-text">FREEFIT300</span><i class="fas fa-copy" style="font-size:.7rem;opacity:.6"></i></div>
          </div>
          <div class="offer-item">
            <div class="offer-top">
              <span class="offer-title">Bulk Order 20% OFF</span>
              <span class="offer-discount">20% OFF</span>
            </div>
            <p class="offer-desc">Get 20% off on orders above ₹25,000. For wholesale buyers.</p>
            <div class="offer-code"><i class="fas fa-ticket-alt"></i><span class="code-text">BULK20</span><i class="fas fa-copy" style="font-size:.7rem;opacity:.6"></i></div>
          </div>
        <?php endif; ?>
        <div style="margin-top:20px;position:relative;z-index:1">
          <a href="contact.php" class="btn btn-outline-white w-100">
            <i class="fas fa-phone-alt"></i> Call for Best Deal: <?php echo SITE_PHONE; ?>
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     STATS BAR
════════════════════════════════════════════════════════ -->
<section class="stats-section">
  <div class="container">
    <div class="stats-grid-main">
      <div class="stat-card" data-aos="zoom-in" data-aos-delay="0">
        <i class="fas fa-users stat-icon"></i>
        <span class="stat-number" data-target="5000">5,000+</span>
        <span class="stat-label-main">Happy Customers</span>
      </div>
      <div class="stat-card" data-aos="zoom-in" data-aos-delay="100">
        <i class="fas fa-map-marker-alt stat-icon"></i>
        <span class="stat-number" data-target="150">150+</span>
        <span class="stat-label-main">Cities Covered</span>
      </div>
      <div class="stat-card" data-aos="zoom-in" data-aos-delay="200">
        <i class="fas fa-file-alt stat-icon"></i>
        <span class="stat-number" data-target="2850">2,850+</span>
        <span class="stat-label-main">Service Pages</span>
      </div>
      <div class="stat-card" data-aos="zoom-in" data-aos-delay="300">
        <i class="fas fa-trophy stat-icon"></i>
        <span class="stat-number" data-target="10">10+</span>
        <span class="stat-label-main">Years Experience</span>
      </div>
      <div class="stat-card" data-aos="zoom-in" data-aos-delay="400">
        <i class="fas fa-star stat-icon"></i>
        <span class="stat-number" data-target="150">150+</span>
        <span class="stat-label-main">5-Star Reviews</span>
      </div>
      <div class="stat-card" data-aos="zoom-in" data-aos-delay="500">
        <i class="fas fa-box stat-icon"></i>
        <span class="stat-number" data-target="50000">50,000+</span>
        <span class="stat-label-main">Sq Ft Supplied</span>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     WHY CHOOSE US
════════════════════════════════════════════════════════ -->
<section class="section">
  <div class="container">
    <div class="section-header" data-aos="fade-up">
      <span class="section-badge"><i class="fas fa-star"></i> Why NetsDial?</span>
      <h2 class="section-title">Hyderabad's Most Trusted <span class="highlight">Russea™ Net Supplier</span></h2>
      <p class="section-subtitle">GCM Enterprises authorized wholesale dealer — quality, trust & best price guaranteed across India.</p>
    </div>
    <div class="features-grid">
      <?php
      $features = [
        ['fa-certificate', 'Russea™ Authorized Dealer', 'Official authorized wholesale dealer of Russea™ branded HDPE safety nets, pigeon nets and sports nets across India.'],
        ['fa-shield-alt', 'Premium HDPE Quality', 'All nets made from 100% virgin HDPE material — UV stabilized, weather resistant, high tensile strength for 5-10 year life.'],
        ['fa-truck', 'Pan-India Delivery', 'We deliver Russea™ nets to all states and cities across India. Hyderabad: 1-2 days. Other cities: 3-7 days.'],
        ['fa-tags', 'Wholesale Prices', 'Direct wholesale prices without middlemen. Best rates in South India with guaranteed quality assurance.'],
        ['fa-headset', 'Expert Support', 'Technical guidance, installation tips and after-sales support from our experienced team. Call/WhatsApp anytime.'],
        ['fa-receipt', 'GST Invoices', 'Proper GST-compliant invoices for all orders. B2B and B2C billing available. Warranty cards provided.'],
        ['fa-award', '10+ Years Experience', 'Over a decade of experience in safety net supply across Telangana, Andhra Pradesh and all of India.'],
        ['fa-handshake', 'Dealer Partnership', 'Become a NetsDial dealer in your city. Best margins, marketing support and exclusive territory rights.'],
      ];
      foreach ($features as $f): ?>
      <div class="feature-card" data-aos="fade-up">
        <div class="feature-icon"><i class="fas <?php echo $f[0]; ?>"></i></div>
        <h4><?php echo $f[1]; ?></h4>
        <p><?php echo $f[2]; ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     SERVICES SECTION
════════════════════════════════════════════════════════ -->
<section class="section section-alt">
  <div class="container">
    <div class="section-header" data-aos="fade-up">
      <span class="section-badge"><i class="fas fa-tools"></i> Our Services</span>
      <h2 class="section-title">Complete Range of <span class="highlight">Russea™ Net Solutions</span></h2>
      <p class="section-subtitle">From pigeon control to sports infrastructure — we supply premium Russea™ HDPE nets for every need across India.</p>
    </div>
    <div class="services-grid">
      <?php
      // Service icon + gradient mapping (works without any images)
      $service_meta = [
        'pigeon-netting'            => ['fa-dove',         'linear-gradient(135deg,#0f2027,#203a43,#2c5364)', '#4ecdc4'],
        'bird-netting'              => ['fa-feather-alt',  'linear-gradient(135deg,#1a1a2e,#16213e,#0f3460)', '#74b9ff'],
        'anti-bird-nets'            => ['fa-shield-alt',   'linear-gradient(135deg,#2d3561,#c05c7e,#f3826f)', '#fd79a8'],
        'balcony-safety-nets'       => ['fa-home',         'linear-gradient(135deg,#134e5e,#1a5276,#1f618d)', '#00cec9'],
        'children-safety-nets'      => ['fa-child',        'linear-gradient(135deg,#11998e,#38ef7d,#11998e)', '#00b894'],
        'pigeon-spikes'             => ['fa-thumbtack',    'linear-gradient(135deg,#373b44,#4286f4,#373b44)', '#74b9ff'],
        'anti-bird-spikes'          => ['fa-bolt',         'linear-gradient(135deg,#642b73,#c6426e,#642b73)', '#fd79a8'],
        'polycarbonate-spikes'      => ['fa-layer-group',  'linear-gradient(135deg,#1c1c1c,#414345,#1c1c1c)', '#b2bec3'],
        'ss-bird-spikes'            => ['fa-star',         'linear-gradient(135deg,#0f3460,#533483,#0f3460)', '#a29bfe'],
        'invisible-grills'          => ['fa-border-all',   'linear-gradient(135deg,#232526,#414345,#232526)', '#dfe6e9'],
        'ss-invisible-grills'       => ['fa-bars',         'linear-gradient(135deg,#1a1a1a,#3d5a80,#1a1a1a)', '#74b9ff'],
        'cloth-hangers-installation'=> ['fa-tshirt',       'linear-gradient(135deg,#2c3e50,#4ca1af,#2c3e50)', '#81ecec'],
        'ss-cloth-hangers'          => ['fa-wind',         'linear-gradient(135deg,#1a1a2e,#4a90a4,#1a1a2e)', '#74b9ff'],
        'artificial-grass'          => ['fa-seedling',     'linear-gradient(135deg,#134e5e,#71b280,#134e5e)', '#00b894'],
        'artificial-turf'           => ['fa-leaf',         'linear-gradient(135deg,#0a3d2e,#1e8449,#0a3d2e)', '#55efc4'],
        'cricket-ground-pitch-turf' => ['fa-baseball-ball','linear-gradient(135deg,#1b2631,#2e4057,#3d5a80)', '#fdcb6e'],
        'sports-practice-nets'      => ['fa-table-tennis', 'linear-gradient(135deg,#1a1a2e,#533483,#c84b31)', '#fd79a8'],
        'box-cricket-nets'          => ['fa-th',           'linear-gradient(135deg,#0f2027,#2c5364,#0f2027)', '#74b9ff'],
        'box-cricket-setup'         => ['fa-building',     'linear-gradient(135deg,#1b2631,#2e4057,#1b2631)', '#fdcb6e'],
      ];
      foreach ($services as $svc):
        $meta = $service_meta[$svc['slug']] ?? ['fa-network-wired','linear-gradient(135deg,#1a1a1a,#333,#1a1a1a)','#FF6B00'];
      ?>
      <div class="service-card" data-aos="fade-up">
        <div class="service-card-img-wrap" style="background:<?php echo $meta[1]; ?>;min-height:180px;display:flex;align-items:center;justify-content:center;position:relative;">
          <i class="fas <?php echo $meta[0]; ?>" style="font-size:3.5rem;color:<?php echo $meta[2]; ?>;opacity:0.9;z-index:1;"></i>
          <span class="service-card-badge" style="position:absolute;top:10px;right:10px"><?php echo htmlspecialchars($svc['category']); ?></span>
        </div>
        <div class="service-card-body">
          <h3><?php echo htmlspecialchars($svc['name']); ?> - Hyderabad</h3>
          <p><?php echo htmlspecialchars($svc['short_desc']); ?></p>
          <a href="<?php echo SITE_URL; ?>/services/hyderabad/kukatpally/<?php echo $svc['slug']; ?>/" class="service-card-link">
            View Details <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-32">
      <a href="services.php" class="btn btn-primary btn-lg">
        <i class="fas fa-th-large"></i> View All Services & Locations
      </a>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     ABOUT SECTION
════════════════════════════════════════════════════════ -->
<section class="section">
  <div class="container">
    <div class="about-grid">
      <div class="about-img-wrap" data-aos="fade-right">
        <div style="background:linear-gradient(135deg,#0f2027 0%,#203a43 50%,#2c5364 100%);border-radius:16px;width:100%;min-height:320px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:16px;padding:32px;">
          <i class="fas fa-network-wired" style="font-size:5rem;color:#4ecdc4;opacity:0.9;"></i>
          <div style="text-align:center;color:#fff;">
            <h3 style="color:#FF8C42;font-size:1.4rem;margin-bottom:4px;">NetsDial</h3>
            <p style="opacity:0.85;font-size:0.95rem;">Russea™ HDPE Net Wholesale Suppliers</p>
            <p style="opacity:0.7;font-size:0.85rem;">Managed by GCM Enterprises, Hyderabad</p>
          </div>
        </div>
        <div class="about-badge-float">
          <div>
            <span class="num">10+</span>
            <span class="label">Years of Excellence</span>
          </div>
        </div>
      </div>
      <div class="about-content" data-aos="fade-left">
        <span class="section-badge"><i class="fas fa-info-circle"></i> About NetsDial</span>
        <h2>India's Largest <span style="color:var(--primary)">Russea™</span> HDPE Net Wholesale Supplier</h2>
        <p>NetsDial is managed by <strong>GCM Enterprises</strong>, headquartered in Karmanghat, Hyderabad. We are the authorized wholesale dealers of <strong>Russea™</strong> branded HDPE safety nets, supplying to customers, contractors and dealers across all of India.</p>
        <div class="about-features">
          <div class="about-feature">
            <div class="about-feature-icon"><i class="fas fa-map-marker-alt"></i></div>
            <div>
              <h5>Our Location</h5>
              <p>Plot No.91, Road No.2, Sri Ram Nagar Colony, Karmanghat, Saroornagar - 500035, Hyderabad</p>
            </div>
          </div>
          <div class="about-feature">
            <div class="about-feature-icon"><i class="fas fa-certificate"></i></div>
            <div>
              <h5>Russea™ Trademark</h5>
              <p>Authorized wholesale dealer of Russea™ branded nets — India's most trusted HDPE net brand.</p>
            </div>
          </div>
          <div class="about-feature">
            <div class="about-feature-icon"><i class="fas fa-globe-asia"></i></div>
            <div>
              <h5>Pan-India Supply</h5>
              <p>We supply to customers, builders, contractors and dealers across all states of India.</p>
            </div>
          </div>
          <div class="about-feature">
            <div class="about-feature-icon"><i class="fas fa-leaf"></i></div>
            <div>
              <h5>All HDPE Nets</h5>
              <p>HDPE Braided Nets, HDPE Twisted Nets, HDPE Knotted Nets — complete range available.</p>
            </div>
          </div>
        </div>
        <div class="d-flex gap-16" style="flex-wrap:wrap">
          <a href="about.php" class="btn btn-primary"><i class="fas fa-info-circle"></i> Read More About Us</a>
          <a href="contact.php" class="btn btn-outline-primary"><i class="fas fa-phone-alt"></i> Contact Us</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     SPECIALISATION
════════════════════════════════════════════════════════ -->
<section class="section section-alt">
  <div class="container">
    <div class="section-header" data-aos="fade-up">
      <span class="section-badge"><i class="fas fa-star"></i> Our Specialisation</span>
      <h2 class="section-title">What Makes <span class="highlight">NetsDial Special</span></h2>
    </div>
    <div class="spec-grid">
      <?php
      $specs = [
        ['fa-dove', 'Pigeon & Bird Control', 'Complete range of anti-pigeon and bird control nets, spikes and deterrents'],
        ['fa-shield-alt', 'Safety Net Supply', 'Balcony, children and pet safety nets for apartments and villas'],
        ['fa-border-all', 'Invisible Grills', 'SS invisible grill systems for modern apartments'],
        ['fa-leaf', 'Artificial Grass', 'Premium turf for homes, terraces and sports facilities'],
        ['fa-baseball-ball', 'Cricket Nets', 'Largest suppliers of cricket practice and box cricket nets'],
        ['fa-industry', 'Industrial Nets', 'Heavy-duty nets for warehouses, factories and construction'],
        ['fa-tshirt', 'Cloth Hangers', 'SS ceiling and wall-mounted cloth drying systems'],
        ['fa-handshake', 'Wholesale Supply', 'Best wholesale rates for bulk orders — pan-India supply'],
      ];
      foreach ($specs as $sp): ?>
      <div class="spec-card" data-aos="zoom-in">
        <div class="spec-icon"><i class="fas <?php echo $sp[0]; ?>"></i></div>
        <h4><?php echo $sp[1]; ?></h4>
        <p><?php echo $sp[2]; ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     ESTIMATION SECTION
════════════════════════════════════════════════════════ -->
<section class="section" id="estimation">
  <div class="container">
    <div class="section-header" data-aos="fade-up">
      <span class="section-badge"><i class="fas fa-calculator"></i> Cost Estimator</span>
      <h2 class="section-title">Calculate Your <span class="highlight">Net Cost</span> Instantly</h2>
      <p class="section-subtitle">Get instant price estimates for safety nets, invisible grills, artificial grass and more.</p>
    </div>
    <div style="text-align:center;padding:40px;background:var(--off-white);border-radius:var(--radius-xl);border:2px dashed var(--border)" data-aos="fade-up">
      <i class="fas fa-calculator" style="font-size:3rem;color:var(--primary);margin-bottom:16px;display:block"></i>
      <h3>Advanced Estimation Calculator</h3>
      <p style="margin-bottom:24px">Use our detailed estimation page to calculate exact costs for safety nets, cricket nets, invisible grills, artificial grass and box cricket setups.</p>
      <a href="estimation.php" class="btn btn-primary btn-lg">
        <i class="fas fa-calculator"></i> Open Full Estimation Calculator
      </a>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     GALLERY SECTION
════════════════════════════════════════════════════════ -->
<?php if (!empty($gallery_imgs)): ?>
<section class="section section-alt">
  <div class="container">
    <div class="section-header" data-aos="fade-up">
      <span class="section-badge"><i class="fas fa-images"></i> Our Work</span>
      <h2 class="section-title">Project <span class="highlight">Gallery</span></h2>
      <p class="section-subtitle">See our quality work across Hyderabad and India.</p>
    </div>
    <div class="gallery-grid">
      <?php foreach ($gallery_imgs as $img): ?>
      <div class="gallery-item" data-category="<?php echo htmlspecialchars($img['category']); ?>" data-aos="zoom-in">
        <img src="<?php echo SITE_URL . '/uploads/gallery/' . htmlspecialchars($img['image_path']); ?>"
             alt="<?php echo htmlspecialchars($img['title']); ?> - NetsDial Hyderabad" loading="lazy">
        <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-32">
      <a href="gallery.php" class="btn btn-primary"><i class="fas fa-images"></i> View Full Gallery</a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════
     REVIEWS SECTION
════════════════════════════════════════════════════════ -->
<section class="section">
  <div class="container">
    <div class="section-header" data-aos="fade-up">
      <span class="section-badge"><i class="fas fa-star"></i> Customer Reviews</span>
      <h2 class="section-title">What Our <span class="highlight">Customers Say</span></h2>
      <p class="section-subtitle">150+ verified reviews from satisfied customers across India.</p>
    </div>

    <!-- Average Rating Display -->
    <div style="text-align:center;margin-bottom:40px" data-aos="fade-up">
      <div style="font-size:3.5rem;font-weight:900;color:var(--primary);line-height:1">4.9</div>
      <div style="color:#F59E0B;font-size:1.5rem;margin:8px 0">★★★★★</div>
      <p style="color:var(--text-light);font-size:.9rem">Based on 150+ reviews</p>
    </div>

    <div class="swiper reviews-swiper">
      <div class="swiper-wrapper">
        <?php foreach ($all_reviews as $rev): ?>
        <div class="swiper-slide">
          <div class="review-card">
            <div class="review-stars">
              <?php for ($i = 1; $i <= 5; $i++): ?>
              <i class="fas fa-star <?php echo $i <= $rev['rating'] ? 'active' : ''; ?>"></i>
              <?php endfor; ?>
            </div>
            <p class="review-text">"<?php echo htmlspecialchars(substr($rev['review_text'], 0, 220)) . (strlen($rev['review_text']) > 220 ? '...' : ''); ?>"</p>
            <div class="reviewer">
              <div class="reviewer-avatar"><?php echo strtoupper(substr($rev['customer_name'], 0, 1)); ?></div>
              <div>
                <div class="reviewer-name"><?php echo htmlspecialchars($rev['customer_name']); ?></div>
                <div class="reviewer-location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($rev['customer_location'] ?: 'India'); ?></div>
                <div class="reviewer-service"><?php echo htmlspecialchars($rev['service_used'] ?: 'NetsDial Customer'); ?></div>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="reviews-swiper-pagination" style="margin-top:24px;text-align:center"></div>
    </div>

    <div class="text-center mt-32">
      <a href="reviews.php" class="btn btn-outline-primary"><i class="fas fa-star"></i> View All Reviews</a>
      <a href="reviews.php#write-review" class="btn btn-primary" style="margin-left:12px"><i class="fas fa-pen"></i> Write a Review</a>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     BLOGS SECTION
════════════════════════════════════════════════════════ -->
<?php if (!empty($latest_blogs)): ?>
<section class="section section-alt">
  <div class="container">
    <div class="section-header" data-aos="fade-up">
      <span class="section-badge"><i class="fas fa-blog"></i> Latest Insights</span>
      <h2 class="section-title">Expert <span class="highlight">Blog & Tips</span></h2>
      <p class="section-subtitle">Stay updated with the latest insights on safety nets, bird control, and more.</p>
    </div>
    <div class="blog-grid">
      <?php foreach ($latest_blogs as $blog): ?>
      <article class="blog-card" data-aos="fade-up">
        <?php if ($blog['image_path']): ?>
        <img src="<?php echo SITE_URL . '/uploads/blogs/' . htmlspecialchars($blog['image_path']); ?>"
             alt="<?php echo htmlspecialchars($blog['title']); ?>" class="blog-card-img" loading="lazy">
        <?php endif; ?>
        <div class="blog-card-body">
          <span class="blog-category"><?php echo htmlspecialchars($blog['category'] ?: 'Tips'); ?></span>
          <h3><a href="<?php echo SITE_URL; ?>/blog/<?php echo htmlspecialchars($blog['slug']); ?>/"><?php echo htmlspecialchars($blog['title']); ?></a></h3>
          <p><?php echo htmlspecialchars(substr($blog['excerpt'] ?: $blog['title'], 0, 120)) . '...'; ?></p>
          <div class="blog-meta">
            <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($blog['author']); ?></span>
            <span><i class="fas fa-calendar"></i> <?php echo date('d M Y', strtotime($blog['created_at'])); ?></span>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-32">
      <a href="blogs.php" class="btn btn-primary"><i class="fas fa-blog"></i> View All Blogs</a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════
     CONTACT SECTION
════════════════════════════════════════════════════════ -->
<section class="section" id="contact">
  <div class="container">
    <div class="section-header" data-aos="fade-up">
      <span class="section-badge"><i class="fas fa-envelope"></i> Contact Us</span>
      <h2 class="section-title">Get In <span class="highlight">Touch</span></h2>
      <p class="section-subtitle">Reach us through any of the following channels. We respond within 2-4 hours.</p>
    </div>
    <div class="contact-grid">
      <div data-aos="fade-right">
        <div class="contact-info-item">
          <div class="contact-info-icon"><i class="fas fa-phone-alt"></i></div>
          <div class="contact-info-text">
            <h5>Call / WhatsApp</h5>
            <a href="tel:+91<?php echo SITE_PHONE; ?>">+91 <?php echo SITE_PHONE; ?></a>
            <a href="<?php echo SITE_WHATSAPP; ?>" target="_blank">WhatsApp: +91 <?php echo SITE_PHONE; ?></a>
          </div>
        </div>
        <div class="contact-info-item">
          <div class="contact-info-icon"><i class="fas fa-envelope"></i></div>
          <div class="contact-info-text">
            <h5>Email Us</h5>
            <a href="mailto:<?php echo SITE_EMAIL; ?>"><?php echo SITE_EMAIL; ?></a>
          </div>
        </div>
        <div class="contact-info-item">
          <div class="contact-info-icon"><i class="fas fa-map-marker-alt"></i></div>
          <div class="contact-info-text">
            <h5>Visit Our Office</h5>
            <p><?php echo SITE_ADDRESS; ?></p>
          </div>
        </div>
        <div class="map-wrap">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3808.6!2d78.5!3d17.35!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTfCsDIxJzAwLjAiTiA3OMKwMzAnMDAuMCJF!5e0!3m2!1sen!2sin!4v1000000000000" allowfullscreen loading="lazy"></iframe>
        </div>
      </div>
      <div data-aos="fade-left">
        <div class="quick-contact-card">
          <h3>Send Us a <span>Message</span></h3>
          <p>We'll respond within 2-4 hours on working days.</p>
          <form action="<?php echo SITE_URL; ?>/api/contact.php" method="POST" data-ajax="true">
            <input type="hidden" name="source_page" value="<?php echo SITE_URL; ?>/#contact">
            <input type="text" name="website" style="display:none" tabindex="-1">
            <div class="form-group form-icon">
              <label>Name *</label><i class="fas fa-user"></i>
              <input type="text" name="name" class="form-control" placeholder="Your full name" required>
            </div>
            <div class="form-group form-icon">
              <label>Phone *</label><i class="fas fa-phone"></i>
              <input type="tel" name="phone" class="form-control" placeholder="Mobile number" required maxlength="10">
            </div>
            <div class="form-group form-icon">
              <label>Email</label><i class="fas fa-envelope"></i>
              <input type="email" name="email" class="form-control" placeholder="Email address">
            </div>
            <div class="form-group">
              <label>Service</label>
              <select name="service" class="form-control">
                <option value="">Select service</option>
                <option>Pigeon Netting</option>
                <option>Balcony Safety Nets</option>
                <option>Invisible Grills</option>
                <option>Artificial Grass</option>
                <option>Cricket Nets</option>
                <option>Other</option>
              </select>
            </div>
            <div class="form-group">
              <label>Message</label>
              <textarea name="message" class="form-control" rows="4" placeholder="Your requirements..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">
              <i class="fas fa-paper-plane"></i> Send Message
            </button>
          </form>
          <div class="form-success" style="display:none">
            <i class="fas fa-check-circle"></i><h4>Message Sent!</h4>
            <p>We'll respond within 2-4 hours.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     CTA SECTION
════════════════════════════════════════════════════════ -->
<section class="cta-section">
  <div class="container">
    <h2 data-aos="fade-up">Ready to Order Russea™ Nets?</h2>
    <p data-aos="fade-up" data-aos-delay="100">Get the best wholesale prices for premium HDPE safety nets, delivered across India. Call us today!</p>
    <div class="cta-buttons" data-aos="fade-up" data-aos-delay="200">
      <a href="tel:+91<?php echo SITE_PHONE; ?>" class="btn btn-outline-white btn-lg">
        <i class="fas fa-phone-alt"></i> Call: +91 <?php echo SITE_PHONE; ?>
      </a>
      <a href="<?php echo SITE_WHATSAPP; ?>" target="_blank" class="btn btn-whatsapp btn-lg">
        <i class="fab fa-whatsapp"></i> WhatsApp Now
      </a>
      <a href="estimation.php" class="btn btn-secondary btn-lg">
        <i class="fas fa-calculator"></i> Get Estimate
      </a>
    </div>

    <!-- Location Keywords (hidden for SEO) -->
    <div style="display:none">
      <p>Pigeon netting Hyderabad, bird netting Hyderabad, safety nets Hyderabad, invisible grills Hyderabad,
      artificial grass Hyderabad, cricket nets Hyderabad, pigeon nets Kukatpally, safety nets Gachibowli,
      bird nets HITEC City, invisible grills Banjara Hills, box cricket nets Kompally, pigeon netting Vizag,
      safety nets Vijayawada, bird netting Warangal, pigeon nets Karimnagar, safety nets Nizamabad,
      Russea nets Hyderabad, HDPE nets wholesale Hyderabad, GCM Enterprises Hyderabad, NetsDial Hyderabad</p>
    </div>
  </div>
</section>

<!-- Lightbox -->
<div class="lightbox" id="lightbox">
  <button class="lightbox-close"><i class="fas fa-times"></i></button>
  <img src="" alt="Gallery Image">
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
