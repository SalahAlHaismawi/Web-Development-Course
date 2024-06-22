<?php
// Ensure the user is logged in and is a counselor
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'counselor') {
    header('Location: ../index.php');
    exit();
}

include('profile_template.php');
?>
