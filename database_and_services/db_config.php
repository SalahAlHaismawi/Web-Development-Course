<?php
function OpenConnection() {
    // Replace with the name of the database on ur local machine
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "app";

    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function CloseConnection($conn) {
    $conn->close();
}
?>
