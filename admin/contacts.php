<?php
define('NETSDIAL', true);
require_once dirname(__DIR__) . '/config/config.php';
requireAdmin();
$admin_page_title = 'Enquiries / Contacts';

if (isset($_GET['mark_read'])) {
    db()->execute("UPDATE contacts SET is_read=1 WHERE id=?", [(int)$_GET['mark_read']]);
    redirect('/admin/contacts.php?msg=Marked+as+read');
}
if (isset($_GET['delete'])) {
    db()->execute("DELETE FROM contacts WHERE id=?", [(int)$_GET['delete']]);
    redirect('/admin/contacts.php?msg=Enquiry+deleted');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    db()->execute("UPDATE contacts SET status=?, admin_notes=? WHERE id=?", [cleanInput($_POST['status']), cleanInput($_POST['notes']), (int)$_POST['id']]);
    redirect('/admin/contacts.php?msg=Status+updated');
}

$per_page = 20;
$page     = max(1,(int)($_GET['page']??1));
$offset   = ($page-1)*$per_page;
$filter   = cleanInput($_GET['filter']??'all');
$where    = $filter==='unread'?'WHERE is_read=0':($filter==='new'?'WHERE status="new"':'WHERE 1');
$total    = db()->fetchOne("SELECT COUNT(*) as c FROM contacts $where")['c']??0;
$contacts = db()->fetchAll("SELECT * FROM contacts $where ORDER BY created_at DESC LIMIT $per_page OFFSET $offset");
$pages    = ceil($total/$per_page);
$view_c   = null;
if (isset($_GET['id'])) {
    $view_c = db()->fetchOne("SELECT * FROM contacts WHERE id=?",[(int)$_GET['id']]);
    if ($view_c) db()->execute("UPDATE contacts SET is_read=1 WHERE id=?",[(int)$_GET['id']]);
}

include __DIR__ . '/includes/admin-header.php';
?>
<?php if (isset($_GET['msg'])): ?><div class="admin-alert admin-alert-success" data-auto-dismiss><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars(urldecode($_GET['msg'])); ?></div><?php endif; ?>

<div style="display:flex;gap:12px;margin-bottom:24px;flex-wrap:wrap">
  <a href="?filter=all" class="btn-admin <?php echo $filter==='all'?'btn-admin-primary':'btn-admin-secondary'; ?>">All (<?php echo db()->fetchOne("SELECT COUNT(*) as c FROM contacts")['c']; ?>)</a>
  <a href="?filter=unread" class="btn-admin <?php echo $filter==='unread'?'btn-admin-primary':'btn-admin-secondary'; ?>">Unread (<?php echo db()->fetchOne("SELECT COUNT(*) as c FROM contacts WHERE is_read=0")['c']; ?>)</a>
  <a href="?filter=new" class="btn-admin <?php echo $filter==='new'?'btn-admin-primary':'btn-admin-secondary'; ?>">New</a>
</div>

