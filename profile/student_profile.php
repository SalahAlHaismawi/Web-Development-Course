<?php
// Ensure the user is logged in and is a student
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'student') {
    header('Location: ../index.php');
    exit();
}

include('profile_template.php');
?>
