<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Store - Healthy Bharat Mission</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Built Tailwind CSS -->
    <link href="./dist/output.css" rel="stylesheet">
    <style>
        .font-handwriting {
            font-family: 'Caveat', cursive;
        }

        .pill-bar-sticky {
            top: 96px;
        }

        @media (min-width: 1024px) {
            .pill-bar-sticky {
                top: 124px;
            }
        }

        @media (min-width: 1280px) {
            .pill-bar-sticky {
                top: 132px;
            }
        }
    </style>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="./assets/images/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="./assets/images/favicon/favicon.svg" />
    <link rel="shortcut icon" href="./assets/images/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/images/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="./assets/images/favicon/site.webmanifest" />
</head>

<body class="font-body text-gray-800 bg-white antialiased">

    <!-- Header Area -->
    <hbm-header></hbm-header>
    <!-- Main Content -->
    <main>

        <!-- Health Library Hero Section -->
        <section class="relative w-full min-h-[400px] md:min-h-[480px] lg:min-h-[550px] flex items-center bg-[#f8fff9] overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0 w-full h-full">
                <img src="assets/Health-library-banner.png" alt="Health Library Banner" class="w-full h-full object-cover object-right lg:object-center opacity-90 lg:opacity-100">
            </div>
            
            <!-- Gradient Overlay for Text Readability -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#fcfdfa] via-[#fcfdfa]/95 to-transparent w-full md:w-[85%] lg:w-[65%] xl:w-[55%] h-full z-0"></div>

            <div class="container mx-auto max-w-[1400px] px-4 lg:px-8 relative z-10 py-12">
                <div class="max-w-xl xl:max-w-2xl">
                    <h1 class="text-[40px] md:text-[50px] lg:text-[60px] font-extrabold text-[#051c3f] leading-[1.1] mb-3 tracking-tight">
                        Health <span class="text-[#0e6e3a]">Library</span>
                    </h1>
                    <h2 class="text-[17px] md:text-[20px] lg:text-[22px] font-bold text-[#051c3f] mb-4">
                        Knowledge Today. A Healthier Tomorrow.
                    </h2>
                    <p class="text-gray-600 text-[14px] md:text-[15px] mb-8 max-w-lg leading-relaxed font-medium">
                        Explore expert-reviewed articles, tips and guides to help you make informed choices for a healthier, happier life.
                    </p>
                    
                    <!-- Search Bar -->
                    <div class="flex items-center w-full max-w-lg bg-white rounded-md shadow-[0_4px_20px_-4px_rgba(0,0,0,0.08)] overflow-hidden mb-6 border border-gray-100 h-[52px]">
                        <input id="searchInput" type="text" placeholder="Search articles, topics or keywords..." class="flex-grow px-5 h-full text-[14px] outline-none text-gray-700 w-full placeholder-gray-400">
                        <button id="searchBtn" class="bg-[#106e39] text-white px-6 h-full hover:bg-[#0b5028] transition-colors flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-magnifying-glass text-[18px]"></i>
                        </button>
                    </div>

                    <!-- Popular Searches -->
                    <div class="flex flex-wrap items-center gap-2.5 text-[13px]">
                        <span class="font-bold text-[#334155] text-[11px] uppercase tracking-wider mr-1">Popular Searches:</span>
                        <a href="?search=Diabetes" class="popular-search-tag px-3.5 py-1.5 rounded-full border border-gray-200 bg-white text-gray-600 font-semibold hover:border-[#106e39] hover:text-[#106e39] transition-colors shadow-sm">Diabetes</a>
                        <a href="?search=Weight+Loss" class="popular-search-tag px-3.5 py-1.5 rounded-full border border-gray-200 bg-white text-gray-600 font-semibold hover:border-[#106e39] hover:text-[#106e39] transition-colors shadow-sm">Weight Loss</a>
                        <a href="?search=Healthy+Diet" class="popular-search-tag px-3.5 py-1.5 rounded-full border border-gray-200 bg-white text-gray-600 font-semibold hover:border-[#106e39] hover:text-[#106e39] transition-colors shadow-sm">Healthy Diet</a>
                        <a href="?search=PCOS" class="popular-search-tag px-3.5 py-1.5 rounded-full border border-gray-200 bg-white text-gray-600 font-semibold hover:border-[#106e39] hover:text-[#106e39] transition-colors shadow-sm">PCOS</a>
                        <a href="?search=Heart+Health" class="popular-search-tag px-3.5 py-1.5 rounded-full border border-gray-200 bg-white text-gray-600 font-semibold hover:border-[#106e39] hover:text-[#106e39] transition-colors shadow-sm">Heart Health</a>
                    </div>
                </div>
            </div>
        </section>

                <!-- Explore by Category Section -->
        <section class="py-16 md:py-20 bg-white relative overflow-hidden border-b border-gray-100">
            <!-- Faint background leaf -->
            <div class="absolute right-0 top-0 opacity-[0.1] pointer-events-none w-64 h-64 md:w-96 md:h-96 transform translate-x-1/3 -translate-y-1/4">
                <svg viewBox="0 0 512 512" fill="#14532d" xmlns="http://www.w3.org/2000/svg">
                    <path d="M357.843 138.278C357.843 59.711 231.125 0 160.535 0C129.178 0 119.02 42.32 119.02 82.507c0 107.104 184.493 172.632 184.493 259.478 0 62.552-46.11 103.22-109.92 103.22-42.094 0-83.044-27.13-103.705-58.13C47.237 327.872 16.922 433.988 16.922 512h22.036c0-49.107 9.618-151.851 80.752-217.161 44.067 42.392 86.794 60.292 136.467 60.292 104.78 0 194.791-81.632 194.791-204.855 0-42.307-13.54-81.469-39.19-118.208-19.229 22.173-53.708 56.11-53.935 86.21z"/>
                </svg>
            </div>

            <div class="container mx-auto max-w-[1400px] px-4 lg:px-8 relative z-10">
                <!-- Section Header -->
                <div class="text-center md:text-left mb-10 md:mb-12">
                    <h2 class="font-heading font-extrabold text-[30px] md:text-[38px] text-[#0f3057] leading-tight mb-3 tracking-tight">
                        Explore by <span class="text-[#14532d]">Category</span>
                    </h2>
                    <p class="text-gray-600 font-medium text-[15px] md:text-[16px]">
                        Find articles by the topics that matter to you.
                    </p>
                </div>

                <!-- Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-9 gap-4 lg:gap-5">

                    <!-- Card 1 -->
                    <a href="?category=nutrition-diet" class="bg-[#f4f8f2] rounded-[20px] p-4 flex flex-col items-center justify-center text-center hover:-translate-y-1.5 transition-transform duration-300 group h-[170px] border border-transparent hover:border-[#14532d]/20">
                        <img src="assets/health_foods.png" alt="Nutrition & Diet" class="w-[72px] h-[72px] object-contain mb-4 group-hover:scale-110 transition-transform mix-blend-multiply">
                        <h4 class="font-extrabold text-[#1e293b] text-[12px] xl:text-[13px] leading-tight">Nutrition &<br>Diet</h4>
                    </a>

                    <!-- Card 2 -->
                    <a href="?category=diabetes-care" class="bg-[#f4f8f2] rounded-[20px] p-4 flex flex-col items-center justify-center text-center hover:-translate-y-1.5 transition-transform duration-300 group h-[170px] border border-transparent hover:border-[#14532d]/20">
                        <img src="assets/diabetes_care.png" alt="Diabetes Care" class="w-[72px] h-[72px] object-contain mb-4 group-hover:scale-110 transition-transform mix-blend-multiply">
                        <h4 class="font-extrabold text-[#1e293b] text-[12px] xl:text-[13px] leading-tight">Diabetes<br>Care</h4>
                    </a>

                    <!-- Card 3 -->
                    <a href="?category=weight-management" class="bg-[#f4f8f2] rounded-[20px] p-4 flex flex-col items-center justify-center text-center hover:-translate-y-1.5 transition-transform duration-300 group h-[170px] border border-transparent hover:border-[#14532d]/20">
                        <img src="assets/weight_management.png" alt="Weight Management" class="w-[72px] h-[72px] object-contain mb-4 group-hover:scale-110 transition-transform mix-blend-multiply">
                        <h4 class="font-extrabold text-[#1e293b] text-[12px] xl:text-[13px] leading-tight">Weight<br>Management</h4>
                    </a>

                    <!-- Card 4 -->
                    <a href="?category=heart-health" class="bg-[#f4f8f2] rounded-[20px] p-4 flex flex-col items-center justify-center text-center hover:-translate-y-1.5 transition-transform duration-300 group h-[170px] border border-transparent hover:border-[#14532d]/20">
                        <img src="assets/heart_health.png" alt="Heart Health" class="w-[72px] h-[72px] object-contain mb-4 group-hover:scale-110 transition-transform mix-blend-multiply">
                        <h4 class="font-extrabold text-[#1e293b] text-[12px] xl:text-[13px] leading-tight">Heart<br>Health</h4>
                    </a>

                    <!-- Card 5 -->
                    <a href="?category=womens-health" class="bg-[#f4f8f2] rounded-[20px] p-4 flex flex-col items-center justify-center text-center hover:-translate-y-1.5 transition-transform duration-300 group h-[170px] border border-transparent hover:border-[#14532d]/20">
                        <img src="assets/womens_health.png" alt="Women's Health" class="w-[72px] h-[72px] object-contain mb-4 group-hover:scale-110 transition-transform mix-blend-multiply">
                        <h4 class="font-extrabold text-[#1e293b] text-[12px] xl:text-[13px] leading-tight">Women's<br>Health</h4>
                    </a>

                    <!-- Card 6 -->
                    <a href="?category=digestive-health" class="bg-[#f4f8f2] rounded-[20px] p-4 flex flex-col items-center justify-center text-center hover:-translate-y-1.5 transition-transform duration-300 group h-[170px] border border-transparent hover:border-[#14532d]/20">
                        <img src="assets/digestive_health.png" alt="Digestive Health" class="w-[72px] h-[72px] object-contain mb-4 group-hover:scale-110 transition-transform mix-blend-multiply">
                        <h4 class="font-extrabold text-[#1e293b] text-[12px] xl:text-[13px] leading-tight">Digestive<br>Health</h4>
                    </a>

                    <!-- Card 7 -->
                    <a href="?category=immunity" class="bg-[#f4f8f2] rounded-[20px] p-4 flex flex-col items-center justify-center text-center hover:-translate-y-1.5 transition-transform duration-300 group h-[170px] border border-transparent hover:border-[#14532d]/20">
                        <img src="assets/immunity.png" alt="Immunity" class="w-[72px] h-[72px] object-contain mb-4 group-hover:scale-110 transition-transform mix-blend-multiply">
                        <h4 class="font-extrabold text-[#1e293b] text-[12px] xl:text-[13px] leading-tight">Immunity</h4>
                    </a>

                    <!-- Card 8 -->
                    <a href="?category=mental-wellness" class="bg-[#f4f8f2] rounded-[20px] p-4 flex flex-col items-center justify-center text-center hover:-translate-y-1.5 transition-transform duration-300 group h-[170px] border border-transparent hover:border-[#14532d]/20">
                        <img src="assets/mental_wellness.png" alt="Mental Wellness" class="w-[72px] h-[72px] object-contain mb-4 group-hover:scale-110 transition-transform mix-blend-multiply">
                        <h4 class="font-extrabold text-[#1e293b] text-[12px] xl:text-[13px] leading-tight">Mental<br>Wellness</h4>
                    </a>

                    <!-- Card 9 -->
                    <a href="?category=healthy-living" class="bg-[#f4f8f2] rounded-[20px] p-4 flex flex-col items-center justify-center text-center hover:-translate-y-1.5 transition-transform duration-300 group h-[170px] border border-transparent hover:border-[#14532d]/20">
                        <img src="assets/personal_care.png" alt="Healthy Living" class="w-[72px] h-[72px] object-contain mb-4 group-hover:scale-110 transition-transform mix-blend-multiply">
                        <h4 class="font-extrabold text-[#1e293b] text-[12px] xl:text-[13px] leading-tight">Healthy<br>Living</h4>
                    </a>

                </div>
            </div>
        </section>

        <!-- Featured Articles Section -->
        <section id="featured-articles-section" class="py-16 md:py-24 bg-[#f8faf8]">
            <div class="container mx-auto max-w-[1400px] px-4 lg:px-8">
                
                <!-- Section Header -->
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                    <div>
                        <h2 class="font-heading font-extrabold text-[32px] md:text-[38px] text-[#0f3057] leading-tight mb-2 tracking-tight">
                            Featured <span class="text-[#14532d]">Articles</span>
                        </h2>
                        <p class="text-gray-500 font-medium text-[16px] md:text-[17px]">
                            Handpicked by our experts, just for you.
                        </p>
                    </div>
                    <a href="#latest-articles-section" class="inline-flex items-center text-[#106e39] font-bold text-[15px] hover:text-[#0b4d27] transition-colors group">
                        View All Articles 
                        <i class="fa-solid fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>

                <!-- Articles Grid -->
                <div id="featured-articles-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    <!-- Fetched dynamically via JS -->
                </div>
            </div>
        </section>

        <!-- Latest Articles Section -->
        <section id="latest-articles-section" class="py-16 md:py-24 bg-white relative">
            <div class="container mx-auto max-w-[1400px] px-4 lg:px-8">
                
                <!-- Section Header -->
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                    <div>
                        <h2 id="latest-articles-heading" class="font-heading font-extrabold text-[32px] md:text-[38px] text-[#0f3057] leading-tight mb-2 tracking-tight">
                            Latest <span class="text-[#14532d]">Articles</span>
                        </h2>
                        <p id="latest-articles-subheading" class="text-gray-500 font-medium text-[16px] md:text-[17px]">
                            Stay updated with the latest health tips, research and expert advice.
                        </p>
                    </div>
                    <!-- Dropdown -->
                    <div class="relative group">
                        <button id="categoryDropdownBtn" class="flex items-center justify-between min-w-[180px] px-5 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-600 font-medium text-[14px] hover:border-[#14532d] hover:text-[#14532d] transition-colors focus:outline-none shadow-sm">
                            <span>All Categories</span>
                            <i class="fa-solid fa-chevron-down text-[12px] ml-2"></i>
                        </button>
                        <!-- Dropdown Menu -->
                        <div id="categoryDropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 hidden z-50 py-2">
                            <!-- Populated dynamically via JS -->
                        </div>
                    </div>
                </div>

                <!-- Articles Grid -->
                <div id="latest-articles-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                    <!-- Fetched dynamically via JS -->
                </div>

                <!-- Load More Button -->
                <div id="loadMoreSection" class="mt-14 flex flex-col items-center justify-center hidden">
                    <p id="loadCountText" class="text-gray-500 text-sm font-medium mb-4">Showing 0 of 0 articles</p>
                    <button id="loadMoreBtn" class="bg-[#14532d] text-white font-bold text-[15px] px-8 py-3.5 rounded-xl hover:bg-[#0b4d27] transition-colors flex items-center shadow-sm">
                        Load More Articles
                        <i class="fa-solid fa-rotate-right ml-2.5"></i>
                    </button>
                </div>

            </div>
        </section>

        <!-- CTA Banner Section -->
        <section class="relative min-h-[280px] md:min-h-[320px] flex items-center justify-center overflow-hidden border-t border-[#e2e8f0] mb-16">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img src="./assets/footer-top.png" alt="Growing Plant Background" class="w-full h-full object-cover">
                <!-- Very light white overlay to ensure text readability if needed -->
                <div class="absolute inset-0 bg-white/10"></div>
            </div>

            <!-- Content -->
            <div class="container mx-auto px-4 relative z-10 text-center flex flex-col items-center justify-center py-12">
                <!-- Heading -->
                <h2 class="font-heading font-extrabold text-[26px] md:text-[32px] lg:text-[36px] text-white leading-[1.2] max-w-[700px] mx-auto mb-5 tracking-tight drop-shadow-md">
                    Knowledge is the first step<br class="hidden sm:block"> towards a healthier you.
                </h2>
                
                <!-- Divider with Leaf -->
                <div class="flex items-center justify-center w-full max-w-[200px] mx-auto mb-10">
                    <div class="h-[2px] bg-gradient-to-r from-transparent to-[#14532d]/40 flex-grow"></div>
                    <div class="text-[#14532d] text-2xl px-4 flex gap-1">
                        <!-- Two leaves mimicking the design -->
                        <i class="fa-solid fa-leaf transform -rotate-12"></i>
                        <i class="fa-solid fa-leaf transform rotate-45 scale-75 origin-bottom-left -ml-2 -mb-2"></i>
                    </div>
                    <div class="h-[2px] bg-gradient-to-l from-transparent to-[#14532d]/40 flex-grow"></div>
                </div>

                <!-- CTA Button -->
                <a href="#" class="bg-[#14532d] text-white font-bold text-[16.5px] px-8 py-4 rounded-xl hover:bg-[#0b4d27] transition-all transform hover:-translate-y-1 shadow-[0_4px_15px_rgba(20,83,45,0.4)] hover:shadow-[0_8px_25px_rgba(20,83,45,0.5)] flex items-center">
                    Explore All Articles
                    <i class="fa-solid fa-arrow-right ml-3 text-[14px]"></i>
                </a>
            </div>
        </section>

