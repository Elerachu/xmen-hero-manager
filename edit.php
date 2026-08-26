<?php

require_once __DIR__ . '/functions.php';

// Only logged-in users can update existing hero records.
require_login();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$stmt = db()->prepare('SELECT * FROM heroes WHERE id = ?');
$stmt->execute([$id]);
$hero = $stmt->fetch();

if (!$hero) {
    flash('error', 'Hero not found.');
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $input = array_merge($hero, hero_input());

    $required = $input['hero_name'] && $input['real_name'] && $input['short_bio'] && $input['long_bio'];

    if (!$required) {
        flash('error', 'Please complete every required field.');
        $hero = $input;
    } else {
        $update = db()->prepare(
            'UPDATE heroes
             SET hero_name = ?, real_name = ?, short_bio = ?, long_bio = ?, powers = ?, team = ?, image_url = ?
             WHERE id = ?'
        );
        $update->execute([
            $input['hero_name'],
            $input['real_name'],
            $input['short_bio'],
            $input['long_bio'],
            $input['powers'],
            $input['team'],
            $input['image_url'],
            $id,
        ]);

        flash('success', 'Hero profile updated.');
        header('Location: details.php?id=' . $id);
        exit;
    }
}

$page_title = 'Edit hero';
require __DIR__ . '/header.php';
require __DIR__ . '/hero_form.php';
require __DIR__ . '/footer.php';
