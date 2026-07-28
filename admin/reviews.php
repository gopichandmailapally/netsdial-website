<?php
define('NETSDIAL', true);
require_once dirname(__DIR__) . '/config/config.php';
requireAdmin();
$admin_page_title = 'Manage Reviews';

// Actions
if (isset($_GET['approve'])) {
    db()->execute("UPDATE reviews SET is_approved=1 WHERE id=?", [(int)$_GET['approve']]);
    redirect('/admin/reviews.php?msg=Review+approved');
}
if (isset($_GET['unapprove'])) {
    db()->execute("UPDATE reviews SET is_approved=0 WHERE id=?", [(int)$_GET['unapprove']]);
    redirect('/admin/reviews.php?msg=Review+unapproved');
}
if (isset($_GET['feature'])) {
    db()->execute("UPDATE reviews SET is_featured=1 WHERE id=?", [(int)$_GET['feature']]);
    redirect('/admin/reviews.php?msg=Review+featured');
}
if (isset($_GET['unfeature'])) {
    db()->execute("UPDATE reviews SET is_featured=0 WHERE id=?", [(int)$_GET['unfeature']]);
    redirect('/admin/reviews.php?msg=Review+unfeatured');
}
if (isset($_GET['delete'])) {
    db()->execute("DELETE FROM reviews WHERE id=?", [(int)$_GET['delete']]);
    redirect('/admin/reviews.php?msg=Review+deleted');
}
// Reply
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply_id'])) {
    db()->execute("UPDATE reviews SET admin_reply=? WHERE id=?", [cleanInput($_POST['reply']), (int)$_POST['reply_id']]);
    redirect('/admin/reviews.php?msg=Reply+saved');
}
// Add review
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_review'])) {
    db()->insert("INSERT INTO reviews (customer_name,customer_email,customer_phone,customer_location,service_used,rating,review_text,is_approved,is_featured) VALUES (?,?,?,?,?,?,?,?,?)",
        [cleanInput($_POST['name']),cleanInput($_POST['email']),cleanInput($_POST['phone']),cleanInput($_POST['location']),cleanInput($_POST['service']),(int)$_POST['rating'],cleanInput($_POST['review']),(int)$_POST['approved'],(int)$_POST['featured']]);
    redirect('/admin/reviews.php?msg=Review+added');
}

$filter    = $_GET['filter'] ?? 'all';
$where     = $filter === 'pending' ? 'WHERE is_approved=0' : ($filter === 'featured' ? 'WHERE is_featured=1' : 'WHERE 1');
$per_page  = 20;
$page      = max(1,(int)($_GET['page']??1));
$offset    = ($page-1)*$per_page;
$total     = db()->fetchOne("SELECT COUNT(*) as c FROM reviews $where")['c'] ?? 0;
$reviews   = db()->fetchAll("SELECT * FROM reviews $where ORDER BY created_at DESC LIMIT $per_page OFFSET $offset");
$pages     = ceil($total/$per_page);

include __DIR__ . '/includes/admin-header.php';
?>

<?php if (isset($_GET['msg'])): ?>
<div class="admin-alert admin-alert-success" data-auto-dismiss><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars(urldecode($_GET['msg'])); ?></div>
<?php endif; ?>

<div style="display:flex;gap:12px;align-items:center;margin-bottom:24px;flex-wrap:wrap">
  <a href="?filter=all" class="btn-admin <?php echo $filter==='all'?'btn-admin-primary':'btn-admin-secondary'; ?>">All (<?php echo db()->fetchOne("SELECT COUNT(*) as c FROM reviews")['c']; ?>)</a>
  <a href="?filter=pending" class="btn-admin <?php echo $filter==='pending'?'btn-admin-primary':'btn-admin-secondary'; ?>">Pending (<?php echo db()->fetchOne("SELECT COUNT(*) as c FROM reviews WHERE is_approved=0")['c']; ?>)</a>
  <a href="?filter=featured" class="btn-admin <?php echo $filter==='featured'?'btn-admin-primary':'btn-admin-secondary'; ?>">Featured</a>
  <button onclick="document.getElementById('addReviewModal').classList.add('open')" class="btn-admin btn-admin-primary" style="margin-left:auto"><i class="fas fa-plus"></i> Add Review</button>
