<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <title>Dashboard</title>
</head>

<?php

?>


<body class="bg-gray-50 dark:bg-gray-900 dark:text-white">

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

            <button onclick="logout()" class="hidden lg:block bg-blue-600 px-4 py-2 rounded-lg text-white hover:bg-blue-500 transition">
                Logout
            </button>
        </nav>
    </header>

    <!-- MAIN CONTENT -->
    <main class="max-w-6xl mx-auto mt-20 px-4">
        <div class="flex items-center justify-between mb-10">
            <button id="newPaymentsBtn" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition" onclick="showAddExpenseModal()">
                + New Payment
            </button>
        </div>
        <p class="text-gray-600 dark:text-gray-300 text-xl">No data available yet — start by adding new payments.</p>

        <div class="flex flex-row">
            <div id="chart1">

            </div>
            <div id="chart2">

            </div>
            <div id="chart3">

            </div>
        </div>

    </main>

    <!-- ADD EXPENSE MODAL -->
    <div id="addExpense" class="fixed inset-0 bg-black/40 backdrop-blur-md flex justify-center items-center z-50 hidden">
        <form id="addExpenseForm" action="form_handlers/expensesHandler.php" method="post" class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg w-96 space-y-4">
            <label for="expenseName" class="text-white">Expense title</label>
            <input type="text" id="expenseName" name="expense_title" class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white">
            <label for="expenseDescription" class="text-white"> Description : </label>
            <input type="text" id="expenseDescription" name="expense_description" class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white">
            <label for="expensePrice" class="text-white"> cost : </label>
            <input type="text" id="expensePrice" name="expense_price" class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white">
            <label for="expenseDate" class="text-white">Due to :</label>
            <input type="date" id="expenseDate" name="expense_date" class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white">
            <button type="submit" id="validateExpense" class="rounded bg-blue-500 hover:bg-blue-300 hover:text-white transform duration-300 py-2 px-1">Add expense</button>
        </form>
    </div>
    <script src="js/auth.js"></script>
    <script src="js/forms.js"></script>
    <script src="js/validators.js"></script>
    <script src="js/dashboard.js"></script>

</body>


</html>