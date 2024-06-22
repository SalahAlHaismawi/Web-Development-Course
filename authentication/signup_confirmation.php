<?php
session_start(); 

if(!isset($_SESSION['message'])){
    header('Location: index.php');
}

$message = $_SESSION['message']; 
$redirectUrl = $_SESSION['redirectUrl'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Confirmation</title>
    <style>
        body {
            display: flex;
            flex-direction: column; 
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-size: 2em;
        }
    </style>
</head>
<body>
    <p id="confirmationMessage"><?php echo $message; ?></p>
    <p id="redirectMessage"></p>
</body>

<script>
        var countdown = 5;
        var redirectUrl = '<?php echo $redirectUrl; ?>'; // Use the redirect URL from the PHP variable

        var intervalId = setInterval(function() {
            countdown--;
            document.getElementById('redirectMessage').innerHTML = 'Redirecting in ' + countdown + ' seconds...';

            if (countdown === 0) {
                clearInterval(intervalId);
                window.location.href = redirectUrl;
            }
        }, 1000);
</script>

</html>
<?php session_destroy(); ?>
