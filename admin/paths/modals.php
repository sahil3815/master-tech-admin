<!-- Logout -->
<div class="modal fade modal-md" id="logout_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-m">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title fs-5" id="staticBackdropLabel">Logging Out</h1>
      <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
    </div>
    <div class="modal-body">
      <div class="modal-body">
        <p class="text-center h5 fw-bold mb-5 mx-1 mx-md-4 mt-4">
          You need to login back
        </p>
      </div>
      <div class="modal-footer justify-content-center">
        <a href="../" class="btn btn-primary">Login</a>
      </div>
    </div>
  </div>
</div>
</div>
<!-- End -->


<!-- Course -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable modal-m">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Course</h1>
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
                              <!-- <p class="text-center h3 fw-bold mb-5 mx-1 mx-md-4 mt-4">Enter the details below</p> -->
                              <form class="mx-1 mx-md-4"  method="post" id="crs_frm">

                              <div class="d-flex flex-row align-items-center mb-4">
                                  <div class="form-outline flex-fill mb-0">
                                    <select class="form-select" id="form4Example6c" name="category">
                                      <option value="" disabled selected>Select category</option>
                                      <option value="Computer Science" id="Computer Science">Computer Science</option>
                                      <option value="Languages" id="Languages">Languages</option>
                                      <option value="Business & Management" id="Business & Management">Business & Management</option>
                                      <option value="Personal Development" id="Personal Development">Personal Development</option>
                                      <option value="Art & Design" id="Art & Design">Art & Design</option>
                                      <option value="Health & Wellness" id="Health & Wellness">Health & Wellness</option>
                                    </select>
                                    <label class="form-label" for="form4Example6c">Course category</label>
                                  </div>
                                </div>



                                <div class="d-flex flex-row align-items-center mb-4">
                                  <div class="form flex-fill mb-0">
                                    <input type="text" id="form4Example1c" class="form-control" name="name" oninput="formatCourseName(event)" pattern="[A-Za-z\s]+" maxlength="50"/>
                                    <label class="form-label" for="form4Example1c">Course Name</label>
                                  </div>
                                </div>
                                
                                <script>
                                    function formatCourseName(event) {
                                        // Get the input value
                                        let input = event.target.value;
                                        
                                        // Convert the first letter of every word to capital
                                        input = input.replace(/\b\w/g, function (char) {
                                            return char.toUpperCase();
                                        });
                                
                                        // Update the input value with the formatted course name
                                        event.target.value = input;
                                    }
                                </script>
                                
                                
                                <div class="d-flex flex-row align-items-center mb-4">
                                  <div class="form flex-fill mb-0">
                                    <input type="text" id="form4Example8c" class="form-control" name="short_name"  maxlength="4" oninput="formatShortName(event)" pattern="[A-Z]+"/>
                                    <label class="form-label" for="form4Example8c">Short Name</label>
                                  </div>
                                </div>
                                
                                <script>
                                    function formatShortName(event) {
                                        // Get the input value
                                        let input = event.target.value;
                                        
                                        // Convert any lowercase letters to uppercase
                                        input = input.toUpperCase();
                                
                                        // Remove any spaces
                                        input = input.replace(/\s/g, '');
                                
                                        // Update the input value with the formatted short name
                                        event.target.value = input;
                                    }
                                </script>
                                
                                
                                
                                <div class="d-flex flex-row align-items-center mb-4">
                                  <div class="form flex-fill mb-0">
                                    <input type="number" id="form4Example4c"  class="form-control" name="price" oninput="limitLength(event, 6)"/>
                                    <label class="form-label" for="form4Example4c">Price</label>
                                  </div>
                                </div>
                                <script>
                                    function limitLength(event, maxLength) {
                                        let input = event.target;
                                        if (input.value.length > maxLength) {
                                            input.value = input.value.slice(0, maxLength); // Truncate the value to the maxLength
                                        }
                                    }
                                </script>


                                <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                  <button class="btn btn-primary btn-lg" id="sbmt_crs_but">Add Course</button>
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
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div> -->
      </div>
    </div>
    </div>


<script>
    $(document).ready(function () {
        // Function to check if all fields are filled
        function checkFields() {
            var category = $("#form4Example6c").val();
            var courseName = $("#form4Example1c").val();
            var shortName = $("#form4Example8c").val();
            var price = $("#form4Example4c").val();

            // Enable the button only if all fields are filled
            if (category && courseName && shortName && price) {
                $("#sbmt_crs_but").prop("disabled", false);
            } else {
                $("#sbmt_crs_but").prop("disabled", true);
            }
        }

        // Check fields on input change
        $("input, select").on("input", function () {
            checkFields();
        });

        // Check fields on page load
        checkFields();

        $("#crs_frm").submit(function (e) {
            e.preventDefault();

            // Disable the "Add Course" button during the AJAX request
            var addButton = $("#sbmt_crs_but");
            addButton.prop("disabled", true);

            // Serialize form data
            var formData = $(this).serialize();

            // Send data to PHP script using AJAX
            $.ajax({
                type: "POST",
                url: "paths/insert_course.php",
                data: formData,
                success: function (response) {
                    if (response.trim() === "success") {
                        // Success message, reset form, and enable the button
                        alert("Course added successfully");
                        window.location.reload(); // Reload the page
                    } else {
                        // Error message
                        alert("Error: " + response);
                    }
                },
                error: function () {
                    // Error message in case of AJAX failure
                    alert("Error occurred in adding data");
                },
                complete: function () {
                    // Enable the "Add Course" button after the request is complete
                    addButton.prop("disabled", false);
                },
            });
        });

        // Reset the form when the modal is closed
        $(".btn-close").click(function () {
            $("form")[0].reset();
            checkFields(); // Check fields after reset
        });
    });
