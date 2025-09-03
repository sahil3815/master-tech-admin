<!-- Sidebar -->
<nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white overflow-auto" style="width:250px;">
    <div class="position-sticky">
        <div class="list-group list-group-flush mx-3 mt-4">
            <a href="https://mastertecheducation.in" onclick="confirmExternalLink(event)" class="list-group-item list-group-item-action py-2 ripple">
                <i class="fas fa-external-link-alt fa-fw me-3"></i><span>Main Website</span>
            </a>

            <span class="list-group-item list-group-item-action py-2 ripple "><i class="fas fa-calendar-alt"></i>&nbsp;&nbsp;&nbsp;<span id="dateAndDay"></span></span>

            <span class="list-group-item list-group-item-action py-2 ripple "><i class="fas fa-clock"></i>&nbsp;&nbsp;&nbsp;<span id="clock"></span></span>
            <div class="text-center mt-3">
                <img src="assets/images/avatar.png" class="rounded-circle" 1 height="70" alt="Avatar" loading="lazy" />

                <h6 class="mt-2"> <?php echo$_SESSION["name"]?> </h6>
                <h6 class="mt-2"> <?php echo$_SESSION["email"]?> </h6>
                <!-- Add any additional user information here -->
            </div>

            <a href="dashboard" class="list-group-item list-group-item-action py-2 ripple" id="main">
                <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Main dashboard</span>
            </a>

            <!--<a href="add_student" class="list-group-item list-group-item-action py-2 ripple" id="add_user" data-bs-toggle="modal" data-bs-target="#modal_student">-->
            <a href="add_student" class="list-group-item list-group-item-action py-2 ripple" id="add_user" >
                <i class="fas fa-user-plus fa-fw me-3"></i><span>Add Student</span>
            </a>

            <a href="fetch_student" class="list-group-item list-group-item-action py-2 ripple" id="list_student">
                <i class="fas fa-users fa-fw me-3"></i><span>Students List</span>
            </a>

            <a href="#" class="list-group-item list-group-item-action py-2 ripple" id="add_course" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="fas fa-book-open fa-fw me-3"></i><span>Add Course</span>
            </a>

            <a href="fetch_course" class="list-group-item list-group-item-action py-2 ripple" id="list_course">
                <i class="fas fa-list fa-fw me-3"></i><span>Courses List</span>
            </a>

            <a href="certificate" class="list-group-item list-group-item-action py-2 ripple" id="add_cert">
                <i class="fas fa-file-alt fa-fw me-3"></i><span>Add Certificate</span>
            </a>

            <a href="fetch_certificate" class="list-group-item list-group-item-action py-2 ripple" id="view_cert">
                <i class="fas fa-eye fa-fw me-3"></i><span>View Certificate</span>
            </a>


        </div>
    </div>
</nav>
<!-- Sidebar -->

<!-- Navbar -->
<nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
    <!-- Container wrapper -->
    <div class="container-fluid">
        <!-- Toggle button -->
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Brand -->
        <a class="navbar-brand" href="dashboard">
            <img src="assets/images/logo.jpeg" height="25" alt="MDB Logo" loading="lazy" />
        </a>


        <!-- Centered Time Spent -->
        <div class="d-flex justify-content-center align-items-center">
            <span id="timeSpent" class="navbar-text">
                Time Spent: 0 seconds
            </span>
        </div>

        <!-- Right links -->
        <ul class="navbar-nav ms-auto d-flex flex-row">


            <!-- Avatar -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center" href="#" id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                    <img src="assets/images/avatar.png" class="rounded-circle" height="25" alt="Avatar" loading="lazy" />
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                    <li>
                        <a class="dropdown-item" href="profile">My profile</a>
                    </li>
                    <!--<li>-->
                    <!--    <a class="dropdown-item" href="#">Settings</a>-->
                    <!--</li>-->
                    <li>
                        <a class="dropdown-item" href="#" id="logoutButton">Logout</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- Container wrapper -->
</nav>
<!-- Navbar -->

<?php 
  include 'paths/modals.php';
?>

<?php 
  include 'paths/stu_modal.php';
?>

<?php
// Debugging: Check if the login timestamp is set
if (!isset($_SESSION['login_timestamp'])) {
    echo "Login time is not set!";
} else {
    echo "Login time: " . date("Y-m-d H:i:s", $_SESSION['login_timestamp']);
}
?>

<!-- Add JavaScript to calculate time spent -->
<script>
   // Get the login timestamp from PHP (session data)
var loginTimestamp = <?php echo isset($_SESSION['login_timestamp']) ? $_SESSION['login_timestamp'] : 0; ?>;

// Function to calculate the elapsed time
function updateTimeSpent() {
    var currentTime = Math.floor(Date.now() / 1000); // Current time in seconds
    var timeSpent = currentTime - loginTimestamp;

    // Make sure the time spent is not negative
    if (timeSpent < 0) {
        timeSpent = 0;
    }

    // Calculate hours, minutes, and seconds
    var hours = Math.floor(timeSpent / 3600);
    var minutes = Math.floor((timeSpent % 3600) / 60);
    var seconds = timeSpent % 60;

    // Format the time as hh:mm:ss
    var formattedTime = hours + " hours " + minutes + " minutes " + seconds + " seconds";

    // Display the time in the navbar and sidebar
    document.getElementById('timeSpent').textContent = "Time Spent: " + formattedTime;
}

// Update time every second
setInterval(updateTimeSpent, 1000);
</script>