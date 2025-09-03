<?php
// Include your database connection file
include_once('connect.php');

// Check if the POST data contains the student ID
if(isset($_POST['stu_id'])) {
    // Sanitize the input to prevent SQL injection
    $studentId = $_POST['stu_id'];

    // Fetch the student data using PDO
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->execute([$studentId]);
    $studentData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if student data is found
    if ($studentData) {
        // Return the student data as JSON
        echo json_encode($studentData);
    } else {
        // Return an error message if student not found
        echo json_encode(array('error' => 'Student not found'));
    }
} else {
    // If student ID is not provided, return an error message
    echo json_encode(array('error' => 'Student ID not provided'));
}
?>
