<?php require_once __DIR__ . '/functions.php'; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($page_title) ? e($page_title) . ' | ' : '' ?>X-Men Archive</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<a class="skip-link" href="#main">Skip to content</a>

<header class="site-header">
  <div class="wrap nav">
    <a class="brand" href="index.php"><span class="brand-x">X</span> MEN ARCHIVE</a>
    <nav class="nav-links" aria-label="Main navigation">
      <a href="index.php" <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'aria-current="page"' : '' ?>>Heroes</a>
      <?php if (logged_in()): ?>
        <a href="add.php">Add hero</a>
        <span class="user-chip" title="Signed in">
          <span class="username"><?= e($_SESSION['username'] ?? '') ?></span>
        </span>
        <a href="logout.php">Log out</a>
      <?php else: ?>
        <a href="login.php">Log in</a>
        <a class="button small" href="register.php<?= isset($next_param) ? '?next=' . urlencode($next_param) : '' ?>">Register</a>
      <?php endif; ?>
    </nav>
  </div>
</header>

<main id="main" class="wrap">
<?php if ($message = flash('success')): ?>
  <div class="alert success" role="status"><?= e($message) ?></div>
<?php endif; ?>
<?php if ($message = flash('error')): ?>
  <div class="alert error" role="alert"><?= e($message) ?></div>
<?php endif; ?>
