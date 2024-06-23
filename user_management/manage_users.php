<?php
session_start();
require_once('../database_and_services/db_config.php');
$conn = OpenConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'add') {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_DEFAULT);
        $role = mysqli_real_escape_string($conn, $_POST['role']);

        $table = ucfirst($role) . 's';

        if (!in_array($table, ['Students', 'Counselors', 'Admins'])) {
            $_SESSION['message'] = "Invalid role selected.";
            header('Location: ../dashboard/admin_dashboard.php');
            exit();
        }

        $query = "INSERT INTO $table (username, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $password, $role);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "User added successfully.";
        } else {
            $_SESSION['message'] = "Error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } elseif ($action === 'edit') {
        $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $role = mysqli_real_escape_string($conn, $_POST['role']);

        $table = ucfirst($role) . 's';

        if (!in_array($table, ['Students', 'Counselors', 'Admins'])) {
            $_SESSION['message'] = "Invalid role selected.";
            header('Location: ../dashboard/admin_dashboard.php');
            exit();
        }

        $query = "UPDATE $table SET username = ?, email = ?, role = ? WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssi", $username, $email, $role, $user_id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "User updated successfully.";
        } else {
            $_SESSION['message'] = "Error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } elseif ($action === 'delete') {
        $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
        $role = mysqli_real_escape_string($conn, $_POST['role']);

        $table = ucfirst($role) . 's';

        if (!in_array($table, ['Students', 'Counselors', 'Admins'])) {
            $_SESSION['message'] = "Invalid role selected.";
            header('Location: ../dashboard/admin_dashboard.php');
            exit();
        }

        // Delete related records in counseling_sessions
        if ($role === 'student') {
            $query = "DELETE FROM counseling_sessions WHERE student_id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        } elseif ($role === 'counselor') {
            $query = "DELETE FROM counseling_sessions WHERE counselor_id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        // Now delete the user
        $query = "DELETE FROM $table WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $user_id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "User deleted successfully.";
        } else {
            $_SESSION['message'] = "Error deleting user: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}

CloseConnection($conn);
header('Location: ../dashboard/admin_dashboard.php');
exit();
?>
