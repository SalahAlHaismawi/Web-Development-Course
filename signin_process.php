<?php
function process_signin() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['email']) || !isset($_POST['password'])) {
        return;
    }

    session_start();
    require_once('db_config.php');
    $conn = OpenConnection();

    $email = mysqli_escape_string($conn, $_POST['email']);
    $password = mysqli_escape_string($conn, $_POST['password']);
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['role'] = $user['role'];
            if(isset($_POST['rememberme'])) {
                //cookies set for 7 days before expiring
                setcookie('role', $user['role'], time() + (86400 * 7), "/");
            }
            if($user['role'] == 'admin'){
                header('Location: dashboard/admin_dashboard.php');
                exit;
            } elseif($user['role'] == 'counselor') {
                header('Location: dashboard/counselor_dashboard.php');
                exit;
            } elseif($user['role'] == 'student') {
                header('Location: dashboard/student_dashboard.php');
                exit;
            }
        } else {
            return "Invalid email or password.";
        }
    } else {
        return "Invalid email or password.";
    }
}