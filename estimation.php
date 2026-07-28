<?php
/**
 * NetsDial - Estimation Calculator Page
 * All 6 estimation calculators with admin-editable rates
 */
define('NETSDIAL', true);
require_once __DIR__ . '/config/config.php';

$page_meta_title = "Free Estimation Calculator - Safety Nets, Invisible Grills, Cricket Nets, Artificial Grass | NetsDial";
$page_meta_desc  = "Calculate exact cost of safety nets, pigeon netting, invisible grills, artificial grass, cricket nets and box cricket setup. Free online estimation tool. Call: 9966499144";
$page_meta_kw    = "pigeon net cost calculator, safety net price calculator, invisible grill estimation, cricket net price, artificial grass cost, box cricket setup price, net cost per sqft hyderabad";

include __DIR__ . '/includes/header.php';
?>

<div class="breadcrumb-bar">
  <div class="container">
    <div class="breadcrumb">
      <a href="/">Home</a><span class="sep"><i class="fas fa-chevron-right"></i></span>
      <span class="current">Estimation Calculator</span>
    </div>
  </div>
</div>

<div class="page-hero">
  <div class="container">
    <h1>Free Cost <span>Estimation</span> Calculator</h1>
    <p>Get instant price estimates for all our products. Rates as of 2026. Call for best wholesale price.</p>
  </div>
</div>

