<?php
session_start();
require_once('db_config.php');
$conn = OpenConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_SESSION['user']['user_id'];
    $counselor_id = mysqli_real_escape_string($conn, $_POST['counselor_id']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);

    // Ensure all fields are provided
    if (!empty($student_id) && !empty($counselor_id) && !empty($date) && !empty($time)) {
        $query = "INSERT INTO counseling_sessions (student_id, counselor_id, date, time, status) VALUES ('$student_id', '$counselor_id', '$date', '$time', 'pending')";

        if (mysqli_query($conn, $query)) {
            $_SESSION['message'] = "Session requested successfully.";
        } else {
            $_SESSION['message'] = "Error: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['message'] = "All fields are required.";
    }
}

CloseConnection($conn);
header('Location: dashboard/student_dashboard.php');
exit();
?>
