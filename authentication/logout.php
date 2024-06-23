<?php
session_start();

function logout() {
    // Unset all of the session variables.
    $_SESSION = array();

    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Destroy the session.
    session_destroy();

    // Delete the user cookie if it exists.
    if (isset($_COOKIE['user'])) {
        setcookie('user', '', time() - 42000, "/");
    }

    // Clear browser cache
    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
    header("Pragma: no-cache"); // HTTP 1.0.
    header("Expires: 0"); // Proxies.

    // Redirect to the login page or home page
    header("Location: ../index.php");
    exit();
}

// Call the logout function
logout();
?>
