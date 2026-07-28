<?php
/**
 * NetsDial Admin - Billing & Quotation System
 * Generates PDF quotations, GST invoices & warranty cards
 */
define('NETSDIAL', true);
require_once dirname(__DIR__) . '/config/config.php';
requireAdmin();
$admin_page_title = 'Quotations & Billing';

$action = $_GET['action'] ?? 'list';
$msg    = '';

// Save quotation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['form_action'] === 'save_quotation') {
    $q_no = generateQutotationNo();
    $items = $_POST['items'] ?? [];
    $subtotal = 0;
    foreach ($items as $item) {
        $subtotal += (float)($item['qty'] ?? 0) * (float)($item['rate'] ?? 0);
    }
    $discount    = (float)($_POST['discount'] ?? 0);
    $gst_pct     = (float)($_POST['gst_pct'] ?? 18);
    $gst_amount  = round(($subtotal - $discount) * $gst_pct / 100, 2);
    $total       = round($subtotal - $discount + $gst_amount, 2);

    $qid = db()->insert(
        "INSERT INTO quotations (quotation_no,client_name,client_email,client_phone,client_address,client_company,client_gstin,bill_type,subtotal,discount,gst_percentage,gst_amount,total,notes,terms,warranty_years) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
        [$q_no, cleanInput($_POST['client_name']), cleanInput($_POST['client_email']),
         cleanInput($_POST['client_phone']), cleanInput($_POST['client_address']),
         cleanInput($_POST['client_company']), cleanInput($_POST['client_gstin']),
         cleanInput($_POST['bill_type']), $subtotal, $discount, $gst_pct, $gst_amount, $total,
         cleanInput($_POST['notes']), cleanInput($_POST['terms']), (int)($_POST['warranty_years']??0)]
    );

    foreach ($items as $item) {
        if (!empty($item['desc'])) {
            $amt = (float)$item['qty'] * (float)$item['rate'];
            db()->insert("INSERT INTO quotation_items (quotation_id,description,quantity,unit,rate,amount) VALUES (?,?,?,?,?,?)",
                [$qid, cleanInput($item['desc']), (float)$item['qty'], cleanInput($item['unit']), (float)$item['rate'], $amt]);
        }
    }
    redirect('/admin/quotations.php?msg=Quotation+' . urlencode($q_no) . '+created&action=view&id=' . $qid);
}

// Delete
if (isset($_GET['delete'])) {
    db()->execute("DELETE FROM quotation_items WHERE quotation_id=?", [(int)$_GET['delete']]);
    db()->execute("DELETE FROM quotations WHERE id=?", [(int)$_GET['delete']]);
    redirect('/admin/quotations.php?msg=Quotation+deleted');
}

$quotations = db()->fetchAll("SELECT * FROM quotations ORDER BY created_at DESC LIMIT 50");

// View single quotation
$view_q = null;
$view_items = [];
if ($action === 'view' && isset($_GET['id'])) {
    $view_q     = db()->fetchOne("SELECT * FROM quotations WHERE id=?", [(int)$_GET['id']]);
    $view_items = db()->fetchAll("SELECT * FROM quotation_items WHERE quotation_id=?", [(int)$_GET['id']]);
}

include __DIR__ . '/includes/admin-header.php';
?>
<?php if (isset($_GET['msg'])): ?>
<div class="admin-alert admin-alert-success" data-auto-dismiss><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars(urldecode($_GET['msg'])); ?></div>
<?php endif; ?>

<div style="display:flex;gap:12px;margin-bottom:24px;flex-wrap:wrap;align-items:center">
  <h2 style="flex:1">Quotations & Invoices</h2>
  <a href="?action=new" class="btn-admin btn-admin-primary"><i class="fas fa-plus"></i> New Quotation</a>
  <a href="?action=warranty" class="btn-admin btn-admin-secondary"><i class="fas fa-certificate"></i> Warranty Card</a>
</div>

