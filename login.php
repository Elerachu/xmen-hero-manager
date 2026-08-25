<?php
require_once __DIR__ . '/functions.php'; 

// Check the submitted password against the secure hashed password in the database.
if (logged_in()) { header('Location: index.php'); exit; }
if ($_SERVER['REQUEST_METHOD'] === 'POST') { verify_csrf(); $username = trim($_POST['username'] ?? ''); $password = $_POST['password'] ?? ''; $stmt = db()->prepare('SELECT * FROM users WHERE username = ?'); $stmt->execute([$username]); $user = $stmt->fetch(); if ($user && password_verify($password, $user['password'])) { session_regenerate_id(true); $_SESSION['user_id'] = $user['id']; $_SESSION['username'] = $user['username']; flash('success', 'Welcome back, ' . $user['username'] . '.'); header('Location: index.php'); exit; } flash('error', 'Invalid username or password.'); }
$page_title = 'Log in'; require __DIR__ . '/header.php'; ?>
<form class="auth-card" method="post" novalidate data-auth-form><input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"><p class="eyebrow">Member access</p><h1>Welcome back</h1><label>Username<input name="username" required autocomplete="username" value="<?= e($_POST['username'] ?? '') ?>"></label><label>Password<input type="password" name="password" required autocomplete="current-password"></label><button class="button" type="submit">Log in</button><p>New here? <a href="register.php">Create an account</a></p></form>
<?php require __DIR__ . '/footer.php'; ?>
