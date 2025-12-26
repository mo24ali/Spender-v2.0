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
require "../../Core/database.php";
    $db = Database::getInstance();
    $conn = $db->getConnection();
session_start();
$userId = $_SESSION['user_id'];
?>

<body class="bg-gradient-to-br from-gray-950 via-gray-900 to-gray-800 text-white">

     
        <?php
        
            require "../partials/nav.php";
        ?>

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
                            $request = $conn->query($query);
                            $rows = $request->fetch(PDO::FETCH_ASSOC);
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
                                $request = $conn->query($query);
                                while ($rows = $request->fetch(PDO::FETCH_ASSOC)) {
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
                                $request = $conn->query($query);
                                while ($rows = $request->fetch(PDO::FETCH_ASSOC)) {
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
                                $request = $conn->query($query);
                                while ($rows = $request->fetch(PDO::FETCH_ASSOC)) {
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
                            $request = $conn->query($query);
                            $rows = $request->fetch(PDO::FETCH_ASSOC);
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
                                $request = $conn->query($query);
                                while ($rows = $request->fetch(PDO::FETCH_ASSOC)) {
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
</body>

</html>