</script>
<!-- end -->



<!-- certificate -->
<div class="modal fade" id="modal_certificate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable modal-m">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Certificate</h1>
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
                              
                              <form class="mx-1 mx-md-4" action="#" method="post">

                              <div class="d-flex flex-row align-items-center mb-4">
                                  <div class="form flex-fill mb-0">
                                    <input class="form-control" name="cert_stu_id" list="stu_id_list" id="cert_stu_id"/>
                                    <label class="form-label" for="cert_stu_id">Student ID</label>
                                    <datalist id="stu_id_list">
                                        <?php
                                            include_once('connect.php');
                                            $stmt = $conn->prepare("SELECT * FROM students");
                                            $stmt->execute();
                                            $students= $stmt->fetchAll();
                                            foreach($students as $student)
                                            {
                                        ?>
                                            <option value="<?php echo $student["id"];?>">
                                        <?php
                                            }
                                        ?>
                                    </datalist>
                                  </div>
                                </div>


                                <div class="d-flex flex-row align-items-center mb-4">
                                  <div class="form flex-fill mb-0">
                                    <input type="text" id="cert_stu_name" class="form-control" name="cert_stu_name" readonly/>
                                    <label class="form-label" for="cert_stu_name">Student Name</label>
                                  </div>
                                </div>
                                
                                <div class="d-flex flex-row align-items-center mb-4">
                                  <div class="form flex-fill mb-0">
                                    <input type="text" id="cert_course"  class="form-control" name="cert_course" readonly/>
                                    <label class="form-label" for="cert_course">Course</label>
                                  </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex flex-row align-items-center mb-4">
                                          <div class="form flex-fill mb-0">
                                            <input type="date" id="cert_strt_dt"  class="form-control" name="cert_strt_dt"/>
                                            <label class="form-label" for="cert_strt_dt">Start Date</label>
                                          </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-6">
                                        <div class="d-flex flex-row align-items-center mb-4">
                                          <div class="form flex-fill mb-0">
                                            <input type="date" id="cert_end_dt"  class="form-control" name="cert_end_dt" />
                                            <label class="form-label" for="cert_end_dt">End Date</label>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="d-flex flex-row align-items-center mb-4">
                                  <div class="form flex-fill mb-0">
                                    <input type="text" id="cert_id"  class="form-control" name="cert_id"/>
                                    <label class="form-label" for="cert_id">Certificate ID</label>
                                  </div>
                                </div>
                                
                                 <div class="d-flex flex-row align-items-center mb-4">
                                  <div class="form flex-fill mb-0">
                                    <input type="file" id="cert_file"  class="form-control" name="cert_file"/>
                                    <label class="form-label" for="cert_file">Certificate File</label>
                                  </div>
                                </div>
                                
                                
                                
                                <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                  <button type="submit" class="btn btn-primary btn-lg">Add Certificate</button>
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



<script>
  $(document).ready(function () {
    $("#cert_stu_id").on("input", function () {
      clearTimeout($(this).data("timeout"));
      $(this).data("timeout", setTimeout(function () {
        var studentId = $("#cert_stu_id").val();
        if (studentId !== '') {
          $.ajax({
            type: 'POST',
            url: 'paths/fetch_student_details.php', // Change to the appropriate URL for fetching student details
            data: { student_id: studentId },
            success: function (response) {
              var data = JSON.parse(response);
              $("#cert_stu_name").val(data.full_name);
              $("#cert_course").val(data.course);
            },
            error: function () {
              alert("Error fetching student details.");
            }
          });
        }
      }, 1000)); // 1000 milliseconds = 1 second
    });

    $("#add_certificate").click(function () {
      alert("After entering the ID, please wait for 1 second to fetch the details automatically.");
    });
  });
  
  
$(document).ready(function(){
    // Set max attribute of date input fields to the current date
    var currentDate = new Date().toISOString().split('T')[0];
    $("#cert_strt_dt").attr('max', currentDate);
    $("#cert_end_dt").attr('max', currentDate);

    // Set min attribute of start date to January 1, 2022
    var minDate = "2022-01-01";
    $("#cert_strt_dt").attr('min', minDate);

    // Update min attribute of end date based on start date
    $("#cert_strt_dt").on('change', function() {
        var strt_dt = $("#cert_strt_dt").val();
        $('#cert_end_dt').attr('min', strt_dt);
    });
});


</script>


<!-- Update Student -->
 <div class="modal fade" id="modal_update_stu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-m">
        <div class="modal-content">
            
        </div>
    </div>
</div> 


<script>
$(document).on('click', '#btn_upd_stu', function(e) {
    e.preventDefault(); // Prevent default form submission

    // Collect data from the form fields
    var formData = {
        id: $("input[name='id']").val(),
        full_name: $("input[name='full_name']").val(),
        dob: $("input[name='dob']").val(),
        mob_no: $("input[name='mob_no']").val(),
        aadhar_no: $("input[name='aadhar_no']").val(),
    };

    // Log formData to console
    console.log('Form Data:', formData);

    // AJAX post request to update_student.php
    $.ajax({
        type: 'POST',
        url: 'paths/update_student.php',
        data: formData,
        dataType: 'json', // Expect JSON response
        success: function(response) {
            if (response.success) {
                // Show success message
                alert('Updated successfully!');
                location.reload();
            } else {
                // Show error message
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            alert('Something went wrong. Please try again.');
        }
    });
});
</script>