<?php if ($action === 'new' || $action === 'edit'): ?>
<!-- New Quotation Form -->
<div class="admin-card">
  <div class="admin-card-header"><div class="admin-card-title"><i class="fas fa-file-invoice"></i> Create New Quotation / Invoice</div></div>
  <div class="admin-card-body">
    <form method="POST">
      <input type="hidden" name="form_action" value="save_quotation">
      <div class="admin-form-row">
        <div class="admin-form-group"><label>Bill Type</label><select name="bill_type" class="admin-form-control"><option>B2C</option><option>B2B</option></select></div>
        <div class="admin-form-group"><label>Client Name *</label><input type="text" name="client_name" class="admin-form-control" required></div>
      </div>
      <div class="admin-form-row">
        <div class="admin-form-group"><label>Client Phone</label><input type="tel" name="client_phone" class="admin-form-control"></div>
        <div class="admin-form-group"><label>Client Email</label><input type="email" name="client_email" class="admin-form-control"></div>
      </div>
      <div class="admin-form-row">
        <div class="admin-form-group"><label>Company Name</label><input type="text" name="client_company" class="admin-form-control"></div>
        <div class="admin-form-group"><label>Client GSTIN</label><input type="text" name="client_gstin" class="admin-form-control" placeholder="For B2B"></div>
      </div>
      <div class="admin-form-group"><label>Client Address</label><textarea name="client_address" class="admin-form-control" rows="2"></textarea></div>

      <hr style="border:1px solid var(--border);margin:24px 0">
      <h4 style="margin-bottom:16px">Line Items</h4>
      <table class="admin-table" id="itemsTable">
        <thead><tr><th>Description *</th><th>Qty *</th><th>Unit</th><th>Rate (₹) *</th><th>Amount</th><th></th></tr></thead>
        <tbody id="itemsBody">
          <?php for ($i=0;$i<5;$i++): ?>
          <tr class="item-row">
            <td><input type="text" name="items[<?php echo $i; ?>][desc]" class="admin-form-control" placeholder="Service/Product description"></td>
            <td><input type="number" name="items[<?php echo $i; ?>][qty]" class="admin-form-control item-qty" placeholder="1" step="0.01" min="0" oninput="calcRow(this)"></td>
            <td><select name="items[<?php echo $i; ?>][unit]" class="admin-form-control"><option>Sqft</option><option>Nos</option><option>Meter</option><option>Lump Sum</option><option>Kg</option></select></td>
            <td><input type="number" name="items[<?php echo $i; ?>][rate]" class="admin-form-control item-rate" placeholder="0.00" step="0.01" min="0" oninput="calcRow(this)"></td>
            <td><input type="text" class="admin-form-control item-amount" readonly style="background:var(--off-white)" value="0.00"></td>
            <td><button type="button" onclick="this.closest('tr').remove();calcTotal()" class="btn-admin btn-admin-danger btn-admin-icon"><i class="fas fa-times"></i></button></td>
          </tr>
          <?php endfor; ?>
        </tbody>
      </table>
      <button type="button" onclick="addRow()" class="btn-admin btn-admin-secondary mt-16"><i class="fas fa-plus"></i> Add Row</button>

      <hr style="border:1px solid var(--border);margin:24px 0">
      <div class="admin-form-row-3">
        <div class="admin-form-group"><label>Discount (₹)</label><input type="number" name="discount" id="discount" class="admin-form-control" value="0" oninput="calcTotal()" step="0.01" min="0"></div>
        <div class="admin-form-group">
          <label>GST %</label>
          <select name="gst_pct" id="gst_pct" class="admin-form-control" onchange="calcTotal()">
            <option value="0">0% (Exempt)</option>
            <option value="5">5% GST</option>
            <option value="12">12% GST</option>
            <option value="18" selected>18% GST</option>
            <option value="28">28% GST</option>
          </select>
        </div>
        <div class="admin-form-group"><label>Warranty (Years)</label><select name="warranty_years" class="admin-form-control"><option value="0">No Warranty</option><option value="1">1 Year</option><option value="2">2 Years</option><option value="3">3 Years</option><option value="5">5 Years</option></select></div>
      </div>

      <div style="background:var(--off-white);border-radius:var(--radius-lg);padding:20px;margin:20px 0;border:1px solid var(--border)">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;max-width:400px;margin-left:auto">
          <span>Subtotal:</span><strong id="disp-subtotal" style="text-align:right">₹0.00</strong>
          <span>Discount:</span><strong id="disp-discount" style="text-align:right;color:var(--error)">-₹0.00</strong>
          <span>GST (<span id="disp-gst-pct">18</span>%):</span><strong id="disp-gst" style="text-align:right">₹0.00</strong>
          <span style="font-size:1.1rem;font-weight:700">TOTAL:</span><strong id="disp-total" style="text-align:right;font-size:1.2rem;color:var(--primary)">₹0.00</strong>
        </div>
      </div>

      <div class="admin-form-row">
        <div class="admin-form-group"><label>Notes</label><textarea name="notes" class="admin-form-control" rows="3" placeholder="Additional notes for the client..."></textarea></div>
        <div class="admin-form-group"><label>Terms & Conditions</label><textarea name="terms" class="admin-form-control" rows="3" placeholder="Terms and conditions...">Payment: 50% advance, 50% before delivery. Material warranty as per manufacturer terms. Installation not included unless specified.</textarea></div>
      </div>

      <button type="submit" class="btn-admin btn-admin-primary btn-admin-lg"><i class="fas fa-file-invoice"></i> Create Quotation</button>
      <a href="quotations.php" class="btn-admin btn-admin-secondary btn-admin-lg" style="margin-left:12px">Cancel</a>
    </form>
  </div>
