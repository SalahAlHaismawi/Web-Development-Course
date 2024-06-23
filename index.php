<?php
include ('includes/header.php');
?>
<div class="container">


    <div class="container2">
        <img class="student-image" src="./assets/images/studentDrawing.jpg"/>
        <h1>Welcome to MMU Counseling Services</h1>
        <h2>Made for Students by Students</h2>

        <div class="button-container">
            <a class="scale-animation" href="./authentication/signup.php"><button>Sign Up</button></a>
            <p>or</p>
            <a class="scale-animation" href="authentication/signin.php"><button>Sign In</button></a>
        </div>
    </div>
</div>
<?php
include ('includes/footer.php');
?>

<style>
    body {
        background-image: url('https://gsehd.gwu.edu/sites/g/files/zaxdzs4166/files/2022-10/event-schoolcounseling.jpg');
        /* https://gsehd.gwu.edu/webinar-counselor-role */
        background-repeat: no-repeat;
        background-size: cover;
    }

    .container {
        min-width: 100%;
        backdrop-filter: blur(10px);
        background-color: rgba(255, 255, 255, 0.7);
    }

    .container2 {
        background-color: white;
        text-align: center;
        border-radius: 30px;
        padding: 30px;
        color: #333;
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .button-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 2rem;
        padding: 20px 20px 10px 20px;
        margin-top: 20px;
    }

    .button-container button {
        background-color: #0056b3;
        color: white;
        border: none;
        border-radius: 15px;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .button-container button:hover {
        background-color: #1e9113;

    }

    .button-container button:hover {
        background-color: #003f8a;
    }

    h1 {
        color: #0056b3;
    }
</style>