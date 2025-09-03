<?php
include ("connect2.php");

  $category = $_POST['category'];
  $name = $_POST['name'];
  $short_name = $_POST['short_name'];
  $price = $_POST['price'];

  // Check if the category and name already exist in the database
  $checkQuery = "SELECT * FROM course WHERE category = '$category' AND name = '$name'";
  $result = $conn->query($checkQuery);

  if ($result->num_rows > 0) {
    // Data already exists, return an error message to the AJAX request
    echo "Already exists";
  } else {
    // Insert the new record into the database
    $sql = "INSERT INTO course (category, name, short_name, price) VALUES ('$category','$name','$short_name',$price)";

    if ($conn->query($sql) === TRUE) {
      // Return success message to the AJAX request
      echo "success";
    } else {
      // Return error message to the AJAX request
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
$conn->close();
?>
