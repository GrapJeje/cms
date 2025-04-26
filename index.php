<?php

$notes = file_exists('data/notes.json') ? json_decode(file_get_contents('data/notes.json'), true) : [];
if (!is_array($notes)) $notes = [];

require 'views/index.php';
