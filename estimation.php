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


<!-- ═══════════════════════════════════════════════════════════════
     PUBLISHED FLOOR PLANS – Sample Ground Layouts
════════════════════════════════════════════════════════════════ -->
<?php
$pub_plans = db()->fetchAll("SELECT * FROM floor_plans WHERE is_published=1 ORDER BY sort_order, is_template DESC, created_at DESC LIMIT 12");
if (!empty($pub_plans)):
$plan_type_labels = [
  'football-5'=>'5-a-Side Football','football-6'=>'6-a-Side Football','football-7'=>'7-a-Side Football',
  'football-9'=>'9-a-Side Football','football-11'=>'11-a-Side Football',
  'box-cricket-cage'=>'Box Cricket – Full Cage','box-cricket-open'=>'Box Cricket – Open Top',
  'box-cricket-rooftop'=>'Box Cricket – Rooftop','box-cricket-indoor'=>'Box Cricket – Indoor',
  'multi-lane'=>'Multi-Lane Twin Setup','custom'=>'Custom Layout'
];
$plan_colors = [
  'football-5'=>'#3b82f6','football-6'=>'#8b5cf6','football-7'=>'#f59e0b','football-9'=>'#ec4899',
  'football-11'=>'#dc2626','box-cricket-cage'=>'#f97316','box-cricket-open'=>'#0ea5e9',
  'box-cricket-rooftop'=>'#8b5cf6','box-cricket-indoor'=>'#10b981','multi-lane'=>'#6366f1','custom'=>'#64748b'
];
?>
<section class="section" style="background:#fff;padding-top:60px;padding-bottom:60px">
  <div class="container">
    <div style="text-align:center;margin-bottom:40px" data-aos="fade-up">
      <span class="section-badge"><i class="fas fa-drafting-compass"></i> Ground Floor Plans</span>
      <h2 style="margin:12px 0">Sample Ground Layouts &amp; Dimensions</h2>
      <p style="color:var(--text-light);max-width:600px;margin-inline:auto">
        Standard floor plans for commercial sports turf setups. Use these as reference for your project.
        We can create a custom plan for your exact site dimensions.
      </p>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:20px">
      <?php foreach ($pub_plans as $p):
        $clr = $plan_colors[$p['ground_type']] ?? '#64748b';
        $lbl = $plan_type_labels[$p['ground_type']] ?? 'Custom';
        $L = (float)$p['length_ft']; $W = (float)$p['width_ft']; $H = (float)$p['height_ft'];
        $sqft = $L * $W;
        $isCricket = strpos($p['ground_type'], 'box-cricket') !== false || $p['ground_type'] === 'multi-lane';
        $isCage    = in_array($p['ground_type'], ['box-cricket-cage','box-cricket-rooftop']);
        // Compute SVG preview coords
        $ratio = ($L > 0 && $W > 0) ? $L/$W : 2;
        $svgW2 = 280; $svgH2 = 140;
        if ($ratio > $svgW2/$svgH2) { $pw2 = $svgW2-30; $ph2 = round(($svgW2-30)/$ratio); }
        else { $ph2 = $svgH2-20; $pw2 = round(($svgH2-20)*$ratio); }
        $ox2 = (280-$pw2)/2; $oy2 = (140-$ph2)/2;
      ?>
      <div style="background:#fff;border:1px solid #e2e8f0;border-radius:16px;overflow:hidden;transition:box-shadow .2s;cursor:pointer"
           onmouseover="this.style.boxShadow='0 8px 30px rgba(0,0,0,.1)'" onmouseout="this.style.boxShadow=''"
           onclick="openPlanModal(<?php echo htmlspecialchars(json_encode($p)); ?>)">

        <!-- SVG Preview -->
        <div style="background:#e8f5e9;padding:12px">
          <svg viewBox="0 0 280 140" xmlns="http://www.w3.org/2000/svg" style="width:100%;height:140px;display:block">
            <?php
            echo "<rect x='$ox2' y='$oy2' width='$pw2' height='$ph2' fill='#4ade80' rx='4' stroke='#16a34a' stroke-width='2'/>";
            $cx2 = $ox2+$pw2/2; $cy2 = $oy2+$ph2/2;
            if (!$isCricket) {
              echo "<circle cx='$cx2' cy='$cy2' r='" . round($ph2*.2) . "' fill='none' stroke='#fff' stroke-width='1.5'/>";
              echo "<line x1='$cx2' y1='$oy2' x2='$cx2' y2='" . ($oy2+$ph2) . "' stroke='#fff' stroke-width='1.5'/>";
              $gw2=$pw2*.1; $gh2=$ph2*.35; $gy2=$oy2+($ph2-$gh2)/2;
              echo "<rect x='$ox2' y='$gy2' width='$gw2' height='$gh2' fill='none' stroke='#fff' stroke-width='1.2'/>";
              echo "<rect x='" . ($ox2+$pw2-$gw2) . "' y='$gy2' width='$gw2' height='$gh2' fill='none' stroke='#fff' stroke-width='1.2'/>";
            } else {
              $pl2=$ph2*.65; $ppw2=$pw2*.1;
              echo "<rect x='" . ($cx2-$ppw2/2) . "' y='" . ($cy2-$pl2/2) . "' width='$ppw2' height='$pl2' fill='#a3e635' rx='2' stroke='#65a30d' stroke-width='1.5'/>";
              echo "<line x1='" . ($cx2-$ppw2/2) . "' y1='" . ($cy2-$pl2/2+$pl2*.14) . "' x2='" . ($cx2+$ppw2/2) . "' y2='" . ($cy2-$pl2/2+$pl2*.14) . "' stroke='#fff' stroke-width='1.5'/>";
              echo "<line x1='" . ($cx2-$ppw2/2) . "' y1='" . ($cy2+$pl2/2-$pl2*.14) . "' x2='" . ($cx2+$ppw2/2) . "' y2='" . ($cy2+$pl2/2-$pl2*.14) . "' stroke='#fff' stroke-width='1.5'/>";
            }
            if ($isCage) {
              echo "<rect x='$ox2' y='$oy2' width='$pw2' height='$ph2' fill='none' stroke='#f97316' stroke-width='2.5' stroke-dasharray='5,3'/>";
            }
            echo "<text x='" . ($ox2+$pw2/2) . "' y='" . ($oy2+$ph2+13) . "' font-size='9' fill='#374151' text-anchor='middle'>{$L}ft × {$W}ft</text>";
            ?>
          </svg>
        </div>

        <div style="padding:16px">
          <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:8px;gap:8px">
            <div>
              <div style="font-weight:700;font-size:.95rem;color:#1e293b"><?php echo htmlspecialchars($p['title']); ?></div>
              <div style="font-size:.75rem;color:<?php echo $clr; ?>;font-weight:600;margin-top:2px"><?php echo $lbl; ?></div>
            </div>
            <?php if ($p['is_template']): ?>
            <span style="background:#fff7ed;color:#f97316;padding:2px 8px;border-radius:99px;font-size:.7rem;font-weight:700;white-space:nowrap"><i class="fas fa-star"></i> Template</span>
            <?php endif; ?>
          </div>
          <div style="display:flex;gap:12px;font-size:.78rem;color:#64748b;margin-bottom:12px;flex-wrap:wrap">
            <span><i class="fas fa-ruler-horizontal" style="color:<?php echo $clr; ?>"></i> <?php echo $L; ?>ft</span>
            <span><i class="fas fa-ruler-vertical" style="color:<?php echo $clr; ?>"></i> <?php echo $W; ?>ft</span>
            <span><i class="fas fa-arrows-alt-v" style="color:<?php echo $clr; ?>"></i> H:<?php echo $H; ?>ft</span>
            <span style="font-weight:700;color:#1e293b"><?php echo number_format($sqft); ?> sq.ft</span>
          </div>
          <?php if ($p['notes']): ?>
          <p style="font-size:.78rem;color:#94a3b8;margin-bottom:10px;line-height:1.5"><?php echo htmlspecialchars(substr($p['notes'],0,80)); ?>...</p>
          <?php endif; ?>
          <button onclick="event.stopPropagation();openPlanModal(<?php echo htmlspecialchars(json_encode($p)); ?>)"
                  style="width:100%;padding:8px;background:<?php echo $clr; ?>15;color:<?php echo $clr; ?>;border:1px solid <?php echo $clr; ?>40;border-radius:8px;font-size:.8rem;font-weight:600;cursor:pointer;transition:all .2s"
                  onmouseover="this.style.background='<?php echo $clr; ?>'" onmouseout="this.style.background='<?php echo $clr; ?>15';this.style.color='<?php echo $clr; ?>'">
            <i class="fas fa-expand"></i> View Full Plan &amp; Elevations
          </button>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <div style="text-align:center;margin-top:30px">
      <p style="color:var(--text-light);font-size:.88rem;margin-bottom:14px">Need a custom floor plan for your project?</p>
      <a href="tel:+91<?php echo SITE_PHONE; ?>" class="btn btn-primary">
        <i class="fas fa-phone-alt"></i> Call for Custom Plan
      </a>
    </div>
  </div>
