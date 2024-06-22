<?php
session_start();
require_once('../database_and_services/db_config.php');
$conn = OpenConnection();

// Ensure user is logged in and is an admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'administrator') {
    header('Location: ../index.php');
    exit();
}

// Fetch all users
$users_query = "SELECT * FROM Students UNION SELECT * FROM Counselors UNION SELECT * FROM Admin";
$users_result = mysqli_query($conn, $users_query);
if (!$users_result) {
    die("Error fetching users: " . mysqli_error($conn));
}

// Fetch FAQs
$faqs_query = "SELECT * FROM faqs";
$faqs_result = mysqli_query($conn, $faqs_query);
if (!$faqs_result) {
    die("Error fetching FAQs: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/dashboards.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>Admin Dashboard</h1>
            <a href="../profile/admin_profile.php" class="btn-profile">Profile</a>
        </div>
    </div>
    <div class="container">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert">
                <?php 
                    echo $_SESSION['message']; 
                    unset($_SESSION['message']);
                ?>
            </div>
        <?php endif; ?>
        <div class="main">
            <div class="section">
                <h2>Manage Users</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($users_result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['role']); ?></td>
                            <td>
                                <form action="../user_management/manage_users.php" method="post" style="display:inline;">
                                    <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                    <input type="hidden" name="action" value="edit">
                                    <button type="submit" class="btn">Edit</button>
                                </form>
                                <form action="../user_management/manage_users.php" method="post" style="display:inline;">
                                    <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit" class="btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
                <form action="../user_management/manage_users.php" method="post">
                    <h3>Add New User</h3>
                    <input type="hidden" name="action" value="add">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select id="role" name="role" required>
                            <option value="" disabled selected>Select role</option>
                            <option value="student">Student</option>
                            <option value="counselor">Counselor</option>
                            <option value="administrator">Administrator</option>
                        </select>
                    </div>
                    <button type="submit" class="btn">Add User</button>
                </form>
            </div>
            <div class="section">
                <h2>Manage FAQs</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Action</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($faqs_result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['question']); ?></td>
                            <td><?php echo htmlspecialchars($row['answer']); ?></td>
                            <td>
                                <form action="../faq_management/manage_faqs.php" method="post" style="display:inline;">
                                    <input type="hidden" name="faq_id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="action" value="edit">
                                    <button type="submit" class="btn">Edit</button>
                                </form>
                                <form action="../faq_management/manage_faqs.php" method="post" style="display:inline;">
                                    <input type="hidden" name="faq_id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit" class="btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
                <form action="../faq_management/manage_faqs.php" method="post">
                    <h3>Add New FAQ</h3>
                    <input type="hidden" name="action" value="add">
                    <div class="form-group">
                        <label for="question">Question</label>
                        <input type="text" id="question" name="question" required>
                    </div>
                    <div class="form-group">
                        <label for="answer">Answer</label>
                        <textarea id="answer" name="answer" required></textarea>
                    </div>
                    <button type="submit" class="btn">Add FAQ</button>
                </form>
            </div>
        </div>
    </div>
    <?php require_once('../includes/footer.php'); ?>
</body>
</html>

<?php
CloseConnection($conn);
?>
