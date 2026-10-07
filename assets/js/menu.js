/**
 * NetsDial - Responsive Mega Menu JavaScript
 * High-Converting Categorized Catalog + Instant Zero-Lag State & City Switcher
 */
(function () {
  'use strict';

  // ── DOM References ──────────────────────────────────────
  const stateSelect    = document.getElementById('megaStateSelect');
  const cityGrid       = document.getElementById('megaCityGrid');
  const citySearch     = document.getElementById('megaCitySearch');
  const stateHubLink   = document.getElementById('stateHubLink');
  const stateHubName   = document.getElementById('stateHubName');
  const navToggle      = document.getElementById('navToggle');
  const mainNav        = document.getElementById('mainNav');
  const navOverlay     = document.getElementById('navOverlay');
  const hasMegaItem    = document.querySelector('.has-mega');
  const siteHeader     = document.getElementById('siteHeader');

  // ── Load Pre-rendered District Data ─────────────────────
  let districtsByState = {};
  const dataEl = document.getElementById('megaDistrictsData');
  if (dataEl) {
    try {
      districtsByState = JSON.parse(dataEl.textContent);
    } catch (e) {
      console.error('Failed to parse megaDistrictsData', e);
    }
  }

  const siteUrl = (typeof SITE_CONFIG !== 'undefined' && SITE_CONFIG.siteUrl) ? SITE_CONFIG.siteUrl : '';

  // ── Render Cities for a Given State ─────────────────────
  function renderCities(stateName, filterQuery) {
    if (!cityGrid) return;
    const q = (filterQuery || '').trim().toLowerCase();

    // If searching across all cities
    if (q) {
      let matches = [];
      for (const [st, list] of Object.entries(districtsByState)) {
        for (const city of list) {
          if (city.n.toLowerCase().includes(q) || city.s.includes(q)) {
            matches.push({ ...city, state: st });
          }
        }
      }

      if (matches.length === 0) {
        cityGrid.innerHTML = '<div style="grid-column:1/-1;padding:20px;text-align:center;color:#9CA3AF;font-size:.8rem">No cities found matching "' + q.replace(/[<>]/g, '') + '"</div>';
        return;
      }

      cityGrid.innerHTML = matches.slice(0, 36).map(city => `
        <a href="${siteUrl}/services.php?district=${city.s}" class="city-pill" title="${city.n}, ${city.state}">
          <i class="fas fa-map-marker-alt"></i>
          <span>${city.n}</span>
          <span class="city-state-badge">${city.state.substring(0, 8)}</span>
        </a>
      `).join('');

      if (stateHubName) stateHubName.textContent = `Search (${matches.length} matches)`;
      if (stateHubLink) stateHubLink.href = `${siteUrl}/services.php`;
      return;
    }

    // Default: render for active state
    const cities = districtsByState[stateName] || [];
    if (cities.length === 0) {
      cityGrid.innerHTML = '<div style="grid-column:1/-1;padding:20px;text-align:center;color:#9CA3AF;font-size:.8rem">No cities configured for ' + stateName + '</div>';
      return;
    }

    cityGrid.innerHTML = cities.map(city => `
      <a href="${siteUrl}/services.php?district=${city.s}" class="city-pill" title="Russea Nets in ${city.n}, ${stateName}">
        <i class="fas fa-map-marker-alt"></i>
        <span>${city.n}</span>
      </a>
    `).join('');

    if (stateHubName) stateHubName.textContent = stateName;
    if (stateHubLink) stateHubLink.href = `${siteUrl}/services.php`;
  }

  // ── Init State & Search Events ──────────────────────────
  if (stateSelect) {
    stateSelect.addEventListener('change', function () {
      if (citySearch) citySearch.value = '';
      renderCities(this.value);
    });
    // Initial render for default selected state (Telangana)
    renderCities(stateSelect.value || 'Telangana');
  }

  if (citySearch) {
    citySearch.addEventListener('input', function () {
      const q = this.value.trim();
      if (q) {
        renderCities('', q);
      } else {
        renderCities(stateSelect ? stateSelect.value : 'Telangana');
      }
    });
  }

  // ── Mobile Navigation Drawer ────────────────────────────
  if (navToggle && mainNav) {
    navToggle.addEventListener('click', () => {
      const isOpen = mainNav.classList.toggle('open');
      navToggle.classList.toggle('open', isOpen);
      if (navOverlay) navOverlay.classList.toggle('open', isOpen);
      document.body.style.overflow = isOpen ? 'hidden' : '';
    });
  }
  if (navOverlay) {
    navOverlay.addEventListener('click', closeMobileNav);
  }

  // ── Desktop Hover & Click Toggle ───────────────────────
  if (hasMegaItem) {
    hasMegaItem.addEventListener('mouseenter', () => {
      if (window.innerWidth > 1100) {
        hasMegaItem.classList.add('mega-open');
      }
    });
    hasMegaItem.addEventListener('mouseleave', () => {
      if (window.innerWidth > 1100) {
        hasMegaItem.classList.remove('mega-open');
      }
    });

    // Arrow click toggle (both desktop & mobile)
    const arrowIcon = hasMegaItem.querySelector('.arrow-icon');
    if (arrowIcon) {
      arrowIcon.addEventListener('click', e => {
        e.preventDefault();
        e.stopPropagation();
        if (window.innerWidth <= 1100) {
          hasMegaItem.classList.toggle('mobile-open');
        } else {
          hasMegaItem.classList.toggle('mega-open');
        }
      });
    }

    // Mobile nav link click
    const megaNavLink = hasMegaItem.querySelector('.nav-link');
    if (megaNavLink) {
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
  });

  function closeMobileNav() {
    if (mainNav) mainNav.classList.remove('open');
    if (navToggle) navToggle.classList.remove('open');
    if (navOverlay) navOverlay.classList.remove('open');
    document.body.style.overflow = '';
  }

  // ── Header Scroll Effect ────────────────────────────────
  if (siteHeader) {
    window.addEventListener('scroll', () => {
      siteHeader.classList.toggle('scrolled', window.scrollY > 50);
    }, { passive: true });
  }

  // ── Close mega menu on outside click or ESC ─────────────
  document.addEventListener('click', e => {
    if (!e.target.closest('.has-mega')) {
      if (hasMegaItem) hasMegaItem.classList.remove('mega-open');
    }
  });

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
      closeMobileNav();
      if (hasMegaItem) hasMegaItem.classList.remove('mega-open', 'mobile-open');
    }
  });

})();
