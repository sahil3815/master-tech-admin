<?php
session_start();
if (isset($_SESSION["name"])) {
    // Get the start and end dates from the GET request
    $startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '';
    $endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '';
    
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Students List - Master Tech Education</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/mdb.min.css">
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
    <script src='https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js'></script>
</head>
<body style="background-image: url('');background-repeat:no-repeat;background-size:cover;" class="gradient-custom-3">
    <header>
    <?php include 'paths/header.php'; ?>
    </header>
    <main>
        <div class="container pt-4">
            <div class="container">
                <div class="row mb-3">
                    <div class="col text-end">
                        <button class="btn btn-primary" id="addBtnForStu" data-bs-toggle="modal" data-bs-target="#modal_student">
                           <i class="fas fa-user-graduate"></i> Add Student
                        </button>
                    </div>
                </div>
                <div class="row header" style="text-align:center;color:green">
                    <h3>Students Details</h3>
                </div>
                <table id="Table" class="table table-bordered table-hover">
                    <thead>  
                        <tr>  
                            <th>Serial No.</th>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Course</th>
                            <th>DOJ</th>
                            <th>Fees</th>
                            <th>Pending</th>
                            <th>View</th>
                        </tr>  
                    </thead>  
                    <tbody>  
                    <?php
                    include_once('paths/connect.php');

                    // Initialize the date condition
                    $dateCondition = '';

                    // Check if start and end dates are provided
                    if ($startDate && $endDate) {
                        // Ensure correct format of dates
                        $startDate = date('Y-m-d', strtotime($startDate));
                        $endDate = date('Y-m-d', strtotime($endDate));

                        // Add the WHERE condition for the date range
                        $dateCondition = " WHERE doj BETWEEN :startDate AND :endDate";
                    }

                    // Prepare the SQL query with the date condition
                    $query = "SELECT * FROM students" . $dateCondition;
                    $stmt = $conn->prepare($query);

                    // Bind the parameters for the date range
                    if ($startDate && $endDate) {
                        $stmt->bindParam(':startDate', $startDate);
                        $stmt->bindParam(':endDate', $endDate);
                    }

                    // Execute the statement
                    $stmt->execute();

                    // Fetch all students matching the query
                    $students = $stmt->fetchAll();

                    // Loop through and display each student
                    foreach ($students as $student) {
                    ?>
                        <tr>
                            <td></td>
                            <td><?php echo $student['id']; ?></td>
                            <td><?php echo $student['full_name']; ?></td>
                            <td><?php echo $student['course']; ?></td>
                            <td><?php echo $student['doj']; ?></td>
                            <td><?php echo $student['fees']; ?></td>
                            <td><?php echo $student['pnd_amt']; ?></td>
                            <td>
                                <button type="button" class="view-button btn btn-success" data-id="<?php echo $student['id']; ?>"><i class="fas fa-eye"></i></button>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>  
                </table>  
            </div>
        </div>
    </main>
    <script>
    $(document).ready(function(){
        var table = $('#Table').DataTable();
        $(document).on('click', '.view-button', function() {
            var studentId = $(this).data('id');
            window.open('student?stu_id=' + studentId, '_blank');
        });
    });
    </script>
    <script>
        $(document).ready(function() {
            $('#list_student').addClass('active');
        });
    </script>
    </body>
    </html>
<?php
} else {
    header("location:../");
}
?>