</div>

<?php elseif ($action === 'view' && $view_q): ?>
<!-- View & Print Quotation -->
<div style="display:flex;gap:12px;margin-bottom:20px">
  <button onclick="window.print()" class="btn-admin btn-admin-primary"><i class="fas fa-print"></i> Print / Save PDF</button>
  <a href="?action=list" class="btn-admin btn-admin-secondary"><i class="fas fa-arrow-left"></i> Back to List</a>
  <a href="?delete=<?php echo $view_q['id']; ?>" class="btn-admin btn-admin-danger" data-confirm="Delete this quotation?"><i class="fas fa-trash"></i> Delete</a>
</div>

<div id="printArea" style="background:#fff;border:1px solid var(--border);border-radius:var(--radius-lg);padding:40px;max-width:900px;margin:0 auto">
  <!-- Header -->
  <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:32px;padding-bottom:24px;border-bottom:3px solid #FF6B00">
    <div>
      <img src="/assets/images/logo.png" alt="NetsDial" style="height:55px;object-fit:contain;margin-bottom:10px">
      <div style="font-size:.85rem;color:#666;line-height:1.8">
        <strong>GCM Enterprises</strong><br>
        <?php echo getSetting('site_address',''); ?><br>
        Phone: +91 <?php echo getSetting('site_phone',''); ?><br>
        Email: <?php echo getSetting('site_email',''); ?><br>
        GSTIN: <?php echo getSetting('company_gstin','__________________'); ?>
      </div>
    </div>
    <div style="text-align:right">
      <h2 style="color:#FF6B00;font-size:2rem;margin:0"><?php echo $view_q['bill_type']; ?> <?php echo $view_q['bill_type']==='B2B'?'TAX INVOICE':'QUOTATION'; ?></h2>
      <div style="background:#FF6B00;color:#fff;padding:8px 16px;border-radius:8px;display:inline-block;margin:8px 0;font-weight:700"><?php echo $view_q['quotation_no']; ?></div>
      <div style="font-size:.85rem;color:#666">Date: <?php echo date('d M Y',strtotime($view_q['created_at'])); ?></div>
    </div>
  </div>

  <!-- Bill To -->
  <div style="margin-bottom:28px">
    <h4 style="color:#FF6B00;margin-bottom:10px;text-transform:uppercase;font-size:.8rem;letter-spacing:.1em">Bill To:</h4>
    <table style="font-size:.9rem;border-collapse:collapse;width:60%">
      <tr><td style="padding:3px 12px 3px 0;color:#666;width:100px">Name</td><td><strong><?php echo htmlspecialchars($view_q['client_name']); ?></strong></td></tr>
      <?php if ($view_q['client_company']): ?><tr><td style="padding:3px 12px 3px 0;color:#666">Company</td><td><?php echo htmlspecialchars($view_q['client_company']); ?></td></tr><?php endif; ?>
      <?php if ($view_q['client_gstin']): ?><tr><td style="padding:3px 12px 3px 0;color:#666">GSTIN</td><td><?php echo htmlspecialchars($view_q['client_gstin']); ?></td></tr><?php endif; ?>
      <?php if ($view_q['client_phone']): ?><tr><td style="padding:3px 12px 3px 0;color:#666">Phone</td><td><?php echo htmlspecialchars($view_q['client_phone']); ?></td></tr><?php endif; ?>
      <?php if ($view_q['client_address']): ?><tr><td style="padding:3px 12px 3px 0;color:#666;vertical-align:top">Address</td><td><?php echo nl2br(htmlspecialchars($view_q['client_address'])); ?></td></tr><?php endif; ?>
    </table>
  </div>

  <!-- Items Table -->
  <table style="width:100%;border-collapse:collapse;font-size:.9rem;margin-bottom:24px">
    <thead>
      <tr style="background:#FF6B00;color:#fff">
        <th style="padding:10px 12px;text-align:left">#</th>
        <th style="padding:10px 12px;text-align:left">Description</th>
        <th style="padding:10px 12px;text-align:center">Qty</th>
        <th style="padding:10px 12px;text-align:center">Unit</th>
        <th style="padding:10px 12px;text-align:right">Rate (₹)</th>
        <th style="padding:10px 12px;text-align:right">Amount (₹)</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($view_items as $i => $item): ?>
      <tr style="border-bottom:1px solid #f0f0f0;<?php echo $i%2===0?'background:#fafafa':''; ?>">
        <td style="padding:10px 12px;color:#999"><?php echo $i+1; ?></td>
        <td style="padding:10px 12px"><?php echo htmlspecialchars($item['description']); ?></td>
        <td style="padding:10px 12px;text-align:center"><?php echo $item['quantity']; ?></td>
        <td style="padding:10px 12px;text-align:center"><?php echo htmlspecialchars($item['unit']); ?></td>
        <td style="padding:10px 12px;text-align:right">₹<?php echo number_format($item['rate'],2); ?></td>
        <td style="padding:10px 12px;text-align:right;font-weight:600">₹<?php echo number_format($item['amount'],2); ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <?php if ($view_q['discount'] > 0): ?>
      <tr><td colspan="5" style="text-align:right;padding:8px 12px;color:#666">Discount:</td><td style="text-align:right;padding:8px 12px;color:#EF4444">-₹<?php echo number_format($view_q['discount'],2); ?></td></tr>
      <?php endif; ?>
      <tr><td colspan="5" style="text-align:right;padding:8px 12px;color:#666">GST (<?php echo $view_q['gst_percentage']; ?>%):</td><td style="text-align:right;padding:8px 12px">₹<?php echo number_format($view_q['gst_amount'],2); ?></td></tr>
      <tr style="background:#FF6B00;color:#fff">
        <td colspan="5" style="padding:12px;text-align:right;font-weight:700;font-size:1rem">TOTAL:</td>
        <td style="padding:12px;text-align:right;font-weight:900;font-size:1.1rem">₹<?php echo number_format($view_q['total'],2); ?></td>
      </tr>
    </tfoot>
  </table>

  <?php if ($view_q['warranty_years'] > 0): ?>
  <div style="background:#FFF7ED;border:2px solid #FF6B00;border-radius:12px;padding:20px;margin:20px 0">
    <h4 style="color:#FF6B00;margin-bottom:8px"><i class="fas fa-certificate"></i> WARRANTY: <?php echo $view_q['warranty_years']; ?> Year(s)</h4>
    <p style="font-size:.88rem;color:#666">This Russea™ product carries a <?php echo $view_q['warranty_years']; ?>-year manufacturer warranty against material defects. Contact NetsDial for warranty claims. Warranty void if misused or tampered.</p>
    <p style="font-size:.85rem;margin-top:8px;color:#999">Warranty Valid Till: <?php echo date('d M Y', strtotime('+' . $view_q['warranty_years'] . ' years', strtotime($view_q['created_at']))); ?></p>
  </div>
  <?php endif; ?>

  <?php if ($view_q['notes']): ?><div style="margin:16px 0;padding:14px;background:#f9f9f9;border-radius:8px;font-size:.88rem"><strong>Notes:</strong> <?php echo nl2br(htmlspecialchars($view_q['notes'])); ?></div><?php endif; ?>
  <?php if ($view_q['terms']): ?><div style="margin:16px 0;font-size:.82rem;color:#666"><strong>Terms & Conditions:</strong><br><?php echo nl2br(htmlspecialchars($view_q['terms'])); ?></div><?php endif; ?>

  <div style="text-align:center;margin-top:32px;padding-top:20px;border-top:1px solid #eee;font-size:.8rem;color:#999">
    <strong>NetsDial | GCM Enterprises</strong> | <?php echo getSetting('site_address',''); ?> | +91 <?php echo getSetting('site_phone',''); ?>
  </div>
