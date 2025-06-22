<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historical Warrior Battle Arena</title>
    <!-- Favicon -->
    <link rel="icon" href="https://placehold.co/16x16/red/white?text=⚔️" type="image/png">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom styles for elements not easily achievable with direct Tailwind classes, or for fine-tuning */
        body {
            font-family: 'Inter', sans-serif;
        }
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap'); /* Added 900 for extra bold */

        /* Custom scrollbar styles */
        .custom-scrollbar::-webkit-scrollbar {
            width: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #1a202c; /* gray-900 */
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #6b7280; /* gray-500 */
            border-radius: 10px;
            border: 2px solid #1a202c; /* Border around thumb for contrast */
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af; /* gray-400 on hover */
        }

        /* Custom SVG arrow for select dropdown */
        select {
            background-image: url('data:image/svg+xml;utf8,<svg fill="%23cbd5e0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1.25em 1.25em;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        /* Message Box animation - Tailwind's `hidden` applies `display: none`, so we need explicit opacity/transform */
        .battle-message {
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.3s ease-out, transform 0.3s ease-out;
            pointer-events: none; /* Allows clicks to pass through when hidden */
        }
        .battle-message.show {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto; /* Re-enable clicks when shown */
        }

        /* Spinner animation */
        @keyframes spin {
          from { transform: rotate(0deg); }
          to { transform: rotate(360deg); }
        }

        /* Specific VS styling */
        .vs-text {
            font-size: 4rem; /* Larger font for VS */
            font-weight: 900; /* Extra bold */
            color: #ef4444; /* red-500 */
            text-shadow: 0px 0px 10px rgba(239, 68, 68, 0.6); /* Glow effect */
        }

        /* Custom button shadows for a more pronounced lift */
        .btn-shadow-lift {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.4), 0 4px 6px -2px rgba(0, 0, 0, 0.2);
        }
        .btn-shadow-lift:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.6), 0 10px 10px -5px rgba(0, 0, 0, 0.3);
        }
        .btn-shadow-lift:active {
            box-shadow: 0 5px 10px -3px rgba(0, 0, 0, 0.3), 0 2px 4px -2px rgba(0, 0, 0, 0.15);
        }

        /* Main gradient for body, matching example */
        body {
            background: radial-gradient(circle at top left, #1a202c 0%, #0c1015 60%, #05070a 100%);
            background-attachment: fixed; /* Ensures gradient covers full scrollable area */
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center py-8 px-4 sm:px-6 bg-gradient-to-br from-gray-900 to-gray-800 text-gray-100 antialiased">
    <div class="container max-w-7xl mx-auto flex flex-col items-center">
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-red-400 to-red-600 mb-12 drop-shadow-lg text-center leading-tight">
            Historical Warrior Battle Arena
        </h1>

        <div id="message-box" class="hidden battle-message fixed top-4 md:top-8 w-full max-w-sm md:max-w-md py-3 px-6 rounded-xl font-semibold text-center z-50 text-white shadow-lg"></div>

        <div class="relative flex flex-col md:flex-row items-stretch justify-center gap-6 md:gap-10 w-full max-w-6xl mb-12">
            <!-- Warrior 1 Selection Card -->
            <div class="flex flex-col items-center p-6 bg-gray-900 bg-opacity-80 backdrop-filter backdrop-blur-sm rounded-2xl shadow-2xl w-full md:w-1/2 border border-gray-700 hover:border-red-500 transition-all duration-300 transform hover:scale-102">
                <h2 class="text-2xl font-semibold text-red-300 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-red-400" fill="currentColor" viewBox="0 0 24 24"><path d="M20.9 2H19c-.3 0-.6.1-.8.4l-2.1 2.1c-.2.2-.3.5-.3.8v4.5c0 .3.1.6.4.8l2.1 2.1c.2.2.5.3.8.3h1.9c.3 0 .6-.1.8-.4l2.1-2.1c.2-.2.3-.5.3-.8V4.8c0-.3-.1-.6-.4-.8L21.7 2.4c-.2-.2-.5-.3-.8-.4zM3.1 22H5c.3 0 .6-.1.8-.4l2.1-2.1c-.2-.2-.3.5-.3.8V14.5c0-.3-.1-.6-.4-.8l-2.1-2.1c-.2-.2-.5-.3-.8-.3H3.1c-.3 0-.6.1-.8.4l-2.1 2.1c-.2.2-.3.5-.3.8v4.5c0 .3.1.6.4.8l2.1 2.1c.2.2.5.3.8.4zM10 8c-.6 0-1-.4-1-1V2c0-.6.4-1 1-1h4c.6 0 1 .4 1 1v5c0 .6-.4 1-1 1h-4zm0 8c-.6 0-1 .4-1 1v5c0 .6.4 1 1 1h4c.6 0 1-.4 1-1v-5c0-.6-.4-1-1-1h-4z"/></svg>
                    Warrior 1
                </h2>
                <select id="warrior1-select" class="w-full p-3 rounded-lg bg-gray-700 border border-gray-600 text-gray-200 focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-200 cursor-pointer">
                    <option value="" disabled selected>Select Warrior 1</option>
                    <!-- Options will be populated by JavaScript -->
                </select>
                <div id="warrior1-details" class="mt-4 text-center w-full">
                    <!-- Warrior details will be displayed here -->
                </div>
            </div>

            <!-- VS Element -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-gray-900 rounded-full p-4 border-4 border-red-500 flex items-center justify-center z-10 w-20 h-20 sm:w-28 sm:h-28">
                <span class="vs-text">VS</span>
            </div>

            <!-- Warrior 2 Selection Card -->
            <div class="flex flex-col items-center p-6 bg-gray-900 bg-opacity-80 backdrop-filter backdrop-blur-sm rounded-2xl shadow-2xl w-full md:w-1/2 border border-gray-700 hover:border-red-500 transition-all duration-300 transform hover:scale-102">
                <h2 class="text-2xl font-semibold text-red-300 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-red-400" fill="currentColor" viewBox="0 0 24 24"><path d="M20.9 2H19c-.3 0-.6.1-.8.4l-2.1 2.1c-.2.2-.3.5-.3.8v4.5c0 .3.1.6.4.8l2.1 2.1c.2.2.5.3.8.3h1.9c.3 0 .6-.1.8-.4l2.1-2.1c.2-.2.3-.5.3-.8V4.8c0-.3-.1-.6-.4-.8L21.7 2.4c-.2-.2-.5-.3-.8-.4zM3.1 22H5c.3 0 .6-.1.8-.4l2.1-2.1c-.2-.2-.3.5-.3.8V14.5c0-.3-.1-.6-.4-.8l-2.1-2.1c-.2-.2-.5-.3-.8-.3H3.1c-.3 0-.6.1-.8.4l-2.1 2.1c-.2.2-.3.5-.3.8v4.5c0 .3.1.6.4.8l2.1 2.1c.2.2.5.3.8.4zM10 8c-.6 0-1-.4-1-1V2c0-.6.4-1 1-1h4c.6 0 1 .4 1 1v5c0 .6-.4 1-1 1h-4zm0 8c-.6 0-1 .4-1 1v5c0 .6.4 1 1 1h4c.6 0 1-.4 1-1v-5c0-.6-.4-1-1-1h-4z"/></svg>
                    Warrior 2
                </h2>
                <select id="warrior2-select" class="w-full p-3 rounded-lg bg-gray-700 border border-gray-600 text-gray-200 focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-200 cursor-pointer">
                    <option value="" disabled selected>Select Warrior 2</option>
                    <!-- Options will be populated by JavaScript -->
                </select>
                <div id="warrior2-details" class="mt-4 text-center w-full">
                    <!-- Warrior details will be displayed here -->
                </div>
            </div>
        </div>

        <!-- Battle Controls -->
        <div class="flex flex-wrap justify-center gap-6 mb-12">
            <button id="simulate-button" class="flex items-center justify-center px-8 py-4 bg-gradient-to-r from-red-600 to-red-800 text-white font-extrabold rounded-full shadow-lg btn-shadow-lift hover:from-red-700 hover:to-red-900 transition-all duration-300 transform hover:-translate-y-1 active:translate-y-0 disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none">
                <span id="simulate-spinner" class="hidden animate-spin h-6 w-6 text-white mr-3 -ml-1"></span>
                <svg id="simulate-play-icon" class="w-7 h-7 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                Simulate Battle (x100)
            </button>
            <button id="reset-button" class="flex items-center justify-center px-8 py-4 bg-gradient-to-r from-gray-600 to-gray-800 text-white font-extrabold rounded-full shadow-lg btn-shadow-lift hover:from-gray-700 hover:to-gray-900 transition-all duration-300 transform hover:-translate-y-1 active:translate-y-0 disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none">
                <svg class="w-7 h-7 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8c0-4.08-3.05-7.44-7-7.93V4z"/></svg>
                Reset
            </button>
        </div>

        <!-- Battle Log and Summary -->
        <div id="battle-results" class="bg-gray-900 bg-opacity-80 backdrop-filter backdrop-blur-sm rounded-2xl shadow-2xl p-6 w-full max-w-5xl hidden border border-gray-700">
            <h2 class="text-2xl font-semibold text-red-300 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-red-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                Battle Details
            </h2>

            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Play-by-Play Log -->
                <div class="flex-1">
                    <h3 class="text-xl font-semibold text-gray-200 mb-3 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-red-400" fill="currentColor" viewBox="0 0 24 24"><path d="M20.9 2H19c-.3 0-.6.1-.8.4l-2.1 2.1c-.2.2-.3.5-.3.8v4.5c0 .3.1.6.4.8l2.1 2.1c.2.2.5.3.8.3h1.9c.3 0 .6-.1.8-.4l2.1-2.1c.2-.2.3-.5.3-.8V4.8c0-.3-.1-.6-.4-.8L21.7 2.4c-.2-.2-.5-.3-.8-.4zM3.1 22H5c.3 0 .6-.1.8-.4l2.1-2.1c-.2-.2-.3.5-.3.8V14.5c0-.3-.1-.6-.4-.8l-2.1-2.1c-.2-.2-.5-.3-.8-.3H3.1c-.3 0-.6.1-.8.4l-2.1 2.1c-.2.2-.3.5-.3.8v4.5c0 .3.1.6.4.8l2.1 2.1c.2.2.5.3.8.4zM10 8c-.6 0-1-.4-1-1V2c0-.6.4-1 1-1h4c.6 0 1 .4 1 1v5c0 .6-.4 1-1 1h-4zm0 8c-.6 0-1 .4-1 1v5c0 .6.4 1 1 1h4c.6 0 1-.4 1-1v-5c0-.6-.4-1-1-1h-4z"/></svg>
                        Play-by-Play (First Simulation)
                    </h3>
                    <div id="battle-log" class="bg-gray-800 border border-gray-700 rounded-lg p-4 h-64 overflow-y-auto text-sm text-gray-300 custom-scrollbar">
                        <p class="text-gray-500">Battle log will appear here after simulation.</p>
                    </div>
                </div>

                <!-- Battle Summary -->
                <div class="flex-1 bg-gray-800 border border-gray-700 rounded-lg p-4">
                    <h3 class="text-xl font-semibold text-gray-200 mb-3 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-red-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                        Tournament Summary (100 Simulations)
                    </h3>
                    <p id="overall-winner" class="text-lg font-extrabold text-green-400 mb-2">
                        <svg class="w-7 h-7 inline-block mr-2 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <!-- Overall winner will be displayed here -->
                    </p>
                    <p id="warrior1-wins" class="text-md text-gray-300"></p>
                    <p id="warrior2-wins" class="text-md text-gray-300 mb-3"></p>
                    <p class="text-md text-gray-300 mt-4 font-semibold">Weapon Effectiveness:</p>
                    <p id="weapon-stats-message" class="text-sm text-gray-400"></p>
                    <div class="mt-2 text-sm text-gray-400">
                        <p>Melee Kills: <span id="melee-kills" class="font-bold text-red-400"></span></p>
                        <p>Mid-Range Kills: <span class="font-bold text-red-400" id="midrange-kills"></span></p>
                        <p>Long-Range Kills: <span class="font-bold text-red-400" id="longrange-kills"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data for historical warriors with their weapons and stats
        const warriorsData = [
            {
                name: "Achilles",
                description: "Legendary Greek hero of the Trojan War.",
                imageUrl: "achilles.jpg",
                weapons: {
                    melee: { name: "Xiphos (short sword)", damage: { min: 12, max: 18 }, hitChance: 0.85 },
                    midRange: { name: "Dory (spear)", damage: { min: 9, max: 15 }, hitChance: 0.75 },
                    longRange: { name: "Toxon (bow)", damage: { min: 6, max: 12 }, hitChance: 0.6 }
                },
                hp: 100,
                weaponSpeed: 1.05, // Slight edge in attack frequency/damage
                tactics: 1.05,     // Slight increase to hit chance/criticals
                healthFactor: 1.1  // A bit tougher
            },
            {
                name: "Spartacus",
                description: "Thracian gladiator and military leader.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Spartacus",
                weapons: {
                    melee: { name: "Gladius (sword)", damage: { min: 11, max: 17 }, hitChance: 0.8 },
                    midRange: { name: "Trident", damage: { min: 8, max: 14 }, hitChance: 0.7 },
                    longRange: { name: "Retiarius Net", damage: { min: 5, max: 10 }, hitChance: 0.55 }
                },
                hp: 100,
                weaponSpeed: 1.0,
                tactics: 1.0,
                healthFactor: 1.0
            },
            {
                name: "Leonidas",
                description: "King of Sparta, leader at the Battle of Thermopylae.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Leonidas",
                weapons: {
                    melee: { name: "Dory (spear)", damage: { min: 13, max: 19 }, hitChance: 0.88 },
                    midRange: { name: "Xiphos (short sword)", damage: { min: 10, max: 16 }, hitChance: 0.78 },
                    longRange: { name: "Javelin", damage: { min: 7, max: 13 }, hitChance: 0.62 }
                },
                hp: 100,
                weaponSpeed: 1.05,
                tactics: 1.1,
                healthFactor: 1.1
            },
            {
                name: "Alexander the Great",
                description: "King of Macedon, conqueror of the Persian Empire.",
                imageUrl: "alexander.webp",
                weapons: {
                    melee: { name: "Sarissa (pike)", damage: { min: 14, max: 20 }, hitChance: 0.9 },
                    midRange: { name: "Kopis (sword)", damage: { min: 11, max: 17 }, hitChance: 0.8 },
                    longRange: { name: "Composite Bow", damage: { min: 8, max: 14 }, hitChance: 0.65 }
                },
                hp: 100,
                weaponSpeed: 1.1,
                tactics: 1.15,
                healthFactor: 1.05
            },
            {
                name: "Julius Caesar",
                description: "Roman general and statesman.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Caesar",
                weapons: {
                    melee: { name: "Gladius (sword)", damage: { min: 10, max: 16 }, hitChance: 0.78 },
                    midRange: { name: "Pilum (javelin)", damage: { min: 9, max: 15 }, hitChance: 0.72 },
                    longRange: { name: "Scorpio (ballista - simplified)", damage: { min: 7, max: 13 }, hitChance: 0.6 }
                },
                hp: 100,
                weaponSpeed: 1.0,
                tactics: 1.1,
                healthFactor: 1.0
            },
            {
                name: "Attila the Hun",
                description: "Ruler of the Huns, Scourge of God.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Attila",
                weapons: {
                    melee: { name: "Hunnish Sword", damage: { min: 13, max: 19 }, hitChance: 0.85 },
                    midRange: { name: "Lasso", damage: { min: 8, max: 13 }, hitChance: 0.65 },
                    longRange: { name: "Hunnish Composite Bow", damage: { min: 10, max: 16 }, hitChance: 0.75 }
                },
                hp: 100,
                weaponSpeed: 1.08,
                tactics: 1.05,
                healthFactor: 1.05
            },
            {
                name: "Genghis Khan",
                description: "Founder and first Great Khan of the Mongol Empire.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Genghis",
                weapons: {
                    melee: { name: "Dao (sabre)", damage: { min: 14, max: 20 }, hitChance: 0.9 },
                    midRange: { name: "Lance", damage: { min: 10, max: 16 }, hitChance: 0.78 },
                    longRange: { name: "Mongol Composite Bow", damage: { min: 11, max: 17 }, hitChance: 0.8 }
                },
                hp: 100,
                weaponSpeed: 1.1,
                tactics: 1.15,
                healthFactor: 1.05
            },
            {
                name: "Saladin",
                description: "First Sultan of Egypt and Syria, led Islamic forces against Crusaders.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Saladin",
                weapons: {
                    melee: { name: "Scimitar", damage: { min: 12, max: 18 }, hitChance: 0.85 },
                    midRange: { name: "Spear", damage: { min: 9, max: 15 }, hitChance: 0.75 },
                    longRange: { name: "Recurve Bow", damage: { min: 8, max: 14 }, hitChance: 0.68 }
                },
                hp: 100,
                weaponSpeed: 1.03,
                tactics: 1.08,
                healthFactor: 1.0
            },
            {
                name: "Richard the Lionheart",
                description: "King of England, crusader.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Richard",
                weapons: {
                    melee: { name: "Longsword", damage: { min: 13, max: 19 }, hitChance: 0.88 },
                    midRange: { name: "Lance", damage: { min: 10, max: 16 }, hitChance: 0.78 },
                    longRange: { name: "Crossbow", damage: { min: 9, max: 15 }, hitChance: 0.7 }
                },
                hp: 100,
                weaponSpeed: 1.05,
                tactics: 1.08,
                healthFactor: 1.05
            },
            {
                name: "William the Conqueror",
                description: "First Norman King of England.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=William C.",
                weapons: {
                    melee: { name: "Norman Sword", damage: { min: 12, max: 18 }, hitChance: 0.85 },
                    midRange: { name: "Spear", damage: { min: 9, max: 15 }, hitChance: 0.75 },
                    longRange: { name: "Norman Bow", damage: { min: 7, max: 13 }, hitChance: 0.65 }
                },
                hp: 100,
                weaponSpeed: 1.02,
                tactics: 1.05,
                healthFactor: 1.0
            },
            {
                name: "William Wallace",
                description: "Scottish knight and one of the main leaders during the Wars of Scottish Independence.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Wallace",
                weapons: {
                    melee: { name: "Claymore (greatsword)", damage: { min: 15, max: 22 }, hitChance: 0.88 },
                    midRange: { name: "Spear", damage: { min: 10, max: 16 }, hitChance: 0.75 },
                    longRange: { name: "Longbow", damage: { min: 8, max: 14 }, hitChance: 0.65 }
                },
                hp: 100,
                weaponSpeed: 1.05,
                tactics: 1.1,
                healthFactor: 1.05
            },
            {
                name: "Joan of Arc",
                description: "French peasant girl who led the French army to several important victories.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Joan",
                weapons: {
                    melee: { name: "Arming Sword", damage: { min: 10, max: 16 }, hitChance: 0.75 },
                    midRange: { name: "Lance", damage: { min: 8, max: 14 }, hitChance: 0.68 },
                    longRange: { name: "Longbow", damage: { min: 7, max: 13 }, hitChance: 0.6 }
                },
                hp: 100,
                weaponSpeed: 1.0,
                tactics: 1.05,
                healthFactor: 0.98
            },
            {
                name: "Miyamoto Musashi",
                description: "Legendary Japanese swordsman, author of The Book of Five Rings.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Musashi",
                weapons: {
                    melee: { name: "Katana (Daisho)", damage: { min: 15, max: 21 }, hitChance: 0.92 },
                    midRange: { name: "Wakizashi (short sword)", damage: { min: 10, max: 16 }, hitChance: 0.82 },
                    longRange: { name: "Bo Staff", damage: { min: 7, max: 13 }, hitChance: 0.65 }
                },
                hp: 100,
                weaponSpeed: 1.15,
                tactics: 1.18,
                healthFactor: 1.0
            },
            {
                name: "Oda Nobunaga",
                description: "Powerful Japanese daimyo, one of the 'Great Unifiers'.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Nobunaga",
                weapons: {
                    melee: { name: "Nodachi (great sword)", damage: { min: 13, max: 19 }, hitChance: 0.85 },
                    midRange: { name: "Yari (spear)", damage: { min: 10, max: 16 }, hitChance: 0.75 },
                    longRange: { name: "Tanegashima (arquebus)", damage: { min: 11, max: 18 }, hitChance: 0.7 } // Early firearm
                },
                hp: 100,
                weaponSpeed: 1.0,
                tactics: 1.1,
                healthFactor: 1.0
            },
            {
                name: "Date Masamune",
                description: "One-Eyed Dragon of Oshu, Japanese daimyo.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Masamune",
                weapons: {
                    melee: { name: "Katana", damage: { min: 12, max: 18 }, hitChance: 0.85 },
                    midRange: { name: "Yari (spear)", damage: { min: 9, max: 15 }, hitChance: 0.75 },
                    longRange: { name: "Bow", damage: { min: 7, max: 13 }, hitChance: 0.6 }
                },
                hp: 100,
                weaponSpeed: 1.03,
                tactics: 1.05,
                healthFactor: 1.0
            },
            {
                name: "Sun Tzu",
                description: "Ancient Chinese military strategist, author of The Art of War.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Sun Tzu",
                weapons: {
                    melee: { name: "Jian (straight sword)", damage: { min: 8, max: 14 }, hitChance: 0.7 },
                    midRange: { name: "Qiang (spear)", damage: { min: 7, max: 13 }, hitChance: 0.65 },
                    longRange: { name: "Crossbow", damage: { min: 6, max: 12 }, hitChance: 0.58 }
                },
                hp: 100,
                weaponSpeed: 0.95,
                tactics: 1.2, // Very high tactics due to strategic genius
                healthFactor: 0.9
            },
            {
                name: "Guan Yu",
                description: "Chinese general serving under Liu Bei during the Three Kingdoms period.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Guan Yu",
                weapons: {
                    melee: { name: "Green Dragon Crescent Blade (Guandao)", damage: { min: 16, max: 22 }, hitChance: 0.95 },
                    midRange: { name: "Spear", damage: { min: 10, max: 16 }, hitChance: 0.8 },
                    longRange: { name: "Bow", damage: { min: 8, max: 14 }, hitChance: 0.65 }
                },
                hp: 100,
                weaponSpeed: 1.1,
                tactics: 1.1,
                healthFactor: 1.1
            },
            {
                name: "Lu Bu",
                description: "Formidable warrior from the late Eastern Han dynasty.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Lu Bu",
                weapons: {
                    melee: { name: "Sky Piercer Halberd", damage: { min: 17, max: 23 }, hitChance: 0.96 },
                    midRange: { name: "Javelin", damage: { min: 11, max: 17 }, hitChance: 0.8 },
                    longRange: { name: "Bow", damage: { min: 9, max: 15 }, hitChance: 0.7 }
                },
                hp: 100,
                weaponSpeed: 1.12,
                tactics: 1.05,
                healthFactor: 1.15
            },
            {
                name: "Harald Hardrada",
                description: "King of Norway, often called 'The Last Great Viking'.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Harald",
                weapons: {
                    melee: { name: "Dane Axe", damage: { min: 14, max: 20 }, hitChance: 0.88 },
                    midRange: { name: "Spear", damage: { min: 10, max: 16 }, hitChance: 0.78 },
                    longRange: { name: "Longbow", damage: { min: 7, max: 13 }, hitChance: 0.65 }
                },
                hp: 100,
                weaponSpeed: 1.07,
                tactics: 1.05,
                healthFactor: 1.08
            },
            {
                name: "Eric Bloodaxe",
                description: "Norse King of Norway and twice King of Northumbria.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Eric B.",
                weapons: {
                    melee: { name: "Viking Axe", damage: { min: 13, max: 19 }, hitChance: 0.85 },
                    midRange: { name: "Seax (large knife)", damage: { min: 9, max: 15 }, hitChance: 0.7 },
                    longRange: { name: "Throwing Axe", damage: { min: 6, max: 12 }, hitChance: 0.6 }
                },
                hp: 100,
                weaponSpeed: 1.05,
                tactics: 1.0,
                healthFactor: 1.05
            },
            {
                name: "Ragnar Lothbrok",
                description: "Legendary Norse Viking hero and king.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Ragnar",
                weapons: {
                    melee: { name: "Viking Sword", damage: { min: 12, max: 18 }, hitChance: 0.85 },
                    midRange: { name: "Spear", damage: { min: 9, max: 15 }, hitChance: 0.75 },
                    longRange: { name: "Bow", damage: { min: 7, max: 13 }, hitChance: 0.6 }
                },
                hp: 100,
                weaponSpeed: 1.03,
                tactics: 1.02,
                healthFactor: 1.0
            },
            {
                name: "Boudica",
                description: "Queen of the British Iceni tribe who led an uprising against the Romans.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Boudica",
                weapons: {
                    melee: { name: "Celtic Longsword", damage: { min: 11, max: 17 }, hitChance: 0.8 },
                    midRange: { name: "Spear", damage: { min: 8, max: 14 }, hitChance: 0.7 },
                    longRange: { name: "Sling", damage: { min: 5, max: 10 }, hitChance: 0.55 }
                },
                hp: 100,
                weaponSpeed: 0.98,
                tactics: 1.05,
                healthFactor: 0.95
            },
            {
                name: "Vercingetorix",
                description: "Chieftain of the Arverni tribe, led a revolt against Julius Caesar.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Vercingetorix",
                weapons: {
                    melee: { name: "Gallian Spatha (sword)", damage: { min: 12, max: 18 }, hitChance: 0.82 },
                    midRange: { name: "Lance", damage: { min: 9, max: 15 }, hitChance: 0.72 },
                    longRange: { name: "Javelin", damage: { min: 6, max: 12 }, hitChance: 0.6 }
                },
                hp: 100,
                weaponSpeed: 1.0,
                tactics: 1.0,
                healthFactor: 1.0
            },
            {
                name: "Hannibal Barca",
                description: "Carthaginian general, one of the greatest military commanders in history.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Hannibal",
                weapons: {
                    melee: { name: "Kopis (sword)", damage: { min: 11, max: 17 }, hitChance: 0.8 },
                    midRange: { name: "Spear", damage: { min: 8, max: 14 }, hitChance: 0.7 },
                    longRange: { name: "Sling", damage: { min: 5, max: 10 }, hitChance: 0.55 }
                },
                hp: 100,
                weaponSpeed: 1.0,
                tactics: 1.2, // Very high tactics
                healthFactor: 0.95
            },
            {
                name: "Scipio Africanus",
                description: "Roman general, known for defeating Hannibal at Zama.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Scipio",
                weapons: {
                    melee: { name: "Gladius (sword)", damage: { min: 10, max: 16 }, hitChance: 0.78 },
                    midRange: { name: "Pilum (javelin)", damage: { min: 9, max: 15 }, hitChance: 0.72 },
                    longRange: { name: "Ballista (simplified)", damage: { min: 7, max: 13 }, hitChance: 0.6 }
                },
                hp: 100,
                weaponSpeed: 1.0,
                tactics: 1.15,
                healthFactor: 1.0
            },
            {
                name: "Arminius",
                description: "Germanic chieftain, defeated Roman legions at Teutoburg Forest.",
                imageUrl: "arminius.webp",
                weapons: {
                    melee: { name: "Germanic Sword", damage: { min: 12, max: 18 }, hitChance: 0.83 },
                    midRange: { name: "Framea (short spear)", damage: { min: 9, max: 15 }, hitChance: 0.73 },
                    longRange: { name: "Throwing Axe", damage: { min: 6, max: 12 }, hitChance: 0.6 }
                },
                hp: 100,
                weaponSpeed: 1.02,
                tactics: 1.05,
                healthFactor: 1.0
            },
            {
                name: "Crixus",
                description: "Gallian gladiator and military leader in Spartacus's slave rebellion.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Crixus",
                weapons: {
                    melee: { name: "Sica (curved sword)", damage: { min: 11, max: 17 }, hitChance: 0.8 },
                    midRange: { name: "Net", damage: { min: 7, max: 13 }, hitChance: 0.65 },
                    longRange: { name: "Stone Throw", damage: { min: 4, max: 9 }, hitChance: 0.5 }
                },
                hp: 100,
                weaponSpeed: 0.98,
                tactics: 0.98,
                healthFactor: 1.0
            },
            {
                name: "Alaric I",
                description: "King of the Visigoths, sacked Rome in 410 AD.",
                imageUrl: "alaric.jpg",
                weapons: {
                    melee: { name: "Gothic Spatha (sword)", damage: { min: 12, max: 18 }, hitChance: 0.85 },
                    midRange: { name: "Lance", damage: { min: 9, max: 15 }, hitChance: 0.75 },
                    longRange: { name: "Javelin", damage: { min: 7, max: 13 }, hitChance: 0.6 }
                },
                hp: 100,
                weaponSpeed: 1.0,
                tactics: 1.0,
                healthFactor: 1.0
            },
            {
                name: "Belisarius",
                description: "Byzantine general, key figure in Justinian I's reconquest efforts.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Belisarius",
                weapons: {
                    melee: { name: "Spatha (cavalry sword)", damage: { min: 10, max: 16 }, hitChance: 0.78 },
                    midRange: { name: "Contus (heavy spear)", damage: { min: 9, max: 15 }, hitChance: 0.72 },
                    longRange: { name: "Composite Bow", damage: { min: 7, max: 13 }, hitChance: 0.6 }
                },
                hp: 100,
                weaponSpeed: 1.0,
                tactics: 1.1,
                healthFactor: 1.0
            },
            {
                name: "Charlemagne",
                description: "King of the Franks, unified much of Western and Central Europe.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Charlemagne",
                weapons: {
                    melee: { name: "Frankish Sword (Spatha)", damage: { min: 12, max: 18 }, hitChance: 0.85 },
                    midRange: { name: "Francisca (throwing axe)", damage: { min: 9, max: 15 }, hitChance: 0.75 },
                    longRange: { name: "Spear", damage: { min: 7, max: 13 }, hitChance: 0.6 }
                },
                hp: 100,
                weaponSpeed: 1.0,
                tactics: 1.0,
                healthFactor: 1.0
            },
            {
                name: "El Cid",
                description: "Castilian nobleman and military leader in medieval Spain.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=El Cid",
                weapons: {
                    melee: { name: "Tizona (sword)", damage: { min: 13, max: 19 }, hitChance: 0.88 },
                    midRange: { name: "Lance", damage: { min: 10, max: 16 }, hitChance: 0.78 },
                    longRange: { name: "Javelin", damage: { min: 8, max: 14 }, hitChance: 0.68 }
                },
                hp: 100,
                weaponSpeed: 1.05,
                tactics: 1.08,
                healthFactor: 1.05
            },
            {
                name: "Baybars",
                description: "Mamluk Sultan of Egypt and Syria, defeated Mongols and Crusaders.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Baybars",
                weapons: {
                    melee: { name: "Shamshir (sabre)", damage: { min: 12, max: 18 }, hitChance: 0.85 },
                    midRange: { name: "Spear", damage: { min: 9, max: 15 }, hitChance: 0.75 },
                    longRange: { name: "Mamluk Composite Bow", damage: { min: 10, max: 16 }, hitChance: 0.7 }
                },
                hp: 100,
                weaponSpeed: 1.05,
                tactics: 1.08,
                healthFactor: 1.0
            },
            {
                name: "Tamerlane",
                description: "Turco-Mongol conqueror, founder of the Timurid Empire.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Tamerlane",
                weapons: {
                    melee: { name: "Shamshir (sabre)", damage: { min: 14, max: 20 }, hitChance: 0.9 },
                    midRange: { name: "Composite Bow (mounted)", damage: { min: 11, max: 17 }, hitChance: 0.8 },
                    longRange: { name: "Javelin", damage: { min: 8, max: 14 }, hitChance: 0.65 }
                },
                hp: 100,
                weaponSpeed: 1.08,
                tactics: 1.12,
                healthFactor: 1.05
            },
            {
                name: "Mehmed II",
                description: "Ottoman Sultan, conquered Constantinople.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Mehmed II",
                weapons: {
                    melee: { name: "Kilij (sword)", damage: { min: 12, max: 18 }, hitChance: 0.85 },
                    midRange: { name: "Hand Cannon (simplified)", damage: { min: 10, max: 16 }, hitChance: 0.72 },
                    longRange: { name: "Ottoman Composite Bow", damage: { min: 9, max: 15 }, hitChance: 0.68 }
                },
                hp: 100,
                weaponSpeed: 1.0,
                tactics: 1.05,
                healthFactor: 1.0
            },
            {
                name: "Vlad the Impaler",
                description: "Voivode of Wallachia, inspiration for Dracula.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Vlad",
                weapons: {
                    melee: { name: "Longsword", damage: { min: 13, max: 19 }, hitChance: 0.88 },
                    midRange: { name: "Lance", damage: { min: 10, max: 16 }, hitChance: 0.78 },
                    longRange: { name: "Javelin", damage: { min: 8, max: 14 }, hitChance: 0.65 }
                },
                hp: 100,
                weaponSpeed: 1.03,
                tactics: 1.05,
                healthFactor: 1.05
            },
            {
                name: "Jan Zizka",
                description: "Hussite general, undefeated in battle.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Jan Zizka",
                weapons: {
                    melee: { name: "Flail", damage: { min: 14, max: 20 }, hitChance: 0.85 },
                    midRange: { name: "War Hammer", damage: { min: 11, max: 17 }, hitChance: 0.75 },
                    longRange: { name: "Hussite Cannon (simplified)", damage: { min: 12, max: 18 }, hitChance: 0.7 }
                },
                hp: 100,
                weaponSpeed: 1.0,
                tactics: 1.15,
                healthFactor: 1.08
            },
            {
                name: "Skanderbeg",
                description: "Albanian nobleman and military commander who led a rebellion against the Ottoman Empire.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Skanderbeg",
                weapons: {
                    melee: { name: "Scimitar", damage: { min: 13, max: 19 }, hitChance: 0.88 },
                    midRange: { name: "Lance", damage: { min: 10, max: 16 }, hitChance: 0.78 },
                    longRange: { name: "Crossbow", damage: { min: 9, max: 15 }, hitChance: 0.7 }
                },
                hp: 100,
                weaponSpeed: 1.05,
                tactics: 1.08,
                healthFactor: 1.05
            },
            {
                name: "Edward, the Black Prince",
                description: "English prince, one of the most successful English commanders in the Hundred Years' War.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Black Prince",
                weapons: {
                    melee: { name: "Longsword", damage: { min: 13, max: 19 }, hitChance: 0.88 },
                    midRange: { name: "Poleaxe", damage: { min: 10, max: 16 }, hitChance: 0.78 },
                    longRange: { name: "English Longbow", damage: { min: 9, max: 15 }, hitChance: 0.75 }
                },
                hp: 100,
                weaponSpeed: 1.05,
                tactics: 1.1,
                healthFactor: 1.05
            },
            {
                name: "Hector",
                description: "Greatest warrior of Troy, hero of the Trojan War.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Hector",
                weapons: {
                    melee: { name: "Sword", damage: { min: 12, max: 18 }, hitChance: 0.85 },
                    midRange: { name: "Spear", damage: { min: 9, max: 15 }, hitChance: 0.75 },
                    longRange: { name: "Bow", damage: { min: 6, max: 12 }, hitChance: 0.6 }
                },
                hp: 100,
                weaponSpeed: 1.02,
                tactics: 1.05,
                healthFactor: 1.05
            },
            {
                name: "King Arthur",
                description: "Legendary British leader who defended Britain against Saxon invaders.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=King Arthur",
                weapons: {
                    melee: { name: "Excalibur (sword)", damage: { min: 14, max: 20 }, hitChance: 0.9 },
                    midRange: { name: "Lance", damage: { min: 11, max: 17 }, hitChance: 0.8 },
                    longRange: { name: "Longbow", damage: { min: 8, max: 14 }, hitChance: 0.65 }
                },
                hp: 100,
                weaponSpeed: 1.05,
                tactics: 1.08,
                healthFactor: 1.05
            },
            {
                name: "Robin Hood",
                description: "Legendary outlaw hero in English folklore, skilled archer.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Robin Hood",
                weapons: {
                    melee: { name: "Quarterstaff", damage: { min: 8, max: 14 }, hitChance: 0.7 },
                    midRange: { name: "Short Sword", damage: { min: 7, max: 13 }, hitChance: 0.65 },
                    longRange: { name: "Longbow", damage: { min: 10, max: 16 }, hitChance: 0.8 }
                },
                hp: 100,
                weaponSpeed: 1.0,
                tactics: 1.1,
                healthFactor: 0.95
            },
            {
                name: "Gilgamesh",
                description: "Legendary king of Uruk, hero of the Epic of Gilgamesh.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Gilgamesh",
                weapons: {
                    melee: { name: "Axe", damage: { min: 15, max: 21 }, hitChance: 0.92 },
                    midRange: { name: "Spear", damage: { min: 12, max: 18 }, hitChance: 0.82 },
                    longRange: { name: "Sling", damage: { min: 7, max: 13 }, hitChance: 0.6 }
                },
                hp: 100,
                weaponSpeed: 1.08,
                tactics: 1.05,
                healthFactor: 1.1
            },
            {
                name: "Shaka Zulu",
                description: "Influential monarch of the Zulu Kingdom.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Shaka Zulu",
                weapons: {
                    melee: { name: "Iklwa (short stabbing spear)", damage: { min: 14, max: 20 }, hitChance: 0.9 },
                    midRange: { name: "Assegai (throwing spear)", damage: { min: 10, max: 16 }, hitChance: 0.78 },
                    longRange: { name: "Knobkerrie (club)", damage: { min: 7, max: 13 }, hitChance: 0.6 }
                },
                hp: 100,
                weaponSpeed: 1.07,
                tactics: 1.08,
                healthFactor: 1.05
            },
            {
                name: "Xerxes I",
                description: "King of the Achaemenid Empire, fought against the Greeks.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Xerxes",
                weapons: {
                    melee: { name: "Acinaces (Persian sword)", damage: { min: 10, max: 16 }, hitChance: 0.75 },
                    midRange: { name: "Spear", damage: { min: 8, max: 14 }, hitChance: 0.68 },
                    longRange: { name: "Persian Bow", damage: { min: 7, max: 13 }, hitChance: 0.6 }
                },
                hp: 100,
                weaponSpeed: 0.95,
                tactics: 1.0,
                healthFactor: 1.0
            },
            {
                name: "Minamoto no Yoshitsune",
                description: "Japanese general of the Minamoto clan, skilled samurai.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Yoshitsune",
                weapons: {
                    melee: { name: "Katana", damage: { min: 13, max: 19 }, hitChance: 0.88 },
                    midRange: { name: "Yari (spear)", damage: { min: 10, max: 16 }, hitChance: 0.78 },
                    longRange: { name: "Yumi (longbow)", damage: { min: 9, max: 15 }, hitChance: 0.7 }
                },
                hp: 100,
                weaponSpeed: 1.07,
                tactics: 1.08,
                healthFactor: 1.0
            },
            {
                name: "Sanada Yukimura",
                description: "Japanese samurai warrior, known for his bravery and tactical skill.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Yukimura",
                weapons: {
                    melee: { name: "Jumonji Yari (cross-shaped spear)", damage: { min: 14, max: 20 }, hitChance: 0.9 },
                    midRange: { name: "Katana", damage: { min: 11, max: 17 }, hitChance: 0.8 },
                    longRange: { name: "Teppo (matchlock gun)", damage: { min: 10, max: 16 }, hitChance: 0.7 }
                },
                hp: 100,
                weaponSpeed: 1.05,
                tactics: 1.1,
                healthFactor: 1.0
            },
            {
                name: "Hattori Hanzo",
                description: "Japanese samurai and ninja, served the Tokugawa clan.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Hanzo",
                weapons: {
                    melee: { name: "Katana", damage: { min: 12, max: 18 }, hitChance: 0.87 },
                    midRange: { name: "Ninjato (straight sword)", damage: { min: 9, max: 15 }, hitChance: 0.77 },
                    longRange: { name: "Shuriken", damage: { min: 5, max: 10 }, hitChance: 0.65 }
                },
                hp: 100,
                weaponSpeed: 1.08,
                tactics: 1.12,
                healthFactor: 0.98
            },
            {
                name: "Zhuge Liang",
                description: "Chancellor of Shu Han during the Three Kingdoms period, brilliant strategist.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Zhuge",
                weapons: {
                    melee: { name: "Sword", damage: { min: 8, max: 14 }, hitChance: 0.7 },
                    midRange: { name: "Feather Fan (as improvised weapon)", damage: { min: 3, max: 7 }, hitChance: 0.4 },
                    longRange: { name: "Repeater Crossbow (simplified)", damage: { min: 9, max: 15 }, hitChance: 0.7 }
                },
                hp: 100,
                weaponSpeed: 0.9,
                tactics: 1.25, // Extremely high tactics
                healthFactor: 0.9
            },
            {
                name: "Cao Cao",
                description: "Warlord who rose to power during the late Eastern Han dynasty, laid foundation for Wei.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Cao Cao",
                weapons: {
                    melee: { name: "Dao (sabre)", damage: { min: 11, max: 17 }, hitChance: 0.8 },
                    midRange: { name: "Spear", damage: { min: 8, max: 14 }, hitChance: 0.7 },
                    longRange: { name: "Crossbow", damage: { min: 7, max: 13 }, hitChance: 0.6 }
                },
                hp: 100,
                weaponSpeed: 0.98,
                tactics: 1.1,
                healthFactor: 0.98
            },
            {
                name: "Subutai",
                description: "Chief military strategist of Genghis Khan and Ögedei Khan.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Subutai",
                weapons: {
                    melee: { name: "Mongol Sabre", damage: { min: 13, max: 19 }, hitChance: 0.88 },
                    midRange: { name: "Lance", damage: { min: 10, max: 16 }, hitChance: 0.78 },
                    longRange: { name: "Mongol Composite Bow", damage: { min: 11, max: 17 }, hitChance: 0.8 }
                },
                hp: 100,
                weaponSpeed: 1.1,
                tactics: 1.2,
                healthFactor: 1.05
            },
            {
                name: "Sitting Bull",
                description: "Hunkpapa Lakota leader, led his people during years of resistance against US government policies.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Sitting Bull",
                weapons: {
                    melee: { name: "War Club", damage: { min: 11, max: 17 }, hitChance: 0.8 },
                    midRange: { name: "Tomahawk", damage: { min: 9, max: 15 }, hitChance: 0.7 },
                    longRange: { name: "Hunting Bow", damage: { min: 8, max: 14 }, hitChance: 0.7 }
                },
                hp: 100,
                weaponSpeed: 1.0,
                tactics: 1.05,
                healthFactor: 1.0
            },
            {
                name: "Khalid ibn al-Walid",
                description: "One of the greatest military commanders in Islamic history, 'The Sword of Allah'.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Khalid",
                weapons: {
                    melee: { name: "Sword", damage: { min: 14, max: 20 }, hitChance: 0.9 },
                    midRange: { name: "Lance", damage: { min: 11, max: 17 }, hitChance: 0.8 },
                    longRange: { name: "Bow", damage: { min: 9, max: 15 }, hitChance: 0.7 }
                },
                hp: 100,
                weaponSpeed: 1.1,
                tactics: 1.15,
                healthFactor: 1.05
            },
            {
                name: "Cyrus the Great",
                description: "Founder of the Achaemenid Persian Empire.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Cyrus",
                weapons: {
                    melee: { name: "Acinaces (Persian sword)", damage: { min: 12, max: 18 }, hitChance: 0.85 },
                    midRange: { name: "Javelin", damage: { min: 9, max: 15 }, hitChance: 0.75 },
                    longRange: { name: "Persian Composite Bow", damage: { min: 8, max: 14 }, hitChance: 0.68 }
                },
                hp: 100,
                weaponSpeed: 0.98,
                tactics: 1.1,
                healthFactor: 1.0
            },
            {
                name: "Napoleon Bonaparte",
                description: "French military and political leader who rose to prominence during the French Revolution.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Napoleon",
                weapons: {
                    melee: { name: "Saber", damage: { min: 9, max: 15 }, hitChance: 0.75 },
                    midRange: { name: "Flintlock Pistol", damage: { min: 10, max: 16 }, hitChance: 0.7 },
                    longRange: { name: "Musket", damage: { min: 11, max: 17 }, hitChance: 0.65 }
                },
                hp: 100,
                weaponSpeed: 1.0,
                tactics: 1.2, // High tactical genius
                healthFactor: 0.95
            },
            {
                name: "George Washington",
                description: "Commander of the Continental Army during the American Revolutionary War.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Washington",
                weapons: {
                    melee: { name: "Broadsword", damage: { min: 8, max: 14 }, hitChance: 0.7 },
                    midRange: { name: "Flintlock Pistol", damage: { min: 9, max: 15 }, hitChance: 0.65 },
                    longRange: { name: "Musket", damage: { min: 10, max: 16 }, hitChance: 0.6 }
                },
                hp: 100,
                weaponSpeed: 0.98,
                tactics: 1.05,
                healthFactor: 0.98
            },
            {
                name: "Geronimo",
                description: "Prominent leader and medicine man from the Bedonkohe band of the Apache tribe.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Geronimo",
                weapons: {
                    melee: { name: "Apache Knife", damage: { min: 10, max: 16 }, hitChance: 0.78 },
                    midRange: { name: "Tomahawk", damage: { min: 9, max: 15 }, hitChance: 0.7 },
                    longRange: { name: "Rifle (lever-action)", damage: { min: 12, max: 18 }, hitChance: 0.75 }
                },
                hp: 100,
                weaponSpeed: 1.03,
                tactics: 1.08,
                healthFactor: 1.0
            },
            {
                name: "Sun Ce",
                description: "Warlord who lived during the late Eastern Han dynasty, founder of Wu kingdom.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Sun Ce",
                weapons: {
                    melee: { name: "Broadsword", damage: { min: 12, max: 18 }, hitChance: 0.85 },
                    midRange: { name: "Spear", damage: { min: 9, max: 15 }, hitChance: 0.75 },
                    longRange: { name: "Bow", damage: { min: 7, max: 13 }, hitChance: 0.6 }
                },
                hp: 100,
                weaponSpeed: 1.0,
                tactics: 1.0,
                healthFactor: 1.0
            },
            {
                name: "Cao Ren",
                description: "Military general serving under the warlord Cao Cao during the Three Kingdoms period.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Cao Ren",
                weapons: {
                    melee: { name: "Dao (sabre)", damage: { min: 11, max: 17 }, hitChance: 0.8 },
                    midRange: { name: "Spear", damage: { min: 8, max: 14 }, hitChance: 0.7 },
                    longRange: { name: "Crossbow", damage: { min: 7, max: 13 }, hitChance: 0.6 }
                },
                hp: 100,
                weaponSpeed: 0.98,
                tactics: 1.0,
                healthFactor: 1.0
            },
            {
                name: "Zhou Yu",
                description: "General and strategist serving under the warlord Sun Ce during the late Eastern Han dynasty.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Zhou Yu",
                weapons: {
                    melee: { name: "Sword", damage: { min: 10, max: 16 }, hitChance: 0.75 },
                    midRange: { name: "Spear", damage: { min: 8, max: 14 }, hitChance: 0.68 },
                    longRange: { name: "Bow", damage: { min: 7, max: 13 }, hitChance: 0.6 }
                },
                hp: 100,
                weaponSpeed: 0.95,
                tactics: 1.15,
                healthFactor: 0.95
            },
            {
                name: "Lu Meng",
                description: "General serving under the warlord Sun Quan during the Three Kingdoms period.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Lu Meng",
                weapons: {
                    melee: { name: "Broadsword", damage: { min: 11, max: 17 }, hitChance: 0.8 },
                    midRange: { name: "Spear", damage: { min: 9, max: 15 }, hitChance: 0.7 },
                    longRange: { name: "Crossbow", damage: { min: 7, max: 13 }, hitChance: 0.6 }
                },
                hp: 100,
                weaponSpeed: 1.0,
                tactics: 1.0,
                healthFactor: 1.0
            },
            {
                name: "Zhang Liao",
                description: "Military general serving under the warlord Cao Cao during the Three Kingdoms period.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Zhang Liao",
                weapons: {
                    melee: { name: "Halberd", damage: { min: 13, max: 19 }, hitChance: 0.88 },
                    midRange: { name: "Spear", damage: { min: 10, max: 16 }, hitChance: 0.78 },
                    longRange: { name: "Bow", damage: { min: 8, max: 14 }, hitChance: 0.65 }
                },
                hp: 100,
                weaponSpeed: 1.05,
                tactics: 1.08,
                healthFactor: 1.05
            },
            {
                name: "Gaius Marius",
                description: "Roman general and statesman, reformed the Roman army.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Marius",
                weapons: {
                    melee: { name: "Gladius", damage: { min: 10, max: 16 }, hitChance: 0.78 },
                    midRange: { name: "Pilum (javelin)", damage: { min: 9, max: 15 }, hitChance: 0.72 },
                    longRange: { name: "Sling", damage: { min: 6, max: 12 }, hitChance: 0.6 }
                },
                hp: 100,
                weaponSpeed: 1.0,
                tactics: 1.05,
                healthFactor: 1.0
            },
            {
                name: "Themistocles",
                description: "Athenian politician and general, prominent during the Persian Wars.",
                imageUrl: "https://placehold.co/64x64/2a2a2a/fff?text=Themistocles",
                weapons: {
                    melee: { name: "Xiphos", damage: { min: 9, max: 15 }, hitChance: 0.7 },
                    midRange: { name: "Dory (spear)", damage: { min: 8, max: 14 }, hitChance: 0.65 },
                    longRange: { name: "Javelin", damage: { min: 6, max: 12 }, hitChance: 0.55 }
                },
                hp: 100,
                weaponSpeed: 0.95,
                tactics: 1.1,
                healthFactor: 0.95
            }
        ];

        let selectedWarrior1 = null;
        let selectedWarrior2 = null;
        let isLoading = false;

        // DOM Elements
        const warrior1Select = document.getElementById('warrior1-select');
        const warrior2Select = document.getElementById('warrior2-select');
        const warrior1Details = document.getElementById('warrior1-details');
        const warrior2Details = document.getElementById('warrior2-details');
        const simulateButton = document.getElementById('simulate-button');
        const resetButton = document.getElementById('reset-button');
        const battleLogElement = document.getElementById('battle-log');
        const battleResultsSection = document.getElementById('battle-results');
        const overallWinnerElement = document.getElementById('overall-winner');
        const warrior1WinsElement = document.getElementById('warrior1-wins');
        const warrior2WinsElement = document.getElementById('warrior2-wins');
        const weaponStatsMessageElement = document.getElementById('weapon-stats-message');
        const meleeKillsElement = document.getElementById('melee-kills');
        const midrangeKillsElement = document.getElementById('midrange-kills');
        const longrangeKillsElement = document.getElementById('longrange-kills');
        const simulateSpinner = document.getElementById('simulate-spinner');
        const simulatePlayIcon = document.getElementById('simulate-play-icon');
        const messageBox = document.getElementById('message-box');

        // Function to display messages to the user
        function showMessage(message, type = 'info') {
            messageBox.textContent = message;
            // Remove all specific background and text color classes before adding new ones
            messageBox.classList.remove('hidden', 'bg-red-700', 'bg-green-700', 'bg-yellow-700', 'bg-gray-700', 'text-white', 'text-gray-900');
            messageBox.classList.add('show'); // Add show class for transition

            if (type === 'error') {
                messageBox.classList.add('bg-red-700', 'text-white');
            } else if (type === 'success') {
                messageBox.classList.add('bg-green-700', 'text-white');
            } else if (type === 'warning') {
                messageBox.classList.add('bg-yellow-700', 'text-gray-900'); // Ensure text is visible on yellow
            } else {
                messageBox.classList.add('bg-gray-700', 'text-white');
            }

            setTimeout(() => {
                messageBox.classList.remove('show'); // Trigger hide transition
                // Add event listener to fully hide element after transition completes
                messageBox.addEventListener('transitionend', function handler() {
                    messageBox.classList.add('hidden');
                    messageBox.removeEventListener('transitionend', handler);
                }, { once: true });
            }, 5000);
        }

        // Function to get a random integer within a range
        const getRandomInt = (min, max) => {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min + 1)) + min;
        };

        // Populate warrior dropdowns
        function populateWarriorSelects() {
            // Sort warriorsData alphabetically by name
            warriorsData.sort((a, b) => a.name.localeCompare(b.name));

            // Clear existing options before populating
            warrior1Select.innerHTML = '<option value="" disabled selected>Select Warrior 1</option>';
            warrior2Select.innerHTML = '<option value="" disabled selected>Select Warrior 2</option>';

            warriorsData.forEach(warrior => {
                const option1 = document.createElement('option');
                option1.value = warrior.name;
                option1.textContent = warrior.name;
                warrior1Select.appendChild(option1);

                const option2 = document.createElement('option');
                option2.value = warrior.name;
                option2.textContent = warrior.name;
                warrior2Select.appendChild(option2);
            });
        }

        // Update warrior details display
        function updateWarriorDetails(warrior, element) {
            if (!warrior) {
                element.innerHTML = '';
                return;
            }
            let weaponsHtml = '';
            for (const type in warrior.weapons) {
                const weapon = warrior.weapons[type];
                // Calculate effective damage and hit chance for display
                const effectiveMinDamage = Math.round(weapon.damage.min * warrior.weaponSpeed);
                const effectiveMaxDamage = Math.round(weapon.damage.max * warrior.weaponSpeed);
                const effectiveHitChance = (weapon.hitChance * warrior.tactics * 100).toFixed(0); // Display as percentage

                weaponsHtml += `<p class="text-sm text-gray-400 ml-2">
                    - ${weapon.name} (<span class="font-semibold">${type.charAt(0).toUpperCase() + type.slice(1)}</span>): Damage ${effectiveMinDamage}-${effectiveMaxDamage}, Hit Chance ${effectiveHitChance}%
                </p>`;
            }

            element.innerHTML = `
                <div class="flex flex-col items-center justify-center">
                    <img src="${warrior.imageUrl}" alt="${warrior.name}" class="w-20 h-20 rounded-full object-cover border-2 border-red-500 shadow-md mb-2" onerror="this.onerror=null;this.src='https://placehold.co/64x64/2a2a2a/fff?text=Error';">
                    <p class="text-xl font-bold text-red-200">${warrior.name}</p>
                </div>
                <p class="text-sm text-gray-400">${warrior.description}</p>
                <div class="mt-3 text-left w-full">
                    <p class="font-semibold text-gray-300">Weapons (Effective Stats):</p>
                    ${weaponsHtml}
                    <p class="text-sm text-gray-300 mt-2">Effective HP: ${Math.round(warrior.hp * warrior.healthFactor)}</p>
                    <p class="text-sm text-gray-300">Base HP: ${warrior.hp}</p>
                    <p class="text-sm text-gray-300">Weapon Speed Multiplier: ${warrior.weaponSpeed.toFixed(2)}</p>
                    <p class="text-sm text-gray-300">Tactics Multiplier: ${warrior.tactics.toFixed(2)}</p>
                    <p class="text-sm text-gray-300">Health Factor: ${warrior.healthFactor.toFixed(2)}</p>
                </div>
            `;
        }

        // Handle warrior selection
        function handleWarriorSelect(event, player) {
            const warriorName = event.target.value;
            const warrior = warriorsData.find(w => w.name === warriorName);

            if (player === 1) {
                if (warrior === selectedWarrior2) {
                    showMessage("Warrior 1 cannot be the same as Warrior 2. Please choose a different warrior.", 'error');
                    event.target.value = selectedWarrior1 ? selectedWarrior1.name : ''; // Reset dropdown
                    return;
                }
                selectedWarrior1 = warrior;
                updateWarriorDetails(selectedWarrior1, warrior1Details);
                // Disable selected warrior in other dropdown
                Array.from(warrior2Select.options).forEach(option => {
                    option.disabled = option.value === warriorName;
                });
            } else {
                if (warrior === selectedWarrior1) {
                    showMessage("Warrior 2 cannot be the same as Warrior 1. Please choose a different warrior.", 'error');
                    event.target.value = selectedWarrior2 ? selectedWarrior2.name : ''; // Reset dropdown
                    return;
                }
                selectedWarrior2 = warrior;
                updateWarriorDetails(selectedWarrior2, warrior2Details);
                // Disable selected warrior in other dropdown
                Array.from(warrior1Select.options).forEach(option => {
                    option.disabled = option.value === warriorName;
                });
            }
        }

        // Simulate a single battle between two warriors
        const simulateSingleBattle = (warriorA, warriorB) => {
            let log = [];
            // Deep copy warriors to reset HP for each simulation and apply healthFactor
            let currentWarriorA = JSON.parse(JSON.stringify(warriorA));
            currentWarriorA.currentHp = Math.round(warriorA.hp * warriorA.healthFactor);
            let currentWarriorB = JSON.parse(JSON.stringify(warriorB));
            currentWarriorB.currentHp = Math.round(warriorB.hp * warriorB.healthFactor);

            let turn = 1;
            let winner = null;
            let weaponOfFinalBlow = null;

            // Helper to log actions
            const logAction = (message) => {
                log.push(message);
            };

            // Max 100 turns to prevent infinite loops (arbitrary but common in simulations)
            while (currentWarriorA.currentHp > 0 && currentWarriorB.currentHp > 0 && turn < 100) {
                logAction(`--- Turn ${turn} ---`);

                // Determine attacker and defender
                const attacker = turn % 2 === 1 ? currentWarriorA : currentWarriorB;
                const defender = turn % 2 === 1 ? currentWarriorB : currentWarriorA;

                // Randomly choose a weapon type
                const weaponTypes = ['melee', 'midRange', 'longRange'];
                const chosenWeaponType = weaponTypes[getRandomInt(0, weaponTypes.length - 1)];
                const weapon = attacker.weapons[chosenWeaponType];

                // Calculate effective hit chance and damage using warrior's stats
                const effectiveHitChance = weapon.hitChance * attacker.tactics;
                const minDamage = Math.round(weapon.damage.min * attacker.weaponSpeed);
                const maxDamage = Math.round(weapon.damage.max * attacker.weaponSpeed);


                logAction(`${attacker.name} attempts to attack ${defender.name} with their ${weapon.name} (${chosenWeaponType} weapon).`);

                // Check for hit
                if (Math.random() < effectiveHitChance) {
                    const damageDealt = getRandomInt(minDamage, maxDamage);
                    defender.currentHp -= damageDealt;
                    logAction(`${attacker.name}'s ${weapon.name} hits ${defender.name} for ${damageDealt} damage! ${defender.name} HP: ${Math.max(0, defender.currentHp)}`);

                    // Check if defender is defeated
                    if (defender.currentHp <= 0) {
                        winner = attacker.name;
                        weaponOfFinalBlow = chosenWeaponType;
                        logAction(`${defender.name} has been defeated! ${winner} wins!`);
                        break;
                    }
                } else {
                    logAction(`${attacker.name}'s attack with ${weapon.name} misses!`);
                }
                turn++;
            }

            if (!winner) { // If battle ended due to turn limit
                if (currentWarriorA.currentHp > currentWarriorB.currentHp) {
                    winner = currentWarriorA.name;
                    logAction(`Turn limit reached. ${currentWarriorA.name} wins with more HP.`);
                } else if (currentWarriorB.currentHp > currentWarriorA.currentHp) {
                    winner = currentWarriorB.name;
                    logAction(`Turn limit reached. ${currentWarriorB.name} wins with more HP.`);
                } else {
                    winner = "Draw";
                    logAction(`Turn limit reached. It's a draw!`);
                }
            }

            return { log, winner, weaponOfFinalBlow };
        };

        // Simulate 100 battles
        async function simulateHundredBattles() {
            if (!selectedWarrior1 || !selectedWarrior2) {
                showMessage("Please select two warriors to battle!", 'error');
                return;
            }

            isLoading = true;
            simulateButton.disabled = true;
            resetButton.disabled = true;
            simulateSpinner.classList.remove('hidden');
            simulatePlayIcon.classList.add('hidden');
            battleResultsSection.classList.add('hidden'); // Hide previous results

            battleLogElement.innerHTML = '<p class="text-gray-500">Simulating battles...</p>';

            let warrior1Wins = 0;
            let warrior2Wins = 0;
            let weaponKills = { melee: 0, midRange: 0, longRange: 0 };
            let firstBattleLog = [];

            for (let i = 0; i < 100; i++) {
                const result = simulateSingleBattle(selectedWarrior1, selectedWarrior2);

                if (i === 0) {
                    firstBattleLog = result.log; // Store log of the first battle
                }

                if (result.winner === selectedWarrior1.name) {
                    warrior1Wins++;
                    if (result.weaponOfFinalBlow) weaponKills[result.weaponOfFinalBlow]++;
                } else if (result.winner === selectedWarrior2.name) {
                    warrior2Wins++;
                    if (result.weaponOfFinalBlow) weaponKills[result.weaponOfFinalBlow]++;
                }
                // Draws are not counted as wins for either, and don't contribute to weapon kills
            }

            // Determine overall winner
            let overallWinnerText = "It's a draw!";
            if (warrior1Wins > warrior2Wins) {
                overallWinnerText = `${selectedWarrior1.name} wins the overall tournament!`;
            } else if (warrior2Wins > warrior1Wins) {
                overallWinnerText = `${selectedWarrior2.name} wins the overall tournament!`;
            }

            // Determine weapon with most kills
            const maxKills = Math.max(weaponKills.melee, weaponKills.midRange, weaponKills.longRange);
            const topWeapons = Object.keys(weaponKills).filter(
                (key) => weaponKills[key] === maxKills && maxKills > 0
            );

            let weaponStatsMessage = "No decisive weapon contributed to final blows.";
            if (topWeapons.length > 0) {
                weaponStatsMessage = `The weapon type that resulted in the most final blows was: ${topWeapons.map(type => type.charAt(0).toUpperCase() + type.slice(1)).join(' and ')} with ${maxKills} kills.`;
            }

            // Update UI after all simulations are complete
            battleLogElement.innerHTML = firstBattleLog.map((entry, index) =>
                `<p class="${entry.startsWith('--- Turn') ? 'font-bold text-red-400 mt-2' : ''}">${entry}</p>`
            ).join('');
            battleLogElement.scrollTop = battleLogElement.scrollHeight; // Scroll to bottom

            overallWinnerElement.innerHTML = `<svg class="w-7 h-7 inline-block mr-2 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg> ${overallWinnerText}`;
            warrior1WinsElement.innerHTML = `${selectedWarrior1.name} Wins: <span class="font-bold text-red-400">${warrior1Wins}</span>`;
            warrior2WinsElement.innerHTML = `${selectedWarrior2.name} Wins: <span class="font-bold text-red-400">${warrior2Wins}</span>`;
            weaponStatsMessageElement.textContent = weaponStatsMessage;
            meleeKillsElement.textContent = weaponKills.melee;
            midrangeKillsElement.textContent = weaponKills.midRange;
            longrangeKillsElement.textContent = weaponKills.longRange;

            battleResultsSection.classList.remove('hidden'); // Show results section

            isLoading = false;
            simulateButton.disabled = false;
            resetButton.disabled = false;
            simulateSpinner.classList.add('hidden');
            simulatePlayIcon.classList.remove('hidden');
        }

        // Reset function
        function resetSelection() {
            selectedWarrior1 = null;
            selectedWarrior2 = null;
            warrior1Select.value = '';
            warrior2Select.value = '';
            updateWarriorDetails(null, warrior1Details);
            updateWarriorDetails(null, warrior2Details);
            battleLogElement.innerHTML = '<p class="text-gray-500">Battle log will appear here after simulation.</p>';
            battleResultsSection.classList.add('hidden');
            messageBox.classList.remove('show');
            messageBox.classList.add('hidden'); // Hide any messages instantly on reset
            // Re-enable all options in both dropdowns
            Array.from(warrior1Select.options).forEach(option => { option.disabled = false; });
            Array.from(warrior2Select.options).forEach(option => { option.disabled = false; });
        }

        // Event Listeners
        document.addEventListener('DOMContentLoaded', () => {
            populateWarriorSelects();
            warrior1Select.addEventListener('change', (e) => handleWarriorSelect(e, 1));
            warrior2Select.addEventListener('change', (e) => handleWarriorSelect(e, 2));
            simulateButton.addEventListener('click', simulateHundredBattles);
            resetButton.addEventListener('click', resetSelection);
        });

    </script>
</body>
</html>
