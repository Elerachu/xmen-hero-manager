<?php

require_once __DIR__ . '/functions.php';

if (logged_in()) {
    header('Location: index.php');
    exit;
}

$next = redirect_target();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = db()->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        flash('success', 'Welcome back, ' . $user['username'] . '.');
        header('Location: ' . $next);
        exit;
    }

    flash('error', 'Invalid username or password.');
}

$page_title = 'Log in';
require __DIR__ . '/header.php';
?>

<div class="auth-layout">
  <aside class="auth-brand" style="background: linear-gradient(160deg, rgba(10,14,26,0.42) 0%, rgba(10,14,26,0.88) 78%), url('assets/img/login-bg.png') center/cover no-repeat, linear-gradient(150deg, #131c3a 0%, #0a0e1a 75%); justify-content: center;">
    <div>
      <p class="display">The archive is always open.</p>
      <p class="sub">Sign in to update records and add new recruits</p>
    </div>
  </aside>

  <div class="auth-form-col">
    <form class="auth-card" method="post" novalidate>
      <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
      <input type="hidden" name="next" value="<?= e($next) ?>">

      <div>
        <h1>Welcome back</h1>
      </div>

      <div class="auth-fields">
        <div class="field">
          <label for="username">Username</label>
          <input id="username" name="username" required autocomplete="username" value="<?= e($_POST['username'] ?? '') ?>">
          <p class="error-msg"></p>
        </div>
        <div class="field">
          <div class="label-row">
            <label for="password">Password</label>
            <button type="button" class="toggle-password">Show</button>
          </div>
          <input id="password" type="password" name="password" required autocomplete="current-password">
          <p class="error-msg"></p>
        </div>
        <button class="button" type="submit">Log in</button>
      </div>

      <p class="auth-swap">New here? <a href="register.php">Create an account</a></p>
    </form>
  </div>
</div>

<?php require __DIR__ . '/footer.php'; ?>
