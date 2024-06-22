<?php
function process_signin() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['email']) || !isset($_POST['password'])) {
        return "Invalid request.";
    }

    session_start();
    require_once('db_config.php');
    $conn = OpenConnection();

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $query = "SELECT * FROM Students WHERE email = '$email' UNION 
              SELECT * FROM Admin WHERE email = '$email' UNION 
              SELECT * FROM Counselors WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
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
                // Cookies set for 7 days before expiring
                setcookie('user', json_encode($_SESSION['user']), time() + (86400 * 7), "/");
            }

            switch ($user['role']) {
                case 'administrator':
                    header('Location: dashboard/admin_dashboard.php');
                    break;
                case 'counselor':
                    header('Location: dashboard/counselor_dashboard.php');
                    break;
                case 'student':
                    header('Location: dashboard/student_dashboard.php');
                    break;
                default:
                    return "Invalid user role.";
            }
            exit();
        } else {
            return "Invalid email or password.";
        }
    } else {
        return "Invalid email or password.";
    }
}
?>
