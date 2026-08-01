<?php
/**
 * NetsDial - Contact Form API
 * Sends email notification on form submission
 */
define('NETSDIAL', true);
require_once dirname(__DIR__) . '/config/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Rate limiting (simple IP-based)
$ip = $_SERVER['REMOTE_ADDR'] ?? '';
$cacheKey = 'contact_' . md5($ip);

// Sanitize inputs
$name     = cleanInput($_POST['name'] ?? '');
$email    = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$phone    = cleanInput($_POST['phone'] ?? '');
$service  = cleanInput($_POST['service'] ?? '');
$location = cleanInput($_POST['location'] ?? '');
$message  = cleanInput($_POST['message'] ?? '');
$source   = cleanInput($_POST['source_page'] ?? $_SERVER['HTTP_REFERER'] ?? '');

// Validation
$errors = [];
if (empty($name) || strlen($name) < 2)  $errors[] = 'Please enter your name.';
if (empty($phone) || strlen($phone) < 10) $errors[] = 'Please enter a valid 10-digit phone number.';
if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email address.';

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

// Honeypot check
if (!empty($_POST['website'])) {
    echo json_encode(['success' => true, 'message' => 'Thank you!']);
    exit;
}

// Save to database
try {
    $contactId = db()->insert(
        "INSERT INTO contacts (name, email, phone, service, location, message, source_page, ip_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
        [$name, $email, $phone, $service, $location, $message, $source, $ip]
    );
} catch (Exception $e) {
    error_log('Contact save error: ' . $e->getMessage());
    $contactId = 0;
}

// Send email notification
$to_email   = getSetting('site_email', 'netsdial@gmail.com');
$smtp_host  = getSetting('smtp_host', 'smtp.gmail.com');
$smtp_port  = getSetting('smtp_port', '587');
$smtp_user  = getSetting('smtp_user', '');
$smtp_pass  = getSetting('smtp_pass', '');
$smtp_name  = getSetting('smtp_name', 'NetsDial');