<section class="section">
  <div class="container">

    <!-- Tabs -->
    <div class="estimation-tabs" role="tablist">
      <button class="estimation-tab active" data-tab="tab-safety-net" role="tab">
        <i class="fas fa-shield-alt"></i> Safety Nets
      </button>
      <button class="estimation-tab" data-tab="tab-cricket" role="tab">
        <i class="fas fa-baseball-ball"></i> Cricket Nets
      </button>
      <button class="estimation-tab" data-tab="tab-invisible" role="tab">
        <i class="fas fa-border-all"></i> Invisible Grills
      </button>
      <button class="estimation-tab" data-tab="tab-hanger" role="tab">
        <i class="fas fa-tshirt"></i> Cloth Hangers
      </button>
      <button class="estimation-tab" data-tab="tab-grass" role="tab">
        <i class="fas fa-leaf"></i> Artificial Grass
      </button>
      <button class="estimation-tab" data-tab="tab-boxcricket" role="tab">
        <i class="fas fa-building"></i> Box Cricket Setup
      </button>
    </div>

    <!-- ══════ TAB 1: SAFETY NETS ══════ -->
    <div class="estimation-panel active" id="tab-safety-net">
      <div style="background:var(--white);border:1px solid var(--border);border-radius:var(--radius-xl);padding:36px">
        <h2 style="margin-bottom:6px"><i class="fas fa-shield-alt" style="color:var(--primary)"></i> Safety Net Estimation</h2>
        <p style="margin-bottom:28px">Balcony Safety Net / Pigeon Net / Anti Bird Net cost calculator. Includes installation charges.</p>

        <div class="form-row" style="margin-bottom:20px">
          <div>
            <label style="display:block;font-weight:600;margin-bottom:6px">Enter Area</label>
            <div style="display:flex;gap:10px;align-items:center">
              <div class="form-group" style="margin:0;flex:1">
                <label style="font-size:.82rem;color:var(--text-light)">Length (ft)</label>
                <input type="number" id="sn-length" class="form-control" placeholder="e.g. 15" min="1">
              </div>
              <span style="margin-top:18px">×</span>
              <div class="form-group" style="margin:0;flex:1">
                <label style="font-size:.82rem;color:var(--text-light)">Height/Width (ft)</label>
                <input type="number" id="sn-height" class="form-control" placeholder="e.g. 8" min="1">
              </div>
              <span style="margin-top:18px">or</span>
              <div class="form-group" style="margin:0;flex:1">
                <label style="font-size:.82rem;color:var(--text-light)">Total Sq Ft (direct)</label>
                <input type="number" id="sn-sqft" class="form-control" placeholder="e.g. 120" min="1">
              </div>
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="fw-600">Net Thickness</label>
            <select id="sn-thickness" class="form-control">
              <option value="1.5mm">1.5mm (Standard)</option>
              <option value="2mm" selected>2mm (Recommended)</option>
              <option value="2.5mm">2.5mm (Heavy Duty)</option>
            </select>
          </div>
          <div class="form-group">
            <label class="fw-600">Square Gap / Mesh Size</label>
            <select id="sn-gap" class="form-control">
              <option value="30mm">30mm (Pigeon Net)</option>
              <option value="40mm" selected>40mm (Standard)</option>
              <option value="45mm">45mm (Economy)</option>
              <option value="50mm">50mm (Large Gap)</option>
            </select>
          </div>
        </div>

        <button onclick="calculateSafetyNet()" class="btn btn-primary btn-lg">
          <i class="fas fa-calculator"></i> Calculate Estimate
        </button>

        <div class="estimation-result" id="sn-result">
          <div id="sn-sqft-display" style="font-size:.95rem;opacity:.8;margin-bottom:6px"></div>
          <h4 style="color:var(--white);margin-bottom:4px">Estimated Cost Range</h4>
          <div class="result-range" id="sn-range"></div>
          <p class="result-note" id="sn-note"></p>
          <div style="margin-top:20px;display:flex;gap:10px;flex-wrap:wrap">
            <a href="contact.php" class="btn btn-outline-white"><i class="fas fa-phone-alt"></i> Get Exact Quote</a>
            <a href="<?php echo SITE_WHATSAPP; ?>" target="_blank" class="btn btn-whatsapp"><i class="fab fa-whatsapp"></i> WhatsApp</a>
          </div>
        </div>
      </div>
    </div>

    <!-- ══════ TAB 2: CRICKET NETS ══════ -->
    <div class="estimation-panel" id="tab-cricket">
      <div style="background:var(--white);border:1px solid var(--border);border-radius:var(--radius-xl);padding:36px">
        <h2 style="margin-bottom:6px"><i class="fas fa-baseball-ball" style="color:var(--primary)"></i> Cricket Net Estimation</h2>
        <p style="margin-bottom:8px">Formula: <code style="background:var(--light-gray);padding:2px 8px;border-radius:4px">Area = (L×W) + 2×(L×H) + 2×(W×H)</code></p>
        <p style="margin-bottom:28px">Enter Length, Width and Height of cricket net enclosure in feet.</p>

        <div class="form-row">
          <div class="form-group form-icon">
            <label class="fw-600">Length (ft)</label>
            <i class="fas fa-arrows-alt-h"></i>
            <input type="number" id="cn-length" class="form-control" placeholder="e.g. 60" min="1">
          </div>
          <div class="form-group form-icon">
            <label class="fw-600">Width (ft)</label>
            <i class="fas fa-arrows-alt-v"></i>
            <input type="number" id="cn-width" class="form-control" placeholder="e.g. 20" min="1">
          </div>
          <div class="form-group form-icon">
            <label class="fw-600">Height (ft)</label>
            <i class="fas fa-sort-amount-up"></i>
            <input type="number" id="cn-height" class="form-control" placeholder="e.g. 14" min="1">
          </div>
        </div>

        <div class="form-group">
          <label class="fw-600">Square Gap / Mesh Size</label>
          <select id="cn-gap" class="form-control">
            <option value="40mm">40mm (Standard Cricket)</option>
            <option value="45mm" selected>45mm (Recommended)</option>
            <option value="50mm">50mm (Economy)</option>
          </select>
        </div>

        <button onclick="calculateCricketNet()" class="btn btn-primary btn-lg">
          <i class="fas fa-calculator"></i> Calculate Cricket Net Cost
        </button>

        <div class="estimation-result" id="cn-result">
          <div id="cn-area-display" style="font-size:.95rem;opacity:.8;margin-bottom:6px"></div>
          <h4 style="color:var(--white);margin-bottom:4px">Estimated Cost Range</h4>
          <div class="result-range" id="cn-range"></div>
          <p class="result-note" id="cn-note"></p>
          <div style="margin-top:20px;display:flex;gap:10px;flex-wrap:wrap">
            <a href="contact.php" class="btn btn-outline-white"><i class="fas fa-phone-alt"></i> Get Exact Quote</a>
            <a href="<?php echo SITE_WHATSAPP; ?>" target="_blank" class="btn btn-whatsapp"><i class="fab fa-whatsapp"></i> WhatsApp</a>
          </div>
        </div>
      </div>
    </div>

    <!-- ══════ TAB 3: INVISIBLE GRILLS ══════ -->
    <div class="estimation-panel" id="tab-invisible">
      <div style="background:var(--white);border:1px solid var(--border);border-radius:var(--radius-xl);padding:36px">
        <h2 style="margin-bottom:6px"><i class="fas fa-border-all" style="color:var(--primary)"></i> Invisible Grill Estimation</h2>
        <p style="margin-bottom:28px">SS Invisible Grill Balcony cost calculator. Enter dimensions or direct sqft.</p>

        <div class="form-row">
          <div class="form-group"><label class="fw-600">Length (ft)</label><input type="number" id="ig-length" class="form-control" placeholder="e.g. 12" min="1"></div>
          <div class="form-group"><label class="fw-600">Height (ft)</label><input type="number" id="ig-height" class="form-control" placeholder="e.g. 9" min="1"></div>
          <div class="form-group"><label class="fw-600">OR Direct Sq Ft</label><input type="number" id="ig-sqft" class="form-control" placeholder="e.g. 108" min="1"></div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="fw-600">Wire Thickness</label>
            <select id="ig-thickness" class="form-control">
              <option value="1.5mm">1.5mm</option>
              <option value="2mm" selected>2mm (Standard)</option>
              <option value="2.5mm">2.5mm (Heavy)</option>
              <option value="3mm">3mm (Premium)</option>
            </select>
          </div>
          <div class="form-group">
            <label class="fw-600">Line Gap</label>
            <select id="ig-gap" class="form-control">
              <option value="2inch" selected>2 Inch (Recommended)</option>
              <option value="3inch">3 Inch (Economy)</option>
            </select>
          </div>
        </div>
        <button onclick="calculateInvisibleGrill()" class="btn btn-primary btn-lg">
          <i class="fas fa-calculator"></i> Calculate Invisible Grill Cost
        </button>
        <div class="estimation-result" id="ig-result">
          <div id="ig-sqft-display" style="font-size:.95rem;opacity:.8;margin-bottom:6px"></div>
          <h4 style="color:var(--white);margin-bottom:4px">Estimated Cost Range</h4>
          <div class="result-range" id="ig-range"></div>
          <p class="result-note" id="ig-note"></p>
          <div style="margin-top:20px;display:flex;gap:10px;flex-wrap:wrap">
            <a href="contact.php" class="btn btn-outline-white"><i class="fas fa-phone-alt"></i> Get Exact Quote</a>
            <a href="<?php echo SITE_WHATSAPP; ?>" target="_blank" class="btn btn-whatsapp"><i class="fab fa-whatsapp"></i> WhatsApp</a>
          </div>
        </div>
      </div>
    </div>

    <!-- ══════ TAB 4: CLOTH HANGERS ══════ -->
    <div class="estimation-panel" id="tab-hanger">
      <div style="background:var(--white);border:1px solid var(--border);border-radius:var(--radius-xl);padding:36px">
        <h2 style="margin-bottom:6px"><i class="fas fa-tshirt" style="color:var(--primary)"></i> Cloth Hanger Estimation</h2>
        <p style="margin-bottom:28px">SS Ceiling and Wall Mounted Cloth Hanger cost calculator.</p>
        <div class="form-row">
          <div class="form-group">
            <label class="fw-600">Hanger Type</label>
            <select id="ch-type" class="form-control">
              <option value="ceiling">Ceiling Cloth Hanger</option>
              <option value="wall">Wall Mounted Cloth Hanger</option>
            </select>
          </div>
          <div class="form-group">
            <label class="fw-600">Length</label>
            <select id="ch-length" class="form-control">
              <option value="4ft">4 Feet</option>
              <option value="5ft" selected>5 Feet</option>
              <option value="6ft">6 Feet</option>
              <option value="7ft">7 Feet</option>
              <option value="8ft">8 Feet</option>
            </select>
          </div>
        </div>
        <button onclick="calculateHanger()" class="btn btn-primary btn-lg">
          <i class="fas fa-calculator"></i> Calculate Cloth Hanger Cost
        </button>
        <div class="estimation-result" id="ch-result">
          <h4 style="color:var(--white);margin-bottom:4px">Estimated Cost (Per Unit)</h4>
          <div class="result-range" id="ch-range"></div>
          <p class="result-note" id="ch-note"></p>
          <div style="margin-top:20px;display:flex;gap:10px;flex-wrap:wrap">
            <a href="contact.php" class="btn btn-outline-white"><i class="fas fa-phone-alt"></i> Get Exact Quote</a>
            <a href="<?php echo SITE_WHATSAPP; ?>" target="_blank" class="btn btn-whatsapp"><i class="fab fa-whatsapp"></i> WhatsApp</a>
          </div>
        </div>
      </div>
    </div>

    <!-- ══════ TAB 5: ARTIFICIAL GRASS ══════ -->
    <div class="estimation-panel" id="tab-grass">
      <div style="background:var(--white);border:1px solid var(--border);border-radius:var(--radius-xl);padding:36px">
        <h2 style="margin-bottom:6px"><i class="fas fa-leaf" style="color:var(--primary)"></i> Artificial Grass Estimation</h2>
        <p style="margin-bottom:28px">Calculate cost for artificial grass mat, turf, or football grass.</p>
        <div class="form-row">
          <div class="form-group"><label class="fw-600">Length (ft)</label><input type="number" id="ag-length" class="form-control" placeholder="e.g. 20" min="1"></div>
          <div class="form-group"><label class="fw-600">Width (ft)</label><input type="number" id="ag-width" class="form-control" placeholder="e.g. 15" min="1"></div>
          <div class="form-group"><label class="fw-600">OR Direct Sq Ft</label><input type="number" id="ag-sqft" class="form-control" placeholder="e.g. 300" min="1"></div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="fw-600">Grass Type</label>
            <select id="ag-type" class="form-control">
              <optgroup label="Artificial Grass Mat">
                <option value="mat_25_single">25mm - Single Layer (₹30-40/sft)</option>
                <option value="mat_30_single">30mm - Single Layer (₹33-43/sft)</option>
                <option value="mat_40_single">40mm - Single Layer (₹36-46/sft)</option>
                <option value="mat_50_single">50mm - Single Layer (₹40-50/sft)</option>
                <option value="mat_25_double">25mm - Double Layer (₹35-45/sft)</option>
                <option value="mat_30_double">30mm - Double Layer (₹38-48/sft)</option>
                <option value="mat_40_double">40mm - Double Layer (₹41-51/sft)</option>
                <option value="mat_50_double">50mm - Double Layer (₹45-55/sft)</option>
              </optgroup>
              <optgroup label="Artificial Grass Turf">
                <option value="turf_25_single">25mm Turf - Single Layer (₹95-135/sft)</option>
              </optgroup>
              <optgroup label="Football Grass">
                <option value="football_50_double">50mm Football Grass - Double Layer (₹75-100/sft)</option>
              </optgroup>
            </select>
          </div>
        </div>
        <button onclick="calculateGrass()" class="btn btn-primary btn-lg">
          <i class="fas fa-calculator"></i> Calculate Artificial Grass Cost
        </button>
        <div class="estimation-result" id="ag-result">
          <div id="ag-sqft-display" style="font-size:.95rem;opacity:.8;margin-bottom:6px"></div>
          <h4 style="color:var(--white);margin-bottom:4px">Estimated Cost Range</h4>
          <div class="result-range" id="ag-range"></div>
          <p class="result-note" id="ag-note"></p>
          <p style="color:rgba(255,255,255,.7);font-size:.85rem;margin-top:8px">📞 Call for best price on large orders!</p>
          <div style="margin-top:20px;display:flex;gap:10px;flex-wrap:wrap">
            <a href="contact.php" class="btn btn-outline-white"><i class="fas fa-phone-alt"></i> Get Exact Quote</a>
            <a href="<?php echo SITE_WHATSAPP; ?>" target="_blank" class="btn btn-whatsapp"><i class="fab fa-whatsapp"></i> WhatsApp</a>
          </div>
        </div>
      </div>
    </div>

    <!-- ══════ TAB 6: BOX CRICKET SETUP ══════ -->
    <div class="estimation-panel" id="tab-boxcricket">
      <div style="background:var(--white);border:1px solid var(--border);border-radius:var(--radius-xl);padding:36px">
        <h2 style="margin-bottom:6px"><i class="fas fa-building" style="color:var(--primary)"></i> Box Cricket Setup Estimation</h2>
        <p style="margin-bottom:8px">Includes: Net + Grass + Structure Fabrication + Flooring</p>
        <div class="alert alert-info" style="margin-bottom:28px"><i class="fas fa-info-circle"></i> Rate: ₹220 - ₹300/sqft depending on structure height and site conditions.</div>

        <div class="form-row">
          <div class="form-group"><label class="fw-600">Ground Length (ft)</label><input type="number" id="bc-length" class="form-control" placeholder="e.g. 60" min="1"></div>
          <div class="form-group"><label class="fw-600">Ground Width (ft)</label><input type="number" id="bc-width" class="form-control" placeholder="e.g. 30" min="1"></div>
          <div class="form-group"><label class="fw-600">OR Direct Sq Ft</label><input type="number" id="bc-sqft" class="form-control" placeholder="e.g. 1800" min="1"></div>
        </div>

        <div class="form-group">
          <label class="fw-600">Structure Height</label>
          <select id="bc-height" class="form-control">
            <option value="20">20 feet</option>
            <option value="25" selected>25 feet (Standard)</option>
            <option value="30">30 feet</option>
            <option value="35">35 feet</option>
            <option value="40">40 feet</option>
          </select>
        </div>

        <button onclick="calculateBoxCricket()" class="btn btn-primary btn-lg">
          <i class="fas fa-calculator"></i> Calculate Box Cricket Setup Cost
        </button>

        <div class="estimation-result" id="bc-result">
          <div id="bc-sqft-display" style="font-size:.95rem;opacity:.8;margin-bottom:6px"></div>
          <h4 style="color:var(--white);margin-bottom:4px">Estimated Setup Cost Range</h4>
          <div class="result-range" id="bc-range"></div>
          <p class="result-note" id="bc-note"></p>
          <div class="alert" style="background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.3);margin-top:14px">
            <i class="fas fa-info-circle"></i> Final cost depends on site inspection, soil conditions and exact specifications. Call for site visit.
          </div>
          <div style="margin-top:16px;display:flex;gap:10px;flex-wrap:wrap">
            <a href="contact.php" class="btn btn-outline-white"><i class="fas fa-phone-alt"></i> Call for Best Price</a>
            <a href="<?php echo SITE_WHATSAPP; ?>" target="_blank" class="btn btn-whatsapp"><i class="fab fa-whatsapp"></i> WhatsApp</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Disclaimer -->
    <div class="alert alert-warning mt-32">
      <i class="fas fa-exclamation-triangle"></i>
      <span><strong>Disclaimer:</strong> These are estimated price ranges only. Actual prices may vary based on location, quantity, specifications and current market rates. Contact us for exact quotations. All prices are subject to change without notice.</span>
    </div>

  </div>
