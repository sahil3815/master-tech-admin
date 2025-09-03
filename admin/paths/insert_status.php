<?php
include_once('connect.php');

// Get the form data
$id = $_POST['id'];
$id2 = $_POST['id2'];
$status = $_POST['status'];

// Concatenate id and id2
$concatenatedId = $id2.$id;

// Insert data into the database
$stmt = $conn->prepare("INSERT INTO status (student_id,status) VALUES (?,?)");
$result = $stmt->execute([$concatenatedId,$status]);

if ($result) 
{
    echo json_encode(['success' => true]);
}
else
{
    // Something went wrong
    echo json_encode(['success' => false]);
}
?>
