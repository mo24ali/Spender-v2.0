document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("register");

    window.showLoginPopup = function() {
        loginForm.classList.toggle("hidden");
    }

    document.getElementById("registerFormPipe").addEventListener("click", () => {
        loginForm.classList.add("hidden");
        registerForm.classList.remove("hidden");
    });
});