</section>

<!-- Floor Plan Modal -->
<div id="plan-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.7);z-index:9999;overflow-y:auto;padding:20px">
  <div style="max-width:900px;margin:20px auto;background:#fff;border-radius:16px;overflow:hidden">
    <div style="padding:16px 20px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between">
      <div>
        <div id="modal-title" style="font-weight:800;font-size:1.1rem"></div>
        <div id="modal-type" style="font-size:.8rem;color:#64748b"></div>
      </div>
      <button onclick="closePlanModal()" style="background:none;border:none;font-size:1.4rem;cursor:pointer;color:#64748b;padding:4px">&times;</button>
    </div>
    <div style="padding:20px">
      <!-- Tabs -->
      <div style="display:flex;gap:8px;margin-bottom:16px">
        <button class="modal-tab active" onclick="switchModalView('mplan',this)" style="padding:7px 14px;border-radius:8px;font-size:.8rem;font-weight:600;cursor:pointer;border:none;background:#FF6B00;color:#fff;transition:all .2s">
          <i class="fas fa-map"></i> Plan View
        </button>
        <button class="modal-tab" onclick="switchModalView('melev-front',this)" style="padding:7px 14px;border-radius:8px;font-size:.8rem;font-weight:600;cursor:pointer;border:none;background:#f1f5f9;color:#64748b;transition:all .2s">
          <i class="fas fa-building"></i> Front Elevation
        </button>
        <button class="modal-tab" onclick="switchModalView('melev-side',this)" style="padding:7px 14px;border-radius:8px;font-size:.8rem;font-weight:600;cursor:pointer;border:none;background:#f1f5f9;color:#64748b;transition:all .2s">
          <i class="fas fa-sign"></i> Side Elevation
        </button>
      </div>
      <div id="mview-mplan"><svg id="modal-plan-svg" viewBox="0 0 800 500" xmlns="http://www.w3.org/2000/svg" style="width:100%;border:1px solid #e2e8f0;border-radius:8px;background:#f8fafc"></svg></div>
      <div id="mview-melev-front" style="display:none"><svg id="modal-elev-front-svg" viewBox="0 0 800 400" xmlns="http://www.w3.org/2000/svg" style="width:100%;border:1px solid #e2e8f0;border-radius:8px;background:#f8fafc"></svg></div>
      <div id="mview-melev-side" style="display:none"><svg id="modal-elev-side-svg" viewBox="0 0 800 400" xmlns="http://www.w3.org/2000/svg" style="width:100%;border:1px solid #e2e8f0;border-radius:8px;background:#f8fafc"></svg></div>
      <div id="modal-dims" style="margin-top:14px;background:#1e293b;color:#a3e635;font-family:monospace;font-size:.82rem;padding:12px 16px;border-radius:8px"></div>
    </div>
  </div>
