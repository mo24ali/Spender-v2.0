<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<title>Spender</title>
</head>
<body class="bg-gray-50 dark:bg-gray-900">

<!-- NAVBAR -->
<header class="sticky top-0 z-50 bg-white dark:bg-gray-800 shadow-sm">
    <nav class="max-w-7xl mx-auto flex items-center justify-between p-4">
        <a href="#" class="text-xl font-bold text-blue-600 dark:text-white">Spender</a>
        <div class="hidden lg:flex space-x-10">
                <a href="dashboard.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600">Dashboard</a>
                <a href="transactions.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600">Transactions</a>
                <a href="expenses.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600">Expenses</a>
                <a href="incomes.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600">Incomes</a>
                <a href="support.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600">Support</a>
            </div>
        <button onclick="showLoginPopup()" class="bg-blue-600 px-4 py-2 rounded-lg text-white hover:bg-blue-500 transition">
            Login / Register
        </button>
    </nav>
</header>

<!-- LOGIN MODAL -->
<div id="loginForm" class="fixed inset-0 bg-black/40 backdrop-blur-sm flex justify-center items-center z-50 hidden">
    <form class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg w-80 space-y-4"
          action="form_handlers/loginFormHandler.php" method="POST">
        <h2 class="text-xl font-bold text-center dark:text-white">Login</h2>
        <input id="logMail" type="text" name="emailLog" placeholder="Email" class="w-full p-2 border rounded-lg dark:bg-gray-900 dark:text-white">
        <input id="logPass" type="password" name="passwordLog" placeholder="Password" class="w-full p-2 border rounded-lg dark:bg-gray-900 dark:text-white">
        <input type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white py-2 rounded-lg transition" value="Connexion" name="connexion">
        <a id="registerFormPipe" class="text-blue-600 hover:underline text-center cursor-pointer block">Create an account →</a>
    </form>
</div>

<!-- REGISTER MODAL -->
<div id="register" class="fixed inset-0 bg-black/40 backdrop-blur-md flex justify-center items-center z-50 hidden">
    <form class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg w-96 space-y-4"
          action="form_handlers/registerFormHandler.php" method="POST">
        <h2 class="text-xl font-bold text-center dark:text-white">Register</h2>
        <input type="text" name="firstname" placeholder="Firstname" class="w-full p-2 border rounded-lg dark:bg-gray-900 dark:text-white">
        <input type="text" name="lastname" placeholder="Lastname" class="w-full p-2 border rounded-lg dark:bg-gray-900 dark:text-white">
        <input type="text" name="emailRegister" placeholder="Email" class="w-full p-2 border rounded-lg dark:bg-gray-900 dark:text-white">
        <input type="password" name="passwordRegister" placeholder="Password" class="w-full p-2 border rounded-lg dark:bg-gray-900 dark:text-white">
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white py-2 rounded-lg transition">Register</button>
    </form>
</div>

<script src="js/auth.js" defer></script>
</body>
</html>
