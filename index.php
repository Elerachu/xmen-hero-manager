<?php
$page_title = 'Hero directory'; require_once __DIR__ . '/header.php';
$heroes = db()->query('SELECT id, hero_name, real_name, short_bio, powers, team, image_url FROM heroes ORDER BY hero_name')->fetchAll();
?>
<section class="hero-banner"><p class="eyebrow">Xavier Institute</p><h1>Meet the X‑Men</h1><p>A public directory of extraordinary people protecting a world that fears them.</p><?php if (logged_in()): ?><a class="button" href="add.php">+ Add a hero</a><?php endif; ?></section>
<section class="section-heading"><div><p class="eyebrow">Roster</p><h2><?= count($heroes) ?> active heroes</h2></div></section>
<div class="hero-grid">
<?php foreach ($heroes as $hero): ?><article class="hero-card">
  <div class="avatar"><?= $hero['image_url'] ? '<img src="' . e($hero['image_url']) . '" alt="' . e($hero['hero_name']) . '">' : e(strtoupper(substr($hero['hero_name'], 0, 1))) ?></div>
  <div class="card-content"><p class="tag"><?= e($hero['team'] ?: 'X-Men') ?></p><h3><?= e($hero['hero_name']) ?></h3><p class="real-name"><?= e($hero['real_name']) ?></p><p><?= e($hero['short_bio']) ?></p><p class="powers"><strong>Powers:</strong> <?= e($hero['powers']) ?></p><a class="text-link" href="details.php?id=<?= $hero['id'] ?>">View profile &rarr;</a></div>
</article><?php endforeach; ?>
</div>
<?php require __DIR__ . '/footer.php'; ?>
