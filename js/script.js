function redirectToHomePage() {
    // Get the email and password from the form
    const email = document.getElementById('email1').value;
    const password = document.getElementById('psw1').value;

    // You can add validation here if needed

    // Assuming successful login, redirect to homepage.html
    window.location.href = './homepage.html';

    // Prevent the form from actually submitting to the server
    return false;
}
