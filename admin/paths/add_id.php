<?php
include_once('connect.php');

$new_id = $_POST['new_id']; 
$new_course_id = $_POST['new_course_id'];
$new_concatenatedId = $new_course_id . $new_id;

$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$new_concatenatedId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo json_encode(['exists' => true]);
} else {
    echo json_encode(['exists' => false]);
}
?>
