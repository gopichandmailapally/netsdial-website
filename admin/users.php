<?php
define('NETSDIAL', true);
require_once dirname(__DIR__) . '/config/config.php';
requireAdmin();
$admin_page_title = 'Admin Users & Security';

$msg = '';

// Change password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['form'] === 'change_password') {
    $id       = (int)$_SESSION['admin_id'];
    $current  = cleanInput($_POST['current_password']);
    $new      = $_POST['new_password'];
    $confirm  = $_POST['confirm_password'];

    $admin = db()->fetchOne("SELECT * FROM admin_users WHERE id=?", [$id]);
    if (!password_verify($current, $admin['password'])) {
        $msg = ['type'=>'error','text'=>'Current password is incorrect.'];
    } elseif (strlen($new) < 8) {
        $msg = ['type'=>'error','text'=>'New password must be at least 8 characters.'];
    } elseif ($new !== $confirm) {
        $msg = ['type'=>'error','text'=>'Passwords do not match.'];
    } else {
        $hash = password_hash($new, PASSWORD_BCRYPT);
        db()->execute("UPDATE admin_users SET password=? WHERE id=?", [$hash, $id]);
        $msg = ['type'=>'success','text'=>'Password changed successfully!'];
    }
}

// Change username
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['form'] === 'change_username') {
    $id       = (int)$_SESSION['admin_id'];
    $username = cleanInput($_POST['username']);
    $email    = cleanInput($_POST['email']);
    $name     = cleanInput($_POST['full_name']);

    if (!$username) {
        $msg = ['type'=>'error','text'=>'Username cannot be empty.'];
    } else {
        db()->execute("UPDATE admin_users SET username=?, email=?, full_name=? WHERE id=?", [$username, $email, $name, $id]);
        $_SESSION['admin_username'] = $username;
        $msg = ['type'=>'success','text'=>'Profile updated successfully!'];
    }
}

// Add new admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['form'] === 'add_admin') {
    $u = cleanInput($_POST['new_username']);
    $e = cleanInput($_POST['new_email']);
    $p = $_POST['new_password'];
    $r = cleanInput($_POST['role'] ?? 'editor');
    if ($u && $p) {
        $hash = password_hash($p, PASSWORD_BCRYPT);
        db()->insert("INSERT INTO admin_users (username,email,password,role,is_active) VALUES (?,?,?,?,1)", [$u,$e,$hash,$r]);
        $msg = ['type'=>'success','text'=>'Admin user added.'];
    }
}

// Delete admin
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id !== (int)$_SESSION['admin_id']) {
        db()->execute("DELETE FROM admin_users WHERE id=?", [$id]);
        redirect('/admin/users.php?deleted=1');
    }
}

$current_admin = db()->fetchOne("SELECT * FROM admin_users WHERE id=?", [(int)$_SESSION['admin_id']]);
$all_admins    = db()->fetchAll("SELECT id,username,email,full_name,role,is_active,last_login FROM admin_users ORDER BY id");

include __DIR__ . '/includes/admin-header.php';
?>
<?php if (isset($_GET['deleted'])): ?><div class="admin-alert admin-alert-success" data-auto-dismiss><i class="fas fa-check-circle"></i> User deleted.</div><?php endif; ?>
<?php if ($msg): ?><div class="admin-alert admin-alert-<?php echo $msg['type']==='success'?'success':'danger'; ?>" data-auto-dismiss><i class="fas fa-<?php echo $msg['type']==='success'?'check-circle':'exclamation-circle'; ?>"></i> <?php echo htmlspecialchars($msg['text']); ?></div><?php endif; ?>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px">
  <!-- Profile Settings -->
  <div class="admin-card">
    <div class="admin-card-header"><div class="admin-card-title"><i class="fas fa-user-cog"></i> My Profile</div></div>
    <div class="admin-card-body">
      <div style="text-align:center;margin-bottom:24px">
        <div style="width:80px;height:80px;background:linear-gradient(135deg,var(--primary),var(--primary-dark));border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:2rem;margin:0 auto 12px"><i class="fas fa-user"></i></div>
        <strong style="font-size:1.1rem"><?php echo htmlspecialchars($current_admin['full_name']?:$current_admin['username']); ?></strong>
        <div style="font-size:.85rem;color:var(--text-light)"><?php echo htmlspecialchars($current_admin['role']); ?></div>
      </div>
      <form method="POST">
        <input type="hidden" name="form" value="change_username">
        <div class="admin-form-group"><label>Username</label><input type="text" name="username" class="admin-form-control" value="<?php echo htmlspecialchars($current_admin['username']); ?>" required></div>
        <div class="admin-form-group"><label>Full Name</label><input type="text" name="full_name" class="admin-form-control" value="<?php echo htmlspecialchars($current_admin['full_name']??''); ?>"></div>
        <div class="admin-form-group"><label>Email</label><input type="email" name="email" class="admin-form-control" value="<?php echo htmlspecialchars($current_admin['email']??''); ?>"></div>
        <button type="submit" class="btn-admin btn-admin-primary"><i class="fas fa-save"></i> Update Profile</button>
      </form>
    </div>
  </div>

  <!-- Change Password -->
  <div class="admin-card">
    <div class="admin-card-header"><div class="admin-card-title"><i class="fas fa-lock"></i> Change Password</div></div>
    <div class="admin-card-body">
      <form method="POST">
        <input type="hidden" name="form" value="change_password">
        <div class="admin-form-group"><label>Current Password *</label><input type="password" name="current_password" class="admin-form-control" required autocomplete="current-password"></div>
        <div class="admin-form-group"><label>New Password *</label><input type="password" name="new_password" class="admin-form-control" required id="newpw" autocomplete="new-password"><div class="form-hint">Minimum 8 characters</div></div>
        <div class="admin-form-group"><label>Confirm New Password *</label><input type="password" name="confirm_password" class="admin-form-control" required id="cpw" autocomplete="new-password"></div>
        <div id="pwMatchMsg" style="font-size:.82rem;margin:-8px 0 12px;display:none"></div>
        <button type="submit" class="btn-admin btn-admin-primary"><i class="fas fa-key"></i> Change Password</button>
      </form>
    </div>
  </div>
