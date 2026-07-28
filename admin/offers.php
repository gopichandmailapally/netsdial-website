<?php
define('NETSDIAL', true);
require_once dirname(__DIR__) . '/config/config.php';
requireAdmin();
$admin_page_title = 'Offers & Coupons';

if (isset($_GET['delete'])) {
    db()->execute("DELETE FROM offers WHERE id=?",[(int)$_GET['delete']]);
    redirect('/admin/offers.php?msg=Offer+deleted');
}
if (isset($_GET['toggle'])) {
    $cur = db()->fetchOne("SELECT is_active FROM offers WHERE id=?",[(int)$_GET['toggle']]);
    db()->execute("UPDATE offers SET is_active=? WHERE id=?",[$cur['is_active']?0:1,(int)$_GET['toggle']]);
    redirect('/admin/offers.php?msg=Toggled');
}

if ($_SERVER['REQUEST_METHOD']==='POST') {
    if ($_POST['oid']) {
        db()->execute("UPDATE offers SET title=?,description=?,discount_type=?,discount_value=?,coupon_code=?,valid_until=?,terms=?,is_active=? WHERE id=?",
            [cleanInput($_POST['title']),cleanInput($_POST['description']),cleanInput($_POST['discount_type']),
             (float)$_POST['discount_value'],strtoupper(cleanInput($_POST['coupon_code'])),
             $_POST['valid_until']?:null,cleanInput($_POST['terms']),isset($_POST['is_active'])?1:0,(int)$_POST['oid']]);
    } else {
        db()->insert("INSERT INTO offers (title,description,discount_type,discount_value,coupon_code,valid_until,terms,is_active) VALUES (?,?,?,?,?,?,?,?)",
            [cleanInput($_POST['title']),cleanInput($_POST['description']),cleanInput($_POST['discount_type']),
             (float)$_POST['discount_value'],strtoupper(cleanInput($_POST['coupon_code'])),
             $_POST['valid_until']?:null,cleanInput($_POST['terms']),isset($_POST['is_active'])?1:0]);
    }
    redirect('/admin/offers.php?msg=Offer+saved');
}

$offers = db()->fetchAll("SELECT * FROM offers ORDER BY created_at DESC");
$edit_o = null;
if (isset($_GET['edit'])) $edit_o = db()->fetchOne("SELECT * FROM offers WHERE id=?",[(int)$_GET['edit']]);
include __DIR__ . '/includes/admin-header.php';
?>
<?php if (isset($_GET['msg'])): ?><div class="admin-alert admin-alert-success" data-auto-dismiss><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars(urldecode($_GET['msg'])); ?></div><?php endif; ?>

