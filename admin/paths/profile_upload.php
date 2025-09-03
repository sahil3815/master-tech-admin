<?php
include_once('connect2.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all necessary form fields are set
    if (isset($_FILES["profile_file"]) && isset($_POST['stu_id_prof_popup'])) {
        // File details
        $stu_id = $_POST['stu_id_prof_popup'];
        
        // Generate a random file name using uniqid()
        $file_name = uniqid("profile-photo-for-" . $stu_id . "-", true) . ".jpg"; // Generate unique file name
        $file_tmp = $_FILES["profile_file"]["tmp_name"];
        $file_ext = strtolower(pathinfo($_FILES["profile_file"]["name"], PATHINFO_EXTENSION)); // Get file extension
        $allowed_extensions = array("jpg"); // Allowed file extensions

        // Validate file extension
        if (in_array($file_ext, $allowed_extensions)) {
            $file_path = "../../profile-photo/" . $file_name;

            // Check if there's an existing profile photo and delete it (except if it's the default profile photo)
            $sql_get_old_photo = "SELECT profile_file_path FROM students WHERE id = '$stu_id'";
            $result = $conn->query($sql_get_old_photo);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $old_file_path = $row['profile_file_path'];

                // Only delete the old file if it is NOT the default profile photo
                $default_file_name = "default-profile-for-any-student-without-profile-picture-" . $stu_id . ".png";
                if (file_exists($old_file_path) && basename($old_file_path) != $default_file_name) {
                    unlink($old_file_path); // Delete the old file if it's not the default one
                }
            }

            // Move the uploaded file to the destination directory
            if (move_uploaded_file($file_tmp, $file_path)) {
                // Update the profile_filename and profile_file_path in students table
                $sql_update = "UPDATE students SET profile_filename = '$file_name', profile_file_path = '$file_path' WHERE id = '$stu_id'";

                if ($conn->query($sql_update) === TRUE) {
                    echo "Profile updated successfully";
                } else {
                    echo "Error updating profile: " . $conn->error;
                }
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Error: Only .jpg files are allowed.";
        }
    } else {
        echo "Error: Required form fields are missing.";
    }
} else {
    echo "Error: Form submission method is not POST.";
}

$conn->close();
?>