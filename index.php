

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Spender</title>
    <style>
        .carousel img {
            opacity: 0;
            transform-origin: center center;
            will-change: transform, opacity;
        }

        .desktop {
            transform: translateY(30px) scale(0.95);
        }

        .mobile {
            transform: translateX(-30px) scale(0.95);
        }

        .cards {
            transform: translateX(30px) scale(0.95);
        }

        #wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #content {
            width: 100%;
            max-width: 1200px;
        }
    </style>
    <script src="js/landing.js" defer></script>
    <script src="js/auth.js" defer></script>
</head>

<body class="bg-gray-50 dark:bg-gray-900">

    <header class="sticky top-0 z-50 bg-white dark:bg-gray-800 shadow-sm opacity-0 translate-y-[-50px]" id="navbar">
        <nav class="max-w-7xl mx-auto flex items-center justify-between p-4">
            <a href="index.php" class="text-2xl font-bold text-blue-600 dark:text-white">Spender</a>

            <div class="hidden lg:flex space-x-10">
                <a href="app/Views/dashboard/dashboard.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 transition">Dashboard</a>
                <a href="app/Views/transactions/transactions.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 transition">Transactions</a>
                <a href="app/Views/cards/mycard.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 transition">My Cards</a>
                <a href="app/Views/expenses/expenses.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 transition">Expenses</a>
                <a href="app/Views/incomes/incomes.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 transition">Incomes</a>

            </div>

            <button id="loginBtn" class="hidden lg:inline-block bg-blue-600 px-4 py-2 rounded-lg text-white hover:bg-blue-500 transition lg:ml-4">
                Login / Register
            </button>

            <button id="burgerBtn" class="lg:hidden ml-2 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600">
                <svg class="w-6 h-6 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <div id="mobileMenu" class="hidden absolute top-full left-0 w-full bg-white dark:bg-gray-800 shadow-md flex flex-col lg:hidden">
                <a href="dashboard.php" class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white">Dashboard</a>
                <a href="transactions.php" class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white">Transactions</a>
                <a href="expenses.php" class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white">Expenses</a>
                <a href="incomes.php" class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white">Incomes</a>
                <a href="support.php" class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white">Support</a>

                <!-- Login button inside mobile menu -->
                <button id="mobileLoginBtn" class="mx-4 my-3 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition">
                    Login / Register
                </button>
            </div>
        </nav>
    </header>

    <!-- HERO SECTION -->
    <section id="hero"
        class="max-w-7xl mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

        <!-- LEFT CONTENT -->
        <div class="flex flex-col space-y-6">
            <h1 class="text-5xl font-extrabold text-gray-800 dark:text-white leading-tight">
                Manage Your Money <span class="text-indigo-500">Smarter with SPENDER</span> 💸
            </h1>

            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-lg">
                Track your income and expenses effortlessly with beautiful charts and a minimal dashboard designed for clarity.
            </p>

            <div class="flex gap-4">
                <a href="#"
                    class="px-6 py-3 bg-indigo-600 text-white rounded-xl shadow-md hover:bg-indigo-700 transition">
                    Get Started
                </a>

                <a href="#"
                    class="px-6 py-3 border border-gray-300 text-gray-700 dark:text-white rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    View Demo
                </a>
            </div>
        </div>

        <div id="wrapper" class="overflow-hidden w-[750] h-[500px] relative">
            <div id="content" class="space-y-20 p-10">
                <div class="carousel w-[750] h-[500px] relative flex justify-center items-center">
                    <img src="assets/desktop.png" alt="Desktop" class="desktop w-1/2 object-cover rounded-xl shadow-lg">
                    <img src="assets/mobile.png" alt="Mobile" class="mobile w-1/6 rounded-xl shadow-lg">
                    <img src="assets/credit_cards.png" alt="Cards" class="cards w-1/4 rounded-xl shadow-lg">
                </div>
            </div>
        </div>

    </section>
    <div id="loginForm" class="fixed inset-0 bg-black/40 backdrop-blur-sm flex justify-center items-center z-50 hidden">
        <form id="loginFormEl" class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg w-80 space-y-4"
            action="auth/loginFormHandler.php" method="POST">
            <h2 class="text-xl font-bold text-center dark:text-white">Login</h2>
            <input id="logMail" type="text" name="emailLog" placeholder="Email"
                class="w-full p-2 border rounded-lg dark:bg-gray-900 dark:text-white">
            <input id="logPass" type="password" name="passwordLog" placeholder="Password"
                class="w-full p-2 border rounded-lg dark:bg-gray-900 dark:text-white">
            <input type="submit"
                class="w-full bg-blue-600 hover:bg-blue-500 text-white py-2 rounded-lg transition"
                value="Connexion" name="connexion">
            <a id="registerFormPipe" href="auth/registerHelper.php?register=true" class="text-blue-600 hover:underline text-center cursor-pointer block">Create an account →</a>
        </form>
    </div>

    <!-- REGISTER MODAL -->
    <div id="register" class="fixed inset-0 bg-black/40 backdrop-blur-md flex justify-center items-center z-50 
    
        <?php
        if (!isset($_GET['register'])) {
            echo "hidden";
        } else {
            echo " ";
        }

        ?>
    ">
        <form id="registerFormEl" class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg w-96 space-y-4"
            action="auth/registerFormHandler.php" method="POST">
            <h2 class="text-xl font-bold text-center dark:text-white">Register</h2>
            <input type="text" name="firstname" placeholder="Firstname"
                class="w-full p-2 border rounded-lg dark:bg-gray-900 dark:text-white">
            <input type="text" name="lastname" placeholder="Lastname"
                class="w-full p-2 border rounded-lg dark:bg-gray-900 dark:text-white">
            <input type="text" name="emailRegister" placeholder="Email"
                class="w-full p-2 border rounded-lg dark:bg-gray-900 dark:text-white">
            <input type="password" name="passwordRegister" placeholder="Password"
                class="w-full p-2 border rounded-lg dark:bg-gray-900 dark:text-white">
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-500 text-white py-2 rounded-lg transition">Register</button>
        </form>
    </div>
    <div id="otpPopup" class="fixed inset-0 bg-black/40 backdrop-blur-md flex justify-center items-center z-50 
        <?php
        if (!isset($_GET['verify_otp'])) {
            echo 'hidden';
        } else {
            echo ' ';
        }
        ?>
    ">
        <form id="otpForm" class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg w-96 space-y-4"
            action="auth/verify_otp.php" method="POST">
            <h2 class="text-xl font-bold text-center dark:text-white">Verify OTP sent by mail</h2>
            <input type="text" name="otp" placeholder="otp"
                class="w-full p-2 border rounded-lg dark:bg-gray-900 dark:text-white">

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-500 text-white py-2 rounded-lg transition">Register</button>
        </form>
    </div>



</body>

</html>