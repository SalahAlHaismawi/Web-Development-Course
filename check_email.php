<?php

require_once('db_config.php');
$conn = OpenConnection();
if(isset($_POST['email'])){
    $email = mysqli_escape_string( $conn, $_POST['email'] );
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<span style='color:red;'>Invalid email format.</span>";
    } else {
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0){
            echo "<span style='color:red;'>Email is already in used.</span>";
        }else{
            echo "<span style='color:green;'>Email confirmed.</span>";
        }
    }
}
?>