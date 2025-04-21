<?php
// C:\xampp\htdocs\Lost_found_app\backend\config\db.php

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'lost_found_db';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

