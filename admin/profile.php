<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_SESSION["name"])) {
    // Include database connection
    include 'paths/connect.php';
    
    // Fetch logged-in user details
    $admin_id = $_SESSION["id"];
    $sql_admin = "SELECT * FROM admin WHERE id = :admin_id";
    $stmt_admin = $conn->prepare($sql_admin);
    $stmt_admin->bindParam(':admin_id', $admin_id);
    $stmt_admin->execute();
    $admin = $stmt_admin->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile - <?= htmlspecialchars($admin['name']); ?> | Master Tech Education </title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/mdb.min.css">
    <script src="assets/js/mdb.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    <link rel="shortcut icon" href="assets/images/logo.jpeg" type="image/x-icon">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css'>
    <link rel='stylesheet' href='https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css'>
    <script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/86186/moment.js'></script>
    <script src='https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js'></script>
    <script src="assets/js/scripts.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>
    <header>
        <?php include 'paths/header.php'; ?>
    </header>

    <main class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Manage Your Profile</h4>
                    </div>
                    <div class="card-body">
                        <!-- Display user details in a form -->
                        <form id="updateProfileForm">
                            <div class="form-group mb-3">
                                <label for="name">Name:</label>
                                <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($admin['name']); ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="username">Username:</label>
                                <input type="text" name="username" id="username" class="form-control" value="<?= htmlspecialchars($admin['username']); ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="prof_email">Email:</label>
                                <input type="email" name="prof_email" id="prof_email" class="form-control" value="<?= htmlspecialchars($admin['email']); ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="mobile">Mobile Number:</label>
                                <input type="text" name="mobile" id="mobile" class="form-control" value="<?= htmlspecialchars($admin['mob_no']); ?>" required>
                            </div>

                            <h5>Change Password</h5>
                            <div class="form-group mb-3">
                                <label for="current_password">Current Password:</label>
                                <input type="password" name="current_password" id="current_password" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="new_password">New Password:</label>
                                <input type="password" name="new_password" id="new_password" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="new_password_confirm">Confirm New Password:</label>
                                <input type="password" name="new_password_confirm" id="new_password_confirm" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal for Profile Update Success -->
    <div class="modal fade" id="profileUpdatedModal" tabindex="-1" aria-labelledby="profileUpdatedModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileUpdatedModalLabel">Profile Updated</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Your profile has been updated successfully. You will be logged out in 5 seconds.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="loginAgainBtn">Login Again</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('updateProfileForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Serialize the form data manually
            let formData = new FormData(this);
            let serializedData = '';
            formData.forEach((value, key) => {
                serializedData += encodeURIComponent(key) + '=' + encodeURIComponent(value) + '&';
            });
            serializedData = serializedData.slice(0, -1); // Remove the last '&'

            // Use Fetch API to send data to the backend
            fetch('paths/update_admin.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: serializedData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    $('#profileUpdatedModal').modal('show');
                    setTimeout(function () {
                        // Send request to logout.php and log the user out after profile update
                        fetch('paths/logout.php', { method: 'POST' })
                            .then(res => res.json())
                            .then(logoutData => {
                                // Redirect to login page after logout
                                window.location.href = '../';
                            })
                            .catch(error => console.error('Error during logout:', error));
                    }, 5000);
                } else {
                    alert(data.message); // Display any error message if status is not success
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("There was an error with the request. Please try again.");
            });
        });

        // Handle the "Login Again" button click
        document.getElementById('loginAgainBtn').addEventListener('click', function () {
            window.location.href = '../'; // Reload the page and redirect to the login page
        });
    </script>
</body>
</html>

<?php
} else {
    header("location:../index.php");
}
?>
