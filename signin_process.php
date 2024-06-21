<?php

require_once('db_config.php');
$conn = OpenConnection();

// if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
//     header('Location: index.php');
//     exit;
// }

if(isset($_POST['email']) && isset($_POST['password'])){
    $email = mysqli_escape_string( $conn, $_POST['email'] );
    $password = mysqli_escape_string( $conn, $_POST['password'] );

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            echo "<span style='color:green;'>Sign in successful.</span>";
        } else {
            echo "<span style='color:red;'>Invalid email or password.</span>";
            
        }
    } else {
        echo "<span style='color:red;'>Invalid email or password.</span>";
    }
} else{
    echo "Error: Email and password are required.";
}
?>