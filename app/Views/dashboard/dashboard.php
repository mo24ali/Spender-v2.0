<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Dashboard</title>
    <script src="../../../js/forms.js"></script>
    <script src="../../../js/chart.js"></script>
</head>

<?php
session_start();
require_once __DIR__ .  "/../../Core/Database.php";


$db = Database::getInstance();
$conn = $db->getConnection();
?>

<body class="bg-gradient-to-br from-gray-950 via-gray-900 to-gray-800 text-white">

    <!-- NAVBAR -->
        <?php require "../partials/nav.php"; ?>
    <!-- MAIN CONTENT -->
    <main class="max-w-6xl mx-auto mt-20 px-4">
        <div class="flex items-center justify-between mb-10">
            <h1 class="font-sans text-2xl sm:text-3xl md:text-4xl font-bold tracking-tight text-gray-800 dark:text-white">

                Welcome back 👋
                <span class="block text-lg font-bold text-gray-600 mt-1 dark:text-white">
                    <?php

                    $userId = $_SESSION['user_id'];
                    $request = "SELECT 
                                    firstname,
                                    lastname 
                                FROM users 
                                WHERE userId = $userId";
                    $query = $conn->query($request);
                    $rows = $query->fetch(PDO::FETCH_ASSOC);

                    echo $rows['firstname'] . " " . $rows['lastname'];
                    ?>
                </span>
            </h1>

            <div class="flex flex-col lg:flex-row justify-center items-center gap-2">
                <button
                    id="newPaymentsBtn"
                    class="bg-blue-600 text-white px-4 sm:px-5 py-2.5 rounded-xl font-semibold hover:bg-blue-500 transition duration-200 shadow-sm"
                    onclick="showAddExpenseModal()">
                    + New Expense
                </button>
                <form method="get">
                    <select name="revenueMonth" onchange="this.form.submit()"
                        class="text-white px-4 sm:px-5 py-2.5 rounded-xl font-semibold bg-white dark:bg-gray-900 border">
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
                </form>
                <button id="exportCsv"
                    class="text-white px-4 sm:px-5 py-2.5 rounded-xl font-semibold bg-white dark:bg-gray-900 border hover:bg-white hover:text-black transform duration-300">
                    <a href="export/exportcsv.php">
                        Export csv
                        <i class="fa fa-download"></i>
                    </a>
                </button>
            </div>
        </div>


        <div class="grid gap-4 p-4
            grid-cols-1
            sm:grid-cols-2
            lg:grid-cols-3
            auto-rows-min">


            <!-- TOTAL REVENUE -->
            <div id="TotalRevenue">
                <div class="bg-neutral-primary-soft w-full p-6 border border-default rounded-xl shadow-xs">

                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-2xl font-semibold tracking-tight text-heading">My Balances</h2>

                    </div>

                    <p class="text-3xl font-bold mb-4 text-blue-600 dark:text-blue-400">
                        $
                        <?php
                        // require "config/connexion.php";
                        $month = isset($_GET['revenueMonth']) ? $_GET['revenueMonth'] : null;
                        $monthCondition = "";
                        if ($month) {
                            $monthCondition = "AND MONTH(i.getIncomeDate) = '$month' AND MONTH(e.dueDate) = '$month'";
                        }
                        $userId = $_SESSION['user_id'];
                        $query = "select SUM(i.price)-SUM(e.price) as total from income i ,expense e where i.user_id =$userId AND e.user_id=$userId $monthCondition";
                        $request = $conn->query($query);
                        $row = $request->fetch(PDO::FETCH_ASSOC);
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
                <div class="bg-neutral-primary-soft w-full p-6 border border-default rounded-xl shadow-xs">

                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-2xl font-semibold tracking-tight text-heading">My Expenses</h2>


                    </div>

                    <p class="text-3xl font-bold mb-4 text-red-600 dark:text-red-400">
                        $
                        <?php
                        // require "config/connexion.php";
                        $userId = $_SESSION['user_id'];
                        $month = isset($_GET['revenueMonth']) ? $_GET['revenueMonth'] : null;

                        $monthCondition = "";
                        if ($month) {
                            $monthCondition = "AND MONTH(dueDate) = '$month'";
                        }
                        $query = "select IFNULL(SUM(price),0) as total from expense where user_id=$userId $monthCondition";
                        $request = $conn->query($query);
                        $row = $request->fetch(PDO::FETCH_ASSOC);
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
                <div class="bg-neutral-primary-soft w-full p-6 border border-default rounded-xl shadow-xs">

                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-2xl font-semibold tracking-tight text-heading">My Incomes</h2>

                    </div>

                    <p class="text-3xl font-bold mb-4 text-green-600 dark:text-green-400">
                        $
                        <?php
                        // require "config/connexion.php";
                        $userId = $_SESSION['user_id'];
                        $month = isset($_GET['revenueMonth']) ? $_GET['revenueMonth'] : null;

                        $monthCondition = "";
                        if ($month) {
                            $monthCondition = "AND MONTH(getIncomeDate) = '$month'";
                        }
                        $query = "select IFNULL(SUM(price),0) as total from income where user_id=$userId $monthCondition";
                        $request = $conn->query($query);
                        $row = $request->fetch(PDO::FETCH_ASSOC);
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
            <div class="bg-neutral-primary-soft border border-default rounded-xl shadow-xs p-4 flex items-center justify-center sm:col-span-2 lg:col-span-2">
                <canvas id="chart" class="w-full h-64"></canvas>
            </div>

            <!-- ACTIVITIES -->
            <div id="listOfActivities" class="bg-neutral-primary-soft border border-default rounded-xl shadow-xs p-4 sm:row-span-1 lg:row-span-2">
                Activities
            </div>

            <!-- SAVINGS -->
            <div id="sevingsDiv" class="bg-neutral-primary-soft border border-default rounded-xl shadow-xs p-4 sm:col-span-2 lg:col-span-2">
                <div class="text-xl font-semibold mb-3">Savings</div>
                <div id="savings" class="grid gap-3 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="p-4 bg-white dark:bg-gray-800 rounded-xl border border-default shadow-sm">sav1</div>
                    <div class="p-4 bg-white dark:bg-gray-800 rounded-xl border border-default shadow-sm">sav2</div>
                    <div class="p-4 bg-white dark:bg-gray-800 rounded-xl border border-default shadow-sm">sav3</div>
                    <div class="p-4 bg-white dark:bg-gray-800 rounded-xl border border-default shadow-sm">sav4</div>
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
            <button type="submit" id="validateExpense" class="bg-blue-600 text-white px-4 sm:px-5 py-2.5 rounded-xl font-semibold hover:bg-blue-500 transition duration-200 shadow-sm">Add expense</button>
        </form>
    </div>


    <?php
    // require "config/connexion.php";

    $requestExpense = "SELECT price, dueDate, Month(dueDate) as month FROM expense";
    $queryExpense = $conn->prepare($requestExpense);
    $requestIncome = "SELECT price, getIncomeDate , Month(getIncomeDate) as month FROM income";
    $queryincome = $conn->prepare($requestIncome);
    $dataExpense = [];
    $dataIncome = [];

    while ($row = $queryExpense->fetch(PDO::FETCH_ASSOC)) {
        $dataExpense[] = [
            "price" => (float)$row["price"],
            "date"  => $row["dueDate"],
            "month" => $row["month"]
        ];
    }


    while ($row = $queryincome->fetch(PDO::FETCH_ASSOC)) {
        $dataIncome[] = [
            "price" => (float)$row["price"],
            "date" => $row["getIncomeDate"],
            "month" => $row["month"]
        ];
    }
    ?>
    <script>
        let exp = <?php echo json_encode($dataExpense) ?>;
        let inc = <?php echo json_encode($dataIncome) ?>;
    </script>
    <script>
      // overall navbar animation 

        // Navbar slide-in
            gsap.to("#navbar", {
                duration: 1,
                y: 0,
                opacity: 1,
                ease: "power2.out"
            });
        let burgerBtn = document.getElementById('burgerBtn');
        let mobileMenu = document.getElementById('mobileMenu');

        burgerBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            if (!mobileMenu.classList.contains('hidden')) {
                gsap.fromTo(mobileMenu, {
                    y: -20,
                    opacity: 0
                }, {
                    y: 0,
                    opacity: 1,
                    duration: 0.3,
                    ease: "power2.out"
                });
            }
        });

        document.addEventListener('click', (e) => {
            if (!mobileMenu.contains(e.target) && !burgerBtn.contains(e.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    </script>

</body>


</html>