</div>

<script>
// Reuse the same SVG rendering from admin (lightweight version for frontend)
function makeR(x,y,w,h,fill,stroke,sw,rx,op){return`<rect x="${x}" y="${y}" width="${w}" height="${h}" fill="${fill||'none'}" stroke="${stroke||'none'}" stroke-width="${sw||1}" rx="${rx||0}" opacity="${op||1}"/>`;}
function makeL(x1,y1,x2,y2,s,sw,d){return`<line x1="${x1}" y1="${y1}" x2="${x2}" y2="${y2}" stroke="${s||'#fff'}" stroke-width="${sw||1}" stroke-dasharray="${d||'none'}"/>`;}
function makeT(x,y,t,sz,f,a,fw){return`<text x="${x}" y="${y}" font-size="${sz||10}" fill="${f||'#1e293b'}" text-anchor="${a||'middle'}" font-weight="${fw||'normal'}" font-family="Inter,Arial,sans-serif">${t}</text>`;}
function makeC(cx,cy,r,f,s,sw){return`<circle cx="${cx}" cy="${cy}" r="${r}" fill="${f||'none'}" stroke="${s||'#fff'}" stroke-width="${sw||1.5}"/>`;}

function renderModalPlan(type, L, W, H) {
  const VW=800,VH=500,mg=60;
  const avW=VW-mg*2,avH=VH-mg*2;
  const sc=Math.min(avW/L,avH/W),pw=L*sc,ph=W*sc,ox=(VW-pw)/2,oy=(VH-ph)/2;
  const isCricket=type.startsWith('box-cricket')||type==='multi-lane';
  const isCage=type==='box-cricket-cage'||type==='box-cricket-rooftop';
  let s=`<defs><pattern id="g" patternUnits="userSpaceOnUse" width="20" height="20"><rect width="20" height="20" fill="#4ade80"/><line x1="0" y1="10" x2="20" y2="10" stroke="#3cb97b" stroke-width="0.4" opacity="0.5"/><line x1="10" y1="0" x2="10" y2="20" stroke="#3cb97b" stroke-width="0.4" opacity="0.5"/></pattern></defs>`;
  s+=makeR(0,0,VW,VH,'#e0f2fe');
  s+=makeR(ox,oy,pw,ph,'url(#g)','#16a34a',3,4);
  if(!isCricket){
    const cx=ox+pw/2,cy=oy+ph/2,cr=Math.min(ph*.16,pw*.08);
    s+=makeC(cx,cy,cr,'none','#fff',2);s+=makeC(cx,cy,3,'#fff','none');
    s+=makeL(cx,oy,cx,oy+ph,'#fff',2);
    const paW=pw*.12,paH=ph*.45,paY=oy+(ph-paH)/2;
    s+=makeR(ox,paY,paW,paH,'rgba(255,255,255,.08)','#fff',1.5);
    s+=makeR(ox+pw-paW,paY,paW,paH,'rgba(255,255,255,.08)','#fff',1.5);
    const gW=pw*.015,gH=ph*.1,gY=oy+(ph-gH)/2;
    s+=makeR(ox-gW,gY,gW,gH,'#fbbf24','#f59e0b',2,2);s+=makeR(ox+pw,gY,gW,gH,'#fbbf24','#f59e0b',2,2);
  } else if(type==='multi-lane'){
    const dvX=ox+pw/2;s+=makeL(dvX,oy,dvX,oy+ph,'#f97316',3,'6,3');
    [ox,ox+pw/2].forEach((lox,li)=>{const lw=pw/2,lh=ph,lcx=lox+lw/2,lcy=oy+lh/2,pLen=lh*.65,pWid=lw*.12;
      s+=makeR(lcx-pWid/2,lcy-pLen/2,pWid,pLen,'#a3e635','#65a30d',1.5,3);
      s+=makeL(lcx-pWid/2,lcy-pLen/2+pLen*.14,lcx+pWid/2,lcy-pLen/2+pLen*.14,'#fff',1.5);
      s+=makeL(lcx-pWid/2,lcy+pLen/2-pLen*.14,lcx+pWid/2,lcy+pLen/2-pLen*.14,'#fff',1.5);
    });
    s+=makeR(ox,oy,pw,ph,'none','#f97316',3,4);
  } else {
    const cx=ox+pw/2,cy=oy+ph/2,nw=8;
    s+=makeR(ox,oy,nw,ph,'#f97316','none',0,0,.5);s+=makeR(ox+pw-nw,oy,nw,ph,'#f97316','none',0,0,.5);
    s+=makeR(ox,oy,pw,nw,'#f97316','none',0,0,.5);s+=makeR(ox,oy+ph-nw,pw,nw,'#f97316','none',0,0,.5);
    if(isCage){s+=`<defs><pattern id="tn" patternUnits="userSpaceOnUse" width="12" height="12"><line x1="0" y1="0" x2="12" y2="12" stroke="#f97316" stroke-width=".8" opacity=".3"/><line x1="12" y1="0" x2="0" y2="12" stroke="#f97316" stroke-width=".8" opacity=".3"/></pattern></defs>`;s+=makeR(ox+nw,oy+nw,pw-nw*2,ph-nw*2,'url(#tn)','#f97316',1.5);}
    else{s+=makeR(ox+nw,oy+nw,pw-nw*2,ph-nw*2,'#4ade80','#16a34a',1.5);}
    const pLen=ph*.65,pWid=pw*.1;
    s+=makeR(cx-pWid/2,cy-pLen/2,pWid,pLen,'#a3e635','#65a30d',2,3);
    s+=makeL(cx-pWid/2,cy-pLen/2+pLen*.13,cx+pWid/2,cy-pLen/2+pLen*.13,'#fff',2);
    s+=makeL(cx-pWid/2,cy+pLen/2-pLen*.13,cx+pWid/2,cy+pLen/2-pLen*.13,'#fff',2);
    s+=makeR(ox,oy,pw,ph,'none','#f97316',3,4);
  }
  // Dimension labels
  s+=makeT(ox+pw/2,oy-10,L+'ft','11','#1e293b','middle','700');
  s+=makeT(ox-10,oy+ph/2,W+'ft','11','#1e293b','middle','700');
  s+=makeT(VW/2,VH-8,'Plan View  |  NetsDial Floor Plan','10','#94a3b8','middle');
  document.getElementById('modal-plan-svg').innerHTML=s;
}

