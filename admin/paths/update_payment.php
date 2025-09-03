<?php
// Include the database connection
include_once('connect.php');

// Turn off error reporting for a production environment
// For debugging purposes, you can enable error reporting: error_reporting(E_ALL); ini_set('display_errors', 1);
ini_set('display_errors', '0'); // Disable error display for production

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $stu_id = $_POST['stu_id'];
    $amount = $_POST['amount'];
    $payment_date = $_POST['payment_date'];
    $ref_no = $_POST['receipt_no'];
    $pay_method = $_POST['pay_method'];
    
    // Generate a dynamic Payment ID (e.g., PAY-YYYYMMDDHHMMSS)
    $payment_id = 'PAY-' . date('YmdHis');  // This generates a unique payment ID using the current timestamp

    // Check if the required data is provided
    if (empty($stu_id) || empty($amount) || empty($payment_date) || empty($ref_no) || empty($payment_id)) {
        echo json_encode(['success' => false, 'message' => 'Please fill all required fields.']);
        exit;
    }

    try {
        // Start transaction
        $conn->beginTransaction();

        // 1. Retrieve the current pending amount of the student from the 'students' table
        $stmt = $conn->prepare("SELECT pnd_amt FROM students WHERE id = :stu_id");
        $stmt->bindParam(':stu_id', $stu_id);
        $stmt->execute();
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$student) {
            echo json_encode(['success' => false, 'message' => 'Student not found.']);
            exit;
        }

        // Calculate the new remaining fees
        $new_remaining = $student['pnd_amt'] - $amount;

        if ($new_remaining < 0) {
            echo json_encode(['success' => false, 'message' => 'Payment amount cannot exceed the pending fees.']);
            exit;
        }

        // 2. Insert the payment details into the 'fees' table
        $stmt = $conn->prepare("INSERT INTO fees (stu_id, payment_id, payment_date, amount, remaining, method, ref_no) 
                                VALUES (:stu_id, :payment_id, :payment_date, :amount, :remaining, :pay_method, :ref_no)");

        $stmt->bindParam(':stu_id', $stu_id);
        $stmt->bindParam(':payment_id', $payment_id); // Use the dynamic payment ID
        $stmt->bindParam(':payment_date', $payment_date);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':remaining', $new_remaining);
        $stmt->bindParam(':pay_method', $pay_method);
        $stmt->bindParam(':ref_no', $ref_no);
        $stmt->execute();

        // 3. Update the pending amount in the 'students' table
        $stmt = $conn->prepare("UPDATE students SET pnd_amt = :remaining WHERE id = :stu_id");
        $stmt->bindParam(':remaining', $new_remaining);
        $stmt->bindParam(':stu_id', $stu_id);
        $stmt->execute();

        // Commit the transaction
        $conn->commit();

        echo json_encode(['success' => true, 'message' => 'Payment updated successfully.']);
    } catch (Exception $e) {
        // Rollback the transaction if something goes wrong
        $conn->rollBack();
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