</section>

<!-- CTA -->
<section class="cta-section">
  <div class="container" style="text-align:center">
    <h2>Need a Detailed Quotation?</h2>
    <p>Our team will provide a complete written quotation within 4 hours.</p>
    <div class="cta-buttons">
      <a href="tel:+91<?php echo SITE_PHONE; ?>" class="btn btn-outline-white btn-lg"><i class="fas fa-phone-alt"></i> Call Now</a>
      <a href="<?php echo SITE_WHATSAPP; ?>" target="_blank" class="btn btn-whatsapp btn-lg"><i class="fab fa-whatsapp"></i> WhatsApp</a>
    </div>
  </div>
</section>

<script>
// ─────────────────────────────────────────────────────────────
// ESTIMATION CALCULATORS - JavaScript
// ─────────────────────────────────────────────────────────────

// Safety Net Calculator
function calculateSafetyNet() {
  const len = parseFloat(document.getElementById('sn-length').value) || 0;
  const ht  = parseFloat(document.getElementById('sn-height').value) || 0;
  let sqft  = parseFloat(document.getElementById('sn-sqft').value) || 0;
  if (!sqft && len && ht) sqft = len * ht;
  if (!sqft) { alert('Please enter length & height OR direct sqft area.'); return; }

  const thickness = document.getElementById('sn-thickness').value;
  const gap       = document.getElementById('sn-gap').value;

  let minRate, maxRate, note;
  const result = document.getElementById('sn-result');
  document.getElementById('sn-sqft-display').textContent = `Total Area: ${sqft.toFixed(0)} Sq Ft`;

  if (sqft < 100) {
    const fixed = { '1.5mm': 1500, '2mm': 1650, '2.5mm': 1800 };
    const price = fixed[thickness] || 1500;
    document.getElementById('sn-range').textContent = `₹${price.toLocaleString('en-IN')} (Fixed Rate)`;
    document.getElementById('sn-note').textContent = `Fixed rate for below 100 sqft. Includes installation for ${thickness} net.`;
    result.classList.add('show');
    return;
  }

  const rates = {
    '100-250': {
      '1.5mm-30mm':[16,20],'2mm-40mm':[24,28],'2mm-45mm':[22,26],'2mm-50mm':[20,24],
      '2.5mm-40mm':[26,30],'2.5mm-45mm':[24,28],'2.5mm-50mm':[22,24]
    },
    '250-500': {
      '1.5mm-30mm':[14,18],'2mm-40mm':[20,24],'2mm-45mm':[18,22],'2mm-50mm':[16,20],
      '2.5mm-40mm':[22,26],'2.5mm-45mm':[20,24],'2.5mm-50mm':[18,22]
    },
    '500-1000': {
      '1.5mm-30mm':[12,16],'2mm-40mm':[18,22],'2mm-45mm':[16,20],'2mm-50mm':[14,18],
      '2.5mm-40mm':[20,24],'2.5mm-45mm':[18,22],'2.5mm-50mm':[16,20]
    },
    '1000-5000': {
      '1.5mm-30mm':[10,14],'2mm-40mm':[14,18],'2mm-45mm':[12,16],'2mm-50mm':[10,14],
      '2.5mm-40mm':[16,20],'2.5mm-45mm':[14,18],'2.5mm-50mm':[12,16]
    }
  };

  if (sqft > 5000) {
    document.getElementById('sn-range').textContent = '📞 CALL FOR BEST PRICE';
    document.getElementById('sn-note').textContent = 'For 5000+ sqft orders, please call us for special wholesale pricing.';
    result.classList.add('show');
    return;
  }

  let rangeKey = sqft < 250 ? '100-250' : sqft < 500 ? '250-500' : sqft < 1000 ? '500-1000' : '1000-5000';
  const effectiveGap = (thickness === '1.5mm') ? '30mm' : gap;
  const rateKey = `${thickness}-${effectiveGap}`;
  const rate = rates[rangeKey][rateKey] || [16, 20];
  const minCost = Math.round(sqft * rate[0]);
  const maxCost = Math.round(sqft * rate[1]);
  document.getElementById('sn-range').textContent = `₹${minCost.toLocaleString('en-IN')} — ₹${maxCost.toLocaleString('en-IN')}`;
  document.getElementById('sn-note').textContent = `₹${rate[0]}-${rate[1]}/sqft × ${sqft.toFixed(0)} sqft. ${thickness} | ${effectiveGap} mesh. Price includes material only.`;
  result.classList.add('show');
}

