<?php require_once __DIR__ . '/functions.php'; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($page_title) ? e($page_title) . ' | ' : '' ?>X‑Men Archive</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="site-header"><div class="nav wrap">
  <a class="brand" href="index.php"><span>X</span> MEN ARCHIVE</a>
  <nav><a href="index.php">Heroes</a>
  <?php if (logged_in()): ?>
    <a href="add.php">Add hero</a><a href="logout.php">Log out</a>
  <?php else: ?>
    <a href="login.php">Log in</a><a class="nav-cta" href="register.php">Register</a>
  <?php endif; ?></nav>
</div></header>
<main class="wrap">
<?php if ($message = flash('success')): ?><div class="alert success"><?= e($message) ?></div><?php endif; ?>
<?php if ($message = flash('error')): ?><div class="alert error"><?= e($message) ?></div><?php endif; ?>
