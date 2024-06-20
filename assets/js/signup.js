//https://stackoverflow.com/questions/75988682/debounce-in-javascript
function init(){
    window.onload = () =>{
        checkEmail()
        checkUsername()
        handlePasswordInput()
    }
}

init()

function debounce(func, delay) {
    let debounceTimer;
    return function(...args) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => func.apply(this, args), delay);
    }
}

function checkUsername() {
    let username = document.getElementById('username').value.trim();
    if(username != ''){
        fetch('check_username.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'username=' + username
        })
        .then(response => response.text())
        .then(data => document.getElementById('username-result').innerHTML = data);
    } else {
        document.getElementById('username-result').innerHTML = "";
    }
}

function checkEmail() {
    let email = document.getElementById('email').value.trim();
    if(email != ''){
        fetch('check_email.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'email=' + email
        })
        .then(response => response.text())
        .then(data => document.getElementById('email-result').innerHTML = data);
    } else {
        document.getElementById('email-result').innerHTML = "";
    }
}

function handlePasswordInput() {
    let password = document.getElementById('password').value;
    let confirmPasswordField = document.getElementById('confirm_password');

    toggleConfirmationField(password, confirmPasswordField);
    checkPasswordConfirmation(password);
}

function toggleConfirmationField(password, confirmPasswordField) {
    if (password === '') {
        confirmPasswordField.style = "background-color: #D3D3D3;";
        confirmPasswordField.disabled = true;
    } else {
        confirmPasswordField.style = "background-color: white;";
        confirmPasswordField.disabled = false;
    }
}

function checkPasswordConfirmation(password) {
    let confirmPassword = document.getElementById('confirm_password').value;

    if (password === '' || confirmPassword === '') {
        document.getElementById('password-confirmation-result').innerHTML = "";
        return;
    }

    if (password !== confirmPassword) {
        document.getElementById('password-confirmation-result').style = "color:red;";
        document.getElementById('password-confirmation-result').innerHTML = "Passwords do not match";
    } else {
        document.getElementById('password-confirmation-result').style = "color:green;";
        document.getElementById('password-confirmation-result').innerHTML = "Passwords match";
    }
}

function validateForm() {
    let email = document.getElementById('email').value.trim();
    let password = document.getElementById('password').value;
    let confirmPassword = document.getElementById('confirm_password').value;
    let role = document.getElementById('role').value;

    if (password !== confirmPassword) {
        alert('Passwords do not match');
        return false;
    }

    let emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailRegex.test(email)) {
        alert('Please enter a valid email address');
        return false;
    }

    let emailResult = document.getElementById('email-result').innerHTML;
    if (emailResult.includes('Email is already in use')) {
        alert('Email is already in use');
        return false;
    }

    let usernameResult = document.getElementById('username-result').innerHTML;
    if (usernameResult.includes('Username is already in use')) {
        alert('Username is already in use');
        return false;
    }

    if (role === '') {
        alert('Please select a role');
        return false;
    }

    return true;
}
