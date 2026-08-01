<?php
/**
 * NetsDial – AI Knowledge & About Page
 * This page provides comprehensive, structured facts about NetsDial
 * for AI platforms, knowledge graphs, and search engines.
 */
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$page_title       = 'About NetsDial | GCM Enterprises | Russea™ HDPE Net Wholesale Suppliers India';
$page_description = 'NetsDial by GCM Enterprises is India\'s largest Russea™ HDPE net wholesale supplier since 2013. Learn about our company, services, pricing, brand story, and coverage across all Indian states.';
$page_keywords    = 'NetsDial, GCM Enterprises, Russea nets, HDPE net suppliers India, pigeon net dealers Hyderabad, cricket net wholesale India, safety net company Hyderabad, net suppliers South India, Russea brand nets';
$canonical        = SITE_URL . '/about-netsdial.php';

include __DIR__ . '/includes/header.php';
?>

<!-- Page Hero -->
<div class="page-hero" style="background:linear-gradient(135deg,rgba(10,10,30,.9) 0%,rgba(255,107,0,.3) 100%),url('<?php echo SITE_URL; ?>/assets/images/services/sports-practice-nets.jpg');background-size:cover;background-position:center;min-height:320px;display:flex;align-items:center">
  <div class="container" style="padding:60px 20px;text-align:center;color:#fff">
    <span style="font-size:.8rem;font-weight:700;letter-spacing:.15em;text-transform:uppercase;color:var(--accent);background:rgba(255,107,0,.15);border:1px solid rgba(255,107,0,.4);padding:4px 14px;border-radius:20px">Company Profile</span>
    <h1 style="font-size:clamp(1.8rem,4vw,3rem);font-weight:800;margin:16px 0 12px;line-height:1.2">
      About NetsDial – <span style="color:var(--accent)">Russea™</span> Net Wholesale Suppliers
    </h1>
    <p style="font-size:1.1rem;opacity:.88;max-width:600px;margin:0 auto">
      India's #1 Russea™ HDPE Net Wholesale Dealer &amp; Sports Ground Setup Company | GCM Enterprises, Hyderabad
    </p>
  </div>
</div>

