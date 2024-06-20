<?php
session_start();
require_once('db_config.php');
$conn = OpenConnection();

if(isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['role'])){
    $username = mysqli_escape_string( $conn, $_POST['username'] );
    $email = mysqli_escape_string( $conn, $_POST['email'] );
    $password = mysqli_escape_string( $conn, $_POST['password'] );
    $confirmPassword = mysqli_escape_string( $conn, $_POST['confirm_password'] );
    $role = mysqli_escape_string( $conn, $_POST['role'] );

    if ($password !== $confirmPassword) {
        $_SESSION['message'] = "<span style='color:red;'>Passwords do not match.</span>";
        $_SESSION['redirectUrl'] = "signup.php";
    } else if (!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/", $email)) {
        $_SESSION['message'] = "<span style='color:red;'>Invalid email format.</span>";
        $_SESSION['redirectUrl'] = "signup.php";
    } else if ($role !== 'student' && $role !== 'counsellor') {
        $_SESSION['message'] = "<span style='color:red;'>Invalid role selection.</span>";
        $_SESSION['redirectUrl'] = "signup.php";
    } else {
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0){
            $_SESSION['message'] = "<span style='color:red;'>Email is already in used.</span>";
            $_SESSION['redirectUrl'] = "signup.php";
        } else {
            $_SESSION['message'] = "<span style='color:green;'>Sign up successful. Now you may log in.</span>";
            $_SESSION['redirectUrl'] = "signin.php";
        }
    }
    header("Location: signupconfirmation.php");
    exit();
} else{
    header("location: index.php");
}
?>