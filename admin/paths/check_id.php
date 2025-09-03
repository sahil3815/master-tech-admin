<?php
include_once('connect.php');

$id = $_POST['id']; // Get the user id
$id2 = $_POST['id2']; // Get the id2

// Concatenate id and id2
$concatenatedId = $id2.$id;

$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$concatenatedId]); // Use the concatenated ID
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // ID exists
    echo json_encode(['exists' => true]);
} else {
    // ID does not exist
    echo json_encode(['exists' => false]);
}
?>