</div>

<div class="admin-card">
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr><th><input type="checkbox" class="select-all"></th><th>Customer</th><th>Rating</th><th>Review</th><th>Service</th><th>Location</th><th>Date</th><th>Status</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php foreach ($reviews as $r): ?>
        <tr>
          <td><input type="checkbox" class="row-select" value="<?php echo $r['id']; ?>"></td>
          <td>
            <div style="font-weight:700;font-size:.9rem"><?php echo htmlspecialchars($r['customer_name']); ?></div>
            <div style="font-size:.75rem;color:var(--text-light)"><?php echo htmlspecialchars($r['customer_email'] ?: ''); ?></div>
            <div style="font-size:.75rem;color:var(--primary)"><?php echo htmlspecialchars($r['customer_phone'] ?: ''); ?></div>
          </td>
          <td><div class="stars-display"><?php echo str_repeat('★',$r['rating']); ?></div></td>
          <td>
            <p style="font-size:.85rem;max-width:280px"><?php echo htmlspecialchars(substr($r['review_text'],0,150)); ?>...</p>
            <?php if ($r['admin_reply']): ?>
            <div style="background:rgba(255,107,0,.05);border-left:2px solid var(--primary);padding:4px 8px;margin-top:4px;font-size:.75rem;color:var(--text-medium)"><i class="fas fa-reply" style="color:var(--primary)"></i> <?php echo htmlspecialchars(substr($r['admin_reply'],0,80)); ?></div>
            <?php endif; ?>
          </td>
          <td style="font-size:.82rem"><?php echo htmlspecialchars($r['service_used']?:'N/A'); ?></td>
          <td style="font-size:.82rem;color:var(--text-light)"><?php echo htmlspecialchars($r['customer_location']?:'N/A'); ?></td>
          <td style="font-size:.78rem;color:var(--text-light)"><?php echo date('d M Y',strtotime($r['created_at'])); ?></td>
          <td>
            <?php if ($r['is_approved']): ?><span class="status-badge badge-success">Approved</span><?php else: ?><span class="status-badge badge-warning">Pending</span><?php endif; ?>
            <?php if ($r['is_featured']): ?><span class="status-badge badge-primary">Featured</span><?php endif; ?>
          </td>
          <td>
            <div class="actions">
              <?php if (!$r['is_approved']): ?>
              <a href="?approve=<?php echo $r['id']; ?>" class="btn-admin btn-admin-success btn-admin-icon" title="Approve"><i class="fas fa-check"></i></a>
              <?php else: ?>
              <a href="?unapprove=<?php echo $r['id']; ?>" class="btn-admin btn-admin-warning btn-admin-icon" title="Unapprove"><i class="fas fa-times"></i></a>
              <?php endif; ?>
              <?php if (!$r['is_featured']): ?>
              <a href="?feature=<?php echo $r['id']; ?>" class="btn-admin btn-admin-info btn-admin-icon" title="Feature"><i class="fas fa-star"></i></a>
              <?php else: ?>
              <a href="?unfeature=<?php echo $r['id']; ?>" class="btn-admin btn-admin-secondary btn-admin-icon" title="Unfeature"><i class="fas fa-star-half-alt"></i></a>
              <?php endif; ?>
              <button onclick="openReply(<?php echo $r['id']; ?>, '<?php echo htmlspecialchars(addslashes($r['admin_reply']??''),'ENT_QUOTES'); ?>')" class="btn-admin btn-admin-secondary btn-admin-icon" title="Reply"><i class="fas fa-reply"></i></button>
              <a href="?delete=<?php echo $r['id']; ?>" class="btn-admin btn-admin-danger btn-admin-icon" title="Delete" data-confirm="Delete this review permanently?"><i class="fas fa-trash"></i></a>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Pagination -->