function renderModalElevFront(type,L,W,H){
  const VW=800,VH=400,mg=60,gY=VH-60,avW=VW-mg*2,sc=avW/L,pw=L*sc,ph=H*sc,ox=(VW-pw)/2,oy=gY-ph;
  const isCage=type==='box-cricket-cage'||type==='box-cricket-rooftop';
  let s=`<defs><linearGradient id="sky3" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#bfdbfe"/><stop offset="100%" stop-color="#e0f2fe"/></linearGradient>
  <pattern id="msh" patternUnits="userSpaceOnUse" width="10" height="10"><line x1="0" y1="0" x2="10" y2="10" stroke="#f97316" stroke-width=".8" opacity=".5"/><line x1="10" y1="0" x2="0" y2="10" stroke="#f97316" stroke-width=".8" opacity=".5"/></pattern></defs>`;
  s+=makeR(0,0,VW,VH,'url(#sky3)');s+=makeR(0,gY,VW,VH-gY,'#a3e635');
  const pw2=8;s+=makeR(ox,oy,pw2,ph,'#1e293b');s+=makeR(ox+pw-pw2,oy,pw2,ph,'#1e293b');
  s+=makeR(ox+pw2,oy,pw-pw2*2,ph,'url(#msh)','#f97316',1.5);
  if(isCage)s+=makeR(ox,oy,pw,pw2,'#1e293b');
  s+=makeR(ox+pw2,gY-8,pw-pw2*2,8,'#4ade80','#16a34a',1.5);
  s+=makeL(0,gY,VW,gY,'#64748b',1.5,'4,3');
  s+=makeT(ox+pw/2,oy-8,'FRONT ELEVATION  |  Length: '+L+'ft × Height: '+H+'ft','11','#1e293b','middle','700');
  s+=makeT(ox+pw/2,gY+20,L+'ft','10','#64748b','middle','600');
  s+=makeT(ox-30,(oy+gY)/2,H+'ft','10','#64748b','middle','600');
  s+=makeT(ox+pw/2,oy+ph/2,'HDPE Net  |  MS Frame','10','#f97316','middle','700');
  s+=makeT(VW/2,VH-5,'Front Elevation  |  NetsDial by GCM Enterprises','9','#94a3b8','middle');
  document.getElementById('modal-elev-front-svg').innerHTML=s;
}

