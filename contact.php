<?php
define('NETSDIAL', true);
require_once __DIR__ . '/config/config.php';
$page_meta_title = "Contact Us - NetsDial | Russea™ Net Suppliers Hyderabad | Call 9966499144";
$page_meta_desc  = "Contact NetsDial - GCM Enterprises for premium Russea™ HDPE safety nets, pigeon netting, invisible grills and cricket nets. Call/WhatsApp: 9966499144. Email: netsdial@gmail.com";
$page_meta_kw    = "contact netsdial, pigeon netting contact hyderabad, safety nets contact, netsdial phone number, netsdial address hyderabad";
include __DIR__ . '/includes/header.php';
?>

<div class="breadcrumb-bar">
  <div class="container">
    <div class="breadcrumb">
      <a href="/">Home</a><span class="sep"><i class="fas fa-chevron-right"></i></span>
      <span class="current">Contact Us</span>
    </div>
  </div>
</div>

<div class="page-hero">
  <div class="container">
    <h1>Contact <span>NetsDial</span></h1>
    <p>Get in touch with India's largest Russea™ HDPE net wholesale supplier. We respond within 2-4 hours.</p>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="contact-grid">
      <div>
        <div class="contact-info-item" data-aos="fade-right">
          <div class="contact-info-icon"><i class="fas fa-phone-alt"></i></div>
          <div class="contact-info-text">
            <h5>Call / WhatsApp</h5>
            <a href="tel:+91<?php echo SITE_PHONE; ?>">+91 <?php echo SITE_PHONE; ?></a>
            <a href="<?php echo SITE_WHATSAPP; ?>" target="_blank" style="color:#25D366"><i class="fab fa-whatsapp"></i> WhatsApp Chat</a>
          </div>
        </div>
        <div class="contact-info-item" data-aos="fade-right" data-aos-delay="100">
          <div class="contact-info-icon"><i class="fas fa-envelope"></i></div>
          <div class="contact-info-text">
            <h5>Email Address</h5>
            <a href="mailto:<?php echo SITE_EMAIL; ?>"><?php echo SITE_EMAIL; ?></a>
            <p style="font-size:.85rem">Response within 4 business hours</p>
          </div>
        </div>
        <div class="contact-info-item" data-aos="fade-right" data-aos-delay="200">
          <div class="contact-info-icon"><i class="fas fa-map-marker-alt"></i></div>
          <div class="contact-info-text">
            <h5>Office Address</h5>
            <p><?php echo SITE_ADDRESS; ?></p>
          </div>
        </div>
        <div class="contact-info-item" data-aos="fade-right" data-aos-delay="300">
          <div class="contact-info-icon"><i class="fas fa-clock"></i></div>
          <div class="contact-info-text">
            <h5>Business Hours</h5>
            <p>Monday - Saturday: 9:00 AM - 8:00 PM<br>Sunday: 10:00 AM - 5:00 PM</p>
          </div>
        </div>
        <div class="map-wrap" data-aos="fade-right" data-aos-delay="400">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3808.6!2d78.5!3d17.35!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bcba!2zHyderabad!5e0!3m2!1sen!2sin!4v1" allowfullscreen loading="lazy"></iframe>
        </div>
      </div>

      <div data-aos="fade-left">
        <div class="quick-contact-card" id="write-review">
          <h3>Send Us a <span>Message</span></h3>
          <p>Fill the form and we'll contact you within 2-4 hours.</p>
          <form action="<?php echo SITE_URL; ?>/api/contact.php" method="POST" data-ajax="true">
            <input type="hidden" name="source_page" value="<?php echo SITE_URL; ?>/contact.php">
            <input type="text" name="website" style="display:none" tabindex="-1">
            <div class="form-group form-icon">
              <label>Name *</label><i class="fas fa-user"></i>
              <input type="text" name="name" class="form-control" placeholder="Your full name" required>
            </div>
            <div class="form-row">
              <div class="form-group form-icon">
                <label>Phone *</label><i class="fas fa-phone"></i>
                <input type="tel" name="phone" class="form-control" placeholder="Mobile number" required maxlength="10">
              </div>
              <div class="form-group form-icon">
                <label>Email</label><i class="fas fa-envelope"></i>
                <input type="email" name="email" class="form-control" placeholder="Email (optional)">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label>Service Required</label>
                <select name="service" class="form-control">
                  <option value="">Select service</option>
                  <option>Pigeon Netting</option>
                  <option>Balcony Safety Nets</option>
                  <option>Children Safety Nets</option>
                  <option>Bird Netting</option>
                  <option>Anti Bird Nets</option>
                  <option>Pigeon Spikes</option>
                  <option>Anti Bird Spikes</option>
                  <option>SS Bird Spikes</option>
                  <option>Invisible Grills</option>
                  <option>SS Invisible Grills</option>
                  <option>Cloth Hangers Installation</option>
                  <option>SS Cloth Hangers</option>
                  <option>Artificial Grass</option>
                  <option>Artificial Turf</option>
                  <option>Cricket Nets</option>
                  <option>Box Cricket Setup</option>
                  <option>Other</option>
                </select>
              </div>
              <div class="form-group form-icon">
                <label>Your Location</label><i class="fas fa-map-marker-alt"></i>
                <input type="text" name="location" class="form-control" placeholder="Area, City">
              </div>
            </div>
            <div class="form-group">
              <label>Message / Requirements</label>
              <textarea name="message" class="form-control" rows="5" placeholder="Please describe your requirements, area size, location etc..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100 btn-lg">
              <i class="fas fa-paper-plane"></i> Send Message — We'll Call You Back
            </button>
          </form>
          <div class="form-success" style="display:none;text-align:center;padding:30px">
            <i class="fas fa-check-circle" style="font-size:3rem;color:var(--success);display:block;margin-bottom:16px"></i>
            <h4>Message Sent Successfully!</h4>
            <p>Our team will contact you within <strong>2-4 hours</strong> on your mobile number.</p>
            <a href="<?php echo SITE_WHATSAPP; ?>" target="_blank" class="btn btn-whatsapp mt-16">
              <i class="fab fa-whatsapp"></i> Chat on WhatsApp for Faster Response
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="cta-section">
  <div class="container" style="text-align:center">
    <h2>India's Largest Russea™ Net Supplier</h2>
    <p>Wholesale pigeon nets, balcony safety nets, invisible grills, artificial grass & cricket nets. Pan-India delivery.</p>
    <div class="cta-buttons">
      <a href="tel:+91<?php echo SITE_PHONE; ?>" class="btn btn-outline-white btn-lg"><i class="fas fa-phone-alt"></i> +91 <?php echo SITE_PHONE; ?></a>
      <a href="<?php echo SITE_WHATSAPP; ?>" target="_blank" class="btn btn-whatsapp btn-lg"><i class="fab fa-whatsapp"></i> WhatsApp</a>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
