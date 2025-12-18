<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <title>My Debit Cards</title>
</head>

<body>
    <div class="relative isolate bg-white px-6 py-24 sm:py-32 lg:px-8 dark:bg-gray-900">

        <!-- Background gradient -->
        <div aria-hidden="true"
            class="absolute inset-x-0 -top-3 -z-10 transform-gpu overflow-hidden px-36 blur-3xl">
            <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"
                class="mx-auto aspect-1155/678 w-288.75 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 dark:opacity-20">
            </div>
        </div>

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

        <div class="mx-auto mt-16 grid max-w-lg grid-cols-1 gap-y-6 sm:mt-20 lg:max-w-4xl lg:grid-cols-2">

            <div
                class="rounded-3xl bg-white/60 p-8 ring-1 ring-gray-900/10 dark:bg-white/5 dark:ring-white/10">
                <h3 class="text-lg font-semibold text-indigo-600 dark:text-indigo-400">
                    CIH Bank
                </h3>
                <p class="mt-4 text-3xl font-semibold text-gray-900 dark:text-white">
                    Balance: 4,250 DH
                </p>

                <ul class="mt-6 space-y-2 text-sm text-gray-600 dark:text-gray-300">
                    <li>Card Number: **** **** **** 2345</li>
                    <li>Status: <span class="text-green-600 font-semibold">Primary</span></li>
                </ul>

                <div class="mt-6 flex gap-3">
                    <button
                        class="rounded-md bg-indigo-500 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-400">
                        Edit
                    </button>
                    <button
                        class="rounded-md bg-red-500 px-4 py-2 text-sm font-semibold text-white hover:bg-red-400">
                        Delete
                    </button>
                </div>
            </div>

            <div
                class="rounded-3xl bg-gray-900 p-8 shadow-xl ring-1 ring-gray-900/10 dark:bg-gray-800 dark:ring-white/10">
                <h3 class="text-lg font-semibold text-indigo-400">
                    Banque Populaire
                </h3>
                <p class="mt-4 text-3xl font-semibold text-white">
                    Balance: 1,800 DH
                </p>

                <ul class="mt-6 space-y-2 text-sm text-gray-300">
                    <li>Card Number: **** **** **** 9876</li>
                    <li>Status: Secondary</li>
                </ul>

                <div class="mt-6 flex gap-3">
                    <button
                        class="rounded-md bg-indigo-500 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-400">
                        Set as Primary
                    </button>
                    <button
                        class="rounded-md bg-red-500 px-4 py-2 text-sm font-semibold text-white hover:bg-red-400">
                        Delete
                    </button>
                </div>
            </div>

        </div>

        <!-- Add card button -->
        <div class="mt-16 text-center">
            <a href="add-card.php"
                class="inline-block rounded-md bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow hover:bg-indigo-500">
                + Add New Card
            </a>
        </div>

    </div>
</body>

</html>