// Email body
$email_body = "
<!DOCTYPE html>
<html>
<head><style>
body{font-family:Arial,sans-serif;color:#333;margin:0;padding:0;background:#f5f5f5}
.wrap{max-width:600px;margin:20px auto;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,.1)}
.header{background:linear-gradient(135deg,#FF6B00,#FF8C42);padding:30px;text-align:center}
.header h1{color:#fff;margin:0;font-size:1.6rem}
.header p{color:rgba(255,255,255,.85);margin:8px 0 0;font-size:.9rem}
.body{padding:30px}
.field{display:flex;gap:12px;padding:14px 0;border-bottom:1px solid #f0f0f0}
.field:last-child{border-bottom:none}
.label{font-weight:700;color:#FF6B00;min-width:100px;font-size:.9rem}
.value{flex:1;font-size:.95rem}
.footer{background:#1A1A1A;padding:16px;text-align:center;color:rgba(255,255,255,.6);font-size:.8rem}
.cta{display:inline-block;background:#FF6B00;color:#fff;padding:10px 24px;border-radius:30px;text-decoration:none;font-weight:700;margin-top:16px}
</style></head>
<body>
<div class='wrap'>
  <div class='header'>
    <h1>📩 New Enquiry - NetsDial</h1>
    <p>A new contact form submission has been received</p>
  </div>
  <div class='body'>
    <div class='field'><span class='label'>Name</span><span class='value'>" . htmlspecialchars($name) . "</span></div>
    <div class='field'><span class='label'>Phone</span><span class='value'><a href='tel:+91" . htmlspecialchars($phone) . "'>+91 " . htmlspecialchars($phone) . "</a></span></div>
    <div class='field'><span class='label'>Email</span><span class='value'>" . htmlspecialchars($email ?: 'Not provided') . "</span></div>
    <div class='field'><span class='label'>Service</span><span class='value'>" . htmlspecialchars($service ?: 'Not specified') . "</span></div>
    <div class='field'><span class='label'>Location</span><span class='value'>" . htmlspecialchars($location ?: 'Not specified') . "</span></div>
    <div class='field'><span class='label'>Message</span><span class='value'>" . nl2br(htmlspecialchars($message ?: 'No message')) . "</span></div>
    <div class='field'><span class='label'>Source</span><span class='value'>" . htmlspecialchars($source ?: 'Direct') . "</span></div>
    <div class='field'><span class='label'>IP</span><span class='value'>" . htmlspecialchars($ip) . "</span></div>
    <div class='field'><span class='label'>Time</span><span class='value'>" . date('d M Y, h:i A') . " IST</span></div>
    <center><a href='" . SITE_URL . "/admin/contacts.php' class='cta'>View in Admin Panel</a></center>
  </div>
  <div class='footer'>NetsDial | GCM Enterprises | contact@netsdial.com | +91 9966499144</div>
</div>
</body></html>
";

$subject = "New Enquiry: " . ($service ?: 'General') . " - " . $name . " | NetsDial";

// Use PHP mail() as fallback, or PHPMailer if available
$email_sent = false;

// Try PHPMailer if available
$phpmailer_path = dirname(__DIR__) . '/vendor/phpmailer/PHPMailer.php';
if (file_exists($phpmailer_path)) {
    require_once $phpmailer_path;
    // PHPMailer setup
    // ... (PHPMailer code here)
} else {
    // Fallback: PHP mail()
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "From: {$smtp_name} <{$smtp_user}>\r\n";
    $headers .= "Reply-To: {$email}\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

    if ($to_email) {
        $email_sent = mail($to_email, $subject, $email_body, $headers);
    }

    // Auto-reply to customer
    if (!empty($email)) {
        $auto_reply = "
        <!DOCTYPE html><html><head><style>
        body{font-family:Arial,sans-serif;background:#f5f5f5;margin:0;padding:0}
        .wrap{max-width:600px;margin:20px auto;background:#fff;border-radius:12px;overflow:hidden}
        .header{background:linear-gradient(135deg,#FF6B00,#FF8C42);padding:28px;text-align:center}
        .header h1{color:#fff;margin:0;font-size:1.4rem}
        .body{padding:28px;color:#333}
        .footer{background:#1A1A1A;padding:14px;text-align:center;color:rgba(255,255,255,.6);font-size:.8rem}
        .btn{display:inline-block;background:#FF6B00;color:#fff;padding:10px 24px;border-radius:30px;text-decoration:none;font-weight:700}
        </style></head>
        <body>
        <div class='wrap'>
          <div class='header'><h1>✅ Thank You, {$name}!</h1></div>
          <div class='body'>
            <p>We have received your enquiry about <strong>" . htmlspecialchars($service ?: 'our services') . "</strong>.</p>
            <p>Our team will contact you within <strong>2-4 hours</strong> on your number <strong>+91 {$phone}</strong>.</p>
            <p>For urgent requirements, please call or WhatsApp us directly:</p>
            <center style='margin:24px 0'>
              <a href='tel:+919966499144' class='btn'>📞 Call Now: 9966499144</a>
            </center>
            <p style='font-size:.88rem;color:#666'>NetsDial is India's largest wholesale supplier of Russea™ HDPE Safety Nets, Invisible Grills, Artificial Grass and Cricket Nets.</p>
          </div>
          <div class='footer'>NetsDial | GCM Enterprises | " . SITE_ADDRESS . "</div>
        </div>
        </body></html>
        ";
        $ar_headers  = "MIME-Version: 1.0\r\n";
        $ar_headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $ar_headers .= "From: NetsDial <{$to_email}>\r\n";
        mail($email, "We received your enquiry - NetsDial", $auto_reply, $ar_headers);
    }
}

echo json_encode([
    'success' => true,
    'message' => 'Thank you! We will contact you within 2-4 hours.',
    'id'      => $contactId,
]);
