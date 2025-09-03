<?php
// Include your database connection file
include_once('connect.php');

// Check if the POST data contains the selected course
if(isset($_POST['course'])) {
    // Sanitize the input to prevent SQL injection
    $selectedCourse = $_POST['course'];

    // Fetch the student data based on the selected course using PDO
    $stmt = $conn->prepare("SELECT short_name FROM course WHERE name = ?");
    $stmt->execute([$selectedCourse]);
    $studentData = $stmt->fetch(PDO::FETCH_ASSOC); // Using fetch instead of fetchAll

    // Check if student data is found
    if ($studentData) {
        // Return the short name directly
        echo $studentData['short_name'];
    } else {
        // Return an error message if no students found for the selected course
        echo json_encode(array('error' => 'No short name found for the selected course'));
    }
} else {
    // If course is not provided, return an error message
    echo json_encode(array('error' => 'Course not provided'));
}
?>
