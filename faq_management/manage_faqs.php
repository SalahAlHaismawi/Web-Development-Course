<?php
session_start();
require_once('../database_and_services/db_config.php');
$conn = OpenConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    
    if ($action === 'add') {
        $question = mysqli_real_escape_string($conn, $_POST['question']);
        $answer = mysqli_real_escape_string($conn, $_POST['answer']);

        $query = "INSERT INTO faqs (question, answer) VALUES ('$question', '$answer')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['message'] = "FAQ added successfully.";
        } else {
            $_SESSION['message'] = "Error: " . mysqli_error($conn);
        }
    } elseif ($action === 'edit') {
        // Fetch current FAQ data
        $faq_id = mysqli_real_escape_string($conn, $_POST['faq_id']);
        $query = "SELECT * FROM faqs WHERE id = '$faq_id'";
        $result = mysqli_query($conn, $query);
        $faq = mysqli_fetch_assoc($result);

        // Display edit form
        if ($faq) {
            $_SESSION['edit_faq'] = $faq;
        }
    } elseif ($action === 'delete') {
        $faq_id = mysqli_real_escape_string($conn, $_POST['faq_id']);

        $query = "DELETE FROM faqs WHERE id = '$faq_id'";
        if (mysqli_query($conn, $query)) {
            $_SESSION['message'] = "FAQ deleted successfully.";
        } else {
            $_SESSION['message'] = "Error: " . mysqli_error($conn);
        }
    }
}

CloseConnection($conn);
header('Location: ../dashboard/admin_dashboard.php');
exit();

