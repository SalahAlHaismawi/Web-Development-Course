<?php
session_start();
require_once('db_config.php');
$conn = OpenConnection();

if (isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['role'])) {
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $role = trim(mysqli_real_escape_string($conn, $_POST['role']));

    if ($password !== $confirmPassword) {
        $_SESSION['message'] = "<span style='color:red;'>Passwords do not match.</span>";
        $_SESSION['redirectUrl'] = "signup.php";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = "<span style='color:red;'>Invalid email format.</span>";
        $_SESSION['redirectUrl'] = "signup.php";
    } else if ($role !== 'student' && $role !== 'counselor' && $role !== 'administrator') {
        $_SESSION['message'] = "<span style='color:red;'>Invalid role selection.</span>";
        $_SESSION['redirectUrl'] = "signup.php";
    } else {
        // Check if email already exists in any of the tables
        $email_query = "SELECT email FROM Students WHERE email = '$email' UNION 
                        SELECT email FROM Admin WHERE email = '$email' UNION 
                        SELECT email FROM Counselors WHERE email = '$email'";
        $email_result = mysqli_query($conn, $email_query);
        if (!$email_result) {
            $_SESSION['message'] = "<span style='color:red;'>Error checking email: " . mysqli_error($conn) . "</span>";
            $_SESSION['redirectUrl'] = "signup.php";
            header("Location: signup_confirmation.php");
            exit();
        }

        // Check if username already exists in any of the tables
        $username_query = "SELECT username FROM Students WHERE username = '$username' UNION 
                           SELECT username FROM Admin WHERE username = '$username' UNION 
                           SELECT username FROM Counselors WHERE username = '$username'";
        $username_result = mysqli_query($conn, $username_query);
        if (!$username_result) {
            $_SESSION['message'] = "<span style='color:red;'>Error checking username: " . mysqli_error($conn) . "</span>";
            $_SESSION['redirectUrl'] = "signup.php";
            header("Location: signup_confirmation.php");
            exit();
        }

        if (mysqli_num_rows($email_result) > 0) {
            $_SESSION['message'] = "<span style='color:red;'>Email is already in use.</span>";
            $_SESSION['redirectUrl'] = "signup.php";
        } else if (mysqli_num_rows($username_result) > 0) {
            $_SESSION['message'] = "<span style='color:red;'>Username is already in use.</span>";
            $_SESSION['redirectUrl'] = "signup.php";
        } else {
            addUserIntoDatabase($conn, $username, $email, $password, $role);
        }
    }
    header("Location: signup_confirmation.php");
    exit();
} else {
    header("location: index.php");
    exit();
}

function addUserIntoDatabase($conn, $username, $email, $password, $role)
{
    // Hash the password before storing it in the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Determine the table based on the role
    $table = '';
    switch ($role) {
        case 'student':
            $table = 'Students';
            break;
        case 'counselor':
            $table = 'Counselors';
            break;
        case 'administrator':
            $table = 'Admin';
            break;
        default:
            $_SESSION['message'] = "<span style='color:red;'>Invalid role.</span>";
            $_SESSION['redirectUrl'] = "signup.php";
            header("Location: signup_confirmation.php");
            exit();
    }

    // Prepare an insert statement
    $query = "INSERT INTO $table (username, email, password, role) VALUES (?, ?, ?, ?)";

    // Create a prepared statement
    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        $_SESSION['message'] = "<span style='color:red;'>Error preparing statement: " . mysqli_error($conn) . "</span>";
        $_SESSION['redirectUrl'] = "signup.php";
        header("Location: signup_confirmation.php");
        exit();
    }

    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashedPassword, $role);

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "<span style='color:green;'>Sign up successful. Now you may log in.</span>";
        $_SESSION['redirectUrl'] = "signin.php";
    } else {
        $_SESSION['message'] = "<span style='color:red;'>Something went wrong. Please try again later.</span>";
        $_SESSION['redirectUrl'] = "signup.php";
    }

    // Close statement
    mysqli_stmt_close($stmt);
    CloseConnection($conn);
}
?>