// Cricket Net Calculator
function calculateCricketNet() {
  const L = parseFloat(document.getElementById('cn-length').value) || 0;
  const W = parseFloat(document.getElementById('cn-width').value)  || 0;
  const H = parseFloat(document.getElementById('cn-height').value) || 0;
  if (!L || !W || !H) { alert('Please enter Length, Width and Height.'); return; }
  const area = (L * W) + 2*(L * H) + 2*(W * H);
  const gap  = document.getElementById('cn-gap').value;

  document.getElementById('cn-area-display').textContent = `Calculated Area: ${area.toFixed(0)} Sq Ft (L:${L}ft × W:${W}ft × H:${H}ft)`;

  const rates = {
    '1000-5000':  { '40mm':[15,18],'45mm':[14,17],'50mm':[13,16] },
    '5000-10000': { '40mm':[14,17],'45mm':[13,16],'50mm':[12,15] },
    '10000-15000':{ '40mm':[12,15],'45mm':[11,14],'50mm':[10,13] },
    '15000-20000':{ '40mm':[11,14],'45mm':[10,13],'50mm':[9,12]  },
    'above-20000':{ '40mm':[10,12],'45mm':[9,11], '50mm':[8,10]  }
  };

  if (area < 1000) {
    document.getElementById('cn-range').textContent = '📞 CALL FOR BEST PRICE';
    document.getElementById('cn-note').textContent = 'For small areas under 1000 sqft, contact us for custom pricing.';
  } else if (area > 20000) {
    const r = rates['above-20000'][gap];
    const min = Math.round(area * r[0]), max = Math.round(area * r[1]);
    document.getElementById('cn-range').textContent = `₹${min.toLocaleString('en-IN')} — ₹${max.toLocaleString('en-IN')}`;
    document.getElementById('cn-note').textContent = `₹${r[0]}-${r[1]}/sqft × ${area.toFixed(0)} sqft | ${gap} mesh`;
  } else {
    const rangeKey = area < 5000 ? '1000-5000' : area < 10000 ? '5000-10000' : area < 15000 ? '10000-15000' : '15000-20000';
    const r = rates[rangeKey][gap];
    const min = Math.round(area * r[0]), max = Math.round(area * r[1]);
    document.getElementById('cn-range').textContent = `₹${min.toLocaleString('en-IN')} — ₹${max.toLocaleString('en-IN')}`;
    document.getElementById('cn-note').textContent = `₹${r[0]}-${r[1]}/sqft × ${area.toFixed(0)} sqft | ${gap} mesh size`;
  }
  document.getElementById('cn-result').classList.add('show');
}

