<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_SESSION["name"])) {
?>
<!DOCTYPE html>
<html lang="en">
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <meta http-equiv="X-UA-Compatible" content="IE=edge">-->
<!--    <meta name="viewport" content="width=device-width, initial-scale=1.0">-->
<!--    <title>Add Student - Master Tech Education</title>-->
<!--    <link rel="stylesheet" href="assets/css/style.css">-->
<!--    <link rel="stylesheet" href="assets/css/mdb.min.css">-->
<!--    <script src="assets/js/mdb.min.js"></script>-->
<!--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>-->
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->
<!--    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" type="text/css" />-->
<!--    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>-->
<!--    <script type="text/javascript" src="https://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>-->
<!--    <link rel="shortcut icon" href="assets/images/logo.jpeg" type="image/x-icon">-->
<!--    <script src="assets/js/scripts.js"></script>-->
<!--</head>-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student - Master Tech Education</title>
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
<body class="gradient-custom-3">
<header>
<?php 
include 'paths/header.php';
?>
</header>
<main style="margin-top: 58px; overflow-x: hidden;">
  <div class="row p-3">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-12">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-10">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-12 col-xl-12 order-2 order-lg-1">
                                <form class="mx-1 mx-md-4"  method="post" id="newAddStudentForm">
                                    <div class="row">
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form flex-fill mb-0">
                                                <input class="form-control" name="new_course_name" list="new_course_list" id="new_course_name"/>
                                                <label class="form-label" for="new_course_name">Course</label>
                                                <datalist id="new_course_list">
                                                    <?php
                                                        include_once('connect.php');
                                                        $stmt = $conn->prepare("SELECT * FROM course");
                                                        $stmt->execute();
                                                        $courses = $stmt->fetchAll();
                                                        foreach($courses as $course)
                                                        {
                                                    ?>
                                                        <option value="<?php echo $course["name"];?>">
                                                    <?php
                                                        }
                                                    ?>
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <div class="form flex-fill mb-0">
                                                    <input type="text" class="form-control" name="new_course_id" id="new_course_id"  readonly/>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                var typingTimer;
                                                var doneTypingInterval = 1000;
                                                $('#new_course_name').on('keyup', function() {
                                                    clearTimeout(typingTimer);
                                                    typingTimer = setTimeout(doneTyping, doneTypingInterval);
                                                });
                                                $('#new_course_name').on('keydown', function() {
                                                    clearTimeout(typingTimer);
                                                });
                                                function doneTyping() {
                                                    var selectedCourse = $('#new_course_name').val();
                                                    $.ajax({
                                                        url: 'paths/add_sn.php',
                                                        type: 'POST',
                                                        data: { new_course: selectedCourse },
                                                        success: function(response) {
                                                            $('#new_course_id').val('MT-' + response + '-25-');
                                                        },
                                                        error: function(xhr, status, error) {
                                                            console.error('Error:', error);
                                                        }
                                                    });
                                                }
                                            });
                                        </script>
                                        <script>
                                            $(document).ready(function() {
                                                var typingTimer;
                                                var doneTypingInterval = 1000;
                                                $('#new_course_name').on('keyup', function() {
                                                    clearTimeout(typingTimer);
                                                    typingTimer = setTimeout(doneTyping, doneTypingInterval);
                                                });
                                                $('#new_course_name').on('keydown', function() {
                                                    clearTimeout(typingTimer);
                                                });
                                                function doneTyping() {
                                                    var selectedCourse = $('#new_course_name').val();
                                                    $.ajax({
                                                        url: 'paths/add_price.php',
                                                        type: 'POST',
                                                        data: { new_course: selectedCourse },
                                                        success: function(response) {
                                                            $('#new_course_price').val(response);
                                                        },
                                                        error: function(xhr, status, error) {
                                                            console.error('Error:', error);
                                                        }
                                                    });
                                                }
                                            });
                                        </script>
                                        <div class="col-8">
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <div class="form flex-fill mb-0">
                                                    <input type="text" class="form-control" name="new_student_id" id="new_student_id" onkeypress="return isNumberKey(event)"/>
                                                    <label class="form-label" for="new_student_id">Student ID</label>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            function isNumberKey(evt) {
                                                var charCode = (evt.which) ? evt.which : event.keyCode;
                                                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                                                    return false;
                                                }
                                                return true;
                                            }
                                        </script>
                                        <div class="col-md-4">
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <div class="form flex-fill mb-0">
                                                    <button type="button" class="btn btn-primary btn-md" id="new_check_student_id">Check</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <div class="form flex-fill mb-0">
                                                    <input type="text" class="form-control" name="new_aadhar_number" id="new_aadhar_number" disabled maxlength="12" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12)"/>
                                                    <label class="form-label" for="new_aadhar_number">Aadhar Number</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form flex-fill mb-0">
                                                <input type="text" class="form-control" name="new_full_name" oninput="formatName(event)" pattern="[A-Za-z\s]+" disabled/>
                                                <label class="form-label" for="new_full_name">Full Name</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form flex-fill mb-0">
                                                <input type="text" class="form-control" name="new_father_full_name" oninput="formatName(event)" pattern="[A-Za-z\s]+" disabled/>
                                                <label class="form-label" for="new_father_full_name">Father's Full Name</label>
                                            </div>
                                        </div>
                                        <script>
                                            function formatName(event) {
                                                let input = event.target.value;
                                                input = input.replace(/\b\w/g, function (char) {
                                                    return char.toUpperCase();
                                                });
                                                event.target.value = input;
                                            }
                                        </script>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form flex-fill mb-0">
                                                <input type="date" class="form-control" name="new_dob" disabled/>
                                                <label class="form-label" for="new_dob">Date of Birth</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form flex-fill mb-0">
                                                <input type="date" class="form-control" name="new_doj" disabled/>
                                                <label class="form-label" for="new_doj">Date of Joining</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form flex-fill mb-0">
                                                <input type="text" class="form-control" name="new_mobile_number" id="new_mobile_number" disabled maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"/>
                                                <label class="form-label" for="new_mobile_number">Mobile Number</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form flex-fill mb-0">
                                                <input type="text" class="form-control" name="new_email" id="new_email" disabled />
                                                <label class="form-label" for="new_email">Email</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <div class="form flex-fill mb-0">
                                                    <input type="text" class="form-control" name="new_course_price" id="new_course_price"  readonly/>
                                                    <label class="form-label" for="new_course_price">Course Price</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <div class="form flex-fill mb-0">
                                                    <input type="text" class="form-control" name="new_offered_price" id="new_offered_price" />
                                                    <label class="form-label" for="new_offered_price">Offered Price</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <div class="form flex-fill mb-0">
                                                    <input type="text" class="form-control" name="new_registration_amount" id="new_registration_amount" />
                                                    <label class="form-label" for="new_registration_amount">Registration Amount</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form flex-fill mb-0">
                                                <select class="form-select" id="new_payment_method" name="new_payment_method" disabled>
                                                    <option value="" disabled selected>Select</option>
                                                    <option value="Online">Online</option>
                                                    <option value="Offline">Offline</option>
                                                </select>
                                                <label for="new_payment_method" class="form-label">Payment Method</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <div class="form flex-fill mb-0">
                                                    <input type="text" class="form-control" name="new_reference_number" id="new_reference_number" />
                                                    <label class="form-label" for="new_reference_number">Ref / Receipt No.</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <div class="form flex-fill mb-0">
                                                    <input type="text" class="form-control" name="new_pending_amount" id="new_pending_amount" readonly/>
                                                    <label class="form-label" for="new_pending_amount">Pending Amount</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form flex-fill mb-0">
                                                <select class="form-select" id="new_student_status" name="new_student_status" disabled>
                                                    <option value="" disabled selected>Select</option>
                                                    <option value="Registered">Registered</option>
                                                    <option value="Joined">Joined</option>
                                                    <option value="Dropped out">Dropped Out</option>
                                                </select>
                                                <label for="new_student_status" class="form-label">Student Status</label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" class="btn btn-primary btn-lg" id="new_add_student_button">Add Student</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</main>