</div>

<?php else: ?>
<!-- Quotations List -->
<div class="admin-card">
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead><tr><th>Quotation No</th><th>Client</th><th>Phone</th><th>Bill Type</th><th>Total</th><th>Date</th><th>Actions</th></tr></thead>
      <tbody>
        <?php foreach ($quotations as $q): ?>
        <tr>
          <td><strong style="color:var(--primary)"><?php echo htmlspecialchars($q['quotation_no']); ?></strong></td>
          <td><?php echo htmlspecialchars($q['client_name']); ?><br><span style="font-size:.78rem;color:var(--text-light)"><?php echo htmlspecialchars($q['client_company']?:''); ?></span></td>
          <td style="font-size:.88rem"><?php echo htmlspecialchars($q['client_phone']?:''); ?></td>
          <td><span class="status-badge <?php echo $q['bill_type']==='B2B'?'badge-info':'badge-success'; ?>"><?php echo $q['bill_type']; ?></span></td>
          <td><strong>₹<?php echo number_format($q['total'],2); ?></strong></td>
          <td style="font-size:.82rem"><?php echo date('d M Y',strtotime($q['created_at'])); ?></td>
          <td>
            <a href="?action=view&id=<?php echo $q['id']; ?>" class="btn-admin btn-admin-primary btn-admin-sm"><i class="fas fa-eye"></i> View/Print</a>
            <a href="?delete=<?php echo $q['id']; ?>" class="btn-admin btn-admin-danger btn-admin-icon" data-confirm="Delete quotation?"><i class="fas fa-trash"></i></a>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($quotations)): ?><tr><td colspan="7" style="text-align:center;padding:30px;color:var(--text-light)">No quotations yet. <a href="?action=new">Create one</a></td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php endif; ?>

