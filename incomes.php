<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>

    <script src="js/auth.js"></script>
    <script src="js/forms.js"></script>
    <script src="js/validators.js"></script>
    <title>Incomes</title>
</head>



<body class="bg-gray-50 dark:bg-gray-900 dark:text-white">

    <!-- NAVBAR -->
    <header class="sticky top-0 z-50 bg-white dark:bg-gray-800 shadow-sm opacity-0 translate-y-[-50px]" id="navbar">
        <nav class="max-w-7xl mx-auto flex items-center justify-between p-4">
            <a href="index.php" class="text-2xl font-bold text-blue-600 dark:text-white">Spender</a>
            <div class="hidden lg:flex space-x-10">
                <a href="dashboard.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 transition">Dashboard</a>
                <a href="transactions.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 transition">Transactions</a>
                <a href="expenses.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 transition">Expenses</a>
                <a href="incomes.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 transition">Incomes</a>
                <a href="support.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 transition">Support</a>
            </div>
            <a href="auth/logout.php">
                <button id="" class="bg-blue-600 px-4 py-2 rounded-lg text-white hover:bg-blue-500 transition">
                    Logout
                </button>
            </a>
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


        <table class="w-full text-sm text-left rtl:text-right text-body border border-default rounded-lg overflow-hidden">
            <thead class="bg-neutral-secondary-soft border-b border-default">
                <tr>
                    <th class="px-6 py-3 font-medium">Income ID</th>
                    <th class="px-6 py-3 font-medium">Income Title</th>
                    <th class="px-6 py-3 font-medium">Description</th>
                    <th class="px-6 py-3 font-medium">Price</th>
                    <th class="px-6 py-3 font-medium">Due Date</th>
                    <th class="px-6 py-3 font-medium">Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php
                require "config/connexion.php";
                session_start();
                $userId = $_SESSION['user_id'];
                $request = "SELECT * FROM income where user_id=$userId";
                $query = mysqli_query($conn, $request);

                while ($row = mysqli_fetch_assoc($query)) {
                    $id = $row['incomeId'];

                    echo "<tr class='odd:bg-neutral-primary-soft even:bg-neutral-secondary-soft border-b border-default hover:bg-neutral-secondary transition'>";

                    echo "<td class='px-6 py-3'>" . htmlspecialchars($row['incomeId']) . "</td>";
                    echo "<td class='px-6 py-3'>" . htmlspecialchars($row['incomeTitle']) . "</td>";
                    echo "<td class='px-6 py-3'>" . htmlspecialchars($row['description']) . "</td>";
                    echo "<td class='px-6 py-3'>$" . htmlspecialchars($row['price']) . "</td>";
                    echo "<td class='px-6 py-3'>" . htmlspecialchars($row['getIncomeDate']) . "</td>";

                    echo "
                <td class='px-6 py-3 flex gap-2'>
                    <a href='update_handlers/updateIncome.php?id={$id}' 
                       class='px-3 py-1 rounded-md bg-blue-500 text-white hover:bg-blue-600 transition text-xs'>
                        Edit
                    </a>
                    <a href='delete_handlers/deleteIncome.php?id={$id}' 
                       class='px-3 py-1 rounded-md bg-red-500 text-white hover:bg-red-600 transition text-xs'>
                        Delete
                    </a>
                </td>
            ";

                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>


    </main>
    <!-- ADD INCOME MODAL -->
    <div id="addIncome" class="fixed inset-0 bg-black/40 backdrop-blur-md flex justify-center items-center z-50 <?php echo isset($_GET['id']) ? '' : 'hidden' ?>">
        <?php
        require "config/connexion.php";

        $income = null;
        $modalId = null;

        if (isset($_GET['id'])) {
            $modalId = $_GET['id'];
            $query = "SELECT * FROM income WHERE incomeId = $modalId";
            $request = mysqli_query($conn, $query);
            $income = mysqli_fetch_assoc($request);
        }
        ?>
        <form id="addIncomeForm" action="form_handlers/incomeHandler.php<?php echo "?id=" . $modalId ?>" method="post" class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg w-96 space-y-4">

            <label for="incomeName" class="text-white">Income title</label>
            <input type="text" id="incomeName" name="income_title" class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white" value="<?php echo $income['incomeTitle'] ?? ''; ?>">
            <label for="incomeDescription" class="text-white"> Description : </label>
            <input type="text" id="incomeDescription" name="income_description" class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white" value="<?php echo $income['decription'] ?? ''; ?>">
            <label for="incomePrice" class="text-white"> Salary : </label>
            <input type="text" id="incomePrice" name="income_price" class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white" value="<?php echo $income['price'] ?? ''; ?>">
            <label for="incomeDate" class="text-white">Getting income date :</label>
            <input type="date" id="incomeDate" name="income_date" class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white" value="<?php echo $income['getIncomeDate'] ?? ''; ?>">
            <button type="submit" id="validateIncome" class="rounded bg-blue-500 hover:bg-blue-300 hover:text-white transform duration-300 py-2 px-1">Add income</button>
        </form>
    </div>

    <script>
        // GSAP Animations

        // Navbar slide-in
        gsap.to("#navbar", {
            duration: 1,
            y: 0,
            opacity: 1,
            ease: "power2.out"
        });
    </script>
</body>


</html>