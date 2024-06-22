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
            $table = 'Counselor';
            $role_file = 'counselor';
            break;
        case 'student':
            $table = 'Student';
            $role_file = 'student';
            break;
        default:
            $_SESSION['message'] = "Invalid user role.";
            echo $_SESSION['message'];
            exit();
    }

    if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == 0) {
        $target_dir = "../uploads/";

        // Check if uploads directory exists, if not create it
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $_SESSION['message'] = "File is not an image.";
            echo $_SESSION['message'];
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["profile_picture"]["size"] > 500000) {
            $_SESSION['message'] = "Sorry, your file is too large.";
            echo $_SESSION['message'];
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $_SESSION['message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            echo $_SESSION['message'];
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $_SESSION['message'] = "Sorry, your file was not uploaded.";
            echo $_SESSION['message'];
        } else {
            // Debugging information
            error_log("Attempting to move uploaded file from: " . $_FILES["profile_picture"]["tmp_name"]);
            error_log("To target path: " . $target_file);

            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                $filename = basename($_FILES["profile_picture"]["name"]);
                $query = "UPDATE $table SET profile_picture = '$filename' WHERE user_id = '$user_id'";
                if (mysqli_query($conn, $query)) {
                    $_SESSION['message'] = "Profile picture uploaded successfully.";
                    echo $_SESSION['message'];
                } else {
                    $_SESSION['message'] = "Error: " . mysqli_error($conn);
                    echo $_SESSION['message'];
                }
            } else {
                $_SESSION['message'] = "Sorry, there was an error uploading your file.";
                echo $_SESSION['message'];
                error_log("Error moving uploaded file.");
            }
        }
    } else {
        $_SESSION['message'] = "No file was uploaded.";
        echo $_SESSION['message'];
        error_log("No file uploaded or upload error: " . $_FILES["profile_picture"]["error"]);
    }
}

CloseConnection($conn);
// Temporarily disable redirection
// header('Location: ../profile/' . $role_file . '_profile.php');
exit();
?>
