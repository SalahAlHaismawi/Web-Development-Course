<?php
session_start();
require_once('../database_and_services/db_config.php');
$conn = OpenConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $session_id = mysqli_real_escape_string($conn, $_POST['session_id']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    $query = "INSERT INTO reviews (session_id, rating, comment) VALUES ('$session_id', '$rating', '$comment')";

    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Review submitted successfully.";
    } else {
        $_SESSION['message'] = "Error: " . mysqli_error($conn);
    }
}

CloseConnection($conn);
header('Location: ../dashboard/student_dashboard.php');
exit();
?>
