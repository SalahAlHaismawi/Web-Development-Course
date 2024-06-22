<?php
session_start();
require_once('../db_config.php');
$conn = OpenConnection();

// Fetch pending requests for counseling
$pending_requests_query = "SELECT cs.session_id, cs.student_id, s.username as student_name, cs.counselor_id, c.username as counselor_name, cs.date, cs.time 
                           FROM counseling_sessions cs
                           JOIN Students s ON cs.student_id = s.user_id
                           JOIN Counselors c ON cs.counselor_id = c.user_id
                           WHERE cs.status = 'pending'";
$pending_requests_result = mysqli_query($conn, $pending_requests_query);

// Fetch accepted requests for counseling
$accepted_requests_query = "SELECT cs.session_id, cs.student_id, s.username as student_name, cs.counselor_id, c.username as counselor_name, cs.date, cs.time 
                            FROM counseling_sessions cs
                            JOIN Students s ON cs.student_id = s.user_id
                            JOIN Counselors c ON cs.counselor_id = c.user_id
                            WHERE cs.status = 'accepted'";
$accepted_requests_result = mysqli_query($conn, $accepted_requests_query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../StudentDashboard.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>Admin Dashboard</h1>
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
                <?php if (mysqli_num_rows($pending_requests_result) > 0): ?>
                    <table>
                        <tr>
                            <th>Student</th>
                            <th>Counselor</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                        <?php while ($row = mysqli_fetch_assoc($pending_requests_result)): ?>
                            <tr>
                                <td><?php echo $row['student_name']; ?></td>
                                <td><?php echo $row['counselor_name']; ?></td>
                                <td><?php echo $row['date']; ?></td>
                                <td><?php echo $row['time']; ?></td>
                                <td>
                                    <form action="../update_request_status.php" method="post">
                                        <input type="hidden" name="session_id" value="<?php echo $row['session_id']; ?>">
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
                            <th>Counselor</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                        <?php while ($row = mysqli_fetch_assoc($accepted_requests_result)): ?>
                            <tr>
                                <td><?php echo $row['student_name']; ?></td>
                                <td><?php echo $row['counselor_name']; ?></td>
                                <td><?php echo $row['date']; ?></td>
                                <td><?php echo $row['time']; ?></td>
                                <td>
                                    <form action="../update_request_status.php" method="post">
                                        <input type="hidden" name="session_id" value="<?php echo $row['session_id']; ?>">
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