<script>
    $(document).ready(function() {
        const disableFields = ($form) => {
            $form.find('input:not(#new_student_id, #new_course_name, #new_course_id)').prop('disabled', true);
            $form.find('#new_add_student_button').prop('disabled', true);
        };
        const $form = $('#newAddStudentForm');
        disableFields($form);
        $form.find('#new_check_student_id').on('click', function(event) {
            event.preventDefault();
            const new_id = $form.find('#new_student_id').val().trim();
            const new_course_id = $form.find('#new_course_id').val().trim();
            if (!new_id) {
                alert("Please enter an ID to check.");
                return;
            }
            $.ajax({
                url: 'paths/add_id.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    new_id: new_id,
                    new_course_id: new_course_id
                },
                success: function(data) {
                    if (data.exists) {
                        alert("ID is not available.");
                        disableFields($form);
                    } else {
                        alert("ID is available. You can proceed.");
                        enableFields($form);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    alert("Something went wrong.");
                }
            });
        });
        const enableFields = ($form) => {
            $form.find('input,select').prop('disabled', false);
            $form.find('#new_add_student_button').prop('disabled', false);
        };
        $('#new_registration_amount').on('input', function() {
            validateAndCalculatePendingAmount();
        });
        $('#new_offered_price').on('input', function() {
            validateAndCalculatePendingAmount();
            validateOfferedPrice();
        });
        $('#new_course_price').on('input', function() {
            validateOfferedPrice();
            validateAndCalculatePendingAmount();
        });
        function validateAndCalculatePendingAmount() {
            const offeredPrice = parseInt($('#new_offered_price').val().trim()) || 0;
            const regAmount = parseInt($('#new_registration_amount').val().trim()) || 0;
            if (regAmount > offeredPrice) {
                alert("Registration amount cannot be greater than the offered price.");
                $('#new_registration_amount').val(0);
                $('#new_pending_amount').val(0);
                return;
            }
            const pendingAmount = offeredPrice - regAmount;
            $('#new_pending_amount').val(Math.floor(pendingAmount));
        }
        function validateOfferedPrice() {
            const new_offeredPrice = parseInt($('#new_offered_price').val().trim()) || 0;
            const new_coursePrice = parseInt($('#new_course_price').val().trim()) || 0;
            if (new_offeredPrice > new_coursePrice) {
                alert("Offered price cannot be greater than the course price.");
                $('#new_offered_price').val(0);
                $('#new_pending_amount').val(0);
            }
        }
        $("#new_add_student_button").on('click', function(event) {
            event.preventDefault();
            const new_id = $form.find('#new_student_id').val().trim();
            const new_course_id = $form.find('#new_course_id').val().trim();
            const new_fullName = $form.find('input[name="new_full_name"]').val().trim();
            const new_dob = $form.find('input[name="new_dob"]').val().trim();
            const new_doj = $form.find('input[name="new_doj"]').val().trim();
            const new_mobNo = $form.find('#new_mobile_number').val().trim();
            const new_aadharNo = $form.find('#new_aadhar_number').val().trim();
            const new_course = $form.find('#new_course_name').val().trim();
            const new_status = $form.find('#new_student_status').val().trim();
            const new_method = $form.find('#new_payment_method').val().trim();
            const new_email = $form.find('#new_email').val().trim();
            const new_fatherName = $form.find('input[name="new_father_full_name"]').val().trim();
            const new_fees = $form.find('input[name="new_offered_price"]').val().trim();
            const new_reg_amt = $form.find('input[name="new_registration_amount"]').val().trim();
            const new_pnd_amt = $form.find('input[name="new_pending_amount"]').val().trim();
            const new_ref_no = $form.find('input[name="new_reference_number"]').val().trim();
            if (!new_id || !new_fullName || !new_dob || !new_mobNo || !new_aadharNo || !new_course || !new_status || !new_fatherName || !new_email || !new_fees) {
                alert("All fields are mandatory. Please fill in all the fields.");
                return;
            }
            $.ajax({
                url: "paths/add_student.php",
                type: "POST",
                data: {
                    new_id: new_id,
                    new_course_id: new_course_id,
                    new_full_name: new_fullName,
                    new_dob: new_dob,
                    new_doj: new_doj,
                    new_mob_no: new_mobNo,
                    new_aadhar_no: new_aadharNo,
                    new_course: new_course,
                    new_status: new_status,
                    new_email: new_email,
                    new_father_name: new_fatherName,
                    new_fees: new_fees,
                    new_reg_amt: new_reg_amt,
                    new_pnd_amt: new_pnd_amt,
                    new_method: new_method,
                    new_ref_no: new_ref_no
                },
                success: function(data) {
                    data = JSON.parse(data);
                    if (data.success) {
                        $.ajax({
                            url: "paths/add_status.php",
                            type: "POST",
                            data: {
                                new_id: new_id,
                                new_course_id: new_course_id,
                                new_status: new_status
                            },
                            success: function(data) {
                                data = JSON.parse(data);
                                if (data.success) {
                                    $.ajax({
                                        url: "mail/send_reg_email.php",
                                        type: "POST",
                                        data: {
                                            new_id: new_id,
                                            new_course_id: new_course_id,
                                            new_full_name: new_fullName,
                                            new_dob: new_dob,
                                            new_doj: new_doj,
                                            new_mob_no: new_mobNo,
                                            new_aadhar_no: new_aadharNo,
                                            new_course: new_course,
                                            new_status: new_status,
                                            new_email: new_email,
                                            new_father_name: new_fatherName,
                                            new_fees: new_fees,
                                            new_reg_amt: new_reg_amt,
                                            new_pnd_amt: new_pnd_amt,
                                            new_method: new_method,
                                            new_ref_no: new_ref_no
                                        },
                                        success: function(data) 
                                        {
                                            data = JSON.parse(data);
                                            if (data.success) 
                                            {
                                                alert("Record inserted successfully.");
                                                window.location.href = 'student?stu_id=' + new_course_id + new_id;
                                                // location.reload();
                                            } 
                                            else 
                                            {
                                                alert("Student registered But mail not sent.");
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            console.error("Error:", error);
                                            alert("Student registered But mail not sent.");
                                        }
                                    });
                                } else {
                                    alert("Student registered but status not updated.");
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("Error:", error);
                                alert("Student registered but status not updated.");
                            }
                        });
                    } else {
                        alert("Something went wrong while registering.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    alert("Something went wrong while registering.");
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#add_user').addClass('active');
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
