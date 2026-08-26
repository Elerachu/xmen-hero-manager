<?php

require_once __DIR__ . '/functions.php';

if (logged_in()) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (!preg_match('/^[A-Za-z0-9_]{3,30}$/', $username)) {
        flash('error', 'Username must be 3-30 letters, numbers, or underscores.');
    } elseif (strlen($password) < 6) {
        flash('error', 'Password must be at least 6 characters.');
    } elseif ($password !== $confirm) {
        flash('error', 'Passwords do not match.');
    } else {
        try {
            $stmt = db()->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
            $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT)]);

            flash('success', 'Account created. You can now log in.');
            header('Location: login.php');
            exit;
        } catch (PDOException $e) {
            flash('error', 'That username is already in use.');
        }
    }
}

$page_title = 'Register';
require __DIR__ . '/header.php';
?>

<div class="auth-layout">
  <aside class="auth-brand" style="background: linear-gradient(160deg, rgba(10,14,26,0.42) 0%, rgba(10,14,26,0.88) 78%), url('assets/img/register-bg.png') center/cover no-repeat, linear-gradient(150deg, #131c3a 0%, #0a0e1a 75%); justify-content: center;">
    <div>
      <p class="display">Every mutant belongs here.</p>
      <p class="sub">Create an account to join the archive and help keep the records updated.</p>
    </div>
  </aside>

  <div class="auth-form-col">
    <form class="auth-card" method="post" novalidate data-register-form>
      <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

      <div>
        <p class="eyebrow">Join the archive</p>
        <h1>Create an account</h1>
      </div>

      <div class="auth-fields">
        <div class="field">
          <label for="username">Username</label>
          <input id="username" name="username" required minlength="3" maxlength="30"
                 pattern="[A-Za-z0-9_]+" autocomplete="username" value="<?= e($_POST['username'] ?? '') ?>">
          <p class="hint">3-30 letters, numbers, or underscores.</p>
          <p class="error-msg"></p>
        </div>
        <div class="field">
          <div class="label-row">
            <label for="password">Password</label>
            <button type="button" class="toggle-password">Show</button>
          </div>
          <input id="password" type="password" name="password" required minlength="6" autocomplete="new-password">
          <p class="hint strength" id="password-strength"></p>
          <p class="error-msg"></p>
        </div>
        <div class="field">
          <div class="label-row">
            <label for="confirm_password">Confirm password</label>
          </div>
          <input id="confirm_password" type="password" name="confirm_password" required minlength="6" autocomplete="new-password">
          <p class="error-msg"></p>
        </div>
        <button class="button" type="submit">Register</button>
      </div>

      <p class="auth-swap">Already registered? <a href="login.php">Log in</a></p>
    </form>
  </div>
</div>

<?php require __DIR__ . '/footer.php'; ?>
