<?php
define('NETSDIAL', true);
require_once dirname(__DIR__) . '/config/config.php';
requireAdmin();
$admin_page_title = 'Estimation Rates';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rates = $_POST['rates'] ?? [];
    foreach ($rates as $id => $rate) {
        db()->execute("UPDATE estimation_rates SET min_rate=?, max_rate=? WHERE id=?",
            [(float)($rate['min']??0),(float)($rate['max']??0),(int)$id]);
    }
    // Also save any new/general settings
    $keys = $_POST['keys'] ?? [];
    $vals = $_POST['vals'] ?? [];
    foreach ($keys as $i => $key) {
        $val = $vals[$i] ?? '';
        db()->execute("INSERT INTO settings (setting_key,setting_value,setting_group) VALUES (?,?,'estimation') ON DUPLICATE KEY UPDATE setting_value=?", [$key,$val,$val]);
    }
    redirect('/admin/estimation-rates.php?msg=Rates+updated');
}

$all_rates = db()->fetchAll("SELECT * FROM estimation_rates ORDER BY service_type, min_sqft, FIELD(thickness,'1.5mm','2mm','2.5mm','3mm'), FIELD(square_gap,'30mm','40mm','45mm','50mm'), FIELD(line_gap,'2inch','3inch')");
$grouped   = [];
foreach ($all_rates as $r) $grouped[$r['service_type']][] = $r;

include __DIR__ . '/includes/admin-header.php';
?>
<?php if (isset($_GET['msg'])): ?><div class="admin-alert admin-alert-success" data-auto-dismiss><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars(urldecode($_GET['msg'])); ?></div><?php endif; ?>

<div class="admin-card">
  <div class="admin-card-header"><div class="admin-card-title"><i class="fas fa-rupee-sign"></i> Estimation Rates Manager</div><div style="font-size:.82rem;color:var(--text-light)">Update all price ranges shown to customers</div></div>
  <div class="admin-card-body">
    <form method="POST">
      <?php foreach ($grouped as $service => $rates): ?>
      <div style="margin-bottom:32px">
        <h4 style="color:var(--primary);font-size:1rem;text-transform:uppercase;letter-spacing:.06em;margin-bottom:16px;padding-bottom:10px;border-bottom:2px solid var(--primary-light)">
          <i class="fas fa-wrench"></i> <?php echo htmlspecialchars($service); ?>
        </h4>
        <div style="overflow-x:auto">
          <table class="admin-table" style="min-width:600px">
            <thead>
              <tr>
                <th>Category / Range</th>
                <th>Thickness</th>
                <th>Gap</th>
                <th>Min Rate (₹/SFT)</th>
                <th>Max Rate (₹/SFT)</th>
                <th>Preview</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rates as $r): ?>
              <tr>
                <td>
                  <div style="font-size:.82rem;font-weight:600"><?php echo number_format($r['min_sqft']); ?> - <?php echo $r['max_sqft']?number_format($r['max_sqft']):'Above'; ?> SFT</div>
                  <div style="font-size:.72rem;color:var(--text-lighter)"><?php echo htmlspecialchars($r['unit']?:'per SFT'); ?></div>
                </td>
                <td style="font-size:.85rem"><?php echo htmlspecialchars($r['thickness']?:'-'); ?></td>
                <td style="font-size:.85rem"><?php echo htmlspecialchars($r['square_gap']?:($r['line_gap']?:'—')); ?></td>
                <td><input type="number" name="rates[<?php echo $r['id']; ?>][min]" class="admin-form-control" style="width:90px" value="<?php echo $r['min_rate']; ?>" step="0.5" min="0"></td>
                <td><input type="number" name="rates[<?php echo $r['id']; ?>][max]" class="admin-form-control" style="width:90px" value="<?php echo $r['max_rate']; ?>" step="0.5" min="0"></td>
                <td style="font-size:.82rem;color:var(--primary);font-weight:700">₹<?php echo $r['min_rate']; ?> – ₹<?php echo $r['max_rate']; ?>/SFT</td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <?php endforeach; ?>

      <div style="position:sticky;bottom:0;background:#fff;padding:16px 0;border-top:1px solid var(--border);z-index:10">
        <button type="submit" class="btn-admin btn-admin-primary btn-admin-lg"><i class="fas fa-save"></i> Save All Rates</button>
        <span style="margin-left:16px;font-size:.85rem;color:var(--text-light)">All changes go live immediately on the website</span>
      </div>
    </form>
  </div>
</div>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
