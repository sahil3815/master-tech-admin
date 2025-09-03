<?php
session_start();
if (isset($_SESSION["name"])) {
    include_once('paths/connect.php');
    $student_id = $_GET['stu_id'];

    // Fetch student details
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = :student_id");
    $stmt->bindParam(':student_id', $student_id);
    $stmt->execute();
    $studnt = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$studnt) {
        header("location: fetch_student.php");
        exit;
    }

    // Fetch payment history for the student
    $stmt = $conn->prepare("SELECT * FROM fees WHERE stu_id = :stu_id ORDER BY payment_date DESC");
    $stmt->bindParam(':stu_id', $student_id);
    $stmt->execute();
    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item"><a href="fetch_student.php">Students</a></li>
              <li class="breadcrumb-item active" aria-current="page">Students Details</li>
            </ol>
          </nav>
          <!-- /Breadcrumb -->

          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <img src="../profile-photo/<?php echo $studnt['profile_filename']; ?>" alt="Admin" class="rounded-circle" width="150" height="150">
                    <div class="mt-3">
                      <h4><?php echo $studnt['full_name']; ?></h4>
                      <p class="text-secondary mb-1"><?php echo $studnt['course']; ?></p>
                      <p class="text-muted font-size-sm"><?php echo $studnt['id']; ?></p>

                      <p id="status-text" class="text-muted font-size-sm"><?php echo $studnt['status']; ?></p>

                        <button id="profileBtn" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Profile">
                            <i class="fas fa-user"></i>
                        </button>

                        <button id="statusBtn" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Status">
                            <i class="fas fa-clipboard-list"></i>
                        </button>

                        <button id="feesBtn" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Fees">
                            <i class="fas fa-dollar-sign"></i>
                        </button>

                        <button class="btn btn-danger delete-button" data-id="<?php echo $studnt['id']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                            <i class="fas fa-trash-alt"></i>
                        </button>

                    </div>
                  </div>
                </div>
              </div>

              <div class="card mt-3">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">Course</h6>
                    <span class="text-secondary"><?php echo $studnt['course']; ?> </span>
                  </li>

                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">Fees</h6>
                    <span class="text-secondary"><?php echo $studnt['fees']; ?></span> 
                  </li>

                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">registration Amt.</h6>
                    <span class="text-secondary"><?php echo $studnt['reg_amt']; ?></span>
                  </li>

                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0">Status</h6>
                    <span class="text-secondary"><?php echo $studnt['status']; ?></span>
                  </li>

                </ul>
              </div>
            </div>

            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body">

                    <!-- <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">ID</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $studnt['id']; ?>
                    </div>
                  </div>
                  <hr> -->

                  <!-- <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Course</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $studnt['course']; ?>
                    </div>
                  </div>
                  <hr> -->

                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Full Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <span id="name-txt"><?php echo $studnt['full_name']; ?></span>
                        <input type="text" id="full-name" class="form-control d-none" name="stu-dtl-name" value="<?php echo $studnt['full_name']; ?>"/>
                    </div>
                  </div>
                  <hr>

                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Father's Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <span id="father-name-txt"><?php echo $studnt['father_name']; ?></span>
                        <input type="text" id="father-name" class="form-control d-none" name="stu-dtl-fatjher-name" value="<?php echo $studnt['father_name']; ?>"/>
                    </div>
                  </div>
                  <hr>

                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email ID</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <span id="email-txt"><?php echo $studnt['email']; ?></span>
                        <input type="email" id="stdnt_email" class="form-control d-none" name="stu-dtl-email" value="<?php echo $studnt['email']; ?>"/>
                    </div>
                  </div>
                  <hr>

                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Phone</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <span id="mobile-number-txt">+91-<?php echo $studnt['mob_no']; ?></span>
                        <input type="number" id="mobile-number" class="form-control d-none" name="stu-dtl-mobile" value="<?php echo $studnt['mob_no']; ?>" maxlength="10"/>

                    </div>
                  </div>
                  <hr>

                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Aadhar</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <span id="aadhar-number-txt"><?php echo $studnt['aadhar_no']; ?></span>
                      <input type="number" maxlength="12" id="aadhar-number" class="form-control d-none" name="stu-dtl-aadhar" value="<?php echo $studnt['aadhar_no']; ?>"/>
                    </div>
                  </div>
                  <hr>

                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">DOB</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <span id="date-of-birth-txt"><?php echo $studnt['dob']; ?></span>
                      <input type="date" id="date-of-birth" class="form-control d-none" name="stu-dtl-dob" value="<?php echo $studnt['dob']; ?>"/>
                    </div>
                  </div>
                  <hr>

                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Join Date</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <span id="date-of-join-txt"><?php echo $studnt['doj']; ?></span>
                        <input type="date" id="date-of-join" class="form-control d-none" name="stu-dtl-doj" value="<?php echo $studnt['doj']; ?>"/>
                    </div>
                  </div>
                  <hr>

                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Fees</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <span id="fees-txt"><?php echo $studnt['fees']; ?></span>
                        <!-- <input type="number" id="stdnt_fees" class="form-control d-none" name="stu-dtl-fees" value="<?php echo $studnt['fees']; ?>"/> -->
                    </div>
                  </div>
                  <hr>

                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Pending</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <span id="pnd-fees-txt"><?php echo $studnt['pnd_amt']; ?></span>
                        <input type="number" id="stdnt_pnd_fees" class="form-control d-none" name="stu-dtl-pnd-fees" value="<?php echo $studnt['pnd_amt']; ?>"/>
                    </div>
                  </div>
                  <hr>

                  <div class="row">
                    <div class="col-sm-12">
                      <button class="update-button btn btn-info" data-id="<?php echo $student['id']; ?>" id="edit-btn">Edit</button>
                      <button class="insert-button btn btn-info d-none" data-id="<?php echo $student['id']; ?>" id="updt-btn">Save</button>
                    </div>
                  </div>

                </div>
              </div>
              <div class="row gutters-sm">
              </div>

            </div>

            <div class="row gutters-sm">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Payment History</h5>
                            <table id="paymentHistoryTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Payment ID</th>
                                        <th>Payment Date</th>
                                        <th>Amount</th>
                                        <th>Remaining Fees</th>
                                        <th>Receipt No</th>
                                        <th>Payment Method</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($payments) {
                                        // Dynamically populate table rows based on the number of records
                                        foreach ($payments as $payment) {
                                            echo "<tr>";
                                            echo "<td></td>";
                                            echo "<td>" . htmlspecialchars($payment['payment_id']) . "</td>";
                                            echo "<td>" . htmlspecialchars($payment['payment_date']) . "</td>";
                                            echo "<td>" . htmlspecialchars($payment['amount']) . "</td>";
                                            echo "<td>" . htmlspecialchars($payment['remaining']) . "</td>";
                                            echo "<td>" . htmlspecialchars($payment['ref_no']) . "</td>";
                                            echo "<td>" . htmlspecialchars($payment['method']) . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6'>No payment history found.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    // Initialize DataTable for payment history
                    $('#paymentHistoryTable').DataTable();
                });
            </script>
          </div>
        </div>
    </div>
