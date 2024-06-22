<?php
function process_signin() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['email']) || !isset($_POST['password'])) {
        return "Invalid request.";
    }

    session_start();
    require_once('../database_and_services/db_config.php');
    $conn = OpenConnection();

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $query = "SELECT * FROM Students WHERE email = '$email' UNION 
              SELECT * FROM Admin WHERE email = '$email' UNION 
              SELECT * FROM Counselors WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        error_log("Database query error: " . mysqli_error($conn));
        return "Error checking email: " . mysqli_error($conn);
    }

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'user_id' => $user['user_id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'role' => $user['role']
            ];

            if (isset($_POST['rememberme'])) {
                setcookie('user', json_encode($_SESSION['user']), time() + (86400 * 7), "/");
            }

            switch ($user['role']) {
                case 'administrator':
                    header('Location: ../dashboard/admin_dashboard.php');
                    break;
                case 'counselor':
                    header('Location: ../dashboard/counselor_dashboard.php');
                    break;
                case 'student':
                    header('Location: ../dashboard/student_dashboard.php');
                    break;
                default:
                    error_log("Invalid user role for user: $email");
                    return "Invalid user role.";
            }
            exit();
        } else {
            error_log("Password does not match for user: $email");
            return "Invalid email or password.";
        }
    } else {
        error_log("No user found with email: $email");
        return "Invalid email or password.";
    }
}
?>

