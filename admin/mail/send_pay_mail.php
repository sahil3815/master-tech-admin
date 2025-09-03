<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dompdf\Dompdf;
use Dompdf\Options;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect the POST data
    $stu_id = $_POST['stu_id'];  // Get student ID from POST
    $amount = $_POST['amount'];
    $payment_date = $_POST['payment_date'];
    $payment_id = 'PAY-' . date('YmdHis');  // Generate unique payment ID

    // Query student and fee information based on the student ID
    include_once('../paths/connect.php');

    // Fetch student's remaining fee amount (pnd_amt)
    $stmt = $conn->prepare("SELECT pnd_amt FROM students WHERE id = :stu_id LIMIT 1");
    $stmt->bindParam(':stu_id', $stu_id);
    $stmt->execute();
    $studentData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the student exists and has remaining fees
    if (!$studentData) {
        echo json_encode(['success' => false, 'message' => 'Student not found']);
        exit;
    }

    // Fetch the remaining amount from the student's data
    $new_remaining = $studentData['pnd_amt'];  // Fetch the pending fees (remaining)

    // Fetch student details
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = :stu_id LIMIT 1");
    $stmt->bindParam(':stu_id', $stu_id);
    $stmt->execute();
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the student record exists
    if (!$student) {
        echo json_encode(['success' => false, 'message' => 'Student not found']);
        exit;
    }

    // Get fee record for this student
    $stmt = $conn->prepare("SELECT * FROM fees WHERE stu_id = :stu_id LIMIT 1");
    $stmt->bindParam(':stu_id', $stu_id);
    $stmt->execute();
    $fees = $stmt->fetch(PDO::FETCH_ASSOC);

    // If no fee record exists
    if (!$fees) {
        echo json_encode(['success' => false, 'message' => 'No fee record found']);
        exit;
    }

    // Collect all the required student data
    $student_name = $student['full_name'];
    $student_email = $student['email'];

    // Generate the HTML content for the email
    $htmlContent = "
    <html>
    <body>
        <h2>Payment Confirmation</h2>
        <p><strong>Student Name:</strong> $student_name</p>
        <p><strong>Payment ID:</strong> $payment_id</p>
        <p><strong>Amount Paid:</strong> ₹$amount</p>
        <p><strong>Payment Date:</strong> $payment_date</p>
        <p><strong>Remaining Fees:</strong> ₹$new_remaining</p>
        <p>Thank you for your payment!</p>
    </body>
    </html>";

    // Generate the PDF for Payment (using DomPDF)
    $pdfContent = generatePDF($student_name, $payment_id, $amount, $payment_date, $new_remaining);

    // Send the email with the PDF attachment
    $emailResult = sendPaymentEmail($student_email, $student_name, $pdfContent);

    // Return success or failure response
    if ($emailResult['success']) {
        echo json_encode(['success' => true, 'message' => 'Payment email sent successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => $emailResult['message']]);
    }
}

// Function to generate the PDF content
// Function to generate the PDF content
function generatePDF($student_name, $payment_id, $amount, $payment_date, $remaining) {
    // Ensure all the necessary variables are being passed correctly
    // Handle cases where the value is not available
    if (!$amount) {
        $amount = 'N/A';  // Default if amount is missing
    }
    if (!$remaining) {
        $remaining = 'N/A';  // Default if remaining is missing
    }

    // Define the styled HTML content
    $html = "
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;  /* Use DejaVu Sans for better character support */
            margin: 0;
            padding: 30px;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 28px;
            margin: 0;
            color: #333;
        }
        .header h2 {
            font-size: 20px;
            margin: 0;
            color: #4CAF50;
        }
        .content {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }
        .content p {
            margin: 10px 0;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        .invoice-table th, .invoice-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .invoice-table th {
            background-color: #f2f2f2;
            color: #333;
        }
        .invoice-table td {
            color: #333;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
            color: #555;
        }
        .footer p {
            margin: 5px 0;
        }
        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
    <div class='container'>
        <div class='header'>
            <h1>Payment Invoice</h1>
            <h2>Student Payment Details</h2>
        </div>
        <div class='content'>
            <p><strong>Student Name:</strong> $student_name</p>
            <p><strong>Payment ID:</strong> $payment_id</p>
            <p><strong>Amount Paid:</strong> &#8377;$amount</p> <!-- Use HTML entity for ₹ -->
            <p><strong>Payment Date:</strong> $payment_date</p>
            <p><strong>Remaining Fees:</strong> &#8377;$remaining</p> <!-- Use HTML entity for ₹ -->
        </div>
        <table class='invoice-table'>
            <tr>
                <th>Payment Details</th>
                <th>Amount</th>
            </tr>
            <tr>
                <td>Payment ID</td>
                <td>$payment_id</td>
            </tr>
            <tr>
                <td>Student Name</td>
                <td>$student_name</td>
            </tr>
            <tr>
                <td>Amount Paid</td>
                <td>&#8377;$amount</td> <!-- Use HTML entity for ₹ -->
            </tr>
            <tr>
                <td>Payment Date</td>
                <td>$payment_date</td>
            </tr>
            <tr>
                <td>Remaining Fees</td>
                <td>&#8377;$remaining</td> <!-- Use HTML entity for ₹ -->
            </tr>
        </table>
        <div class='footer'>
            <p><strong>Master Tech Education</strong> | Empowering Your Future Through Skill-Based Learning</p>
            <p>Visit: <a href='https://www.mastertecheducation.in' target='_blank'>www.mastertecheducation.in</a> | Email: <a href='mailto:info@mastertecheducation.in'>info@mastertecheducation.in</a></p>
            <p>&copy; " . date("Y") . " Master Tech Education. All Rights Reserved.</p>
        </div>
    </div>";

    // Initialize Dompdf
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->render();

    return $dompdf->output(); // Return the generated PDF as content
}


// Function to send the email with the PDF attached
function sendPaymentEmail($toEmail, $studentName, $pdfContent) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';  // SMTP server
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'accounts@mastertecheducation.in';
        $mail->Password = 'Control@75';
        $mail->setFrom('accounts@mastertecheducation.in', 'Master Tech Education');
        $mail->addAddress($toEmail, $studentName);
        $mail->Subject = 'Payment Confirmation - ' . date('YmdHis');
        $mail->isHTML(true);
        $mail->Body = "
            <p>Dear $studentName,</p>
            <p>Thank you for your payment. Please find the attached invoice for your reference.</p>
        ";

        // Add PDF as attachment
        $pdfFile = 'payment_invoice_' . date('YmdHis') . '.pdf';
        $mail->addStringAttachment($pdfContent, $pdfFile);

        $mail->send();
        return ['success' => true, 'message' => 'Email sent successfully'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Mailer Error: ' . $mail->ErrorInfo];
    }
}
?>
