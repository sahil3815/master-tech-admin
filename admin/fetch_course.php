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
    <title>All Courses List - Master Tech Education</title>
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
                        <th>Category</th>
                        <th>Name</th>
                        <th>Short Name</th>
                        <th>Price</th>
                        <th><i class="fas fa-sync"></i></th>
                        <th><i class="fas fa-trash"></i></th>
                    </tr>  
                </thead>  
                <tbody>  
                    <?php
                    include_once('paths/connect.php'); 
                    $stmt = $conn->prepare("SELECT * FROM course");
                    $stmt->execute();
                    $courses = $stmt->fetchAll();
                    foreach($courses as $course)
                    {
                    ?>
                    <tr>
                        <td></td>
                        <td><?php echo $course['category']; ?></td>
                        <td><?php echo $course['name']; ?></td>
                        <td><?php echo $course['short_name']; ?></td>
                        <td>₹<?php echo $course['price']; ?></td>
                        <td><button class="btn btn-success" onclick="updatePrice(<?php echo $course['id']; ?>)"><i class="fas fa-sync"></i> </button></td>
                        <td><button class="btn btn-danger" onclick="deleteCourse(<?php echo $course['id']; ?>)"> <i class="fas fa-trash"></i></button></td>
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
function deleteCourse(courseId) {
    if (confirm("Are you sure you want to delete the course? This cannot be undone.")) {
        $.ajax({
            type: "POST",
            url: "paths/delete_course.php",
            data: { id: courseId },
            success: function(response) {
                if (response == "success") {
                    alert("Course deleted successfully.");
                    location.reload();
                } else {
                    alert("Something went wrong. Please try again.");
                }
            }
        });
    }
}


function updatePrice(courseId) {
    var newPrice = prompt("Enter the new price:");
    if (newPrice === null) {
        // User clicked cancel, do nothing
        return;
    }
    if (newPrice.trim() !== "" && parseFloat(newPrice) > 0 && !isNaN(newPrice) && newPrice.length <= 6) {
        // Proceed if newPrice is not empty, greater than 0, is a valid number, and has a length of 6 or less
        $.ajax({
            type: "POST",
            url: "paths/update_price.php",
            data: { id: courseId, price: newPrice },
            success: function(response) {
                if (response === "success") {
                    alert("Price updated successfully.");
                    location.reload();
                } else {
                    alert("Something went wrong. Please try again.");
                }
            }
        });
    } else {
        alert("Price must be a number greater than 0 and with at most 6 digits. Please try again.");
        // Run the function again recursively
        updatePrice(courseId);
    }
}



$(document).ready(function(){
    $('#Table').dataTable();
    $('#list_course').addClass('active');
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