</section>
<input type="hidden" name="stu_id" id="stu_id">
<!-- Modal for updating status -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="statusModalLabel">Update Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="statusForm" method="post">
          <div class="mb-3">
            <label for="status" class="form-label">Select Status</label>
            <select class="form-select" id="status" name="status">
                <option value="" disabled selected>Select</option>
              <option value="Registered">Registered</option>
              <option value="Joined">Joined</option>
              <option value="Dropped out">Dropped Out</option>
            </select>
            <input type="hidden" id="stu_id_stats_popup" name="stu_id_stats_popup" value="<?php echo htmlspecialchars($studnt['id']); ?>">
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal for fees -->
<div class="modal fade" id="feesModal" tabindex="-1" aria-labelledby="feesModalLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="feesModalLabel">Update Fees</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="feesForm" method="post">
            <!-- Student ID (Hidden) -->
            <input type="hidden" id="stu_id_fees_popup" name="stu_id_fees_popup" values="<?php echo $studnt['pnd_amt']; ?>">
            <input type="hidden" id="pending-payment" name="pending-payment" value="<?php echo $studnt['pnd_amt']; ?>">
            <!-- Amount Field -->
            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" required>
            </div>

            <!-- Payment Date -->
            <div class="mb-3">
                <label for="payment_date" class="form-label">Payment Date</label>
                <input type="date" class="form-control" id="payment_date" name="payment_date" required>
            </div>

            <!-- Receipt No -->
            <div class="mb-3">
                <label for="receipt_no" class="form-label">Receipt/Ref. No</label>
                <input type="text" class="form-control" id="receipt_no" name="receipt_no" required>
            </div>

            <!-- Payment Method -->
            <div class="mb-3">
                <label for="method" class="form-label">Payment Method</label>
                <select class="form-select" id="method" name="method" required>
                    <option value="Online">Online</option>
                    <option value="Offline">Offline</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

      </div>
    </div>
  </div>
