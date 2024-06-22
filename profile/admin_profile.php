<?php
// Ensure the user is logged in and is an administrator
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'administrator') {
    header('Location: ../index.php');
    exit();
}

include('profile_template.php');
?>
