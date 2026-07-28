/**
 * NetsDial - Main JavaScript
 * Hero Slider, Animations, Lightbox, FAQ, Counter, Reviews
 */
(function () {
  'use strict';

  // ── Hero Swiper Slider ────────────────────────────────────
  if (document.querySelector('.hero-swiper')) {
    new Swiper('.hero-swiper', {
      loop: true,
      autoplay: { delay: 5500, disableOnInteraction: false, pauseOnMouseEnter: true },
      effect: 'fade',
      fadeEffect: { crossFade: true },
      speed: 900,
      pagination: { el: '.swiper-pagination', clickable: true },
      navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
      on: {
        slideChangeTransitionStart() {
          const slides = document.querySelectorAll('.swiper-slide');
          slides.forEach(s => s.querySelectorAll('.slide-badge,.slide-title,.slide-text,.slide-btns')
            .forEach(el => { el.style.animation = 'none'; el.offsetHeight; el.style.animation = ''; }));
        }
      }
    });
  }

  // ── Review Swiper ─────────────────────────────────────────
  if (document.querySelector('.reviews-swiper')) {
    new Swiper('.reviews-swiper', {
      slidesPerView: 1,
      spaceBetween: 24,
      loop: true,
      autoplay: { delay: 4000, disableOnInteraction: false },
      pagination: { el: '.reviews-swiper-pagination', clickable: true },
      breakpoints: {
        600:  { slidesPerView: 2 },
        1024: { slidesPerView: 3 },
      }
    });
  }

  // ── FAQ Accordion ─────────────────────────────────────────
  document.querySelectorAll('.faq-question').forEach(q => {
    q.addEventListener('click', () => {
      const item = q.closest('.faq-item');
      const isOpen = item.classList.contains('open');
      // Close all
      document.querySelectorAll('.faq-item.open').forEach(i => i.classList.remove('open'));
      if (!isOpen) item.classList.add('open');
    });
  });

  // ── Gallery Lightbox ──────────────────────────────────────
  const lightbox = document.getElementById('lightbox');
  const lightboxImg = lightbox ? lightbox.querySelector('img') : null;

  document.querySelectorAll('.gallery-item').forEach(item => {
    item.addEventListener('click', () => {
      const img = item.querySelector('img');
      if (lightbox && lightboxImg && img) {
        lightboxImg.src = img.src;
        lightboxImg.alt = img.alt;
        lightbox.classList.add('open');
        document.body.style.overflow = 'hidden';
      }
    });
  });
  if (lightbox) {
    lightbox.addEventListener('click', e => {
      if (e.target === lightbox || e.target.classList.contains('lightbox-close')) {
        lightbox.classList.remove('open');
        document.body.style.overflow = '';
      }
    });
  }

  // ── Animated Counter ──────────────────────────────────────
  function animateCounter(el, from, to, duration) {
    const start = performance.now();
    const update = (time) => {
      const progress = Math.min((time - start) / duration, 1);
      const ease = 1 - Math.pow(1 - progress, 3);
      el.textContent = Math.floor(from + (to - from) * ease).toLocaleString('en-IN');
      if (progress < 1) requestAnimationFrame(update);
    };
    requestAnimationFrame(update);
  }

  const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const el = entry.target;
        const target = parseInt(el.dataset.target || el.textContent.replace(/,/g, ''), 10);
        if (!isNaN(target)) animateCounter(el, 0, target, 2000);
        counterObserver.unobserve(el);
      }
    });
  }, { threshold: 0.5 });

  document.querySelectorAll('.stat-number, .stat-num[data-target]').forEach(el => {
    const val = el.textContent.replace(/[^0-9]/g, '');
    if (val) { el.dataset.target = val; counterObserver.observe(el); }
  });

  // ── Coupon Copy ───────────────────────────────────────────
  document.querySelectorAll('.offer-code').forEach(el => {
    el.addEventListener('click', () => {
      const code = el.querySelector('.code-text')?.textContent || el.textContent.trim();
      navigator.clipboard.writeText(code).then(() => {
        const orig = el.innerHTML;
        el.innerHTML = '<i class="fas fa-check"></i> Copied!';
        el.style.background = 'rgba(16,185,129,0.3)';
        setTimeout(() => { el.innerHTML = orig; el.style.background = ''; }, 2000);
      }).catch(() => {
        // Fallback
        const ta = document.createElement('textarea');
        ta.value = code;
        document.body.appendChild(ta);
        ta.select();
        document.execCommand('copy');
        document.body.removeChild(ta);
      });
    });
  });

  // ── Star Rating Input ──────────────────────────────────────
  document.querySelectorAll('.star-rating').forEach(container => {
    const labels = container.querySelectorAll('label');
    const inputs = container.querySelectorAll('input');
    labels.forEach((label, i) => {
      label.addEventListener('mouseover', () => {
        labels.forEach((l, j) => l.style.color = j >= labels.length - 1 - i ? '#F59E0B' : '#ddd');
      });
      label.addEventListener('mouseout', () => {
        labels.forEach(l => l.style.color = '');
      });
    });
  });

  // ── Smooth Scroll for Anchor Links ────────────────────────
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const target = document.querySelector(a.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  // ── Sticky Header Shadow ──────────────────────────────────
  // (handled in menu.js)

  // ── Estimation Tab Switcher ───────────────────────────────
  document.querySelectorAll('.estimation-tab').forEach(tab => {
    tab.addEventListener('click', () => {
      const target = tab.dataset.tab;
      document.querySelectorAll('.estimation-tab').forEach(t => t.classList.remove('active'));
      document.querySelectorAll('.estimation-panel').forEach(p => p.classList.remove('active'));
      tab.classList.add('active');
      document.getElementById(target)?.classList.add('active');
    });
  });

  // ── Contact Form Submission ───────────────────────────────
  const contactForms = document.querySelectorAll('form[data-ajax="true"]');
  contactForms.forEach(form => {
    form.addEventListener('submit', async e => {
      e.preventDefault();
      const btn = form.querySelector('[type="submit"]');
      const origText = btn.innerHTML;
      btn.innerHTML = '<span class="spinner"></span> Sending…';
      btn.disabled = true;

      try {
        const data = new FormData(form);
        const res  = await fetch(form.action || '/api/contact.php', { method: 'POST', body: data });
        const json = await res.json();

        if (json.success) {
          const successEl = form.closest('.quick-contact-card, .contact-form-wrap')?.querySelector('.form-success');
          if (successEl) {
            form.style.display = 'none';
            successEl.style.display = 'block';
          } else {
            showNotification('Thank you! We will contact you shortly.', 'success');
            form.reset();
          }
        } else {
          showNotification(json.message || 'Something went wrong. Please try again.', 'error');
        }
      } catch (err) {
        showNotification('Network error. Please call us at ' + (SITE_CONFIG?.phone || '9966499144'), 'error');
      }

      btn.innerHTML = origText;
      btn.disabled = false;
    });
  });

  // ── Review Form ───────────────────────────────────────────
  const reviewForm = document.querySelector('#reviewForm');
  if (reviewForm) {
    reviewForm.addEventListener('submit', async e => {
      e.preventDefault();
      const btn = reviewForm.querySelector('[type="submit"]');
      const origText = btn.innerHTML;
      btn.innerHTML = '<span class="spinner"></span> Submitting…';
      btn.disabled = true;

      const data = new FormData(reviewForm);
      try {
        const res  = await fetch('/api/review.php', { method: 'POST', body: data });
        const json = await res.json();
        if (json.success) {
          showNotification('Thank you for your review! It will be published after verification.', 'success');
          reviewForm.reset();
          document.querySelectorAll('.star-rating label').forEach(l => l.style.color = '');
        } else {
          showNotification(json.message || 'Error submitting review. Please try again.', 'error');
        }
      } catch {
        showNotification('Network error. Please try again.', 'error');
      }
      btn.innerHTML = origText;
      btn.disabled = false;
    });
  }

  // ── Notification Toast ────────────────────────────────────
  function showNotification(msg, type = 'success') {
    const el = document.createElement('div');
    el.className = `notification notification-${type}`;
    el.innerHTML = `
      <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
      <span>${msg}</span>
      <button onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
    `;
    document.body.appendChild(el);
    setTimeout(() => el.style.cssText += 'opacity:1;transform:translateY(0)', 10);
    setTimeout(() => { el.style.opacity = '0'; setTimeout(() => el.remove(), 400); }, 5000);
  }

  // Notification styles (inject once)
  const notifStyles = `
    .notification{
      position:fixed;bottom:20px;left:50%;transform:translateY(20px);
      background:#fff;border-radius:12px;padding:16px 20px;
      display:flex;align-items:center;gap:12px;
      box-shadow:0 8px 40px rgba(0,0,0,0.18);z-index:99999;
      max-width:460px;font-size:.9rem;font-weight:600;
      opacity:0;transition:all .3s ease;
      translate:-50% 0;
    }
    .notification-success{border-left:4px solid #10B981;color:#065F46}
    .notification-success i{color:#10B981}
    .notification-error{border-left:4px solid #EF4444;color:#991B1B}
    .notification-error i{color:#EF4444}
    .notification button{margin-left:auto;background:none;border:none;cursor:pointer;color:#9CA3AF;font-size:.9rem}
  `;
  if (!document.getElementById('notifStyles')) {
    const s = document.createElement('style');
    s.id = 'notifStyles';
    s.textContent = notifStyles;
    document.head.appendChild(s);
  }

  // ── Gallery Filter ────────────────────────────────────────
  document.querySelectorAll('.gallery-filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const filter = btn.dataset.filter;
      document.querySelectorAll('.gallery-filter-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      document.querySelectorAll('.gallery-item[data-category]').forEach(item => {
        const show = filter === 'all' || item.dataset.category === filter;
        item.style.display = show ? '' : 'none';
      });
    });
  });

  // ── Video Modal ───────────────────────────────────────────
  document.querySelectorAll('.video-play-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const videoId = btn.dataset.videoId;
      if (!videoId) return;
      const modal = document.createElement('div');
      modal.className = 'video-modal';
      modal.innerHTML = `
        <div class="video-modal-backdrop"></div>
        <div class="video-modal-content">
          <button class="video-modal-close"><i class="fas fa-times"></i></button>
          <iframe src="https://www.youtube.com/embed/${videoId}?autoplay=1" 
                  allow="autoplay;encrypted-media" allowfullscreen></iframe>
        </div>
      `;
      document.body.appendChild(modal);
      document.body.style.overflow = 'hidden';
      setTimeout(() => modal.classList.add('open'), 10);
      modal.querySelector('.video-modal-backdrop').onclick = () => closeVideoModal(modal);
      modal.querySelector('.video-modal-close').onclick = () => closeVideoModal(modal);
    });
  });

  function closeVideoModal(modal) {
    modal.classList.remove('open');
    document.body.style.overflow = '';
    setTimeout(() => modal.remove(), 300);
  }

  // Video modal styles
  const vidStyles = `
    .video-modal{position:fixed;inset:0;z-index:99998;display:flex;align-items:center;justify-content:center;padding:20px}
    .video-modal-backdrop{position:absolute;inset:0;background:rgba(0,0,0,.92)}
    .video-modal-content{position:relative;width:100%;max-width:900px;aspect-ratio:16/9;z-index:1;opacity:0;transform:scale(.95);transition:all .3s ease}
    .video-modal.open .video-modal-content{opacity:1;transform:scale(1)}
    .video-modal-content iframe{width:100%;height:100%;border-radius:12px;border:none}
    .video-modal-close{position:absolute;top:-44px;right:0;width:38px;height:38px;border-radius:50%;background:rgba(255,255,255,.15);color:#fff;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:1rem;transition:all .2s}
    .video-modal-close:hover{background:var(--primary,#FF6B00)}
  `;
  if (!document.getElementById('vidStyles')) {
    const s = document.createElement('style');
    s.id = 'vidStyles';
    s.textContent = vidStyles;
    document.head.appendChild(s);
  }

  // ── Visitor Tracking ──────────────────────────────────────
  (function trackVisitor() {
    const siteUrl = (typeof SITE_CONFIG !== 'undefined') ? SITE_CONFIG.siteUrl : '';
    const sessionKey = 'nd_session';
    let sessionId = sessionStorage.getItem(sessionKey);

    if (!sessionId) {
      sessionId = 'ND_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
      sessionStorage.setItem(sessionKey, sessionId);
    }

    // Track page visit
    fetch(`${siteUrl}/api/visitor.php?action=track`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        session_id: sessionId,
        page_url:   window.location.href,
        page_title: document.title,
        referrer:   document.referrer
      })
    }).catch(() => {});

    // Heartbeat every 30 seconds
    setInterval(() => {
      fetch(`${siteUrl}/api/visitor.php?action=heartbeat`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ session_id: sessionId })
      }).catch(() => {});
    }, 30000);

    // Track leave
    window.addEventListener('beforeunload', () => {
      navigator.sendBeacon(
        `${siteUrl}/api/visitor.php?action=leave`,
        JSON.stringify({ session_id: sessionId })
      );
    });
  })();

})();
