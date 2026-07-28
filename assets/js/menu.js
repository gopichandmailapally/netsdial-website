/**
 * NetsDial - 4-Level Mega Menu JavaScript
 * AJAX-powered district → area → keyword navigation
 * Fixed: Smooth switching between dropdown columns
 */
(function () {
  'use strict';

  // ── State ───────────────────────────────────────────────
  let activeDistrictId   = null;
  let activeAreaId       = null;
  let activeDistrictSlug = null;
  let activeAreaSlug     = null;
  let districtTimeout    = null;
  let areaTimeout        = null;
  const areaCache        = {};
  const keywordList      = {}; // pre-populated with all 19 keywords

  const KEYWORDS = [
    { name: 'Pigeon Netting',              slug: 'pigeon-netting',              icon: 'fa-dove' },
    { name: 'Bird Netting',                slug: 'bird-netting',                icon: 'fa-crow' },
    { name: 'Anti Bird Nets',              slug: 'anti-bird-nets',              icon: 'fa-ban' },
    { name: 'Balcony Safety Nets',         slug: 'balcony-safety-nets',         icon: 'fa-shield-alt' },
    { name: 'Children Safety Nets',        slug: 'children-safety-nets',        icon: 'fa-child' },
    { name: 'Pigeon Spikes',               slug: 'pigeon-spikes',               icon: 'fa-grip-lines' },
    { name: 'Anti Bird Spikes',            slug: 'anti-bird-spikes',            icon: 'fa-thumbtack' },
    { name: 'Polycarbonate Spikes',        slug: 'polycarbonate-spikes',        icon: 'fa-project-diagram' },
    { name: 'SS Bird Spikes',              slug: 'ss-bird-spikes',              icon: 'fa-bars' },
    { name: 'Invisible Grills',            slug: 'invisible-grills',            icon: 'fa-border-all' },
    { name: 'SS Invisible Grills',         slug: 'ss-invisible-grills',         icon: 'fa-grip-vertical' },
    { name: 'Cloth Hangers Installation',  slug: 'cloth-hangers-installation',  icon: 'fa-tshirt' },
    { name: 'SS Cloth Hangers',            slug: 'ss-cloth-hangers',            icon: 'fa-arrows-alt-h' },
    { name: 'Artificial Grass',            slug: 'artificial-grass',            icon: 'fa-leaf' },
    { name: 'Artificial Turf',             slug: 'artificial-turf',             icon: 'fa-football-ball' },
    { name: 'Cricket Ground Pitch Turf',   slug: 'cricket-ground-pitch-turf',   icon: 'fa-baseball-ball' },
    { name: 'Sports Practice Nets',        slug: 'sports-practice-nets',        icon: 'fa-table-tennis' },
    { name: 'Box Cricket Nets',            slug: 'box-cricket-nets',            icon: 'fa-th' },
    { name: 'Box Cricket Setup',           slug: 'box-cricket-setup',           icon: 'fa-building' },
  ];

  // ── DOM Elements ────────────────────────────────────────
  const districtList  = document.getElementById('districtList');
  const areaListEl    = document.getElementById('areaList');
  const keywordListEl = document.getElementById('keywordList');
  const megaMenu      = document.getElementById('megaMenu');
  const navToggle     = document.getElementById('navToggle');
  const mainNav       = document.getElementById('mainNav');
  const navOverlay    = document.getElementById('navOverlay');
  const hasMegaItem   = document.querySelector('.has-mega');
  const siteHeader    = document.getElementById('siteHeader');

  // ── Render Keywords ─────────────────────────────────────
  function renderKeywords(districtSlug, areaSlug) {
    if (!areaSlug) return;
    const siteUrl = (typeof SITE_CONFIG !== 'undefined') ? SITE_CONFIG.siteUrl : '';
    keywordListEl.innerHTML = KEYWORDS.map(kw => `
      <li class="keyword-link-item">
        <a href="${siteUrl}/services/${districtSlug}/${areaSlug}/${kw.slug}/">
          <i class="fas ${kw.icon}"></i>${kw.name}
        </a>
      </li>
    `).join('');
  }

  // ── Load Areas via AJAX ──────────────────────────────────
  function loadAreas(districtId, districtSlug, callback) {
    if (areaCache[districtId]) {
      callback(areaCache[districtId], districtSlug);
      return;
    }
    const siteUrl = (typeof SITE_CONFIG !== 'undefined') ? SITE_CONFIG.siteUrl : '';
    areaListEl.innerHTML = '<li class="mega-loading"><span class="spinner" style="border-color:rgba(0,0,0,.15);border-top-color:var(--primary)"></span> Loading…</li>';
    keywordListEl.innerHTML = '<li class="keyword-placeholder"><i class="fas fa-arrow-left"></i> Select an area</li>';

    fetch(`${siteUrl}/api/menu.php?action=areas&district_id=${districtId}`)
      .then(r => r.json())
      .then(data => {
        areaCache[districtId] = data;
        callback(data, districtSlug);
      })
      .catch(() => {
        areaListEl.innerHTML = '<li class="area-placeholder">Error loading areas</li>';
      });
  }

  // ── Render Areas ─────────────────────────────────────────
  function renderAreas(areas, districtSlug) {
    if (!areas || areas.length === 0) {
      areaListEl.innerHTML = '<li class="area-placeholder">No areas found</li>';
      return;
    }
    areaListEl.innerHTML = areas.map(a => `
      <li class="area-item"
          data-area-slug="${a.slug}"
          data-area-id="${a.id}">
        <span>${a.name}</span>
        <i class="fas fa-chevron-right"></i>
      </li>
    `).join('');

    // Bind area hover/click
    areaListEl.querySelectorAll('.area-item').forEach(item => {
      item.addEventListener('mouseenter', () => handleAreaHover(item, districtSlug));
      item.addEventListener('click',      () => handleAreaClick(item, districtSlug));
    });

    // Auto-activate first area
    const first = areaListEl.querySelector('.area-item');
    if (first) handleAreaHover(first, districtSlug);
  }

  // ── Handle District Hover ────────────────────────────────
  function handleDistrictHover(item) {
    const districtId   = item.dataset.districtId;
    const districtSlug = item.dataset.districtSlug;

    if (districtId === activeDistrictId) return;

    // Clear any pending timer
    clearTimeout(districtTimeout);

    // Debounce slightly (80ms) to prevent flicker on fast mouse movement
    districtTimeout = setTimeout(() => {
      // Update active state
      districtList.querySelectorAll('.district-item').forEach(d => d.classList.remove('active'));
      item.classList.add('active');
      activeDistrictId   = districtId;
      activeDistrictSlug = districtSlug;
      activeAreaId       = null;
      activeAreaSlug     = null;

      keywordListEl.innerHTML = '<li class="keyword-placeholder"><i class="fas fa-arrow-left"></i> Select an area</li>';
      loadAreas(districtId, districtSlug, renderAreas);
    }, 80);
  }

  // ── Handle Area Hover ─────────────────────────────────────
  function handleAreaHover(item, districtSlug) {
    const areaSlug = item.dataset.areaSlug;
    if (areaSlug === activeAreaSlug) return;

    clearTimeout(areaTimeout);
    areaTimeout = setTimeout(() => {
      areaListEl.querySelectorAll('.area-item').forEach(a => a.classList.remove('active'));
      item.classList.add('active');
      activeAreaSlug = areaSlug;
      activeAreaId   = item.dataset.areaId;
      renderKeywords(districtSlug || activeDistrictSlug, areaSlug);
    }, 60);
  }

  // ── Handle Area Click (mobile / keyboard) ────────────────
  function handleAreaClick(item, districtSlug) {
    handleAreaHover(item, districtSlug);
  }

  // ── Init District Events ──────────────────────────────────
  if (districtList) {
    districtList.querySelectorAll('.district-item').forEach(item => {
      item.addEventListener('mouseenter', () => handleDistrictHover(item));
      item.addEventListener('click',      () => handleDistrictHover(item));
    });

    // Auto-load first district on menu open
    const firstDistrict = districtList.querySelector('.district-item');
    if (firstDistrict) {
      firstDistrict.classList.add('active');
      const dId   = firstDistrict.dataset.districtId;
      const dSlug = firstDistrict.dataset.districtSlug;
      activeDistrictId   = dId;
      activeDistrictSlug = dSlug;
      loadAreas(dId, dSlug, renderAreas);
    }
  }

  // ── Mobile Navigation Toggle ──────────────────────────────
  if (navToggle && mainNav) {
    navToggle.addEventListener('click', () => {
      const isOpen = mainNav.classList.toggle('open');
      navToggle.classList.toggle('open', isOpen);
      navOverlay.classList.toggle('open', isOpen);
      document.body.style.overflow = isOpen ? 'hidden' : '';
    });
  }
  if (navOverlay) {
    navOverlay.addEventListener('click', closeMobileNav);
  }

  // ── Mobile Mega Toggle ────────────────────────────────────
  if (hasMegaItem) {
    const megaNavLink = hasMegaItem.querySelector('.nav-link');
    if (megaNavLink && window.innerWidth <= 1100) {
      megaNavLink.addEventListener('click', e => {
        if (window.innerWidth <= 1100) {
          e.preventDefault();
          hasMegaItem.classList.toggle('mobile-open');
        }
      });
    }
  }
  window.addEventListener('resize', () => {
    if (window.innerWidth > 1100) {
      closeMobileNav();
    }
    // Re-bind mobile mega toggle
    if (hasMegaItem) {
      const link = hasMegaItem.querySelector('.nav-link');
      if (link) {
        link.onclick = window.innerWidth <= 1100
          ? (e) => { e.preventDefault(); hasMegaItem.classList.toggle('mobile-open'); }
          : null;
      }
    }
  });

  function closeMobileNav() {
    if (mainNav) mainNav.classList.remove('open');
    if (navToggle) navToggle.classList.remove('open');
    if (navOverlay) navOverlay.classList.remove('open');
    document.body.style.overflow = '';
  }

  // ── Header Scroll Effect ──────────────────────────────────
  if (siteHeader) {
    window.addEventListener('scroll', () => {
      siteHeader.classList.toggle('scrolled', window.scrollY > 50);
    }, { passive: true });
  }

  // ── Close mega menu on outside click ─────────────────────
  document.addEventListener('click', e => {
    if (!e.target.closest('.has-mega')) {
      if (hasMegaItem) hasMegaItem.classList.remove('mega-open');
    }
  });

  // ── Keyboard accessibility ────────────────────────────────
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
      closeMobileNav();
      if (hasMegaItem) hasMegaItem.classList.remove('mega-open', 'mobile-open');
    }
  });

  // ── Expose for external use ───────────────────────────────
  window.NetsDial = window.NetsDial || {};
  window.NetsDial.menu = { loadAreas, renderAreas, renderKeywords };

})();
