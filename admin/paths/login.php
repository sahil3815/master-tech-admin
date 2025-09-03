<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
$message = "";
require_once("connect2.php"); // Include the database connection file

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mail/vendor/autoload.php'; // Include Composer's autoloader

// Function to generate a random OTP
function generateOTP() {
    return mt_rand(100000, 999999); // Generate a 6 digit OTP
}

// Function to send OTP via email
function sendOTP($email, $otp) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'do_not_reply@mastertecheducation.com';
        $mail->Password = 'Control@75';
        $mail->setFrom('do_not_reply@mastertecheducation.com', 'Master Tech Education');
        $mail->addAddress($email); // Admin's email to receive the OTP

        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for Admin Login';
        
        // Custom HTML and inline CSS for a better email design
        $mail->Body = '
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f9;
                    padding: 20px;
                }
                .container {
                    background-color: #ffffff;
                    padding: 30px;
                    border-radius: 10px;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                    width: 100%;
                    max-width: 600px;
                    margin: 0 auto;
                }
                .header {
                    text-align: center;
                    font-size: 24px;
                    font-weight: bold;
                    color: #333;
                }
                .otp {
                    font-size: 32px;
                    color: #2c3e50;
                    background-color: #ecf0f1;
                    padding: 15px;
                    border-radius: 5px;
                    display: inline-block;
                    margin: 20px 0;
                }
                .footer {
                    text-align: center;
                    font-size: 12px;
                    color: #777;
                    margin-top: 20px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">Your OTP for Admin Login</div>
                <p>Hello,</p>
                <p>You requested an OTP for logging into the admin panel. Please use the following One-Time Password (OTP) to complete your login:</p>
                <div class="otp">' . $otp . '</div>
                <p>This OTP is valid for 10 minutes. If you did not request this OTP, please ignore this email.</p>
                <div class="footer">Master Tech Education &copy; 2024</div>
            </div>
        </body>
        </html>';

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false; // If email fails to send
    }
}

header('Content-Type: application/json'); // Ensure content type is JSON

// Start processing the login form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["user_name"]) || empty($_POST["password"])) {
        echo json_encode(['status' => 'error', 'message' => 'Username and Password are required!']);
        exit();
    }

    $username = $conn->real_escape_string($_POST["user_name"]);
    $password = $conn->real_escape_string($_POST["password"]);

    // Query the database to check the credentials
    $result = $conn->query("SELECT * FROM admin WHERE (email='$username' OR username='$username') AND password='$password'");
    $row = $result->fetch_assoc();

    // If user is found
    if ($row !== null) {
        // Generate and send OTP
        $otp = generateOTP();
        $email = $row['email'];

        if (sendOTP($email, $otp)) {
            // Store OTP in session for verification
            $_SESSION['otp'] = $otp;
            $_SESSION['email'] = $email;

            // Send response for OTP
            echo json_encode(['status' => 'otp_sent', 'email' => $email]); // Ensure this is a valid JSON
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send OTP!']); // Ensure this is a valid JSON
            exit();
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Username or Password!']); // Ensure this is a valid JSON
        exit();
    }
}
?>
