<?php
session_start();
if(isset($_SESSION["name"]))
{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students - Add, Update, Delete and Manage Students</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/mdb.min.css">
    <script src="assets/js/script.js"></script>
    <script src="assets/js/mdb.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    <link rel="shortcut icon" href="assets/images/logo.jpeg" type="image/x-icon">

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css'>
    <link rel='stylesheet' href='https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css'>
    
    <script src="assets/js/scripts.js"></script>
    <script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/86186/moment.js'></script>
    <script src='https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js'></script>
    <script src="assets/js/scripts.js"></script>

    <!-- Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

</head>
<body style="overflow-x:hidden;" class="gradient-custom-3">
    <header>
        <?php include 'paths/header.php'; ?>
    </header>

    <main>
        <div class="container-fluid pt-5">
            <div class="row p-4">
                <!-- Add New Student Card -->
                <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                    <div class="card shadow-sm border-0 rounded-4 animate__animated animate__fadeIn animate__delay-1s">
                        <div class="card-header bg-primary text-white">
                            <i class="fas fa-user-plus"></i> Add New Student
                        </div>
                        <div class="card-body text-center">
                            <h4 class="display-7">+</h4>
                            <p>Add a new student to the system</p>
                            <a href="add_student" class="btn btn-primary btn-md">Add Student</a>
                        </div>
                        <div class="card-footer text-center">
                            Click to add a new student
                        </div>
                    </div>
                </div>

                <!-- View Students Card -->
                <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                    <div class="card shadow-sm border-0 rounded-4 animate__animated animate__fadeIn animate__delay-2s">
                        <div class="card-header bg-success text-white">
                            <i class="fas fa-eye"></i> View Students
                        </div>
                        <div class="card-body text-center">
                            <h4 class="display-7"></h4>
                            <p>View and manage all students</p>
                            <a href="fetch_student" class="btn btn-success btn-md">View Students</a>
                        </div>
                        <div class="card-footer text-center">
                            Click to see all students
                        </div>
                    </div>
                </div>

                <!-- Manage Students Card -->
                <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                    <div class="card shadow-sm border-0 rounded-4 animate__animated animate__fadeIn animate__delay-3s">
                        <div class="card-header bg-warning text-dark">
                            <i class="fas fa-cogs"></i> Manage Students
                        </div>
                        <div class="card-body text-center">
                            <h4 class="display-7">🔧</h4>
                            <p>Update or delete student information</p>
                            <a href="#" class="btn btn-warning btn-md">Manage Students</a>
                        </div>
                        <div class="card-footer text-center">
                            Click to manage students
                        </div>
                    </div>
                </div>

                <!-- Students by Status Card -->
                <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                    <div class="card shadow-sm border-0 rounded-4 animate__animated animate__fadeIn animate__delay-4s">
                        <div class="card-header bg-info text-white">
                            <i class="fas fa-users-cog"></i> Students by Status
                        </div>
                        <div class="card-body text-center">
                            <h4 class="display-7"></h4>
                            <p>View students based on status</p>
                            <a href="#" class="btn btn-info btn-md">View Status</a>
                        </div>
                        <div class="card-footer text-center">
                            Click to view students' status
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- View by Course Card -->
                <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                    <div class="card shadow-sm border-0 rounded-4 animate__animated animate__fadeIn animate__delay-5s">
                        <div class="card-header bg-danger text-white">
                            <i class="fas fa-book"></i> View by Course
                        </div>
                        <div class="card-body text-center">
                            <h4 class="display-7"></h4>
                            <p>View students by course</p>
                            <a href="#" class="btn btn-danger btn-md">View by Course</a>
                        </div>
                        <div class="card-footer text-center">
                            Click to see students by course
                        </div>
                    </div>
                </div>

                <!-- Certificates Issued Card -->
                <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                    <div class="card shadow-sm border-0 rounded-4 animate__animated animate__fadeIn animate__delay-6s">
                        <div class="card-header bg-primary text-white">
                            <i class="fas fa-certificate"></i> Certificates Issued
                        </div>
                        <div class="card-body text-center">
                            <h4 class="display-7"></h4>
                            <p>View all certificates issued</p>
                            <a href="fetch_certificate.php" class="btn btn-primary btn-md">View Certificates</a>
                        </div>
                        <div class="card-footer text-center">
                            Click to view issued certificates
                        </div>
                    </div>
                </div>

                <!-- Pending Fees Card -->
                <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                    <div class="card shadow-sm border-0 rounded-4 animate__animated animate__fadeIn animate__delay-7s">
                        <div class="card-header bg-danger text-white">
                            <i class="fas fa-money-check-alt"></i> Pending Fees
                        </div>
                        <div class="card-body text-center">
                            <h4 class="display-7">₹0</h4>
                            <p>Total pending fees from students</p>
                            <a href="fetch_pending_fees.php" class="btn btn-danger btn-md">View Pending Fees</a>
                        </div>
                        <div class="card-footer text-center">
                            Click to view pending fees
                        </div>
                    </div>
                </div>

                <!-- Total Collected Fees Card -->
                <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                    <div class="card shadow-sm border-0 rounded-4 animate__animated animate__fadeIn animate__delay-8s">
                        <div class="card-header bg-success text-white">
                            <i class="fas fa-dollar-sign"></i> Total Collected Fees
                        </div>
                        <div class="card-body text-center">
                            <h4 class="display-7">₹0</h4>
                            <p>Total fees collected</p>
                            <a href="fetch_collected_fees.php" class="btn btn-success btn-md">View Collected Fees</a>
                        </div>
                        <div class="card-footer text-center">
                            Click to view collected fees
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
    $(document).ready(function(){
        $('#list_student').addClass('active');
    });
    </script>
</body>
</html>
<?php
}
else
{
header("location:../");
}
?>
