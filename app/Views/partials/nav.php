 <header class="sticky top-0 z-50 bg-gray-900/80 backdrop-blur border-b border-white/10 shadow-lg opacity-0 -translate-y-10" id="navbar">
        <nav class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
            <a href="index.php"
                class="text-2xl font-extrabold bg-gradient-to-r from-blue-400 to-indigo-500 bg-clip-text text-transparent">
                Spender
            </a>

            <div class="hidden lg:flex space-x-10">
                <a href="#" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 transition">Dashboard</a>
                <a href="../transactions/transactions.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 transition">Transactions</a>
                <a href="../cards/mycard.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 transition">My Cards</a>
                <a href="../expenses/expenses.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 transition">Expenses</a>
                <a href="../incomes/incomes.php" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 transition">Incomes</a>

            </div>
            <a href="../auth/logout.php">
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