<!DOCTYPE html>
<html>

<head>
    <title>MMU Counseling Services</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body>
    <header>
        <div class="nav-container">
        <a href="index.php"><h1 style="color: white; margin: auto; text-decoration: none;">MMU Counseling Services</h1></a>
            <nav>
                <ul>
                    <li><a class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>" href="index.php">Home</a></li>
                    <li>|</li>
                    <li><a class="<?= basename($_SERVER['PHP_SELF']) == 'aboutus.php' ? 'active' : '' ?>" href="aboutus.php">About Us</a></li>
                    <li>|</li>
                    <li><a class="<?= basename($_SERVER['PHP_SELF']) == 'faq.php' ? 'active' : '' ?>" href="faq.php">FAQ</a></li>
                    <li>|</li>
                    <li><a class="<?= basename($_SERVER['PHP_SELF']) == 'signin.php' ? 'active' : '' ?>" href="signin.php">Sign In</a></li>
                    <li>|</li>
                    <li><a class="<?= basename($_SERVER['PHP_SELF']) == 'signup.php' ? 'active' : '' ?>" href="signup.php">Sign Up</a></li>
                </ul>
            </nav>
        </div>
    </header>