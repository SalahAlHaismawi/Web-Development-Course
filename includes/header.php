<!DOCTYPE html>
<html>

<head>
    <title>MMU Counseling Services</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/Web-Development-Course/assets/css/style.css">
</head>

<body>
    <header>
         <h1 style="color: white; margin: auto; text-decoration: none;">MMU Counseling Services</h1>
<a href="https://www.mmu.edu.my/" target="_blank">
        <img class="mmu-logo" src="./assets/images/Multimedia_University_Logo.jpg" alt="MMU Logo"/>
    </a>        <div class="nav-container">
            <a href="/Web-Development-Course/index.php">
                <div>

                </div>

            </a>
            <nav>
                <ul>
                    <li><a class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>"
                            href="/Web-Development-Course/index.php">Home</a></li>
                    <li>|</li>
                    <li><a class="<?= basename($_SERVER['PHP_SELF']) == 'aboutus.php' ? 'active' : '' ?>"
                            href="/Web-Development-Course/aboutus.php">About Us</a></li>
                    <li>|</li>
                    <li><a class="<?= basename($_SERVER['PHP_SELF']) == 'faq.php' ? 'active' : '' ?>"
                            href="/Web-Development-Course/faq_management/faq.php">FAQ</a></li>
                    <li>|</li>
                    <li><a class="<?= basename($_SERVER['PHP_SELF']) == 'contacts.php' ? 'active' : '' ?>"
                            href="/Web-Development-Course/contacts.php">Contacts</a></li>
                    <li>|</li>
                    <li><a class="<?= basename($_SERVER['PHP_SELF']) == 'signin.php' ? 'active' : '' ?>"
                            href="/Web-Development-Course/authentication/signin.php">Sign In</a></li>
                    <li>|</li>
                    <li><a class="<?= basename($_SERVER['PHP_SELF']) == 'signup.php' ? 'active' : '' ?>"
                            href="/Web-Development-Course/authentication/signup.php">Sign Up</a></li>
                </ul>
            </nav>
        </div>
    </header>
</body>
</html>
