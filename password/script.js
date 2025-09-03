function validatePassword() {
    const passwordField = document.getElementById('password');
    const message = document.getElementById('message');
    const password = passwordField.value;

    if (password === 'password') {
        passwordField.classList.remove('error');
        passwordField.classList.add('success');
        message.textContent = 'Shabaash mere sher!';
        message.classList.remove('error');
        message.classList.add('success');
    } else {
        passwordField.classList.remove('success');
        passwordField.classList.add('error');
        message.textContent = 'ex ka number toh yaad hoga, par password yaad nahi hai';
        message.classList.remove('success');
        message.classList.add('error');
    }
}