function renderModalElevSide(type,L,W,H){
  const VW=800,VH=400,gY=VH-60,avW=VW-120,sc=avW/W,pw=W*sc,ph=H*sc,ox=(VW-pw)/2,oy=gY-ph;
  const isCage=type==='box-cricket-cage'||type==='box-cricket-rooftop';
  let s=`<defs><linearGradient id="sky4" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#bfdbfe"/><stop offset="100%" stop-color="#e0f2fe"/></linearGradient>
  <pattern id="msh2" patternUnits="userSpaceOnUse" width="10" height="10"><line x1="0" y1="0" x2="10" y2="10" stroke="#f97316" stroke-width=".8" opacity=".5"/><line x1="10" y1="0" x2="0" y2="10" stroke="#f97316" stroke-width=".8" opacity=".5"/></pattern></defs>`;
  s+=makeR(0,0,VW,VH,'url(#sky4)');s+=makeR(0,gY,VW,VH-gY,'#a3e635');
  const pw2=8;s+=makeR(ox,oy,pw2,ph,'#1e293b');s+=makeR(ox+pw-pw2,oy,pw2,ph,'#1e293b');
  s+=makeR(ox+pw2,oy,pw-pw2*2,ph,'url(#msh2)','#f97316',1.5);
  if(isCage)s+=makeR(ox,oy,pw,pw2,'#1e293b');
  s+=makeR(ox+pw2,gY-8,pw-pw2*2,8,'#4ade80','#16a34a',1.5);
  s+=makeL(0,gY,VW,gY,'#64748b',1.5,'4,3');
  s+=makeT(ox+pw/2,oy-8,'SIDE ELEVATION  |  Width: '+W+'ft × Height: '+H+'ft','11','#1e293b','middle','700');
  s+=makeT(ox+pw/2,gY+20,W+'ft','10','#64748b','middle','600');
  s+=makeT(ox-30,(oy+gY)/2,H+'ft','10','#64748b','middle','600');
  s+=makeT(VW/2,VH-5,'Side Elevation  |  NetsDial by GCM Enterprises','9','#94a3b8','middle');
  document.getElementById('modal-elev-side-svg').innerHTML=s;
}

function openPlanModal(plan) {
  const type=plan.ground_type||'custom', L=parseFloat(plan.length_ft)||0, W=parseFloat(plan.width_ft)||0, H=parseFloat(plan.height_ft)||0;
  const labels={'football-5':'5-a-Side Football','football-6':'6-a-Side Football','football-7':'7-a-Side Football','football-9':'9-a-Side Football','football-11':'11-a-Side Football (FIFA)','box-cricket-cage':'Box Cricket – Full Cage','box-cricket-open':'Box Cricket – Open Top','box-cricket-rooftop':'Box Cricket – Rooftop','box-cricket-indoor':'Box Cricket – Indoor','multi-lane':'Multi-Lane Twin Setup','custom':'Custom Layout'};
  document.getElementById('modal-title').textContent = plan.title;
  document.getElementById('modal-type').textContent = labels[type] || type;
  document.getElementById('modal-dims').innerHTML = `📐 ${L}ft × ${W}ft | Height: ${H}ft | Area: ${(L*W).toLocaleString('en-IN')} sq.ft | Net perimeter walls: ~${(2*(L+W)*H).toFixed(0)} sq.ft`;
  renderModalPlan(type,L,W,H);
  renderModalElevFront(type,L,W,H);
  renderModalElevSide(type,L,W,H);
  document.getElementById('plan-modal').style.display='block';
  document.body.style.overflow='hidden';
  // Reset tabs
  document.querySelectorAll('.modal-tab').forEach((b,i)=>{b.style.background=i===0?'#FF6B00':'#f1f5f9';b.style.color=i===0?'#fff':'#64748b';});
  document.querySelectorAll('[id^="mview-"]').forEach((v,i)=>{v.style.display=i===0?'block':'none';});
}
function closePlanModal(){document.getElementById('plan-modal').style.display='none';document.body.style.overflow='';}
function switchModalView(view,btn){
  document.querySelectorAll('[id^="mview-"]').forEach(v=>v.style.display='none');
  document.getElementById('mview-'+view).style.display='block';
  document.querySelectorAll('.modal-tab').forEach(b=>{b.style.background='#f1f5f9';b.style.color='#64748b';});
  btn.style.background='#FF6B00';btn.style.color='#fff';
}
document.getElementById('plan-modal').addEventListener('click',function(e){if(e.target===this)closePlanModal();});
</script>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════════════
     SPORTS TURF SETUP GUIDE – Below Calculators
