<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    if(isset($_POST['id'])) {
        include_once('connect.php'); // Include your database connection
        
        $fileId = $_POST['id']; // Get the file ID (certificate ID) passed from AJAX

        // Prepare the delete statement for the file record
        $stmt = $conn->prepare("DELETE FROM files WHERE cert_id = :fileId");
        $stmt->bindParam(':fileId', $fileId, PDO::PARAM_STR);

        // Execute the query
        $stmt->execute();

        // Check if any row was affected (deleted)
        if ($stmt->rowCount() > 0) {
            echo 'success'; // Return success message
            exit();
        } else {
            echo 'error'; // Return error if no row was deleted
            exit();
        }
    } else {
        echo 'error'; // Return error if no file_id was provided
        exit();
    }
} else {
    echo 'error'; // Return error if the request is not an AJAX request
    exit();
}
?>
