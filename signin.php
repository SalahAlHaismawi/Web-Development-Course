<?php 
require_once('includes/header.php'); 
require_once('signin_process.php'); 
$message = process_signin();
?>
<h2>Sign In</h2>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>

    <p id="message" style="color: red;">
    <?php
    if (isset($message)) {
        echo $message;
    }
    ?>
    </p>    
    <input type="submit" value="Sign In">
</form>
<script>

</script>
<?php require_once('includes/footer.php'); ?>