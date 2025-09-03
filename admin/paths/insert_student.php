<?php
include_once('connect.php');
$id = $_POST['id'];
$fullName = $_POST['full_name'];
$dob = $_POST['dob'];
$doj = $_POST['doj'];
$mobNo = $_POST['mob_no'];
$aadharNo = $_POST['aadhar_no'];
$course = $_POST['course'];
$id2 = $_POST['id2'];
$status = $_POST['status'];
$email = $_POST['email'];
$fatherName = $_POST['father_name'];
$fees = $_POST['fees'];
$reg_amt = $_POST['reg_amt'];
$pnd_amt = $_POST['pnd_amt'];
$payment_date = date('Y-m-d');
$payment_id = 'PAY-' . date('YmdHis');
$ref_no = $_POST['ref_no'];
$method = $_POST['method'];
$concatenatedId = $id2.$id;

$stmt = $conn->prepare("INSERT INTO students (id, full_name, father_name, dob, doj, mob_no, email, aadhar_no, course, fees, reg_amt, pnd_amt, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,? ,?)");
$result = $stmt->execute([$concatenatedId, $fullName, $fatherName, $dob, $doj, $mobNo, $email, $aadharNo, $course, $fees, $reg_amt, $pnd_amt, $status]);

if ($result) {
    try {
        $conn->beginTransaction();
        $stmt = $conn->prepare("INSERT INTO fees (stu_id, payment_id, payment_date, amount, remaining, method, ref_no) 
                                VALUES (:stu_id, :payment_id, :payment_date, :amount, :remaining, :method, :ref_no)");

        $stmt->bindParam(':stu_id', $concatenatedId);
        $stmt->bindParam(':payment_id', $payment_id);
        $stmt->bindParam(':payment_date', $payment_date);
        $stmt->bindParam(':amount', $reg_amt);
        $stmt->bindParam(':remaining', $pnd_amt);
        $stmt->bindParam(':method', $method);
        $stmt->bindParam(':ref_no', $ref_no);
        $stmt->execute();
        $conn->commit();

        echo json_encode(['success' => true]);
    } 
    catch (Exception $e) 
    {
        $conn->rollBack();
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => $stmt->errorInfo()]);
}
?>
