<?php
session_start();
require_once('../database_and_services/db_config.php');
$conn = OpenConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $session_id = mysqli_real_escape_string($conn, $_POST['session_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $query = "UPDATE counseling_sessions SET status = '$status' WHERE session_id = '$session_id'";

    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Session status updated successfully.";
    } else {
        $_SESSION['message'] = "Error: " . mysqli_error($conn);
    }
}

CloseConnection($conn);
header('Location: ../dashboard/counselor_dashboard.php');
exit();

