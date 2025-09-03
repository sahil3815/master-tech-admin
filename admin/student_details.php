<?php
session_start();
if(isset($_SESSION["name"]))
{
    include_once('paths/connect.php');
    $student_id = $_GET['stu_id'];
    $stmt = $conn->prepare("SELECT s.id, s.full_name, s.dob, s.doj, s.mob_no, s.aadhar_no, s.course, s.status,profile_filename,profile_file_path,
    f.cert_id, f.compl_dt, f.filename, f.file_path, f.upload_date
    FROM files f
    LEFT JOIN students s ON f.stu_id = s.id where s.id = :student_id");
    $stmt->bindParam(':student_id', $student_id);
    $stmt->execute();
    $st_dtl = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch single row
    if(!$st_dtl){
        header("location: fetch_certificate.php");
        exit; // Stop further execution
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
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
    

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css'>
    <script src="assets/js/scripts.js"></script>

    <script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/86186/moment.js'></script>
</head>
<body style="background-color: #eee;">
<header >
<?php 
include 'paths/header.php';
?>
</header>
<main style="margin-top:58px;">
<section >
  <div class="container">
    <div class="main-body">
    
          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
              <li class="breadcrumb-item"><a href="fetch_certificate">Certificate</a></li>
              <li class="breadcrumb-item active" aria-current="page">Details</li>
            </ol>
          </nav>
          <!-- /Breadcrumb -->
    
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <img src="../profile-photo/<?php echo $st_dtl['profile_filename']; ?>" alt="Admin" class="rounded-circle" width="150" height="150">
                    <div class="mt-3">
                      <h4><?php echo $st_dtl['full_name']; ?></h4>

                      <p class="text-secondary mb-1"><?php echo $st_dtl['course']; ?></p>

                      <p class="text-muted font-size-sm"><?php echo $st_dtl['id']; ?></p>

                      <a class="btn btn-primary" href="../certificate/<?php echo $st_dtl['filename']; ?>" target="_blank">View</a>

                      <a class="btn btn-success" href="../certificate/<?php echo $st_dtl['filename']; ?>" download="../certificate/<?php echo $st_dtl['filename']; ?>">Download</a>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="card mt-3">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">Certificate ID</h6>
                    <span class="text-secondary"><?php echo $st_dtl['cert_id']; ?> </span>
                  </li>

                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">Completion Date</h6>
                    <span class="text-secondary"><?php echo $st_dtl['compl_dt']; ?></span> 
                  </li>

                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">Status</h6>
                    <span class="text-secondary"><?php echo $st_dtl['status']; ?></span>
                  </li>

                </ul>
              </div>
            </div>
           
 
            
            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body">
                    
                    <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">ID</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $st_dtl['id']; ?>
                    </div>
                  </div>
                  <hr>
                  
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Course</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $st_dtl['course']; ?>
                    </div>
                  </div>
                  <hr>
                    
                    
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Full Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <span id="full-name-txt"><?php echo $st_dtl['full_name']; ?></span>   
                    <input type="text" id="full-name" class="form-control d-none" name="stu-dtl-name" value="<?php echo $st_dtl['full_name'];?>"/>
                    </div>
                  </div>
                  <hr>
                  
                  
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Phone</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <span id="mobile-number-txt">+91-<?php echo $st_dtl['mob_no']; ?></span>
                        <input type="number" id="mobile-number" class="form-control d-none" name="stu-dtl-mobile" value="<?php echo $st_dtl['mob_no']; ?>" maxlength="10"/>
                        
                    </div>
                  </div>
                  <hr>
                  
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Aadhar</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <span id="aadhar-number-txt"><?php echo $st_dtl['aadhar_no']; ?></span>
                      <input type="number" maxlength="12" id="aadhar-number" class="form-control d-none" name="stu-dtl-aadhar" value="<?php echo $st_dtl['aadhar_no']; ?>"/>
                    </div>
                  </div>
                  <hr>
                  
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">DOB</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <span id="date-of-birth-txt"><?php echo $st_dtl['dob']; ?></span>
                      <input type="date" id="date-of-birth" class="form-control d-none" name="stu-dtl-dob" value="<?php echo $st_dtl['dob']; ?>" maxlenght="12"/>
                    </div>
                  </div>
                  <hr>
                  
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Join Date</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <span id="date-of-join-txt"><?php echo $st_dtl['doj']; ?></span>
                        <input type="date" id="date-of-join" class="form-control d-none" name="stu-dtl-doj" value="<?php echo $st_dtl['doj']; ?>"/>
                    </div>
                  </div>
                  <hr>
                  
                  <div class="row">
                    <div class="col-sm-12">
                      <button class="update-button btn btn-info" data-id="<?php echo $student['id']; ?>" id="edit-btn">Edit</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row gutters-sm">
              </div>
                  
            </div>
          </div>
        </div>
    </div>
</section>
<input type="hidden" name="stu_id" id="stu_id">
</main>
<script>
    $(document).ready(function() {
        $('#main').addClass('active');
         
        // Event listener for clicking anywhere outside the input fields
        $(document).click(function(event) { 
            if(!$(event.target).closest('.form-control').length && !$(event.target).closest('#edit-btn').length) {
                // Hide input fields and show span elements
                $("#date-of-join, #date-of-birth, #aadhar-number, #mobile-number, #full-name").addClass("d-none");
                $("#date-of-join-txt, #date-of-birth-txt, #aadhar-number-txt, #mobile-number-txt, #full-name-txt").removeClass("d-none");
            }
        });
        
    $("#edit-btn").click(function(){
        $("#date-of-join, #date-of-birth, #aadhar-number, #mobile-number, #full-name").removeClass("d-none");
        $("#date-of-join-txt, #date-of-birth-txt, #aadhar-number-txt, #mobile-number-txt, #full-name-txt").addClass("d-none");
    });
    
    });
</script>

<script>
    // Add an event listener to the input fields
    document.addEventListener('DOMContentLoaded', function() {
        var mobileNumberInput = document.getElementById('mobile-number');
        var aadharNumberInput = document.getElementById('aadhar-number');

        // Add event listeners to restrict the input length
        mobileNumberInput.addEventListener('input', function() {
            if (this.value.length > 10) {
                this.value = this.value.slice(0, 10); // Restrict to 10 characters
            }
        });

        aadharNumberInput.addEventListener('input', function() {
            if (this.value.length > 12) {
                this.value = this.value.slice(0, 12); // Restrict to 12 characters
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