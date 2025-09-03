<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_SESSION["name"])) {
    // Include database connection
    include 'paths/connect.php';
    
    // Get the filter dates from POST request
    $startDate = isset($_POST['startDate']) ? $_POST['startDate'] : '';
    $endDate = isset($_POST['endDate']) ? $_POST['endDate'] : '';

    // Prepare where condition for filtering
    $dateCondition = '';
    if ($startDate && $endDate) {
        $dateCondition = " WHERE doj BETWEEN '$startDate' AND '$endDate'";
    }

    // Fetch total students count with date filter
    $sql_students = "SELECT COUNT(id) AS count FROM students" . $dateCondition;
    $result_students = $conn->query($sql_students);
    $row_students = $result_students->fetch(PDO::FETCH_ASSOC);
    $student_count = $row_students['count'];

    // Fetch total courses count (no date filter applied as courses don't have a created_at field)
    $sql_courses = "SELECT COUNT(id) AS count FROM course";
    $result_courses = $conn->query($sql_courses);
    $row_courses = $result_courses->fetch(PDO::FETCH_ASSOC);
    $course_count = $row_courses['count'];

    // Fetch total certificate count with date filter
    $sql_certificate = "SELECT COUNT(stu_id) AS count FROM files LEFT JOIN students ON students.id = files.stu_id" . $dateCondition;
    $result_certificate = $conn->query($sql_certificate);
    $row_certificate = $result_certificate->fetch(PDO::FETCH_ASSOC);
    $certificate_count = $row_certificate['count'];

    // Fetch total enrolled amount with date filter
    $sql_enrolled_amount = "SELECT SUM(fees) AS total_enrolled FROM students" . $dateCondition;
    $result_enrolled_amount = $conn->query($sql_enrolled_amount);
    $row_enrolled_amount = $result_enrolled_amount->fetch(PDO::FETCH_ASSOC);
    $total_enrolled = $row_enrolled_amount['total_enrolled'];

    // Fetch data for total students by course chart
    $sql_students_by_course = "SELECT course, COUNT(id) AS count FROM students GROUP BY course";
    $result_students_by_course = $conn->query($sql_students_by_course);

    $dataPoints_students_by_course = array();
    while ($row = $result_students_by_course->fetch(PDO::FETCH_ASSOC)) {
        $dataPoints_students_by_course[] = array("label" => $row["course"], "y" => $row["count"]);
    }

    // Fetch data for total courses by category chart
    $sql_courses_by_category = "SELECT category, COUNT(id) AS count FROM course GROUP BY category";
    $result_courses_by_category = $conn->query($sql_courses_by_category);

    $dataPoints_courses_by_category = array();
    while ($row = $result_courses_by_category->fetch(PDO::FETCH_ASSOC)) {
        $dataPoints_courses_by_category[] = array("label" => $row["category"], "y" => $row["count"]);
    }

    // Fetch data for total students by status chart with date filter
    $sql_students_by_status = "SELECT status, COUNT(id) AS count FROM students" . $dateCondition . " GROUP BY status";
    $result_students_by_status = $conn->query($sql_students_by_status);

    $dataPoints_students_by_status = array();
    while ($row = $result_students_by_status->fetch(PDO::FETCH_ASSOC)) {
        $dataPoints_students_by_status[] = array("label" => $row["status"], "y" => $row["count"]);
    }

    // Fetch total pending amount with date filter
    $sql_pending_amount = "SELECT SUM(pnd_amt) AS total_pending FROM students" . $dateCondition;
    $result_pending_amount = $conn->query($sql_pending_amount);
    $row_pending_amount = $result_pending_amount->fetch(PDO::FETCH_ASSOC);
    $total_pending = $row_pending_amount['total_pending'];

    // Fetch total collected amount with date filter
    $sql_collected_amount = "SELECT SUM(fees) - sum(pnd_amt) AS total_collected FROM students" . $dateCondition;
    $result_collected_amount = $conn->query($sql_collected_amount);
    $row_collected_amount = $result_collected_amount->fetch(PDO::FETCH_ASSOC);
    $total_collected = $row_collected_amount['total_collected'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Dashboard - Admin Panel | Master Tech Education</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/mdb.min.css">
    <link rel="stylesheet" href="assets/css/faq-accordian.css">
    <script src="assets/js/mdb.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    <link rel="shortcut icon" href="assets/images/logo.jpeg" type="image/x-icon">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css'>
    <link rel='stylesheet' href='https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css'>
    <script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/86186/moment.js'></script>
    <script src='https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js'></script>
    <script src="assets/js/scripts.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
      .canvasjs-chart-credit
      {
        display:none;
      }
    </style>
</head>
<body style="overflow-x:hidden;background-image: url('');background-repeat:no-repeat;background-size:cover;" class="gradient-custom-3">
<header >
<?php 
include 'paths/header.php';
?>
</header>
<main style="margin-top: 58px; overflow-x: hidden;">
  <div class="container-fluid">
    <div class="wrapper wrapper-faq-accordian">
      <div class="container container-faq-accordian">
        <div class="question">
          <h5>Filters</h5>
        </div>
        <div class="answercont">
          <div class="answer">
            <form action="" method="post">
                <!-- Date Input Fields -->
                <div class="mb-3">
                    <label for="startDate" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="startDate" name="startDate" value="<?php echo isset($startDate) ? $startDate : ''; ?>">
                </div>
            
                <div class="mb-3">
                    <label for="endDate" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="endDate" name="endDate" value="<?php echo isset($endDate) ? $endDate : ''; ?>">
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <!-- Submit Button -->
                        <button type="submit" value="Apply Filters" class="btn btn-primary btn-md w-100 me-2">Apply Filters</button>
                    </div>
                    <div class="col-6">
                        <!-- Reset Button -->
                        <button type="button" onclick="resetFilters()" class="btn btn-secondary btn-md w-100">Reset Filters</button>
                    </div>
                    
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <script>
        let question = document.querySelectorAll(".question");

        question.forEach(question => {
          question.addEventListener("click", event => {
            const active = document.querySelector(".question.active");
            if(active && active !== question ) {
              active.classList.toggle("active");
              active.nextElementSibling.style.maxHeight = 0;
            }
            question.classList.toggle("active");
            const answer = question.nextElementSibling;
            if(question.classList.contains("active")){
              answer.style.maxHeight = answer.scrollHeight + "px";
            } else {
              answer.style.maxHeight = 0;
            }
          })
        })

    </script>
    <div class="row p-3">
        <!-- Total Students Card -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-users"></i> Total Students
                </div>
                <div class="card-body text-center">
                    <h4 class="display-8"><?php echo $student_count; ?></h4>
                    <p>Number of students enrolled</p>
                    <a href="fetch_student<?php if($startDate && $endDate){ echo '?startDate=' . $startDate . '&endDate=' . $endDate; } ?>" class="btn btn-primary btn-md rounded-pill">See Details</a>
                </div>
                <div class="card-footer text-center text-muted">Updated Recently</div>
            </div>
        </div>
        
        <!-- Total Certificates Card -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-warning text-dark">
                    <i class="fas fa-certificate"></i>Total Certificates
                </div>
                <div class="card-body text-center">
                    <h4 class="display-8"><?php echo $certificate_count; ?></h4>
                    <p>Number of Certificates issued</p>
                    <a href="fetch_certificate<?php if($startDate && $endDate){ echo '?startDate=' . $startDate . '&endDate=' . $endDate; } ?>" class="btn btn-warning btn-md rounded-pill">See Details</a>
                </div>
                <div class="card-footer text-center text-muted">Updated Recently</div>
            </div>
        </div>
        
        <!-- Total Collected Amount Card -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-dollar-sign"></i> Total Enrolled Amount
                </div>
                <div class="card-body text-center">
                    <h4 class="display-8">₹<?php echo number_format($total_enrolled, 2); ?></h4>
                    <p>Total amount enrolled</p>
                    <a href="#" class="btn btn-info btn-md rounded-pill">See Details</a>
                </div>
                <div class="card-footer text-center text-muted">Updated Recently</div>
            </div>
        </div>
        
        <!-- Total Courses Card -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-book"></i> Total Courses
                </div>
                <div class="card-body text-center">
                    <h4 class="display-8"><?php echo $course_count; ?></h4>
                    <p>Number of courses available</p>
                    <a href="fetch_course" class="btn btn-success btn-md rounded-pill">See Details</a>
                </div>
                <div class="card-footer text-center text-muted">Updated Recently</div>
            </div>
        </div>
    </div>
    
    <div class="row">
      <!-- Students by Status Chart -->
      <div class="col-lg-6 col-md-12 mb-4">
        <div class="card shadow-sm border-0 rounded-4">
          <div class="card-header bg-info text-white">
            <i class="fas fa-users-cog"></i> Students by Status
          </div>
          <div class="card-body">
            <div id="studentsByStatusChart" style="height: 300px;"></div>
          </div>
        </div>
      </div>

      <!-- Pending vs Collected Amount Chart -->
      <div class="col-lg-6 col-md-12 mb-4">
        <div class="card shadow-sm border-0 rounded-4">
          <div class="card-header bg-warning text-dark">
            <i class="fas fa-money-check-alt"></i> Pending vs Collected Amount
          </div>
          <div class="card-body">
            <div id="amountChart" style="height: 300px;"></div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row">
      <!-- Students by Course Chart -->
      <div class="col-lg-6 col-md-12 mb-4">
        <div class="card shadow-sm border-0 rounded-4">
          <div class="card-header bg-primary text-white">
            <i class="fas fa-chalkboard-teacher"></i> Students by Course
          </div>
          <div class="card-body">
            <div id="studentsByCourseChart" style="height: 300px;"></div>
          </div>
        </div>
      </div>

      <!-- Courses by Category Chart -->
      <div class="col-lg-6 col-md-12 mb-4">
        <div class="card shadow-sm border-0 rounded-4">
          <div class="card-header bg-success text-white">
            <i class="fas fa-tags"></i> Courses by Category
          </div>
          <div class="card-body">
            <div id="coursesByCategoryChart" style="height: 300px;"></div>
          </div>
        </div>
      </div>
    </div>

    
  </div>
</main>


<script>
  function resetFilters() {
      // Clear the date input fields and reload the page
      document.getElementById("startDate").value = "";
      document.getElementById("endDate").value = "";
      // Reload the page without any parameters to reset the filter
      window.location.href = window.location.pathname;
  }

</script>

<script>
  window.onload = function() {
      // Chart for Pending vs Collected Amount
      var amountChart = new CanvasJS.Chart("amountChart", {
        animationEnabled: true,
        title: {
            text: "Pending vs Collected Amount"
        },
        data: [{
            type: "column",
            dataPoints: [
                { label: "Collected Amount", y: <?php echo $total_collected; ?> },
                { label: "Pending Amount", y: <?php echo $total_pending; ?> }
            ]
        }]
    });
    amountChart.render();

      // Chart for Total Students by Course
      var studentsByCourseChart = new CanvasJS.Chart("studentsByCourseChart", {
          animationEnabled: true,
          title: { text: "Students by Course" },
          data: [{
              type: "doughnut",
              dataPoints: <?php echo json_encode($dataPoints_students_by_course, JSON_NUMERIC_CHECK); ?>
          }]
      });
      studentsByCourseChart.render();

      // Chart for Total Courses by Category
      var coursesByCategoryChart = new CanvasJS.Chart("coursesByCategoryChart", {
          animationEnabled: true,
          title: { text: "Courses by Category" },
          data: [{
              type: "pie",
              dataPoints: <?php echo json_encode($dataPoints_courses_by_category, JSON_NUMERIC_CHECK); ?>
          }]
      });
      coursesByCategoryChart.render();

      // Chart for Students by Status
      var studentsByStatusChart = new CanvasJS.Chart("studentsByStatusChart", {
        animationEnabled: true,
        title: { text: "Students by Status" },
        data: [{
            type: "column",
            dataPoints: <?php echo json_encode($dataPoints_students_by_status, JSON_NUMERIC_CHECK); ?>
        }]
    });
    studentsByStatusChart.render();
  }
</script>
<script>
    $(document).ready(function() {
        $('#main').addClass('active');
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