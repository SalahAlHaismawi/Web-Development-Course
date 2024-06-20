<?php

require_once('db_config.php');
$conn = OpenConnection();
if(isset($_POST['username'])){
    $username = trim(mysqli_escape_string($conn, $_POST['username']));
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        echo "<span style='color:red;'>Username is already in use.</span>";
    }else{
        echo "<span style='color:green;'>Username available.</span>";
    }
} else {
    header("Location: index.php");
    exit();
}
?>