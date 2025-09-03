<?php
include_once('connect.php');

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
$new_payment_date = date('Y-m-d');
$new_method = $_POST['new_method'];
$new_ref_no = $_POST['new_ref_no'];
$new_payment_id = 'PAY-' . date('YmdHis');
$new_concatenatedId = $new_course_id . $new_id;

$stmt = $conn->prepare("INSERT INTO students (id, full_name, father_name, dob, doj, mob_no, email, aadhar_no, course, fees, reg_amt, pnd_amt, status) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$result = $stmt->execute([$new_concatenatedId, $new_fullName, $new_fatherName, $new_dob, $new_doj, $new_mobNo, $new_email, $new_aadharNo, $new_course, $new_fees, $new_reg_amt, $new_pnd_amt, $new_status]);

if ($result) {
    try {
        $conn->beginTransaction();
        
        $stmt = $conn->prepare("INSERT INTO fees (stu_id, payment_id, payment_date, amount, remaining, method, ref_no) 
            VALUES (:stu_id, :payment_id, :payment_date, :amount, :remaining, :method, :ref_no)");
        $stmt->bindParam(':stu_id', $new_concatenatedId);
        $stmt->bindParam(':payment_id', $new_payment_id);
        $stmt->bindParam(':payment_date', $new_payment_date);
        $stmt->bindParam(':amount', $new_reg_amt);
        $stmt->bindParam(':remaining', $new_pnd_amt);
        $stmt->bindParam(':method', $new_method);
        $stmt->bindParam(':ref_no', $new_ref_no);
        
        $stmt->execute();
        $conn->commit();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $conn->rollBack();
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => $stmt->errorInfo()]);
}
?>