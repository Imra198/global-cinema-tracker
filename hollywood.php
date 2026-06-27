<?php include 'header.php'; ?>
<main class="main-content max-w-7xl mx-auto px-6 py-8">
    <h2 class="text-3xl font-bold mb-4">Hollywood: News & Releases</h2>
    <p class="mb-8 text-gray-600 dark:text-gray-400 max-w-3xl">Stay updated with the latest Hollywood news, movie releases, and celebrity gossip. Explore reviews, trailers, and exclusive interviews with your favorite stars.</p>

    <!--Filter Bar-->
    <div class="mb-10 flex justify-start">
        <div class="flex w-full max-w-md">
            <input id="searchInput" type="text" placeholder="Filter Hollywood movies..." class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-l-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-violet-600 transition">
            <button id="searchBtn" class="px-5 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-r-lg font-semibold transition">Filter</button>
        </div>
    </div>


    <!-- Hollywood movie grid -->
    <div id="loadingState" class="flex flex-col items-center justify-center py-20">
        <svg class="animate-spin h-12 w-12 text-violet-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>

    <div id="movieGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 hidden">
    </div>

</main>
<?php include 'footer.php'; ?>

<script>
    // LIVE TMDB API DATA INTEGRATION FOR HOLLYWOOD (English Language Releases)
    const ACCESS_TOKEN = "eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIyZjIyMGM5NWYwNzFlY2M0ZGUxNWNkYWRhMWQ3NzcwYSIsIm5iZiI6MTc4MTUxNjI4MC43NjcsInN1YiI6IjZhMmZjN2Y4YjVkMWRhMmVmNWM0NzViMSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.VTHd4IpgP7cbI2OfZsPwHTB1wXC74MEh3hz2ltAsXEg";

    const movieGrid = document.getElementById("movieGrid");
    const loadingState = document.getElementById("loadingState");
    const searchInput = document.getElementById("searchInput");
    const searchBtn = document.getElementById("searchBtn");

    let fetchedMovies = []; // Stores the raw API data array globally for filtering

    // Reusable layout helper that includes the Watch Trailer trigger link
    function createMovieCard(movie) {
        const releaseYear = (movie.release_date || 'N/A').split('-')[0];
        const rating = (movie.vote_average / 2).toFixed(1);

        return `
            <div class="movie-item flex flex-col justify-between bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden transform hover:scale-105 transition duration-300">
                <div>
                    <img src="https://image.tmdb.org/t/p/w500${movie.poster_path}" alt="${movie.title}" class="w-full h-80 object-cover">
                    <div class="p-4 text-center">
                        <p class="font-bold line-clamp-1 mb-1">${movie.title}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Released: ${releaseYear}</p>
                        <p class="text-yellow-400 text-lg">★ <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">(${rating})</span></p>
                    </div>
                </div>
                <div class="px-4 pb-4">
                    <button onclick="openTrailer(${movie.id}, 'movie')" class="w-full py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-lg font-medium text-sm transition shadow-sm hover:shadow">
                        Watch Trailer
                    </button>
                </div>
            </div>
        `;
    }

    async function fetchHollywoodMovies() {
        try {
            // Discover endpoint filtering for English language films to isolate Hollywood content
            const response = await fetch("https://api.themoviedb.org/3/discover/movie?with_original_language=en&sort_by=popularity.desc", {
                method: "GET",
                headers: {
                    "accept": "application/json",
                    "Authorization": `Bearer ${ACCESS_TOKEN}`
                }
            });
            if (!response.ok) throw new Error("API request failed");

            const data = await response.json();
            fetchedMovies = data.results; // Save to memory for filter actions

            renderMovies(fetchedMovies);

            // Reveal the content cards and clear the spinner
            loadingState.classList.add("hidden");
            movieGrid.classList.remove("hidden");

        } catch (error) {
            console.error("Error loading registry data:", error);
            loadingState.innerHTML = `<p class="text-red-500 font-semibold">Failed to fetch dynamic cinema feeds.</p>`;
        }
    }

    // Render card layout function matching the movies page
    function renderMovies(movieList) {
        // Loop through the movie array and build the grid cards using the helper function
        movieGrid.innerHTML = movieList.map(createMovieCard).join("");
    }

    // 3. Dynamic Search Filter Engine
    function filterMovies() {
        const query = searchInput.value.toLowerCase().trim();
        const filtered = fetchedMovies.filter(movie =>
            movie.title.toLowerCase().includes(query)
        );
        renderMovies(filtered);
    }

    searchBtn.addEventListener("click", filterMovies);
    searchInput.addEventListener("input", filterMovies);

    // Run automatically when the webpage mounts
    fetchHollywoodMovies();
</script>