<script>
let rowIdx = 5;

function calcRow(el) {
  const row = el.closest('tr');
  const qty  = parseFloat(row.querySelector('.item-qty')?.value) || 0;
  const rate = parseFloat(row.querySelector('.item-rate')?.value) || 0;
  const amtEl = row.querySelector('.item-amount');
  if (amtEl) amtEl.value = (qty * rate).toFixed(2);
  calcTotal();
}

function calcTotal() {
  let subtotal = 0;
  document.querySelectorAll('.item-amount').forEach(el => subtotal += parseFloat(el.value) || 0);
  const discount   = parseFloat(document.getElementById('discount')?.value) || 0;
  const gst_pct    = parseFloat(document.getElementById('gst_pct')?.value) || 0;
  const gst_amount = ((subtotal - discount) * gst_pct / 100);
  const total      = subtotal - discount + gst_amount;

  const f = n => '₹' + n.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g,',');
  document.getElementById('disp-subtotal') && (document.getElementById('disp-subtotal').textContent = f(subtotal));
  document.getElementById('disp-discount') && (document.getElementById('disp-discount').textContent = '-'+f(discount));
  document.getElementById('disp-gst')      && (document.getElementById('disp-gst').textContent = f(gst_amount));
  document.getElementById('disp-total')    && (document.getElementById('disp-total').textContent = f(total));
  document.getElementById('disp-gst-pct')  && (document.getElementById('disp-gst-pct').textContent = gst_pct);
}

function addRow() {
  const tbody = document.getElementById('itemsBody');
  const i = rowIdx++;
  const tr = document.createElement('tr');
  tr.className = 'item-row';
  tr.innerHTML = `
    <td><input type="text" name="items[${i}][desc]" class="admin-form-control" placeholder="Description"></td>
    <td><input type="number" name="items[${i}][qty]" class="admin-form-control item-qty" placeholder="1" step="0.01" min="0" oninput="calcRow(this)"></td>
    <td><select name="items[${i}][unit]" class="admin-form-control"><option>Sqft</option><option>Nos</option><option>Meter</option><option>Lump Sum</option><option>Kg</option></select></td>
    <td><input type="number" name="items[${i}][rate]" class="admin-form-control item-rate" placeholder="0.00" step="0.01" min="0" oninput="calcRow(this)"></td>
    <td><input type="text" class="admin-form-control item-amount" readonly style="background:var(--off-white)" value="0.00"></td>
    <td><button type="button" onclick="this.closest('tr').remove();calcTotal()" class="btn-admin btn-admin-danger btn-admin-icon"><i class="fas fa-times"></i></button></td>
  `;
  tbody.appendChild(tr);
}

// Print styles
const ps = document.createElement('style');
ps.textContent = '@media print { .admin-sidebar,.admin-topbar,button,.btn-admin,a.btn-admin { display:none!important } .admin-main{margin-left:0!important} #printArea{box-shadow:none!important;border:none!important} }';
document.head.appendChild(ps);
</script>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
