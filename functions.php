<?php

require_once __DIR__ . '/config.php';

session_start();

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function logged_in(): bool
{
    return isset($_SESSION['user_id']);
}

function require_login(): void
{
    if (!logged_in()) {
        flash('error', 'Please log in to manage heroes.');
        header('Location: login.php?next=' . urlencode(current_page()));
        exit;
    }
}

function current_page(): string
{
    $page = basename($_SERVER['PHP_SELF']);
    $query = $_SERVER['QUERY_STRING'] ?? '';

    return $query !== '' ? $page . '?' . $query : $page;
}

function redirect_target(): string
{
    $next = $_POST['next'] ?? $_GET['next'] ?? '';

    // Only allow simple internal page targets like "index.php" or "details.php?id=3".
    if (!preg_match('/^[a-z_]+\.php(\?[a-zA-Z0-9_=&%-]+)?$/', $next)) {
        $next = 'index.php';
    }

    return $next;
}

function flash(string $key, ?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['flash'][$key] = $message;
        return null;
    }

    $result = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);

    return $result;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function verify_csrf(): void
{
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Invalid form request. Please go back and try again.');
    }
}

function hero_fields(): array
{
    return ['hero_name', 'real_name', 'short_bio', 'long_bio', 'powers', 'team', 'image_url'];
}

function hero_input(): array
{
    $data = [];
    foreach (hero_fields() as $field) {
        $data[$field] = trim($_POST[$field] ?? '');
    }

    return $data;
}

function power_chips(?string $powers): array
{
    $chips = array_filter(array_map('trim', explode(',', $powers ?? '')));

    return array_values($chips);
}

function format_date(?string $timestamp): string
{
    if (!$timestamp) {
        return 'Unknown';
    }

    return date('M j, Y', strtotime($timestamp));
}
