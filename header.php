<?php

// Track current filename to apply active state dynamically to navigation links
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Configures Tailwind CSS manual class-based dark mode switching
        tailwind.config = {
            darkMode: "class",
        }
    </script>
    <title>CineView</title>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans leading-normal tracking-normal transition-colors duration-200">

    <header class="sticky top-0 z-50 bg-white dark:bg-gray-800 shadow-md transition-colors duration-200">
        <div class="flex justify-between items-center px-6 py-4 max-w-7xl mx-auto">
            <h1 class="text-2xl font-extrabold text-gray-800 dark:text-white">CineView</h1>

            <nav class="flex gap-6">
                <a href="index.php" class="<?php echo $current_page == 'index.php' || $current_page == '' ? 'text-violet-600 font-bold border-b-2 border-violet-600' : 'text-gray-700 dark:text-gray-200 hover:text-violet-600 font-semibold transition-colors'; ?>">HOME</a>

                <a href="hollywood.php" class="<?php echo $current_page == 'hollywood.php' ? 'text-violet-600 font-bold border-b-2 border-violet-600' : 'text-gray-700 dark:text-gray-200 hover:text-violet-600 font-semibold transition-colors'; ?>">HOLLYWOOD</a>

                <a href="movies.php" class="<?php echo $current_page == 'movies.php' ? 'text-violet-600 font-bold border-b-2 border-violet-600' : 'text-gray-700 dark:text-gray-200 hover:text-violet-600 font-semibold transition-colors'; ?>">MOVIES</a>

                <a href="tv-shows.php" class="<?php echo $current_page == 'tv-shows.php' ? 'text-violet-600 font-bold border-b-2 border-violet-600' : 'text-gray-700 dark:text-gray-200 hover:text-violet-600 font-semibold transition-colors'; ?>">TV SHOWS</a>
            </nav>


            <div class="flex items-center">
                <button id="themeToggle" class="relative inline-flex h-6 w-11 items-center rounded-full bg-gray-300 dark:bg-violet-600 transition-colors duration-300 focus:outline-none shadow-inner" aria-label="Toggle Dark Mode">
                    <span class="absolute left-1 dark:opacity-0 transition-opacity duration-300 text-xs">☀️</span>
                    <span class="absolute right-1 opacity-0 dark:opacity-100 transition-opacity duration-300 text-xs">🌙</span>
                    <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform duration-300 translate-x-1 dark:translate-x-6"></span>
                </button>
            </div>
        </div>
    </header>