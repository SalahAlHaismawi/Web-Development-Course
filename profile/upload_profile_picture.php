<?php
session_start();
require_once('../database_and_services/db_config.php');
$conn = OpenConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $table = '';

    switch ($role) {
        case 'administrator':
            $table = 'Admin';
            $role_file = 'admin';
            break;
        case 'counselor':
            $table = 'Counselors';
            $role_file = 'counselor';
            break;
        case 'student':
            $table = 'Students';
            $role_file = 'student';
            break;
        default:
            $_SESSION['message'] = "Invalid user role.";
            header('Location: ../profile/' . $role_file . '_profile.php');
            exit();
    }

    if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == 0) {
        $target_dir = "../uploads/";

        // Check if uploads directory exists, if not create it
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        // Generate a unique file name to prevent overwriting
        $filename = uniqid() . '-' . basename($_FILES["profile_picture"]["name"]);
        $target_file = $target_dir . $filename;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $_SESSION['message'] = "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["profile_picture"]["size"] > 500000) {
            $_SESSION['message'] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            $_SESSION['message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $_SESSION['message'] = "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                $query = "UPDATE $table SET profile_picture = '$filename' WHERE user_id = '$user_id'";
                if (mysqli_query($conn, $query)) {
                    $_SESSION['message'] = "Profile picture uploaded successfully.";
                } else {
                    $_SESSION['message'] = "Error: " . mysqli_error($conn);
                }
            } else {
                $_SESSION['message'] = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $_SESSION['message'] = "No file was uploaded.";
    }
}

CloseConnection($conn);
header('Location: ../profile/' . $role_file . '_profile.php');
exit();
?>
