/**
 * AutoHub LK — admin.js
 */
(function () {
  'use strict';

  // ── Reject listing modal ─────────────────────────────────────────────────────
  window.rejectListing = function (action) {
    const form  = document.getElementById('rejectForm');
    const modal = document.getElementById('rejectModal');
    if (form && modal) {
      form.action = action;
      new bootstrap.Modal(modal).show();
    }
  };

  // ── Confirm-before-submit for all forms with data-confirm attr ───────────────
  document.querySelectorAll('form[data-confirm]').forEach(form => {
    form.addEventListener('submit', function (e) {
      if (!confirm(this.dataset.confirm)) e.preventDefault();
    });
  });

  // ── Auto-dismiss alerts ──────────────────────────────────────────────────────
  document.querySelectorAll('.alert').forEach(el => {
    setTimeout(() => {
      el.style.transition = 'opacity 0.5s';
      el.style.opacity = '0';
      setTimeout(() => el.remove(), 500);
    }, 6000);
  });

  // ── Lookup tabs: persist active tab in URL hash ───────────────────────────────
  const lookupTabs = document.getElementById('lookupTabs');
  if (lookupTabs) {
    // Activate tab from URL hash
    const hash = location.hash;
    if (hash) {
      const target = lookupTabs.querySelector(`[href="${hash}"]`);
      if (target) bootstrap.Tab.getOrCreateInstance(target).show();
    }
    lookupTabs.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
      tab.addEventListener('shown.bs.tab', e => {
        history.replaceState(null, '', e.target.getAttribute('href'));
      });
    });
  }

  // ── Auto-collapse sidebar on link click (mobile) ──────────────────────────────
  document.querySelectorAll('#adminSidebar .sidebar-nav a, #dashSidebar .sidebar-nav a').forEach(a => {
    a.addEventListener('click', () => {
      document.querySelectorAll('#adminSidebar, #dashSidebar').forEach(s => s.classList.remove('show'));
    });
  });

})();
