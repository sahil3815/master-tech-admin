<?php
session_start();
require_once("connect2.php");

header('Content-Type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mail/vendor/autoload.php'; // Include Composer's autoloader

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $email = $_POST['email'];

        // Generate new OTP
        $otp = mt_rand(100000, 999999); // Generate a 6 digit OTP

        // Store OTP in session
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email; // Store email in session

        // Send OTP via email (use your email sending function here)
        $mailSent = sendOTP($email, $otp);

        if ($mailSent) {
            echo json_encode(['status' => 'otp_sent', 'message' => 'OTP sent successfully to '.$email]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send OTP']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Email address is required']);
    }
}

// Function to send OTP email
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
        $mail->addAddress($email); // Send OTP to the user's email

        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for Admin Login (Resend)';

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
                <div class="header">Your OTP for Admin Login (Resend)</div>
                <p>Hello,</p>
                <p>You recently requested a One-Time Password (OTP) for logging into the admin panel. Please use the following OTP to complete your login:</p>
                <div class="otp">' . $otp . '</div>
                <p>This OTP is valid for 10 minutes. If you did not request this OTP, please ignore this email.</p>
                <div class="footer">Master Tech Education &copy; 2024</div>
            </div>
        </body>
        </html>';

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Mailer Error: ' . $mail->ErrorInfo);  // Log error for debugging
        return false; // If email fails to send
    }
}
?>
