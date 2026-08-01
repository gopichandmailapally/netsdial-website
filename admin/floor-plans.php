<?php
/**
 * NetsDial Admin – Floor Plan Builder
 * Create top-down plan view + front/side elevation for any sports ground
 */
define('NETSDIAL', true);
require_once dirname(__DIR__) . '/config/config.php';
requireAdmin();

$admin_page_title = 'Floor Plan Builder';

// CRUD actions
$action  = $_GET['action'] ?? 'list';
$plan_id = (int)($_GET['id'] ?? 0);
$msg     = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'title'       => cleanInput($_POST['title'] ?? ''),
        'ground_type' => cleanInput($_POST['ground_type'] ?? 'custom'),
        'length_ft'   => (float)($_POST['length_ft'] ?? 0),
        'width_ft'    => (float)($_POST['width_ft'] ?? 0),
        'height_ft'   => (float)($_POST['height_ft'] ?? 0),
        'sqft'        => (float)($_POST['length_ft'] ?? 0) * (float)($_POST['width_ft'] ?? 0),
        'pitch_zones' => $_POST['pitch_zones'] ?? '[]',
        'elements'    => $_POST['elements'] ?? '[]',
        'notes'       => cleanInput($_POST['notes'] ?? ''),
        'client_name' => cleanInput($_POST['client_name'] ?? ''),
        'client_phone'=> cleanInput($_POST['client_phone'] ?? ''),
        'location'    => cleanInput($_POST['location'] ?? ''),
        'is_published'=> isset($_POST['is_published']) ? 1 : 0,
        'is_template' => isset($_POST['is_template']) ? 1 : 0,
        'sort_order'  => (int)($_POST['sort_order'] ?? 0),
        'created_by'  => $_SESSION['admin_name'] ?? 'Admin',
    ];

    if ($plan_id && $_POST['_action'] === 'update') {
        db()->query(
            "UPDATE floor_plans SET title=?,ground_type=?,length_ft=?,width_ft=?,height_ft=?,sqft=?,
             pitch_zones=?,elements=?,notes=?,client_name=?,client_phone=?,location=?,
             is_published=?,is_template=?,sort_order=? WHERE id=?",
            [$data['title'],$data['ground_type'],$data['length_ft'],$data['width_ft'],$data['height_ft'],
             $data['sqft'],$data['pitch_zones'],$data['elements'],$data['notes'],
             $data['client_name'],$data['client_phone'],$data['location'],
             $data['is_published'],$data['is_template'],$data['sort_order'],$plan_id]
        );
        $msg = 'Plan updated successfully!';
        $action = 'edit';
    } else {
        $new_id = db()->insert(
            "INSERT INTO floor_plans (title,ground_type,length_ft,width_ft,height_ft,sqft,pitch_zones,elements,notes,client_name,client_phone,location,is_published,is_template,sort_order,created_by)
             VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
            [$data['title'],$data['ground_type'],$data['length_ft'],$data['width_ft'],$data['height_ft'],
             $data['sqft'],$data['pitch_zones'],$data['elements'],$data['notes'],
             $data['client_name'],$data['client_phone'],$data['location'],
             $data['is_published'],$data['is_template'],$data['sort_order'],$data['created_by']]
        );
        header('Location: /admin/floor-plans.php?action=edit&id=' . $new_id . '&msg=Plan+created+successfully');
        exit;
    }
}

if ($action === 'delete' && $plan_id) {
    db()->query("DELETE FROM floor_plans WHERE id=?", [$plan_id]);
    header('Location: /admin/floor-plans.php?msg=Plan+deleted');
    exit;
}

if ($action === 'toggle' && $plan_id) {
    db()->query("UPDATE floor_plans SET is_published = 1-is_published WHERE id=?", [$plan_id]);
    header('Location: /admin/floor-plans.php');
    exit;
}

// Load plan for editing
$plan = null;
if ($plan_id) {
    $plan = db()->fetchOne("SELECT * FROM floor_plans WHERE id=?", [$plan_id]);
}

// Load all plans for list
$plans     = db()->fetchAll("SELECT * FROM floor_plans ORDER BY is_template DESC, sort_order, created_at DESC");
$templates = db()->fetchAll("SELECT * FROM floor_plans WHERE is_template=1 ORDER BY sort_order");

$msg = $msg ?: ($_GET['msg'] ?? '');

include __DIR__ . '/includes/admin-header.php';
?>

<?php if ($msg): ?>
<div class="admin-alert admin-alert-success" data-auto-dismiss>
  <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($msg); ?>
</div>
<?php endif; ?>

