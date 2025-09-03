<?php
// paths/update_price.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the course id and price are set in the POST data
    if (isset($_POST["id"]) && isset($_POST["price"])) {
        // Sanitize and validate the input
        $courseId = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
        $newPrice = filter_input(INPUT_POST, "price", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        // Check if the input values are valid
        if ($courseId !== false && $newPrice !== false) {
            // Include the database connection file
            include_once('connect.php');

            // Prepare and execute the SQL update query
            $stmt = $conn->prepare("UPDATE course SET price = :newPrice WHERE id = :courseId");
            $stmt->bindParam(":newPrice", $newPrice);
            $stmt->bindParam(":courseId", $courseId);
            if ($stmt->execute()) {
                // Return success message if the update was successful
                echo "success";
            } else {
                // Return error message if the update failed
                echo "error";
            }
        } else {
            // Return error message if input validation fails
            echo "error";
        }
    } else {
        // Return error message if course id or price is not set in the POST data
        echo "error";
    }
} else {
    // Return error message if request method is not POST
    echo "error";
}
?>
