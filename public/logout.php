<?php
session_start();
require_once __DIR__ . '/../config/db.php';
session_unset();
session_destroy();
header('Location: index.php');
exit;