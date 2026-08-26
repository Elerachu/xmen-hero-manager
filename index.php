<?php
require_once __DIR__ . '/functions.php';

$heroes = db()->query(
    'SELECT id, hero_name, real_name, short_bio, powers, team, image_url FROM heroes ORDER BY hero_name'
)->fetchAll();

$hero_count = count($heroes);

$page_title = 'Hero directory';
require_once __DIR__ . '/header.php';
?>

<section class="page-head">
  <div>
    <h1>Mutant Roster</h1>
    <p class="tagline">A public directory of special mutants who are a part of the X-Men.</p>
  </div>
  <div class="head-meta">
    <?php if (logged_in()): ?>
      <a class="button" href="add.php">+ Add hero</a>
    <?php endif; ?>
  </div>
</section>

<section class="toolbar" aria-label="Search heroes">
  <div class="search-box">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#98A2BD" stroke-width="2.2" stroke-linecap="round" aria-hidden="true">
      <circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>
    </svg>
    <input type="search" id="hero-search" placeholder="Search heroes or real names&hellip;" aria-label="Search heroes">
  </div>
</section>

<div class="hero-grid" id="hero-grid">
  <?php foreach ($heroes as $hero): ?>
    <?php $chips = power_chips($hero['powers']); ?>
    <article class="hero-card"
             data-search="<?= e($hero['hero_name'] . ' ' . $hero['real_name'] . ' ' . $hero['powers']) ?>">
      <div class="card-avatar">
        <?php if ($hero['image_url']): ?>
          <img src="<?= e($hero['image_url']) ?>" alt="<?= e($hero['hero_name']) ?>">
        <?php else: ?>
          <span class="initial"><?= e(strtoupper(substr($hero['hero_name'], 0, 1))) ?></span>
        <?php endif; ?>
      </div>
      <div class="card-body">
        <h3><?= e($hero['hero_name']) ?></h3>
        <p class="real-name"><?= e($hero['real_name']) ?></p>
        <p class="card-bio"><?= e($hero['short_bio']) ?></p>
        <div class="power-chips">
          <?php foreach (array_slice($chips, 0, 3) as $chip): ?>
            <span class="power-chip"><?= e($chip) ?></span>
          <?php endforeach; ?>
        </div>
      </div>
      <a class="card-link" href="details.php?id=<?= $hero['id'] ?>">View profile &rarr;</a>
    </article>
  <?php endforeach; ?>

  <div class="empty-state" id="empty-state">
    <div class="empty-icon">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#6D9EFF" stroke-width="2.2" stroke-linecap="round" aria-hidden="true">
        <circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/><path d="M8.5 11h5"/>
      </svg>
    </div>
    <h2>No mutants found</h2>
    <p>Cerebro picked up no signals for <span id="empty-query">your search</span>. Try a different name or clear the search.</p>
    <button type="button" class="button ghost small" id="clear-search">Clear search</button>
  </div>
</div>

<?php if ($hero_count === 0): ?>
  <div class="empty-simple">
    <h2>The archive is empty</h2>
    <p>No heroes have been recorded yet.</p>
    <?php if (logged_in()): ?>
      <a class="button" href="add.php">+ Add the first hero</a>
    <?php endif; ?>
  </div>
<?php endif; ?>

<?php require __DIR__ . '/footer.php'; ?>
