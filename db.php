<?php
$host = "localhost";
$user = "root";
$pass = "root123";
$db   = "solar_db";
$use_pure=True;

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("DB Connection Failed");
}
