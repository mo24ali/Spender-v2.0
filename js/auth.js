document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("register");

    window.showLoginPopup = function () {
        loginForm.classList.toggle("hidden");
    }

    document.getElementById("registerFormPipe").addEventListener("click", () => {
        loginForm.classList.add("hidden");
        registerForm.classList.remove("hidden");
    });
});


const loginForm = document.getElementById('loginFormEl');
const registerForm = document.getElementById('registerFormEl');

loginForm.addEventListener('submit', (e) => {
    const email = document.getElementById('logMail').value.trim();
    const password = document.getElementById('logPass').value.trim();

    if (!email || !password) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please fill in all login fields!',
        });
    }
});

registerForm.addEventListener('submit', (e) => {
    const firstname = registerForm.firstname.value.trim();
    const lastname = registerForm.lastname.value.trim();
    const email = registerForm.emailRegister.value.trim();
    const password = registerForm.passwordRegister.value.trim();

    if (!firstname || !lastname || !email || !password) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please fill in all register fields!',
        });
    } else if (!/^\S+@\S+\.\S+$/.test(email)) {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Invalid Email',
            text: 'Please enter a valid email address!',
        });
    } else if (password.length < 6) {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Weak Password',
            text: 'Password must be at least 6 characters!',
        });
    }
});

document.getElementById('registerFormPipe').addEventListener('click', () => {
    document.getElementById('loginForm').classList.add('hidden');
    document.getElementById('register').classList.remove('hidden');
});
