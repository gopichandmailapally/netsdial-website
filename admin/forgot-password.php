<?php
/**
 * NetsDial Admin - Forgot Password
 */
define('NETSDIAL', true);
require_once dirname(__DIR__) . '/config/config.php';

if (isAdmin()) redirect('/admin/');

$msg   = '';
$error = '';
$step  = $_GET['step'] ?? 'request'; // request | reset
$token = $_GET['token'] ?? '';

// ── STEP 2: Reset password using token ───────────────────────
if ($step === 'reset' && $token) {
    $row = db()->fetchOne(
        "SELECT * FROM password_resets WHERE token=? AND expires_at > NOW() AND used=0",
        [$token]
    );
    if (!$row) {
        $error = 'This reset link has expired or already been used. Please request a new one.';
        $step  = 'request';
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_password'])) {
        $new     = $_POST['new_password'];
        $confirm = $_POST['confirm_password'];
        if (strlen($new) < 8) {
            $error = 'Password must be at least 8 characters.';
        } elseif ($new !== $confirm) {
            $error = 'Passwords do not match.';
        } else {
            $hash = password_hash($new, PASSWORD_BCRYPT);
            db()->execute("UPDATE admin_users SET password=? WHERE email=?", [$hash, $row['email']]);
            db()->execute("UPDATE password_resets SET used=1 WHERE token=?", [$token]);
            $msg  = 'Password updated successfully! You can now login.';
            $step = 'done';
        }
    }
}

