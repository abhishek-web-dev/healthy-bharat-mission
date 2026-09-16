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
        <!-- Store Hero Section -->
        <section class="relative w-full overflow-hidden bg-[#f8fbf8] min-h-[500px] xl:min-h-[600px] flex items-center">

            <!-- Right side image (The provided Store-banner.png) -->
            <div class="absolute right-0 top-0 bottom-0 w-full md:w-[60%] lg:w-[65%] z-0">
                <!-- We use the provided image as the background, positioned to the right -->
                <img src="assets/Store-banner.png" alt="Health Store Products"
                    class="w-full h-full object-cover object-right md:object-right-top">
                <!-- A soft gradient to blend the image into the background color on the left -->
                <div class="absolute inset-y-0 left-0 w-[40%] bg-gradient-to-r from-[#f8fbf8] to-transparent"></div>
            </div>

            <!-- Content Area -->
            <div class="container mx-auto max-w-[1500px] relative z-10 px-4 lg:px-8 py-12 lg:py-20">
                <div class="w-full md:w-[60%] lg:w-[50%] flex flex-col items-start text-left">

                    <!-- Top Subtitle -->
                    <p
                        class="text-gray-600 font-bold text-[10px] xl:text-[12px] tracking-[0.2em] uppercase mb-4 flex items-center gap-2">
                        <span>NATURAL</span> <span class="text-gray-400">|</span>
                        <span>TRUSTED</span> <span class="text-gray-400">|</span>
                        <span>HEALTHIER TOMORROWS</span>
                    </p>

                    <!-- Main Title -->
                    <h1
                        class="font-heading font-extrabold text-5xl lg:text-6xl xl:text-[75px] text-[#0f3057] leading-tight mb-2 tracking-tight">
                        Health <span class="text-[#14532d]">Store</span>
                    </h1>

                    <!-- Sub Heading -->
                    <h3 class="font-bold text-[#0f3057] text-lg lg:text-xl xl:text-[22px] mb-5">
                        Support Your Journey to a Healthier You
                    </h3>

                    <!-- Description -->
                    <p class="text-gray-600 font-medium text-sm xl:text-[16px] leading-relaxed mb-8 max-w-[500px]">
                        Discover a range of carefully curated products to support your health, manage diabetes and build
                        a better lifestyle.
                        Natural, safe and trusted — for you and your family.
                    </p>

                    <!-- CTA Button -->
                    <a href="#products"
                        class="bg-[#14532d] hover:bg-[#0f3f22] text-white px-8 py-3.5 rounded-lg font-bold text-sm xl:text-base transition-all duration-300 shadow flex items-center group mb-12">
                        Explore Products
                        <i class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    <!-- Trust Badges -->
                    <div class="flex flex-wrap items-center gap-6 lg:gap-10">
                        <!-- Badge 1 -->
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-leaf text-2xl text-[#14532d]"></i>
                            <div class="leading-tight">
                                <span class="block font-bold text-[#1e293b] text-[13px] xl:text-[14px]">100%</span>
                                <span class="block font-semibold text-gray-500 text-[11px] xl:text-[12px]">Natural &
                                    Safe</span>
                            </div>
                        </div>
                        <!-- Badge 2 -->
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-shield-halved text-2xl text-[#14532d]"></i>
                            <div class="leading-tight">
                                <span class="block font-bold text-[#1e293b] text-[13px] xl:text-[14px]">Trusted</span>
                                <span
                                    class="block font-semibold text-gray-500 text-[11px] xl:text-[12px]">Quality</span>
                            </div>
                        </div>
                        <!-- Badge 3 -->
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-truck-fast text-2xl text-[#14532d]"></i>
                            <div class="leading-tight">
                                <span class="block font-bold text-[#1e293b] text-[13px] xl:text-[14px]">Fast &
                                    Reliable</span>
                                <span
                                    class="block font-semibold text-gray-500 text-[11px] xl:text-[12px]">Delivery</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </section>

        <!-- Shop by Category Section -->
        <section class="py-16 md:py-20 bg-white relative overflow-hidden border-b border-gray-100">
            <!-- Faint background leaf -->
            <div
                class="absolute right-0 top-0 opacity-[0.1] pointer-events-none w-64 h-64 md:w-96 md:h-96 transform translate-x-1/3 -translate-y-1/4">
                <svg viewBox="0 0 512 512" fill="#14532d" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M357.843 138.278C357.843 59.711 231.125 0 160.535 0C129.178 0 119.02 42.32 119.02 82.507c0 107.104 184.493 172.632 184.493 259.478 0 62.552-46.11 103.22-109.92 103.22-42.094 0-83.044-27.13-103.705-58.13C47.237 327.872 16.922 433.988 16.922 512h22.036c0-49.107 9.618-151.851 80.752-217.161 44.067 42.392 86.794 60.292 136.467 60.292 104.78 0 194.791-81.632 194.791-204.855 0-42.307-13.54-81.469-39.19-118.208-19.229 22.173-53.708 56.11-53.935 86.21z" />
                </svg>
            </div>

            <div class="container mx-auto max-w-[1400px] px-4 lg:px-8 relative z-10">
                <!-- Header -->
                <div class="text-center mb-12">
                    <h2
                        class="font-heading font-extrabold text-[30px] md:text-[38px] text-[#0f3057] leading-tight mb-3 tracking-tight">
                        Shop by <span class="text-[#14532d]">Category</span>
                    </h2>
                    <p class="text-gray-600 font-medium text-[15px] md:text-[16px]">
                        Find the right products for your health and wellness needs.
                    </p>
                </div>

                <!-- Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-8 gap-4 lg:gap-5">

                    <!-- Card 1 -->
                    <a href="#"
                        class="bg-[#f4f8f2] rounded-[20px] p-4 flex flex-col items-center justify-center text-center hover:-translate-y-1.5 transition-transform duration-300 group h-[170px] border border-transparent hover:border-[#14532d]/20">
                        <img src="assets/diabetes_care.png" alt="Diabetes Care"
                            class="w-[72px] h-[72px] object-contain mb-4 group-hover:scale-110 transition-transform drop-shadow-sm">
                        <h4 class="font-extrabold text-[#1e293b] text-[13px] xl:text-[14px] leading-tight">Diabetes Care
                        </h4>
                    </a>

                    <!-- Card 2 -->
                    <a href="#"
                        class="bg-[#f4f8f2] rounded-[20px] p-4 flex flex-col items-center justify-center text-center hover:-translate-y-1.5 transition-transform duration-300 group h-[170px] border border-transparent hover:border-[#14532d]/20">
                        <img src="assets/health_foods.png" alt="Health Foods"
                            class="w-[72px] h-[72px] object-contain mb-4 group-hover:scale-110 transition-transform drop-shadow-sm">
                        <h4 class="font-extrabold text-[#1e293b] text-[13px] xl:text-[14px] leading-tight">Health Foods
                        </h4>
                    </a>

                    <!-- Card 3 -->
                    <a href="#"
                        class="bg-[#f4f8f2] rounded-[20px] p-4 flex flex-col items-center justify-center text-center hover:-translate-y-1.5 transition-transform duration-300 group h-[170px] border border-transparent hover:border-[#14532d]/20">
                        <img src="assets/herbal_supplements.png" alt="Herbal Supplements"
                            class="w-[72px] h-[72px] object-contain mb-4 group-hover:scale-110 transition-transform drop-shadow-sm">
                        <h4 class="font-extrabold text-[#1e293b] text-[13px] xl:text-[14px] leading-tight">Herbal
                            Supplements</h4>
                    </a>

                    <!-- Card 4 -->
                    <a href="#"
                        class="bg-[#f4f8f2] rounded-[20px] p-4 flex flex-col items-center justify-center text-center hover:-translate-y-1.5 transition-transform duration-300 group h-[170px] border border-transparent hover:border-[#14532d]/20">
                        <img src="assets/sugar_control.png" alt="Sugar Control"
                            class="w-[72px] h-[72px] object-contain mb-4 group-hover:scale-110 transition-transform drop-shadow-sm">
                        <h4 class="font-extrabold text-[#1e293b] text-[13px] xl:text-[14px] leading-tight">Sugar Control
                        </h4>
                    </a>

                    <!-- Card 5 -->
                    <a href="#"
                        class="bg-[#f4f8f2] rounded-[20px] p-4 flex flex-col items-center justify-center text-center hover:-translate-y-1.5 transition-transform duration-300 group h-[170px] border border-transparent hover:border-[#14532d]/20">
                        <img src="assets/healthy_beverages.png" alt="Healthy Beverages"
                            class="w-[72px] h-[72px] object-contain mb-4 group-hover:scale-110 transition-transform drop-shadow-sm">
                        <h4 class="font-extrabold text-[#1e293b] text-[13px] xl:text-[14px] leading-tight">Healthy
                            Beverages</h4>
                    </a>

                    <!-- Card 6 -->
                    <a href="#"
                        class="bg-[#f4f8f2] rounded-[20px] p-4 flex flex-col items-center justify-center text-center hover:-translate-y-1.5 transition-transform duration-300 group h-[170px] border border-transparent hover:border-[#14532d]/20">
                        <img src="assets/fitness_lifestyle.png" alt="Fitness & Lifestyle"
                            class="w-[72px] h-[72px] object-contain mb-4 group-hover:scale-110 transition-transform drop-shadow-sm">
                        <h4 class="font-extrabold text-[#1e293b] text-[13px] xl:text-[14px] leading-tight">Fitness &
                            Lifestyle</h4>
                    </a>

                    <!-- Card 7 -->
                    <a href="#"
                        class="bg-[#f4f8f2] rounded-[20px] p-4 flex flex-col items-center justify-center text-center hover:-translate-y-1.5 transition-transform duration-300 group h-[170px] border border-transparent hover:border-[#14532d]/20">
                        <img src="assets/personal_care.png" alt="Personal Care"
                            class="w-[72px] h-[72px] object-contain mb-4 group-hover:scale-110 transition-transform drop-shadow-sm">
                        <h4 class="font-extrabold text-[#1e293b] text-[13px] xl:text-[14px] leading-tight">Personal Care
                        </h4>
                    </a>

                    <!-- Card 8 -->
                    <a href="#"
                        class="bg-[#f4f8f2] rounded-[20px] p-4 flex flex-col items-center justify-center text-center hover:-translate-y-1.5 transition-transform duration-300 group h-[170px] border border-transparent hover:border-[#14532d]/20">
                        <img src="assets/combos_packs.png" alt="Combos & Packs"
                            class="w-[72px] h-[72px] object-contain mb-4 group-hover:scale-110 transition-transform drop-shadow-sm">
                        <h4 class="font-extrabold text-[#1e293b] text-[13px] xl:text-[14px] leading-tight">Combos &
                            Packs</h4>
                    </a>
                </div>
            </div>
        </section>

        <!-- New E-commerce Layout -->
        <div class="relative w-full z-10">
            <section
                class="pill-bar-sticky bg-[#f0fdf4] pt-6 pb-2 border-b border-[#064e3b]/10 sticky z-40 shadow-sm top-[104px]">
                <div class="container mx-auto max-w-[1400px] px-4 lg:px-8">
                    <!-- Top Navbar -->
                    <div id="top-category-nav" class="flex flex-wrap items-center gap-3 md:gap-4 overflow-x-auto scrollbar-hide">
                    </div>
                </div>
            </section>


            <section class="py-12 bg-white">
                <div class="container mx-auto max-w-[1400px] px-4 lg:px-8 lg:flex lg:gap-8">

                    <!-- Left Sidebar -->
                    <aside class="w-full lg:w-[280px] shrink-0 space-y-6 mb-8 lg:mb-0 lg:sticky self-start z-30"
                        style="top: 192px;">

                        <!-- Categories -->
                        <div class="bg-[#f0fdf4] rounded-xl shadow-sm border border-[#064e3b]/10 p-5">
                            <h3 class="text-xs font-bold text-[#064e3b] uppercase tracking-wider mb-4">Store Categories
                            </h3>
                            <ul class="space-y-1" id="store-categories-list">
                                <!-- Categories will be loaded dynamically -->
                            </ul>
                        </div>

                        <!-- Quick Enquiry -->
                        <div
                            class="bg-gradient-to-br from-[#064e3b] to-[#022c22] rounded-xl shadow-md p-6 text-white border border-[#064e3b]/20 relative overflow-hidden">
                            <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/5 rounded-full blur-xl"></div>
                            <h3 class="font-bold text-lg mb-1 relative z-10">Quick Enquiry</h3>
                            <p class="text-white/70 text-xs mb-5 relative z-10">Expert callback within 2 hours</p>

                            <form class="space-y-4 relative z-10">
                                <div>
                                    <label
                                        class="block text-[10px] font-bold uppercase tracking-wider text-white/60 mb-1">Your
                                        Name</label>
                                    <input type="text" placeholder="Full Name"
                                        class="w-full bg-[#064e3b]/50 border border-white/20 rounded-md px-3 py-2 text-sm text-white placeholder-white/30 focus:outline-none focus:border-white/50">
                                </div>
                                <div>
                                    <label
                                        class="block text-[10px] font-bold uppercase tracking-wider text-white/60 mb-1">Phone
                                        Number</label>
                                    <input type="text" placeholder="+91 XXXXX XXXXX"
                                        class="w-full bg-[#064e3b]/50 border border-white/20 rounded-md px-3 py-2 text-sm text-white placeholder-white/30 focus:outline-none focus:border-white/50">
                                </div>
                                <div>
                                    <label
                                        class="block text-[10px] font-bold uppercase tracking-wider text-white/60 mb-1">Interested
                                        In</label>
                                    <select
                                        class="w-full bg-[#064e3b]/50 border border-white/20 rounded-md px-3 py-2 text-sm text-white focus:outline-none focus:border-white/50 appearance-none">
                                        <option class="text-gray-800">Select product type...</option>
                                        <option class="text-gray-800">Atta & Flours</option>
                                        <option class="text-gray-800">Cookies & Snacks</option>
                                        <option class="text-gray-800">Sweeteners</option>
                                        <option class="text-gray-800">Diet Plans</option>
                                    </select>
                                </div>
                                <button type="button"
                                    class="w-full bg-white hover:bg-gray-100 text-primary-light font-bold py-3 rounded-md text-sm transition-colors mt-2 shadow-sm">
                                    <i class="fa-regular fa-paper-plane mr-2"></i> SEND ENQUIRY
                                </button>
                            </form>
                        </div>
                    </aside>

                    <!-- Main Content -->
                    <div class="flex-1">

                        <div id="store-main-content"></div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Good Health Promotional Banner -->
        <section class="py-6 pb-12 bg-white">
            <div class="container mx-auto max-w-[1400px] px-4 lg:px-8">
                <div class="relative rounded-[30px] overflow-hidden bg-[#edf7ef] shadow-sm border border-green-50 flex flex-col lg:flex-row items-center justify-between p-6 lg:p-8 min-h-[250px] xl:min-h-[280px]"
                    style="background-image: url('./assets/Good-Health.png'); background-size: cover; background-position: center;">

                    <!-- Left spacer (for the bowl in the background) -->
                    <div class="hidden lg:block lg:w-1/4 xl:w-1/3"></div>

                    <!-- Center Content -->
                    <div
                        class="flex-1 text-center z-10 max-w-xl mx-auto bg-white/40 lg:bg-transparent backdrop-blur-md lg:backdrop-blur-none p-4 rounded-3xl lg:p-0">
                        <h2
                            class="font-heading text-2xl lg:text-3xl xl:text-4xl font-extrabold text-primary leading-tight mb-2 tracking-tight">
                            Good Health <br class="hidden md:block" />
                            Begins with Better Choices
                        </h2>
                        <p class="text-gray-700 text-xs lg:text-sm font-medium mb-4 max-w-md mx-auto leading-relaxed">
                            Explore our range of natural and trusted products, made for a healthier, diabetes-free
                            tomorrow.
                        </p>
                        <a href="#"
                            class="inline-flex items-center gap-2 bg-primary hover:bg-primary-light text-white px-6 py-2.5 rounded-lg font-bold transition-all shadow-md hover:shadow-lg transform active:scale-95 text-sm">
                            Shop Now <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>

                    <!-- Right Icons -->
                    <div
                        class="w-full lg:w-1/4 xl:w-1/4 mt-6 lg:mt-0 flex flex-col gap-3 lg:gap-4 z-10 pl-0 lg:pl-4 xl:pl-8">
                        <!-- Icon 1 -->
                        <div
                            class="flex items-center gap-3 bg-white/70 backdrop-blur-md lg:bg-transparent lg:backdrop-blur-none p-3 lg:p-0 rounded-2xl">
                            <div
                                class="w-10 h-10 lg:w-11 lg:h-11 rounded-full bg-white text-primary border-2 border-primary flex items-center justify-center text-lg lg:text-xl shrink-0 shadow-sm">
                                <i class="fa-solid fa-leaf"></i>
                            </div>
                            <div>
                                <div class="text-primary font-bold text-xs lg:text-sm leading-tight">Natural</div>
                                <div class="text-gray-600 text-[10px] lg:text-xs font-medium mt-0.5">Ingredients</div>
                            </div>
                        </div>
                        <!-- Icon 2 -->
                        <div
                            class="flex items-center gap-3 bg-white/70 backdrop-blur-md lg:bg-transparent lg:backdrop-blur-none p-3 lg:p-0 rounded-2xl">
                            <div
                                class="w-10 h-10 lg:w-11 lg:h-11 rounded-full bg-white text-primary border-2 border-primary flex items-center justify-center text-lg lg:text-xl shrink-0 shadow-sm">
                                <i class="fa-solid fa-user-doctor"></i>
                            </div>
                            <div>
                                <div class="text-primary font-bold text-xs lg:text-sm leading-tight">Backed by</div>
                                <div class="text-gray-600 text-[10px] lg:text-xs font-medium mt-0.5">Expert Guidance
                                </div>
                            </div>
                        </div>
                        <!-- Icon 3 -->
                        <div
                            class="flex items-center gap-3 bg-white/70 backdrop-blur-md lg:bg-transparent lg:backdrop-blur-none p-3 lg:p-0 rounded-2xl">
                            <div
                                class="w-10 h-10 lg:w-11 lg:h-11 rounded-full bg-white text-primary border-2 border-primary flex items-center justify-center text-lg lg:text-xl shrink-0 shadow-sm">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div>
                                <div class="text-primary font-bold text-xs lg:text-sm leading-tight">Trusted</div>
                                <div class="text-gray-600 text-[10px] lg:text-xs font-medium mt-0.5">by Families</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Popular Products Section -->
        <section class="py-12 bg-white border-b border-gray-100">
            <div class="container mx-auto max-w-[1400px] px-4 lg:px-8">
                <!-- Header and Filter -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
                    <h2 class="text-2xl lg:text-3xl font-extrabold text-secondary tracking-tight">Popular Products</h2>
                    <div id="popular-products-filters" class="flex items-center gap-3 overflow-x-auto scrollbar-hide pb-2 md:pb-0 w-full md:w-auto snap-x">
                        <button data-filter="all" class="filter-btn snap-start shrink-0 px-6 py-2 rounded-full bg-primary text-white text-sm font-bold shadow-sm">All</button>
                    </div>
                </div>

                <!-- Products Carousel -->

                <div id="popular-products-slider" class="overflow-hidden -mx-4 px-4 lg:mx-0 lg:px-0 pb-6">
                    <div id="popular-products-track" class="flex gap-4 lg:gap-6 cursor-grab active:cursor-grabbing">
                    </div>
                </div>
            </div>
        </section>

    </main>

    <hbm-footer></hbm-footer>

    <script src="js/api.js"></script>
    <script src="js/components_v15.js"></script>
    <script src="js/store.js"></script>
</body>
</html>
