<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('../database_and_services/db_config.php');
$conn = OpenConnection();

$user_id = $_SESSION['user']['user_id'];
$role = $_SESSION['user']['role'];
$table = '';

switch ($role) {
    case 'administrator':
        $table = 'Admin';
        break;
    case 'counselor':
        $table = 'Counselor';
        break;
    case 'student':
        $table = 'Student';
        break;
    default:
        $_SESSION['message'] = "Invalid user role.";
        header('Location: ../index.php');
        exit();
}

$query = "SELECT * FROM $table WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching user: " . mysqli_error($conn));
}

$user = mysqli_fetch_assoc($result);

if (!$user) {
    $_SESSION['message'] = "User not found.";
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo ucfirst($role); ?> Profile</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <h1><?php echo ucfirst($role); ?> Profile</h1>
    </header>
    <div class="container">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert">
                <?php
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                ?>
            </div>
        <?php endif; ?>
        <div class="profile">
            <form action="upload_profile_picture.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                <input type="hidden" name="role" value="<?php echo $role; ?>">
                <div class="form-group">
                    <label for="profile_picture">Profile Picture</label>
                    <input type="file" name="profile_picture" id="profile_picture">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn">Upload Picture</button>
                </div>
            </form>
            <?php if (isset($user['profile_picture']) && $user['profile_picture']): ?>
                <img src="../uploads/<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture">
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php CloseConnection($conn); ?>
