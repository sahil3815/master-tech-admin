<?php
session_start();
if (!isset($_SESSION["name"])) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

include_once('connect.php');

try {
    $student_id = $_POST['stu_id'] ?? '';
    $full_name = trim($_POST['full_name'] ?? '');
    $father_name = trim($_POST['father_name'] ?? '');
    $dob = $_POST['dob'] ?? '';
    $doj = $_POST['doj'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $mob_no = $_POST['mob_no'] ?? '';
    $aadhar_no = $_POST['aadhar_no'] ?? '';

    if ($student_id === '' || $full_name === '' || $email === '') {
        echo json_encode(["success" => false, "message" => "Missing required fields"]);
        exit;
    }

    $sql = "UPDATE students 
            SET full_name = :full_name,
                father_name = :father_name,
                dob = :dob,
                doj = :doj,
                email = :email,
                mob_no = :mob_no,
                aadhar_no = :aadhar_no
            WHERE id = :student_id";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':full_name' => $full_name,
        ':father_name' => $father_name,
        ':dob' => $dob,
        ':doj' => $doj,
        ':email' => $email,
        ':mob_no' => $mob_no,
        ':aadhar_no' => $aadhar_no,
        ':student_id' => $student_id
    ]);

    echo json_encode(["success" => true, "message" => "Student updated successfully"]);

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
