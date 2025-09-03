<?php
include_once('connect2.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['stu_id']) && isset($_POST['completion_date']) && isset($_POST['certificate_id']) && isset($_FILES["cert_file"])) {
        $stu_id = $_POST['stu_id'];
        $completion_date = $_POST['completion_date'];
        $certificate_id = $_POST['certificate_id'];
        $file_name = $certificate_id . ".pdf"; 
        $file_tmp = $_FILES["cert_file"]["tmp_name"];
        $file_ext = strtolower(pathinfo($_FILES["cert_file"]["name"], PATHINFO_EXTENSION)); 
        $allowed_extensions = array("pdf"); 
        if (in_array($file_ext, $allowed_extensions)) {
            $file_path = "../../certificate/" . $file_name;
            if (move_uploaded_file($file_tmp, $file_path)) {
                $sql = "INSERT INTO files (filename, file_path, stu_id, compl_dt, cert_id) VALUES ('$file_name', '$file_path', '$stu_id', '$completion_date', '$certificate_id')";
                if ($conn->query($sql) === TRUE) {
                    $update_status_sql = "UPDATE students SET status='Completed' WHERE id='$stu_id'";
                    if ($conn->query($update_status_sql) === TRUE) {
                        echo "File uploaded and status updated successfully!";
                    } else {
                        echo "Error updating status: " . $conn->error;
                    }
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Error: Only PDF files are allowed.";
        }
    } else {
        echo "Error: Required form fields are missing.";
    }
} else {
    echo "Error: Form submission method is not POST.";
}
$conn->close();
?>