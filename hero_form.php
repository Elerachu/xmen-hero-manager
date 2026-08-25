<?php $is_edit = isset($hero['id']); ?>
<form class="form-card" method="post" novalidate data-hero-form>
<input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
<div class="form-header"><p class="eyebrow">Secure editor</p><h1><?= $is_edit ? 'Edit ' . e($hero['hero_name']) : 'Add a new hero' ?></h1><p>Fields marked * are required.</p></div>
<div class="form-grid"><label>Hero name *<input name="hero_name" required maxlength="100" value="<?= e($hero['hero_name'] ?? '') ?>"></label><label>Real name *<input name="real_name" required maxlength="100" value="<?= e($hero['real_name'] ?? '') ?>"></label><label>Team<input name="team" maxlength="100" value="<?= e($hero['team'] ?? 'X-Men') ?>"></label><label>Image URL <span class="muted">(optional)</span><input type="url" name="image_url" maxlength="500" placeholder="https://..." value="<?= e($hero['image_url'] ?? '') ?>"></label></div>
<label>Short biography *<textarea name="short_bio" required maxlength="255" rows="3"><?= e($hero['short_bio'] ?? '') ?></textarea><small>Brief summary used on the directory card.</small></label>
<label>Long biography *<textarea name="long_bio" required rows="7"><?= e($hero['long_bio'] ?? '') ?></textarea></label>
<label>Powers<input name="powers" maxlength="255" value="<?= e($hero['powers'] ?? '') ?>"></label>
<div class="form-actions"><a href="<?= $is_edit ? 'details.php?id=' . $hero['id'] : 'index.php' ?>">Cancel</a><button class="button" type="submit"><?= $is_edit ? 'Save changes' : 'Create hero' ?></button></div></form>
