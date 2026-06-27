<?php include "header.php"; ?>
<main class="main-content max-w-7xl mx-auto px-6 py-8">

    <section class="bg-gray-900 text-white text-center py-20 px-6">

        <div class="max-w-2xl mx-auto">
            <h2 class="text-4xl md:text-5xl font-extrabold mb-6 text-center">Trending Now: <span class="text-violet-600">Must-Watch</span> Movies & Shows</h2>
            <p class="text-lg opacity-90 mb-6">Discover the latest hits and timeless classics in our curated selection of movies and TV shows. Stay updated with what's trending and find your next favorite watch!</p>
            <a href="#trending" class="inline-block px-8 py-3 bg-violet-600 hover:bg-violet-700 rounded-full text-lg font-semibold transition transform hover:scale-105">Start Exploring</a>
        </div>
    </section>

    <!--Horizontal Scroll Movie Preview-->
    <section class="max-w-7xl mx-auto px-4 py-12">
        <h3 class="text-2xl md:text-3xl font-bold mb-8 text-center text-gray-800 dark:text-white">Featured Movies Preview</h3>

        <div id="previewContainer" class="flex gap-4 overflow-x-auto pb-6 scroll-smooth snap-x">
            <div class="w-64 h-40 bg-gray-300 dark:bg-gray-700 rounded-xl flex-shrink-0 animate-pulse snap-start"></div>
            <div class="w-64 h-40 bg-gray-300 dark:bg-gray-700 rounded-xl flex-shrink-0 animate-pulse snap-start hidden sm:block"></div>
            <div class="w-64 h-40 bg-gray-300 dark:bg-gray-700 rounded-xl flex-shrink-0 animate-pulse snap-start hidden md:block"></div>
            <div class="w-64 h-40 bg-gray-300 dark:bg-gray-700 rounded-xl flex-shrink-0 animate-pulse snap-start hidden lg:block"></div>
        </div>
    </section>

    <!--Trending Movies Section-->
    <section id="trending" class="container mx-auto px-6 py-12">

        <h2 class="text-4xl md:text-5xl font-extrabold mb-4 text-center tracking-tight leading-tight">Trending Movies</h2>

        <p class="text-lg max-w-3xl mx-auto opacity-90 text-center leading-relaxed mb-6">Discover the latest hits and timeless classics in our curated selection of movies and TV shows. Stay updated with what's trending and find your next favorite watch!</p>

        <div class="mt-4 mb-8 flex justify-center">
            <div class="flex w-full max-w-md">
                <input id="searchInput" type="text" placeholder="Search for movies or TV shows..." class="w-full max-w-md px-4 py-2 border border-gray-300 rounded-lg bg-gray-200 dark:bg-gray-700 dark:text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-violet-600 transition">
                <button id="searchBtn" class="px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-r-lg font-semibold transition">Search</button>

            </div>
        </div>
        <div id="loadingState" class="flex flex-col items-center justify-center py-20">
            <svg class="animate-spin h-12 w-12 text-violet-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-gray-500 dark:text-gray-400 animate-pulse">Connecting to movie registries...</p>
        </div>

        <div class="movie-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-6">
        </div>
    </section>

</main>

<?php include 'footer.php'; ?>
<script>
    // Live TMDB API Data 
    const ACCESS_TOKEN = "eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIyZjIyMGM5NWYwNzFlY2M0ZGUxNWNkYWRhMWQ3NzcwYSIsIm5iZiI6MTc4MTUxNjI4MC43NjcsInN1YiI6IjZhMmZjN2Y4YjVkMWRhMmVmNWM0NzViMSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.VTHd4IpgP7cbI2OfZsPwHTB1wXC74MEh3hz2ltAsXEg";
    const previewContainer = document.getElementById("previewContainer");
    const movieGrid = document.querySelector(".movie-grid");
    const loadingState = document.getElementById("loadingState");

    // Reusable layout helper that includes the Watch Trailer trigger link
    function createMovieCard(movie) {
        const releaseYear = (movie.release_date || 'N/A').split('-')[0];
        const rating = (movie.vote_average / 2).toFixed(1);

        return `
            <div class="movie-item flex flex-col justify-between bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden transform hover:scale-105 transition duration-300" data-title="${movie.title.toLowerCase()}">
                <div>
                    <img src="https://image.tmdb.org/t/p/w500${movie.poster_path}" alt="${movie.title}" class="w-full h-80 object-cover" onerror="this.src='https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=500&auto=format&fit=crop'">
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

    // DYNAMIC HORIZONTAL BANNER COMPONENT (Uses Backdrop Images)
    async function fetchPreviewBanners() {
        try {
            const response = await fetch("https://api.themoviedb.org/3/movie/now_playing?language=en-US&page=1", {
                method: "GET",
                headers: {
                    "accept": "application/json",
                    "Authorization": `Bearer ${ACCESS_TOKEN}`
                }
            });
            if (!response.ok) throw new Error("Preview fetch failed");

            const data = await response.json();

            // Target the top 6 trending movies for wide layout mapping
            const featuredMovies = data.results.slice(0, 6);

            // Overwrites the pulsing skeletons with the real wide movie backdrops
            previewContainer.innerHTML = featuredMovies.map(movie => `
                <img src="https://image.tmdb.org/t/p/w500${movie.backdrop_path}" 
                     class="inline-block w-64 h-40 object-cover flex-shrink-0 rounded-xl shadow-lg hover:scale-105 transition duration-300 snap-start" 
                    alt="${movie.title}"
                    onerror="this.src='https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=500&auto=format&fit=crop'">
            `).join("");

        } catch (error) {
            console.error("Error setting up preview reel:", error);
            previewContainer.innerHTML = `<p class="text-xs text-red-500 text-center w-full py-4">Preview tracks unavailable.</p>`;
        }
    }

    //Declared search elements and implemented functional client-side filtering logic
    const searchInput = document.getElementById("searchInput");
    const searchBtn = document.getElementById("searchBtn");

    function filterMovies() {
        const query = searchInput.value.toLowerCase().trim();
        const items = document.querySelectorAll(".movie-item");
        items.forEach(item => {
            const title = item.dataset.title;
            if (title.includes(query)) {
                item.style.display = "flex";
            } else {
                item.style.display = "none";
            }
        });
    }


    // MAIN DISCOVERY MOVIE GRID COMPONENT (Uses Poster Images)
    async function fetchLiveMovies() {
        try {
            const response = await fetch("https://api.themoviedb.org/3/trending/movie/week", {
                method: "GET",
                headers: {
                    "accept": "application/json",
                    "Authorization": `Bearer ${ACCESS_TOKEN}`
                }
            });

            if (!response.ok) throw new Error("API request failed");
            const data = await response.json();

            // Loop through array elements dynamically painting standard posters
            movieGrid.innerHTML = data.results.map(createMovieCard).join("");

            //Hide loader, reveal movie grid
            loadingState.classList.add("hidden");
            movieGrid.classList.remove("hidden");

        } catch (error) {
            console.error("Error loading registry data:", error);
            loadingState.innerHTML = `<p class="text-red-500 font-semibold">Failed to fetch dynamic cinema feeds.</p>`;
        }
    }

    searchBtn.addEventListener("click", filterMovies);
    searchInput.addEventListener("keyup", filterMovies);

    // Initialize execution runtime for both components in parallel
    fetchPreviewBanners();
    fetchLiveMovies();
</script>