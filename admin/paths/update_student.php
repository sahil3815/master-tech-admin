<?php
require_once("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set
    if (isset($_POST['id'], $_POST['full_name'], $_POST['dob'], $_POST['mob_no'], $_POST['aadhar_no'])) {
        
        // Sanitize input data to prevent SQL injection
        $id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
        $full_name = filter_var($_POST['full_name'], FILTER_SANITIZE_STRING);
        $dob = filter_var($_POST['dob'], FILTER_SANITIZE_STRING);
        $mob_no = filter_var($_POST['mob_no'], FILTER_SANITIZE_NUMBER_INT);
        $aadhar_no = filter_var($_POST['aadhar_no'], FILTER_SANITIZE_NUMBER_INT);
        
        try {
            // Prepare and execute the SQL update query
            $stmt = $conn->prepare("UPDATE students SET full_name = :full_name, dob = :dob, mob_no = :mob_no, aadhar_no = :aadhar_no WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':full_name', $full_name);
            $stmt->bindParam(':dob', $dob);
            $stmt->bindParam(':mob_no', $mob_no);
            $stmt->bindParam(':aadhar_no', $aadhar_no);

            $stmt->execute();

            // Check if update was successful
            $affectedRows = $stmt->rowCount();
            if ($affectedRows > 0) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'No rows were affected']);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Required fields are not set']);
    }
} else {
    header("Location: ../index.php"); // Redirect if accessed directly
    exit();
}
?>
