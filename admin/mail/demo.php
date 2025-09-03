<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Dummy student data for testing
$_POST = [
    'new_id' => '1234',
    'new_full_name' => 'John Doe',
    'new_dob' => '1998-05-21',
    'new_doj' => '2025-06-15',
    'new_mob_no' => '9876543210',
    'new_aadhar_no' => '1234-5678-9012',
    'new_course' => 'Full Stack Development',
    'new_course_id' => 'FSD',
    'new_status' => 'Active',
    'new_email' => 'sahilpayal81@gmail.com',
    'new_father_name' => 'Robert Doe',
    'new_fees' => '45000',
    'new_reg_amt' => '5000',
    'new_pnd_amt' => '40000'
];

if (isset($_POST['new_id'])) {
    // Fetch POST data
    extract($_POST);
    $new_concatenatedId = $new_course_id . $new_id;

    // Dummy payment data
    $fees = [
        'payment_id' => 'PAY123456',
        'payment_date' => '2025-06-20',
        'amount' => '5000',
        'remaining' => '40000',
        'ref_no' => 'INV2025-00123',
        'method' => 'UPI - Google Pay'
    ];

    // Load logo from remote URL and convert to base64
    $logoURL = 'https://admin.mastertecheducation.in/admin/assets/images/logo.jpeg';
    $logoData = @file_get_contents($logoURL);
    $logoSrc = $logoData ? 'data:image/jpeg;base64,' . base64_encode($logoData) : '';

    // Start HTML content
    $htmlContent = '
        <html>
        <head>
            <style>
                @font-face {
                    font-family: "DejaVu Sans";
                    src: url("fonts/DejaVuSans.ttf") format("truetype");
                }
                body {
                    font-family: "DejaVu Sans", sans-serif;
                    color: #333;
                    background: #ffffff;
                    margin: 0;
                    padding: 20px;
                }
                .wrapper {
                    max-width: 800px;
                    margin: auto;
                    border: 1px solid #ccc;
                    padding: 40px;
                    border-radius: 8px;
                }
                .header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    border-bottom: 2px solid #000;
                    padding-bottom: 10px;
                    margin-bottom: 30px;
                }
                .header img {
                    max-height: 60px;
                }
                .header .title {
                    font-size: 22px;
                    font-weight: bold;
                    text-align: right;
                }
                .contact-info {
                    text-align: right;
                    font-size: 12px;
                    margin-bottom: 30px;
                    line-height: 1.4;
                }
                .contact-info p {
                    margin: 2px 0;
                }
                .section-title {
                    font-size: 18px;
                    border-bottom: 1px solid #000;
                    margin-top: 20px;
                    margin-bottom: 10px;
                    padding-bottom: 4px;
                }
                .info-table {
                    width: 100%;
                    font-size: 14px;
                    border-collapse: collapse;
                }
                .info-table td {
                    padding: 8px 5px;
                }
                .info-table td.label {
                    font-weight: bold;
                    width: 30%;
                }
                .invoice-box {
                    margin-top: 20px;
                    font-size: 14px;
                }
                .invoice-box table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 10px;
                }
                .invoice-box th, .invoice-box td {
                    border: 1px solid #888;
                    padding: 10px;
                    text-align: left;
                }
                .invoice-box th {
                    background-color: #f2f2f2;
                }
                .footer {
                    text-align: center;
                    font-size: 12px;
                    margin-top: 40px;
                    color: #555;
                }
            </style>
        </head>
        <body>
        <div class="wrapper">
            <div class="header">
                ' . ($logoSrc ? '<img src="' . $logoSrc . '" alt="Logo">' : '') . '
                <div class="title">Student Registration Profile</div>
            </div>
        
            <div class="contact-info">
                <p><strong>Phone:</strong> +91-9876543210</p>
                <p><strong>Email:</strong> info@mastertecheducation.in</p>
                <p><strong>Website:</strong> www.mastertecheducation.in</p>
                <p><strong>Privacy Policy:</strong> www.mastertecheducation.in/privacy-policy</p>
            </div>
        
            <div class="section-title">Student Details</div>
            <table class="info-table">
                <tr><td class="label">Full Name:</td><td>' . htmlspecialchars($new_full_name) . '</td></tr>
                <tr><td class="label">Father\'s Name:</td><td>' . htmlspecialchars($new_father_name) . '</td></tr>
                <tr><td class="label">Email:</td><td>' . htmlspecialchars($new_email) . '</td></tr>
                <tr><td class="label">Phone:</td><td>' . htmlspecialchars($new_mob_no) . '</td></tr>
                <tr><td class="label">Aadhaar No.:</td><td>' . htmlspecialchars($new_aadhar_no) . '</td></tr>
                <tr><td class="label">Date of Birth:</td><td>' . htmlspecialchars($new_dob) . '</td></tr>
                <tr><td class="label">Date of Joining:</td><td>' . htmlspecialchars($new_doj) . '</td></tr>
                <tr><td class="label">Course:</td><td>' . htmlspecialchars($new_course) . '</td></tr>
                <tr><td class="label">Total Fees:</td><td>₹' . htmlspecialchars($new_fees) . '</td></tr>
                <tr><td class="label">Registration Paid:</td><td>₹' . htmlspecialchars($new_reg_amt) . '</td></tr>
                <tr><td class="label">Pending Fees:</td><td>₹' . htmlspecialchars($new_pnd_amt) . '</td></tr>
            </table>
        
            <div class="section-title">Invoice Details</div>
            <div class="invoice-box">
                <table>
                    <tr>
                        <th>Invoice No.</th>
                        <th>Date</th>
                        <th>Student ID</th>
                        <th>Payment Method</th>
                    </tr>
                    <tr>
                        <td>' . htmlspecialchars($fees['ref_no']) . '</td>
                        <td>' . htmlspecialchars($fees['payment_date']) . '</td>
                        <td>' . htmlspecialchars($new_concatenatedId) . '</td>
                        <td>' . htmlspecialchars($fees['method']) . '</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Amount Paid</th>
                        <th>Remaining Fees</th>
                    </tr>
                    <tr>
                        <td>₹' . htmlspecialchars($fees['amount']) . '</td>
                        <td>₹' . htmlspecialchars($fees['remaining']) . '</td>
                    </tr>
                </table>
            </div>
        
            <div class="footer">
                <p><strong>Master Tech Education</strong><br>
                Empowering Your Future Through Skill-Based Learning</p>
                <p>&copy; ' . date("Y") . ' Master Tech Education. All Rights Reserved.</p>
            </div>
        </div>
        </body>
        </html>';


    // Generate PDF
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $options->set('defaultFont', 'DejaVu Sans');
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($htmlContent);
    $dompdf->render();
    $pdfContent = $dompdf->output();

    // Save PDF (optional)
    $pdfFile = 'student_profile_invoice_' . $new_concatenatedId . '.pdf';
    file_put_contents($pdfFile, $pdfContent);

    // Send Email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'info@mastertecheducation.in';
        $mail->Password = 'Control@75';
        $mail->setFrom('info@mastertecheducation.in', 'Master Tech Education');
        $mail->addAddress($new_email, $new_full_name);
        $mail->Subject = 'Welcome to Master Tech Education';
        $mail->isHTML(true);
        $mail->Body = "
            <p>Dear <strong>$new_full_name</strong>,</p>
            <p>Welcome to <strong>Master Tech Education</strong>!</p>
            <p>Please find your student profile and payment invoice attached as a PDF.</p>
            <p>Regards,<br>Team Master Tech</p>
        ";
        $mail->addStringAttachment($pdfContent, $pdfFile);
        $mail->send();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $mail->ErrorInfo]);
    }
} else {
    echo 'Invalid request!';
}
