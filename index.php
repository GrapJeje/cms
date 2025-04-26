<?php
global $db;

require_once __DIR__ . '/vendor/autoload.php';

use App\Database\Database;

$notes = Database::all('notes');
if (empty($notes)) $notes = [];

require 'views/index.php';
