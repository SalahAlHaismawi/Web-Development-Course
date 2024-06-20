<?php
session_start();
require_once ('db_config.php');
$conn = OpenConnection();

if (isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['role'])) {
    $username = trim(mysqli_escape_string($conn, $_POST['username']));
    $email = trim(mysqli_escape_string($conn, $_POST['email']));
    $password = mysqli_escape_string($conn, $_POST['password']);
    $confirmPassword = mysqli_escape_string($conn, $_POST['confirm_password']);
    $role = trim(mysqli_escape_string($conn, $_POST['role']));

    if ($password !== $confirmPassword) {
        $_SESSION['message'] = "<span style='color:red;'>Passwords do not match.</span>";
        $_SESSION['redirectUrl'] = "signup.php";
    } else if (!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/", $email)) {
        $_SESSION['message'] = "<span style='color:red;'>Invalid email format.</span>";
        $_SESSION['redirectUrl'] = "signup.php";
    } else if ($role !== 'student' && $role !== 'counselor') {
        $_SESSION['message'] = "<span style='color:red;'>Invalid role selection.</span>";
        $_SESSION['redirectUrl'] = "signup.php";
    } else {
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        $query2 = "SELECT * FROM users WHERE username = '$username'";
        $result2 = mysqli_query($conn, $query2);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION['message'] = "<span style='color:red;'>Email is already in use.</span>";
            $_SESSION['redirectUrl'] = "signup.php";
        } else if (mysqli_num_rows($result2) > 0) {
            $_SESSION['message'] = "<span style='color:red;'>Username is already in use.</span>";
            $_SESSION['redirectUrl'] = "signup.php";
        } else {
            addUserIntoDatabase($conn, $username, $email, $password, $role);
        }
    }
    header("Location: signupconfirmation.php");
    exit();
} else {
    header("location: index.php");
}
?>

<?php
function addUserIntoDatabase($conn, $username, $email, $password, $role)
{
    // Hash the password before storing in database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare an insert statement
    $query = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";

    // Create a prepared statement
    $stmt = mysqli_prepare($conn, $query);

    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashedPassword, $role);

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // Redirect to login page
        $_SESSION['message'] = "<span style='color:green;'>Sign up successful. Now you may log in.</span>";
        $_SESSION['redirectUrl'] = "signin.php";
    } else {
        echo "Something went wrong. Please try again later.";
    }

    // Close statement
    mysqli_stmt_close($stmt);
}