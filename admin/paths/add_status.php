<?php
include_once('connect.php');

$new_id = $_POST['new_id'];
$new_course_id = $_POST['new_course_id'];
$new_status = $_POST['new_status'];
$new_concatenatedId = $new_course_id . $new_id;

$stmt = $conn->prepare("INSERT INTO status (student_id, status) VALUES (?, ?)");
$result = $stmt->execute([$new_concatenatedId, $new_status]);

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
