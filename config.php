<?php

session_start();

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "bankly_v2";

$conn = new mysqli($host, $user, $pass, $dbname, 3308);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>