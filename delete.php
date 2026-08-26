<?php

require_once __DIR__ . '/functions.php';

// Deleting a record is restricted to logged-in users.
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

verify_csrf();

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if ($id) {
    $stmt = db()->prepare('DELETE FROM heroes WHERE id = ?');
    $stmt->execute([$id]);
    flash('success', 'Hero removed from the archive.');
}

header('Location: index.php');
exit;
