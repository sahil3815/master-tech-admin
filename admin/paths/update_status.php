<?php
include_once('connect2.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if (isset($_POST["status"]) && isset($_POST['stu_id_stats_popup'])) 
    {
        // Fix: Correct variable name from 'stu_id_prof_popup' to 'stu_id_stats_popup'
        $stu_id = $_POST['stu_id_stats_popup'];
        $status = $_POST['status'];
        
        $sql_update = "UPDATE students SET status = '$status' WHERE id = '$stu_id'";
        if ($conn->query($sql_update) === TRUE) {
            echo json_encode(["success" => true, "message" => "Profile updated successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error updating profile: " . $conn->error]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Required form fields are missing."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Form submission method is not POST."]);
}
$conn->close();
?>
