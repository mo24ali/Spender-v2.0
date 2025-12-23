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

<body class="min-h-screen bg-gradient-to-br from-gray-950 via-gray-900 to-gray-800 text-white">

    <!-- NAVBAR -->
    <header id="navbar"
        class="sticky top-0 z-50 bg-gray-900/80 backdrop-blur border-b border-white/10 shadow-lg opacity-0 -translate-y-10">
        <nav class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
            <a href="index.php"
                class="text-2xl font-extrabold bg-gradient-to-r from-blue-400 to-indigo-500 bg-clip-text text-transparent">
                Spender
            </a>

            <div class="hidden lg:flex gap-8 text-sm font-medium">
                <a href="dashboard.php" class="hover:text-blue-400 transition">Dashboard</a>
                <a href="transactions.php" class="hover:text-blue-400 transition">Transactions</a>
                <a href="mycard.php" class="text-blue-400">My Cards</a>
                <a href="expenses.php" class="hover:text-blue-400 transition">Expenses</a>
                <a href="incomes.php" class="hover:text-blue-400 transition">Incomes</a>
            </div>

            <a href="auth/logout.php"
                class="hidden lg:inline-block rounded-xl bg-blue-600 px-5 py-2 text-sm font-semibold hover:bg-blue-500 transition">
                Logout
            </a>
        </nav>
    </header>

    <!-- HEADER -->
    <section class="pt-24 text-center">
        <h2 class="text-sm uppercase tracking-widest text-indigo-400">Wallet</h2>
        <h1 class="mt-3 text-5xl font-bold tracking-tight">My Debit Cards</h1>
        <p class="mt-4 mb-4 text-gray-400 max-w-xl mx-auto">
            Manage your debit cards, track balances, and choose your primary card.
        </p>
        <button
            class="flex-1 rounded-xl bg-indigo-600/90 px-4 py-2 text-sm font-semibold hover:bg-indigo-500 transition">
            <a href="transactions_handler/helperSendMoney.php?sendTransfer=true">
                Send Money
            </a>
        </button>
    </section>

    <?php
    $id = $id;
    $query = "SELECT idCard,nom, currentSold, num, statue,limite FROM carte WHERE user_id = $id";
    $request = mysqli_query($conn, $query);
    ?>

    <!-- CARDS GRID -->
    <section class="max-w-6xl mx-auto px-6 mt-20">
        <div class="grid gap-8 sm:grid-cols-2">

            <?php while ($row = mysqli_fetch_assoc($request)): ?>

                <div
                    class="relative rounded-3xl bg-white/5 backdrop-blur border border-white/10 p-8 shadow-xl hover:shadow-indigo-500/10 transition">

                    <!-- STATUS BADGE -->
                    <span
                        class="absolute top-4 right-4 text-xs px-3 py-1 rounded-full 
                        <?= $row['statue'] === 'Primary'
                            ? 'bg-indigo-500/20 text-indigo-400'
                            : 'bg-gray-500/20 text-gray-400' ?>">
                        <?= htmlspecialchars($row['statue']) ?>
                    </span>

                    <h3 class="text-xl font-semibold text-indigo-400">
                        <?= htmlspecialchars($row['nom']) ?>
                    </h3>

                    <p class="mt-4 text-3xl font-bold">
                        <?= $row['currentSold'] ?> $
                    </p>

                    <p class="mt-2 text-sm text-gray-400">
                        Card Number: <?= htmlspecialchars($row['num']) ?>
                    </p>
                    <p class="mt-2 text-sm text-gray-400">
                        Card Limit:
                        <span class="text-xs px-3 py-1 rounded-full bg-yellow-500/20 text-yellow-400">
                            <?= htmlspecialchars($row['limite']) ?>
                        </span>

                    </p>

                    <div class="mt-8 flex gap-3">
                        <button
                            class="flex-1 rounded-xl bg-indigo-600/90 px-4 py-2 text-sm font-semibold hover:bg-indigo-500 transition">
                            Edit
                        </button>

                        <a href="delete_handlers/deleteCard.php?cardId=<?php echo $row['idCard'] ?>"
                            class="flex-1 rounded-xl bg-red-600/90 px-4 py-2 text-sm font-semibold text-center hover:bg-red-500 transition">
                            Delete
                        </a>
                    </div>
                </div>

            <?php endwhile; ?>

        </div>
    </section>

    <!-- ADD CARD BUTTON -->
    <div class="mt-20 text-center">
        <button id="addCardBtn"
            class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-indigo-600 to-blue-600 px-8 py-4 text-sm font-semibold shadow-lg hover:scale-105 transition">
            + Add New Card
        </button>
    </div>

    <!-- MODAL -->
    <div id="addCard"
        class="fixed inset-0 bg-black/50 backdrop-blur flex items-center justify-center z-50 <?php echo isset($_GET['id']) ? '' : 'hidden' ?>">

        <?php require "config/connexion.php"; ?>

        <form action="form_handlers/cardHandler.php" method="post"
            class="w-[380px] rounded-3xl bg-gray-900 border border-white/10 p-8 shadow-2xl space-y-4">

            <h3 class="text-xl font-semibold text-center mb-4">Add New Card</h3>

            <input type="text" name="provider" placeholder="Provider"
                class="w-full rounded-xl bg-gray-800 border border-white/10 p-3">

            <input type="text" name="balance" placeholder="Current Balance"
                class="w-full rounded-xl bg-gray-800 border border-white/10 p-3">

            <input type="text" name="cardNum" placeholder="Card Number"
                class="w-full rounded-xl bg-gray-800 border border-white/10 p-3">

            <input type="text" name="cardLimit" placeholder="Limit"
                class="w-full rounded-xl bg-gray-800 border border-white/10 p-3">

            <input type="date" name="expiredate"
                class="w-full rounded-xl bg-gray-800 border border-white/10 p-3">

            <select name="status"
                class="w-full rounded-xl bg-gray-800 border border-white/10 p-3">
                <option value="Primary">Primary</option>
                <option value="Secondary">Secondary</option>
            </select>

            <button type="submit"
                class="w-full rounded-xl bg-indigo-600 py-3 font-semibold hover:bg-indigo-500 transition">
                Add Card
            </button>
        </form>
    </div>


    <div id="sendMoney" class="fixed inset-0 bg-black/40 backdrop-blur-md flex justify-center items-center z-50 
        <?php
            if (!isset($_GET['send'])) {
                echo 'hidden';
            } else {
                echo ' ';
            }


            $userId = $_SESSION['user_id'];

            ?>
        ">
        <form id="sendMoneyForm" class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg w-96 space-y-4"
            action="transactions_handler/transferMoney.php?sender=userId?target=targetId" method="POST">
            <h2 class="text-xl font-bold text-center dark:text-white">Send to a friend</h2>
            <input type="text" name="receiverMail" placeholder="Receiver email"
                class="w-full p-2 border rounded-lg dark:bg-gray-900 dark:text-white">
            <input type="text" name="amount" placeholder="How much you want to send ?"
                class="w-full p-2 border rounded-lg dark:bg-gray-900 dark:text-white">

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-500 text-white py-2 rounded-lg transition">Send</button>
        </form>
    </div>
    <!-- ANIMATIONS -->
    <script>
        gsap.to("#navbar", {
            duration: 0.8,
            y: 0,
            opacity: 1,
            ease: "power3.out"
        });

        document.getElementById("addCardBtn").addEventListener("click", () => {
            document.getElementById("addCard").classList.toggle("hidden");
        });
    </script>

</body>

</html>