</div>
<!-- Modal For Profile -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModal" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="profileModalLabel">Update Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="profileUploadForm" method="post" enctype="multipart/form-data">
          <div class="mb-3">
              <label for="photo" class="form-label">Choose Profile Photo</label>

              <input type="hidden" id="stu_id_prof_popup" name="stu_id_prof_popup" value="<?php echo htmlspecialchars($studnt['id']); ?>">

              <input type="file" id="photo-profile-popup" class="form-control" name="profile_file" accept=".jpg">
          </div>
          <button type="submit" class="btn btn-primary" id="profile-popup-submtBtn">Upload</button>
      </form>

    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
      $('#profileUploadForm').submit(function(event){

          event.preventDefault();

          var formData = new FormData(this);
          var stu_id_popup_profile = $('#stu_id_prof_popup').val();
          var file_profile = $('#photo-profile-popup').prop('files')[0];

          if (stu_id_popup_profile === '' || !file_profile) {
              console.error("Error: Please choose a file.");
              return;
          }

          formData.append('stu_id_prof_popup', stu_id_popup_profile);

          $.ajax({
              type: 'POST',
              url: 'paths/profile_upload.php',
              data: formData,
              processData: false,
              contentType: false,
              success: function(response){
                  console.log("Response from server: " + response);
                  location.reload(); 
              },
              error: function(xhr, status, error){
                  console.error("Error occurred: " + error);
                  console.error("Response Text: " + xhr.responseText);
              }
          });
      });
  });
    $(document).ready(function() {
        $('#main').addClass('active');

        $(document).click(function(event) {
            if (
                !$(event.target).closest('.form-control').length &&
                !$(event.target).closest('#edit-btn').length &&
                !$(event.target).closest('#updt-btn').length
             ) {
                $("#updt-btn,#full-name,#father-name,#stdnt_email,#date-of-join, #date-of-birth, #aadhar-number, #mobile-number").addClass("d-none");
                $("#name-txt,#father-name-txt,#email-txt,#date-of-join-txt, #date-of-birth-txt, #aadhar-number-txt, #mobile-number-txt").removeClass("d-none");
            }
        });

    $("#edit-btn").click(function(){
        $("#updt-btn,#full-name,#father-name,#stdnt_email,#date-of-join, #date-of-birth, #aadhar-number, #mobile-number").removeClass("d-none");
        $("#name-txt,#father-name-txt,#email-txt,#date-of-join-txt, #date-of-birth-txt, #aadhar-number-txt, #mobile-number-txt").addClass("d-none");
    });

    });
    document.addEventListener('DOMContentLoaded', function() {
        var mobileNumberInput = document.getElementById('mobile-number');
        var aadharNumberInput = document.getElementById('aadhar-number');

        mobileNumberInput.addEventListener('input', function() {
            if (this.value.length > 10) {
                this.value = this.value.slice(0, 10); 
            }
        });

        aadharNumberInput.addEventListener('input', function() {
            if (this.value.length > 12) {
                this.value = this.value.slice(0, 12); 
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
    var statusParagraph = document.getElementById('status-text');
    var statusButton = document.getElementById('statusBtn');
    if (statusParagraph.textContent.trim() == 'Completed') {
          statusButton.classList.add('d-none');
        }
    });
    $(document).ready(function() {
        $('#statusForm').submit(function(event) {
            event.preventDefault(); 

            var formData = new FormData(this);
            var stu_id_stats_profile = $('#stu_id_stats_popup').val();
            var status = $('#status').val();

            console.log("Student ID:", stu_id_stats_profile);
            console.log("Status:", status);

            if (stu_id_stats_profile === '' || status === '') {
                console.error("Error: Please fill all fields.");
                return;
            }

            formData.append('stu_id_stats_popup', stu_id_stats_profile);  

            $.ajax({
                type: 'POST',
                url: 'paths/update_status.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log("Response from server: " + response);
                    var data = JSON.parse(response);  

                    if (data.success) {

                        $('#status-text').text(status); 

                        alert('Status updated successfully');

                        $('#statusModal').modal('hide');

                        setTimeout(function() {
                            location.reload();
                        }); 
                    } else {
                        console.error("Error: " + data.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error occurred: " + error);
                    console.error("Response Text: " + xhr.responseText);
                }
            });
        });
    });

    $(document).ready(function() {
        $('#statusBtn').click(function() {
            var studentId = '<?php echo $studnt["id"]; ?>'; 
            $('#stu_id_stats_popup').val(studentId); 
            $('#status').val('<?php echo $studnt['status']; ?>'); 
            $('#statusModal').modal('show'); 
        });

        $('#profileBtn').click(function() {
            $('#profileModal').modal('show');
        });

        $('#feesBtn').click(function() {

        $('#stu_id_fees_popup').val('<?php echo $studnt["id"]; ?>'); 
        $('#stu_name').val('<?php echo $studnt["full_name"]; ?>'); 
        $('#total_fees').val('<?php echo $studnt["fees"]; ?>'); 
        $('#pending_fees').val('<?php echo $studnt["pnd_amt"]; ?>'); 

        $('#feesModal').modal('show');
    });

    var tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });
    });
    $(document).ready(function() {
        $('#updt-btn').click(function(event) {
            event.preventDefault();

            const formData = {
                stu_id: '<?php echo $studnt["id"]; ?>',
                full_name: $('#full-name').val(),
                father_name: $('#father-name').val(),
                dob: $('#date-of-birth').val(),
                doj: $('#date-of-join').val(),
                email: $('#stdnt_email').val(),
                mob_no: $('#mobile-number').val(),
                aadhar_no: $('#aadhar-number').val()
            };

            console.log("Form Data:", formData); 

            $.ajax({
                url: 'paths/update_student_details.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log("Server Response:", response); 
                    const res = JSON.parse(response);
                    if (res.success) {
                        alert('Student updated successfully');
                        location.reload();
                    } else {
                        alert('Error: ' + res.message);
                    }
                },
                error: function(xhr) {
                    alert('Request failed: ' + xhr.status);
                }
            });
        });

    });
    $(document).ready(function(){

        $('.delete-button').click(function() {
            var deleteConfirmed = confirm("Are you sure you want to delete? This action cannot be undone.");

            if (deleteConfirmed) {
                var studentId = $(this).data('id');

                $.post('paths/delete_student.php', { id: studentId })
                .done(function(response) {
                    console.log('Delete Response:', response);
                    if (response.trim() === 'success') {

                        alert('Deleted successfully!');
                        window.location.href = 'fetch_student.php';
                    } else {

                        console.error('Error deleting student:', response);
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
    $(document).ready(function() {
        // Disable fees button if pending fees are zero
        if ($('#pending-payment').val() == 0) {
            $('#feesBtn').hide();
        }

        // Instant error checking when entering the payment amount
        $('#amount').on('input', function() {
            const pendingAmount = parseFloat($('#pending-payment').val());
            const enteredAmount = parseFloat($(this).val());

            // If the entered amount exceeds the pending amount, show error and reset input
            if (enteredAmount > pendingAmount) {
            alert("Payment amount cannot exceed the pending fees.");
            $(this).val(""); // Clear the entered value
            }
        });

        // Submit the fees form via AJAX
        $('#feesForm').submit(function(event) {
            event.preventDefault();

            var formData = {
            stu_id: $('#stu_id_fees_popup').val(),
            amount: $('#amount').val(),
            payment_date: $('#payment_date').val(),
            receipt_no: $('#receipt_no').val(),
            method: $('#method').val()
            };

            $.ajax({
            url: 'paths/update_payment.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                alert('Payment updated successfully!');
                $('#feesModal').modal('hide');
                location.reload(); // Reload the page to reflect changes
                } else {
                alert('Error: ' + data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error occurred: " + error);
                alert('Something went wrong. Please try again.');
            }
            });
        });
    });


</script>
</main>
</body>
</html>
<?php
}
else
{
header("location:../");
}
?>