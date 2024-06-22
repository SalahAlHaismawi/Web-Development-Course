<?php
session_start();
require_once('../database_and_services/db_config.php');
$conn = OpenConnection();

// Fetch counselors for the dropdown
$counselors_query = "SELECT user_id, username FROM Counselors";
$counselors_result = mysqli_query($conn, $counselors_query);

// Fetch past sessions for reviews
$student_id = $_SESSION['user']['user_id'];
$sessions_query = "SELECT session_id, counselor_id, date, time, status FROM counseling_sessions WHERE student_id = '$student_id' AND status = 'completed'";
$sessions_result = mysqli_query($conn, $sessions_query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/dashboards.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>Student Dashboard</h1>
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
                <h2>Create a New Counseling Session Request</h2>
                <form action="../session_management/create_session.php" method="post">
                    <div class="form-group">
                        <label for="counselor">Choose a Counselor</label>
                        <select id="counselor" name="counselor_id" required>
                            <option value="" disabled selected>Select a counselor</option>
                            <?php while ($row = mysqli_fetch_assoc($counselors_result)) : ?>
                                <option value="<?php echo $row['user_id']; ?>"><?php echo $row['username']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date">Preferred Date</label>
                        <input type="date" id="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="time">Preferred Time</label>
                        <input type="time" id="time" name="time" required>
                    </div>
                    <button type="submit" class="btn">Request Session</button>
                </form>
            </div>
            <div class="section">
                <h2>Write a Review of Past Sessions</h2>
                <form action="../review_management/submit_review.php" method="post">
                    <div class="form-group">
                        <label for="session">Choose a Session</label>
                        <select id="session" name="session_id" required>
                            <option value="" disabled selected>Select a session</option>
                            <?php while ($row = mysqli_fetch_assoc($sessions_result)) : ?>
                                <option value="<?php echo $row['session_id']; ?>">
                                    Session with Counselor ID: <?php echo $row['counselor_id']; ?> on <?php echo $row['date']; ?> at <?php echo $row['time']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="rating">Rating</label>
                        <input type="number" id="rating" name="rating" min="1" max="5" required>
                    </div>
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <textarea id="comment" name="comment" required></textarea>
                    </div>
                    <button type="submit" class="btn">Submit Review</button>
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
