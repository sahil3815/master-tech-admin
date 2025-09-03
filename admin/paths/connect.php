<?php
try {
$servername = "localhost";
$username = "u812089401_mt_admin_db";
$password = "Sahil@3815";
$dbname = "u812089401_mt_user_admin";

    $conn = new PDO(
        "mysql:host=$servername;dbname=$dbname",
        $username,
        $password
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch courses from the database
    $stmt = $conn->prepare("SELECT name FROM course");
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit(); // Terminate script execution if connection fails
}
?>