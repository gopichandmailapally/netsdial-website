<?php
/**
 * NetsDial - Database Installation Script
 * Run once to set up the database
 */

// Basic security - delete this file after installation
session_start();

$step   = (int)($_GET['step'] ?? 1);
$errors = [];
$ok     = false;

if ($step === 2 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $host   = $_POST['host'] ?? 'localhost';
    $user   = $_POST['user'] ?? '';
    $pass   = $_POST['pass'] ?? '';
    $dbname = $_POST['dbname'] ?? 'netsdial_db';

    try {
        $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]);

        // Create database
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $pdo->exec("USE `$dbname`");

        // Read and execute SQL schema
        $sql = file_get_contents(__DIR__ . '/schema.sql');
        $statements = array_filter(array_map('trim', explode(';', $sql)));
        $executed = 0;
        foreach ($statements as $stmt) {
            if ($stmt) {
                try {
                    $pdo->exec($stmt);
                    $executed++;
                } catch (PDOException $e) {
                    // Skip "already exists" errors
                    if (strpos($e->getMessage(), '1050') === false && strpos($e->getMessage(), '1060') === false) {
                        $errors[] = $e->getMessage();
                    }
                }
            }
        }

        // Write database config
        $cfg_content = '<?php
define(\'DB_HOST\', \'' . addslashes($host) . '\');
define(\'DB_USER\', \'' . addslashes($user) . '\');
define(\'DB_PASS\', \'' . addslashes($pass) . '\');
define(\'DB_NAME\', \'' . addslashes($dbname) . '\');
';
        $cfg_file = dirname(__DIR__) . '/config/database.php';
        $existing = file_get_contents($cfg_file);
        // Update only the define lines
        $existing = preg_replace("/define\('DB_HOST',.*?\);/", "define('DB_HOST', '" . addslashes($host) . "');", $existing);
        $existing = preg_replace("/define\('DB_USER',.*?\);/", "define('DB_USER', '" . addslashes($user) . "');", $existing);
        $existing = preg_replace("/define\('DB_PASS',.*?\);/", "define('DB_PASS', '" . addslashes($pass) . "');", $existing);
        $existing = preg_replace("/define\('DB_NAME',.*?\);/", "define('DB_NAME', '" . addslashes($dbname) . "');", $existing);
        file_put_contents($cfg_file, $existing);

        if (empty($errors)) {
            $ok = true;
            $step = 3;
        }
    } catch (PDOException $e) {
        $errors[] = 'Connection failed: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NetsDial - Installation Setup</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;900&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Poppins',sans-serif;background:linear-gradient(135deg,#1a1a2e,#16213e,#0f3460);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
.installer{background:#fff;border-radius:20px;max-width:600px;width:100%;overflow:hidden;box-shadow:0 30px 80px rgba(0,0,0,.4)}
.installer-header{background:linear-gradient(135deg,#FF6B00,#FF8C42);padding:32px;color:#fff;text-align:center}
.installer-header img{height:55px;margin-bottom:16px}
.installer-header h1{font-size:1.5rem;font-weight:700}
.installer-body{padding:32px}
.steps{display:flex;margin-bottom:32px;gap:8px}
.step-dot{flex:1;height:6px;border-radius:99px;background:#e5e7eb}
.step-dot.done{background:#FF6B00}
.form-group{margin-bottom:20px}
.form-group label{display:block;margin-bottom:6px;font-weight:600;font-size:.9rem;color:#374151}
.form-group input{width:100%;padding:12px 16px;border:2px solid #e5e7eb;border-radius:10px;font-size:1rem;font-family:inherit;outline:none;transition:border-color .2s}
.form-group input:focus{border-color:#FF6B00}
.btn{width:100%;padding:14px;background:linear-gradient(135deg,#FF6B00,#FF8C42);color:#fff;border:none;border-radius:10px;font-size:1rem;font-weight:700;cursor:pointer;font-family:inherit;margin-top:8px}
.error{background:#FEF2F2;border:1px solid #FECACA;color:#DC2626;padding:12px 16px;border-radius:10px;font-size:.88rem;margin-bottom:16px}
.success{background:#F0FDF4;border:1px solid #BBF7D0;color:#15803D;padding:16px;border-radius:10px;text-align:center}
.info{background:#EFF6FF;border:1px solid #BFDBFE;color:#1D4ED8;padding:12px;border-radius:10px;font-size:.85rem;margin-bottom:20px}
.hint{font-size:.78rem;color:#9CA3AF;margin-top:4px}
</style>
</head>
<body>
<div class="installer">
  <div class="installer-header">
    <div style="font-size:2.5rem;margin-bottom:12px">⚙️</div>
    <h1>NetsDial Installation</h1>
    <p style="opacity:.85;font-size:.9rem;margin-top:4px">Set up your database and get started</p>
  </div>
  <div class="installer-body">
    <div class="steps">
      <div class="step-dot done"></div>
      <div class="step-dot <?php echo $step>=2?'done':''; ?>"></div>
      <div class="step-dot <?php echo $step>=3?'done':''; ?>"></div>
    </div>

    <?php if ($step === 1): ?>
    <h2 style="margin-bottom:12px;font-size:1.2rem">Welcome to NetsDial Setup</h2>
    <div class="info">
      <strong>Before you begin, ensure:</strong><br>
      ✅ PHP 7.4+ with PDO MySQL extension<br>
      ✅ MySQL 5.7+ database access<br>
      ✅ Apache/Nginx with mod_rewrite enabled<br>
      ✅ This file is in the <code>install/</code> folder
    </div>
    <p style="color:#6B7280;font-size:.9rem;margin-bottom:24px">This wizard will create the database tables and populate initial data for your NetsDial website.</p>
    <a href="?step=2" style="display:block;text-align:center;padding:14px;background:linear-gradient(135deg,#FF6B00,#FF8C42);color:#fff;border-radius:10px;font-weight:700;text-decoration:none">Continue → Set Up Database</a>

    <?php elseif ($step === 2): ?>
    <h2 style="margin-bottom:16px;font-size:1.2rem">Database Configuration</h2>
    <?php foreach ($errors as $e): ?><div class="error">❌ <?php echo htmlspecialchars($e); ?></div><?php endforeach; ?>
    <form method="POST" action="?step=2">
      <div class="form-group"><label>Database Host</label><input type="text" name="host" value="localhost" required><p class="hint">Usually "localhost" for shared hosting</p></div>
      <div class="form-group"><label>Database Username</label><input type="text" name="user" placeholder="your_db_username" required></div>
      <div class="form-group"><label>Database Password</label><input type="password" name="pass" placeholder="your_db_password"></div>
      <div class="form-group"><label>Database Name</label><input type="text" name="dbname" value="netsdial_db" required><p class="hint">Create this database in cPanel first (or give the user CREATE privileges)</p></div>
      <button type="submit" class="btn">Install Database & Continue →</button>
    </form>

    <?php elseif ($step === 3): ?>
    <div class="success">
      <div style="font-size:3rem;margin-bottom:12px">🎉</div>
      <h2 style="margin-bottom:12px;color:#15803D">Installation Successful!</h2>
      <p style="color:#166534;font-size:.9rem;margin-bottom:20px">Your NetsDial website database has been set up successfully!</p>
    </div>
    <div style="margin-top:20px;padding:16px;background:#FFF7ED;border-radius:10px;border:1px solid #FED7AA">
      <strong style="color:#92400E">⚠️ Security Steps:</strong>
      <ol style="margin-top:10px;padding-left:20px;font-size:.88rem;color:#78350F;line-height:2">
        <li>Delete or restrict access to the <code>install/</code> folder</li>
        <li>Login to admin: <code>/admin/login.php</code></li>
        <li>Default credentials: <strong>admin / password</strong></li>
        <li>Change password immediately from Admin → Users</li>
      </ol>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:20px">
      <a href="/" style="display:block;text-align:center;padding:12px;background:#f3f4f6;color:#374151;border-radius:10px;font-weight:600;text-decoration:none">🏠 View Website</a>
      <a href="/admin/login.php" style="display:block;text-align:center;padding:12px;background:linear-gradient(135deg,#FF6B00,#FF8C42);color:#fff;border-radius:10px;font-weight:700;text-decoration:none">⚙️ Go to Admin Panel</a>
    </div>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
