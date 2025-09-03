<?php
session_start();
if(isset($_SESSION["name"]))
{
    header("Location: admin/dashboard");
}
else{
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="admin/assets/css/style.css">
    <link rel="stylesheet" href="admin/assets/css/mdb.min.css">    
    <link rel="shortcut icon" href="admin/assets/images/logo.jpeg" type="image/x-icon">
    <style>
        body {
            background-image:url(admin/assets/images/main.jpg);
            background-size:cover;
            background-repeat:no-repeat;
            background-attachment: fixed;
        }
        .card-container {
            max-width: 600px;
            margin: 50px auto;
            text-align: center;
            animation: fadeIn 1s ease-out;
        }
        h1 {
            color: #007bff;
            font-size: 2em;
            animation: slideIn 1s ease-out;
        }
        /* Add some animation to the button */
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        
        .card-otp {
        	width: 400px;
        	border: none;
        	height: 300px;
        	box-shadow: 0px 5px 20px 0px #d2dae3;
        	z-index: 1;
        	display: flex;
        	justify-content: center;
        	align-items: center
        }
        
        .card-otp h6 {
        	color: red;
        	font-size: 20px
        }
        
        .inputs input {
        	width: 40px;
        	height: 40px
        }
        
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
        	-webkit-appearance: none;
        	-moz-appearance: none;
        	appearance: none;
        	margin: 0
        }
        
        .card-2 {
        	background-color: #fff;
        	padding: 10px;
        	width: 350px;
        	height: 100px;
        	bottom: -50px;
        	left: 20px;
        	position: absolute;
        	border-radius: 5px
        }
        
        .card-2 .content {
        	margin-top: 50px
        }
        
        .card-2 .content a {
        	color: red
        }
        
        .form-control:focus {
        	box-shadow: none;
        	border: 2px solid red
        }
        
        .validate {
        	border-radius: 20px;
        	height: 40px;
        	background-color: red;
        	border: 1px solid red;
        	width: 140px
        }
    </style>
