<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dompdf\Dompdf;
use Dompdf\Options;

if (isset($_POST['new_id'])) {
    // Collect dynamic POST data
    $new_id = $_POST['new_id'];
    $new_fullName = $_POST['new_full_name'];
    $new_dob = $_POST['new_dob'];
    $new_doj = $_POST['new_doj'];
    $new_mobNo = $_POST['new_mob_no'];
    $new_aadharNo = $_POST['new_aadhar_no'];
    $new_course = $_POST['new_course'];
    $new_course_id = $_POST['new_course_id'];
    $new_status = $_POST['new_status'];
    $new_email = $_POST['new_email'];
    $new_fatherName = $_POST['new_father_name'];
    $new_fees = $_POST['new_fees'];
    $new_reg_amt = $_POST['new_reg_amt'];
    $new_pnd_amt = $_POST['new_pnd_amt'];
    $new_concatenatedId = $new_course_id . $new_id;

    // Connect to DB
    include_once('../paths/connect.php');

    // Get fee record from DB
    $stmt = $conn->prepare("SELECT * FROM fees WHERE stu_id = :student_id LIMIT 1");
    $stmt->bindParam(':student_id', $new_concatenatedId);
    $stmt->execute();
    $fees = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch and encode logo
    $logoURL = 'https://admin.mastertecheducation.in/admin/assets/images/logo.jpeg';
    $logoData = @file_get_contents($logoURL);
    $logoSrc = $logoData ? 'data:image/jpeg;base64,' . base64_encode($logoData) : '';

    // Build HTML
    $htmlContent = '
    <html>
    <head>
        <style>
            body {
                font-family: "DejaVu Sans", sans-serif;
                margin: 0;
                padding: 20px;
                background: #fff;
                color: #333;
            }
            .container {
                width: 90%;
                margin: 0 auto;
                border: 1px solid #ccc;
                border-radius: 8px;
                padding: 30px;
            }
            .header {
                text-align: center;
                border-bottom: 2px solid #4CAF50;
                margin-bottom: 20px;
                padding-bottom: 10px;
            }
            .header img {
                max-height: 70px;
            }
            .header h1 {
                font-size: 24px;
                color: #4CAF50;
            }
            .section-title {
                font-size: 18px;
                border-bottom: 1px solid #aaa;
                margin-top: 30px;
                margin-bottom: 10px;
                padding-bottom: 5px;
            }
            .profile-details p {
                font-size: 14px;
                margin: 6px 0;
            }
            .profile-details .key {
                font-weight: bold;
            }
            .invoice-box {
                margin-top: 20px;
                border: 1px solid #ccc;
                padding: 15px;
            }
            .invoice-box table {
                width: 100%;
                border-collapse: collapse;
                font-size: 14px;
            }
            .invoice-box th, .invoice-box td {
                border: 1px solid #ddd;
                padding: 10px;
                text-align: left;
            }
            .invoice-box th {
                background-color: #f9f9f9;
            }
            .footer {
                margin-top: 40px;
                text-align: center;
                font-size: 12px;
                color: #555;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                ' . ($logoSrc ? '<img src="' . $logoSrc . '" alt="Logo">' : '') . '
                <h1>Student Registration Profile</h1>
            </div>

            <div class="section-title">Student Details</div>
            <div class="profile-details">
                <p><span class="key">Full Name:</span> ' . htmlspecialchars($new_fullName) . '</p>
                <p><span class="key">Father\'s Name:</span> ' . htmlspecialchars($new_fatherName) . '</p>
                <p><span class="key">Email:</span> ' . htmlspecialchars($new_email) . '</p>
                <p><span class="key">Phone:</span> ' . htmlspecialchars($new_mobNo) . '</p>
                <p><span class="key">Aadhaar No.:</span> ' . htmlspecialchars($new_aadharNo) . '</p>
                <p><span class="key">Date of Birth:</span> ' . htmlspecialchars($new_dob) . '</p>
                <p><span class="key">Date of Joining:</span> ' . htmlspecialchars($new_doj) . '</p>
                <p><span class="key">Course:</span> ' . htmlspecialchars($new_course) . '</p>
                <p><span class="key">Total Fees:</span> ₹' . htmlspecialchars($new_fees) . '</p>
                <p><span class="key">Registration Paid:</span> ₹' . htmlspecialchars($new_reg_amt) . '</p>
                <p><span class="key">Pending Fees:</span> ₹' . htmlspecialchars($new_pnd_amt) . '</p>
            </div>

            <div class="section-title">Invoice Details</div>
            <div class="invoice-box">
                <table>
                    <tr>
                        <th>Invoice No.</th>
                        <th>Invoice Date</th>
                        <th>Student ID</th>
                        <th>Payment Method</th>
                    </tr>
                    <tr>
                        <td>' . htmlspecialchars($fees['ref_no']) . '</td>
                        <td>' . htmlspecialchars($fees['payment_date']) . '</td>
                        <td>' . htmlspecialchars($new_concatenatedId) . '</td>
                        <td>' . htmlspecialchars($fees['method']) . '</td>
                    </tr>
                    <tr>
                        <th>Amount Paid</th>
                        <td colspan="3">₹' . htmlspecialchars($fees['amount']) . '</td>
                    </tr>
                    <tr>
                        <th>Remaining Fees</th>
                        <td colspan="3">₹' . htmlspecialchars($fees['remaining']) . '</td>
                    </tr>
                </table>
            </div>

            <div class="footer">
                <p><strong>Master Tech Education</strong> | Empowering Your Future Through Skill-Based Learning</p>
                <p>Visit: www.mastertecheducation.in | Email: info@mastertecheducation.in</p>
                <p>&copy; ' . date("Y") . ' Master Tech Education. All Rights Reserved.</p>
            </div>
        </div>
    </body>
    </html>';

    // PDF Generation
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $options->set('defaultFont', 'DejaVu Sans');
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($htmlContent);
    $dompdf->render();
    $pdfContent = $dompdf->output();

    $pdfFile = 'student_profile_payment_' . $new_concatenatedId . '.pdf';
    file_put_contents($pdfFile, $pdfContent);

    // Email Sending
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'info@mastertecheducation.in';
        $mail->Password = 'Control@75';
        $mail->setFrom('info@mastertecheducation.in', 'Master Tech Education');
        $mail->addAddress($new_email, $new_fullName);
        $mail->Subject = 'Welcome to Master Tech Education';
        $mail->isHTML(true);
        $mail->Body = "
            <p>Dear <strong>" . htmlspecialchars($new_fullName) . ",</strong></p>
            
            <p>Welcome to <strong>Master Tech Education</strong>! 🎉</p>
            
            <p>We are thrilled to have you as a part of our community. Our mission is to provide the best learning experience, and we are excited to accompany you on your educational journey. Below, you will find your profile details and payment information, which have been attached as a combined PDF for your reference.</p>
            
            <p>At Master Tech Education, we are committed to supporting you every step of the way. Should you have any questions or need assistance, feel free to reach out to us. We are always here to help!</p>
        
            <p><strong>Your Next Steps:</strong></p>
            <ul>
                <li>Ensure your profile details are up-to-date.</li>
                <li>Review your payment status and keep track of your fees.</li>
                <li>Stay tuned for exciting updates and offers.</li>
            </ul>
        
            <p>If you haven’t done so already, please make sure to provide your passport-sized photo for profile updation. You can submit it to your nearest offline center or ignore this if it has already been submitted.</p>
            
            <p>We look forward to being a part of your success story!</p>
            
            <p><strong>Stay Connected:</strong></p>
            <p>For any inquiries or support, feel free to visit our website or contact us:</p>
            <ul>
                <li><a href='https://www.mastertecheducation.in' target='_blank'>Visit our Website</a></li>
                <li><a href='https://www.mastertecheducation.in/privacy-policy' target='_blank'>Privacy Policy</a></li>
            </ul>
        
            <p>Best regards,<br><br>The Master Tech Education Team</p>
            <p><em>&copy; " . date("Y") . " Master Tech Education. All Rights Reserved.</em></p>
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