<style>
/* ── Floor Plan Builder Styles ─────────────────────────────── */
.fpb-layout { display:grid; grid-template-columns:320px 1fr; gap:0; min-height:calc(100vh - 120px); }
.fpb-panel  { background:#f8fafc; border-right:1px solid #e2e8f0; padding:20px; overflow-y:auto; max-height:calc(100vh - 120px); }
.fpb-canvas-area { padding:20px; background:#fff; overflow:auto; }
.fpb-section { margin-bottom:20px; }
.fpb-section h5 { font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#64748b; margin-bottom:10px; padding-bottom:6px; border-bottom:1px solid #e2e8f0; }
.fpb-input { width:100%; padding:8px 12px; border:1px solid #e2e8f0; border-radius:8px; font-size:.85rem; background:#fff; color:#1e293b; transition:border .2s; outline:none; }
.fpb-input:focus { border-color:#FF6B00; box-shadow:0 0 0 3px rgba(255,107,0,.12); }
.fpb-row { display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:10px; }
.fpb-row-3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:8px; margin-bottom:10px; }
.fpb-label { display:block; font-size:.75rem; font-weight:600; color:#475569; margin-bottom:4px; }
.fpb-btn { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:8px; font-size:.82rem; font-weight:600; cursor:pointer; border:none; transition:all .2s; }
.fpb-btn-primary { background:#FF6B00; color:#fff; } .fpb-btn-primary:hover { background:#e55a00; }
.fpb-btn-success { background:#16a34a; color:#fff; } .fpb-btn-success:hover { background:#15803d; }
.fpb-btn-outline { background:#fff; color:#475569; border:1px solid #e2e8f0; } .fpb-btn-outline:hover { background:#f1f5f9; }
.fpb-btn-danger  { background:#ef4444; color:#fff; } .fpb-btn-danger:hover { background:#dc2626; }
.fpb-btn-sm { padding:5px 10px; font-size:.75rem; }
.type-grid { display:grid; grid-template-columns:1fr 1fr; gap:6px; }
.type-btn { padding:8px 6px; border:2px solid #e2e8f0; border-radius:8px; background:#fff; cursor:pointer; text-align:center; font-size:.72rem; font-weight:600; color:#475569; transition:all .2s; }
.type-btn:hover { border-color:#FF6B00; color:#FF6B00; }
.type-btn.active { border-color:#FF6B00; background:#fff7ed; color:#FF6B00; }
.type-btn i { display:block; font-size:1rem; margin-bottom:4px; }
.canvas-tabs { display:flex; gap:8px; margin-bottom:16px; border-bottom:1px solid #e2e8f0; padding-bottom:12px; }
.canvas-tab { padding:7px 16px; border-radius:8px 8px 0 0; font-size:.82rem; font-weight:600; cursor:pointer; border:none; background:transparent; color:#64748b; transition:all .2s; }
.canvas-tab.active { background:#FF6B00; color:#fff; }
#plan-svg, #elev-front-svg, #elev-side-svg { display:block; width:100%; border:1px solid #e2e8f0; border-radius:12px; background:#f8fafc; }
.plan-list { display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:16px; }
.plan-card { background:#fff; border:1px solid #e2e8f0; border-radius:12px; overflow:hidden; transition:box-shadow .2s; }
.plan-card:hover { box-shadow:0 4px 20px rgba(0,0,0,.1); }
.plan-card-header { padding:14px 16px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; }
.plan-card-preview { padding:12px; background:#f8fafc; }
.plan-card-preview svg { width:100%; height:140px; border-radius:8px; }
.plan-card-info { padding:14px 16px; }
.plan-badge { display:inline-flex; align-items:center; gap:4px; padding:2px 8px; border-radius:99px; font-size:.7rem; font-weight:600; }
.badge-pub  { background:#dcfce7; color:#16a34a; }
.badge-priv { background:#f1f5f9; color:#64748b; }
.badge-tpl  { background:#fff7ed; color:#f97316; }
.dim-display { background:#1e293b; color:#a3e635; font-family:monospace; font-size:.8rem; padding:10px 12px; border-radius:8px; margin-bottom:12px; }
.zone-color-btn { width:28px; height:28px; border-radius:6px; border:2px solid transparent; cursor:pointer; transition:border .2s; flex-shrink:0; }
.zone-color-btn.selected { border-color:#1e293b; }
.element-chip { display:inline-flex; align-items:center; gap:6px; padding:4px 10px; border-radius:99px; background:#f1f5f9; font-size:.75rem; font-weight:600; cursor:pointer; border:1px solid #e2e8f0; margin:3px; transition:all .2s; }
.element-chip:hover { background:#fff7ed; border-color:#FF6B00; color:#FF6B00; }
@media(max-width:900px) {
  .fpb-layout { grid-template-columns:1fr; }
  .fpb-panel { max-height:none; border-right:none; border-bottom:1px solid #e2e8f0; }
}
</style>

<?php if ($action === 'list'): ?>
<!-- ═══ LIST VIEW ═══════════════════════════════════════════════ -->
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px">
  <div>
    <h2 style="margin:0">Floor Plan Builder</h2>
    <p style="color:#64748b;margin:4px 0 0;font-size:.88rem">Create top-down plans &amp; elevation views for any sports ground</p>
  </div>
  <a href="/admin/floor-plans.php?action=new" class="fpb-btn fpb-btn-primary">
    <i class="fas fa-plus"></i> New Floor Plan
  </a>
</div>

<?php if (!empty($plans)): ?>
<div class="plan-list">
  <?php foreach ($plans as $p): ?>
  <?php
    $types = ['football-5'=>'5-a-Side Football','football-6'=>'6-a-Side Football','football-7'=>'7-a-Side Football',
              'football-9'=>'9-a-Side Football','football-11'=>'11-a-Side Football',
              'box-cricket-cage'=>'Box Cricket (Full Cage)','box-cricket-open'=>'Box Cricket (Open-Top)',
              'box-cricket-rooftop'=>'Box Cricket (Rooftop)','box-cricket-indoor'=>'Box Cricket (Indoor)',
              'multi-lane'=>'Multi-Lane Setup','custom'=>'Custom Layout'];
    $type_label = $types[$p['ground_type']] ?? 'Custom';
    $colors = ['football-5'=>'#3b82f6','football-6'=>'#8b5cf6','football-7'=>'#f59e0b','football-9'=>'#ec4899',
               'football-11'=>'#dc2626','box-cricket-cage'=>'#f97316','box-cricket-open'=>'#0ea5e9',
               'box-cricket-rooftop'=>'#8b5cf6','box-cricket-indoor'=>'#10b981','multi-lane'=>'#6366f1','custom'=>'#64748b'];
    $clr = $colors[$p['ground_type']] ?? '#64748b';
  ?>
  <div class="plan-card">
    <div class="plan-card-header">
      <div>
        <div style="font-weight:700;font-size:.92rem"><?php echo htmlspecialchars($p['title']); ?></div>
        <div style="font-size:.75rem;color:#64748b;margin-top:2px"><?php echo $type_label; ?></div>
      </div>
      <div style="display:flex;gap:6px;flex-wrap:wrap;justify-content:flex-end">
        <?php if ($p['is_template']): ?><span class="plan-badge badge-tpl"><i class="fas fa-star"></i> Template</span><?php endif; ?>
        <?php if ($p['is_published']): ?><span class="plan-badge badge-pub">Published</span>
        <?php else: ?><span class="plan-badge badge-priv">Draft</span><?php endif; ?>
      </div>
    </div>
    <div class="plan-card-preview">
      <!-- Mini SVG preview generated inline -->
      <svg viewBox="0 0 240 120" xmlns="http://www.w3.org/2000/svg" style="width:100%;height:120px;border-radius:8px;background:#e8f5e9">
        <?php
        $l = min((float)$p['length_ft'], 500); $w = min((float)$p['width_ft'], 300);
        $ratio = $l > 0 && $w > 0 ? $l/$w : 2;
        $svgW = 220; $svgH = 100;
        if ($ratio > $svgW/$svgH) { $pw = $svgW; $ph = round($svgW / $ratio); }
        else { $ph = $svgH; $pw = round($svgH * $ratio); }
        $ox = (240 - $pw) / 2; $oy = (120 - $ph) / 2;
        $isCricket = strpos($p['ground_type'], 'box-cricket') !== false || $p['ground_type'] === 'multi-lane';
        echo "<rect x='$ox' y='$oy' width='$pw' height='$ph' fill='#4ade80' rx='3' stroke='#16a34a' stroke-width='2'/>";
        if (!$isCricket) {
            // Football markings (simplified)
            $cx = $ox + $pw/2; $cy = $oy + $ph/2;
            echo "<circle cx='$cx' cy='$cy' r='" . round($ph*0.22) . "' fill='none' stroke='#fff' stroke-width='1.5' opacity='.7'/>";
            echo "<line x1='$cx' y1='$oy' x2='$cx' y2='" . ($oy+$ph) . "' stroke='#fff' stroke-width='1.5' opacity='.7'/>";
            $gw = $pw * 0.12; $gh = $ph * 0.4;
            echo "<rect x='$ox' y='" . ($oy+($ph-$gh)/2) . "' width='$gw' height='$gh' fill='none' stroke='#fff' stroke-width='1.2' opacity='.7'/>";
            echo "<rect x='" . ($ox+$pw-$gw) . "' y='" . ($oy+($ph-$gh)/2) . "' width='$gw' height='$gh' fill='none' stroke='#fff' stroke-width='1.2' opacity='.7'/>";
        } else {
            // Cricket pitch (simplified)
            $cx = $ox + $pw/2; $cy = $oy + $ph/2;
            $plen = $ph * 0.7; $pwid = $pw * 0.12;
            echo "<rect x='" . ($cx-$pwid/2) . "' y='" . ($cy-$plen/2) . "' width='$pwid' height='$plen' fill='#a3e635' rx='2'/>";
            echo "<line x1='" . ($cx-$pwid/2) . "' y1='" . ($cy-$plen/2+$plen*0.15) . "' x2='" . ($cx+$pwid/2) . "' y2='" . ($cy-$plen/2+$plen*0.15) . "' stroke='#fff' stroke-width='1.2'/>";
            echo "<line x1='" . ($cx-$pwid/2) . "' y1='" . ($cy+$plen/2-$plen*0.15) . "' x2='" . ($cx+$pwid/2) . "' y2='" . ($cy+$plen/2-$plen*0.15) . "' stroke='#fff' stroke-width='1.2'/>";
        }
        if ($p['ground_type'] === 'box-cricket-cage' || $p['ground_type'] === 'box-cricket-rooftop') {
            echo "<rect x='$ox' y='$oy' width='$pw' height='$ph' fill='none' stroke='#f97316' stroke-width='2.5' stroke-dasharray='4,2'/>";
        }
        // Dimension text
        echo "<text x='" . ($ox + $pw/2) . "' y='" . ($oy + $ph + 12) . "' font-size='9' fill='#374151' text-anchor='middle'>" . $p['length_ft'] . "ft × " . $p['width_ft'] . "ft</text>";
        ?>
      </svg>
    </div>
    <div class="plan-card-info">
      <?php if ($p['length_ft'] > 0): ?>
      <div style="display:flex;gap:10px;font-size:.78rem;color:#64748b;margin-bottom:10px">
        <span><i class="fas fa-ruler-horizontal" style="color:<?php echo $clr; ?>"></i> <?php echo $p['length_ft']; ?>ft</span>
        <span><i class="fas fa-ruler-vertical" style="color:<?php echo $clr; ?>"></i> <?php echo $p['width_ft']; ?>ft</span>
        <span><i class="fas fa-arrows-alt-v" style="color:<?php echo $clr; ?>"></i> H: <?php echo $p['height_ft']; ?>ft</span>
        <span><b style="color:#1e293b"><?php echo number_format($p['sqft']); ?> sqft</b></span>
      </div>
      <?php endif; ?>
      <?php if ($p['client_name']): ?>
      <div style="font-size:.78rem;color:#64748b;margin-bottom:8px"><i class="fas fa-user"></i> <?php echo htmlspecialchars($p['client_name']); ?> <?php echo $p['location'] ? '– ' . htmlspecialchars($p['location']) : ''; ?></div>
      <?php endif; ?>
      <div style="display:flex;gap:8px;flex-wrap:wrap">
        <a href="/admin/floor-plans.php?action=edit&id=<?php echo $p['id']; ?>" class="fpb-btn fpb-btn-outline fpb-btn-sm"><i class="fas fa-pencil-alt"></i> Edit &amp; View</a>
        <a href="/admin/floor-plans.php?action=toggle&id=<?php echo $p['id']; ?>" class="fpb-btn fpb-btn-sm" style="background:<?php echo $p['is_published'] ? '#f1f5f9' : '#dcfce7'; ?>;color:<?php echo $p['is_published'] ? '#64748b' : '#16a34a'; ?>">
          <i class="fas fa-<?php echo $p['is_published'] ? 'eye-slash' : 'eye'; ?>"></i> <?php echo $p['is_published'] ? 'Unpublish' : 'Publish'; ?>
        </a>
        <a href="/admin/floor-plans.php?action=delete&id=<?php echo $p['id']; ?>" class="fpb-btn fpb-btn-danger fpb-btn-sm" onclick="return confirm('Delete this plan?')"><i class="fas fa-trash"></i></a>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>
<?php else: ?>
<div style="text-align:center;padding:60px;background:#f8fafc;border-radius:12px">
  <i class="fas fa-drafting-compass" style="font-size:3rem;color:#cbd5e1;margin-bottom:16px;display:block"></i>
  <h3 style="color:#64748b">No floor plans yet</h3>
  <p style="color:#94a3b8;margin-bottom:20px">Create your first floor plan with the visual builder</p>
  <a href="/admin/floor-plans.php?action=new" class="fpb-btn fpb-btn-primary"><i class="fas fa-plus"></i> Create First Plan</a>
</div>
<?php endif; ?>

<?php else: ?>
<!-- ═══ BUILDER VIEW (new / edit) ═══════════════════════════════ -->
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
  <div style="display:flex;align-items:center;gap:12px">
    <a href="/admin/floor-plans.php" class="fpb-btn fpb-btn-outline fpb-btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
    <div>
      <h2 style="margin:0;font-size:1.2rem"><?php echo $plan ? 'Edit Plan: ' . htmlspecialchars($plan['title']) : 'New Floor Plan'; ?></h2>
      <p style="color:#64748b;margin:2px 0 0;font-size:.8rem">Draw top-down plan view and elevation views</p>
    </div>
  </div>
  <div style="display:flex;gap:8px">
    <button onclick="exportPDF()" class="fpb-btn fpb-btn-outline fpb-btn-sm"><i class="fas fa-file-pdf"></i> Export PDF</button>
    <button onclick="exportPNG()" class="fpb-btn fpb-btn-outline fpb-btn-sm"><i class="fas fa-image"></i> Export PNG</button>
    <button form="plan-form" type="submit" class="fpb-btn fpb-btn-primary"><i class="fas fa-save"></i> Save Plan</button>
  </div>
</div>

<div class="fpb-layout">
  <!-- LEFT PANEL – Controls -->
  <div class="fpb-panel">
    <form id="plan-form" method="POST" action="/admin/floor-plans.php?action=<?php echo $plan ? 'edit&id='.$plan_id : 'new'; ?>">
      <input type="hidden" name="_action" value="<?php echo $plan ? 'update' : 'create'; ?>">
      <input type="hidden" name="pitch_zones" id="pitch_zones_input" value="<?php echo htmlspecialchars($plan['pitch_zones'] ?? '[]'); ?>">
      <input type="hidden" name="elements" id="elements_input" value="<?php echo htmlspecialchars($plan['elements'] ?? '[]'); ?>">

      <!-- Plan Info -->
      <div class="fpb-section">
        <h5><i class="fas fa-info-circle"></i> Plan Details</h5>
        <div style="margin-bottom:8px">
          <label class="fpb-label">Plan Title *</label>
          <input type="text" name="title" class="fpb-input" placeholder="e.g. 7-a-Side Football Turf – Kukatpally" required
                 value="<?php echo htmlspecialchars($plan['title'] ?? ''); ?>">
        </div>
        <div class="fpb-row">
          <div>
            <label class="fpb-label">Client Name</label>
            <input type="text" name="client_name" class="fpb-input" placeholder="Optional"
                   value="<?php echo htmlspecialchars($plan['client_name'] ?? ''); ?>">
          </div>
          <div>
            <label class="fpb-label">Phone</label>
            <input type="text" name="client_phone" class="fpb-input" placeholder="Optional"
                   value="<?php echo htmlspecialchars($plan['client_phone'] ?? ''); ?>">
          </div>
        </div>
        <div style="margin-bottom:8px">
          <label class="fpb-label">Location / City</label>
          <input type="text" name="location" class="fpb-input" placeholder="e.g. Kukatpally, Hyderabad"
                 value="<?php echo htmlspecialchars($plan['location'] ?? ''); ?>">
        </div>
        <div style="margin-bottom:8px">
          <label class="fpb-label">Notes</label>
          <textarea name="notes" class="fpb-input" rows="2" placeholder="Extra notes..."><?php echo htmlspecialchars($plan['notes'] ?? ''); ?></textarea>
        </div>
        <div style="display:flex;gap:16px">
          <label style="display:flex;align-items:center;gap:6px;font-size:.82rem;cursor:pointer">
            <input type="checkbox" name="is_published" value="1" <?php echo ($plan['is_published'] ?? 0) ? 'checked' : ''; ?>>
            Publish on website
          </label>
          <label style="display:flex;align-items:center;gap:6px;font-size:.82rem;cursor:pointer">
            <input type="checkbox" name="is_template" value="1" <?php echo ($plan['is_template'] ?? 0) ? 'checked' : ''; ?>>
            Mark as template
          </label>
        </div>
      </div>

      <!-- Ground Type -->
      <div class="fpb-section">
        <h5><i class="fas fa-layer-group"></i> Ground Type</h5>
        <input type="hidden" name="ground_type" id="ground_type_input" value="<?php echo htmlspecialchars($plan['ground_type'] ?? 'football-7'); ?>">
        <div class="type-grid">
          <?php
          $gtypes = [
            ['football-5','fas fa-futbol','5-a-Side','#3b82f6'],
            ['football-6','fas fa-futbol','6-a-Side','#8b5cf6'],
            ['football-7','fas fa-star','7-a-Side','#f59e0b'],
            ['football-9','fas fa-users','9-a-Side','#ec4899'],
            ['football-11','fas fa-trophy','11-a-Side','#dc2626'],
            ['box-cricket-cage','fas fa-cube','Box Cricket Cage','#f97316'],
            ['box-cricket-open','fas fa-arrows-alt-v','Box Cricket Open','#0ea5e9'],
            ['box-cricket-rooftop','fas fa-home','Box Cricket Roof','#8b5cf6'],
            ['box-cricket-indoor','fas fa-warehouse','Indoor / Warehouse','#10b981'],
            ['multi-lane','fas fa-columns','Multi-Lane Twin','#6366f1'],
          ];
          $cur_type = $plan['ground_type'] ?? 'football-7';
          foreach ($gtypes as $gt): ?>
          <div class="type-btn <?php echo $cur_type===$gt[0]?'active':''; ?>"
               data-type="<?php echo $gt[0]; ?>"
               onclick="selectType('<?php echo $gt[0]; ?>', this)"
               style="border-color:<?php echo $cur_type===$gt[0]?$gt[3]:'#e2e8f0'; ?>">
            <i class="<?php echo $gt[1]; ?>" style="color:<?php echo $gt[3]; ?>"></i>
            <?php echo $gt[2]; ?>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Dimensions -->
      <div class="fpb-section">
        <h5><i class="fas fa-ruler-combined"></i> Dimensions</h5>
        <div class="fpb-row-3">
          <div>
            <label class="fpb-label">Length (ft)</label>
            <input type="number" id="dim-length" name="length_ft" class="fpb-input" placeholder="180"
                   value="<?php echo $plan['length_ft'] ?? 180; ?>" oninput="renderAll()">
          </div>
          <div>
            <label class="fpb-label">Width (ft)</label>
            <input type="number" id="dim-width" name="width_ft" class="fpb-input" placeholder="100"
                   value="<?php echo $plan['width_ft'] ?? 100; ?>" oninput="renderAll()">
          </div>
          <div>
            <label class="fpb-label">Height (ft)</label>
            <input type="number" id="dim-height" name="height_ft" class="fpb-input" placeholder="20"
                   value="<?php echo $plan['height_ft'] ?? 20; ?>" oninput="renderAll()">
          </div>
        </div>
        <div class="dim-display" id="dim-display">
          📐 Loading dimensions...
        </div>

        <!-- Quick presets -->
        <h5 style="margin-top:12px"><i class="fas fa-bolt"></i> Quick Presets</h5>
        <div style="display:flex;gap:6px;flex-wrap:wrap">
          <?php
          $presets = [
            ['5-a-Side','football-5',82,50,18],
            ['6-a-Side','football-6',115,70,18],
            ['7-a-Side','football-7',180,100,20],
            ['Box Cricket','box-cricket-cage',80,50,25],
            ['Twin Lanes','multi-lane',160,50,25],
          ];
          foreach ($presets as $pr): ?>
          <button type="button" class="fpb-btn fpb-btn-outline fpb-btn-sm"
                  onclick="applyPreset('<?php echo $pr[1]; ?>',<?php echo $pr[2]; ?>,<?php echo $pr[3]; ?>,<?php echo $pr[4]; ?>)">
            <?php echo $pr[0]; ?>
          </button>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Elements to add -->
      <div class="fpb-section">
        <h5><i class="fas fa-object-group"></i> Add Elements to Plan</h5>
        <p style="font-size:.74rem;color:#94a3b8;margin-bottom:8px">Click chips to toggle elements on the plan:</p>
        <div id="element-chips">
          <?php
          $elements_list = [
            ['center-circle','Center Circle'],['penalty-box','Penalty Box'],['goal','Goal Posts'],
            ['crease','Batting Crease'],['pitch-strip','Pitch Strip'],['divider-net','Divider Net'],
            ['entry-gate','Entry Gate'],['spectator-stand','Spectator Area'],
            ['light-pole','Flood Light Pole'],['scoreboard','Scoreboard'],
            ['rest-area','Rest Area'],['equipment-room','Equipment Room'],
          ];
          foreach ($elements_list as $el): ?>
          <span class="element-chip" data-el="<?php echo $el[0]; ?>" onclick="toggleElement('<?php echo $el[0]; ?>','<?php echo $el[1]; ?>')">
            <?php echo $el[1]; ?>
          </span>
          <?php endforeach; ?>
        </div>
      </div>

      <div style="border-top:1px solid #e2e8f0;padding-top:16px;margin-top:4px">
        <button type="submit" class="fpb-btn fpb-btn-primary" style="width:100%">
          <i class="fas fa-save"></i> Save Floor Plan
        </button>
      </div>
    </form>
  </div>

  <!-- RIGHT PANEL – Canvas Views -->
  <div class="fpb-canvas-area">
    <div class="canvas-tabs">
      <button class="canvas-tab active" onclick="switchView('plan',this)"><i class="fas fa-map"></i> Top-Down Plan View</button>
      <button class="canvas-tab" onclick="switchView('elev-front',this)"><i class="fas fa-building"></i> Front Elevation</button>
      <button class="canvas-tab" onclick="switchView('elev-side',this)"><i class="fas fa-sign"></i> Side Elevation</button>
    </div>

    <!-- Top-Down Plan -->
    <div id="view-plan" class="canvas-view">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px">
        <h4 style="margin:0;font-size:.9rem;color:#64748b"><i class="fas fa-map"></i> Plan View (Top-Down)</h4>
        <span style="font-size:.75rem;color:#94a3b8">Looking from above</span>
      </div>
      <svg id="plan-svg" viewBox="0 0 800 500" xmlns="http://www.w3.org/2000/svg"></svg>
      <p style="font-size:.72rem;color:#94a3b8;margin-top:8px;text-align:center">
        <i class="fas fa-info-circle"></i> All measurements shown in feet. Net zones shown in orange.
      </p>
    </div>

    <!-- Front Elevation -->
    <div id="view-elev-front" class="canvas-view" style="display:none">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px">
        <h4 style="margin:0;font-size:.9rem;color:#64748b"><i class="fas fa-building"></i> Front Elevation View</h4>
        <span style="font-size:.75rem;color:#94a3b8">Looking from the front (long side)</span>
      </div>
      <svg id="elev-front-svg" viewBox="0 0 800 400" xmlns="http://www.w3.org/2000/svg"></svg>
      <p style="font-size:.72rem;color:#94a3b8;margin-top:8px;text-align:center">
        <i class="fas fa-info-circle"></i> Structure height, net wall height, and frame shown.
      </p>
    </div>

    <!-- Side Elevation -->
    <div id="view-elev-side" class="canvas-view" style="display:none">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px">
        <h4 style="margin:0;font-size:.9rem;color:#64748b"><i class="fas fa-sign"></i> Side Elevation View</h4>
        <span style="font-size:.75rem;color:#94a3b8">Looking from the side (short side)</span>
      </div>
      <svg id="elev-side-svg" viewBox="0 0 800 400" xmlns="http://www.w3.org/2000/svg"></svg>
      <p style="font-size:.72rem;color:#94a3b8;margin-top:8px;text-align:center">
        <i class="fas fa-info-circle"></i> Width, height, and lateral net walls shown.
      </p>
    </div>

    <!-- Legend -->
    <div style="display:flex;gap:16px;flex-wrap:wrap;margin-top:16px;padding:12px;background:#f8fafc;border-radius:8px;font-size:.75rem">
      <span><span style="display:inline-block;width:14px;height:14px;background:#4ade80;border-radius:3px;vertical-align:middle;margin-right:4px"></span>Outfield Turf</span>
      <span><span style="display:inline-block;width:14px;height:14px;background:#a3e635;border-radius:3px;vertical-align:middle;margin-right:4px"></span>Pitch / Playing Area</span>
      <span><span style="display:inline-block;width:14px;height:14px;background:#f97316;opacity:.7;border-radius:3px;vertical-align:middle;margin-right:4px"></span>Net / Boundary</span>
      <span><span style="display:inline-block;width:14px;height:14px;background:#1e293b;border-radius:3px;vertical-align:middle;margin-right:4px"></span>Structure / Frame</span>
      <span><span style="display:inline-block;width:14px;height:14px;background:#fff;border:2px solid #94a3b8;border-radius:3px;vertical-align:middle;margin-right:4px"></span>Markings</span>
    </div>
  </div>
</div>

<script>
// ═══════════════════════════════════════════════════════════════
//  NetsDial Floor Plan Builder – SVG Rendering Engine
// ═══════════════════════════════════════════════════════════════

let currentType = document.getElementById('ground_type_input').value || 'football-7';
let activeElements = <?php echo $plan && $plan['elements'] !== '[]' ? htmlspecialchars($plan['elements']) : '[]'; ?>;
let currentView = 'plan';

// Sync element chips on load
activeElements.forEach(el => {
  const chip = document.querySelector(`.element-chip[data-el="${el.id}"]`);
  if (chip) { chip.style.background='#fff7ed'; chip.style.borderColor='#FF6B00'; chip.style.color='#FF6B00'; }
});

function getDims() {
  return {
    L: parseFloat(document.getElementById('dim-length').value) || 180,
    W: parseFloat(document.getElementById('dim-width').value)  || 100,
    H: parseFloat(document.getElementById('dim-height').value) || 20,
  };
}

function selectType(type, el) {
  currentType = type;
  document.getElementById('ground_type_input').value = type;
  document.querySelectorAll('.type-btn').forEach(b => {
    b.classList.remove('active');
    b.style.borderColor = '#e2e8f0';
  });
  el.classList.add('active');
  const colors = {
    'football-5':'#3b82f6','football-6':'#8b5cf6','football-7':'#f59e0b','football-9':'#ec4899',
    'football-11':'#dc2626','box-cricket-cage':'#f97316','box-cricket-open':'#0ea5e9',
    'box-cricket-rooftop':'#8b5cf6','box-cricket-indoor':'#10b981','multi-lane':'#6366f1'
  };
  el.style.borderColor = colors[type] || '#FF6B00';
  renderAll();
}

function applyPreset(type, l, w, h) {
  document.getElementById('dim-length').value = l;
  document.getElementById('dim-width').value  = w;
  document.getElementById('dim-height').value = h;
  const btn = document.querySelector(`.type-btn[data-type="${type}"]`);
  if (btn) selectType(type, btn);
  else renderAll();
}

function toggleElement(id, label) {
  const idx = activeElements.findIndex(e => e.id === id);
  const chip = document.querySelector(`.element-chip[data-el="${id}"]`);
  if (idx >= 0) {
    activeElements.splice(idx, 1);
    chip.style.background=''; chip.style.borderColor=''; chip.style.color='';
  } else {
    activeElements.push({id, label});
    chip.style.background='#fff7ed'; chip.style.borderColor='#FF6B00'; chip.style.color='#FF6B00';
  }
  document.getElementById('elements_input').value = JSON.stringify(activeElements);
  renderAll();
}

function switchView(view, btn) {
  currentView = view;
  document.querySelectorAll('.canvas-view').forEach(v => v.style.display='none');
  document.getElementById('view-' + view).style.display='block';
  document.querySelectorAll('.canvas-tab').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
}

// ── SVG Helpers ─────────────────────────────────────────────
function makeRect(x,y,w,h,fill,stroke,sw,rx,opacity) {
  return `<rect x="${x}" y="${y}" width="${w}" height="${h}" fill="${fill||'none'}" stroke="${stroke||'none'}" stroke-width="${sw||1}" rx="${rx||0}" opacity="${opacity||1}"/>`;
}
function makeLine(x1,y1,x2,y2,stroke,sw,dash) {
  return `<line x1="${x1}" y1="${y1}" x2="${x2}" y2="${y2}" stroke="${stroke||'#fff'}" stroke-width="${sw||1}" stroke-dasharray="${dash||'none'}"/>`;
}
function makeText(x,y,text,size,fill,anchor,weight) {
  return `<text x="${x}" y="${y}" font-size="${size||10}" fill="${fill||'#1e293b'}" text-anchor="${anchor||'middle'}" font-weight="${weight||'normal'}" font-family="Inter,Arial,sans-serif">${text}</text>`;
}
function makeCircle(cx,cy,r,fill,stroke,sw) {
  return `<circle cx="${cx}" cy="${cy}" r="${r}" fill="${fill||'none'}" stroke="${stroke||'#fff'}" stroke-width="${sw||1.5}"/>`;
}
function dimArrow(x1,y1,x2,y2,label,color) {
  // Horizontal or vertical dimension annotation
  const isH = Math.abs(y2-y1) < 2;
  let out = `<line x1="${x1}" y1="${y1}" x2="${x2}" y2="${y2}" stroke="${color||'#64748b'}" stroke-width="1.5" marker-start="url(#arrow)" marker-end="url(#arrow)"/>`;
  const mx = (x1+x2)/2, my = (y1+y2)/2;
  const bg = `<rect x="${mx-label.length*2.8}" y="${my-7}" width="${label.length*5.8}" height="13" fill="white" rx="3" opacity=".9"/>`;
  out += bg + makeText(mx, my+4, label, 9, color||'#1e293b', 'middle', '600');
  return out;
}

// ── PLAN VIEW RENDERER ──────────────────────────────────────
function renderPlan() {
  const {L, W, H} = getDims();
  const VW = 800, VH = 500;
  const margin = 60;
  const avW = VW - margin*2, avH = VH - margin*2;
  const scale = Math.min(avW/L, avH/W);
  const pw = L * scale, ph = W * scale;
  const ox = (VW - pw) / 2, oy = (VH - ph) / 2;

  const isCricket = currentType.startsWith('box-cricket') || currentType === 'multi-lane';
  const isMulti   = currentType === 'multi-lane';
  const isCage    = currentType === 'box-cricket-cage' || currentType === 'box-cricket-rooftop';

  let svg = `<defs>
    <marker id="arrow" markerWidth="8" markerHeight="8" refX="4" refY="4" orient="auto">
      <path d="M2,2 L6,4 L2,6" stroke="#64748b" stroke-width="1" fill="none"/>
    </marker>
    <pattern id="grass" patternUnits="userSpaceOnUse" width="20" height="20">
      <rect width="20" height="20" fill="#4ade80"/>
      <line x1="0" y1="10" x2="20" y2="10" stroke="#3cb97b" stroke-width="0.4" opacity="0.5"/>
      <line x1="10" y1="0" x2="10" y2="20" stroke="#3cb97b" stroke-width="0.4" opacity="0.5"/>
    </pattern>
  </defs>`;

  // Sky/ground background
  svg += makeRect(0, 0, VW, VH, '#e0f2fe', 'none');

  // Ground fill
  svg += makeRect(ox, oy, pw, ph, 'url(#grass)', '#16a34a', 3, 4);

  if (!isCricket) {
    // ── FOOTBALL GROUND ──
    const cx = ox + pw/2, cy = oy + ph/2;

    // Center circle
    const cr = Math.min(ph * 0.16, pw * 0.08);
    svg += makeCircle(cx, cy, cr, 'none', '#fff', 2);
    svg += makeCircle(cx, cy, 3, '#fff', 'none', 0);

    // Half-way line
    svg += makeLine(cx, oy, cx, oy+ph, '#fff', 2);

    // Penalty areas
    const paW = pw * 0.12, paH = ph * 0.45;
    const paY = oy + (ph - paH) / 2;
    svg += makeRect(ox, paY, paW, paH, 'rgba(255,255,255,.08)', '#fff', 1.5);
    svg += makeRect(ox+pw-paW, paY, paW, paH, 'rgba(255,255,255,.08)', '#fff', 1.5);

    // Goal boxes
    const gbW = pw * 0.05, gbH = ph * 0.22;
    const gbY = oy + (ph - gbH) / 2;
    svg += makeRect(ox, gbY, gbW, gbH, 'rgba(255,255,255,.05)', '#fff', 1, 0);
    svg += makeRect(ox+pw-gbW, gbY, gbW, gbH, 'rgba(255,255,255,.05)', '#fff', 1, 0);

    // Goals (outside pitch)
    const gW = pw * 0.015, gH = ph * 0.1;
    const gY = oy + (ph - gH) / 2;
    svg += makeRect(ox-gW, gY, gW, gH, '#fbbf24', '#f59e0b', 2, 2);
    svg += makeRect(ox+pw, gY, gW, gH, '#fbbf24', '#f59e0b', 2, 2);

    // 11-a-side: extra circles and arcs
    if (currentType === 'football-11') {
      svg += `<path d="M ${cx-cr*0.3},${oy+paH+oy*0.5} A ${cr},${cr} 0 0,0 ${cx+cr*0.3},${oy+paH+oy*0.5}" fill="none" stroke="#fff" stroke-width="1.5"/>`;
    }

    // Net boundary (orange dashed if 5/6 cage style)
    if (currentType === 'football-5' || currentType === 'football-6') {
      svg += makeRect(ox-3, oy-3, pw+6, ph+6, 'none', '#f97316', 3, 4);
    }

    // Dimensions
    svg += dimArrow(ox, oy-30, ox+pw, oy-30, L+'ft (Length)');
    svg += dimArrow(ox-40, oy, ox-40, oy+ph, W+'ft (Width)');

  } else if (isMulti) {
    // ── MULTI-LANE TWIN ──
    const divX = ox + pw/2;
    svg += makeLine(divX, oy, divX, oy+ph, '#f97316', 3, '6,3');
    svg += makeText(divX, oy-10, '⟵ Lane 1 ⟶', 10, '#64748b', 'right');
    svg += makeText(divX, oy-10, '⟵ Lane 2 ⟶', 10, '#64748b', 'left');

    // Each lane – cricket pitch
    [ox, ox+pw/2].forEach((lox, li) => {
      const lw = pw/2, lh = ph;
      const lcx = lox + lw/2, lcy = oy + lh/2;
      const pLen = lh * 0.65, pWid = lw * 0.12;
      svg += makeRect(lcx-pWid/2, lcy-pLen/2, pWid, pLen, '#a3e635', '#65a30d', 1.5, 3);
      // Creases
      svg += makeLine(lcx-pWid/2, lcy-pLen/2+pLen*0.14, lcx+pWid/2, lcy-pLen/2+pLen*0.14, '#fff', 1.5);
      svg += makeLine(lcx-pWid/2, lcy+pLen/2-pLen*0.14, lcx+pWid/2, lcy+pLen/2-pLen*0.14, '#fff', 1.5);
      svg += makeText(lcx, lcy, 'Lane '+(li+1), 10, '#1e293b', 'middle', '700');
    });

    // Boundary net
    svg += makeRect(ox, oy, pw, ph, 'none', '#f97316', 3, 4);
    svg += dimArrow(ox, oy-30, ox+pw, oy-30, L+'ft');
    svg += dimArrow(ox-40, oy, ox-40, oy+ph, W+'ft');

  } else {
    // ── BOX CRICKET ──
    const cx = ox + pw/2, cy = oy + ph/2;
    const netW = 8, netColor = '#f97316';

    // Net walls (all 4 sides as thick bands)
    svg += makeRect(ox, oy, netW, ph, netColor, 'none', 0, 0, 0.5);
    svg += makeRect(ox+pw-netW, oy, netW, ph, netColor, 'none', 0, 0, 0.5);
    svg += makeRect(ox, oy, pw, netW, netColor, 'none', 0, 0, 0.5);
    svg += makeRect(ox, oy+ph-netW, pw, netW, netColor, 'none', 0, 0, 0.5);

    // If cage (top net)
    if (isCage) {
      svg += makeRect(ox+netW, oy+netW, pw-netW*2, ph-netW*2, '#4ade80', '#16a34a', 1.5, 2);
      // Hatched top net pattern
      svg += `<pattern id="topnet" patternUnits="userSpaceOnUse" width="12" height="12"><line x1="0" y1="0" x2="12" y2="12" stroke="${netColor}" stroke-width="0.8" opacity="0.3"/><line x1="12" y1="0" x2="0" y2="12" stroke="${netColor}" stroke-width="0.8" opacity="0.3"/></pattern>`;
      svg += makeRect(ox+netW, oy+netW, pw-netW*2, ph-netW*2, 'url(#topnet)', 'none', 0, 0, 1);
    } else {
      svg += makeRect(ox+netW, oy+netW, pw-netW*2, ph-netW*2, '#4ade80', '#16a34a', 1.5, 2);
    }

    // Pitch strip
    const pLen = ph * 0.65, pWid = pw * 0.1;
    svg += makeRect(cx-pWid/2, cy-pLen/2, pWid, pLen, '#a3e635', '#65a30d', 2, 3);

    // Batting creases
    svg += makeLine(cx-pWid/2, cy-pLen/2+pLen*0.13, cx+pWid/2, cy-pLen/2+pLen*0.13, '#fff', 2);
    svg += makeLine(cx-pWid/2, cy+pLen/2-pLen*0.13, cx+pWid/2, cy+pLen/2-pLen*0.13, '#fff', 2);
    // Popping crease extensions
    svg += makeLine(cx-pWid, cy-pLen/2+pLen*0.13, cx-pWid/2, cy-pLen/2+pLen*0.13, '#fff', 1, '3,2');
    svg += makeLine(cx+pWid/2, cy-pLen/2+pLen*0.13, cx+pWid, cy-pLen/2+pLen*0.13, '#fff', 1, '3,2');

    // Boundary
    svg += makeRect(ox, oy, pw, ph, 'none', '#f97316', 3, 4);
    svg += dimArrow(ox, oy-30, ox+pw, oy-30, L+'ft');
    svg += dimArrow(ox-40, oy, ox-40, oy+ph, W+'ft');
  }

  // Active element overlays
  activeElements.forEach(el => {
    const cx = ox + pw/2, cy = oy + ph/2;
    switch(el.id) {
      case 'light-pole':
        [ox+20,ox+pw-20,ox+20,ox+pw-20].forEach((lx,i) => {
          const ly = i<2 ? oy+20 : oy+ph-20;
          svg += makeCircle(lx, ly, 6, '#fbbf24', '#f59e0b', 1.5);
          svg += makeText(lx, ly+16, '💡', 8, '#f59e0b', 'middle');
        });
        break;
      case 'entry-gate':
        svg += makeRect(cx-15, oy+ph-5, 30, 12, '#6366f1', '#4f46e5', 2, 4);
        svg += makeText(cx, oy+ph+14, 'GATE', 8, '#6366f1', 'middle', '700');
        break;
      case 'spectator-stand':
        svg += makeRect(ox-35, oy+ph/2-30, 30, 60, '#ddd6fe', '#8b5cf6', 1.5, 4);
        svg += makeText(ox-20, oy+ph/2+4, '👥', 10, '#7c3aed', 'middle');
        break;
      case 'scoreboard':
        svg += makeRect(ox+pw-50, oy-25, 50, 20, '#1e293b', '#0f172a', 1.5, 4);
        svg += makeText(ox+pw-25, oy-12, 'SCORE', 8, '#a3e635', 'middle', '700');
        break;
      case 'equipment-room':
        svg += makeRect(ox+pw+8, oy+ph-50, 30, 40, '#e2e8f0', '#94a3b8', 1.5, 4);
        svg += makeText(ox+pw+23, oy+ph-26, '🔧', 9, '#64748b', 'middle');
        break;
    }
  });

  // Compass
  svg += `<g transform="translate(${VW-50},40)">
    <circle cx="0" cy="0" r="18" fill="white" stroke="#e2e8f0" stroke-width="1.5"/>
    <text x="0" y="-6" font-size="10" text-anchor="middle" fill="#dc2626" font-weight="700">N</text>
    <path d="M0,-14 L3,-6 L0,-4 L-3,-6 Z" fill="#dc2626"/>
    <path d="M0,14 L3,6 L0,4 L-3,6 Z" fill="#94a3b8"/>
  </g>`;

  // Title
  const typeLabels = {
    'football-5':'5-a-Side Football (Futsal)','football-6':'6-a-Side Football',
    'football-7':'7-a-Side Football (Standard)','football-9':'9-a-Side Football',
    'football-11':'11-a-Side Football (FIFA Standard)','box-cricket-cage':'Box Cricket – Full Cage',
    'box-cricket-open':'Box Cricket – Open Top','box-cricket-rooftop':'Box Cricket – Rooftop',
    'box-cricket-indoor':'Box Cricket – Indoor / Warehouse','multi-lane':'Multi-Lane Twin Setup'
  };
  svg += makeText(VW/2, VH-10, (typeLabels[currentType]||'Custom') + ' | Plan View', 11, '#64748b', 'middle', '600');
  svg += makeText(VW/2, 18, 'NetsDial by GCM Enterprises | Floor Plan', 10, '#94a3b8', 'middle');

  document.getElementById('plan-svg').innerHTML = svg;
}

// ── FRONT ELEVATION RENDERER ────────────────────────────────
function renderElevFront() {
  const {L, W, H} = getDims();
  const VW = 800, VH = 400;
  const margin = 60;
  const groundY = VH - 60;
  const avW = VW - margin*2;
  const scale = avW / L;
  const pw = L * scale;
  const ph = H * scale;
  const ox = (VW - pw) / 2;
  const oy = groundY - ph;

  const isCricket = currentType.startsWith('box-cricket') || currentType === 'multi-lane';
  const isCage    = currentType === 'box-cricket-cage' || currentType === 'box-cricket-rooftop';

  let svg = `<defs><marker id="arrow2" markerWidth="8" markerHeight="8" refX="4" refY="4" orient="auto">
    <path d="M2,2 L6,4 L2,6" stroke="#64748b" stroke-width="1" fill="none"/>
  </marker></defs>`;

  // Sky gradient
  svg += `<defs><linearGradient id="sky" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#bfdbfe"/><stop offset="100%" stop-color="#e0f2fe"/></linearGradient></defs>`;
  svg += makeRect(0, 0, VW, VH, 'url(#sky)', 'none');

  // Ground strip
  svg += makeRect(0, groundY, VW, VH-groundY, '#a3e635', 'none');

  // Structure frame (posts)
  const postW = 8;
  svg += makeRect(ox, oy, postW, ph, '#1e293b', '#0f172a', 1, 2);
  svg += makeRect(ox+pw-postW, oy, postW, ph, '#1e293b', '#0f172a', 1, 2);

  // Net fill (mesh hatch)
  svg += `<defs><pattern id="mesh" patternUnits="userSpaceOnUse" width="10" height="10">
    <line x1="0" y1="0" x2="10" y2="10" stroke="#f97316" stroke-width="0.8" opacity="0.5"/>
    <line x1="10" y1="0" x2="0" y2="10" stroke="#f97316" stroke-width="0.8" opacity="0.5"/>
  </pattern></defs>`;
  svg += makeRect(ox+postW, oy, pw-postW*2, ph, 'url(#mesh)', '#f97316', 1.5, 0, 0.7);

  // Roof beam (for cage)
  if (isCage) {
    svg += makeRect(ox, oy, pw, postW, '#1e293b', '#0f172a', 1, 2);
    svg += makeRect(ox+postW, oy+postW, pw-postW*2, 10, '#f97316', '#ea580c', 1, 0, 0.5);
  }

  // Turf floor
  svg += makeRect(ox+postW, groundY-8, pw-postW*2, 8, '#4ade80', '#16a34a', 1.5);

  // Ground line
  svg += makeLine(0, groundY, VW, groundY, '#64748b', 1.5, '4,3');

  // Dimensions
  // Height arrow
  svg += `<line x1="${ox-35}" y1="${oy}" x2="${ox-35}" y2="${groundY}" stroke="#64748b" stroke-width="1.5" marker-start="url(#arrow2)" marker-end="url(#arrow2)"/>`;
  const hLabel = H+'ft Height';
  svg += `<rect x="${ox-35-hLabel.length*2.8}" y="${(oy+groundY)/2-7}" width="${hLabel.length*5.8}" height="13" fill="white" rx="3" opacity=".9"/>`;
  svg += makeText(ox-35, (oy+groundY)/2+4, hLabel, 9, '#64748b', 'middle', '600');

  // Length arrow
  svg += `<line x1="${ox}" y1="${groundY+30}" x2="${ox+pw}" y2="${groundY+30}" stroke="#64748b" stroke-width="1.5" marker-start="url(#arrow2)" marker-end="url(#arrow2)"/>`;
  const lLabel = L+'ft Length';
  svg += `<rect x="${(ox+(ox+pw))/2-lLabel.length*2.8}" y="${groundY+23}" width="${lLabel.length*5.8}" height="13" fill="white" rx="3" opacity=".9"/>`;
  svg += makeText((ox+(ox+pw))/2, groundY+36, lLabel, 9, '#64748b', 'middle', '600');

  // Labels
  svg += makeText(ox+pw/2, oy - 8, 'FRONT ELEVATION  |  ' + (currentType.startsWith('box') ? 'Box Cricket' : 'Football Turf'), 11, '#1e293b', 'middle', '700');
  svg += makeText(ox+pw/2, VH-5, 'NetsDial by GCM Enterprises | Elevation View', 9, '#94a3b8', 'middle');

  // MS pipe label on posts
  svg += makeText(ox+4, oy+ph/2, 'MS Frame', 8, '#fff', 'middle', '600');

  // Net label
  svg += makeText(ox+pw/2, oy+ph/2, 'HDPE Net', 10, '#f97316', 'middle', '700');

  document.getElementById('elev-front-svg').innerHTML = svg;
}

// ── SIDE ELEVATION RENDERER ─────────────────────────────────
function renderElevSide() {
  const {L, W, H} = getDims();
  const VW = 800, VH = 400;
  const groundY = VH - 60;
  const avW = VW - 120;
  const scale = avW / W;
  const pw = W * scale;
  const ph = H * scale;
  const ox = (VW - pw) / 2;
  const oy = groundY - ph;
  const isCage = currentType === 'box-cricket-cage' || currentType === 'box-cricket-rooftop';

  let svg = `<defs><marker id="arrow3" markerWidth="8" markerHeight="8" refX="4" refY="4" orient="auto">
    <path d="M2,2 L6,4 L2,6" stroke="#64748b" stroke-width="1" fill="none"/>
  </marker>
  <linearGradient id="sky2" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#bfdbfe"/><stop offset="100%" stop-color="#e0f2fe"/></linearGradient>
  <pattern id="mesh2" patternUnits="userSpaceOnUse" width="10" height="10">
    <line x1="0" y1="0" x2="10" y2="10" stroke="#f97316" stroke-width="0.8" opacity="0.5"/>
    <line x1="10" y1="0" x2="0" y2="10" stroke="#f97316" stroke-width="0.8" opacity="0.5"/>
  </pattern></defs>`;

  svg += makeRect(0, 0, VW, VH, 'url(#sky2)', 'none');
  svg += makeRect(0, groundY, VW, VH-groundY, '#a3e635', 'none');

  const postW = 8;
  svg += makeRect(ox, oy, postW, ph, '#1e293b', '#0f172a', 1, 2);
  svg += makeRect(ox+pw-postW, oy, postW, ph, '#1e293b', '#0f172a', 1, 2);
  svg += makeRect(ox+postW, oy, pw-postW*2, ph, 'url(#mesh2)', '#f97316', 1.5, 0, 0.7);
  if (isCage) {
    svg += makeRect(ox, oy, pw, postW, '#1e293b', '#0f172a', 1, 2);
  }
  svg += makeRect(ox+postW, groundY-8, pw-postW*2, 8, '#4ade80', '#16a34a', 1.5);
  svg += makeLine(0, groundY, VW, groundY, '#64748b', 1.5, '4,3');

  // Width arrow
  svg += `<line x1="${ox}" y1="${groundY+30}" x2="${ox+pw}" y2="${groundY+30}" stroke="#64748b" stroke-width="1.5" marker-start="url(#arrow3)" marker-end="url(#arrow3)"/>`;
  svg += makeText((ox+(ox+pw))/2, groundY+42, W+'ft Width', 9, '#64748b', 'middle', '600');

  // Height arrow
  svg += `<line x1="${ox-35}" y1="${oy}" x2="${ox-35}" y2="${groundY}" stroke="#64748b" stroke-width="1.5" marker-start="url(#arrow3)" marker-end="url(#arrow3)"/>`;
  svg += makeText(ox-35, (oy+groundY)/2+4, H+'ft H', 9, '#64748b', 'middle', '600');

  svg += makeText(ox+pw/2, oy-8, 'SIDE ELEVATION  |  Width: '+W+'ft × Height: '+H+'ft', 11, '#1e293b', 'middle', '700');
  svg += makeText(ox+pw/2, VH-5, 'NetsDial by GCM Enterprises | Side Elevation View', 9, '#94a3b8', 'middle');
  svg += makeText(ox+pw/2, oy+ph/2, 'HDPE Net', 10, '#f97316', 'middle', '700');

  document.getElementById('elev-side-svg').innerHTML = svg;
}

function updateDimDisplay() {
  const {L, W, H} = getDims();
  const sqft = (L * W).toFixed(0);
  const netPerimeter = (2*(L+W)*H).toFixed(0);
  document.getElementById('dim-display').innerHTML =
    `📐 ${L}ft × ${W}ft | Height: ${H}ft<br>` +
    `📊 Ground Area: ${Number(sqft).toLocaleString()} sq.ft<br>` +
    `🕸️ Net Area (perimeter walls): ~${Number(netPerimeter).toLocaleString()} sq.ft`;
}

function renderAll() {
  updateDimDisplay();
  renderPlan();
  renderElevFront();
  renderElevSide();
}

// Export functions
function exportPNG() {
  const svgId = currentView === 'plan' ? 'plan-svg' : currentView === 'elev-front' ? 'elev-front-svg' : 'elev-side-svg';
  const svg = document.getElementById(svgId);
  const data = new XMLSerializer().serializeToString(svg);
  const blob = new Blob([data], {type:'image/svg+xml'});
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url; a.download = 'netsdial-floor-plan.svg'; a.click();
}

function exportPDF() {
  const planName = document.querySelector('input[name="title"]').value || 'Floor Plan';
  const {L, W, H} = getDims();
  const w = window.open('', '_blank');
  const svgs = [
    document.getElementById('plan-svg').outerHTML,
    document.getElementById('elev-front-svg').outerHTML,
    document.getElementById('elev-side-svg').outerHTML,
  ];
  w.document.write(`<!DOCTYPE html><html><head>
    <title>${planName}</title>
    <style>body{font-family:Arial,sans-serif;padding:20px;max-width:900px;margin:0 auto}
    h1{color:#FF6B00;font-size:18px;margin-bottom:4px}
    .meta{color:#64748b;font-size:12px;margin-bottom:20px}
    .view-title{font-size:13px;font-weight:700;color:#1e293b;margin:20px 0 8px;text-transform:uppercase}
    svg{width:100%;border:1px solid #e2e8f0;border-radius:8px;page-break-inside:avoid}
    @media print{.noprint{display:none}}
    </style></head><body>
    <h1>Floor Plan: ${planName}</h1>
    <p class="meta">NetsDial by GCM Enterprises | ${L}ft × ${W}ft × ${H}ft Height | ${(L*W).toLocaleString()} sq.ft | Generated: ${new Date().toLocaleDateString('en-IN')}</p>
    <div class="view-title">1. Top-Down Plan View</div>
    ${svgs[0]}
    <div class="view-title">2. Front Elevation View</div>
    ${svgs[1]}
    <div class="view-title">3. Side Elevation View</div>
    ${svgs[2]}
    <p style="font-size:10px;color:#94a3b8;margin-top:20px;text-align:center">
      NetsDial – India's Largest Russea™ HDPE Net Wholesale Supplier | GCM Enterprises, Hyderabad | +91 9966499144
    </p>
    <script>window.onload=function(){window.print();}<\/script>
  </body></html>`);
}

// Initialize on load
window.addEventListener('DOMContentLoaded', renderAll);
</script>
<?php endif; ?>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
