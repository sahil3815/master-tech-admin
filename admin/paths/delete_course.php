<?php
include_once('connect.php'); 

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    
    $stmt = $conn->prepare("DELETE FROM course WHERE id = ?");
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error";
}
?>
