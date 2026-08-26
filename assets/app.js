// Cerebro Files — client-side behaviour

// ---------------------------------------------------------------- helpers
function powerChips(text) {
  return String(text || '')
    .split(',')
    .map((part) => part.trim())
    .filter(Boolean);
}

// ----------------------------------------------------------- roster: live search
const searchInput = document.getElementById('hero-search');
const rosterGrid = document.getElementById('hero-grid');
const emptyState = document.getElementById('empty-state');

if (searchInput && rosterGrid) {
  const cards = Array.from(rosterGrid.querySelectorAll('.hero-card'));

  function applySearch() {
    const query = searchInput.value.trim().toLowerCase();
    let visible = 0;

    cards.forEach((card) => {
      const haystack = (card.dataset.search || '').toLowerCase();
      const show = !query || haystack.includes(query);
      card.style.display = show ? '' : 'none';
      if (show) visible += 1;
    });

    if (emptyState && cards.length > 0) {
      emptyState.classList.toggle('show', visible === 0);
      const queryNote = document.getElementById('empty-query');
      if (queryNote) queryNote.textContent = query ? '"' + query + '"' : 'your search';
    }
  }

  searchInput.addEventListener('input', applySearch);
}

// clear-search button inside the empty state
const clearSearch = document.getElementById('clear-search');
if (clearSearch && searchInput) {
  clearSearch.addEventListener('click', () => {
    searchInput.value = '';
    searchInput.dispatchEvent(new Event('input'));
    searchInput.focus();
  });
}

// ------------------------------------------------------------- hero form extras
const heroForm = document.querySelector('[data-hero-form]');
if (heroForm) {
  const shortBio = heroForm.querySelector('[name="short_bio"]');
  const counter = document.getElementById('short-bio-count');
  if (shortBio && counter) {
    const update = () => { counter.textContent = shortBio.value.length + ' / 255'; };
    shortBio.addEventListener('input', update);
    update();
  }

  const imageInput = heroForm.querySelector('[name="image_url"]');
  const preview = document.getElementById('image-preview');
  if (imageInput && preview) {
    const update = () => {
      const value = imageInput.value.trim();
      if (value && /^https?:\/\/\S+$/i.test(value)) {
        preview.innerHTML = '';
        const img = document.createElement('img');
        img.src = value;
        img.alt = 'Preview';
        preview.replaceChildren(img);
        preview.classList.add('show');
      } else {
        preview.classList.remove('show');
        preview.replaceChildren();
      }
    };
    imageInput.addEventListener('input', update);
    update();
  }
}

// ------------------------------------------------------- inline field validation
function validateForm(form) {
  let firstInvalid = null;
  form.querySelectorAll('.field').forEach((field) => {
    const input = field.querySelector('input, textarea');
    if (!input) return;
    const ok = input.checkValidity();
    field.classList.toggle('invalid', !ok);
    const msg = field.querySelector('.error-msg');
    if (!ok && msg && !msg.textContent) msg.textContent = input.validationMessage;
    if (!ok && !firstInvalid) firstInvalid = input;
  });
  if (firstInvalid) firstInvalid.focus();
  return !firstInvalid;
}

document.querySelectorAll('form').forEach((form) => {
  form.addEventListener('submit', (event) => {
    if (form.hasAttribute('data-skip-validation')) return;
    if (!form.checkValidity()) {
      event.preventDefault();
      validateForm(form);
    }
  });
});

// --------------------------------------------------------- register: passwords
const registerForm = document.querySelector('[data-register-form]');
if (registerForm) {
  const password = registerForm.querySelector('[name="password"]');
  const confirm = registerForm.querySelector('[name="confirm_password"]');
  const strength = document.getElementById('password-strength');

  if (password && strength) {
    password.addEventListener('input', () => {
      const value = password.value;
      const strong = value.length >= 10 && /[0-9]/.test(value) && /[^A-Za-z0-9]/.test(value);
      strength.textContent = !value ? '' : strong ? 'Strong password' : 'Add 10+ characters with a number and symbol for a stronger password.';
      strength.classList.toggle('strong', strong);
      strength.classList.toggle('weak', Boolean(value) && !strong);
    });
  }

  registerForm.addEventListener('submit', (event) => {
    if (password && confirm && password.value !== confirm.value) {
      event.preventDefault();
      const field = confirm.closest('.field');
      field.classList.add('invalid');
      const msg = field.querySelector('.error-msg');
      if (msg) msg.textContent = 'Passwords do not match.';
      confirm.focus();
    }
  });
}

// ------------------------------------------------------------ password reveal
document.querySelectorAll('.toggle-password').forEach((button) => {
  button.addEventListener('click', () => {
    const input = button.closest('.field').querySelector('input');
    const showing = input.type === 'text';
    input.type = showing ? 'password' : 'text';
    button.textContent = showing ? 'Show' : 'Hide';
  });
});

// -------------------------------------------------------------- delete modal
const modal = document.getElementById('delete-modal');
if (modal) {
  const dialog = modal.querySelector('.modal');
  const opener = document.querySelector('[data-open-delete]');
  const cancel = modal.querySelector('[data-close-delete]');
  const confirmForm = modal.querySelector('form');
  let lastFocus = null;

  function openModal() {
    lastFocus = document.activeElement;
    modal.classList.add('open');
    cancel.focus();
    document.addEventListener('keydown', onKeydown);
  }

  function closeModal() {
    modal.classList.remove('open');
    document.removeEventListener('keydown', onKeydown);
    if (lastFocus) lastFocus.focus();
  }

  function onKeydown(event) {
    if (event.key === 'Escape') { closeModal(); return; }
    if (event.key !== 'Tab') return;
    const focusable = Array.from(dialog.querySelectorAll('button, a, input'));
    const first = focusable[0];
    const last = focusable[focusable.length - 1];
    if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
    else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
  }

  if (opener) opener.addEventListener('click', openModal);
  cancel.addEventListener('click', closeModal);
  modal.addEventListener('click', (event) => { if (event.target === modal) closeModal(); });
}
