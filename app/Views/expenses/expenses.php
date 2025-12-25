<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>

    <script src="../../../js/forms.js"></script>
    <title>Expenses</title>
</head>


<body class="bg-gray-50 dark:bg-gray-900 dark:text-white">
    <?php
    session_start();
    require "../../Core/database.php";
    $db = new Database();
    $conn = $db->getConnection();
    ?>
    <!-- NAVBAR -->

    <?php

    require "../partials/nav.php";
    ?>

    <main class="max-w-6xl mx-auto mt-20 px-4">
        <div class="flex flex-col mb-10 space-y-4">
            <h2 class="text-center text-sm uppercase tracking-widest text-indigo-400">List of: </h2>
            <h1 class="mt-2 text-center text-4xl font-bold mb-4">Expences</h1>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <button id="newPaymentsBtn"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition duration-200"
                    onclick="showAddExpenseModal()">
                    + New Expense
                </button>
                <a href="expenses.php?categoryLimit=true"
                    class="px-3 py-1 bg-orange-500 text-white rounded hover:bg-orange-600 transform duration-300">
                    Set Category Limit
                </a>

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
                $userId = $_SESSION['user_id'];
                echo $userId;
                $catergory;
                $monthFilter;
                $priceSort;
                if (isset($_GET['priceFilter'])) {
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
                if (isset($priceSort)) {
                    $priceSortCondition = "ORDER BY PRICE desc";
                }
                if (isset($catergory)) {
                    $catergoryCondition = "AND categorie= '$catergory'";
                }
                if (isset($monthFilter)) {
                    $monthCondition = "AND MONTH(dueDate) = '$monthFilter'";
                }




                $request = "SELECT * FROM expense where user_id=$userId and state='not paid' $catergoryCondition $monthCondition $priceSortCondition";
                $query = $conn->query($request);

                while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
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
                    <a href='updateExpense.php?id={$id}' 
                       class='px-3 py-1 rounded-md bg-blue-500 text-white hover:bg-blue-600 transition text-xs'>
                        Edit
                    </a>
                    <a href='deleteExpense.php?id={$id}' 
                       class='px-3 py-1 rounded-md bg-red-500 text-white hover:bg-red-600 transition text-xs'>
                        Delete
                    </a>
                    <button>
                        <a href='../cards/chooseCard.php?expenseId=$id' 
                       class='px-3 py-1 rounded-md bg-green-500 text-white hover:bg-green-600 transition text-xs'>
                        Pay
                    </a>
                    </button>
                </td>
            ";

                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
    <!-- SET MONTHLY LIMITS TO EACH CATEGORY -->

    <!-- CATEGORY LIMIT MODAL -->
    <div id="categoryLimitModal" class="fixed inset-0 bg-black/40 backdrop-blur-md flex justify-center items-center z-50
    <?php echo isset($_GET['categoryLimit']) ? '' : 'hidden'; ?>
">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg w-96 space-y-4">
            <h2 class="text-lg font-semibold mb-4">Set Category Limit</h2>

            <form method="POST" action="categoryLimitHandler/categoryLimit.php" class="space-y-4">

                <label for="expenseCategoryLimit" class="block text-gray-700 font-medium">Category</label>
                <select id="expenseCategoryLimit" name="categoryNameLimit"
                    class="bg-gray-700 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 w-full" required>
                    <option value="" disabled selected>Select Category</option>
                    <option value="food">Food</option>
                    <option value="transport">Transport</option>
                    <option value="bills">Bills</option>
                    <option value="shopping">Shopping</option>
                    <option value="health">Health</option>
                    <option value="entertainment">Entertainment</option>
                    <option value="other">Other</option>
                </select>

                <label for="monthlyLimit" class="block text-gray-700 font-medium">Monthly Limit</label>
                <input type="number" min="0" step="0.01" id="monthlyLimit" name="monthly_limit"
                    class="bg-gray-700 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 w-full"
                    placeholder="Enter monthly limit" required>

                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">

                <button type="submit" name="setLimit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500 w-full">
                    Save Limit
                </button>
            </form>

            <a href="expenses.php" class="block text-center text-sm text-gray-500 mt-4">
                Cancel
            </a>
        </div>
    </div>



    <!-- CHOOSE CARD MODAL -->
    <div id="cardModal" class="fixed inset-0 bg-black/40 backdrop-blur-md flex justify-center items-center z-50 
    
                <?php

                if (!isset($_GET['chooseCard'])) {
                    echo " hidden";
                } else {
                    echo " ";
                }

                ?>
    ">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg w-96 space-y-4">

            <h2 class="text-lg font-semibold mb-4">Choose a card</h2>

            <?php
            $cardQuery = "SELECT * FROM carte WHERE user_id = $userId";
            $request = $conn->query($cardQuery);
            ?>
            <?php while ($card = $request->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="border p-3 rounded mb-2 flex justify-between items-center">
                    <div>
                        <p class="font-medium"><?= htmlspecialchars($card['nom']) ?></p>
                        <p class="text-sm text-gray-600">
                            Balance: <?= $card['currentSold'] ?> |
                            Limit: <?= $card['limite'] ?>
                        </p>

                        <?php if ($card['statue'] === 'Primary'): ?>
                            <span class="text-xs text-green-600 font-semibold">Primary</span>
                        <?php endif; ?>
                    </div>

                    <form method="GET" action="transactions_handler/payExpense.php">
                        <input type="hidden" name="payed" value="<?= isset($_GET['expenseId']) ? (int)$_GET['expenseId'] : 0 ?>">
                        <input type="hidden" name="card" value="<?= htmlspecialchars($card['idCard']) ?>">
                        <button class="px-3 py-1 bg-green-500 text-white rounded text-xs">
                            Pay
                        </button>
                    </form>

                </div>
            <?php endwhile; ?>
            <a href="expenses.php" class="block text-center text-sm text-gray-500 mt-4">
                Cancel
            </a>

        </div>
    </div>

    <!-- ADD EXPENSE MODAL -->


    <div id="addExpense" class="fixed inset-0 bg-black/40 backdrop-blur-md flex justify-center items-center z-50 
    <?php echo isset($_GET['id']) ? '' : 'hidden'; ?>">

        <?php

        $expense = null;
        $modalId = null;

        if (isset($_GET['id'])) {
            $modalId = $_GET['id'];
            $query = "SELECT * FROM expense WHERE expenseId = $modalId";
            $request = $conn->query($query);
            $expense = $request->fetch(PDO::FETCH_ASSOC);
        }
        ?>

        <form id="addExpenseForm" action="expensesHandler.php<?php echo "?id=" . $modalId ?>" method="post"
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

            <label for="expenseRecurrency" class="text-white">Is it recurrent?</label>
            <select id="expenseRecurrency" name="expense_recurrency"
                class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white">

                <option value="" disabled selected>recurrent</option>
                <option value="YES" <?php if (($expense['isRecurent'] ?? '') == 'YES') echo 'selected'; ?>>Yes</option>
                <option value="NO" <?php if (($expense['isRecurent'] ?? '') == 'NO') echo 'selected'; ?>>No</option>
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