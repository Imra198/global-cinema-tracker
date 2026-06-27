# global-cinema-tracker
A modern, fast, and responsive web interface designed to fetch, display, and filter streaming content live from global movie database registries using the TMDB API. Built with PHP, Tailwind CSS, and asynchronous JavaScript

## 🚀 Key Features
* **Live Data Sync:** Pulls real-time global trending content (Movies and TV Shows) directly from the TMDB API via asynchronous secure headers.
* **Unified Component Engine:** Uses an optimized component mapping layout helper (`createMovieCard`) to dynamically construct clean, standardized UI layout bounds.
* **Dynamic Interactive Trailer Modal:** Integrated trailer play links that trigger target streams with contextual entity mappings (`movie` or `tv`).
* **Instant DOM Filtering:** Client-side dynamic search and match engine filters current collections effortlessly without causing layout reflow breaks.
* **Fluid Responsive UX:** Smooth horizontal scrolling showcase reels, active content skeleton states, and custom responsive layouts via Tailwind CSS utilities.

## 📂 Project Structure

```text
├── header.php          # Global navigation header, meta tags, and style linkages
├── footer.php          # Global footer incorporating the active dynamic trailer modal
├── index.php           # Landing page with marquee showcase banner & general trending cards
├── movies.php          # Main Trending Global Movies stream page
├── tv-shows.php        # Dynamic TV Show stream page using contextual TMDB naming models
├── hollywood.php       # Filtered English Language (US releases) cinema category page
└── README.md           # Documentation registry hub
⚙️ Setup and Installation
1. Prerequisites
You will need a web server environment running PHP 7.4 or later (e.g., Apache, Nginx, XAMPP, or Local by Flywheel).

2. Configure API Access Token
Open the .php files (index.php, movies.php, etc.).
Replace the value of ACCESS_TOKEN inside the <script> tag with your private TMDB Read Access Token (v4 Auth):
JavaScript
const ACCESS_TOKEN = "YOUR_OWN_TMDB_BEARER_TOKEN";

3. Deploy Localhost Host Environment
Clone this repository directly into your server's root web directory

Project is built with
PHP Engine: Handles component layouts via modular server-side includes (include).
Asynchronous JavaScript: Intercepts JSON data pipes via async/await fetch patterns and processes results sequentially.
Tailwind CSS UI Suite: Paints dark mode compatible utility elements and layouts.
The Movie Database (TMDB) API: Powers the dynamic backing registry infrastructure.