════════════════════════════════════════════════════════════════ -->
<section class="section" style="background:var(--light-gray);padding-top:60px;padding-bottom:60px">
  <div class="container">

    <div style="text-align:center;margin-bottom:48px" data-aos="fade-up">
      <span class="section-badge"><i class="fas fa-book-open"></i> Complete Setup Guide</span>
      <h2 style="margin:12px 0">Commercial Sports Turf – Types &amp; Configurations</h2>
      <p style="color:var(--text-light);max-width:680px;margin-inline:auto">
        When building commercial sports turf facilities, standard dimensions, player configurations, and
        setup variations dictate how grounds are designed and constructed. This guide helps you choose
        the right setup for your project and get the correct estimate.
      </p>
    </div>

    <!-- ACCORDION TABS -->
    <div class="estimation-tabs" role="tablist" style="margin-bottom:32px">
      <button class="estimation-tab active" data-tab="guide-football" role="tab">
        <i class="fas fa-futbol"></i> Football Turf Types
      </button>
      <button class="estimation-tab" data-tab="guide-cricket" role="tab">
        <i class="fas fa-baseball-ball"></i> Box Cricket Setups
      </button>
      <button class="estimation-tab" data-tab="guide-spec" role="tab">
        <i class="fas fa-table"></i> Turf Specifications
      </button>
    </div>

    <!-- ─── TAB: Football Turf Types ─── -->
    <div class="estimation-panel active" id="guide-football">
      <div style="background:#fff;border:1px solid var(--border);border-radius:var(--radius-xl);padding:36px">

        <h3 style="margin-bottom:6px"><i class="fas fa-futbol" style="color:#16a34a"></i> Types of Football Turf Grounds</h3>
        <p style="color:var(--text-light);margin-bottom:28px">
          Football turfs are classified by the number of players per side, pitch size, and operational design.
          <strong>7-a-side</strong> is the most popular commercial model, but several formats exist to suit different spaces.
        </p>

        <h5 style="font-weight:700;margin-bottom:16px;text-transform:uppercase;font-size:.8rem;letter-spacing:.08em;color:var(--text-light)">Standard Formats (By Size &amp; Capacity)</h5>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(270px,1fr));gap:16px;margin-bottom:32px">
          <?php
          $football_guide = [
            ['5-a-Side (Futsal)', '#3b82f6', 'fas fa-users',
             '~15m × 25m – 20m × 30m', '4,000 – 6,500 sq.ft.',
             'Highly popular in urban centres with space constraints. High turnover, faster gameplay, lower installation and lighting costs.'],
            ['6-a-Side Turf', '#8b5cf6', 'fas fa-users',
             '~20m × 35m – 22m × 40m', '7,500 – 9,500 sq.ft.',
             'Middle-ground solution for spaces slightly too small for a standard 7-a-side pitch.'],
            ['7-a-Side (Standard)', '#f59e0b', 'fas fa-star',
             '~30m × 50m – 35m × 55m', '16,000 – 21,000 sq.ft.',
             'Most commercially lucrative for recreational leagues and corporate bookings. Recommended first choice.'],
            ['8/9-a-Side Turf', '#ec4899', 'fas fa-users',
             '~40m × 60m – 45m × 65m', '25,000 – 32,000 sq.ft.',
             'Built by semi-professional academies and large sports complexes for extended squads.'],
            ['11-a-Side (FIFA)', '#dc2626', 'fas fa-trophy',
             '~68m × 105m', '70,000+ sq.ft.',
             'Professional stadiums, official academy grounds and official tournament facilities. Full FIFA standard.'],
          ];
          foreach ($football_guide as $fg): ?>
          <div style="border:1px solid var(--border);border-radius:var(--radius-lg);padding:18px;position:relative;overflow:hidden;background:#fff">
            <div style="position:absolute;top:0;right:0;width:56px;height:56px;background:<?php echo $fg[1]; ?>;opacity:.1;border-radius:0 var(--radius-lg) 0 100%"></div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px">
              <div style="width:36px;height:36px;background:<?php echo $fg[1]; ?>;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:.9rem;flex-shrink:0"><i class="<?php echo $fg[2]; ?>"></i></div>
              <div style="font-weight:800;font-size:.92rem"><?php echo $fg[0]; ?></div>
            </div>
            <div style="font-size:.8rem;font-weight:700;color:var(--text-dark);margin-bottom:4px"><?php echo $fg[3]; ?></div>
            <div style="font-size:.75rem;color:<?php echo $fg[1]; ?>;font-weight:600;margin-bottom:8px"><?php echo $fg[4]; ?></div>
            <p style="font-size:.8rem;color:var(--text-light);margin:0;line-height:1.6"><?php echo $fg[5]; ?></p>
          </div>
          <?php endforeach; ?>
        </div>

        <h5 style="font-weight:700;margin-bottom:16px">Operational &amp; Modular Variations</h5>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:14px">
          <div style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);border:1px solid #86efac;border-radius:var(--radius-lg);padding:20px">
            <div style="font-weight:700;color:#16a34a;margin-bottom:8px"><i class="fas fa-divide"></i> &nbsp;Multi-Divisible Turf (Modular Partition)</div>
            <p style="font-size:.82rem;margin:0;color:#15803d;line-height:1.65">
              A large 7-a-side or 9-a-side field built with <strong>retractable dividing net systems</strong>.
              One ground splits into two 5-a-side pitches simultaneously — doubles booking potential during peak hours.
            </p>
          </div>
          <div style="background:linear-gradient(135deg,#fefce8,#fef9c3);border:1px solid #fde047;border-radius:var(--radius-lg);padding:20px">
            <div style="font-weight:700;color:#ca8a04;margin-bottom:8px"><i class="fas fa-layer-group"></i> &nbsp;Multi-Sport Hybrid Turf</div>
            <p style="font-size:.82rem;margin:0;color:#92400e;line-height:1.65">
              Fields marked for football <em>and</em> box cricket with multi-colored line markings — white for football,
              yellow/red for cricket crease lines. Maximizes a single turf installation's earning potential.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- ─── TAB: Box Cricket Setup Types ─── -->
    <div class="estimation-panel" id="guide-cricket">
      <div style="background:#fff;border:1px solid var(--border);border-radius:var(--radius-xl);padding:36px">

        <h3 style="margin-bottom:6px"><i class="fas fa-baseball-ball" style="color:#f97316"></i> Types of Box Cricket Setups</h3>
        <p style="color:var(--text-light);margin-bottom:28px">
          Box cricket setups vary by structural design, enclosure layout, turf selection, and underlying infrastructure.
          Choose the right configuration based on your available space and target usage.
        </p>

        <!-- A. Structural -->
        <h5 style="font-weight:700;margin-bottom:16px;border-left:4px solid #f97316;padding-left:10px">A. By Structural &amp; Frame Setup</h5>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:14px;margin-bottom:32px">
          <?php
          $bc_structures = [
            ['Full Cage Box Setup', 'fas fa-cube', '#f97316', 'Top Covered',
             'Fully enclosed on all 4 sides and completely roofed with high-density netting (40mm–50mm square mesh).',
             'Ball entirely contained. Ideal for high-density commercial spaces or multi-story rooftops.'],
            ['Open-Top / High-Wall', 'fas fa-arrows-alt-v', '#0ea5e9', 'No Roof Net',
             'High side walls (20ft–30ft nets) without a top net cover.',
             'Feels more open for high-lofted shots. Requires larger perimeter buffer to prevent lost balls.'],
            ['Rooftop Box Setup', 'fas fa-home', '#8b5cf6', 'Terrace Build',
             'Built on commercial terraces using lightweight MS/GI pipe framing with chemical anchoring — no roof penetration.',
             'Maximizes unused terrace space with minimal structural modifications.'],
            ['Indoor / Warehouse', 'fas fa-warehouse', '#10b981', 'Climate Controlled',
             'Built inside industrial sheds using truss structures and ceiling suspension netting systems.',
             'Year-round, climate-controlled play — no rain or heat disruptions.'],
          ];
          foreach ($bc_structures as $bcs): ?>
          <div style="border:1px solid var(--border);border-radius:var(--radius-lg);padding:18px;background:#fff">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px">
              <div style="width:36px;height:36px;background:<?php echo $bcs[2]; ?>;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:.9rem;flex-shrink:0"><i class="<?php echo $bcs[1]; ?>"></i></div>
              <div>
                <div style="font-weight:800;font-size:.88rem"><?php echo $bcs[0]; ?></div>
                <div style="font-size:.7rem;color:<?php echo $bcs[2]; ?>;font-weight:600;text-transform:uppercase"><?php echo $bcs[3]; ?></div>
              </div>
            </div>
            <p style="font-size:.8rem;color:var(--text-dark);margin-bottom:8px"><?php echo $bcs[4]; ?></p>
            <p style="font-size:.78rem;color:var(--text-light);margin:0"><i class="fas fa-check" style="color:<?php echo $bcs[2]; ?>"></i> <?php echo $bcs[5]; ?></p>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- B. Pitch layout -->
        <h5 style="font-weight:700;margin-bottom:16px;border-left:4px solid #f97316;padding-left:10px">B. By Pitch &amp; Outfield Layout</h5>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:14px">
          <div style="border:1px solid #fed7aa;border-radius:var(--radius-lg);padding:18px;background:#fff7ed">
            <div style="font-weight:700;color:#ea580c;margin-bottom:8px"><i class="fas fa-circle"></i> &nbsp;Single Central Pitch Layout</div>
            <p style="font-size:.82rem;margin:0;line-height:1.65;color:#7c2d12">
              A single central pitch (20–22 yards length) centred inside a standard 50ft×80ft or 60ft×100ft netted arena.
              Synthetic grass covers both the pitch and outfield.
            </p>
          </div>
          <div style="border:1px solid #bbf7d0;border-radius:var(--radius-lg);padding:18px;background:#f0fdf4">
            <div style="font-weight:700;color:#16a34a;margin-bottom:8px"><i class="fas fa-columns"></i> &nbsp;Multi-Lane / Twin Setup</div>
            <p style="font-size:.82rem;margin:0;line-height:1.65;color:#14532d">
              Two or more parallel box cricket grounds sharing a central dividing net partition.
              Optimizes land usage and shared lighting infrastructure — maximizes revenue per square foot.
            </p>
          </div>
          <div style="border:1px solid #c7d2fe;border-radius:var(--radius-lg);padding:18px;background:#eef2ff">
            <div style="font-weight:700;color:#4f46e5;margin-bottom:8px"><i class="fas fa-layer-group"></i> &nbsp;Dual-Turf System (Differentiated)</div>
            <p style="font-size:.82rem;margin-bottom:6px;line-height:1.65;color:#312e81">
              <strong>Pitch:</strong> High-density 12mm–15mm non-infill curly grass on concrete for true ball bounce &amp; seam movement.
            </p>
            <p style="font-size:.82rem;margin:0;line-height:1.65;color:#312e81">
              <strong>Outfield:</strong> 25mm–40mm sports turf with rubber granule + silica sand infill for player cushioning.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- ─── TAB: Turf Specs ─── -->
    <div class="estimation-panel" id="guide-spec">
      <div style="background:#fff;border:1px solid var(--border);border-radius:var(--radius-xl);padding:36px">

        <h3 style="margin-bottom:6px"><i class="fas fa-table" style="color:#0ea5e9"></i> Turf Specification &amp; Infill Comparison</h3>
        <p style="color:var(--text-light);margin-bottom:28px">
          Choosing the right turf type depends on your sport, usage frequency, and ground conditions.
          All Russea™ HDPE sports nets are compatible with every turf type listed below.
        </p>

        <div style="overflow-x:auto;border-radius:var(--radius-lg);border:1px solid var(--border);margin-bottom:24px">
          <table style="width:100%;border-collapse:collapse;font-size:.88rem">
            <thead>
              <tr style="background:linear-gradient(135deg,#1e293b,#334155);color:#fff">
                <th style="padding:16px 20px;text-align:left;font-weight:600">Turf Type</th>
                <th style="padding:16px 20px;text-align:left;font-weight:600">Fiber Height</th>
                <th style="padding:16px 20px;text-align:left;font-weight:600">Primary Infill</th>
                <th style="padding:16px 20px;text-align:left;font-weight:600">Best For</th>
              </tr>
            </thead>
            <tbody>
              <tr style="border-bottom:1px solid var(--border)">
                <td style="padding:16px 20px;font-weight:700;color:#16a34a"><i class="fas fa-leaf"></i> &nbsp;Monofilament Grass</td>
                <td style="padding:16px 20px">40mm – 50mm</td>
                <td style="padding:16px 20px">Silica Sand + SBR Rubber</td>
                <td style="padding:16px 20px"><span style="background:#dcfce7;color:#16a34a;padding:4px 12px;border-radius:99px;font-size:.8rem;font-weight:600">Football &amp; Multi-Sport</span></td>
              </tr>
              <tr style="border-bottom:1px solid var(--border);background:#f8f9fa">
                <td style="padding:16px 20px;font-weight:700;color:#f97316"><i class="fas fa-leaf"></i> &nbsp;Fibrillated Grass</td>
                <td style="padding:16px 20px">30mm – 40mm</td>
                <td style="padding:16px 20px">Silica Sand + SBR Rubber</td>
                <td style="padding:16px 20px"><span style="background:#fff7ed;color:#f97316;padding:4px 12px;border-radius:99px;font-size:.8rem;font-weight:600">High-Traffic Cricket Outfields</span></td>
              </tr>
              <tr>
                <td style="padding:16px 20px;font-weight:700;color:#0ea5e9"><i class="fas fa-leaf"></i> &nbsp;Non-Infill Curly Grass</td>
                <td style="padding:16px 20px">12mm – 15mm</td>
                <td style="padding:16px 20px">None (Direct Stick on Concrete)</td>
                <td style="padding:16px 20px"><span style="background:#e0f2fe;color:#0ea5e9;padding:4px 12px;border-radius:99px;font-size:.8rem;font-weight:600">Fast Cricket Batting Pitches</span></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);border:1px solid #86efac;border-radius:var(--radius-md);padding:16px;display:flex;gap:14px;align-items:flex-start">
          <i class="fas fa-info-circle" style="color:#16a34a;font-size:1.2rem;margin-top:2px;flex-shrink:0"></i>
          <div>
            <strong style="color:#15803d">SBR = Styrene-Butadiene Rubber</strong>
            <p style="margin:4px 0 0;font-size:.82rem;color:#14532d;line-height:1.6">
              SBR rubber granules act as a shock-absorption infill layer beneath the artificial grass blades.
              Combined with silica sand for stability, SBR infill reduces player injury risk, improves ball bounce consistency,
              and extends the turf lifespan in high-traffic commercial installations.
            </p>
          </div>
        </div>

        <div style="margin-top:24px;text-align:center">
          <p style="color:var(--text-light);font-size:.9rem;margin-bottom:16px">Not sure which turf type suits your project?</p>
          <a href="tel:+91<?php echo SITE_PHONE; ?>" class="btn btn-primary" style="margin-right:12px">
            <i class="fas fa-phone-alt"></i> Call for Expert Advice
          </a>
          <a href="<?php echo SITE_URL; ?>/contact.php" class="btn btn-outline-primary">
            <i class="fas fa-envelope"></i> Send Requirements
          </a>
        </div>
      </div>
    </div>

  </div>
</section>
<!-- ═══════════════════════════════════════════════════════════════ -->

<?php include __DIR__ . '/includes/footer.php'; ?>
