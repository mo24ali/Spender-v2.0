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
session_start();
require "../../Core/database.php";
$conn = Database::getInstance();
?>


<body class="min-h-screen bg-gradient-to-br from-gray-950 via-gray-900 to-gray-800 text-white">


<!-- NAVBAR -->
    <?php require "../partials/nav.php"; ?>

    <section class="pt-24 text-center">
        <h2 class="text-sm uppercase tracking-widest text-indigo-400">Wallet</h2>
        <h1 class="mt-3 text-5xl font-bold tracking-tight">My Debit Cards</h1>
        <p class="mt-4 mb-4 text-gray-400 max-w-xl mx-auto">
            Manage your debit cards, track balances, and choose your primary card.
        </p>
        <button class="rounded-xl bg-indigo-600/90 px-6 py-2 text-sm font-semibold hover:bg-indigo-500 transition">
            <a href="helperSendMoney.php?sendTransfer=true">Send Money</a>
        </button>
    </section>

    <?php
    $userId = $_SESSION['user_id'];
    $stmt = $conn->getConnection()->prepare("SELECT idCard, nom, currentSold, num, statue, limite, expireDate 
                                                FROM carte 
                                                WHERE user_id = ?");
    $stmt->execute([$userId]);

    $editData = null;
    if (isset($_GET['edit_id'])) {
        $editStmt = $conn->getConnection()->prepare("SELECT * 
                                                        FROM carte 
                                                        WHERE idCard = ? 
                                                        AND user_id = ?");
        $editStmt->execute([$_GET['edit_id'], $userId]);
        $editData = $editStmt->fetch(PDO::FETCH_ASSOC);
    }
    ?>

    <section class="max-w-6xl mx-auto px-6 mt-20">
        <div class="grid gap-8 sm:grid-cols-2">
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="relative rounded-3xl bg-white/5 backdrop-blur border border-white/10 p-8 shadow-xl hover:shadow-indigo-500/10 transition">

                    <span class="absolute top-4 right-4 text-xs px-3 py-1 rounded-full <?= $row['statue'] === 'Primary' ? 'bg-indigo-500/20 text-indigo-400' : 'bg-gray-500/20 text-gray-400' ?>">
                        <?= htmlspecialchars($row['statue']) ?>
                    </span>

                    <h3 class="text-xl font-semibold text-indigo-400"><?= htmlspecialchars($row['nom']) ?></h3>
                    <p class="mt-4 text-3xl font-bold"><?= number_format($row['currentSold'], 2) ?> $</p>

                    <p class="mt-2 text-sm text-gray-400">
                        Card: **** **** **** <?= substr(htmlspecialchars($row['num'] ?? ''), -4) ?>
                    </p>

                    <div class="mt-8 flex gap-3">
                        <a href="?edit_id=<?= $row['idCard'] ?>" class="flex-1 rounded-xl bg-indigo-600/90 px-4 py-2 text-sm font-semibold text-center hover:bg-indigo-500 transition">
                            Edit
                        </a>
                        <a href="deleteCard.php?cardId=<?= $row['idCard'] ?>" onclick="return confirm('Are you sure?')" class="flex-1 rounded-xl bg-red-600/90 px-4 py-2 text-sm font-semibold text-center hover:bg-red-500 transition">
                            Delete
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <div class="mt-20 text-center">
        <button id="addCardBtn" class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-indigo-600 to-blue-600 px-8 py-4 text-sm font-semibold shadow-lg hover:scale-105 transition">
            + Add New Card
        </button>
    </div>

    <div id="cardModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 <?= (isset($_GET['edit_id'])) ? '' : 'hidden' ?>">

        <form action="cardHandler.php<?= isset($editData) ? '?id=' . $editData['idCard'] : '' ?>" method="post" class="w-[380px] rounded-3xl bg-gray-900 border border-white/10 p-8 shadow-2xl space-y-4">

            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold"><?= isset($editData) ? 'Edit Card' : 'Add New Card' ?></h3>
                <a href="mycard.php" class="text-gray-400 hover:text-white">&times;</a>
            </div>

            <input type="text" name="provider" value="<?= $editData['nom'] ?? '' ?>" placeholder="Provider (e.g. Visa)" class="w-full rounded-xl bg-gray-800 border-white/10 p-3" required>
            <input type="number" step="0.01" name="balance" value="<?= $editData['currentSold'] ?? '' ?>" placeholder="Current Balance" class="w-full rounded-xl bg-gray-800 border-white/10 p-3" required>
            <input type="text" name="cardNum" value="<?= $editData['num'] ?? '' ?>" placeholder="Card Number" class="w-full rounded-xl bg-gray-800 border-white/10 p-3" required>
            <input type="number" name="cardLimit" value="<?= $editData['limite'] ?? '' ?>" placeholder="Limit" class="w-full rounded-xl bg-gray-800 border-white/10 p-3">
            <input type="date" name="expiredate" value="<?= $editData['expireDate'] ?? '' ?>" class="w-full rounded-xl bg-gray-800 border-white/10 p-3">

            <select name="status" class="w-full rounded-xl bg-gray-800 border-white/10 p-3">
                <option value="Secondary" <?= (isset($editData) && $editData['statue'] == 'Secondary') ? 'selected' : '' ?>>Secondary</option>
                <option value="Primary" <?= (isset($editData) && $editData['statue'] == 'Primary') ? 'selected' : '' ?>>Primary</option>
            </select>

            <button type="submit" class="w-full rounded-xl bg-indigo-600 py-3 font-semibold hover:bg-indigo-500 transition">
                <?= isset($editData) ? 'Update Card' : 'Add Card' ?>
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
            action="transferMoney.php?sender=userId?target=targetId" method="POST">
            <h2 class="text-xl font-bold text-center dark:text-white">Send to a friend</h2>
            <input type="text" name="receiverMail" placeholder="Receiver email"
                class="w-full p-2 border rounded-lg dark:bg-gray-900 dark:text-white">
            <input type="text" name="amount" placeholder="How much you want to send ?"
                class="w-full p-2 border rounded-lg dark:bg-gray-900 dark:text-white">

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-500 text-white py-2 rounded-lg transition">Send</button>
        </form>
    </div>

    <script>
        const modal = document.getElementById("cardModal");
        const addBtn = document.getElementById("addCardBtn");

        addBtn.addEventListener("click", () => {
            // Clear edit URL param if user just wants to ADD a new card
            if (window.location.search.includes('edit_id')) {
                window.location.href = 'mycard.php';
            }
            modal.classList.remove("hidden");
        });

        // Close modal when clicking outside form
        window.onclick = function(event) {
            if (event.target == modal) {
                window.location.href = 'mycard.php';
            }
        }
         gsap.to("#navbar", {
            duration: 1,
            y: 0,
            opacity: 1,
            ease: "power2.out"
        });
    </script>
</body>

</html>