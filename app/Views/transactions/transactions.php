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

    <section class="max-w-6xl mx-auto px-6 mt-20">
        <div class="max-w-7xl mx-auto px-6">

            <header class="mb-12">
                <h2 class="text-center text-sm uppercase tracking-[0.2em] text-indigo-400 font-semibold">My Transactions</h2>
                <h1 class="mt-2 text-center text-4xl lg:text-5xl font-extrabold tracking-tight">Financial Overview</h1>
            </header>

            <div class="grid gap-8 lg:grid-cols-3 lg:grid-rows-2">

                
                <div class="lg:row-span-2 flex flex-col rounded-3xl bg-gray-900/40 border border-white/10 shadow-2xl backdrop-blur-sm overflow-hidden">
                    <div class="p-8 border-b border-white/5 bg-white/[0.02] flex justify-between items-center">
                        <h3 class="text-xl font-bold">Expenses</h3>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">
                            Total paid:
                            <?php
                            $query = "select sum(price) as total from expense where state='paid'";
                            $request = mysqli_query($conn, $query);
                            $rows = mysqli_fetch_assoc($request);
                            echo "<span class='text-emerald-400 font-bold ml-1'>{$rows['total']} $</span>";
                            ?>
                        </p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-white/5 text-gray-400 font-medium">
                                <tr>
                                    <th class="px-6 py-4">Expense</th>
                                    <th class="px-6 py-4">Price</th>
                                    <th class="px-6 py-4">Category</th>
                                    <th class="px-6 py-4">State</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                <?php
                                $query = "select expenseTitle, price , state,categorie 
                                            from expense 
                                            where user_id=$userId 
                                            and state='paid'";
                                $request = mysqli_query($conn, $query);
                                while ($rows = mysqli_fetch_assoc($request)) {
                                    echo "
                                <tr class='hover:bg-white/[0.03] transition-colors'>
                                    <td class='px-6 py-4 font-medium'>{$rows['expenseTitle']}</td>
                                    <td class='px-6 py-4 text-red-400 font-bold'>-{$rows['price']} $</td>
                                    <td class='px-6 py-4 text-gray-400'>{$rows['categorie']}</td>
                                    <td class='px-6 py-4 text-emerald-400 font-medium italic'>Paid</td>
                                </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- RECURRENT (Middle Top) -->
                <div class="rounded-3xl bg-gray-900/40 border border-white/10 shadow-2xl backdrop-blur-sm overflow-hidden flex flex-col">
                    <div class="p-6 border-b border-white/5">
                        <h3 class="text-lg font-bold italic text-indigo-300 tracking-wide">Recurrent Transactions</h3>
                    </div>
                    <div class="overflow-x-auto flex-grow">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-white/5 text-gray-400">
                                <tr>
                                    <th class="px-6 py-3">Title</th>
                                    <th class="px-6 py-3">Price</th>
                                    <th class="px-6 py-3">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
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
                                while ($rows = mysqli_fetch_assoc($request)) {
                                    echo "
                                <tr class='hover:bg-white/[0.03] transition-colors'>
                                    <td class='px-6 py-3'>{$rows['title']}</td>
                                    <td class='px-6 py-3 font-semibold'>{$rows['price']} $</td>
                                    <td class='px-6 py-3 text-indigo-400'>{$rows['event_date']}</td>
                                </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TRANSFERS (Middle Bottom) -->
                <div class="rounded-3xl bg-gray-900/40 border border-white/10 shadow-2xl backdrop-blur-sm overflow-hidden flex flex-col">
                    <div class="p-6 border-b border-white/5">
                        <h3 class="text-lg font-bold italic text-emerald-300 tracking-wide">My Transfers</h3>
                    </div>
                    <div class="overflow-x-auto flex-grow">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-white/5 text-gray-400">
                                <tr>
                                    <th class="px-6 py-3">ID</th>
                                    <th class="px-6 py-3">Receiver</th>
                                    <th class="px-6 py-3">Amount</th>
                                    <th class="px-6 py-3">When</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                <?php
                                $query = "select transferId, idReceiver , amount ,daySent from transfert where idSender=$userId";
                                $request = mysqli_query($conn, $query);
                                while ($rows = mysqli_fetch_assoc($request)) {
                                    echo "
                            <tr class='hover:bg-white/[0.03] transition-colors'>
                                <td class='px-6 py-3 text-gray-500'>#{$rows['transferId']}</td>
                                <td class='px-6 py-3 font-medium'>Rec: {$rows['idReceiver']}</td>
                                <td class='px-6 py-3 font-bold'>{$rows['amount']} $</td>
                                <td class='px-6 py-3 text-emerald-400'>{$rows['daySent']}</td>
                            </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- INCOMES (Right Sidebar) -->
                <div class="lg:row-span-2 flex flex-col rounded-3xl bg-gray-900/40 border border-white/10 shadow-2xl backdrop-blur-sm overflow-hidden">
                    <div class="p-8 border-b border-white/5 bg-white/[0.02] flex justify-between items-center">
                        <h3 class="text-xl font-bold">Incomes</h3>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">
                            Total gained:
                            <?php
                            $query = "select sum(price) as total from income";
                            $request = mysqli_query($conn, $query);
                            $rows = mysqli_fetch_assoc($request);
                            echo "<span class='text-indigo-400 font-bold ml-1'>{$rows['total']} $</span>";
                            ?>
                        </p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-white/5 text-gray-400 font-medium">
                                <tr>
                                    <th class="px-6 py-4">Income Source</th>
                                    <th class="px-6 py-4">Price</th>
                                    <th class="px-6 py-4">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                <?php
                                $query = "select incomeTitle, price, getIncomeDate 
                                            from income 
                                                where user_id=$userId";
                                $request = mysqli_query($conn, $query);
                                while ($rows = mysqli_fetch_assoc($request)) {
                                    echo "
                                <tr class='hover:bg-white/[0.03] transition-colors'>
                                    <td class='px-6 py-4 font-medium'>{$rows['incomeTitle']}</td>
                                    <td class='px-6 py-4 text-emerald-400 font-bold'>+{$rows['price']} $</td>
                                    <td class='px-6 py-4 text-gray-400'>{$rows['getIncomeDate']}</td>
                                </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
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