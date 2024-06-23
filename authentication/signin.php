<?php
require_once("../database_and_services/redirection_cookies.php");
require_once('../includes/header.php');
require_once('signin_process.php');
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = process_signin();
}
?>
<div class="container">
    <h2>Sign In</h2>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="auth-picture-container">
            <img class="student-image" src="../assets/images/studentDrawing.jpg"/>

        </div>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="rememberme">Stay logged in?</label>
        <input type="checkbox" name="rememberme" id="rememberme">

        <p id="message" style="color: red;">
            <?php
            if (isset($message)) {
                echo $message;
            }
            ?>
        </p>
        <input type="submit" value="Sign In">
    </form>
</div>
<script>

</script>
<?php require_once('../includes/footer.php'); ?>
