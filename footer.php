<div id="trailerModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="relative w-full max-w-4xl mx-4 aspect-video bg-black rounded-xl overflow-hidden shadow-2xl border border-gray-800 transform scale-95 transition-transform duration-300" id="modalContainer">
        <button id="closeModalBtn" class="absolute top-4 right-4 z-10 w-10 h-10 flex items-center justify-center rounded-full bg-black/60 text-white hover:bg-violet-600 transition shadow">
            ✕
        </button>
        <div id="trailerPlayerContainer" class="w-full h-full">
        </div>
    </div>
</div>

<footer class="bg-gray-900 text-white text-center py-6 mt-16">
    <p>&copy; 2026 CineView. All rights reserved.</p>

</footer>

<script>
    const html = document.documentElement;
    const themeToggle = document.getElementById("themeToggle");
    const trailerModal = document.getElementById('trailerModal');
    const trailerPlayerContainer = document.getElementById('trailerPlayerContainer');
    const modalContainer = document.getElementById('modalContainer');
    const closeModalBtn = document.getElementById('closeModalBtn');

    // Access Token that is used from all pages
    const GLOBAL_TOKEN = "eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIyZjIyMGM5NWYwNzFlY2M0ZGUxNWNkYWRhMWQ3NzcwYSIsIm5iZiI6MTc4MTUxNjI4MC43NjcsInN1YiI6IjZhMmZjN2Y4YjVkMWRhMmVmNWM0NzViMSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.VTHd4IpgP7cbI2OfZsPwHTB1wXC74MEh3hz2ltAsXEg";

    // Sync local storage preferences on window mount
    if (localStorage.theme === "light") {
        html.classList.remove("dark");
    } else if (localStorage.theme === "dark" || !("theme" in localStorage)) {
        html.classList.add("dark");
    }

    themeToggle.onclick = () => {
        const isDark = html.classList.toggle("dark");
        localStorage.theme = isDark ? "dark" : "light";
    };

    async function openTrailer(id, type = 'movie') {
        try {
            //Ping TMDB's video endpoint to retrieve YouTube key references for trailers or clips
            const response = await fetch(`https://api.themoviedb.org/3/${type}/${id}/videos?language=en-US`, {
                method: "GET",
                headers: {
                    "accept": "application/json",
                    "Authorization": `Bearer ${GLOBAL_TOKEN}`
                }
            });
            const data = await response.json();
            // Filter out videos to find a valid YouTube Trailer or Teaser clip
            const trailer = data.results.find(
                vid => vid.site === 'YouTube' &&
                (vid.type === 'Trailer' ||
                    vid.type === 'Teaser'));

            if (!trailer) {
                alert("Apologies! No video clip found for this title.");
                return;
            }

            // Inject the YouTube iframe cleanly with autoplay enabled
            trailerPlayerContainer.innerHTML = `
                <iframe class="w-full h-full" src="https://www.youtube.com/embed/${trailer.key}?autoplay=1&rel=0" 
                        title="YouTube video player" frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        allowfullscreen></iframe>
            `;

            // Animate transition show states
            trailerModal.classList.remove('opacity-0', 'pointer-events-none');
            modalContainer.classList.remove('scale-95');
            modalContainer.classList.add('scale-100');

        } catch (error) {
            console.error("Failed to load trailer track context:", error);
        }
    }

    function closeModal() {
        // Animate out transitions
        trailerModal.classList.add('opacity-0', 'pointer-events-none');
        modalContainer.classList.remove('scale-100');
        modalContainer.classList.add('scale-95');
        // Instantly kill player tracking state to stop audio playing in the background
        trailerPlayerContainer.innerHTML = "";
    }

    closeModalBtn.addEventListener('click', closeModal);
    // Let users click outside the video container box to dismiss the player frame easily
    trailerModal.addEventListener('click', (e) => {
        if (e.target === trailerModal) closeModal();
    });
</script>
</body>

</html>