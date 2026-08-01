<?php defined('NETSDIAL') or die('Direct access not allowed'); ?>

<!-- ── Floating Action Buttons ──────────────────────────────── -->
<div class="floating-buttons" aria-label="Quick Contact">
  <a href="tel:+91<?php echo SITE_PHONE; ?>" class="float-btn float-phone" title="Call NetsDial">
    <i class="fas fa-phone-alt"></i>
    <span class="float-label">Call Now</span>
  </a>
  <a href="<?php echo SITE_WHATSAPP; ?>" target="_blank" rel="noopener" class="float-btn float-whatsapp" title="WhatsApp NetsDial">
    <i class="fab fa-whatsapp"></i>
    <span class="float-label">WhatsApp</span>
  </a>
</div>

<!-- ── Footer ─────────────────────────────────────────────────── -->
<footer class="site-footer" itemscope itemtype="https://schema.org/WholesaleStore">
  <meta itemprop="name" content="NetsDial – Russea™ HDPE Net Wholesale Suppliers">
  <meta itemprop="telephone" content="+91<?php echo SITE_PHONE; ?>">

  <!-- Wholesale Trust Strip -->
  <div class="footer-trust-strip">
    <div class="container">
      <div class="trust-items">
        <div class="trust-item">
          <i class="fas fa-trademark"></i>
          <div><strong>Russea™ Authorised</strong><span>Wholesale Dealer</span></div>
        </div>
        <div class="trust-item">
          <i class="fas fa-truck"></i>
          <div><strong>PAN India Delivery</strong><span>All 28 States & UTs</span></div>
        </div>
        <div class="trust-item">
          <i class="fas fa-award"></i>
          <div><strong>#1 South India</strong><span>Largest Net Supplier</span></div>
        </div>
        <div class="trust-item">
          <i class="fas fa-baseball-ball"></i>
          <div><strong>Cricket Nets</strong><span>Largest Wholesale Supplier</span></div>
        </div>
        <div class="trust-item">
          <i class="fas fa-industry"></i>
          <div><strong>HDPE Specialists</strong><span>Braided · Twisted · Knotted</span></div>
        </div>
        <div class="trust-item">
          <i class="fas fa-store"></i>
          <div><strong>10,000+ Dealers</strong><span>Across India</span></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer Main Grid -->
  <div class="footer-top">
    <div class="container">
      <div class="footer-grid">

        <!-- Company -->
        <div class="footer-col footer-about">
          <a href="<?php echo SITE_URL; ?>/" class="footer-logo">
            <img src="<?php echo SITE_URL; ?>/assets/images/logo-white.png"
                 alt="NetsDial Russea™ Net Suppliers" width="180" height="55" loading="lazy"
                 style="filter:brightness(0) invert(1)"
                 onerror="this.removeAttribute('onerror');this.src='<?php echo SITE_URL; ?>/assets/images/logo.png';this.style.filter='brightness(0) invert(1)'">
          </a>
          <div class="footer-brand-badge">
            <i class="fas fa-trademark"></i> Official Russea™ Wholesale Supplier
          </div>
          <p>
            <strong>NetsDial</strong>, managed by <strong>GCM Enterprises</strong>, is India's largest
            wholesale supplier of <strong>Russea™</strong> HDPE nets. We offer sales, supply and installation
            of HDPE Braided, Twisted &amp; Knotted Nets — pigeon control, balcony safety, bird control,
            cricket nets, invisible grills, artificial grass and complete sports ground setup across all
            28 states of India. Largest net supplier from South India.
          </p>
          <div class="footer-contact-info">
            <a href="tel:+91<?php echo SITE_PHONE; ?>" itemprop="telephone">
              <i class="fas fa-phone-alt"></i> +91 <?php echo SITE_PHONE; ?>
            </a>
            <a href="mailto:<?php echo SITE_EMAIL; ?>" itemprop="email">
              <i class="fas fa-envelope"></i> <?php echo SITE_EMAIL; ?>
            </a>
            <!-- Schema.org address meta (hidden) -->
            <div itemscope itemtype="https://schema.org/PostalAddress" style="display:none">
              <meta itemprop="streetAddress" content="Plot No.91, Road No.2, Sri Ram Nagar Colony, Karmanghat, Saroornagar">
              <meta itemprop="addressLocality" content="Hyderabad">
              <meta itemprop="postalCode" content="500035">
              <meta itemprop="addressRegion" content="Telangana">
              <meta itemprop="addressCountry" content="IN">
            </div>
            <!-- Visible address (clean, no spans) -->
            <div style="display:flex;align-items:flex-start;gap:8px">
              <i class="fas fa-map-marker-alt" style="margin-top:3px;flex-shrink:0"></i>
              <div style="line-height:1.8">
                Plot No.91, Road No.2,<br>
                Sri Ram Nagar Colony, Karmanghat,<br>
                Saroornagar – 500035,<br>
                Hyderabad, Telangana, India
              </div>
            </div>
          </div>
          <div class="footer-social">
            <a href="<?php echo getSetting('facebook_url','#'); ?>" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="<?php echo getSetting('instagram_url','#'); ?>" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="<?php echo getSetting('youtube_url','#'); ?>" target="_blank" rel="noopener" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
            <a href="<?php echo SITE_WHATSAPP; ?>" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
          </div>
        </div>

        <!-- Quick Links -->
        <div class="footer-col">
          <h4 class="footer-title">Quick Links</h4>
          <ul class="footer-links">
            <?php
            $qlinks = [
              ['Home','/'],['About Us','/about.php'],['Company Profile','/about-netsdial.php'],
              ['Our Services','/services.php'],['Gallery','/gallery.php'],['Videos','/videos.php'],
              ['Estimation','/estimation.php'],['Reviews','/reviews.php'],['Blogs','/blogs.php'],
              ["FAQ's",'/faq.php'],['Contact Us','/contact.php'],
            ];
            foreach ($qlinks as $l): ?>
            <li><a href="<?php echo SITE_URL.$l[1]; ?>"><i class="fas fa-chevron-right"></i> <?php echo $l[0]; ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Russea™ Products -->
        <div class="footer-col">
          <h4 class="footer-title">Russea™ Products</h4>
          <ul class="footer-links">
            <?php
            $footer_services = db()->fetchAll("SELECT name,slug FROM service_keywords WHERE is_active=1 ORDER BY sort_order LIMIT 14");
            foreach ($footer_services as $fs): ?>
            <li>
              <a href="<?php echo SITE_URL; ?>/services.php?service=<?php echo $fs['slug']; ?>">
                <i class="fas fa-chevron-right"></i> Russea™ <?php echo htmlspecialchars($fs['name']); ?>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Cities We Supply -->
        <div class="footer-col">
          <h4 class="footer-title">Cities We Supply</h4>
          <ul class="footer-links">
            <?php
            $city_links = [
              ['Pigeon Nets Hyderabad','/services/hyderabad/kukatpally/pigeon-netting/'],
              ['Safety Nets Gachibowli','/services/hyderabad/gachibowli/balcony-safety-nets/'],
              ['Invisible Grills HITEC City','/services/hyderabad/hitec-city/invisible-grills/'],
              ['Cricket Nets Banjara Hills','/services/hyderabad/banjara-hills/box-cricket-nets/'],
              ['Bird Nets Madhapur','/services/hyderabad/madhapur/anti-bird-nets/'],
              ['Safety Nets Kukatpally','/services/hyderabad/kukatpally/balcony-safety-nets/'],
              ['Pigeon Nets Vizag','/services/visakhapatnam/visakhapatnam-city/pigeon-netting/'],
              ['Safety Nets Vijayawada','/services/vijayawada/vijayawada-city/balcony-safety-nets/'],
              ['Cricket Nets Warangal','/services/warangal/warangal-city/box-cricket-nets/'],
              ['Pigeon Nets Karimnagar','/services/karimnagar/karimnagar-city/pigeon-netting/'],
              ['Nets Tirupati','/services/tirupati/tirupati-city/pigeon-netting/'],
              ['Artificial Grass Jubilee Hills','/services/hyderabad/jubilee-hills/artificial-grass/'],
            ];
            foreach ($city_links as $cl): ?>
            <li><a href="<?php echo SITE_URL.$cl[1]; ?>"><i class="fas fa-chevron-right"></i> <?php echo $cl[0]; ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>

      </div><!-- /.footer-grid -->
    </div>
  </div><!-- /.footer-top -->

  <!-- Footer Stats -->
  <div class="footer-stats">
    <div class="container">
      <div class="stats-grid">
        <div class="stat-item">
          <span class="stat-num" id="visitorCount"><?php echo number_format(getVisitorCount()); ?></span>
          <span class="stat-label"><i class="fas fa-users"></i> Happy Visitors</span>
        </div>
        <div class="stat-item">
          <span class="stat-num" id="liveVisitors" style="color:#22C55E">–</span>
          <span class="stat-label"><i class="fas fa-circle" style="color:#22C55E;font-size:.5rem"></i> Live Now</span>
        </div>
        <div class="stat-item">
          <span class="stat-num">37,500+</span>
          <span class="stat-label"><i class="fas fa-file-alt"></i> Service Pages</span>
        </div>
        <div class="stat-item">
          <span class="stat-num">150+</span>
          <span class="stat-label"><i class="fas fa-map-marker-alt"></i> Cities Covered</span>
        </div>
        <div class="stat-item">
          <span class="stat-num">28</span>
          <span class="stat-label"><i class="fas fa-map"></i> States Supplied</span>
        </div>
        <div class="stat-item">
          <span class="stat-num">10+</span>
          <span class="stat-label"><i class="fas fa-trophy"></i> Years in Business</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer Bottom -->
  <div class="footer-bottom">
    <div class="container">
      <div class="footer-bottom-inner">
        <p>
          &copy; <?php echo date('Y'); ?> <strong>NetsDial</strong> | Managed by
          <strong>GCM Enterprises</strong>, Hyderabad. All Rights Reserved.
        </p>
        <p style="margin-top:4px;opacity:.7;font-size:.8rem">
          Official Wholesale Supplier of <strong>Russea™</strong> HDPE Nets — Braided · Twisted · Knotted |
          Largest Net Supplier from South India | Supplying All India
        </p>
        <div class="footer-bottom-links">
          <a href="#">Privacy Policy</a>
          <a href="#">Terms of Service</a>
        </div>
      </div>
    </div>
  </div>
