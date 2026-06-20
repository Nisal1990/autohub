/**
 * AutoHub LK — app.js (Public site JS)
 */
(function () {
  'use strict';

  // ── Navbar scroll behaviour ──────────────────────────────────────────────────
  const nav = document.getElementById('mainNav');
  if (nav) {
    window.addEventListener('scroll', () => {
      nav.classList.toggle('scrolled', window.scrollY > 30);
    }, { passive: true });
  }

  // ── Auto-dismiss alerts ──────────────────────────────────────────────────────
  document.querySelectorAll('.alert').forEach(el => {
    setTimeout(() => {
      if (el && el.parentElement) {
        el.style.transition = 'opacity 0.5s';
        el.style.opacity = '0';
        setTimeout(() => el.remove(), 500);
      }
    }, 5000);
  });

  // ── Image lazy-load fallback placeholder ─────────────────────────────────────
  document.querySelectorAll('img[src=""]').forEach(img => {
    img.src = '/autohub/public/assets/images/placeholder.jpg';
  });

  document.querySelectorAll('img').forEach(img => {
    img.addEventListener('error', function () {
      if (!this.dataset.errored) {
        this.dataset.errored = '1';
        this.src = '/autohub/public/assets/images/placeholder.jpg';
      }
    });
  });

  // ── Hero search — route to correct category URL ───────────────────────────────
  const heroBtn  = document.getElementById('heroSearchBtn');
  const heroCat  = document.getElementById('heroCategory');
  const heroForm = heroBtn?.closest('form');
  if (heroBtn && heroCat && heroForm) {
    heroBtn.addEventListener('click', () => {
      const cat = heroCat.value;
      const base = '/autohub/public';
      if (cat === 'parts')    heroForm.action = base + '/parts';
      if (cat === 'services') heroForm.action = base + '/services';
      if (cat === 'vehicles') heroForm.action = base + '/vehicles';
    });
  }

  // ── Vehicle form: dependent make → model AJAX dropdown ───────────────────────
  function initMakeModel(makeId, modelId) {
    const makeEl  = document.getElementById(makeId);
    const modelEl = document.getElementById(modelId);
    if (!makeEl || !modelEl) return;

    makeEl.addEventListener('change', function () {
      const id = this.value;
      const saved = modelEl.dataset.selected || '';
      modelEl.innerHTML = '<option value="">Select Model</option>';
      if (!id) return;

      fetch('/autohub/public/ajax/models?manufacturer_id=' + id)
        .then(r => r.json())
        .then(models => {
          models.forEach(m => {
            const opt = document.createElement('option');
            opt.value = m.id;
            opt.textContent = m.name;
            if (m.id == saved) opt.selected = true;
            modelEl.appendChild(opt);
          });
        })
        .catch(console.error);
    });
  }

  initMakeModel('makeFilter', 'modelFilter');
  initMakeModel('formMake', 'formModel');

  // ── Multi-image upload preview ────────────────────────────────────────────────
  function initImgPreview(inputId, previewId) {
    const input   = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    if (!input || !preview) return;

    input.addEventListener('change', function () {
      preview.innerHTML = '';
      [...this.files].slice(0, 8).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
          const img = document.createElement('img');
          img.src = e.target.result;
          img.className = 'preview-thumb';
          preview.appendChild(img);
        };
        reader.readAsDataURL(file);
      });
    });
  }

  initImgPreview('imgInput', 'imgPreview');
  initImgPreview('imgInputParts', 'imgPreviewParts');

  // ── Gallery lightbox (main image switch) ─────────────────────────────────────
  const mainImg = document.getElementById('mainImg');
  if (mainImg) {
    document.querySelectorAll('.gallery-thumb').forEach(thumb => {
      thumb.addEventListener('click', function () {
        mainImg.style.opacity = '0';
        setTimeout(() => {
          mainImg.src = this.src;
          mainImg.style.opacity = '1';
        }, 120);
        document.querySelectorAll('.gallery-thumb').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
      });
    });
    mainImg.style.transition = 'opacity 0.12s';
  }

  // ── Tooltip init (Bootstrap) ─────────────────────────────────────────────────
  if (typeof bootstrap !== 'undefined') {
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
      new bootstrap.Tooltip(el);
    });
  }

})();
