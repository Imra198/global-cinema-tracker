    <?php include 'header.php'; ?>

    <main class="main-content max-w-7xl mx-auto px-6 py-8">
        <section class="hero-section bg-gray-900 text-white text-center py-20 px-6">
            <div class="max-w-2xl mx-auto">
                <h2 class="text-4xl md:text-5xl font-extrabold mb-4">Binge-Worthy TV Shows: What's Hot Right Now</h2>
                <p class="text-lg opacity-90 mb-6">From gripping dramas to hilarious comedies, explore our selection of trending TV shows that everyone is talking about. Find your next obsession today!</p>

                <a href="#trending-shows" class="inline-block px-8 py-3 bg-violet-600 hover:bg-violet-700 rounded-full text-lg font-semibold transition">Browse Shows</a>
            </div>
        </section>


        <!--Trending TV Shows Section-->
        <img src="https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=1200&auto=format&fit=crop" alt="Cinema Theater" class="w-full h-64 object-cover">
        <section id="trending-shows" class="container mx-auto px-6 py-12">

            <h2 class="text-3xl md:text-5xl font-bold mb-4">Trending TV Shows</h2>

            <!-- Loading State Spinner -->
            <div id="loadingState" class="flex flex-col items-center justify-center py-20">
                <svg class="animate-spin h-12 w-12 text-violet-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>

            <!-- The Empty target grid (hidden initially) -->
            <div id="showGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 hidden">
            </div>
        </section>

    </main>
    <?php include 'footer.php'; ?>
    <script>
        // 2. Fetching Data from TMDB Registry
        const ACCESS_TOKEN = "eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIyZjIyMGM5NWYwNzFlY2M0ZGUxNWNkYWRhMWQ3NzcwYSIsIm5iZiI6MTc4MTUxNjI4MC43NjcsInN1YiI6IjZhMmZjN2Y4YjVkMWRhMmVmNWM0NzViMSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.VTHd4IpgP7cbI2OfZsPwHTB1wXC74MEh3hz2ltAsXEg";
        const showGrid = document.getElementById("showGrid");
        const loadingState = document.getElementById("loadingState");

        async function fetchLiveTVShows() {
            try {
                // Note the URL path change here to "trending/tv/week"
                const response = await fetch("https://api.themoviedb.org/3/trending/tv/week", {
                    method: "GET",
                    headers: {
                        "accept": "application/json",
                        "Authorization": `Bearer ${ACCESS_TOKEN}`
                    }
                });
                if (!response.ok) throw new Error("API request failed");

                const data = await response.json();

                // Loop through array using show.name and show.first_air_date
                showGrid.innerHTML = data.results.map(show => `
                <div class="show-item bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden transform hover:scale-105 transition duration-300">
                    <img src="https://image.tmdb.org/t/p/w500${show.poster_path}" alt="${show.name}" class="w-full h-80 object-cover">
                    <div class="p-4 text-center">
                        <p class="font-bold line-clamp-1 mb-1">${show.name}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">First Aired: ${(show.first_air_date || 'N/A').split('-')[0]}</p>
                        <p class="text-yellow-400 text-lg">★ <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">(${(show.vote_average / 2).toFixed(1)})</span></p>
                    </div>
                </div>
            `).join("");

                // Reveal the content cards
                loadingState.classList.add("hidden");
                showGrid.classList.remove("hidden");

            } catch (error) {
                console.error("Error loading registry data:", error);
                loadingState.innerHTML = `<p class="text-red-500 font-semibold">Failed to fetch dynamic series feeds.</p>`;
            }
        }

        // Initialize immediately when page finishes mounting
        fetchLiveTVShows();
    </script>