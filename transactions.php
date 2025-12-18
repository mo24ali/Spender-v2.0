<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>
    <title>Document</title>
</head>
<?php

require "config/connexion.php";
session_start();
$userId = $_SESSION['user_id'];


?>

<body class="bg-gray-50 dark:bg-gray-900 dark:text-white">
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
    <div class="bg-gray-900 py-24 sm:py-32">
        <div class="mx-auto max-w-2xl px-6 lg:max-w-7xl lg:px-8">
            <h2 class="text-center text-base/7 font-semibold text-indigo-400">My Transactions</h2>

            <div class="mt-10 grid gap-4 sm:mt-16 lg:grid-cols-3 lg:grid-rows-2">
                <div class="relative lg:row-span-2">
                    <div class="absolute inset-px rounded-lg bg-gray-800 lg:rounded-l-4xl"></div>
                    <div class="relative flex h-full flex-col overflow-hidden rounded-[calc(var(--radius-lg)+1px)] lg:rounded-l-[calc(2rem+1px)]">
                        <div class="px-8 pt-8 sm:px-10 sm:pt-10 grid grid-cols-2">
                            <p class="mb-2 text-lg font-medium tracking-tight text-white max-lg:text-center">Expenses transactions</p>
                            <p>Total paid: 
                                <?php
                                    $query = "select sum(price) as total from expense where state='paid'";
                                    $request = mysqli_query($conn,$query);
                                    $rows = mysqli_fetch_assoc($request);
                                    echo $rows['total']." $" ;

                                ?>    
                            </p>
                        </div>
                        <table class="w-full text-sm text-left rtl:text-right text-body border border-default rounded-lg overflow-hidden">
                            <thead class="bg-neutral-secondary-soft border-b border-default">
                                <tr>
                                    <th class="px-6 py-3 font-medium">Expense</th>
                                    <th class="px-6 py-3 font-medium">Price</th>
                                    <th class="px-6 py-3 font-medium">State</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $query = "select expenseTitle, price , state from expense where user_id=$userId and state='paid'";
                                    $request = mysqli_query($conn, $query);
                                    while ($rows = mysqli_fetch_assoc($request)) {
                                        echo "<tr class='odd:bg-neutral-primary-soft even:bg-neutral-secondary-soft border-b border-default hover:bg-neutral-secondary transition'>";
                                        echo "  <td class='px-6 py-3'>".htmlspecialchars($rows['expenseTitle'])."</td>";
                                        echo "  <td class='px-6 py-3'>".htmlspecialchars($rows['price'])."</td>";
                                        echo "  <td class='px-6 py-3'>".htmlspecialchars($rows['state'])."✅"."</td>";
                                    }
                                ?>
                            </tbody>
                        </table>



                    </div>
                    <div class="pointer-events-none absolute inset-px rounded-lg shadow-sm outline outline-white/15 lg:rounded-l-4xl"></div>
                </div>
                <div class="relative max-lg:row-start-1">
                    <div class="absolute inset-px rounded-lg bg-gray-800 max-lg:rounded-t-4xl"></div>
                    <div class="relative flex h-full flex-col overflow-hidden rounded-[calc(var(--radius-lg)+1px)] max-lg:rounded-t-[calc(2rem+1px)]">
                        <div class="px-8 pt-8 sm:px-10 sm:pt-10">
                            <p class="mt-2 text-lg font-medium tracking-tight text-white max-lg:text-center">Recurrente transactions</p>
                        </div>
                    </div>
                    <div class="pointer-events-none absolute inset-px rounded-lg shadow-sm outline outline-white/15 max-lg:rounded-t-4xl"></div>
                </div>
                <div class="relative max-lg:row-start-3 lg:col-start-2 lg:row-start-2">
                    <div class="absolute inset-px rounded-lg bg-gray-800"></div>
                    <div class="relative flex h-full flex-col overflow-hidden rounded-[calc(var(--radius-lg)+1px)]">
                        <div class="px-8 pt-8 sm:px-10 sm:pt-10">
                            <p class="mt-2 text-lg font-medium tracking-tight text-white max-lg:text-center">How am i doing this month</p>
                            <p class="mt-2 max-w-lg text-sm/6 text-gray-400 max-lg:text-center">Chart</p>
                        </div>
                        <div class="@container flex flex-1 items-center max-lg:py-6 lg:pb-2">
                            <img src="https://tailwindcss.com/plus-assets/img/component-images/dark-bento-03-security.png" alt="" class="h-[min(152px,40cqw)] object-cover" />
                        </div>
                    </div>
                    <div class="pointer-events-none absolute inset-px rounded-lg shadow-sm outline outline-white/15"></div>
                </div>
                <div class="relative lg:row-span-2">
                    <div class="absolute inset-px rounded-lg bg-gray-800 max-lg:rounded-b-4xl lg:rounded-r-4xl"></div>
                    <div class="relative flex h-full flex-col overflow-hidden rounded-[calc(var(--radius-lg)+1px)] max-lg:rounded-b-[calc(2rem+1px)] lg:rounded-r-[calc(2rem+1px)]">
                       <div class="px-8 pt-8 sm:px-10 sm:pt-10 grid grid-cols-2">
                            <p class="mb-2 text-lg font-medium tracking-tight text-white max-lg:text-center">Incomes transactions</p>
                            <p>
                                Total gained: 
                                <?php
                                    $query = " select sum(price) as total from income";
                                    $request = mysqli_query($conn, $query);
                                    $rows = mysqli_fetch_assoc($request);
                                    echo $rows['total']." $";
                                ?>
                            </p>
                        </div>
                        <table class="w-full text-sm text-left rtl:text-right text-body border border-default rounded-lg overflow-hidden">
                            <thead class="bg-neutral-secondary-soft border-b border-default">
                                <tr>
                                    <th class="px-6 py-3 font-medium">Income</th>
                                    <th class="px-6 py-3 font-medium">Price</th>
                                    <th class="px-6 py-3 font-medium">When to get it?</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $query = "select incomeTitle, price , getIncomeDate from income where user_id=$userId";
                                    $request = mysqli_query($conn, $query);
                                    while ($rows = mysqli_fetch_assoc($request)) {
                                        echo "<tr class='odd:bg-neutral-primary-soft even:bg-neutral-secondary-soft border-b border-default hover:bg-neutral-secondary transition'>";
                                        echo "  <td class='px-6 py-3'>".htmlspecialchars($rows['incomeTitle'])."</td>";
                                        echo "  <td class='px-6 py-3'>".htmlspecialchars($rows['price'])."</td>";
                                        echo "  <td class='px-6 py-3'>".htmlspecialchars($rows['getIncomeDate'])."⬅️"."</td>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="pointer-events-none absolute inset-px rounded-lg shadow-sm outline outline-white/15 max-lg:rounded-b-4xl lg:rounded-r-4xl"></div>
                </div>
            </div>
        </div>
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
</body>

</html>