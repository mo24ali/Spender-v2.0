<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <title>Incomes</title>
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

            <button id="newPaymentsBtn" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition" onclick="showAddIncome()">
                + New Income
            </button>
            <p class="text-gray-600 dark:text-gray-300 text-xl">Liste des Incomes:</p>
        </div>


        <table border="2" cellspacing="2" cellpadding="8">
            <thead>
                <tr>
                    <th>Income ID</th>
                    <th>Income Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php
                require "config/connexion.php";

                $request = "SELECT * FROM income";
                $query = mysqli_query($conn, $request);

                while ($row = mysqli_fetch_assoc($query)) {
                    $id = $row['incomeId'];
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['incomeId']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['incomeTitle']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['price']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['getIncomeDate']) . "</td>";

                    echo "<td>
                        <button><a href='edit_handler/updateIncome.php?id={$id}'>Edit</a></button>
                        <button><a href='delete_handlers/deleteIncome.php?id={$id}'>Delete</a></button>
                      </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

    </main>
    <!-- ADD INCOME MODAL -->
    <div id="addIncome" class="fixed inset-0 bg-black/40 backdrop-blur-md flex justify-center items-center z-50 hidden">
        <form id="addIncomeForm" action="form_handlers/incomeHandler.php" method="post" class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg w-96 space-y-4">
            <label for="incomeName" class="text-white">Income title</label>
            <input type="text" id="incomeName" name="income_title" class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white">
            <label for="incomeDescription" class="text-white"> Description : </label>
            <input type="text" id="incomeDescription" name="income_description" class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white">
            <label for="incomePrice" class="text-white"> Salary : </label>
            <input type="text" id="incomePrice" name="income_price" class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white">
            <label for="incomeDate" class="text-white">Getting income date :</label>
            <input type="date" id="incomeDate" name="income_date" class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white">
            <button type="submit" id="validateIncome" class="rounded bg-blue-500 hover:bg-blue-300 hover:text-white transform duration-300 py-2 px-1">Add income</button>
        </form>
    </div>

    <script src="js/auth.js"></script>
    <script src="js/forms.js"></script>
    <script src="js/validators.js"></script>
</body>


</html>