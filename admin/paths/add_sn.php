<?php
include_once('connect.php');

if (isset($_POST['new_course'])) {
    $selectedCourse = $_POST['new_course'];
    $stmt = $conn->prepare("SELECT short_name FROM course WHERE name = ?");
    $stmt->execute([$selectedCourse]);
    $courseData = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($courseData) {
        echo $courseData['short_name'];
    } else {
        echo json_encode(['error' => 'No short name found for the selected course']);
    }
} else {
    echo json_encode(['error' => 'Course not provided']);
}
?>
