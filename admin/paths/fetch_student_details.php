<?php
// fetch_student_details.php

// Include the database connection script
include_once('connect.php');

// Check if the request method is POST and if the student_id is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["student_id"])) {
    try {
        // Fetch student details from the database based on the provided student ID
        $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->execute([$_POST["student_id"]]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($student) {
            // If student details are found, return them as JSON response
            echo json_encode($student);
        } else {
            // If no student is found with the provided ID, return an empty response or an error message
            echo json_encode(array("error" => "Student not found"));
        }
    } catch (PDOException $e) {
        // If an error occurs during database operation, return an error message
        echo json_encode(array("error" => "Database error: " . $e->getMessage()));
    }
} else {
    // If the request method is not POST or student ID is not set, return an error message
    echo json_encode(array("error" => "Invalid request"));
}
?>
