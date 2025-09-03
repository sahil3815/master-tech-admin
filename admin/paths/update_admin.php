<?php
session_start();
include 'connect.php'; // Include database connection

$response = array();
$admin_id = $_SESSION["id"];  // Assuming `id` is stored in session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $updated_email = $_POST['prof_email'];
    $updated_username = $_POST['username'];
    $updated_name = $_POST['name'];
    $updated_mobile = $_POST['mobile'];
    $current_password = $_POST['current_password']; // The password the user entered
    $new_password = $_POST['new_password'];
    $new_password_confirm = $_POST['new_password_confirm'];

    // Fetch the current password from the database
    $sql = "SELECT password FROM admin WHERE id = :admin_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':admin_id', $admin_id);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify if the current password entered matches the stored password
    if ($current_password === $admin['password']) {
        if (!empty($new_password)) {
            // Check if the new passwords match
            if ($new_password === $new_password_confirm) {
                // Update the password directly as plain text
                $update_sql = "UPDATE admin SET email = :email, username = :username, name = :name, password = :password WHERE id = :admin_id";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bindParam(':email', $updated_email);
                $update_stmt->bindParam(':username', $updated_username);
                $update_stmt->bindParam(':name', $updated_name);
                $update_stmt->bindParam(':password', $new_password); // Store password as plain text
                $update_stmt->bindParam(':admin_id', $admin_id);
                $update_stmt->execute();
                $response['status'] = 'success';
                $response['message'] = 'Profile updated successfully!';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'New passwords do not match.';
            }
        } else {
            // Update without changing the password
            $update_sql = "UPDATE admin SET email = :email, username = :username, name = :name WHERE id = :admin_id";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bindParam(':email', $updated_email);
            $update_stmt->bindParam(':username', $updated_username);
            $update_stmt->bindParam(':name', $updated_name);
            $update_stmt->bindParam(':admin_id', $admin_id);
            $update_stmt->execute();
            $response['status'] = 'success';
            $response['message'] = 'Profile updated successfully!';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Current password is incorrect.';
    }
}

echo json_encode($response);
?>
