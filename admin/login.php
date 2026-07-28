<?php
/**
 * NetsDial Admin - Login Page
 */
define('NETSDIAL', true);
require_once dirname(__DIR__) . '/config/config.php';

// Already logged in
if (isAdmin()) redirect('/admin/');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = cleanInput($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Please enter username and password.';
    } else {
        $user = db()->fetchOne("SELECT * FROM admin_users WHERE username = ?", [$username]);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id']        = $user['id'];
            $_SESSION['admin_name']      = $user['name'];
            $_SESSION['admin_role']      = $user['role'];
            db()->execute("UPDATE admin_users SET last_login=NOW() WHERE id=?", [$user['id']]);
            redirect('/admin/');
        } else {
            $error = 'Invalid username or password. Please try again.';
            // Log failed attempt
            error_log("Failed login attempt for: $username from " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login - NetsDial</title>
  <meta name="robots" content="noindex, nofollow">
  <link rel="icon" type="image/png" href="/assets/images/favicon.png">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Poppins',sans-serif;background:linear-gradient(135deg,#1A1A1A 0%,#2D2D2D 40%,#1A1A1A 100%);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px;position:relative;overflow:hidden}
    body::before{content:'';position:absolute;top:-200px;right:-200px;width:600px;height:600px;border-radius:50%;background:rgba(255,107,0,.05);pointer-events:none}
    body::after{content:'';position:absolute;bottom:-200px;left:-200px;width:500px;height:500px;border-radius:50%;background:rgba(255,107,0,.04);pointer-events:none}
    .login-wrap{width:100%;max-width:440px;position:relative;z-index:1}
    .login-logo{text-align:center;margin-bottom:32px}
    .login-logo img{height:60px;object-fit:contain}
    .login-logo h1{color:#fff;font-size:1.4rem;margin-top:12px;font-weight:700}
    .login-logo p{color:rgba(255,255,255,.5);font-size:.85rem;margin-top:4px}
    .login-card{background:#fff;border-radius:24px;padding:40px;box-shadow:0 24px 80px rgba(0,0,0,.35)}
    .login-card h2{font-size:1.5rem;margin-bottom:8px;color:#1A1A1A}
    .login-card p{color:#6B7280;font-size:.9rem;margin-bottom:28px}
    .form-group{margin-bottom:20px;position:relative}
    .form-group label{display:block;font-weight:600;font-size:.85rem;margin-bottom:7px;color:#374151}
    .input-wrap{position:relative}
    .input-wrap i{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#FF6B00;font-size:1rem}
    .form-control{width:100%;padding:13px 16px 13px 44px;border:2px solid #E5E7EB;border-radius:10px;font-size:.95rem;font-family:inherit;color:#1A1A1A;outline:none;transition:all .25s;background:#fff}
    .form-control:focus{border-color:#FF6B00;box-shadow:0 0 0 4px rgba(255,107,0,.1)}
    .toggle-pwd{position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer;color:#9CA3AF;transition:color .2s;background:none;border:none}
    .toggle-pwd:hover{color:#FF6B00}
    .btn-login{width:100%;padding:15px;background:linear-gradient(135deg,#FF6B00,#FF8C42);color:#fff;border:none;border-radius:10px;font-weight:700;font-size:1rem;cursor:pointer;transition:all .25s;font-family:inherit;display:flex;align-items:center;justify-content:center;gap:10px;margin-top:8px}
    .btn-login:hover{transform:translateY(-2px);box-shadow:0 8px 30px rgba(255,107,0,.4)}
    .btn-login:active{transform:translateY(0)}
    .error{background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);color:#DC2626;padding:12px 16px;border-radius:8px;font-size:.88rem;margin-bottom:20px;display:flex;align-items:center;gap:8px}
    .admin-badge{display:flex;align-items:center;justify-content:center;gap:8px;margin-top:24px;color:rgba(255,255,255,.4);font-size:.78rem}
    .admin-badge a{color:rgba(255,107,0,.6);text-decoration:none;transition:color .2s}
    .admin-badge a:hover{color:#FF6B00}
  </style>
</head>
<body>
<div class="login-wrap">
  <div class="login-logo">
    <img src="/assets/images/logo.png" alt="NetsDial" onerror="this.style.display='none'">
    <h1>NetsDial Admin</h1>
    <p>Control Panel — GCM Enterprises</p>
  </div>
  <div class="login-card">
    <h2>Welcome Back 👋</h2>
    <p>Sign in to manage your website content, reviews, blogs and more.</p>

    <?php if ($error): ?>
    <div class="error"><i class="fas fa-exclamation-circle"></i><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="form-group">
        <label>Username</label>
        <div class="input-wrap">
          <i class="fas fa-user"></i>
          <input type="text" name="username" class="form-control" placeholder="Enter username" required
                 value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" autocomplete="username">
        </div>
      </div>
      <div class="form-group">
        <label>Password</label>
        <div class="input-wrap">
          <i class="fas fa-lock"></i>
          <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required autocomplete="current-password">
          <button type="button" class="toggle-pwd" onclick="togglePwd()"><i class="fas fa-eye" id="eyeIcon"></i></button>
        </div>
      </div>
      <button type="submit" class="btn-login">
        <i class="fas fa-sign-in-alt"></i> Sign In to Admin Panel
      </button>
    </form>
  </div>
  <div class="admin-badge">
    <i class="fas fa-shield-alt"></i>
    Secured Admin Area | <a href="/">← Back to Website</a>
  </div>
</div>
<script>
function togglePwd(){
  const p = document.getElementById('password');
  const e = document.getElementById('eyeIcon');
  p.type = p.type === 'password' ? 'text' : 'password';
  e.className = p.type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
}
</script>
</body>
</html>
