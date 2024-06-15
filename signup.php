<?php
include('includes/header.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
    <h2>Sign Up</h2>
    <form action="signup_process.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Sign Up">
    </form>
</body>
</html>
<?php
include('includes/footer.php');
?>
