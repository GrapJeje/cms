<?php

require_once __DIR__ . '/app/Config/config.php';

session_start();
session_unset();
session_destroy();

header("Location: " . ROOT_PATH . "/login?msg=U bent uitgelogd");
exit();
