<?php
session_start();

// Ensure we only return JSON
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if OTP is in the session and if the POST contains an OTP
    if (isset($_SESSION['otp']) && isset($_POST['otp'])) {
        $otpEntered = $_POST['otp'];

        // Verify OTP
        if ($otpEntered == $_SESSION['otp']) {
            // OTP matches, set session variables for the user
            if (isset($_SESSION['email'])) {
                $email = $_SESSION['email'];

                // You might want to retrieve user information from the database to store in session
                // Example: Retrieve user data based on the email (if needed)
                require_once("connect2.php");
                $result = $conn->query("SELECT * FROM admin WHERE email='$email'");
                $row = $result->fetch_assoc();

                // Set user session variables after OTP is verified
                $_SESSION['name'] = $row['name'];  // Set the user name or other details
                $_SESSION['email'] = $row['email'];  // Ensure email is stored
                $_SESSION['username'] = $row['username'];
                $_SESSION['id'] = $row['id'];  // User ID (if needed)
                $_SESSION['login_timestamp'] = time(); // Store the login timestamp

                // Return a success message and redirect the user to the dashboard
                echo json_encode(['status' => 'success', 'message' => 'OTP verified successfully']);
                exit();
            } else {
                // If email is not found in session, it's an error
                echo json_encode(['status' => 'error', 'message' => 'Session expired or email not set']);
                exit();
            }
        } else {
            // OTP doesn't match
            echo json_encode(['status' => 'error', 'message' => 'Invalid OTP']);
            exit();
        }
    } else {
        // Missing OTP or session data
        echo json_encode(['status' => 'error', 'message' => 'OTP session expired']);
        exit();
    }
}
?>
