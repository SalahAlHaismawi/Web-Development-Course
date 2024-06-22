<?php
require_once('../database_and_services/db_config.php');
$conn = OpenConnection();

if (isset($_POST['email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $emailRegex = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/';
    if (!preg_match($emailRegex, $email)) {
        echo "<span style='color:red;'>Invalid email format.</span>";
    } else {
        // Check if email already exists in any of the tables
        $query = "SELECT email FROM Students WHERE email = '$email' UNION 
                  SELECT email FROM Admin WHERE email = '$email' UNION 
                  SELECT email FROM Counselors WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            echo "<span style='color:red;'>Error checking email: " . mysqli_error($conn) . "</span>";
        } else if (mysqli_num_rows($result) > 0) {
            echo "<span style='color:red;'>Email is already in use.</span>";
        } else {
            echo "<span style='color:green;'>Email confirmed.</span>";
        }
    }
} else {
    header("Location: index.php");
    exit();
}
?>
