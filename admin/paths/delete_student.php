<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    if(isset($_POST['id'])) {
        include_once('connect.php');
        $studentId = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
        $stmt->execute([$studentId]);
        if($stmt->rowCount() > 0) {
            echo 'success';
            exit(); 
        } else {
            echo 'error';
            exit(); 
        }
    } else {
        echo 'error';
        exit(); 
    }
} else {
    echo 'error';
    exit(); 
}
?>