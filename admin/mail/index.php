<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dompdf\Dompdf;
use Dompdf\Options;

// Ensure the student ID is passed
if (isset($_POST['stu_id'])) {
    $student_id = $_POST['stu_id'];
    
    // Include your database connection
    include_once('../paths/connect.php');
    
    // Fetch student details
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = :student_id");
    $stmt->bindParam(':student_id', $student_id);
    $stmt->execute();
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($student) {
        // Generate PDF of the student's profile with enhanced design
        $htmlContent = '
        <html>
            <head>
                <style>
                    body {
                        font-family: "Arial", sans-serif;
                        background-color: #f4f4f4;
                        margin: 0;
                        padding: 0;
                    }
                    .container {
                        width: 80%;
                        margin: 50px auto;
                        background-color: #fff;
                        padding: 20px;
                        border-radius: 10px;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    }
                    .header {
                        text-align: center;
                        margin-bottom: 30px;
                    }
                    .header h2 {
                        color: #4CAF50;
                        font-size: 28px;
                    }
                    .header p {
                        color: #888;
                        font-size: 16px;
                    }
                    .profile-details {
                        margin: 20px 0;
                    }
                    .profile-details h4 {
                        color: #333;
                        font-size: 20px;
                        margin-bottom: 15px;
                    }
                    .profile-details p {
                        font-size: 16px;
                        color: #555;
                        margin-bottom: 8px;
                    }
                    .profile-details .key {
                        font-weight: bold;
                    }
                    .footer {
                        margin-top: 30px;
                        text-align: center;
                        font-size: 14px;
                        color: #777;
                    }
                    .footer p {
                        margin: 5px 0;
                    }
                    .table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;
                    }
                    .table th, .table td {
                        border: 1px solid #ddd;
                        padding: 10px;
                        text-align: left;
                    }
                    .table th {
                        background-color: #f2f2f2;
                        color: #333;
                    }
                    .table td {
                        background-color: #f9f9f9;
                    }
                    .table .amount {
                        color: #4CAF50;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h2>Student Profile</h2>
                        <p>Below are the details of the student. Please find attached the full profile PDF.</p>
                    </div>
                    
                    <div class="profile-details">
                        <h4>Student Details</h4>
                        <p><span class="key">Full Name:</span> ' . htmlspecialchars($student['full_name']) . '</p>
                        <p><span class="key">Father\'s Name:</span> ' . htmlspecialchars($student['father_name']) . '</p>
                        <p><span class="key">Email:</span> ' . htmlspecialchars($student['email']) . '</p>
                        <p><span class="key">Phone:</span> ' . htmlspecialchars($student['mob_no']) . '</p>
                        <p><span class="key">Aadhar No:</span> ' . htmlspecialchars($student['aadhar_no']) . '</p>
                        <p><span class="key">Date of Birth:</span> ' . htmlspecialchars($student['dob']) . '</p>
                        <p><span class="key">Course:</span> ' . htmlspecialchars($student['course']) . '</p>
                        <p><span class="key">Fees:</span> ' . htmlspecialchars($student['fees']) . '</p>
                        <p><span class="key">Status:</span> ' . htmlspecialchars($student['status']) . '</p>
                    </div>

                    <div class="footer">
                        <p>&copy; ' . date("Y") . ' Master Tech Education. All Rights Reserved.</p>
                    </div>
                </div>
            </body>
        </html>';

        // Initialize Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($htmlContent);
        $dompdf->render();
        $pdfContent = $dompdf->output();
        
        // Save the PDF to a file
        $pdfFile = 'student_profile_' . $student_id . '.pdf';
        file_put_contents($pdfFile, $pdfContent);

        // Send email
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->Username = 'info@mastertecheducation.in';
            $mail->Password = 'Control@75';
            $mail->setFrom('info@mastertecheducation.in', 'Master Tech Education');
            $mail->addAddress($student['email'], $student['full_name']);
            $mail->Subject = 'Your Profile Details from Master Tech Education';
            
            // Email Body
            $mail->isHTML(true);
            $mail->Body = "
                <p>Dear " . htmlspecialchars($student['full_name']) . ",</p>
                <p>We hope this email finds you well. Below are your profile details:</p>
                <p><strong>Full Name:</strong> " . htmlspecialchars($student['full_name']) . "</p>
                <p><strong>Father's Name:</strong> " . htmlspecialchars($student['father_name']) . "</p>
                <p><strong>Email:</strong> " . htmlspecialchars($student['email']) . "</p>
                <p><strong>Phone:</strong> " . htmlspecialchars($student['mob_no']) . "</p>
                <p><strong>Aadhar No:</strong> " . htmlspecialchars($student['aadhar_no']) . "</p>
                <p><strong>Course:</strong> " . htmlspecialchars($student['course']) . "</p>
                <p><strong>Status:</strong> " . htmlspecialchars($student['status']) . "</p>
                <p>Attached is a PDF containing your full profile details.</p>
                <p>Best regards,<br>Master Tech Education Team</p>
            ";

            // Attach the generated PDF
            $mail->addStringAttachment($pdfContent, $pdfFile);

            // Send the email
            if ($mail->send()) {
                echo 'Email sent successfully!';
            } else {
                echo 'Email could not be sent. Please try again.';
            }
        } catch (Exception $e) {
            echo "Error: {$mail->ErrorInfo}";
        }
    } else {
        echo 'Student not found!';
    }
} else {
    echo 'Invalid request!';
}
?>
