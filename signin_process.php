<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header('Location: index.php');
    exit;
}

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
            if($user['role'] == 'admin'){
                header('Location: admin_page.php');
                exit;
            } else {
                header('Location: user_page.php');
                exit;
            }
        } else {
            return "Invalid email or password.";
        }
    } else {
        return "Invalid email or password.";
    }
}
?>