<?php
session_start();
require_once('../db_config.php');
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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Counselor Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="StudentDashboard.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>Counselor Dashboard</h1>
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
                                    <form action="../update_request_status.php" method="post">
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
                                    <form action="../update_request_status.php" method="post">
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
        </div>
    </div>
    <?php require_once('../includes/footer.php'); ?>
</body>
</html>

<?php
CloseConnection($conn);
?>
