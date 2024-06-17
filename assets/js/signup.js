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

