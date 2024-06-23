<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('../database_and_services/db_config.php');
$conn = OpenConnection();

if (!isset($_SESSION['user'])) {
    header('Location: ../authentication/signin.php');
    exit();
}

$user_id = $_SESSION['user']['user_id'];
$role = $_SESSION['user']['role'];
$table = '';

switch ($role) {
    case 'administrator':
        $table = 'Admin';
        $dashboard_url = '../dashboard/admin_dashboard.php';
        break;
    case 'counselor':
        $table = 'Counselors';
        $dashboard_url = '../dashboard/counselor_dashboard.php';
        break;
    case 'student':
        $table = 'Students';
        $dashboard_url = '../dashboard/student_dashboard.php';
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
    <style>
        .profile-pic {
            display: block;
            margin: 0 auto 1.5rem;
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 2px solid #ddd;
        }
        .profile-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
        }
        .profile-container > .info-container {
            flex: 1 1 calc(50% - 1.5rem);
            box-sizing: border-box;
        }
        .title-text {
            font-size: 1.2em;
            margin-bottom: 0.5rem;
        }
    </style>
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
            <!-- Display the profile picture at the top -->


            <form action="./upload_profile_picture.php" method="post" enctype="multipart/form-data">
                <h2 style="text-align: center">Profile Information</h2>

                <?php if (isset($user['profile_picture']) && $user['profile_picture']): ?>
                <img src="../uploads/<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" class="profile-pic">
            <?php endif; ?>
                <div class="profile-container">
                   <div class="info-container">
                       <h1 class="title-text">USERNAME:</h1>
                       <p class="profile-text"><?php echo htmlspecialchars($user['username']); ?></p>
                   </div>
                   <div class="info-container">
                       <h1 class="title-text">E-MAIL:</h1>
                       <p class="profile-text"><?php echo htmlspecialchars($user['email']); ?></p>
                   </div>
                   <div class="info-container">
                       <h1 class="title-text">ROLE:</h1>
                       <p class="profile-text"><?php echo htmlspecialchars($user['role']); ?></p>
                   </div>
               </div>

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
        </div>
        <a href="<?php echo $dashboard_url; ?>" class="btn">Back to Dashboard</a>
    </div>
</body>
</html>
<?php CloseConnection($conn); ?>
