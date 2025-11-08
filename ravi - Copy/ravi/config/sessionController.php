<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';

$host = $_SERVER['HTTP_HOST'];

$base_url = $protocol . $host . '/views/';

if (!isset($_SESSION['codeuser'])) {
    header('Location: ' . $base_url . 'login.php');
    exit;
}
?>