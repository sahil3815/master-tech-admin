<?php
include_once('connect.php');

if (isset($_POST['new_course'])) {
    $selectedCourse = $_POST['new_course'];
    $stmt = $conn->prepare("SELECT price FROM course WHERE name = ?");
    $stmt->execute([$selectedCourse]);
    $courseData = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($courseData) {
        echo $courseData['price'];
    } else {
        echo json_encode(['error' => 'No price found for the selected course']);
    }
} else {
    echo json_encode(['error' => 'Course not provided']);
}
?>
