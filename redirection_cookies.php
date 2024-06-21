<?php
if (isset($_COOKIE['role'])) {
    $role = $_COOKIE['role'];
    if ($role == 'admin') {
        header('Location: dashboard/admin_dashboard.php');
        exit;
    } elseif ($role == 'counselor') {
        header('Location: dashboard/counselor_dashboard.php');
        exit;
    } elseif ($role == 'student') {
        header('Location: dashboard/student_dashboard.php');
        exit;
    }
}
// rest of your index.php code
?>