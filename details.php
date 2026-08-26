<?php
require_once __DIR__ . '/functions.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$stmt = db()->prepare('SELECT * FROM heroes WHERE id = ?');
$stmt->execute([$id]);
$hero = $stmt->fetch();

if (!$hero) {
    http_response_code(404);
    $page_title = 'Not found';
    require __DIR__ . '/header.php';
    echo '<div class="empty-simple"><h1>Hero not found</h1><a class="button" href="index.php">Back to roster</a></div>';
    require __DIR__ . '/footer.php';
    exit;
}

$chips = power_chips($hero['powers']);
$page_title = $hero['hero_name'];
$next_param = 'details.php?id=' . $hero['id'];
require __DIR__ . '/header.php';
?>

<a class="back-link" href="index.php">&larr; Back to roster</a>

<section class="profile-head">
  <div class="profile-avatar">
    <?php if ($hero['image_url']): ?>
      <img src="<?= e($hero['image_url']) ?>" alt="<?= e($hero['hero_name']) ?>">
    <?php else: ?>
      <span class="initial"><?= e(strtoupper(substr($hero['hero_name'], 0, 1))) ?></span>
    <?php endif; ?>
  </div>
  <div class="profile-id">
    <h1><?= e($hero['hero_name']) ?></h1>
    <p class="alias">Also known as <?= e($hero['real_name']) ?></p>
    <div class="power-chips">
      <?php foreach ($chips as $chip): ?>
        <span class="power-chip"><?= e($chip) ?></span>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="profile-actions">
    <?php if (logged_in()): ?>
      <a class="button" href="edit.php?id=<?= $hero['id'] ?>">Edit hero</a>
      <button type="button" class="button danger-outline" data-open-delete>Delete</button>
    <?php else: ?>
      <a class="button locked" href="login.php?next=<?= urlencode('details.php?id=' . $hero['id']) ?>">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true">
          <rect x="4" y="10.5" width="16" height="10" rx="2"/><path d="M8 10.5V7a4 4 0 0 1 8 0v3.5"/>
        </svg>
        Log in to edit
      </a>
    <?php endif; ?>
  </div>
</section>

<section class="profile-layout">
  <div class="bio-column">
    <h2>Biography</h2>
    <p><?= nl2br(e($hero['long_bio'])) ?></p>
    <div class="short-bio-note">Short biography &mdash; &ldquo;<?= e($hero['short_bio']) ?>&rdquo;</div>
  </div>
  <aside class="profile-side">
    <div class="side-card">
      <h3>Abilities</h3>
      <p><?= e($hero['powers'] ?: 'Classified') ?></p>
    </div>
    <div class="side-card">
      <h3>Team</h3>
      <p><?= e($hero['team'] ?: 'X-Men') ?></p>
    </div>
    <div class="side-card">
      <h3>Record added</h3>
      <p><?= e(format_date($hero['created_at'])) ?></p>
    </div>
  </aside>
</section>

<?php if (logged_in()): ?>
  <div class="modal-backdrop" id="delete-modal" role="dialog" aria-modal="true" aria-labelledby="delete-modal-title">
    <div class="modal">
      <div class="modal-icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true">
          <path d="M12 8v5"/><circle cx="12" cy="16.5" r="0.5" fill="currentColor"/><path d="M10.3 3.9 2.8 17a2 2 0 0 0 1.7 3h15a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"/>
        </svg>
      </div>
      <h2 id="delete-modal-title">Remove <?= e($hero['hero_name']) ?>?</h2>
      <p>This permanently removes the hero from the archive. This action cannot be undone.</p>
      <div class="modal-actions">
        <button type="button" class="button ghost" data-close-delete>Cancel</button>
        <form method="post" action="delete.php">
          <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
          <input type="hidden" name="id" value="<?= $hero['id'] ?>">
          <button class="button danger-solid" type="submit">Yes, delete hero</button>
        </form>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php require __DIR__ . '/footer.php'; ?>
