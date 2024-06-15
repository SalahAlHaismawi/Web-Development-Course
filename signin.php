<?php
include('includes/header.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sign In</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
    <h2>Sign In</h2>
    <form action="signin_process.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Sign In">
    </form>
</body>
</html>
<?php
include('includes/footer.php');
?>