// Invisible Grill Calculator
function calculateInvisibleGrill() {
  const len = parseFloat(document.getElementById('ig-length').value) || 0;
  const ht  = parseFloat(document.getElementById('ig-height').value) || 0;
  let sqft  = parseFloat(document.getElementById('ig-sqft').value)   || 0;
  if (!sqft && len && ht) sqft = len * ht;
  if (!sqft) { alert('Please enter dimensions or direct sqft.'); return; }

  const thickness = document.getElementById('ig-thickness').value;
  const gap       = document.getElementById('ig-gap').value;

  const rates = {
    '1.5mm-2inch':[130,150],'1.5mm-3inch':[120,140],
    '2mm-2inch'  :[140,160],'2mm-3inch'  :[130,150],
    '2.5mm-2inch':[150,170],'2.5mm-3inch':[140,160],
    '3mm-2inch'  :[160,180],'3mm-3inch'  :[150,170]
  };

  const r = rates[`${thickness}-${gap}`] || [140,160];
  const min = Math.round(sqft * r[0]), max = Math.round(sqft * r[1]);
  document.getElementById('ig-sqft-display').textContent = `Total Area: ${sqft.toFixed(0)} Sq Ft`;
  document.getElementById('ig-range').textContent = `₹${min.toLocaleString('en-IN')} — ₹${max.toLocaleString('en-IN')}`;
  document.getElementById('ig-note').textContent = `₹${r[0]}-${r[1]}/sqft × ${sqft.toFixed(0)} sqft | ${thickness} wire | ${gap} line gap`;
  document.getElementById('ig-result').classList.add('show');
}

