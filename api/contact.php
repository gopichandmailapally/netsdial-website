<?php
/**
 * NetsDial - Contact Form API
 * Saves enquiry to MySQL database & sends real-time email notification via Gmail SMTP (PHPMailer)
 * Recipients: netsdial@gmail.com & gopichandmailapally@gmail.com
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

// 1. Save to MySQL database table contacts
try {
    $contactId = db()->insert(
        "INSERT INTO contacts (name, email, phone, service, location, message, source_page, ip_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
        [$name, $email, $phone, $service, $location, $message, $source, $ip]
    );
} catch (Exception $e) {
    error_log('Contact save error: ' . $e->getMessage());
    $contactId = 0;
}


// ── Push Lead to ChatGCM Central Omnichannel CRM (100% Autonomous) ────────────
try {
     = 'http://127.0.0.1:3020/api/crm/ingest-lead';
     = json_encode([
        'websiteId'          => 'netsdial',
        'customerName'       =>  ?: 'NetsDial Visitor',
        'phone'              =>  ?: '',
        'email'              =>  ?: null,
        'city'               =>  ?: 'Hyderabad',
        'locality'           =>  ?: null,
        'service'            =>  ?: 'Netting Directory Inquiry',
        'requirementSummary' => !empty() ?  . (!empty() ? ' in ' .  : '') : 'NetsDial Directory Inquiry',
        'channel'            => 'web_form',
        'sourceUrl'          =>  ?: 'https://netsdial.com',
        'ipAddress'          =>  ?: '127.0.0.1',
        'notes'              =>  ?: null
    ]);

     = curl_init();
    curl_setopt(, CURLOPT_POST, true);
    curl_setopt(, CURLOPT_POSTFIELDS, );
    curl_setopt(, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'X-GCM-KEY: gcm-lead-bridge-2026'
    ]);
    curl_setopt(, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(, CURLOPT_TIMEOUT, 2);
    curl_setopt(, CURLOPT_CONNECTTIMEOUT, 1);
    curl_exec();
    curl_close();
} catch (\Throwable ) {
    error_log('[ChatGCM Bridge Error NetsDial] ' . ->getMessage());
}

// 2. Email Configuration
$to_email   = getSetting('site_email', 'netsdial@gmail.com');
$smtp_host  = getSetting('smtp_host', 'smtp.gmail.com');
$smtp_port  = (int)getSetting('smtp_port', '587');
$smtp_user  = getSetting('smtp_user', 'gcmsafetynets@gmail.com');
$smtp_pass  = getSetting('smtp_pass', 'kyfeomgmoshdriym');
$smtp_name  = getSetting('smtp_name', 'NetsDial');

// Email HTML Body
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
.label{font-weight:700;color:#FF6B00;min-width:110px;font-size:.9rem}
.value{flex:1;font-size:.95rem}
.footer{background:#1A1A1A;padding:16px;text-align:center;color:rgba(255,255,255,.6);font-size:.8rem}
.cta{display:inline-block;background:#FF6B00;color:#fff;padding:10px 24px;border-radius:30px;text-decoration:none;font-weight:700;margin-top:16px}
</style></head>
<body>
<div class='wrap'>
  <div class='header'>
    <h1>📩 New Enquiry – NetsDial</h1>
    <p>A new enquiry has been submitted on netsdial.com</p>
  </div>
  <div class='body'>
    <div class='field'><span class='label'>Customer Name</span><span class='value'><strong>" . htmlspecialchars($name) . "</strong></span></div>
    <div class='field'><span class='label'>Phone Number</span><span class='value'><a href='tel:+91" . htmlspecialchars($phone) . "' style='color:#FF6B00;font-weight:700;font-size:1.05rem'>+91 " . htmlspecialchars($phone) . "</a></span></div>
    <div class='field'><span class='label'>Email Address</span><span class='value'>" . htmlspecialchars($email ?: 'Not provided') . "</span></div>
    <div class='field'><span class='label'>Service Required</span><span class='value'><strong>" . htmlspecialchars($service ?: 'General Enquiry') . "</strong></span></div>
    <div class='field'><span class='label'>City / Location</span><span class='value'>" . htmlspecialchars($location ?: 'Not specified') . "</span></div>
    <div class='field'><span class='label'>Requirements</span><span class='value'>" . nl2br(htmlspecialchars($message ?: 'No additional message')) . "</span></div>
    <div class='field'><span class='label'>Source Page</span><span class='value'>" . htmlspecialchars($source ?: 'Direct') . "</span></div>
    <div class='field'><span class='label'>Submission Time</span><span class='value'>" . date('d M Y, h:i A') . " IST</span></div>
    <center><a href='" . SITE_URL . "/admin/contacts.php' class='cta'>View in NetsDial Admin Panel</a></center>
  </div>
  <div class='footer'>NetsDial | Contact: netsdial@gmail.com | Phone: +91 9966499144 | Hyderabad, Telangana</div>
</div>
</body></html>
";

$subject = "New Enquiry: " . ($service ?: 'General') . " - " . $name . " (" . $phone . ") | NetsDial";

$email_sent = false;

// 3. Dispatch via PHPMailer (Gmail SMTP)
$vendor_autoload = dirname(__DIR__) . '/vendor/autoload.php';
if (file_exists($vendor_autoload) && !empty($smtp_user) && !empty($smtp_pass)) {
    require_once $vendor_autoload;

    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = $smtp_host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtp_user;
        $mail->Password   = $smtp_pass;
        $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $smtp_port;

        $mail->setFrom($smtp_user, $smtp_name);
        
        // ── Primary Recipients (Delivered to netsdial@gmail.com and gopichandmailapally@gmail.com) ──
        $mail->addAddress('netsdial@gmail.com', 'NetsDial');
        $mail->addAddress('gopichandmailapally@gmail.com', 'Gopichand Mailapally');

        if (!empty($email)) {
            $mail->addReplyTo($email, $name);
        }

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $subject;
        $mail->Body    = $email_body;
        $mail->AltBody = strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $email_body));

        $mail->send();
        $email_sent = true;
    } catch (\Exception $e) {
        error_log('NetsDial PHPMailer Error: ' . $e->getMessage());
    }

    // Auto-reply to customer (if customer provided an email address)
    if (!empty($email)) {
        try {
            $replyMail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $replyMail->isSMTP();
            $replyMail->Host       = $smtp_host;
            $replyMail->SMTPAuth   = true;
            $replyMail->Username   = $smtp_user;
            $replyMail->Password   = $smtp_pass;
            $replyMail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $replyMail->Port       = $smtp_port;

            $replyMail->setFrom($smtp_user, 'NetsDial');
            $replyMail->addAddress($email, $name);
            $replyMail->isHTML(true);
            $replyMail->CharSet = 'UTF-8';
            $replyMail->Subject = "We received your enquiry - NetsDial";
            $replyMail->Body    = "
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
              <div class='header'><h1>✅ Thank You, " . htmlspecialchars($name) . "!</h1></div>
              <div class='body'>
                <p>We have received your enquiry regarding <strong>" . htmlspecialchars($service ?: 'our services') . "</strong>.</p>
                <p>Our sales and installation team will contact you within <strong>2 to 4 hours</strong> on your number <strong>+91 " . htmlspecialchars($phone) . "</strong>.</p>
                <p>For immediate assistance or wholesale roll dispatch, feel free to call or WhatsApp us:</p>
                <center style='margin:24px 0'>
                  <a href='tel:+919966499144' class='btn'>📞 Call Now: 9966499144</a>
                </center>
                <p style='font-size:.88rem;color:#666'>NetsDial is India's largest wholesale distributor of Russea™ HDPE Safety Nets, Bird Proofing, SS 316 Invisible Grills and Cricket Turfs.</p>
              </div>
              <div class='footer'>NetsDial | Phone: +91 9966499144 | " . SITE_ADDRESS . "</div>
            </div>
            </body></html>";
            $replyMail->send();
        } catch (\Exception $e) {
            // Customer auto-reply failure ignored
        }
    }
}

echo json_encode([
    'success' => true,
    'message' => 'Thank you! We will contact you within 2-4 hours.',
    'id'      => $contactId,
    'email_delivered' => $email_sent
]);
