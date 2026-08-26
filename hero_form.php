<?php $is_edit = isset($hero['id']); ?>
<div class="form-shell">
  <p class="eyebrow">Secure editor &middot; Clearance verified</p>
  <h1><?= $is_edit ? 'Edit ' . e($hero['hero_name']) : 'Add a new hero' ?></h1>
  <p class="form-intro">Fields marked * are required. Changes are recorded instantly in the archive.</p>

  <form class="form-card" method="post" novalidate data-hero-form>
    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

    <p class="fieldset-label">Identity</p>
    <div class="form-row">
      <div class="field">
        <label for="hero_name">Hero name *</label>
        <input id="hero_name" name="hero_name" required maxlength="100" value="<?= e($hero['hero_name'] ?? '') ?>">
        <p class="error-msg"></p>
      </div>
      <div class="field">
        <label for="real_name">Real name *</label>
        <input id="real_name" name="real_name" required maxlength="100" value="<?= e($hero['real_name'] ?? '') ?>">
        <p class="error-msg"></p>
      </div>
    </div>
    <div class="form-row">
      <div class="field">
        <label for="team">Team</label>
        <input id="team" name="team" maxlength="100" value="<?= e($hero['team'] ?? 'X-Men') ?>">
      </div>
      <div class="field">
        <label for="powers">Powers <span class="optional">(comma-separated)</span></label>
        <input id="powers" name="powers" maxlength="255" placeholder="e.g. Flight, Strength" value="<?= e($hero['powers'] ?? '') ?>">
        <p class="hint">Rendered as chips across the archive.</p>
      </div>
    </div>

    <p class="fieldset-label">Story</p>
    <div class="field">
      <div class="label-row">
        <label for="short_bio">Short biography *</label>
        <span class="char-count" id="short-bio-count">0 / 255</span>
      </div>
      <textarea id="short_bio" name="short_bio" required maxlength="255" rows="3"><?= e($hero['short_bio'] ?? '') ?></textarea>
      <p class="hint">Brief summary shown on the roster card.</p>
      <p class="error-msg"></p>
    </div>
    <div class="field">
      <label for="long_bio">Long biography *</label>
      <textarea id="long_bio" name="long_bio" required rows="7" class="tall"><?= e($hero['long_bio'] ?? '') ?></textarea>
      <p class="error-msg"></p>
    </div>

    <p class="fieldset-label">Extras</p>
    <div class="preview-row">
      <div class="field">
        <label for="image_url">Image URL <span class="optional">(optional)</span></label>
        <input id="image_url" name="image_url" type="url" maxlength="500" placeholder="https://&hellip;" value="<?= e($hero['image_url'] ?? '') ?>">
        <p class="hint">A live preview appears once the link is valid.</p>
        <p class="error-msg"></p>
      </div>
      <div class="image-preview" id="image-preview" aria-hidden="true"></div>
    </div>

    <div class="form-actions">
      <a class="cancel-link" href="<?= $is_edit ? 'details.php?id=' . $hero['id'] : 'index.php' ?>">Cancel</a>
      <button class="button" type="submit"><?= $is_edit ? 'Save changes' : 'Create hero' ?></button>
    </div>
  </form>
</div>
