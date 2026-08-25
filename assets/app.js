document.querySelectorAll('[data-confirm]').forEach(form => form.addEventListener('submit', event => {
  if (!window.confirm(form.dataset.confirm)) event.preventDefault();
}));
document.querySelectorAll('[data-hero-form], [data-auth-form], [data-register-form]').forEach(form => form.addEventListener('submit', event => {
  if (!form.checkValidity()) { event.preventDefault(); form.reportValidity(); }
  if (form.dataset.registerForm && form.password.value !== form.confirm_password.value) { event.preventDefault(); alert('Passwords must match.'); form.confirm_password.focus(); }
}));