// Cloth Hanger Calculator
function calculateHanger() {
  const type   = document.getElementById('ch-type').value;
  const length = document.getElementById('ch-length').value;

  const rates = {
    ceiling:{'4ft':[2000,2500],'5ft':[2250,2750],'6ft':[2500,3000],'7ft':[2750,3250],'8ft':[3000,3500]},
    wall:   {'4ft':[2500,3000],'5ft':[2750,3250],'6ft':[3000,3500],'7ft':[3250,3750],'8ft':[3500,4000]}
  };

  const r = rates[type][length];
  document.getElementById('ch-range').textContent = `₹${r[0].toLocaleString('en-IN')} — ₹${r[1].toLocaleString('en-IN')}`;
  document.getElementById('ch-note').textContent = `${type === 'ceiling' ? 'Ceiling' : 'Wall Mounted'} Cloth Hanger | ${length} length | Per unit price`;
  document.getElementById('ch-result').classList.add('show');
}

// Artificial Grass Calculator
function calculateGrass() {
  const len  = parseFloat(document.getElementById('ag-length').value) || 0;
  const wid  = parseFloat(document.getElementById('ag-width').value)  || 0;
  let sqft   = parseFloat(document.getElementById('ag-sqft').value)   || 0;
  if (!sqft && len && wid) sqft = len * wid;
  if (!sqft) { alert('Please enter length & width OR direct sqft.'); return; }

  const type = document.getElementById('ag-type').value;

  const rates = {
    mat_25_single:[30,40],mat_30_single:[33,43],mat_40_single:[36,46],mat_50_single:[40,50],
    mat_25_double:[35,45],mat_30_double:[38,48],mat_40_double:[41,51],mat_50_double:[45,55],
    turf_25_single:[95,135],football_50_double:[75,100]
  };

  const r = rates[type] || [30,40];
  const min = Math.round(sqft * r[0]), max = Math.round(sqft * r[1]);
  document.getElementById('ag-sqft-display').textContent = `Total Area: ${sqft.toFixed(0)} Sq Ft`;
  document.getElementById('ag-range').textContent = `₹${min.toLocaleString('en-IN')} — ₹${max.toLocaleString('en-IN')}`;
  document.getElementById('ag-note').textContent = `₹${r[0]}-${r[1]}/sqft × ${sqft.toFixed(0)} sqft. 📞 Call for best price!`;
  document.getElementById('ag-result').classList.add('show');
}

// Box Cricket Calculator
function calculateBoxCricket() {
  const len  = parseFloat(document.getElementById('bc-length').value) || 0;
  const wid  = parseFloat(document.getElementById('bc-width').value)  || 0;
  let sqft   = parseFloat(document.getElementById('bc-sqft').value)   || 0;
  if (!sqft && len && wid) sqft = len * wid;
  if (!sqft) { alert('Please enter length & width OR direct sqft.'); return; }

  const min = Math.round(sqft * 220), max = Math.round(sqft * 300);
  document.getElementById('bc-sqft-display').textContent = `Ground Area: ${sqft.toFixed(0)} Sq Ft`;
  document.getElementById('bc-range').textContent = `₹${min.toLocaleString('en-IN')} — ₹${max.toLocaleString('en-IN')}`;
  document.getElementById('bc-note').textContent = `₹220-300/sqft × ${sqft.toFixed(0)} sqft | Includes nets, turf, structure & flooring | 📞 Call for best price!`;
  document.getElementById('bc-result').classList.add('show');
}
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