</main>

    <!-- Footer Area -->
    <hbm-footer></hbm-footer>
    <script src="js/api.js"></script>
    <script src="js/content.js"></script>
    <script src="js/components_v15.js"></script>

    <!-- ScrollSpy Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sections = document.querySelectorAll('.product-category-section');
            const navLinks = document.querySelectorAll('.category-pill');
            const sidebarLinks = document.querySelectorAll('.sidebar-category-link');

            // Offset for sticky headers (104px main header + 88px pills navbar = 192px)
            const scrollOffset = 210;

            // Highlight on scroll
            window.addEventListener('scroll', () => {
                let current = '';

                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    // If we have scrolled past this section (minus the offset)
                    if (window.scrollY >= (sectionTop - scrollOffset)) {
                        current = section.getAttribute('id');
                    }
                });

                // Default to first section if at the top
                if (!current && sections.length > 0) {
                    current = sections[0].getAttribute('id');
                }

                navLinks.forEach(link => {
                    // Reset all links to default styling
                    link.className = 'category-pill flex items-center gap-2 px-5 py-2.5 bg-white text-gray-700 hover:text-[#064e3b] border border-gray-200 hover:border-[#064e3b]/30 rounded-full text-sm font-bold shadow-sm whitespace-nowrap transition-colors';

                    // Add active styling to the current one
                    if (link.getAttribute('href') === `#${current}`) {
                        link.className = 'category-pill flex items-center gap-2 px-5 py-2.5 bg-[#064e3b] text-white rounded-full text-sm font-bold shadow-sm whitespace-nowrap transition-colors';
                    }
                });

                sidebarLinks.forEach(link => {
                    // Reset all links to default styling
                    link.className = 'sidebar-category-link flex items-center justify-between text-sm py-2 px-3 rounded-lg hover:bg-white text-gray-700 hover:text-[#064e3b] font-semibold transition-colors';

                    // Add active styling to the current one
                    if (link.getAttribute('href') === `#${current}`) {
                        link.className = 'sidebar-category-link flex items-center justify-between text-sm py-2 px-3 rounded-lg bg-white text-[#064e3b] font-semibold transition-colors shadow-sm';
                    }
                });
            });

            // Smooth scroll on click
            const allLinks = [...navLinks, ...sidebarLinks];
            allLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    const targetSection = document.getElementById(targetId);
                    if (targetSection) {
                        window.scrollTo({
                            top: targetSection.offsetTop - scrollOffset + 10,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const track = document.getElementById('popular-products-track');
            if (!track) return;

            let autoScrollInterval;
            let isTransitioning = false;
            
            // Store all original cards for filtering
            const allCards = Array.from(track.querySelectorAll('.slider-card')).map(card => card.cloneNode(true));
            
            // Filtering logic
            const filterBtns = document.querySelectorAll('.filter-btn');
            filterBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    // Update active styles
                    const inactiveClass = "filter-btn snap-start shrink-0 px-6 py-2 rounded-full bg-white border border-gray-200 text-gray-600 hover:text-primary hover:border-primary text-sm font-semibold transition-colors shadow-sm flex items-center gap-2";
                    const activeClass = "filter-btn snap-start shrink-0 px-6 py-2 rounded-full bg-primary text-white text-sm font-bold shadow-sm flex items-center gap-2";
                    
                    filterBtns.forEach(b => {
                        b.className = inactiveClass;
                    });
                    
                    e.currentTarget.className = activeClass;
                    
                    const filter = e.currentTarget.getAttribute('data-filter');
                    
                    // Pause slider while updating
                    stopAutoScroll();
                    
                    // Empty track
                    track.innerHTML = '';
                    track.style.transition = 'none';
                    track.style.transform = 'translateX(0)';
                    
                    // Add filtered cards
                    allCards.forEach(card => {
                        if (filter === 'all' || card.getAttribute('data-category') === filter) {
                            track.appendChild(card.cloneNode(true));
                        }
                    });
                    
                    // Restart slider
                    startAutoScroll();
                });
            });

            const slideOne = () => {
                if (isTransitioning) return;
                
                // If the cards don't fill the container, no need to slide
                let totalWidth = 0;
                for(let i=0; i<track.children.length; i++) {
                    totalWidth += track.children[i].offsetWidth + 24;
                }
                if (totalWidth <= track.parentElement.clientWidth) return;

                const firstCard = track.firstElementChild;
                const secondCard = firstCard.nextElementSibling;
                if (!secondCard) return;

                isTransitioning = true;
                
                // Calculate distance to slide
                const slideDistance = secondCard.getBoundingClientRect().left - firstCard.getBoundingClientRect().left;

                // Apply transition
                track.style.transition = 'transform 0.5s ease-in-out';
                track.style.transform = `translateX(-${slideDistance}px)`;

                // Wait for transition
                const onTransitionEnd = () => {
                    track.removeEventListener('transitionend', onTransitionEnd);
                    
                    // Move first card to the end
                    track.appendChild(firstCard);
                    
                    // Reset transform instantly
                    track.style.transition = 'none';
                    track.style.transform = 'translateX(0)';
                    
                    // Force reflow
                    void track.offsetWidth;
                    
                    isTransitioning = false;
                };
                
                track.addEventListener('transitionend', onTransitionEnd);
                
                // Fallback in case transitionend fails
                setTimeout(() => {
                    if (isTransitioning) {
                        track.removeEventListener('transitionend', onTransitionEnd);
                        onTransitionEnd();
                    }
                }, 600);
            };

            const startAutoScroll = () => {
                if (autoScrollInterval) clearInterval(autoScrollInterval);
                autoScrollInterval = setInterval(slideOne, 3000);
            };

            const stopAutoScroll = () => {
                clearInterval(autoScrollInterval);
            };

            startAutoScroll();

            track.addEventListener('mouseenter', stopAutoScroll);
            track.addEventListener('mouseleave', startAutoScroll);
            track.addEventListener('touchstart', stopAutoScroll);
            track.addEventListener('touchend', startAutoScroll);
        });
    </script>

    <!-- Script for Dynamic Articles -->
    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            const featuredGrid = document.getElementById('featured-articles-grid');
            const latestGrid = document.getElementById('latest-articles-grid');
            const featuredSection = document.getElementById('featured-articles-section');
            const latestHeading = document.getElementById('latest-articles-heading');
            const latestSubheading = document.getElementById('latest-articles-subheading');
            const searchInput = document.getElementById('searchInput');
            const searchBtn = document.getElementById('searchBtn');
            const loadMoreSection = document.getElementById('loadMoreSection');
            const loadCountText = document.getElementById('loadCountText');
            const loadMoreBtn = document.getElementById('loadMoreBtn');
            const categoryDropdownBtn = document.getElementById('categoryDropdownBtn');
            const categoryDropdownMenu = document.getElementById('categoryDropdownMenu');

            let currentPage = 1;
            const perPage = 12; // Standard per page
            let totalArticles = 0;
            let loadedArticles = 0;

            // Parse URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const searchQuery = urlParams.get('search');
            const categoryFilter = urlParams.get('category');
            
            const isFiltered = searchQuery || categoryFilter;

            // Handle Search Event
            const performSearch = () => {
                const val = searchInput.value.trim();
                if(val) {
                    window.location.href = '?search=' + encodeURIComponent(val);
                } else {
                    window.location.href = 'healthlibrary.php';
                }
            };

            searchBtn.addEventListener('click', performSearch);
            searchInput.addEventListener('keypress', (e) => {
                if(e.key === 'Enter') performSearch();
            });

            // Handle Dropdown UI
            if (categoryDropdownBtn && categoryDropdownMenu) {
                categoryDropdownBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    categoryDropdownMenu.classList.toggle('hidden');
                });
                
                document.addEventListener('click', () => {
                    if (!categoryDropdownMenu.classList.contains('hidden')) {
                        categoryDropdownMenu.classList.add('hidden');
                    }
                });
            }

            // Fetch and Populate Categories Dropdown
            try {
                const catRes = await window.HBM_API.request('/article-categories');
                const categories = Array.isArray(catRes.data) ? catRes.data : [];
                
                if (categoryDropdownMenu) {
                    let menuHtml = `<a href="healthlibrary.php${searchQuery ? '?search='+encodeURIComponent(searchQuery) : ''}" class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-[#f4f8f2] hover:text-[#14532d] font-medium transition-colors border-b border-gray-50">All Categories</a>`;
                    
                    categories.forEach(cat => {
                        const searchParam = searchQuery ? `&search=${encodeURIComponent(searchQuery)}` : '';
                        menuHtml += `<a href="?category=${cat.slug}${searchParam}" class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-[#f4f8f2] hover:text-[#14532d] font-medium transition-colors">${cat.name}</a>`;
                    });
                    
                    categoryDropdownMenu.innerHTML = menuHtml;
                }

                // Update UI based on active category
                if (categoryFilter) {
                    const activeCat = categories.find(c => c.slug === categoryFilter);
                    if (activeCat && categoryDropdownBtn) {
                        categoryDropdownBtn.querySelector('span').textContent = activeCat.name;
                    }
                }
            } catch (err) {
                console.error("Failed to load categories for dropdown", err);
            }

            // Set search input value if search param is present
            if(searchQuery) {
                searchInput.value = searchQuery;
                if(latestHeading) latestHeading.innerHTML = `Search Results for <span class="text-[#14532d]">'${searchQuery}'</span>`;
                if(latestSubheading) latestSubheading.style.display = 'none';
            } else if (categoryFilter) {
                if(latestSubheading) latestSubheading.style.display = 'none';
                // Wait for categories to load, if activeCat name wasn't set we fallback
                const btnText = categoryDropdownBtn ? categoryDropdownBtn.querySelector('span').textContent : 'Category';
                if(latestHeading) latestHeading.innerHTML = `Category: <span class="text-[#14532d]">${btnText !== 'All Categories' ? btnText : categoryFilter}</span>`;
            }

            // Hide featured section if filtering
            if(isFiltered && featuredSection) {
                featuredSection.style.display = 'none';
            }

            const renderCard = (a, isFeatured = false) => {
                const imgClass = isFeatured ? 'h-[260px]' : 'h-[200px]';
                const wrapperClass = isFeatured ? 'bg-white rounded-3xl overflow-hidden shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] flex flex-col group hover:shadow-[0_12px_40px_-5px_rgba(0,0,0,0.1)] transition-all duration-300 transform hover:-translate-y-1 h-full' : 'bg-white rounded-2xl overflow-hidden border border-gray-100 flex flex-col group hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.08)] transition-all duration-300 transform hover:-translate-y-1 h-full';
                const titleClass = isFeatured ? 'font-extrabold text-[22px] md:text-[24px] text-[#0f3057] leading-[1.3] mb-3 group-hover:text-[#106e39] transition-colors line-clamp-2' : 'font-bold text-[17px] text-[#0f3057] leading-snug mb-5 group-hover:text-[#106e39] transition-colors flex-grow line-clamp-2';
                
                return `
                    <a href="/${a.slug}" class="block cursor-pointer">
                        <article class="${wrapperClass}">
                        <div class="relative ${imgClass} overflow-hidden shrink-0">
                            <img src="${a.image_url}" alt="${a.title}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                            ${a.category_name ? `<div class="absolute bottom-4 left-4 bg-[#14532d] text-white text-[12.5px] font-bold px-3.5 py-1.5 rounded-lg shadow-sm">${a.category_name}</div>` : ''}
                        </div>
                        <div class="p-${isFeatured ? '7' : '5'} flex flex-col flex-grow">
                            <h3 class="${titleClass}">
                                ${a.title}
                            </h3>
                            ${isFeatured && a.excerpt ? `<p class="text-gray-500 text-[15px] leading-relaxed mb-6 flex-grow line-clamp-3">${a.excerpt}</p>` : ''}
                            <div class="flex items-center gap-${isFeatured ? '6' : '4'} text-gray-500 text-[13px] font-${isFeatured ? 'semibold' : 'medium'} mt-auto shrink-0">
                                <div class="flex items-center gap-2">
                                    <i class="fa-regular fa-calendar text-[#a0aab8]"></i>
                                    ${new Date(a.published_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })}
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-regular fa-clock text-[#a0aab8]"></i>
                                    ${a.read_time_minutes} min read
                                </div>
                            </div>
                        </div>
                    </article>
                    </a>`;
            };

            const fetchArticles = async (page = 1, append = false) => {
                try {
                    let apiUrl = `/articles?page=${page}&perPage=${perPage}`;
                    if(searchQuery) apiUrl += '&search=' + encodeURIComponent(searchQuery);
                    if(categoryFilter) apiUrl += '&category=' + encodeURIComponent(categoryFilter);

                    const res = await window.HBM_API.request(apiUrl);
                    
                    let articles = [];
                    if (Array.isArray(res.data)) {
                        articles = res.data;
                    } else if (res.data && Array.isArray(res.data.data)) {
                        articles = res.data.data;
                    } else if (Array.isArray(res)) {
                        articles = res;
                    }
                    
                    if(res.meta && res.meta.total !== undefined) {
                        totalArticles = res.meta.total;
                    } else {
                        // Fallback if meta is missing
                        totalArticles = append ? totalArticles + articles.length : articles.length;
                    }

                    if (articles.length === 0 && !append) {
                        if(!isFiltered && featuredGrid) featuredGrid.innerHTML = '<p class="col-span-full text-center text-gray-500 py-10">No articles available.</p>';
                        if(latestGrid) latestGrid.innerHTML = '<p class="col-span-full text-center text-gray-500 py-10">No articles found matching your criteria.</p>';
                        if(loadMoreSection) loadMoreSection.classList.add('hidden');
                        return;
                    }

                    // Render Logic
                    if (!isFiltered && page === 1 && !append) {
                        // Display default state (Featured + Latest)
                        const featuredSlugs = ['beginners-guide-balanced-diet', '10-daily-habits-manage-diabetes', 'power-of-daily-movement'];
                        const featured = [];
                        const latest = [];

                        featuredSlugs.forEach(slug => {
                            const found = articles.find(a => a.slug === slug);
                            if (found) featured.push(found);
                        });

                        let i = 0;
                        while (featured.length < 3 && i < articles.length) {
                            if (!featured.includes(articles[i])) {
                                featured.push(articles[i]);
                            }
                            i++;
                        }

                        articles.forEach(a => {
                            if (!featured.includes(a)) {
                                latest.push(a);
                            }
                        });

                        if (featuredGrid) featuredGrid.innerHTML = featured.map(a => renderCard(a, true)).join('');
                        if (latestGrid) latestGrid.innerHTML = latest.map(a => renderCard(a, false)).join('');
                        loadedArticles = latest.length + featured.length;
                    } else {
                        // Rendering filtered or paginated results to latestGrid
                        const htmlString = articles.map(a => renderCard(a, false)).join('');
                        if (append) {
                            if(latestGrid) latestGrid.innerHTML += htmlString;
                        } else {
                            if(latestGrid) latestGrid.innerHTML = htmlString;
                        }
                        loadedArticles = append ? loadedArticles + articles.length : articles.length;
                    }

                    // Update Load More UI
                    if(loadMoreSection) {
                        if(loadedArticles < totalArticles) {
                            loadMoreSection.classList.remove('hidden');
                            loadCountText.textContent = `Showing ${loadedArticles} of ${totalArticles} articles`;
                        } else {
                            loadMoreSection.classList.add('hidden');
                        }
                    }

                } catch(e) {
                    console.error("Failed to load articles", e);
                    if(!append) {
                        if(featuredGrid) featuredGrid.innerHTML = '<p class="col-span-full text-center text-red-500 py-10">Failed to load articles.</p>';
                        if(latestGrid) latestGrid.innerHTML = '<p class="col-span-full text-center text-red-500 py-10">Failed to load articles.</p>';
                    }
                }
            };

            // Initial fetch
            fetchArticles(currentPage, false);

            // Handle Load More
            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', () => {
                    currentPage++;
                    fetchArticles(currentPage, true);
                });
            }
        });
    </script>
</body>


</html>