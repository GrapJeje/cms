<?php
global $db;

if (!isset($_SESSION)) session_start();

require_once __DIR__ . '/vendor/autoload.php';

use App\Database\Database;

$notes = Database::all('notes');
$notes = $notes ?: [];

if (!$_SESSION['user_id'] ?? null) {
    header("Location: login?msg=Authenticatie vereist. Log in om door te gaan.");
    exit();
}

$user = Database::get('users', ['id' => $_SESSION['user_id']]);
require 'views/index.php';

echo '<script src="public/js/UrlCleaner.js"></script>';
