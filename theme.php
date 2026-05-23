<?php
session_start();

if (isset($_GET['theme'])) {
    $_SESSION['theme'] = $_GET['theme'];
    exit();
}

echo $_SESSION['theme'] ?? 'light';
