<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>
    <title>Transactions • Spender</title>
</head>

<?php
require "config/connexion.php";
session_start();
$userId = $_SESSION['user_id'];
?>

<body class="bg-gradient-to-br from-gray-950 via-gray-900 to-gray-800 text-white">

    <header class="sticky top-0 z-50 bg-gray-900/80 backdrop-blur border-b border-white/10 shadow-lg opacity-0 -translate-y-10" id="navbar">
        <nav class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
            <a href="index.php"
                class="text-2xl font-extrabold bg-gradient-to-r from-blue-400 to-indigo-500 bg-clip-text text-transparent">
                Spender
            </a>
            <div class="hidden lg:flex space-x-10">
                <a href="dashboard.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 transition">Dashboard</a>
                <a href="transactions.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 transition">Transactions</a>
                <a href="mycard.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 transition">My cards</a>
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

    <section class="py-24">
        <div class="max-w-7xl mx-auto px-6">

            <h2 class="text-center text-sm uppercase tracking-widest text-indigo-400">My Transactions</h2>
            <h1 class="mt-2 text-center text-4xl font-bold">Overview</h1>

            <div class="mt-16 grid gap-6 lg:grid-cols-3 lg:grid-rows-2">

                <div class="lg:row-span-2 rounded-3xl bg-gray-900/70 border border-white/10 shadow-xl">
                    <div class="p-8 flex justify-between items-center">
                        <h3 class="text-xl font-semibold">Expenses</h3>
                        <p class="text-sm text-gray-400">
                            Total paid:
                            <?php
                            $query = "select sum(price) as total from expense where state='paid'";
                            $request = mysqli_query($conn, $query);
                            $rows = mysqli_fetch_assoc($request);
                            echo "<span class='text-white font-semibold'>{$rows['total']} $</span>";
                            ?>
                        </p>
                    </div>

                    <table class="w-full text-sm">
                        <thead class="bg-white/5 text-gray-300">
                            <tr>
                                <th class="px-6 py-3 text-left">Expense</th>
                                <th class="px-6 py-3">Price</th>
                                <th class="px-6 py-3">State</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "select expenseTitle, price , state from expense where user_id=$userId and state='paid'";
                            $request = mysqli_query($conn, $query);
                            while ($rows = mysqli_fetch_assoc($request)) {
                                echo "
                                <tr class='border-t border-white/5 hover:bg-white/5 transition'>
                                    <td class='px-6 py-3'>{$rows['expenseTitle']}</td>
                                    <td class='px-6 py-3 text-center'>{$rows['price']}</td>
                                    <td class='px-6 py-3 text-center text-green-400'>✓ Paid</td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- RECURRENT -->
                <div class="rounded-3xl bg-gray-900/70 border border-white/10 shadow-xl">
                    <div class="p-8">
                        <h3 class="text-xl font-semibold mb-4">Recurrent Transactions</h3>

                        <table class="w-full text-sm">
                            <thead class="bg-white/5 text-gray-300">
                                <tr>
                                    <th class="px-6 py-3 text-left">Title</th>
                                    <th class="px-6 py-3">Price</th>
                                    <th class="px-6 py-3">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "
                                    SELECT incomeTitle AS title, price, getIncomeDate AS event_date
                                    FROM income
                                    WHERE user_id=$userId AND isRecurent='YES'
                                    UNION
                                    SELECT expenseTitle AS title, price, dueDate AS event_date
                                    FROM expense
                                    WHERE user_id=$userId AND isRecurent='YES'
                                    ORDER BY event_date
                                ";

                                $request = mysqli_query($conn, $query);
                                if (!$request) die(mysqli_error($conn));

                                while ($rows = mysqli_fetch_assoc($request)) {
                                    echo "
                                    <tr class='border-t border-white/5 hover:bg-white/5 transition'>
                                        <td class='px-6 py-3'>{$rows['title']}</td>
                                        <td class='px-6 py-3 text-center'>{$rows['price']}</td>
                                        <td class='px-6 py-3 text-center text-indigo-400'>{$rows['event_date']}</td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- STATS -->
                <div class="rounded-3xl bg-gray-900/70 border border-white/10 shadow-xl flex items-center justify-center">
                    <h3 class="text-xl font-semibold mb-4">My Transfers</h3>

                </div>

                <!-- INCOMES -->
                <div class="lg:row-span-2 rounded-3xl bg-gray-900/70 border border-white/10 shadow-xl">
                    <div class="p-8 flex justify-between items-center">
                        <h3 class="text-xl font-semibold">Incomes</h3>
                        <p class="text-sm text-gray-400">
                            Total gained:
                            <?php
                            $query = "select sum(price) as total from income";
                            $request = mysqli_query($conn, $query);
                            $rows = mysqli_fetch_assoc($request);
                            echo "<span class='text-white font-semibold'>{$rows['total']} $</span>";
                            ?>
                        </p>
                    </div>

                    <table class="w-full text-sm">
                        <thead class="bg-white/5 text-gray-300">
                            <tr>
                                <th class="px-6 py-3 text-left">Income</th>
                                <th class="px-6 py-3">Price</th>
                                <th class="px-6 py-3">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "select incomeTitle, price , getIncomeDate from income where user_id=$userId";
                            $request = mysqli_query($conn, $query);
                            while ($rows = mysqli_fetch_assoc($request)) {
                                echo "
                                <tr class='border-t border-white/5 hover:bg-white/5 transition'>
                                    <td class='px-6 py-3'>{$rows['incomeTitle']}</td>
                                    <td class='px-6 py-3 text-center'>{$rows['price']}</td>
                                    <td class='px-6 py-3 text-center text-blue-400'>{$rows['getIncomeDate']}</td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>

    <script>
        gsap.to("#navbar", {
            duration: 0.8,
            y: 0,
            opacity: 1,
            ease: "power3.out"
        });
    </script>
</body>

</html>