<?php if ($view_c): ?>
<div class="admin-card mb-24">
  <div class="admin-card-header">
    <div class="admin-card-title"><i class="fas fa-envelope-open"></i> Enquiry Details</div>
    <a href="contacts.php" class="btn-admin btn-admin-secondary btn-admin-sm">← Back</a>
  </div>
  <div class="admin-card-body">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px">
      <div>
        <table style="font-size:.9rem;width:100%;border-collapse:collapse">
          <?php foreach (['name'=>'Name','phone'=>'Phone','email'=>'Email','service'=>'Service','location'=>'Location','created_at'=>'Date'] as $k=>$l): ?>
          <tr style="border-bottom:1px solid var(--border)"><td style="padding:10px 0;color:var(--text-light);width:80px"><?php echo $l; ?></td><td style="padding:10px;font-weight:600"><?php echo htmlspecialchars($view_c[$k]??'-'); ?></td></tr>
          <?php endforeach; ?>
        </table>
        <div style="margin-top:16px">
          <strong>Message:</strong>
          <p style="background:var(--off-white);padding:12px;border-radius:var(--radius);margin-top:8px;font-size:.9rem;white-space:pre-wrap"><?php echo htmlspecialchars($view_c['message']??''); ?></p>
        </div>
        <div style="margin-top:16px;display:flex;gap:10px">
          <a href="tel:+91<?php echo $view_c['phone']; ?>" class="btn-admin btn-admin-primary"><i class="fas fa-phone-alt"></i> Call Now</a>
          <a href="https://wa.me/91<?php echo $view_c['phone']; ?>" target="_blank" class="btn-admin btn-admin-success"><i class="fab fa-whatsapp"></i> WhatsApp</a>
          <?php if ($view_c['email']): ?><a href="mailto:<?php echo $view_c['email']; ?>" class="btn-admin btn-admin-info"><i class="fas fa-envelope"></i> Email</a><?php endif; ?>
        </div>
      </div>
      <div>
        <form method="POST">
          <input type="hidden" name="update_status" value="1">
          <input type="hidden" name="id" value="<?php echo $view_c['id']; ?>">
          <div class="admin-form-group"><label>Status</label>
            <select name="status" class="admin-form-control">
              <?php foreach (['new','contacted','converted','closed'] as $st): ?>
              <option value="<?php echo $st; ?>" <?php echo $view_c['status']===$st?'selected':''; ?>><?php echo ucfirst($st); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="admin-form-group"><label>Admin Notes</label><textarea name="notes" class="admin-form-control" rows="5" placeholder="Internal notes..."><?php echo htmlspecialchars($view_c['admin_notes']??''); ?></textarea></div>
          <button type="submit" class="btn-admin btn-admin-primary"><i class="fas fa-save"></i> Update</button>
          <a href="?delete=<?php echo $view_c['id']; ?>" class="btn-admin btn-admin-danger" data-confirm="Delete this enquiry?" style="margin-left:8px"><i class="fas fa-trash"></i></a>
        </form>
        <a href="quotations.php?action=new&client=<?php echo urlencode($view_c['name']); ?>&phone=<?php echo urlencode($view_c['phone']); ?>" class="btn-admin btn-admin-warning mt-16"><i class="fas fa-file-invoice"></i> Create Quotation</a>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<div class="admin-card">
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead><tr><th>Name</th><th>Phone</th><th>Service</th><th>Location</th><th>Status</th><th>Time</th><th>Actions</th></tr></thead>
      <tbody>
        <?php foreach ($contacts as $c): ?>
        <tr style="<?php echo !$c['is_read']?'background:rgba(255,107,0,.03)':''; ?>">
          <td><strong><?php echo htmlspecialchars($c['name']); ?></strong><?php if (!$c['is_read']): ?><span class="status-badge badge-warning" style="margin-left:6px;font-size:.65rem">NEW</span><?php endif; ?></td>
          <td><a href="tel:+91<?php echo htmlspecialchars($c['phone']); ?>" style="color:var(--primary);font-weight:600"><?php echo htmlspecialchars($c['phone']); ?></a></td>
          <td style="font-size:.82rem"><?php echo htmlspecialchars(substr($c['service']?:'General',0,30)); ?></td>
          <td style="font-size:.82rem;color:var(--text-light)"><?php echo htmlspecialchars(substr($c['location']?:'-',0,25)); ?></td>
          <td><span class="status-badge <?php echo ['new'=>'badge-warning','contacted'=>'badge-info','converted'=>'badge-success','closed'=>'badge-dark'][$c['status']]??'badge-dark'; ?>"><?php echo ucfirst($c['status']); ?></span></td>
          <td style="font-size:.78rem;color:var(--text-light)"><?php echo timeAgo($c['created_at']); ?></td>
          <td>
            <div class="actions">
              <a href="?id=<?php echo $c['id']; ?>" class="btn-admin btn-admin-info btn-admin-icon"><i class="fas fa-eye"></i></a>
              <a href="tel:+91<?php echo $c['phone']; ?>" class="btn-admin btn-admin-success btn-admin-icon"><i class="fas fa-phone"></i></a>
              <a href="?delete=<?php echo $c['id']; ?>" class="btn-admin btn-admin-danger btn-admin-icon" data-confirm="Delete?"><i class="fas fa-trash"></i></a>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php if ($pages > 1): ?>
<div class="admin-pagination mt-16">
  <?php for ($p=1;$p<=$pages;$p++): ?><a href="?page=<?php echo $p; ?>&filter=<?php echo $filter; ?>" class="<?php echo $p==$page?'current':''; ?>"><?php echo $p; ?></a><?php endfor; ?>
</div>
<?php endif; ?>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