</head>
<body>
    <div class="card-container">
        <div class="card text-center">
            <div class="card-body">
                <h1 class="card-title">Welcome to Student Management Panel</h1>
                <button class="btn btn-primary py-2 ripple" id="add_course" data-bs-toggle="modal" data-bs-target="#login_modal">
                    <span>Login</span>
                </button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="login_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Login</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm" action="admin/paths/login.php" method="post">
                        <div class="mb-3">
                            <label for="user_name" class="form-label">Username</label>
                            <input type="text" class="form-control" id="user_name" name="user_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg" id="addUserBtn">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="OTPmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="OTPModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mobileWarningModalLabel">OTP Verification</h5>
                </div>
                <div class="modal-body">
                    <div class="container height-100 d-flex justify-content-center align-items-center"> 
                        <div class="position-relative"> 
                            <div class="card card-otp p-2 text-center"> 
                                <h6>Please enter the one-time password <br> to verify your account</h6> 
                                <div> 
                                    <span>An OTP has been sent to: </span>
                                    <small id="userEmailMasked">*******@example.com</small> 
                                </div> 
                                <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2"> 
                                    <input class="m-2 text-center form-control rounded" type="text" id="first" maxlength="1" /> 
                                    <input class="m-2 text-center form-control rounded" type="text" id="second" maxlength="1" /> 
                                    <input class="m-2 text-center form-control rounded" type="text" id="third" maxlength="1" /> 
                                    <input class="m-2 text-center form-control rounded" type="text" id="fourth" maxlength="1" /> 
                                    <input class="m-2 text-center form-control rounded" type="text" id="fifth" maxlength="1" /> 
                                    <input class="m-2 text-center form-control rounded" type="text" id="sixth" maxlength="1" /> 
                                </div> 
                                <div class="mt-4"> 
                                    <button class="btn btn-danger px-4 validate">Validate</button> 
                                </div> 
                            </div> 
                            <div class="card-2"> 
                                <div class="content d-flex justify-content-center align-items-center"> 
                                    <span>Didn't get the code?</span> 
                                    <a href="#" class="text-decoration-none ms-3" id="resendOtp">Resend</a> 
                                </div> 
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>


    <div class="modal fade" id="mobileWarningModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="mobileWarningModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mobileWarningModalLabel">Warning</h5>
                </div>
                <div class="modal-body">
                    <p>Looks like you're using a screen which is not recommended for this page. This may cause the page to not work properly.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js (if needed) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            function OTPInput() {
                const inputs = document.querySelectorAll('#otp > *[id]');
                for (let i = 0; i < inputs.length; i++) { 
                    inputs[i].addEventListener('keydown', function(event) { 
                        if (event.key==="Backspace" ) { 
                            inputs[i].value=''; 
                            if (i !==0) inputs[i - 1].focus(); 
                        } else { 
                            if (i===inputs.length - 1 && inputs[i].value !=='') { 
                                return true; 
                            } else if (event.keyCode> 47 && event.keyCode < 58) { 
                                inputs[i].value=event.key; 
                                if (i !==inputs.length - 1) inputs[i + 1].focus(); 
                                event.preventDefault(); 
                            } else if (event.keyCode> 64 && event.keyCode < 91) { 
                                inputs[i].value=String.fromCharCode(event.keyCode); 
                                if (i !==inputs.length - 1) inputs[i + 1].focus(); 
                                event.preventDefault(); 
                            } 
                        } 
                    }); 
                } 
            }
            OTPInput();
        });

        $(document).ready(function() {
            // Check if the user is accessing from a mobile device
            var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            if (isMobile) {
                // Show the mobile warning modal
                $('#mobileWarningModal').modal('show');
            }

            $("#otp").click(function() {
                $('#OTPmodal').modal('show');  // Trigger the OTP modal to open
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // When the login form is submitted
            $("#addUserBtn").click(function(event) {
                event.preventDefault(); // Prevent form from submitting and page reload
        
                // Disable the login button and show the "Please wait" text
                $("#addUserBtn").prop("disabled", true).text("Please wait...");
        
                $.ajax({
                    type: "POST",
                    url: "admin/paths/login.php", // Ensure this is the correct path
                    data: $("#loginForm").serialize(),
                    success: function(response) {
                        console.log("Raw response: ", response); // Log the raw response for debugging
                        try {
                            // Since the response is already JSON, no need to parse it again
                            var res = response;  // This is already an object (not a string)
        
                            // If OTP is successfully sent, show the OTP modal and hide the login modal
                            if (res.status === 'otp_sent') {
                                $('#login_modal').modal('hide'); // Hide login modal
                                $('#OTPmodal').modal('show'); // Show OTP modal
        
                                // Set the email in OTP modal
                                $('#userEmailMasked').text(res.email); // Display the email in the OTP modal
                            } else {
                                alert(res.message); // Show error message
                            }
                        } catch (e) {
                            console.error("Invalid JSON response:", response); // Log the raw response if parsing fails
                            alert("There was an error processing your request.");
                        }
                        // Re-enable the login button and change text back after response
                        $("#addUserBtn").prop("disabled", false).text("Login");
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error); // Log any AJAX errors
                        // Re-enable the login button and change text back after error
                        $("#addUserBtn").prop("disabled", false).text("Login");
                    }
                });
            });
        
            // OTP verification logic
            $(".validate").click(function() {
                var otp = "";
                $(".inputs input").each(function() {
                    otp += $(this).val(); // Concatenate OTP inputs to form a single OTP string
                });
        
                // Disable the OTP validation button and change text to "Please wait..."
                $(".validate").prop("disabled", true).text("Please wait...");
        
                $.ajax({
                    type: "POST",
                    url: "admin/paths/verify_otp.php", // OTP verification endpoint
                    data: { otp: otp },
                    success: function(response) {
                        console.log("Raw response: ", response); // Log the raw response for debugging
                        try {
                            var res = response; // This is already an object (not a string)
        
                            if (res.status === 'success') {
                                window.location.href = "admin/dashboard"; // Redirect to the dashboard page
                            } else {
                                alert(res.message); // Show OTP error message
                            }
                        } catch (e) {
                            console.error("Invalid JSON response:", response); // Log error if parsing fails
                            alert("There was an error verifying the OTP.");
                        }
                        // Re-enable the OTP validation button and change text back after response
                        $(".validate").prop("disabled", false).text("Validate");
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error); // Log any AJAX errors
                        // Re-enable the OTP validation button and change text back after error
                        $(".validate").prop("disabled", false).text("Validate");
                    }
                });
            });
        
            // Resend OTP functionality
            $("#resendOtp").click(function() {
                // Get the email from the OTP modal
                var email = $('#userEmailMasked').text().trim(); // Extract the email from the masked element
        
                // Disable the resend link and show "Resending..."
                $(this).prop("disabled", true).text("Resending...");
        
                // Send the email to the server
                $.ajax({
                    type: "POST",
                    url: "admin/paths/resend_otp.php", // Resend OTP endpoint
                    data: { email: email }, // Pass the email address to resend OTP
                    success: function(response) {
                        console.log("Resend response: ", response); // Log the raw response
                        try {
                            var res = response;  // This is already an object (not a string)
        
                            if (res.status === 'otp_sent') {
                                alert("A new OTP has been sent to your email.");
                            } else {
                                alert(res.message); // Show error message if OTP resend fails
                            }
                        } catch (e) {
                            console.error("Invalid JSON response:", response); // Log error if parsing fails
                            alert("There was an error resending the OTP.");
                        }
                        // Re-enable the resend button
                        $("#resendOtp").prop("disabled", false).text("Resend");
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error); // Log any AJAX errors
                        // Re-enable the resend button and change text back after error
                        $("#resendOtp").prop("disabled", false).text("Resend");
                    }
                });
            });
        });

    </script>
</body>
</html>

<?php
}
?>
