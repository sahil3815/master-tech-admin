<div class="modal fade" id="modal_student" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-m">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Student</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <div class="container h-100">
                        <div class="row d-flex justify-content-center align-items-center h-100">
                            <div class="col-lg-12 col-xl-12">
                                <div class="card text-black" style="border-radius: 25px;">
                                    <div class="card-body p-md-10">
                                        <div class="row justify-content-center">
                                            <div class="col-md-10 col-lg-12 col-xl-12 order-2 order-lg-1">
                                                <form class="mx-1 mx-md-4"  method="post" id="addStudentForm">
                                                    <div class="row">
                                                        <div class="d-flex flex-row align-items-center mb-4">
                                                        <div class="form flex-fill mb-0">
                                                            <input class="form-control" name="course" list="course_list" id="course"/>
                                                            <label class="form-label" for="course">Course</label>
                                                            <datalist id="course_list">
                                                                <?php
                                                                    include_once('connect.php');
                                                                    $stmt = $conn->prepare("SELECT * FROM course");
                                                                    $stmt->execute();
                                                                    $courses= $stmt->fetchAll();
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
                                                        <div class="col-12" >
                                                            <div class="d-flex flex-row align-items-center mb-4">
                                                                <div class="form flex-fill mb-0">
                                                                    <input type="text" class="form-control" name="id2" id="id2"  readonly/>
                                                                    <!--<label class="form-label" for="usr_id">ID</label>-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <script>
                                                            $(document).ready(function() {
                                                                var typingTimer;
                                                                var doneTypingInterval = 1000; 
                                                                $('#course').on('keyup', function() {
                                                                    clearTimeout(typingTimer);
                                                                    typingTimer = setTimeout(doneTyping, doneTypingInterval);
                                                                });
                                                                $('#course').on('keydown', function() {
                                                                    clearTimeout(typingTimer);
                                                                });
                                                                function doneTyping() {
                                                                    var selectedCourse = $('#course').val();
                                                                    $.ajax({
                                                                        url: 'paths/get_sn.php',
                                                                        type: 'POST',
                                                                        data: { course: selectedCourse },
                                                                        success: function(response) {
                                                                            $('#id2').val('MT-'+response+'-25-');
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
                                                                $('#course').on('keyup', function() {
                                                                    clearTimeout(typingTimer);
                                                                    typingTimer = setTimeout(doneTyping, doneTypingInterval);
                                                                });
                                                                $('#course').on('keydown', function() {
                                                                    clearTimeout(typingTimer);
                                                                });
                                                                function doneTyping() {
                                                                    var selectedCourse = $('#course').val();
                                                                    $.ajax({
                                                                        url: 'paths/get_price.php',
                                                                        type: 'POST',
                                                                        data: { course: selectedCourse },
                                                                        success: function(response) {
                                                                            $('#crs_price').val(response);
                                                                        },
                                                                        error: function(xhr, status, error) {
                                                                            console.error('Error:', error);
                                                                        }
                                                                    });
                                                                }
                                                            });
                                                        </script>
                                                        <div class="col-8" >
                                                            <div class="d-flex flex-row align-items-center mb-4">
                                                                <div class="form flex-fill mb-0">
                                                                    <input type="text" class="form-control" name="id" id="usr_id" onkeypress="return isNumberKey(event)"/>
                                                                    <label class="form-label" for="usr_id">ID</label>
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
                                                                    <button type="button" class="btn btn-primary btn-md" id="checkIdBtn">Check</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                        <div class="d-flex flex-row align-items-center mb-4">
                                                            <div class="form flex-fill mb-0">
                                                                <input type="text" class="form-control" name="aadhar_no" id="aadhar_no" disabled maxlength="12" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12)"/>
                                                                <label class="form-label" for="aadhar_no">Aadhar Number</label>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    <div class="d-flex flex-row align-items-center mb-4">
                                                        <div class="form flex-fill mb-0">
                                                            <input type="text" class="form-control" name="full_name" oninput="formatName(event)" pattern="[A-Za-z\s]+" disabled/>
                                                            <label class="form-label" for="full_name">Full Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-row align-items-center mb-4">
                                                        <div class="form flex-fill mb-0">
                                                            <input type="text" class="form-control" name="father_name" oninput="formatName(event)" pattern="[A-Za-z\s]+" disabled/>
                                                            <label class="form-label" for="father_name">Father's Name</label>
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
                                                            <input type="date" class="form-control" name="dob" disabled/>
                                                            <label class="form-label" for="dob">Date of Birth</label>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-row align-items-center mb-4">
                                                        <div class="form flex-fill mb-0">
                                                            <input type="date" class="form-control" name="doj" disabled/>
                                                            <label class="form-label" for="doj">Date of Joining</label>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-row align-items-center mb-4">
                                                        <div class="form flex-fill mb-0">
                                                            <input type="text" class="form-control" name="mob_no" id="mob_no" disabled maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"/>
                                                            <label class="form-label" for="mob_no">Mobile Number</label>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-row align-items-center mb-4">
                                                        <div class="form flex-fill mb-0">
                                                            <input type="tmail" class="form-control" name="email" id="email" disabled />
                                                            <label class="form-label" for="email">Email</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12" >
                                                            <div class="d-flex flex-row align-items-center mb-4">
                                                                <div class="form flex-fill mb-0">
                                                                    <input type="text" class="form-control" name="crs_price" id="crs_price"  readonly/>
                                                                    <label class="form-label" for="crs_price">Course Price</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12" >
                                                            <div class="d-flex flex-row align-items-center mb-4">
                                                                <div class="form flex-fill mb-0">
                                                                    <input type="text" class="form-control" name="fees" id="fees" />
                                                                    <label class="form-label" for="fees">Offerred Price</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12" >
                                                            <div class="d-flex flex-row align-items-center mb-4">
                                                                <div class="form flex-fill mb-0">
                                                                    <input type="text" class="form-control" name="reg_amt" id="reg_amt" />
                                                                    <label class="form-label" for="reg_amt">Reg. Amount</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-row align-items-center mb-4">
                                                        <div class="form flex-fill mb-0">
                                                            <select class="form-select" id="method" name="method" disabled>
                                                              <option value="" disabled selected>Select</option>
                                                              <option value="Online">Online</option>
                                                              <option value="Offline">Offline</option>
                                                              <label for="status" class="form-label">Payment Method</label>
                                                            </select>
                                                            <label for="status" class="form-label">Payment Method</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12" >
                                                            <div class="d-flex flex-row align-items-center mb-4">
                                                                <div class="form flex-fill mb-0">
                                                                    <input type="text" class="form-control" name="ref_no" id="ref_no"/>
                                                                    <label class="form-label" for="pnd_amt">Ref./Receipt No.</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12" >
                                                            <div class="d-flex flex-row align-items-center mb-4">
                                                                <div class="form flex-fill mb-0">
                                                                    <input type="text" class="form-control" name="pnd_amt" id="pnd_amt" readonly/>
                                                                    <label class="form-label" for="pnd_amt">Pending Amt.</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                     <div class="d-flex flex-row align-items-center mb-4">
                                                        <div class="form flex-fill mb-0">
                                                            <select class="form-select" id="status" name="status" disabled>
                                                              <option value="" disabled selected>Select</option>
                                                              <option value="Registered">Registered</option>
                                                              <option value="Joined">Joined</option>
                                                              <option value="Dropped out">Dropped Out</option>
                                                              <!-- <option value="Completed">Completed</option> -->
                                                              <label for="status" class="form-label">Select Status</label>
                                                            </select>
                                                            <label for="status" class="form-label">Select Status</label>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                                        <button type="submit" class="btn btn-primary btn-lg" id="addStuBtn">Add Student</button>
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
        </div>
    </div>
</div>
<!-- Add this script at the end of your HTML file -->
<script>
    $(document).ready(function() {
        const disableFields = ($form) => {
            $form.find('input:not(#usr_id, #course, #id2)').prop('disabled', true);
            $form.find('#addUserBtn').prop('disabled', true);
        };
        const $form = $('#addStudentForm');
        disableFields($form); 
        $form.find('#checkIdBtn').on('click', function(event) {
            event.preventDefault(); 
            const id = $form.find('#usr_id').val().trim();
            const id2 = $form.find('#id2').val().trim();
            if (!id) {
                alert("Please enter an ID to check.");
                return; 
            }
            $.ajax({
                url: 'paths/check_id.php',
                type: 'POST', 
                dataType: 'json',
                data: {
                    id: id, 
                    id2: id2 
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
            $form.find('#addUserBtn').prop('disabled', false);
        };
        $('#reg_amt').on('input', function() {
            validateAndCalculatePendingAmount();
        });
        $('#fees').on('input', function() {
            validateAndCalculatePendingAmount();
            validateOfferedPrice(); 
        });
        $('#crs_price').on('input', function() {
            validateOfferedPrice(); 
            validateAndCalculatePendingAmount();
        });
        function validateAndCalculatePendingAmount() {
            const offeredPrice = parseInt($('#fees').val().trim()) || 0;
            const regAmount = parseInt($('#reg_amt').val().trim()) || 0;
            if (regAmount > offeredPrice) {
                alert("Registration amount cannot be greater than the offered price.");
                $('#reg_amt').val(0);
                $('#pnd_amt').val(0);
                return; 
            }
            const pendingAmount = offeredPrice - regAmount;
            $('#pnd_amt').val(Math.floor(pendingAmount)); 
        }
        function validateOfferedPrice() {
            const offeredPrice = parseInt($('#fees').val().trim()) || 0;
            const coursePrice = parseInt($('#crs_price').val().trim()) || 0;
            if (offeredPrice > coursePrice) {
                alert("Offered price cannot be greater than the course price.");
                $('#fees').val(0);
                $('#pnd_amt').val(0);
            }
        }   
        $("#addStuBtn").on('click', function(event) {
        event.preventDefault(); 
            const id = $form.find('#usr_id').val().trim();
            const id2 = $form.find('#id2').val().trim();
            const fullName = $form.find('input[name="full_name"]').val().trim();
            const dob = $form.find('input[name="dob"]').val().trim();
            const doj = $form.find('input[name="doj"]').val().trim();
            const mobNo = $form.find('#mob_no').val().trim();
            const aadharNo = $form.find('#aadhar_no').val().trim();
            const course = $form.find('#course').val().trim();
            const status = $form.find('#status').val().trim();
            const method = $form.find('#method').val().trim();
            const email = $form.find('#email').val().trim();
            const fatherName = $form.find('input[name="father_name"]').val().trim();
            const fees = $form.find('input[name="fees"]').val().trim();
            const reg_amt = $form.find('input[name="reg_amt"]').val().trim();
            const pnd_amt = $form.find('input[name="pnd_amt"]').val().trim();
            const ref_no = $form.find('input[name="ref_no"]').val().trim();
            if (!id || !fullName || !dob || !mobNo || !aadharNo || !course || !status || !fatherName || !email || !fees) {
                alert("All fields are mandatory. Please fill in all the fields.");
                return; 
            }
            $.ajax({
                url: "paths/insert_student.php",
                type: "POST",
                data: {
                    id: id,
                    id2: id2, 
                    full_name: fullName,
                    dob: dob,
                    doj: doj,
                    mob_no: mobNo,
                    aadhar_no: aadharNo,
                    course: course,
                    status: status,
                    email: email,
                    father_name: fatherName,
                    fees: fees,
                    reg_amt: reg_amt,
                    pnd_amt: pnd_amt,
                    method: method,
                    ref_no: ref_no
                },
                success: function(data) {
                    data = JSON.parse(data);
                    if (data.success) {
                        $.ajax({
                            url: "paths/insert_status.php",
                            type: "POST",
                            data: {
                                id: id,
                                id2: id2, 
                                status: status
                            },
                            success: function(data) {
                                data = JSON.parse(data);
                                if (data.success) {
                                    alert("Record inserted successfully.");
                                    location.reload();
                                } else {
                                    alert("Something went wrong.");
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("Error:", error);
                                alert("Something went wrong.");
                            }
                        });
                    } else {
                        alert("Something went wrong.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    alert("Something went wrong.");
                }
            });
        });
    });
</script>