</footer>

<!-- ── Scripts ─────────────────────────────────────────────── -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js"></script>
<script src="<?php echo SITE_URL; ?>/assets/js/menu.js"></script>
<script src="<?php echo SITE_URL; ?>/assets/js/main.js"></script>
<script>
const SITE_CONFIG = {
  siteUrl: '<?php echo SITE_URL; ?>',
  phone:   '<?php echo SITE_PHONE; ?>',
  whatsapp:'<?php echo SITE_WHATSAPP; ?>'
};
// Initialize AOS with low offset so elements animate immediately when visible
if (typeof AOS !== 'undefined') {
  AOS.init({ duration: 700, once: true, offset: 30, easing: 'ease-out-cubic', disable: false });
} else {
  // AOS failed to load — make all data-aos elements visible
  document.querySelectorAll('[data-aos]').forEach(function(el) {
    el.style.opacity = '1';
    el.style.transform = 'none';
    el.style.transition = 'none';
  });
}

// Live visitor count
fetch('<?php echo SITE_URL; ?>/api/visitor.php?action=live_count')
  .then(r => r.json())
  .then(d => { const el = document.getElementById('liveVisitors'); if (el) el.textContent = d.count ?? 0; })
  .catch(() => {});
</script>
<?php if (isset($extra_scripts)) echo $extra_scripts; ?>
</body>
</html>
