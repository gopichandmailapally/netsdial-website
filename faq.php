<?php
define('NETSDIAL', true);
require_once __DIR__ . '/config/config.php';
trackVisitor();

$page_title       = "FAQ's – Russea™ Net Wholesale Questions | NetsDial Hyderabad India";
$page_description = "Find answers to common questions about Russea™ HDPE pigeon nets, balcony safety nets, invisible grills, cricket nets, wholesale pricing, HDPE braided & twisted nets, and supply from NetsDial by GCM Enterprises, Hyderabad.";
$page_keywords    = 'netsdial faq, pigeon net questions, balcony safety net faq, invisible grill questions, net prices hyderabad, russe net wholesale';
$breadcrumb = [['Home',SITE_URL],["FAQ's",'']];

// Schema for FAQPage
$faqs_schema = [];
$faqs_db = db()->fetchAll("SELECT question, answer FROM faqs WHERE is_active=1 ORDER BY sort_order ASC LIMIT 30");
foreach ($faqs_db as $f) {
    $faqs_schema[] = ['@type'=>'Question','name'=>$f['question'],'acceptedAnswer'=>['@type'=>'Answer','text'=>strip_tags($f['answer'])]];
}
$extra_schema = '<script type="application/ld+json">'.json_encode(['@context'=>'https://schema.org','@type'=>'FAQPage','mainEntity'=>$faqs_schema]).'</script>';

include __DIR__ . '/includes/header.php';
echo $extra_schema;
?>

<section class="page-hero">
  <div class="container page-hero-content">
    <div class="breadcrumb"><?php echo buildBreadcrumb($breadcrumb); ?></div>
    <h1>Frequently Asked <span class="gradient-text">Questions</span></h1>
    <p>Everything you need to know about our Russe™ nets, pricing, and wholesale supply</p>
  </div>
</section>

<section class="section-padding">
  <div class="container" style="max-width:900px">

    <?php if (!empty($faqs_db)): ?>
    <div class="faq-container">
      <?php foreach ($faqs_db as $i => $faq): ?>
      <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
        <div class="faq-question" onclick="toggleFaq(this)">
          <span itemprop="name"><?php echo htmlspecialchars($faq['question']); ?></span>
          <i class="fas fa-chevron-down faq-icon"></i>
        </div>
        <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
          <div itemprop="text"><?php echo nl2br(htmlspecialchars($faq['answer'])); ?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <?php else: ?>
    <!-- Static FAQs as fallback -->
    <?php
    $static_faqs = [
      ['What products does NetsDial supply?','NetsDial, managed by GCM Enterprises, supplies Russe™ branded HDPE nets including pigeon nets, balcony safety nets, anti-bird nets, invisible grills, SS cloth hangers, artificial grass/turf, cricket nets, and sports nets. We are wholesale suppliers for PAN India delivery.'],
      ['What is the price of pigeon net per sq ft in Hyderabad?','Pigeon net prices depend on material thickness and mesh size. For 1.5mm nets with 30mm gap, rates range from ₹10–20/sqft based on quantity. For below 100 sqft, flat rates apply (₹1500–₹1800 including installation). Use our Estimation page for exact pricing.'],
      ['Do you supply Russe™ branded nets only?','Yes. NetsDial is an exclusive wholesale supplier of Russe™ branded HDPE nets. Russe™ is a registered trademark, and every net we supply carries this mark of quality assurance.'],
      ['What is the minimum order quantity for wholesale?','We supply both retail and wholesale quantities. For wholesale/dealer pricing, minimum orders vary by product. Contact us at +91 9966499144 for bulk pricing details.'],
      ['Do you deliver all over India?','Yes! We supply Russe™ branded nets across all 28 states and 8 Union Territories of India. We are the largest net suppliers from South India with a strong logistics network.'],
      ['What types of HDPE nets do you supply?','We supply HDPE Braided Nets, HDPE Twisted Nets, and HDPE Knotted Nets across various sizes and specifications — suitable for pigeon control, safety, sports, and industrial use.'],
      ['How long does pigeon net last?','Russe™ HDPE pigeon nets with UV stabilization last 5–8 years when properly installed and maintained. They are weather resistant and suitable for Hyderabad\'s climate.'],
      ['What is the price of invisible grills?','Invisible grill pricing depends on wire thickness (1.5mm to 3mm) and line gap (2 inch or 3 inch). Rates range from ₹120–₹180 per sqft. Use our Estimation Calculator for exact pricing.'],
      ['Do you offer warranty on nets?','Yes, we provide warranty cards for our Russe™ products. Warranty period varies from 1 to 5 years based on the product and material. Warranty cards are issued with all purchases.'],
      ['How do I contact NetsDial for a quote?','Call us at +91 9966499144, WhatsApp us, email netsdial@gmail.com, or fill the contact form on our website. We respond within 2 hours on working days.'],
      ['Do you supply cricket nets for cricket grounds?','Yes! We are one of South India\'s largest wholesale suppliers of cricket nets. We supply HDPE nylon cricket nets for batting practice nets, box cricket setups, and full cricket grounds. Bulk pricing available.'],
      ['Can I get artificial grass for my balcony?','Absolutely. We supply Russe™ brand artificial grass in 25mm to 50mm pile heights, in single and double layer options. Suitable for balconies, terraces, gardens, and sports grounds.'],
    ];
    echo '<div class="faq-container">';
    foreach ($static_faqs as $i => $faq):
    echo '<div class="faq-item"><div class="faq-question" onclick="toggleFaq(this)"><span>'.htmlspecialchars($faq[0]).'</span><i class="fas fa-chevron-down faq-icon"></i></div><div class="faq-answer"><div>'.htmlspecialchars($faq[1]).'</div></div></div>';
    endforeach;
    echo '</div>';
    ?>
    <?php endif; ?>

    <!-- Still have questions? -->
    <div style="text-align:center;margin-top:60px;padding:40px;background:linear-gradient(135deg,#FF6B00,#FF8C42);border-radius:var(--radius-xl);color:#fff">
      <h3 style="margin-bottom:8px">Still Have Questions?</h3>
      <p style="opacity:.9;margin-bottom:24px">Our experts are ready to help with any query about nets, pricing, or wholesale orders</p>
      <div style="display:flex;justify-content:center;gap:16px;flex-wrap:wrap">
        <a href="tel:+91<?php echo getSetting('site_phone','9966499144'); ?>" style="background:#fff;color:#FF6B00;padding:12px 28px;border-radius:99px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:8px"><i class="fas fa-phone-alt"></i> Call Now</a>
        <a href="/contact" style="background:rgba(255,255,255,.2);color:#fff;padding:12px 28px;border-radius:99px;font-weight:700;text-decoration:none;border:2px solid rgba(255,255,255,.5)">Contact Form</a>
      </div>
    </div>
  </div>
</section>

<script>
function toggleFaq(el) {
  const item = el.parentElement;
  const isOpen = item.classList.contains('active');
  document.querySelectorAll('.faq-item.active').forEach(i => i.classList.remove('active'));
  if (!isOpen) item.classList.add('active');
}
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
