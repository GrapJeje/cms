<?php
global $db;

if (!isset($_SESSION)) session_start();

require_once __DIR__ . '/vendor/autoload.php';
const ROOT_PATH = __DIR__ . '/';

use App\Database\Database;

$notes = Database::all('notes');
if (empty($notes)) $notes = [];

if ($_SESSION['user_id'] ?? null) {
    $user = Database::get('users', ['id' => $_SESSION['user_id']]);
    require 'views/index.php';
} else {
    $user = null;
    header("Location: login?msg=Authenticatie vereist. Log in om door te gaan.");
}

exit();
