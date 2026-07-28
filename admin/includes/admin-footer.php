<?php defined('NETSDIAL') or die(); ?>
  </div><!-- end admin-content -->
</div><!-- end admin-main -->

<script>
function toggleSidebar() {
  const sb = document.getElementById('adminSidebar');
  const ov = document.getElementById('sidebarOverlay');
  sb.classList.toggle('open');
  ov.classList.toggle('open');
}

// Admin-specific JS
document.addEventListener('DOMContentLoaded', function() {
  // Confirm delete dialogs
  document.querySelectorAll('[data-confirm]').forEach(el => {
    el.addEventListener('click', e => {
      if (!confirm(el.dataset.confirm || 'Are you sure?')) e.preventDefault();
    });
  });

  // Auto-dismiss alerts
  document.querySelectorAll('.admin-alert[data-auto-dismiss]').forEach(el => {
    setTimeout(() => { el.style.opacity = '0'; setTimeout(() => el.remove(), 300); }, 4000);
  });

  // Table row select
  document.querySelectorAll('.select-all').forEach(cb => {
    cb.addEventListener('change', () => {
      document.querySelectorAll('.row-select').forEach(r => r.checked = cb.checked);
    });
  });
});
</script>
<?php echo $admin_extra_js ?? ''; ?>
</body>
</html>
