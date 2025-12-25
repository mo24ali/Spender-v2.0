<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>

    <script src="js/auth.js"></script>
    <script src="js/forms.js"></script>
    <title>Incomes</title>
</head>



<body class="bg-gray-50 dark:bg-gray-900 dark:text-white">
    <?php
    session_start();
    ?>
    <!-- NAVBAR -->
      
        <?php
        
            require "../partials/nav.php";
        ?>

    <!-- MAIN CONTENT -->
    <main class="max-w-6xl mx-auto mt-20 px-4">
        <div class="flex flex-col mb-10 space-y-4">
            <h2 class="text-center text-sm uppercase tracking-widest text-indigo-400">List of: </h2>
            <h1 class="mt-2 text-center text-4xl font-bold mb-4">Incomes</h1>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <button id="newPaymentsBtn"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition duration-200"
                    onclick="showAddIncome()">
                    + New Income
                </button>

                <form class="flex flex-col sm:flex-row items-center gap-2" method="get">
                    <select id="incomeMonth" name="incomeMonth"
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

                    <select id="incomeCategory" name="incomeCategory"
                        class="bg-gray-700 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="" disabled selected>Filter by Category</option>
                        <option value="salary">Salary</option>
                        <option value="freelance">Freelance</option>
                        <option value="business">Business</option>
                        <option value="investment">Investment</option>
                        <option value="gift">Gift</option>
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
                    <th class="px-6 py-3 font-medium">Income ID</th>
                    <th class="px-6 py-3 font-medium">Income Title</th>
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
                $catergory ;
                $monthFilter ;
                $priceSort;
                if(isset($_GET['priceFilter'])){
                    $priceSort = $_GET['priceFilter'];
                }
                if (isset($_GET['incomeCategory'])) {
                    $catergory = $_GET['incomeCategory'];
                }
                if (isset($_GET['incomeMonth'])) {
                    $monthFilter = $_GET['incomeMonth'];
                }
                $catergoryCondition = "";
                $monthCondition = "";
                $priceSortCondition = "";
                if(isset($priceSort)){
                    $priceSortCondition = "ORDER BY price desc";
                }
                if (isset($catergory)) {
                    $catergoryCondition = "AND categorie= '$catergory'";
                }
                if (isset($monthFilter)) {
                    $monthCondition = "AND MONTH(getIncomeDate) = '$monthFilter'";
                }

                $request = "SELECT * FROM income where user_id=$userId $catergoryCondition $monthCondition $priceSortCondition";
                $query = mysqli_query($conn, $request);

                while ($row = mysqli_fetch_assoc($query)) {
                    $id = $row['incomeId'];

                    echo "<tr class='odd:bg-neutral-primary-soft even:bg-neutral-secondary-soft border-b border-default hover:bg-neutral-secondary transition'>";

                    echo "<td class='px-6 py-3'>" . htmlspecialchars($row['incomeId']) . "</td>";
                    echo "<td class='px-6 py-3'>" . htmlspecialchars($row['incomeTitle']) . "</td>";
                    echo "<td class='px-6 py-3'>" . htmlspecialchars($row['description']) . "</td>";
                    echo "<td class='px-6 py-3'>$" . htmlspecialchars($row['price']) . "</td>";
                    echo "<td class='px-6 py-3'>" . htmlspecialchars($row['categorie']) . "</td>";
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
            <input type="text" id="incomeDescription" name="income_description" class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white" value="<?php echo $income['description'] ?? ''; ?>">

            <label for="incomePrice" class="text-white"> Salary : </label>
            <input type="text" id="incomePrice" name="income_price" class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white" value="<?php echo $income['price'] ?? ''; ?>">

            <label for="incomeCategorie" class="text-white">Income category :</label>

            <select id="incomeCategorie" name="income_categorie"
                class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white">

                <option value="" disabled selected>Select category</option>

                <option value="salary" <?php if (($income['categorie'] ?? '') == 'salary') echo 'selected'; ?>>Salary</option>
                <option value="freelance" <?php if (($income['categorie'] ?? '') == 'freelance') echo 'selected'; ?>>Freelance</option>
                <option value="business" <?php if (($income['categorie'] ?? '') == 'business') echo 'selected'; ?>>Business</option>
                <option value="investment" <?php if (($income['categorie'] ?? '') == 'investment') echo 'selected'; ?>>Investment</option>
                <option value="gift" <?php if (($income['categorie'] ?? '') == 'gift') echo 'selected'; ?>>Gift</option>
                <option value="other" <?php if (($income['categorie'] ?? '') == 'other') echo 'selected'; ?>>Other</option>

            </select>

            
            <label for="incomeRecurrency" class="text-white">Is it recurrent?</label>
            <select id="incomeRecurrency" name="income_recurrency"
                class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white">

                <option value="" disabled selected>recurrent</option>
                <option value="YES"  <?php if (($income['isRecurent'] ?? '') == 'YES') echo 'selected'; ?>>Yes</option>
                <option value="NO" <?php if (($income['isRecurent'] ?? '') == 'NO') echo 'selected'; ?>>No</option>
            </select>
            <label for="incomeDate" class="text-white">Getting income date :</label>
            <input type="date" id="incomeDate" name="income_date" class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white" value="<?php echo $income['getIncomeDate'] ?? ''; ?>">
            <button type="submit" id="validateIncome" class="rounded bg-blue-500 hover:bg-blue-300 hover:text-white transform duration-300 py-2 px-1">
                <?php
                if (isset($modalId)) {
                    echo "modify income";
                } else {
                    echo "Add income";
                }
                ?>
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
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("addIncomeForm");

            form.addEventListener("submit", function(e) {
                const title = document.getElementById("incomeName").value.trim();
                const desc = document.getElementById("incomeDescription").value.trim();
                const price = document.getElementById("incomePrice").value.trim();
                const date = document.getElementById("incomeDate").value;

                document.querySelectorAll(".error-text").forEach(el => el.remove());

                let valid = true;

                if (title === "") {
                    showError("incomeName", "Income title is required");
                    valid = false;
                }

                if (desc === "") {
                    showError("incomeDescription", "Description is required");
                    valid = false;
                }

                if (price === "" || isNaN(price) || Number(price) <= 0) {
                    showError("incomePrice", "Enter a valid salary amount");
                    valid = false;
                }

                if (date === "") {
                    showError("incomeDate", "Please select a date");
                    valid = false;
                }

                if (!valid) {
                    e.preventDefault(); // stop form submit
                }
            });

            function showError(inputId, message) {
                const input = document.getElementById(inputId);
                const error = document.createElement("div");

                error.className = "error-text text-red-500 text-sm mt-1";
                error.innerText = message;

                input.parentNode.insertBefore(error, input.nextSibling);
            }
        });
    </script>

</body>


</html>