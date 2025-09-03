<?php
$servername = "localhost";
$username = "u812089401_mt_admin_db";
$password = "Sahil@3815";
$dbname = "u812089401_mt_user_admin";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}
?>