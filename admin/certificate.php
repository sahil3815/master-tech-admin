<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_SESSION["name"]))
{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue a Certificate - Master Tech Education</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- <link rel="stylesheet" href="assets/css/upload.css"> -->
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

    <script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/86186/moment.js'></script>
    <script src='https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js'></script>
    <script src="assets/js/scripts.js"></script>
</head>
<body style="overflow-x:hidden;background-image: url('');background-repeat:no-repeat;background-size:cover;"class="gradient-custom-3">
<header >
<?php 
include 'paths/header.php';
?>
<style type="text/css">
    body {
    background: linear-gradient(135deg, #2980b9, #6abeff);
    padding-top: 50px;
    font-family: Arial, sans-serif;
}

.container {
    max-width: 500px;
    background-color: rgba(255, 255, 255, 0.8);
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.2);
}

.form-group label {
    color: #2c3e50;
    font-weight: bold;
}

.btn-upload {
    background-color: #27ae60;
    border-color: #27ae60;
}

.btn-upload:hover {
    background-color: #219653;
    border-color: #219653;
}

.btn-upload:active {
    background-color: #1e8449;
    border-color: #1e8449;
}

.btn-upload:focus {
    box-shadow: 0 0 0 0.2rem rgba(39, 174, 96, 0.5);
}

input[type="file"] {
    border: none;
    background-color: #ecf0f1;
    padding: 10px;
    border-radius: 5px;
}

input[type="file"]:focus {
    outline: none;
    box-shadow: 0 0 0 0.2rem rgba(189, 195, 199, 0.5);
}

</style>
</header>
<main style="margin-top: 58px;overflow-x:hidden;" >

<div class="container">
        <h2 class="text-center mb-4">Upload Certificate</h2>
        <form id="uploadForm" enctype="multipart/form-data">
            <div class="form-group">
                <label for="stu_id">Student ID</label>
                <input type="text" class="form-control" id="stu_id" name="stu_id" required list="id_list">
            </div>
            <div class="form-group">
                <label for="stu_name">Student Name</label>
                <input type="text" class="form-control" id="stu_name" name="stu_name" required readonly>
            </div>
            <div class="form-group">
                <label for="course_name">Course</label>
                <input type="text" class="form-control" id="course_name" name="course_name" required readonly>
            </div>
            <div class="form-group">
                <label for="joining_date">Joining Date</label>
                <input type="date" class="form-control" id="joining_date" name="joining_date" required readonly>
            </div>
            <div class="form-group">
                <label for="completion_date">Completion Date</label>
                <input type="date" class="form-control" id="completion_date" name="completion_date" required>
            </div>
            <div class="form-group">
                <label for="cert_id">Certificate ID</label>
                <input type="text" class="form-control" id="cert_id" name="certificate_id" required>
            </div>
            <div class="form-group">
                <label for="file">File (pdf only):</label>
                <input type="file" class="form-control-file" id="cert_file" name="cert_file" accept=".pdf" required>
            </div>
            <div class="text-center">
                <button type="button" class="btn btn-primary btn-lg btn-upload">Upload</button>
            </div>
        </form>
        <div id="uploadMessage" class="mt-4 text-center" style="display: none;"></div>
    </div>

    <datalist id="id_list">
        <?php
            include_once('connect.php');
            $stmt = $conn->prepare("SELECT id FROM students");
            $stmt->execute();
            $courses= $stmt->fetchAll();
            foreach($courses as $course)
            {
        ?>
            <option value="<?php echo $course["id"];?>">
        <?php
            }
        ?>
    </datalist>


</main>
<script>
    $(document).ready(function() {
        $('#add_cert').addClass('active');

        // Disable fields initially
        $('#stu_name, #course_name, #joining_date, #completion_date, #cert_id').prop('readonly', true);

        var typingTimer; // Timer identifier
        var doneTypingInterval = 1000; // Time in ms (1 second)

        // On keyup, start the countdown
        $('#stu_id').keyup(function() {
            clearTimeout(typingTimer);
            if ($('#stu_id').val()) {
                typingTimer = setTimeout(fetchStudentDetails, doneTypingInterval);
            }
        });

        // Function to fetch student details
        function fetchStudentDetails() {
            var studentId = $('#stu_id').val();
            $.ajax({
                type: 'POST',
                url: 'paths/fetch_student_details.php',
                data: { student_id: studentId },
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        // If student not found, show error message
                        alert(response.error);
                        // Clear fields
                        $('#stu_name, #course_name, #joining_date').val('');
                    } else {
                        // If student found, fill the form fields
                        $('#stu_name').val(response.full_name);
                        $('#course_name').val(response.course);
                        $('#joining_date').val(response.doj);
                        // Enable fields
                        $('#completion_date, #cert_id').prop('readonly', false);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(xhr.responseText);
                }
            });
        }

        // Upload button click event
        $('.btn-upload').click(function(event){
            // Prevent default form submission
            event.preventDefault();

            // Validate form fields
            var stu_id = $('#stu_id').val();
            var completion_date = $('#completion_date').val();
            var certificate_id = $('#cert_id').val();
            
            // Create FormData object
            var formData = new FormData($('#uploadForm')[0]);

            // Send form data to PHP script using AJAX
            $.ajax({
                type: 'POST',
                url: 'paths/cert_upload.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response){
                    // Show upload message if successful
                    $('.container').html('<div class="text-center"><h3>File Uploaded Successfully!</h3><p>' + response + '</p></div>').fadeIn(300);
                },
                error: function(xhr, status, error){
                    // Show error message in alert box
                    alert("Error: " + xhr.responseText);
                }
            });
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
