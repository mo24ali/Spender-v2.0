<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Dashboard</title>
</head>



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

        <div class="grid grid-cols-3 grid-rows-3 gap-4 p-4">

    <!-- TOTAL REVENUE -->
    <div id="TotalRevenue">
        <div class="bg-neutral-primary-soft w-full p-6 border border-default rounded-base shadow-xs">

            <div class="flex justify-between items-center mb-3">
                <h2 class="text-2xl font-semibold tracking-tight text-heading">My Balances</h2>
                <select name="revenueMonth"
                    class="rounded-xl px-2 py-1 bg-white dark:bg-gray-900 border">
                    <option disabled selected>Select month</option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </div>

            <p class="text-3xl font-bold mb-4 text-blue-600 dark:text-blue-400">
                $
                <?php
                require "config/connexion.php";
                $query = "select SUM(price) as total from income";
                $request = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($request);
                echo $row['total'];
                ?>
            </p>

            <div class="flex items-center gap-3 text-sm text-body">
                <p class="text-green-600 dark:text-green-400 font-medium">
                    <i class="fa-solid fa-money-bill-trend-up"></i> minichart
                </p>
                <p>compared with the last month</p>
            </div>
        </div>
    </div>


    <!-- EXPENSES -->
    <div id="Expenses">
        <div class="bg-neutral-primary-soft w-full p-6 border border-default rounded-base shadow-xs">

            <div class="flex justify-between items-center mb-3">
                <h2 class="text-2xl font-semibold tracking-tight text-heading">My Expenses</h2>
                <select name="expenseMonth"
                    class="rounded-xl px-2 py-1 bg-white dark:bg-gray-900 border">
                    <option disabled selected>Select month</option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </div>

            <p class="text-3xl font-bold mb-4 text-red-600 dark:text-red-400">
                $
                <?php
                require "config/connexion.php";
                $query = "select SUM(price) as total from expense";
                $request = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($request);
                echo $row['total'];
                ?>
            </p>

            <div class="flex items-center gap-3 text-sm text-body">
                <p class="text-red-500 dark:text-red-400 font-medium">
                    <i class="fa-solid fa-money-bill-trend-up"></i> minichart
                </p>
                <p>compared with the last month</p>
            </div>

        </div>
    </div>


    <!-- INCOME -->
    <div id="Income">
        <div class="bg-neutral-primary-soft w-full p-6 border border-default rounded-base shadow-xs">

            <div class="flex justify-between items-center mb-3">
                <h2 class="text-2xl font-semibold tracking-tight text-heading">My Incomes</h2>
                <select name="incomeMonth"
                    class="rounded-xl px-2 py-1 bg-white dark:bg-gray-900 border">
                    <option disabled selected>Select month</option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </div>

            <p class="text-3xl font-bold mb-4 text-green-600 dark:text-green-400">
                $
                <?php
                require "config/connexion.php";
                $query = "select SUM(price) as total from income";
                $request = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($request);
                echo $row['total'];
                ?>
            </p>

            <div class="flex items-center gap-3 text-sm text-body">
                <p class="text-green-500 dark:text-green-400 font-medium">
                    <i class="fa-solid fa-money-bill-trend-up"></i> minichart
                </p>
                <p>compared with the last month</p>
            </div>

        </div>
    </div>


    <!-- CHART -->
    <div class="col-span-2 bg-neutral-primary-soft border border-default rounded-base shadow-xs p-4 flex items-center justify-center">
        <canvas id="chart" class="w-full h-64"></canvas>
    </div>


    <!-- ACTIVITIES -->
    <div id="listOfActivities" class="bg-neutral-primary-soft border border-default rounded-base shadow-xs p-4 row-span-2">
        Activities
    </div>

    <!-- SAVINGS -->
    <div id="sevingsDiv" class="col-span-2 bg-neutral-primary-soft border border-default rounded-base shadow-xs p-4">
        <div class="text-xl font-semibold mb-3">Savings</div>

        <div id="savings" class="grid grid-cols-2 grid-rows-2 gap-3">
            <div class="p-4 bg-white dark:bg-gray-800 rounded-base border border-default shadow-sm">sav1</div>
            <div class="p-4 bg-white dark:bg-gray-800 rounded-base border border-default shadow-sm">sav2</div>
            <div class="p-4 bg-white dark:bg-gray-800 rounded-base border border-default shadow-sm">sav3</div>
            <div class="p-4 bg-white dark:bg-gray-800 rounded-base border border-default shadow-sm">sav4</div>
        </div>
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
    <script src="js/chart.js"></script>

</body>


</html>