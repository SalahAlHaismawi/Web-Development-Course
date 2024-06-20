<?php
include ('includes/header.php');
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <h2>Sign Up</h2>
    <form action="add_user.php" method="post" onsubmit="return validateForm()">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" oninput="debounce(checkEmail, 1000)(event)" required>
        <span id="email-result"></span><br><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" maxlength="20" oninput="debounce(checkUsername, 1000)(event)"
            required>
        <span id="username-result"></span><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" autocomplete="off" oninput="debounce(handlePasswordInput, 100)(event)"
            required><br><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" autocomplete="off"
            oninput="debounce(handlePasswordInput, 100)(event)" disabled required>
        <span id="password-confirmation-result"></span><br><br>

        <label for="role">Role:</label>
        <select id="role" name="role" required autocomplete="off">
            <option value="" disabled selected style="display:none;">Please choose one</option>
            <option value="student">Student</option>
            <option value="counsellor">Counsellor</option>
        </select><br><br><br>

        <input type="submit" value="Sign Up">
    </form>
</body>
<script src="assets/js/signup.js"></script>

</html>
<?php
include ('includes/footer.php');
?>