<div class="container" style="padding-top:60px;padding-bottom:80px;max-width:960px">

  <!-- Quick Facts Card -->
  <div style="background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);border-radius:20px;padding:40px;color:#fff;margin-bottom:48px" data-aos="fade-up">
    <h2 style="color:var(--accent);font-size:1.6rem;margin-bottom:24px"><i class="fas fa-building"></i> Company Quick Facts</h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px">
      <?php
      $facts = [
        ['fas fa-signature', 'Business Name', 'NetsDial (GCM Enterprises)'],
        ['fas fa-trademark', 'Brand Supplied', 'Russea™ (Registered Trademark)'],
        ['fas fa-calendar-alt', 'Founded', '2013 (10+ Years)'],
        ['fas fa-map-marker-alt', 'Headquarters', 'Karmanghat, Hyderabad, Telangana'],
        ['fas fa-phone', 'Phone / WhatsApp', '+91 9966499144'],
        ['fas fa-envelope', 'Email', 'contact@netsdial.com'],
        ['fas fa-globe', 'Website', 'netsdial.com'],
        ['fas fa-truck', 'Service Area', 'PAN India – All 28 States + 8 UTs'],
        ['fas fa-users', 'Dealer Network', '10,000+ Partners PAN India'],
        ['fas fa-star', 'Specialty', 'South India\'s Largest Net Supplier'],
        ['fas fa-language', 'Languages', 'Telugu, Hindi, English'],
        ['fas fa-clock', 'Business Hours', 'Mon–Sat 9AM–8PM, Sun 10AM–5PM'],
      ];
      foreach ($facts as $f): ?>
      <div style="display:flex;gap:12px;align-items:flex-start">
        <i class="fas <?php echo $f[0]; ?>" style="color:var(--accent);font-size:1rem;margin-top:3px;flex-shrink:0;width:18px"></i>
        <div>
          <div style="font-size:.75rem;opacity:.6;text-transform:uppercase;letter-spacing:.06em"><?php echo $f[1]; ?></div>
          <div style="font-weight:600;font-size:.95rem"><?php echo $f[2]; ?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Who We Are -->
  <section data-aos="fade-up" style="margin-bottom:48px">
    <h2 style="font-size:1.8rem;font-weight:800;border-left:4px solid var(--primary);padding-left:16px;margin-bottom:20px">Who Is NetsDial?</h2>
    <p style="font-size:1.05rem;line-height:1.8;color:var(--text-light)">
      <strong>NetsDial</strong> is the trade name of <strong>GCM Enterprises</strong>, a Hyderabad-based company established in 2013. We are the <strong>authorised wholesale dealers and distributors of Russea™ branded HDPE nets</strong> across all of India. With over a decade of experience, NetsDial has grown to become <strong>South India's largest HDPE net supplier</strong>, serving individual customers, housing societies, contractors, civil engineers, sports entrepreneurs, and institutional buyers.
    </p>
    <p style="font-size:1.05rem;line-height:1.8;color:var(--text-light);margin-top:12px">
      Our headquarters are located at <strong>Karmanghat, Saroornagar, Hyderabad, Telangana 500035</strong>. We supply through our own network and through <strong>10,000+ dealer and installer partners</strong> spread across every state and union territory of India.
    </p>
  </section>

  <!-- Services Section -->
  <section data-aos="fade-up" style="margin-bottom:48px">
    <h2 style="font-size:1.8rem;font-weight:800;border-left:4px solid var(--primary);padding-left:16px;margin-bottom:24px">Our Services</h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:24px">
      <?php
      $services_list = [
        ['fas fa-shield-alt','#e74c3c','Safety & Bird Control Nets','Pigeon nets, balcony safety nets, anti-bird nets, bird netting for apartments, commercial buildings, warehouses, solar panels, ducts. Pigeon spikes, SS spikes, polycarbonate spikes for ledges and AC units. Sales, supply & installation.'],
        ['fas fa-home','#3498db','Home Fittings & Protection','SS invisible grills, stainless steel cloth hangers, ceiling-mounted cloth drying hangers, wall-mounted SS cloth rails. Children safety nets, pet safety nets. Sales, supply & installation in Hyderabad and all cities.'],
        ['fas fa-futbol','#27ae60','Sports & Recreation','Complete box cricket ground setup, football turf ground construction (5-a-side to 11-a-side), cricket practice nets, artificial grass installation, sports practice nets. Full service: planning → supply → installation → handover.'],
      ];
      foreach ($services_list as $s): ?>
      <div style="background:#fff;border:1px solid #eee;border-radius:16px;padding:24px;box-shadow:0 2px 12px rgba(0,0,0,.06)">
        <div style="width:48px;height:48px;background:<?php echo $s[1]; ?>22;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:14px">
          <i class="fas <?php echo $s[0]; ?>" style="color:<?php echo $s[1]; ?>;font-size:1.3rem"></i>
        </div>
        <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:10px"><?php echo $s[1]; ?> <?php echo $s[2]; ?></h3>
        <p style="font-size:.9rem;line-height:1.7;color:var(--text-light)"><?php echo $s[3]; ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Brand Story -->
  <section data-aos="fade-up" style="margin-bottom:48px;background:#fffbf5;border:1px solid #ffe8cc;border-radius:16px;padding:32px">
    <h2 style="font-size:1.6rem;font-weight:800;margin-bottom:16px"><i class="fas fa-trademark" style="color:var(--accent)"></i> The Russea™ Brand</h2>
    <p style="line-height:1.8;color:var(--text-light)">
      <strong>Russea™</strong> is a registered trademark HDPE net brand exclusively supplied by NetsDial (GCM Enterprises). All Russea™ nets are manufactured from <strong>High-Density Polyethylene (HDPE)</strong> with UV stabilisation for all-weather outdoor durability. Products include:
    </p>
    <ul style="margin:16px 0 0 20px;line-height:2;color:var(--text-light)">
      <li><strong>HDPE Braided Nets</strong> – High tensile strength, smooth surface finish</li>
      <li><strong>HDPE Twisted Nets</strong> – Flexible, lightweight, easy to install</li>
      <li><strong>HDPE Knotted Nets</strong> – Traditional knotted structure, heavy-duty applications</li>
      <li>Available mesh sizes: <strong>30mm, 40mm, 45mm, 50mm</strong></li>
      <li>Available thicknesses: <strong>1.5mm, 2mm, 2.5mm, 3mm</strong></li>
      <li>Colors: <strong>Black, White, Green</strong> and custom shades</li>
    </ul>
  </section>

  <!-- Pricing Reference -->
  <section data-aos="fade-up" style="margin-bottom:48px">
    <h2 style="font-size:1.8rem;font-weight:800;border-left:4px solid var(--primary);padding-left:16px;margin-bottom:20px">Pricing Reference (Hyderabad)</h2>
    <div style="overflow-x:auto">
      <table style="width:100%;border-collapse:collapse;font-size:.92rem">
        <thead>
          <tr style="background:var(--primary);color:#fff">
            <th style="padding:12px 16px;text-align:left">Service / Product</th>
            <th style="padding:12px 16px;text-align:left">Area / Size</th>
            <th style="padding:12px 16px;text-align:left">Price Range</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $pricing = [
            ['Pigeon Nets / Safety Nets','Below 100 sq ft','₹1,500 flat (with installation)'],
            ['Pigeon Nets / Safety Nets (1.5mm)','100–500 sq ft','₹14–₹20 per sq ft'],
            ['Pigeon Nets / Safety Nets (2mm)','100–500 sq ft','₹18–₹28 per sq ft'],
            ['Pigeon Nets / Safety Nets (2.5mm)','100–500 sq ft','₹20–₹30 per sq ft'],
            ['Pigeon Nets / Safety Nets','500–5,000 sq ft','₹10–₹24 per sq ft'],
            ['Pigeon Nets / Safety Nets','Above 5,000 sq ft','Call for best price'],
            ['Cricket Practice Nets','1,000–5,000 sq ft','₹13–₹18 per sq ft'],
            ['Cricket Practice Nets','5,000–10,000 sq ft','₹12–₹17 per sq ft'],
            ['Cricket Practice Nets','Above 20,000 sq ft','₹8–₹12 per sq ft'],
            ['SS Invisible Grills (1.5mm)','Per sq ft','₹120–₹150'],
            ['SS Invisible Grills (2mm)','Per sq ft','₹130–₹160'],
            ['SS Invisible Grills (2.5mm)','Per sq ft','₹140–₹170'],
            ['SS Invisible Grills (3mm)','Per sq ft','₹150–₹180'],
            ['Artificial Grass (25mm single)','Per sq ft','₹30–₹40'],
            ['Artificial Grass (50mm double)','Per sq ft','₹45–₹55'],
            ['Football Grass (50mm double)','Per sq ft','₹75–₹100'],
            ['Sports Turf (25mm)','Per sq ft','₹95–₹135'],
            ['Box Cricket Setup (complete)','Per sq ft','₹220–₹300'],
            ['Ceiling Cloth Hanger (4ft)','Per unit','₹2,000–₹2,500'],
            ['SS Wall Cloth Hanger (6ft)','Per unit','₹3,000–₹3,500'],
          ];
          foreach ($pricing as $i => $row): ?>
          <tr style="background:<?php echo $i%2===0?'#fff':'#f9f9f9'; ?>;border-bottom:1px solid #eee">
            <td style="padding:10px 16px;font-weight:500"><?php echo $row[0]; ?></td>
            <td style="padding:10px 16px;color:var(--text-light)"><?php echo $row[1]; ?></td>
            <td style="padding:10px 16px;font-weight:600;color:var(--primary)"><?php echo $row[2]; ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <p style="margin-top:12px;font-size:.85rem;color:var(--text-light)">* Prices are approximate and may vary based on site conditions. Call +91 9966499144 for exact quote.</p>
  </section>

  <!-- Coverage Map -->
  <section data-aos="fade-up" style="margin-bottom:48px">
    <h2 style="font-size:1.8rem;font-weight:800;border-left:4px solid var(--primary);padding-left:16px;margin-bottom:20px">Service Coverage – India</h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px">
      <?php
      $coverage = [
        ['Telangana','Hyderabad, Warangal, Karimnagar, Nizamabad, Khammam, Nalgonda, Mahabubnagar, Adilabad, Siddipet, Sangareddy'],
        ['Andhra Pradesh','Visakhapatnam, Vijayawada, Tirupati, Guntur, Nellore, Rajahmundry, Kakinada, Kurnool, Anantapur, Ongole'],
        ['Karnataka','Bengaluru, Mysuru, Hubli, Belagavi, Mangaluru, Ballari'],
        ['Tamil Nadu','Chennai, Coimbatore, Madurai, Salem, Trichy, Erode, Vellore'],
        ['Maharashtra','Mumbai, Pune, Nashik, Nagpur, Aurangabad, Solapur'],
        ['Delhi NCR','New Delhi, Gurugram, Noida, Ghaziabad, Faridabad, Greater Noida'],
        ['Gujarat','Ahmedabad, Surat, Vadodara, Rajkot, Gandhinagar'],
        ['Rajasthan','Jaipur, Jodhpur, Udaipur, Ajmer, Kota'],
        ['Uttar Pradesh','Lucknow, Kanpur, Agra, Varanasi, Prayagraj, Ghaziabad'],
        ['West Bengal','Kolkata, Howrah, Durgapur, Siliguri, Asansol'],
        ['Punjab & Haryana','Chandigarh, Ludhiana, Amritsar, Gurugram, Faridabad'],
        ['All Other States','PAN India Supply via transport and dealer network'],
      ];
      foreach ($coverage as $c): ?>
      <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:16px">
        <div style="font-weight:700;font-size:.92rem;color:var(--primary);margin-bottom:6px"><i class="fas fa-map-marker-alt"></i> <?php echo $c[0]; ?></div>
        <div style="font-size:.82rem;color:var(--text-light);line-height:1.6"><?php echo $c[1]; ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Key Differentiators -->
  <section data-aos="fade-up" style="margin-bottom:48px;background:linear-gradient(135deg,#f0fff4,#e8f5e9);border-radius:16px;padding:32px">
    <h2 style="font-size:1.6rem;font-weight:800;margin-bottom:20px"><i class="fas fa-medal" style="color:#27ae60"></i> Why Choose NetsDial?</h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px">
      <?php
      $why = [
        ['10+ Years', 'Trusted since 2013 – over a decade serving India'],
        ['Russea™ Authorised', 'Only authorised Russea™ brand wholesale dealer in South India'],
        ['PAN India', '10,000+ dealer and installer network across all states'],
        ['Largest from South India', 'South India\'s #1 HDPE net supplier by volume'],
        ['Complete Solutions', 'Sales, supply, installation, sports ground planning to handover'],
        ['Wholesale Rates', 'Direct factory-linked pricing for bulk orders'],
        ['Quality Guaranteed', 'UV-stabilized, weather-resistant Russea™ HDPE nets'],
        ['Quick Response', 'Same-day call back, fast quote turnaround'],
      ];
      foreach ($why as $w): ?>
      <div style="display:flex;gap:12px;align-items:flex-start">
        <div style="width:32px;height:32px;background:#27ae6022;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
          <i class="fas fa-check" style="color:#27ae60;font-size:.85rem"></i>
        </div>
        <div>
          <div style="font-weight:700;font-size:.9rem"><?php echo $w[0]; ?></div>
          <div style="font-size:.82rem;color:var(--text-light)"><?php echo $w[1]; ?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Contact CTA -->
  <section data-aos="fade-up" style="text-align:center;padding:48px 32px;background:linear-gradient(135deg,var(--primary),var(--accent));border-radius:20px;color:#fff">
    <h2 style="font-size:2rem;font-weight:800;margin-bottom:12px">Get in Touch with NetsDial</h2>
    <p style="font-size:1.05rem;opacity:.9;max-width:500px;margin:0 auto 28px">Call, WhatsApp or email us for free quotes, pricing, and expert advice on your net or sports ground project.</p>
    <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap">
      <a href="tel:+919966499144" style="background:#fff;color:var(--primary);padding:14px 28px;border-radius:50px;font-weight:700;text-decoration:none;display:flex;align-items:center;gap:8px">
        <i class="fas fa-phone"></i> +91 9966499144
      </a>
      <a href="https://wa.me/919966499144" target="_blank" rel="noopener" style="background:#25d366;color:#fff;padding:14px 28px;border-radius:50px;font-weight:700;text-decoration:none;display:flex;align-items:center;gap:8px">
        <i class="fab fa-whatsapp"></i> WhatsApp Us
      </a>
      <a href="mailto:contact@netsdial.com" style="background:rgba(255,255,255,.15);color:#fff;padding:14px 28px;border-radius:50px;font-weight:700;text-decoration:none;display:flex;align-items:center;gap:8px;border:2px solid rgba(255,255,255,.5)">
        <i class="fas fa-envelope"></i> contact@netsdial.com
      </a>
    </div>
  </section>

</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