<!-- Add/Edit Form -->
<div class="admin-card mb-24">
  <div class="admin-card-header"><div class="admin-card-title"><i class="fas fa-tag"></i> <?php echo $edit_o?'Edit Offer':'Add New Offer / Coupon'; ?></div></div>
  <div class="admin-card-body">
    <form method="POST">
      <input type="hidden" name="oid" value="<?php echo $edit_o['id']??0; ?>">
      <div class="admin-form-row">
        <div class="admin-form-group" style="flex:2"><label>Offer Title *</label><input type="text" name="title" class="admin-form-control" required value="<?php echo htmlspecialchars($edit_o['title']??''); ?>" placeholder="e.g. Summer Sale - 20% Off on Pigeon Nets"></div>
        <div class="admin-form-group"><label>Coupon Code</label><input type="text" name="coupon_code" class="admin-form-control" value="<?php echo htmlspecialchars($edit_o['coupon_code']??''); ?>" placeholder="SAVE20" style="text-transform:uppercase;font-weight:700;letter-spacing:.1em"></div>
      </div>
      <div class="admin-form-group"><label>Description</label><textarea name="description" class="admin-form-control" rows="2"><?php echo htmlspecialchars($edit_o['description']??''); ?></textarea></div>
      <div class="admin-form-row">
        <div class="admin-form-group"><label>Discount Type</label>
          <select name="discount_type" class="admin-form-control">
            <option value="percentage" <?php echo ($edit_o['discount_type']??'')==='percentage'?'selected':''; ?>>Percentage (%)</option>
            <option value="flat" <?php echo ($edit_o['discount_type']??'')==='flat'?'selected':''; ?>>Flat Amount (₹)</option>
          </select>
        </div>
        <div class="admin-form-group"><label>Discount Value *</label><input type="number" name="discount_value" class="admin-form-control" required value="<?php echo $edit_o['discount_value']??''; ?>" step="0.01" placeholder="e.g. 20 for 20%"></div>
        <div class="admin-form-group"><label>Valid Until</label><input type="date" name="valid_until" class="admin-form-control" value="<?php echo $edit_o['valid_until']??''; ?>"></div>
      </div>
      <div class="admin-form-group"><label>Terms & Conditions</label><input type="text" name="terms" class="admin-form-control" value="<?php echo htmlspecialchars($edit_o['terms']??''); ?>" placeholder="e.g. Valid on orders above ₹5000. Only for new customers."></div>
      <div class="admin-form-row" style="align-items:center">
        <label style="display:flex;align-items:center;gap:8px;cursor:pointer"><input type="checkbox" name="is_active" <?php echo !empty($edit_o)?($edit_o['is_active']?'checked':''):'checked'; ?>> Active (show on website)</label>
      </div>
      <div style="margin-top:16px;display:flex;gap:12px">
        <button type="submit" class="btn-admin btn-admin-primary"><i class="fas fa-save"></i> Save Offer</button>
        <?php if ($edit_o): ?><a href="offers.php" class="btn-admin btn-admin-secondary">Cancel</a><?php endif; ?>
      </div>
    </form>
  </div>
</div>

<!-- Offers Table -->
<div class="admin-card">
  <div class="admin-card-header"><div class="admin-card-title"><i class="fas fa-percentage"></i> All Offers & Coupons</div></div>
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead><tr><th>Offer</th><th>Coupon Code</th><th>Discount</th><th>Valid Until</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        <?php foreach ($offers as $o): ?>
        <tr>
          <td><strong><?php echo htmlspecialchars($o['title']); ?></strong><br><span style="font-size:.78rem;color:var(--text-lighter)"><?php echo htmlspecialchars(substr($o['description']?:'',0,60)); ?></span></td>
          <td><?php if ($o['coupon_code']): ?><code style="background:var(--off-white);padding:4px 10px;border-radius:6px;font-weight:700;letter-spacing:.1em;color:var(--primary);border:1px solid var(--border)"><?php echo htmlspecialchars($o['coupon_code']); ?></code><?php else: ?>-<?php endif; ?></td>
          <td><strong style="color:var(--success)"><?php echo $o['discount_type']==='percentage'?$o['discount_value'].'%':'₹'.number_format($o['discount_value'],2); ?></strong></td>
          <td style="font-size:.82rem"><?php echo $o['valid_until']?date('d M Y',strtotime($o['valid_until'])):'No Expiry'; ?></td>
          <td><span class="status-badge <?php echo $o['is_active']?'badge-success':'badge-dark'; ?>"><?php echo $o['is_active']?'Active':'Inactive'; ?></span></td>
          <td>
            <div class="actions">
              <a href="?edit=<?php echo $o['id']; ?>" class="btn-admin btn-admin-info btn-admin-icon"><i class="fas fa-edit"></i></a>
              <a href="?toggle=<?php echo $o['id']; ?>" class="btn-admin btn-admin-secondary btn-admin-icon"><i class="fas fa-toggle-<?php echo $o['is_active']?'on':'off'; ?>"></i></a>
              <a href="?delete=<?php echo $o['id']; ?>" class="btn-admin btn-admin-danger btn-admin-icon" data-confirm="Delete?"><i class="fas fa-trash"></i></a>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($offers)): ?><tr><td colspan="6" style="text-align:center;padding:30px;color:var(--text-light)">No offers yet.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
