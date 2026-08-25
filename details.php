<?php
require_once __DIR__ . '/functions.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$stmt = db()->prepare('SELECT * FROM heroes WHERE id = ?'); $stmt->execute([$id]); $hero = $stmt->fetch();
if (!$hero) { http_response_code(404); $page_title = 'Not found'; require __DIR__ . '/header.php'; echo '<div class="empty"><h1>Hero not found</h1><a class="button" href="index.php">Back to roster</a></div>'; require __DIR__ . '/footer.php'; exit; }
$page_title = $hero['hero_name']; require __DIR__ . '/header.php';
?>
<a class="back" href="index.php">&larr; Back to roster</a>
<section class="profile"><div class="profile-avatar"><?= $hero['image_url'] ? '<img src="' . e($hero['image_url']) . '" alt="' . e($hero['hero_name']) . '">' : e(strtoupper(substr($hero['hero_name'], 0, 1))) ?></div><div>
 <p class="eyebrow"><?= e($hero['team'] ?: 'X-Men') ?></p><h1><?= e($hero['hero_name']) ?></h1><p class="subtitle">Also known as <?= e($hero['real_name']) ?></p><p class="lead"><?= e($hero['short_bio']) ?></p>
 <?php if (logged_in()): ?><div class="actions"><a class="button" href="edit.php?id=<?= $hero['id'] ?>">Edit hero</a><form method="post" action="delete.php" data-confirm="Delete <?= e($hero['hero_name']) ?>? This cannot be undone."><input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"><input type="hidden" name="id" value="<?= $hero['id'] ?>"><button class="button danger" type="submit">Delete</button></form></div><?php endif; ?>
</div></section>
<section class="bio-layout"><article><h2>Biography</h2><p><?= nl2br(e($hero['long_bio'])) ?></p></article><aside><h2>Abilities</h2><p><?= e($hero['powers'] ?: 'Classified') ?></p><h2>Team</h2><p><?= e($hero['team'] ?: 'X-Men') ?></p></aside></section>
<?php require __DIR__ . '/footer.php'; ?>
