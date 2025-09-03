<?php
session_start();
$response = array();
// Perform logout operations here
unset($_SESSION["id"]);
unset($_SESSION["name"]);
unset($_SESSION["login_timestamp"]);
$response['status'] = 'success';
$response['message'] = 'Logged out successfully';
echo json_encode($response);
?>