</div>

<!-- All Admins -->
<div class="admin-card mt-24">
  <div class="admin-card-header">
    <div class="admin-card-title"><i class="fas fa-users-cog"></i> All Admin Users</div>
    <button onclick="document.getElementById('addAdminForm').classList.toggle('hidden')" class="btn-admin btn-admin-primary btn-admin-sm"><i class="fas fa-plus"></i> Add Admin</button>
  </div>
  <div id="addAdminForm" class="admin-card-body hidden" style="border-bottom:1px solid var(--border)">
    <form method="POST" style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr auto;gap:12px;align-items:end">
      <input type="hidden" name="form" value="add_admin">
      <div class="admin-form-group" style="margin:0"><label>Username</label><input type="text" name="new_username" class="admin-form-control" required></div>
      <div class="admin-form-group" style="margin:0"><label>Email</label><input type="email" name="new_email" class="admin-form-control"></div>
      <div class="admin-form-group" style="margin:0"><label>Password</label><input type="password" name="new_password" class="admin-form-control" required minlength="8"></div>
      <div class="admin-form-group" style="margin:0"><label>Role</label>
        <select name="role" class="admin-form-control"><option value="super_admin">Super Admin</option><option value="admin">Admin</option><option value="editor">Editor</option></select>
      </div>
      <button type="submit" class="btn-admin btn-admin-success"><i class="fas fa-plus"></i> Add</button>
    </form>
  </div>
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead><tr><th>Username</th><th>Full Name</th><th>Email</th><th>Role</th><th>Last Login</th><th>Actions</th></tr></thead>
      <tbody>
        <?php foreach ($all_admins as $a): ?>
        <tr>
          <td><strong><?php echo htmlspecialchars($a['username']); ?></strong> <?php if ((int)$a['id']===(int)$_SESSION['admin_id']): ?><span class="status-badge badge-success" style="font-size:.65rem">You</span><?php endif; ?></td>
          <td><?php echo htmlspecialchars($a['full_name']??'-'); ?></td>
          <td style="font-size:.85rem"><?php echo htmlspecialchars($a['email']??'-'); ?></td>
          <td><span class="status-badge badge-info"><?php echo htmlspecialchars($a['role']); ?></span></td>
          <td style="font-size:.78rem;color:var(--text-light)"><?php echo $a['last_login']?timeAgo($a['last_login']):'Never'; ?></td>
          <td>
            <?php if ((int)$a['id']!==(int)$_SESSION['admin_id']): ?>
            <a href="?delete=<?php echo $a['id']; ?>" class="btn-admin btn-admin-danger btn-admin-icon" data-confirm="Delete this admin user?"><i class="fas fa-trash"></i></a>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
const np = document.getElementById('newpw'), cp = document.getElementById('cpw'), m = document.getElementById('pwMatchMsg');
function checkPwMatch() {
  if (!cp.value) { m.style.display='none'; return; }
  m.style.display = 'block';
  if (np.value === cp.value) { m.style.color='#10B981'; m.textContent='✓ Passwords match'; }
  else { m.style.color='#EF4444'; m.textContent='✗ Passwords do not match'; }
}
np?.addEventListener('input', checkPwMatch);
cp?.addEventListener('input', checkPwMatch);
</script>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