<?php if ($pages > 1): ?>
<div class="admin-pagination mt-16">
  <?php for ($p=1;$p<=$pages;$p++): ?><a href="?page=<?php echo $p; ?>&filter=<?php echo $filter; ?>" class="<?php echo $p==$page?'current':''; ?>"><?php echo $p; ?></a><?php endfor; ?>
</div>
<?php endif; ?>

<!-- Reply Modal -->
<div class="admin-modal" id="replyModal">
  <div class="admin-modal-box">
    <button class="admin-modal-close" onclick="document.getElementById('replyModal').classList.remove('open')"><i class="fas fa-times"></i></button>
    <h3 style="margin-bottom:20px"><i class="fas fa-reply" style="color:var(--primary)"></i> Admin Reply</h3>
    <form method="POST">
      <input type="hidden" name="reply_id" id="replyId">
      <div class="admin-form-group">
        <label>Your Reply</label>
        <textarea name="reply" id="replyText" class="admin-form-control" rows="4" placeholder="Type your reply to the customer..."></textarea>
      </div>
      <button type="submit" class="btn-admin btn-admin-primary"><i class="fas fa-paper-plane"></i> Save Reply</button>
    </form>
  </div>
</div>

<!-- Add Review Modal -->
<div class="admin-modal" id="addReviewModal">
  <div class="admin-modal-box">
    <button class="admin-modal-close" onclick="document.getElementById('addReviewModal').classList.remove('open')"><i class="fas fa-times"></i></button>
    <h3 style="margin-bottom:20px"><i class="fas fa-plus" style="color:var(--primary)"></i> Add Review</h3>
    <form method="POST">
      <input type="hidden" name="add_review" value="1">
      <div class="admin-form-row">
        <div class="admin-form-group"><label>Customer Name *</label><input type="text" name="name" class="admin-form-control" required></div>
        <div class="admin-form-group"><label>Phone</label><input type="tel" name="phone" class="admin-form-control"></div>
      </div>
      <div class="admin-form-row">
        <div class="admin-form-group"><label>Email</label><input type="email" name="email" class="admin-form-control"></div>
        <div class="admin-form-group"><label>Location</label><input type="text" name="location" class="admin-form-control" placeholder="Area, City"></div>
      </div>
      <div class="admin-form-row">
        <div class="admin-form-group"><label>Service Used</label><input type="text" name="service" class="admin-form-control" placeholder="e.g. Pigeon Netting"></div>
        <div class="admin-form-group"><label>Rating (1-5)</label><select name="rating" class="admin-form-control"><option value="5" selected>5 ★★★★★</option><option value="4">4 ★★★★</option><option value="3">3 ★★★</option><option value="2">2 ★★</option><option value="1">1 ★</option></select></div>
      </div>
      <div class="admin-form-group"><label>Review Text *</label><textarea name="review" class="admin-form-control" rows="4" required></textarea></div>
      <div class="admin-form-row">
        <div class="admin-form-group"><label>Status</label><select name="approved" class="admin-form-control"><option value="1">Approved</option><option value="0">Pending</option></select></div>
        <div class="admin-form-group"><label>Featured</label><select name="featured" class="admin-form-control"><option value="0">No</option><option value="1">Yes</option></select></div>
      </div>
      <button type="submit" class="btn-admin btn-admin-primary w-100"><i class="fas fa-plus"></i> Add Review</button>
    </form>
  </div>
</div>

<script>
function openReply(id, existing) {
  document.getElementById('replyId').value = id;
  document.getElementById('replyText').value = existing;
  document.getElementById('replyModal').classList.add('open');
}
</script>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
