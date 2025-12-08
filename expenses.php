<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>

    <script src="js/forms.js"></script>
    <script src="js/auth.js"></script>
    <!-- <script src="js/validators.js"></script> -->
    <title>Expenses</title>
</head>


<body class="bg-gray-50 dark:bg-gray-900 dark:text-white">
    <?php
    session_start();

    ?>
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
        <div class="flex flex-col mb-10 space-y-4">
            <p class="text-gray-700 dark:text-gray-300 text-xl font-semibold">Liste des Dépences:</p>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <!-- New Income Button -->
                <button id="newPaymentsBtn"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition duration-200"
                    onclick="showAddExpenseModal()">
                    + New Expense
                </button>

                <!-- Filters Form -->
                <form class="flex flex-col sm:flex-row items-center gap-2" method="get">
                    <select id="expenseMonth" name="expenseMonth"
                        class="bg-gray-700 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="" disabled selected>Filter by Month</option>
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

                    <select id="expenseCategory" name="expenseCategory"
                        class="bg-gray-700 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="" disabled selected>Filter by Category</option>
                        <option value="food">Food</option>
                        <option value="transport">Transport</option>
                        <option value="bills">Bills</option>
                        <option value="shopping">Shopping</option>
                        <option value="health">Health</option>
                        <option value="entertainment">Entertainment</option>
                        <option value="other">Other</option>
                    </select>
                    Sort by price:
                    <input type="checkbox" placeholder="sort by price" name="priceFilter">
                    <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-500 transition duration-200">
                        Apply
                    </button>
                </form>
            </div>
        </div>



        <table class="w-full text-sm text-left rtl:text-right text-body border border-default rounded-lg overflow-hidden">
            <thead class="bg-neutral-secondary-soft border-b border-default">
                <tr>
                    <th class="px-6 py-3 font-medium">Expense ID</th>
                    <th class="px-6 py-3 font-medium">Expense Title</th>
                    <th class="px-6 py-3 font-medium">Description</th>
                    <th class="px-6 py-3 font-medium">Price</th>
                    <th class="px-6 py-3 font-medium">Category</th>
                    <th class="px-6 py-3 font-medium">Due Date</th>
                    <th class="px-6 py-3 font-medium">Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php
                require "config/connexion.php";
                $userId = $_SESSION['user_id'];
                $catergory;
                $monthFilter;
                $priceSort;
                if(isset($_GET['priceFilter'])){
                    $priceSort = $_GET['priceFilter'];
                }
                if (isset($_GET['expenseCategory'])) {
                    $catergory = $_GET['expenseCategory'];
                }
                if (isset($_GET['expenseMonth'])) {
                    $monthFilter = $_GET['expenseMonth'];
                }
                $catergoryCondition = "";
                $monthCondition = "";
                $priceSortCondition = "";
                if(isset($priceSort)){
                        $priceSortCondition = "ORDER BY PRICE desc";
                }
                if (isset($catergory)) {
                    $catergoryCondition = "AND categorie= '$catergory'";
                }
                if (isset($monthFilter)) {
                    $monthCondition = "AND MONTH(dueDate) = '$monthFilter'";
                }
                $request = "SELECT * FROM expense where user_id=$userId $catergoryCondition $monthCondition $priceSortCondition";
                $query = mysqli_query($conn, $request);

                while ($row = mysqli_fetch_assoc($query)) {
                    $id = $row['expenseId'];

                    echo "<tr class='odd:bg-neutral-primary-soft even:bg-neutral-secondary-soft border-b border-default hover:bg-neutral-secondary transition'>";

                    echo "<td class='px-6 py-3'>" . htmlspecialchars($row['expenseId']) . "</td>";
                    echo "<td class='px-6 py-3'>" . htmlspecialchars($row['expenseTitle']) . "</td>";
                    echo "<td class='px-6 py-3'>" . htmlspecialchars($row['description']) . "</td>";
                    echo "<td class='px-6 py-3'>$" . htmlspecialchars($row['price']) . "</td>";
                    echo "<td class='px-6 py-3'>" . htmlspecialchars($row['categorie']) . "</td>";
                    echo "<td class='px-6 py-3'>" . htmlspecialchars($row['dueDate']) . "</td>";

                    echo "
                <td class='px-6 py-3 flex gap-2'>
                    <a href='update_handlers/updateExpense.php?id={$id}' 
                       class='px-3 py-1 rounded-md bg-blue-500 text-white hover:bg-blue-600 transition text-xs'>
                        Edit
                    </a>
                    <a href='delete_handlers/deleteExpense.php?id={$id}' 
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
    <!-- ADD EXPENSE MODAL -->


    <div id="addExpense" class="fixed inset-0 bg-black/40 backdrop-blur-md flex justify-center items-center z-50 
    <?php echo isset($_GET['id']) ? '' : 'hidden'; ?>">

        <?php
        require "config/connexion.php";

        $expense = null;
        $modalId = null;

        if (isset($_GET['id'])) {
            $modalId = $_GET['id'];
            $query = "SELECT * FROM expense WHERE expenseId = $modalId";
            $request = mysqli_query($conn, $query);
            $expense = mysqli_fetch_assoc($request);
        }
        ?>

        <form id="addExpenseForm" action="form_handlers/expensesHandler.php<?php echo "?id=" . $modalId ?>" method="post"
            class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg w-96 space-y-4">

            <label for="expenseName" class="text-white">Expense title</label>
            <input type="text" id="expenseName" name="expense_title"
                class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white"
                value="<?php echo $expense['expenseTitle'] ?? ''; ?>">

            <label for="expenseDescription" class="text-white">Description</label>
            <input type="text" id="expenseDescription" name="expense_description"
                class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white"
                value="<?php echo $expense['description'] ?? ''; ?>">

            <label for="expensePrice" class="text-white">Cost</label>
            <input type="text" id="expensePrice" name="expense_price"
                class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white"
                value="<?php echo $expense['price'] ?? ''; ?>">

            <label for="expenseCategorie" class="text-white">Expense category :</label>

            <select id="expenseCategorie" name="expense_categorie"
                class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white">

                <option value="" disabled selected>Select category</option>
                <!-- food transport bills  shopping  health entertainment other-->
                <option value="food" <?php if (($expense['categorie'] ?? '') == 'food') echo 'selected'; ?>>Food</option>
                <option value="transport" <?php if (($expense['categorie'] ?? '') == 'transport') echo 'selected'; ?>>Transport</option>
                <option value="bills" <?php if (($expense['categorie'] ?? '') == 'bills') echo 'selected'; ?>>Bills</option>
                <option value="shopping" <?php if (($expense['categorie'] ?? '') == 'shopping') echo 'selected'; ?>>Shopping</option>
                <option value="health" <?php if (($expense['categorie'] ?? '') == 'health') echo 'selected'; ?>>Health</option>
                <option value="entertainment" <?php if (($expense['categorie'] ?? '') == 'entertainment') echo 'selected'; ?>>Entertainment</option>
                <option value="other" <?php if (($expense['categorie'] ?? '') == 'other') echo 'selected'; ?>>Other</option>

            </select>


            <label for="expenseDate" class="text-white">Due Date</label>
            <input type="date" id="expenseDate" name="expense_date"
                class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white"
                value="<?php echo $expense['dueDate'] ?? ''; ?>">

            <button type="submit" id="validateExpense"
                class="rounded bg-blue-500 hover:bg-blue-300 text-white p-2 w-full">
                <?php echo $modalId ? "Update Expense" : "Add Expense"; ?>
            </button>

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

    <script>
        let form = document.getElementById("addExpenseForm");
        form.addEventListener("submit", () => {
            let title = document.getElementById("expenseName").value.trim();
            let description = document.getElementById("expenseDescription").value.trim();
            let price = document.getElementById("expensePrice").value.trim();
            let date = document.getElementById("expenseDate").value.trim();
            document.querySelectorAll(".error-text").forEach(el => el.remove());

            let valid = true;

            if (title === "") {
                showError("incomeName", "Title is required");
                valid = false;
            }

            if (description === "") {
                showError("incomeDescription", "Description is required");
                valid = false;
            }

            if (price === "" || isNaN(price) || Number(price) <= 0) {
                showError("incomePrice", "Enter a valid amount");
                valid = false;
            }

            if (date === "") {
                showError("incomeDate", "Please select a date");
                valid = false;
            }

            if (!valid) {
                e.preventDefault();
            }

            function showError(id, msg) {
                const el = document.getElementById(id);
                const error = document.createElement("div");
                error.className = "error-text text-red-500 text-sm mt-1";
                error.innerText = msg;

                el.parentNode.insertBefore(error, el.nextSibling);
            }
        })
    </script>
</body>


</html>