// ── STEP 1: Send reset email ──────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && $step === 'request') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $admin = db()->fetchOne("SELECT * FROM admin_users WHERE email=?", [$email]);

    if (!$admin) {
        // Don't reveal if email exists
        $msg = "If that email is registered, a reset link has been sent.";
    } else {
        $resetToken = bin2hex(random_bytes(32));
        $expires    = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Save token
        db()->execute(
            "INSERT INTO password_resets (email, token, expires_at, used) VALUES (?,?,?,0) ON DUPLICATE KEY UPDATE token=?, expires_at=?, used=0",
            [$email, $resetToken, $expires, $resetToken, $expires]
        );

        $resetUrl  = SITE_URL . '/admin/forgot-password.php?step=reset&token=' . $resetToken;
        $adminName = $admin['name'] ?: $admin['username'];

        $emailBody = "<!DOCTYPE html><html><head><style>
body{font-family:Arial,sans-serif;background:#f5f5f5;margin:0}
.wrap{max-width:560px;margin:24px auto;background:#fff;border-radius:14px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,.1)}
.hdr{background:linear-gradient(135deg,#FF6B00,#FF8C42);padding:28px;text-align:center}
.hdr h1{color:#fff;margin:0;font-size:1.4rem}
.body{padding:28px;color:#333;font-size:.95rem;line-height:1.7}
.btn{display:inline-block;background:#FF6B00;color:#fff;padding:13px 32px;border-radius:99px;text-decoration:none;font-weight:700;margin:20px 0}
.ftr{background:#1a1a1a;padding:14px;text-align:center;color:rgba(255,255,255,.5);font-size:.8rem}
</style>
</head><body>
<div class='wrap'>
  <div class='hdr'><h1>🔐 Password Reset - NetsDial Admin</h1></div>
  <div class='body'>
    <p>Hi <strong>{$adminName}</strong>,</p>
    <p>We received a request to reset your NetsDial Admin Panel password. Click the button below to reset it. This link expires in <strong>1 hour</strong>.</p>
    <center><a href='{$resetUrl}' class='btn'>Reset My Password</a></center>
    <p style='font-size:.82rem;color:#888'>Or copy this link into your browser:<br><a href='{$resetUrl}' style='color:#FF6B00;word-break:break-all'>{$resetUrl}</a></p>
    <p style='font-size:.82rem;color:#888'>If you did not request this, simply ignore this email — your password will remain unchanged.</p>
  </div>
  <div class='ftr'>NetsDial | GCM Enterprises | netsdial@gmail.com</div>
</div></body></html>";

        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "From: NetsDial Admin <netsdial@gmail.com>\r\n";
        mail($email, "Password Reset — NetsDial Admin Panel", $emailBody, $headers);

        $msg = "A password reset link has been sent to <strong>{$email}</strong>. Check your inbox (and spam folder). Link expires in 1 hour.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password - NetsDial Admin</title>
  <meta name="robots" content="noindex, nofollow">
  <link rel="icon" type="image/png" href="/assets/images/favicon.png">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Poppins',sans-serif;background:linear-gradient(135deg,#1A1A1A 0%,#2D2D2D 40%,#1A1A1A 100%);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
    .wrap{width:100%;max-width:440px}
    .logo{text-align:center;margin-bottom:28px}
    .logo img{height:55px;object-fit:contain}
    .logo h1{color:#fff;font-size:1.3rem;margin-top:10px;font-weight:700}
    .card{background:#fff;border-radius:24px;padding:40px;box-shadow:0 24px 80px rgba(0,0,0,.35)}
    .card h2{font-size:1.4rem;margin-bottom:6px;color:#1A1A1A}
    .card p{color:#6B7280;font-size:.88rem;margin-bottom:24px;line-height:1.6}
    .form-group{margin-bottom:18px}
    .form-group label{display:block;font-weight:600;font-size:.85rem;margin-bottom:6px;color:#374151}
    .input-wrap{position:relative}
    .input-wrap i{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#FF6B00}
    .form-control{width:100%;padding:13px 16px 13px 44px;border:2px solid #E5E7EB;border-radius:10px;font-size:.93rem;font-family:inherit;outline:none;transition:all .25s}
    .form-control:focus{border-color:#FF6B00;box-shadow:0 0 0 4px rgba(255,107,0,.1)}
    .btn{width:100%;padding:14px;background:linear-gradient(135deg,#FF6B00,#FF8C42);color:#fff;border:none;border-radius:10px;font-weight:700;font-size:.95rem;cursor:pointer;font-family:inherit;display:flex;align-items:center;justify-content:center;gap:9px;transition:all .25s}
    .btn:hover{transform:translateY(-2px);box-shadow:0 8px 30px rgba(255,107,0,.35)}
    .alert{padding:12px 16px;border-radius:8px;font-size:.88rem;margin-bottom:18px;line-height:1.5}
    .alert-success{background:rgba(16,185,129,.08);border:1px solid rgba(16,185,129,.2);color:#065F46}
    .alert-error{background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);color:#DC2626}
    .back-link{display:flex;align-items:center;justify-content:center;gap:6px;margin-top:20px;color:rgba(255,255,255,.45);font-size:.8rem;text-decoration:none;transition:color .2s}
    .back-link:hover{color:rgba(255,107,0,.7)}
    .done-icon{text-align:center;font-size:3.5rem;margin-bottom:16px}
  </style>
</head>
<body>
<div class="wrap">
  <div class="logo">
    <img src="/assets/images/logo.png" alt="NetsDial" onerror="this.style.display='none'">
    <h1>NetsDial Admin</h1>
  </div>

  <div class="card">

    <?php if ($error): ?>
    <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if ($step === 'done'): ?>
      <!-- Done -->
      <div class="done-icon">✅</div>
      <h2>Password Updated!</h2>
      <p>Your password has been changed successfully. You can now login with your new password.</p>
      <a href="/admin/login.php" class="btn" style="text-decoration:none;margin-top:8px"><i class="fas fa-sign-in-alt"></i> Go to Login</a>

    <?php elseif ($step === 'reset' && !$error): ?>
      <!-- Set new password -->
      <h2>Set New Password</h2>
      <p>Enter and confirm your new password below.</p>
      <?php if ($msg): ?><div class="alert alert-error"><?php echo $msg; ?></div><?php endif; ?>
      <form method="POST">
        <div class="form-group">
          <label>New Password</label>
          <div class="input-wrap"><i class="fas fa-lock"></i>
            <input type="password" name="new_password" class="form-control" placeholder="Min. 8 characters" required minlength="8">
          </div>
        </div>
        <div class="form-group">
          <label>Confirm Password</label>
          <div class="input-wrap"><i class="fas fa-lock"></i>
            <input type="password" name="confirm_password" class="form-control" placeholder="Repeat password" required>
          </div>
        </div>
        <button type="submit" class="btn"><i class="fas fa-key"></i> Update Password</button>
      </form>

    <?php else: ?>
      <!-- Request reset -->
      <h2>Forgot Password?</h2>
      <p>Enter the email address linked to your admin account. We'll send a password reset link valid for 1 hour.</p>
      <?php if ($msg): ?><div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo $msg; ?></div><?php endif; ?>
      <?php if (!$msg): ?>
      <form method="POST">
        <div class="form-group">
          <label>Admin Email Address</label>
          <div class="input-wrap"><i class="fas fa-envelope"></i>
            <input type="email" name="email" class="form-control" placeholder="your@email.com" required autofocus>
          </div>
        </div>
        <button type="submit" class="btn"><i class="fas fa-paper-plane"></i> Send Reset Link</button>
      </form>
      <?php endif; ?>
    <?php endif; ?>

  </div>

  <a href="/admin/login.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Login</a>
</div>
</body>
</html>
