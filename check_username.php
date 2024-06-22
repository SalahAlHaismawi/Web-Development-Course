<?php
require_once('db_config.php');
$conn = OpenConnection();

if (isset($_POST['username'])) {
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    
    // Check if username already exists in any of the tables
    $query = "SELECT username FROM Students WHERE username = '$username' UNION 
              SELECT username FROM Admin WHERE username = '$username' UNION 
              SELECT username FROM Counselors WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "<span style='color:red;'>Error checking username: " . mysqli_error($conn) . "</span>";
    } else if (mysqli_num_rows($result) > 0) {
        echo "<span style='color:red;'>Username is already in use.</span>";
    } else {
        echo "<span style='color:green;'>Username available.</span>";
    }
} else {
    header("Location: index.php");
    exit();
}
?>
