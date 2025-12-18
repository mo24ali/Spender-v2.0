<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>

    <title>My Debit Cards</title>

</head>


<?php
require "config/connexion.php";
session_start();
$id = $_SESSION['user_id'];
?>

<body class="bg-gray-50 dark:bg-gray-900 dark:text-white">
    <!-- <div class="relative isolate bg-white sm:py-32 lg:px-8 dark:bg-gray-900"> -->

    <!-- NAVBAR -->
    <header class="sticky top-0 z-50 bg-white dark:bg-gray-800 shadow-sm opacity-0 translate-y-[-50px]" id="navbar">
        <nav class="max-w-7xl mx-auto flex items-center justify-between p-4">
            <a href="index.php" class="text-2xl font-bold text-blue-600 dark:text-white">Spender</a>
            <div class="hidden lg:flex space-x-10">
                <a href="dashboard.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 transition">Dashboard</a>
                <a href="transactions.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 transition">Transactions</a>
                <a href="mycard.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 transition">My Cards</a>
                <a href="expenses.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 transition">Expenses</a>
                <a href="incomes.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 transition">Incomes</a>

            </div>
            <a href="auth/logout.php">
                <button id="" class="hidden lg:inline-block bg-blue-600 px-4 py-2 rounded-lg text-white hover:bg-blue-500 transition lg:ml-4">
                    Logout
                </button>
            </a>
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

                <a href="auth/logout.php">
                    <button id="" class="mx-4 my-3 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition">
                        Logout
                    </button>
                </a>
            </div>
        </nav>
    </header>
    <!-- Header -->
    <div class="mx-auto max-w-4xl text-center">
        <h2 class="text-base font-semibold text-indigo-600 dark:text-indigo-400">
            Wallet
        </h2>
        <p class="mt-2 text-5xl font-semibold tracking-tight text-gray-900 sm:text-6xl dark:text-white">
            My Debit Cards
        </p>
    </div>

    <p class="mx-auto mt-6 max-w-2xl text-center text-lg text-gray-600 dark:text-gray-400">
        Manage your debit cards, check balances, and choose your primary card.
    </p>

    <?php
    $id = (int) $id;
    $query = "SELECT idCard,nom, currentSold, num, statue FROM carte WHERE user_id = $id";
    $request = mysqli_query($conn, $query);
    ?>

    <div class="mx-auto mt-16 grid max-w-lg grid-cols-1 gap-y-6 sm:mt-20 lg:max-w-4xl lg:grid-cols-2">

        <?php while ($row = mysqli_fetch_assoc($request)): ?>

            <div class="rounded-3xl bg-white/60 p-8 ring-1 ring-gray-900/10 dark:bg-white/5 dark:ring-white/10">

                <h3 class="text-lg font-semibold text-indigo-600 dark:text-indigo-400">
                    <?= htmlspecialchars($row['nom']) ?>
                </h3>

                <p class="mt-4 text-3xl font-semibold text-gray-900 dark:text-white">
                    Balance: <?= $row['currentSold'] ?> $
                </p>

                <ul class="mt-6 space-y-2 text-sm text-gray-600 dark:text-gray-300">
                    <li>
                        Card Number: <?= htmlspecialchars($row['num']) ?>
                    </li>
                    <li>
                        Status:
                        <span class="text-green-600 font-semibold">
                            <?= htmlspecialchars($row['statue']) ?>
                        </span>
                    </li>
                </ul>

                <div class="mt-6 flex gap-3">
                    <button class="rounded-md bg-indigo-500 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-400">
                        Edit
                    </button>

                    <button class="rounded-md bg-red-500 px-4 py-2 text-sm font-semibold text-white hover:bg-red-400">
                        <a href="delete_handlers/deleteCard.php?cardId=
                            <?php
                            echo $row['idCard']
                            ?>">
                            Delete
                        </a>
                    </button>
                </div>

            </div>

        <?php endwhile; ?>

    </div>

    <div class="mt-16 text-center">
        <button id="addCardBtn"
            class="inline-block rounded-md bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow hover:bg-indigo-500">
            + Add New Card
        </button>
    </div>

    <div id="addCard" class="fixed inset-0 bg-black/40 backdrop-blur-md flex justify-center items-center z-50 <?php echo isset($_GET['id']) ? '' : 'hidden' ?>">

        <?php
            require "config/connexion.php";
        ?>

        <form action="form_handlers/cardHandler.php" method="post"
            class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg w-96 space-y-4">

            <label for="provider" class="text-white">Provider</label>
            <input type="text" id="provider" name="provider"
                class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white">

            <label for="balance" class="text-white">Current Sold</label>
            <input type="text" id="balance" name="balance"
                class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white">

            <label for="cardNum" class="text-white">Card Number</label>
            <input type="text" id="cardNum" name="cardNum"
                class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white">

            <label for="cardLimit" class="text-white">Limit</label>
            <input type="text" id="cardLimit" name="cardLimit"
                class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white">

            <label for="expiredate" class="text-white">Expire Date</label>
            <input type="date" id="expiredate" name="expiredate"
                class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white">
        
            <label for="status" class="text-white">Status</label>
            <select type="date" id="expiredate" name="status"
                class="w-full p-2 rounded-lg border dark:bg-gray-900 dark:text-white">
                <option value="Primary">Primary</option>
                <option value="Secondary">Secondary</option>
            </select>

            <button type="submit"
                class="rounded bg-blue-500 hover:bg-blue-300 text-white p-2 w-full">
                Add Card
            </button>

        </form>
    </div>
    <script>
        // Navbar slide-in
        gsap.to("#navbar", {
            duration: 1,
            y: 0,
            opacity: 1,
            ease: "power2.out"
        });
    </script>

    <script>
        let pop = document.getElementById("addCardBtn");
        pop.addEventListener('click', () => {
            document.getElementById('addCard').classList.toggle('hidden');
        })
    </script>
</body>

</html>