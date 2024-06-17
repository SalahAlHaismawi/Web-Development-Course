<?php
include ('includes/header.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <h2>Sign Up</h2>
    <form action="add_user.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" maxlength="20" onblur="checkUsername()" required>
        <span id="username-result"></span><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" oninput="handlePasswordInput()" required><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" oninput="handlePasswordInput()" disabled
            required>
        <span id="password-confirmation-result"></span><br>

        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="">Please choose one</option>
            <option value="student">Student</option>
            <option value="counsellor">Counsellor</option>
        </select><br><br>

        <input type="submit" value="Sign Up">
    </form>
</body>
<script src="assets/js/signup.js"></script>

</html>
<?php
include ('includes/footer.php');
?>