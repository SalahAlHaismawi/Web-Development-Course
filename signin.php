<?php require_once('includes/header.php'); ?>
<h2>Sign In</h2>
<form id="signinForm">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>

    <p id="message"></p>    
    <input type="submit" value="Sign In">
</form>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('signinForm');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'signin_process.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (this.status == 200) {
                document.getElementById('message').innerHTML = this.response;
            }
        };
        xhr.send(new URLSearchParams(new FormData(form)).toString());
    });
});
</script>
<?php require_once('includes/footer.php'); ?>