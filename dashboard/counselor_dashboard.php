<?php
session_start();
require_once('../database_and_services/db_config.php');
$conn = OpenConnection();

// Ensure user is logged in and is a counselor
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'counselor') {
    header('Location: ../index.php');
    exit();
}

// Fetch pending requests for counseling assigned to this counselor
$counselor_id = $_SESSION['user']['user_id'];
$requests_query = "SELECT cs.session_id, cs.student_id, s.username as student_name, cs.date, cs.time, cs.status 
                   FROM counseling_sessions cs
                   JOIN Students s ON cs.student_id = s.user_id
                   WHERE cs.counselor_id = '$counselor_id' AND cs.status = 'pending'";
$requests_result = mysqli_query($conn, $requests_query);

// Fetch accepted requests for counseling
$accepted_requests_query = "SELECT cs.session_id, cs.student_id, s.username as student_name, cs.date, cs.time, cs.status 
                            FROM counseling_sessions cs
                            JOIN Students s ON cs.student_id = s.user_id
                            WHERE cs.counselor_id = '$counselor_id' AND cs.status = 'accepted'";
$accepted_requests_result = mysqli_query($conn, $accepted_requests_query);

// Fetch reviews for completed sessions
$reviews_query = "SELECT r.review_id, r.session_id, r.rating, r.comment, s.username as student_name, cs.date, cs.time
                  FROM reviews r
                  JOIN counseling_sessions cs ON r.session_id = cs.session_id
                  JOIN Students s ON cs.student_id = s.user_id
                  WHERE cs.counselor_id = '$counselor_id'";
$reviews_result = mysqli_query($conn, $reviews_query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Counselor Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/dashboards.css">
</head>
<body>
    <div class="header">
        <div class="button-container">
            <a href="../profile/counselor_profile.php" class="round-button">
                <img style="width: 30px; height: 30px; border-radius: 100%" src="../assets/images/profileIcon.jpg" alt="Profile Icon" class="profile-section-class">
            </a>
            <h1>Counselor Dashboard</h1>
            <a href="../authentication/logout.php" class="logoutButton">
                <span>Logout</span>
                <i class="fas fa-sign-out-alt"></i>
            </a>
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
                <h2>View Counseling Requests</h2>
                <?php if (mysqli_num_rows($requests_result) > 0): ?>
                    <table>
                        <tr>
                            <th>Student</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                        <?php while ($row = mysqli_fetch_assoc($requests_result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['date']); ?></td>
                                <td><?php echo htmlspecialchars($row['time']); ?></td>
                                <td>
                                    <form action="../session_management/update_request_status.php" method="post">
                                        <input type="hidden" name="session_id" value="<?php echo htmlspecialchars($row['session_id']); ?>">
                                        <input type="hidden" name="status" value="accepted">
                                        <button type="submit" class="btn">Accept</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                <?php else: ?>
                    <p>No pending requests.</p>
                <?php endif; ?>
            </div>
            <div class="section">
                <h2>Accepted Requests</h2>
                <?php if (mysqli_num_rows($accepted_requests_result) > 0): ?>
                    <table>
                        <tr>
                            <th>Student</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                        <?php while ($row = mysqli_fetch_assoc($accepted_requests_result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['date']); ?></td>
                                <td><?php echo htmlspecialchars($row['time']); ?></td>
                                <td>
                                    <form action="../session_management/update_request_status.php" method="post">
                                        <input type="hidden" name="session_id" value="<?php echo htmlspecialchars($row['session_id']); ?>">
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="btn">Mark as Done</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                <?php else: ?>
                    <p>No accepted requests.</p>
                <?php endif; ?>
            </div>
            <div class="section">
                <h2>Reviews</h2>
                <?php if (mysqli_num_rows($reviews_result) > 0): ?>
                    <table>
                        <tr>
                            <th>Student</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Rating</th>
                            <th>Comment</th>
                        </tr>
                        <?php while ($row = mysqli_fetch_assoc($reviews_result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['date']); ?></td>
                                <td><?php echo htmlspecialchars($row['time']); ?></td>
                                <td><?php echo htmlspecialchars($row['rating']); ?></td>
                                <td><?php echo htmlspecialchars($row['comment']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                <?php else: ?>
                    <p>No reviews available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>

<?php
CloseConnection($conn);
?>
