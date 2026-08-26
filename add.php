<?php

require_once __DIR__ . '/functions.php';

// Only logged-in users can create new hero records.
require_login();

$hero = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $hero = hero_input();

    $required = $hero['hero_name'] && $hero['real_name'] && $hero['short_bio'] && $hero['long_bio'];

    if (!$required) {
        flash('error', 'Please complete every required field.');
    } else {
        $stmt = db()->prepare(
            'INSERT INTO heroes (hero_name, real_name, short_bio, long_bio, powers, team, image_url)
             VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute(array_values($hero));

        flash('success', 'Hero added to the archive.');
        header('Location: details.php?id=' . db()->lastInsertId());
        exit;
    }
}

$page_title = 'Add hero';
require __DIR__ . '/header.php';
require __DIR__ . '/hero_form.php';
require __DIR__ . '/footer.php';
