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
    <title>All Certificates List - Master Tech Education</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/mdb.min.css">
    <script src="assets/js/scripts.js"></script>
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
</head>
<body style="overflow-x:hidden;background-image: url('');background-repeat:no-repeat;background-size:cover;"class="gradient-custom-3">
<header>
    <?php include 'paths/header.php'; ?>
</header>
<main style="overflow-x:hidden;" >
    <div class="container pt-4">
        <div class="container">
            <div class="row header" style="text-align:center;color:green">
                <h3>Details</h3>
            </div>
            <table id="Table" class="table table-bordered table-hover" >  
                <thead>
                    <tr>
                        <th>Serial No.</th>
                        <th>Sudent ID</th>
                        <th>Name</th>
                        <th>Completion Date</th>
                        <th>Certificate ID</th>
                        <th><i class="fas fa-sync"></i></th>
                        <th><i class="fas fa-trash"></i></th>
                    </tr>  
                </thead>  
                <tbody>  
                    <?php
                    include_once('paths/connect.php'); 

                    // Initialize the date condition to an empty string
                    $dateCondition = '';

                    // Check if both start and end dates are provided
                    if ($startDate && $endDate) {
                        // Ensure the dates are in 'YYYY-MM-DD' format
                        $startDate = date('Y-m-d', strtotime($startDate));
                        $endDate = date('Y-m-d', strtotime($endDate));

                        // Add the WHERE condition to filter by the completion date (compl_dt)
                        $dateCondition = " WHERE s.doj BETWEEN :startDate AND :endDate";
                    }

                    // Prepare the SQL query with the date condition
                    $query = "SELECT s.id, s.full_name, s.dob, s.doj, s.mob_no, s.aadhar_no, s.course, s.status,
                              f.cert_id, f.compl_dt, f.filename, f.file_path, f.upload_date
                              FROM files f
                              LEFT JOIN students s ON f.stu_id = s.id" . $dateCondition;

                    // Prepare the statement
                    $stmt = $conn->prepare($query);

                    // Bind the parameters for the date range if dates are provided
                    if ($startDate && $endDate) {
                        $stmt->bindParam(':startDate', $startDate);
                        $stmt->bindParam(':endDate', $endDate);
                    }

                    // Execute the statement
                    $stmt->execute();

                    // Fetch all the files
                    $files = $stmt->fetchAll();

                    // Loop through and display each file record
                    foreach ($files as $file) {
                    ?>
                        <td></td>
                        <td><?php echo $file['id']; ?></td>
                        <td><?php echo $file['full_name']; ?></td>
                        <td><?php echo $file['compl_dt']; ?></td>
                        <td><?php echo $file['cert_id']; ?></td>

                        <td>
                            <button type="button" class="view-button btn btn-success" data-id="<?php echo $file['id']; ?>"><i class="fas fa-eye"></i></button>
                        </td>
                        
                        <td><button class="btn btn-danger delete-file-button" data-id="<?php echo $file['cert_id']; ?>"><i class="fas fa-trash"></i></button></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>  
            </table>  
        </div>
    </div>
</main>
<!--Main layout-->
<script>
$(document).ready(function(){
    $('#Table').dataTable();
    $('#view_cert').addClass('active');
    // Function to handle click event on the View button
    $('.view-button').click(function() {
        var studentId = $(this).data('id');
        // Redirect to the page with the student's details
        window.location.href = 'student_details?stu_id=' + studentId;
    });
    
    
    
     $('.delete-file-button').click(function() {
        var deleteConfirmed = confirm("Are you sure you want to delete? This action cannot be undone.");
    
        if (deleteConfirmed) {
            var fileId = $(this).data('id'); // Correctly grab the cert_id from the data-id
    
            $.post('paths/delete_file.php', { id: fileId })  // Send the correct cert_id
            .done(function(response) {
                console.log('Delete Response:', response);
                if (response.trim() === 'success') {
                    alert('Deleted successfully!');
                    window.location.href = 'fetch_certificate';  // Redirect or update table
                } else {
                    console.error('Error deleting certificate:', response);
                    alert('Something went wrong. Please try again.');
                }
            })
            .fail(function(xhr, status, error) {
                console.error('AJAX Error:', error);
                alert('Something went wrong. Please try again.');
            });
        }
    });

        
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
