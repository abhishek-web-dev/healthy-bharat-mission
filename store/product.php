<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutroActive Keto Combo - Healthy Bharat Mission</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="../dist/output.css" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../assets/images/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="../assets/images/favicon/favicon.svg" />
    <link rel="shortcut icon" href="../assets/images/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="../assets/images/favicon/site.webmanifest" />
</head>

<body class="font-body text-gray-800 bg-white antialiased">

    <hbm-header base-path="../"></hbm-header>

    <main class="container mx-auto max-w-[1500px] px-2 lg:px-8 py-16">

        <!-- Breadcrumbs -->
        <nav class="flex text-[13px] text-gray-500 mb-8 font-medium">
            <ol class="flex items-center space-x-2">
                <li><a href="../index" class="hover:text-[#106e39] transition-colors">Home</a></li>
                <li><i class="fa-solid fa-chevron-right text-[10px] mx-1"></i></li>
                <li><a href="../store" class="hover:text-[#106e39] transition-colors">Store</a></li>
                <li><i class="fa-solid fa-chevron-right text-[10px] mx-1"></i></li>
                <li><a href="../store" class="hover:text-[#106e39] transition-colors" id="product-breadcrumb-category">Category</a></li>
                <li><i class="fa-solid fa-chevron-right text-[10px] mx-1"></i></li>
                <li><span class="text-gray-900 font-bold" id="product-breadcrumb-name">Product</span></li>
            </ol>
        </nav>

        <!-- Product Top Section -->
        <div class="flex flex-col lg:flex-row gap-10 xl:gap-14">

            <!-- Left: Images Gallery -->
            <div class="w-full lg:w-[45%] flex flex-col gap-4">
                <!-- Main Image -->
                <div class="relative w-full bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 flex items-center justify-center p-2" style="height: 450px;">
                    <img id="product-main-image" src="https://images.unsplash.com/photo-1550989460-0adf9ea622e2?auto=format&fit=crop&w=800&q=80" alt="Main Product" class="w-full h-full object-contain">
                    <!-- 100% Natural Tag -->
                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md rounded-lg px-3 py-2 flex items-center gap-2 shadow-sm border border-white/50 z-10">
                        <div class="w-6 h-6 rounded-full bg-[#106e39] flex items-center justify-center text-white shrink-0">
                            <i class="fa-solid fa-leaf text-[10px]"></i>
                        </div>
                        <div>
                            <span class="block text-[12px] font-bold text-[#052b14] leading-none">100%</span>
                            <span class="block text-[9px] font-semibold text-gray-500 mt-0.5 uppercase tracking-wide">Natural</span>
                        </div>
                    </div>
                </div>

                <!-- Thumbnails -->
                <div id="product-thumbnails-container" class="flex gap-4 overflow-x-auto pb-2 scrollbar-hide snap-x">
                    <!-- Dynamic thumbnails will be injected here -->
                </div>
            </div>

            <!-- Right: Product Info -->
            <div class="w-full flex-1 flex flex-col pt-2 lg:pl-6 xl:pl-10">
                <span id="product-category-tag" class="text-[12px] font-bold tracking-wider text-gray-500 uppercase mb-2">Cookies & Snacks</span>

                <h1 id="product-title" class="text-3xl lg:text-4xl font-extrabold text-[#052b14] leading-tight mb-3">
                    NutroActive Keto Atta 750g with Keto Sugar 250g Combo
                </h1>

                <p class="text-[16px] text-gray-600 font-medium mb-4">
                    A healthier choice for your everyday meals.
                </p>

                <!-- Reviews & Trust -->
                <div class="flex items-center gap-4 mb-6 text-[14px]">
                    <div class="flex items-center gap-1.5">
                        <div class="flex text-[#fbbf24] text-[13px]">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <span class="font-bold text-[#052b14] ml-1">4.8</span>
                        <span
                            class="text-gray-500 underline decoration-gray-300 underline-offset-2 cursor-pointer hover:text-[#106e39]">(120
                            reviews)</span>
                    </div>
                    <div class="w-px h-4 bg-gray-300"></div>
                    <div class="flex items-center gap-1.5 text-gray-600 font-medium">
                        <i class="fa-solid fa-shield-check text-[#106e39]"></i> Trusted by 5,000+ customers
                    </div>
                </div>

                <!-- Price -->
                <div class="flex items-center gap-3 mb-6">
                    <span id="product-price" class="text-3xl font-extrabold text-[#106e39]"></span>
                    <span id="product-mrp" class="text-[16px] font-medium text-gray-400 line-through mt-1 hidden"></span>
                    <span id="product-discount-badge" class="bg-[#dcfce7] text-[#166534] text-[12px] font-bold px-2.5 py-1 rounded-full mt-1 ml-1 hidden">
                        <!-- Discount text injected here -->
                    </span>
                </div>

                <!-- Highlights Bar -->
                <div
                    class="bg-[#f8faf9] rounded-xl p-4 flex flex-wrap lg:flex-nowrap items-center justify-start gap-8 border border-green-50 mb-8">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-truck-fast text-[#106e39] text-lg"></i>
                        <span class="text-[13px] font-semibold text-[#052b14]">Free Delivery <span
                                class="text-gray-500 font-medium block sm:inline">on orders above ₹499</span></span>
                    </div>

                    <div class="hidden lg:block w-px h-8 bg-gray-200"></div>

                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-leaf text-[#106e39]"></i>
                            <span class="text-[12px] font-bold text-[#052b14] leading-tight">100%<br>Natural</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-wheat-awn-circle-exclamation text-[#106e39]"></i>
                            <span class="text-[12px] font-bold text-[#052b14] leading-tight">No<br>Maida</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-regular fa-heart text-[#106e39]"></i>
                            <span class="text-[12px] font-bold text-[#052b14] leading-tight">Diabetic<br>Friendly</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-4/5 lg:w-3/4 xl:w-2/3 mb-8">
                    <div id="product-cart-ui" class="flex-1">
                        <!-- Filled dynamically by JS -->
                        <button class="w-full bg-gray-100 h-[52px] rounded-xl animate-pulse"></button>
                    </div>
                    <button id="btn-buy-now"
                        class="flex-1 bg-[#106e39] hover:bg-[#0c5c2d] text-white h-[52px] rounded-xl font-bold flex items-center justify-center gap-2 transition-all shadow-md hover:shadow-lg">
                        <i class="fa-solid fa-bolt"></i> Buy Now
                    </button>
                </div>

                <!-- Trust Badges Bottom -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 pt-6 border-t border-gray-100">
                    <div class="flex flex-col items-center text-center gap-2">
                        <i class="fa-solid fa-wallet text-[#106e39] text-xl"></i>
                        <div>
                            <span class="block text-[12px] font-bold text-[#052b14]">Secure Payment</span>
                            <span class="block text-[11px] text-gray-500 mt-0.5">100% safe & secure</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-center text-center gap-2">
                        <i class="fa-solid fa-rotate-left text-[#106e39] text-xl"></i>
                        <div>
                            <span class="block text-[12px] font-bold text-[#052b14]">Easy Returns</span>
                            <span class="block text-[11px] text-gray-500 mt-0.5">7-day return policy</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-center text-center gap-2">
                        <i class="fa-solid fa-medal text-[#106e39] text-xl"></i>
                        <div>
                            <span class="block text-[12px] font-bold text-[#052b14]">Genuine Products</span>
                            <span class="block text-[11px] text-gray-500 mt-0.5">Trusted quality</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-center text-center gap-2">
                        <i class="fa-regular fa-clock text-[#106e39] text-xl"></i>
                        <div>
                            <span class="block text-[12px] font-bold text-[#052b14]">Customer Support</span>
                            <span class="block text-[11px] text-gray-500 mt-0.5">Mon - Sat, 9AM - 6PM</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Features Banner (added as per second screenshot) -->
        <div
            class="mt-16 bg-[#f0f8f3] rounded-2xl py-8 px-8 sm:px-12 flex flex-wrap lg:flex-nowrap justify-between gap-8 border border-green-50 shadow-sm">
            <div class="flex items-center gap-4">
                <i class="fa-solid fa-leaf text-[#106e39] text-[26px]"></i>
                <span class="font-bold text-[#052b14] text-[15px] leading-tight">Made with<br>Natural Ingredients</span>
            </div>
            <div class="flex items-center gap-4">
                <i class="fa-solid fa-heart text-[#106e39] text-[26px]"></i>
                <span class="font-bold text-[#052b14] text-[15px] leading-tight">Supports<br>Healthy Lifestyle</span>
            </div>
            <div class="flex items-center gap-4">
                <i class="fa-solid fa-shield-halved text-[#106e39] text-[26px]"></i>
                <span class="font-bold text-[#052b14] text-[15px] leading-tight">Trusted by<br>Nutrition Experts</span>
            </div>
            <div class="flex items-center gap-4">
                <i class="fa-solid fa-truck-fast text-[#106e39] text-[26px]"></i>
                <span class="font-bold text-[#052b14] text-[15px] leading-tight">Fast & Reliable<br>Delivery</span>
            </div>
        </div>

        <!-- Bottom Tabs & Content Section -->
        <div class="mt-16 border-t border-gray-100 pt-8">

            <!-- Tabs -->
            <div
                class="flex items-center gap-8 border-b border-gray-100 overflow-x-auto overflow-y-hidden scrollbar-hide pb-px">
                <button id="btn-description" onclick="switchTab('description')" class="tab-btn pb-4 border-b-2 border-[#106e39] text-[#052b14] font-bold text-[15px] whitespace-nowrap">
                    Description
                </button>
                <button id="btn-ingredients" onclick="switchTab('ingredients')"
                    class="tab-btn pb-4 border-b-2 border-transparent hover:border-gray-200 text-gray-500 hover:text-gray-700 font-medium text-[15px] whitespace-nowrap transition-colors">
                    Ingredients
                </button>
                <button id="btn-nutrition" onclick="switchTab('nutrition')"
                    class="tab-btn pb-4 border-b-2 border-transparent hover:border-gray-200 text-gray-500 hover:text-gray-700 font-medium text-[15px] whitespace-nowrap transition-colors">
                    Nutritional Information
                </button>
                <button id="btn-usage" onclick="switchTab('usage')"
                    class="tab-btn pb-4 border-b-2 border-transparent hover:border-gray-200 text-gray-500 hover:text-gray-700 font-medium text-[15px] whitespace-nowrap transition-colors">
                    How to Use
                </button>

            </div>

            <!-- Tab Content -->
            <div id="tab-description" class="tab-pane py-10 flex flex-col lg:flex-row gap-12">

                <!-- Left: Description -->
                <div class="w-full lg:w-[60%] xl:w-[65%]">
                    <h2 class="text-2xl font-extrabold text-[#052b14] mb-4">Product Description</h2>
                    <div id="dynamic-description" class="text-[15px] text-gray-600 leading-relaxed mb-10 font-medium whitespace-pre-line">
                        Loading description...
                    </div>

                    <!-- Feature Icons Row -->
                    <div class="flex flex-wrap items-center gap-6 xl:gap-8">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-[#f0f8f3] flex items-center justify-center text-[#106e39]">
                                <i class="fa-solid fa-leaf"></i>
                            </div>
                            <span class="text-[13px] font-bold text-[#052b14]">Low Carb</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-[#f0f8f3] flex items-center justify-center text-[#106e39]">
                                <i class="fa-solid fa-wheat-awn"></i>
                            </div>
                            <span class="text-[13px] font-bold text-[#052b14]">High Fibre</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-[#f0f8f3] flex items-center justify-center text-[#106e39]">
                                <i class="fa-solid fa-ban"></i>
                            </div>
                            <span class="text-[13px] font-bold text-[#052b14]">No Maida</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-[#f0f8f3] flex items-center justify-center text-[#106e39]">
                                <i class="fa-solid fa-droplet"></i>
                            </div>
                            <span class="text-[13px] font-bold text-[#052b14]">Diabetic Friendly</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-[#f0f8f3] flex items-center justify-center text-[#106e39]">
                                <i class="fa-solid fa-heart"></i>
                            </div>
                            <span class="text-[13px] font-bold text-[#052b14]">For a Healthier You</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Why Choose Box -->
                <div class="w-full lg:w-[40%] xl:w-[35%]">
                    <div class="bg-[#f4f9f6] rounded-2xl p-6 relative overflow-hidden border border-[#e8f3ec]">
                        <!-- Decorative leaf in background -->
                        <div
                            class="absolute -bottom-8 -right-8 text-[#106e39] opacity-10 text-[120px] pointer-events-none">
                            <i class="fa-solid fa-leaf"></i>
                        </div>

                        <div class="flex items-center gap-3 mb-6 relative z-10">
                            <div
                                class="w-10 h-10 rounded-lg bg-[#dcfce7] flex items-center justify-center text-[#106e39] shrink-0">
                                <i class="fa-solid fa-seedling text-lg"></i>
                            </div>
                            <h3 class="text-lg font-extrabold text-[#052b14]">Why Choose NutroActive?</h3>
                        </div>

                        <ul class="space-y-3.5 relative z-10">
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-check text-[#106e39] mt-1 text-[14px]"></i>
                                <span class="text-[14px] text-[#052b14] font-medium leading-snug">Made from natural,
                                    high-quality ingredients</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-check text-[#106e39] mt-1 text-[14px]"></i>
                                <span class="text-[14px] text-[#052b14] font-medium leading-snug">Helps manage blood
                                    sugar levels</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-check text-[#106e39] mt-1 text-[14px]"></i>
                                <span class="text-[14px] text-[#052b14] font-medium leading-snug">Supports weight
                                    management</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-check text-[#106e39] mt-1 text-[14px]"></i>
                                <span class="text-[14px] text-[#052b14] font-medium leading-snug">No added maida or
                                    preservatives</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-check text-[#106e39] mt-1 text-[14px]"></i>
                                <span class="text-[14px] text-[#052b14] font-medium leading-snug">Great taste, same
                                    traditional feel</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-check text-[#106e39] mt-1 text-[14px]"></i>
                                <span class="text-[14px] text-[#052b14] font-medium leading-snug">Trusted by nutrition
                                    experts</span>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

            <!-- Tab Ingredients -->
            <div id="tab-ingredients" class="tab-pane hidden py-10">
                <h2 class="text-2xl font-extrabold text-[#052b14] mb-4">Ingredients</h2>
                <div id="dynamic-ingredients" class="text-[15px] text-gray-600 leading-relaxed font-medium whitespace-pre-line">
                    Loading ingredients...
                </div>
            </div>

            <!-- Tab Nutritional Information -->
            <div id="tab-nutrition" class="tab-pane hidden py-10">
                <h2 class="text-2xl font-extrabold text-[#052b14] mb-4">Nutritional Information</h2>
                <div id="dynamic-nutrition" class="text-[15px] text-gray-600 leading-relaxed font-medium whitespace-pre-line">
                    Loading nutritional information...
                </div>
            </div>

            <!-- Tab How to Use -->
            <div id="tab-usage" class="tab-pane hidden py-10">
                <h2 class="text-2xl font-extrabold text-[#052b14] mb-4">How to Use</h2>
                <div id="dynamic-usage" class="text-[15px] text-gray-600 leading-relaxed font-medium whitespace-pre-line">
                    Loading instructions...
                </div>
            </div>



        </div>

        <!-- Standalone FAQ Section -->
        <div class="mt-20 mb-10 pt-16 border-t border-gray-100 flex flex-col lg:flex-row gap-12 xl:gap-20">
            
            <!-- Left Side: Heading and CTA -->
            <div class="w-full lg:w-[40%] flex flex-col items-start">
                <span class="bg-[#ebf5ef] text-[#106e39] text-[11px] font-bold px-3 py-1.5 rounded-full mb-6 tracking-widest uppercase">FAQS</span>
                <h2 class="text-4xl lg:text-5xl font-extrabold text-[#052b14] mb-6 leading-[1.1]">Product Questions —<br>Answered</h2>
                <p class="text-[15px] text-gray-500 leading-relaxed font-medium mb-8">
                    Have a specific question about this product or its ingredients? We're happy to answer before you even order.
                </p>
                <button class="bg-[#106e39] hover:bg-[#0d592e] text-white h-[50px] px-8 rounded-full font-bold flex items-center justify-center gap-2 shadow-[0_4px_12px_rgba(16,110,57,0.2)] transition-all">
                    <i class="fa-brands fa-whatsapp text-lg"></i> Ask on WhatsApp
                </button>
            </div>

            <!-- Right Side: Accordion -->
            <div class="w-full lg:w-[60%] flex flex-col gap-4">
                
                <details class="group bg-white border border-gray-200 rounded-xl overflow-hidden" open>
                    <summary class="flex items-center justify-between p-6 cursor-pointer list-none font-bold text-[#052b14] hover:bg-gray-50 transition-colors">
                        Is this combo suitable for diabetics?
                        <i class="fa-solid fa-chevron-down text-gray-400 group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <div class="px-6 pb-6 text-gray-500 text-[14px] leading-relaxed">
                        Yes! Both the atta and sugar have a very low glycemic index. In many cases, the right dietary changes can significantly reduce or even eliminate the need for medication — under doctor supervision.
                    </div>
                </details>

                <details class="group bg-white border border-gray-200 rounded-xl overflow-hidden">
                    <summary class="flex items-center justify-between p-6 cursor-pointer list-none font-bold text-[#052b14] hover:bg-gray-50 transition-colors">
                        Does it taste like regular atta?
                        <i class="fa-solid fa-chevron-down text-gray-400 group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <div class="px-6 pb-6 text-gray-500 text-[14px] leading-relaxed">
                        It has a slightly nuttier flavor but the texture and eating experience are very close to traditional wheat rotis. It is perfect for making parathas, puris, and rotis.
                    </div>
                </details>

                <details class="group bg-white border border-gray-200 rounded-xl overflow-hidden">
                    <summary class="flex items-center justify-between p-6 cursor-pointer list-none font-bold text-[#052b14] hover:bg-gray-50 transition-colors">
                        Can I bake cakes with this?
                        <i class="fa-solid fa-chevron-down text-gray-400 group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <div class="px-6 pb-6 text-gray-500 text-[14px] leading-relaxed">
                        Absolutely. The Keto Sugar in this combo can be used in a 1:1 ratio for regular sugar in baking, and the flour is great for dense, nutritious low-carb cakes.
                    </div>
                </details>

            </div>
        </div>

        <!-- Tab Reviews -->
        <div class="mt-20 mb-10 pt-16 border-t border-gray-100 w-full">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-[22px] font-bold text-[#212121]">Ratings and reviews</h2>
                <button onclick="openWriteReviewModal()" class="border border-[#106e39] text-[#106e39] px-5 py-2 rounded-lg font-bold text-[14px] hover:bg-[#106e39] hover:text-white transition-colors shadow-sm">Write a review</button>
            </div>
                
                <!-- Rating Summary -->
                <div class="flex items-center gap-2 mb-1" id="reviewAggregateStats">
                    <div class="text-[28px] font-medium text-[#212121] leading-none"><span id="avgRatingText">--</span> <i class="fa-solid fa-star text-[18px] text-[#212121] -mt-1"></i></div>
                    <span class="bg-[#e2f6e9] text-[#106e39] text-[13px] font-medium px-2 py-0.5 rounded ml-2" id="ratingBadgeText">No Ratings Yet</span>
                </div>
                <div class="text-[#878787] text-[13px] mb-6">
                    based on <span id="totalRatingsText">0</span> ratings by <i class="fa-regular fa-circle-check text-[#878787] ml-1 mr-0.5"></i>Verified Buyers
                </div>

                <!-- Image Grid -->
                <div id="customerPhotosGrid" style="display: none; grid-template-columns: repeat(4, 1fr); grid-template-rows: repeat(2, 1fr); gap: 6px; aspect-ratio: 3/1; width: 100%; margin-bottom: 20px;">
                    <!-- Filled dynamically via JS -->
                </div>

                <!-- Feature Ratings (Flipkart Style) -->
                <div class="flex flex-wrap items-center gap-x-6 gap-y-2 mb-8">
                    <div class="flex items-center gap-1.5 text-[14px] text-[#212121]">
                        Taste <span class="font-bold flex items-center gap-0.5 ml-1">4.5 <i class="fa-solid fa-star text-[10px] text-[#106e39]"></i></span>
                    </div>
                    <div class="flex items-center gap-1.5 text-[14px] text-[#212121]">
                        Texture <span class="font-bold flex items-center gap-0.5 ml-1">4.4 <i class="fa-solid fa-star text-[10px] text-[#106e39]"></i></span>
                    </div>
                    <div class="flex items-center gap-1.5 text-[14px] text-[#212121]">
                        Health Benefits <span class="font-bold flex items-center gap-0.5 ml-1">4.8 <i class="fa-solid fa-star text-[10px] text-[#106e39]"></i></span>
                    </div>
                    <div class="flex items-center gap-1.5 text-[14px] text-[#212121]">
                        Packaging <span class="font-bold flex items-center gap-0.5 ml-1">4.2 <i class="fa-solid fa-star text-[10px] text-[#106e39]"></i></span>
                    </div>
                    <div class="flex items-center gap-1.5 text-[14px] text-[#212121]">
                        Value for Money <span class="font-bold flex items-center gap-0.5 ml-1">4.1 <i class="fa-solid fa-star text-[10px] text-[#106e39]"></i></span>
                    </div>
                </div>

                <!-- Reviews Scroll List (Discrete Auto-Slide) -->
                <style>
                    /* Hide scrollbar for Chrome, Safari and Opera */
                    #reviewsScrollContainer::-webkit-scrollbar {
                        display: none;
                    }
                </style>
                <div class="relative mb-6 group">
                    <div id="reviewsScrollContainer" style="-ms-overflow-style: none; scrollbar-width: none;" class="flex overflow-x-auto gap-4 pb-2 snap-x">
                        <div class="w-full text-center text-gray-500 py-8" id="noReviewsMsg" style="display: none;">No reviews yet. Be the first to write a review!</div>
                    </div>
                    
                    <!-- Right Arrow Button Overlay -->
                    <button onclick="document.getElementById('reviewsScrollContainer').scrollBy({ left: 276, behavior: 'smooth' })" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 bg-white shadow-[0_2px_8px_rgba(0,0,0,0.15)] border border-gray-100 w-12 h-12 rounded-full flex items-center justify-center text-gray-700 hover:text-black z-10 opacity-0 group-hover:opacity-100 transition-opacity">
                        <i class="fa-solid fa-chevron-right text-lg"></i>
                    </button>
                </div>

                <script>
                    let reviewSliderInterval;
                    function initReviewSlider() {
                        const slider = document.getElementById('reviewsScrollContainer');
                        if(slider && slider.children.length > 2) {
                            if(reviewSliderInterval) clearInterval(reviewSliderInterval);
                            
                            // Clone all cards for a seamless infinite loop
                            const originalCount = slider.children.length;
                            const html = slider.innerHTML;
                            slider.innerHTML += html; // Add clones
                            
                            reviewSliderInterval = setInterval(() => {
                                // Only slide if user isn't hovering over the reviews
                                if(!slider.matches(':hover')) {
                                    // Calculate exact distance from original to cloned cards
                                    const jumpDistance = slider.children[originalCount].offsetLeft - slider.children[0].offsetLeft;
                                    
                                    // If we've reached the cloned set, instantly snap back to the original set
                                    if(slider.scrollLeft >= jumpDistance) {
                                        slider.scrollBy({ left: -jumpDistance, behavior: 'auto' });
                                    }
                                    
                                    // Allow a tiny delay for the snap to process, then smoothly slide the next card
                                    setTimeout(() => {
                                        slider.scrollBy({ left: 276, behavior: 'smooth' });
                                    }, 50);
                                }
                            }, 3500); // Slide every 3.5 seconds
                        }
                    }
                </script>


            </div>
            
            <!-- You May Also Like Section -->
            <div class="mt-10 mb-10 pt-10 border-t border-gray-100 w-full relative">
                <style>
                    #youMayAlsoLikeScroll::-webkit-scrollbar { display: none; }
                </style>
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-[28px] font-bold text-[#1e293b]">You May Also Like</h2>
                    <a href="../store" class="text-[#106e39] font-medium text-[14px] hover:underline flex items-center gap-1">View All Products <i class="fa-solid fa-arrow-right text-[12px]"></i></a>
                </div>

                <!-- Slider Container -->
                <div class="relative overflow-hidden -mx-4 px-4 lg:mx-0 lg:px-0 pb-6">
                    <div id="youMayAlsoLikeScroll" class="flex gap-6 flex-nowrap" style="scrollbar-width: none; -ms-overflow-style: none;">
                        <!-- Dynamic Product Cards will be injected here by JS -->
                    </div>
                </div>
            </div>
        </main>

    <hbm-footer base-path="../"></hbm-footer>
    <script src="../js/api.js"></script>
    <script src="../js/components_v15.js"></script>
    <script src="../js/store.js?v=1789550392"></script>

    <!-- Thumbnail Script -->
    <script>
        function changeMainImage(btn, imageUrl) {
            // Update main image source
            document.getElementById('product-main-image').src = imageUrl;

            // Remove active border from all thumbnails
            const thumbnails = document.querySelectorAll('.thumbnail-btn');
            thumbnails.forEach(t => {
                t.classList.remove('border-black');
                t.classList.add('border-transparent');
                t.classList.add('hover:border-gray-300'); // restore hover state
            });

            // Add active border to clicked thumbnail
            btn.classList.remove('border-transparent');
            btn.classList.remove('hover:border-gray-300'); // remove hover state when active
            btn.classList.add('border-black');
        }


        function switchTab(tabId) {
            // Hide all tab panes
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.add('hidden');
            });
            // Show the target tab pane
            document.getElementById('tab-' + tabId).classList.remove('hidden');

            // Reset all tab buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('border-[#106e39]', 'text-[#052b14]', 'font-bold');
                btn.classList.add('border-transparent', 'text-gray-500', 'font-medium');
            });

            // Set active class on clicked button
            const activeBtn = document.getElementById('btn-' + tabId);
            if (activeBtn) {
                activeBtn.classList.remove('border-transparent', 'text-gray-500', 'font-medium');
                activeBtn.classList.add('border-[#106e39]', 'text-[#052b14]', 'font-bold');
            }
        }
        
        // Modal toggles
        function openAllImagesModal() {
            document.getElementById('allImagesModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
        function closeAllImagesModal() {
            document.getElementById('allImagesModal').style.display = 'none';
            document.body.style.overflow = '';
        }

        
        // Generate placeholder images for the modal grid
        document.addEventListener('DOMContentLoaded', () => {
            const grid = document.getElementById('allImagesGrid');
            if(!grid) return;
            const imageUrls = [
                'https://images.unsplash.com/photo-1627485937980-221c88ac04f9?w=400&h=400&fit=crop',
                'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400&h=400&fit=crop',
                'https://images.unsplash.com/photo-1625940629601-8f2570086b06?w=400&h=400&fit=crop',
                'https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=400&h=400&fit=crop',
                'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=400&q=80',
                'https://images.unsplash.com/photo-1490645935967-10de6ba17061?auto=format&fit=crop&w=400&q=80',
            ];
            window.allGalleryImages = [];
            let html = '';
            for(let i = 0; i < 30; i++) {
                const src = imageUrls[i % imageUrls.length];
                window.allGalleryImages.push(src);
                html += `<div onclick="openSingleImageModal(${i}, window.allGalleryImages)" style="aspect-ratio: 1/1; background: #f3f4f6; overflow: hidden; cursor: pointer;">
                            <img src="${src}" style="width: 100%; height: 100%; object-fit: cover; transition: opacity 0.2s;" onmouseover="this.style.opacity=0.8" onmouseout="this.style.opacity=1" />
                         </div>`;
            }
            grid.innerHTML = html;
        });
    </script>

    <!-- All Images Modal -->
    <div id="allImagesModal" style="display: none; flex-direction: column; position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 9999; background: white; overflow: hidden; width: 100vw; height: 100vh;">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 shadow-sm" style="background: white; z-index: 10;">
            <h3 class="text-xl font-bold text-[#212121]" id="allPhotosTitle">Customer Photos (0)</h3>
            <button onclick="closeAllImagesModal()" class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-gray-100 text-gray-500 hover:text-black transition-colors" style="cursor: pointer;">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <!-- Grid Content -->
        <div style="flex: 1; overflow-y: auto; padding: 16px;">
            <div id="allImagesGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 8px;">
                <!-- Filled dynamically by JavaScript -->
            </div>
        </div>
    </div>

    <script>
        function renderStars(rating, sizeClass = 'text-[10px]') {
            let html = '';
            for (let i = 1; i <= 5; i++) {
                if (rating >= i) {
                    html += `<i class="fa-solid fa-star ${sizeClass}"></i>`;
                } else if (rating >= i - 0.5) {
                    html += `<i class="fa-solid fa-star-half-stroke ${sizeClass}"></i>`;
                } else {
                    html += `<i class="fa-regular fa-star ${sizeClass}"></i>`;
                }
            }
            return html;
        }

        function timeAgo(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const seconds = Math.floor((now - date) / 1000);
            
            let interval = Math.floor(seconds / 31536000);
            if (interval > 1) return interval + " years ago";
            if (interval === 1) return "1 year ago";
            interval = Math.floor(seconds / 2592000);
            if (interval > 1) return interval + " months ago";
            if (interval === 1) return "1 month ago";
            interval = Math.floor(seconds / 86400);
            if (interval > 1) return interval + " days ago";
            if (interval === 1) return "1 day ago";
            return "today";
        }

        async function loadProductReviews(productId) {
            try {
                const data = await window.HBM_API.request(`/store/products/${productId}/reviews`);
                
                if (data.success) {
                    const stats = data.data.stats;
                    const reviews = data.data.reviews;
                    const photos = data.data.photos;
                    
                    // Update Aggregate Stats
                    if(stats.total_reviews > 0) {
                        const avg = parseFloat(stats.average_rating).toFixed(1);
                        document.getElementById('avgRatingText').textContent = avg;
                        document.getElementById('totalRatingsText').textContent = stats.total_reviews;
                        
                        const badge = document.getElementById('ratingBadgeText');
                        if(avg >= 4.5) badge.textContent = 'Excellent';
                        else if(avg >= 4) badge.textContent = 'Very Good';
                        else if(avg >= 3) badge.textContent = 'Good';
                        else badge.textContent = 'Average';
                    }

                    // Update Review List
                    const scrollContainer = document.getElementById('reviewsScrollContainer');
                    const noReviewsMsg = document.getElementById('noReviewsMsg');
                    
                    if (reviews.length === 0) {
                        noReviewsMsg.style.display = 'block';
                    } else {
                        noReviewsMsg.style.display = 'none';
                        let reviewsHtml = '';
                        reviews.forEach(r => {
                            let photosHtml = '';
                            if(r.photos && r.photos.length > 0) {
                                photosHtml = '<div class="flex gap-2 mt-3 overflow-x-auto">';
                                r.photos.forEach(img => {
                                    photosHtml += `<img src="${img}" class="h-16 w-16 object-cover rounded shadow-sm border border-gray-100">`;
                                });
                                photosHtml += '</div>';
                            }
                            
                            reviewsHtml += `
                            <div style="min-width: 260px; width: 260px; background-color: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 16px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);" class="shrink-0 snap-start flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-2">
                                            <span class="bg-[#106e39] text-white font-bold" style="font-size: 12px; padding: 2px 6px; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px; line-height: 1;">${r.rating} <i class="fa-solid fa-star" style="font-size: 9px; margin-bottom: 1px;"></i></span>
                                            <span class="font-bold text-[#212121] text-[13px] truncate max-w-[120px]">${r.title}</span>
                                        </div>
                                        <span class="text-[#878787] text-[12px]">${timeAgo(r.created_at)}</span>
                                    </div>
                                    <p class="text-[#212121] text-[13px] line-clamp-3 leading-snug">${r.content}</p>
                                    ${photosHtml}
                                </div>
                                <div class="flex flex-col gap-1 mt-4">
                                    <span class="text-[#878787] text-[12px] font-medium">${r.reviewer_name}</span>
                                    <span class="text-[#878787] text-[12px] flex items-center gap-1"><i class="fa-regular fa-circle-check"></i> Verified Buyer</span>
                                </div>
                            </div>`;
                        });
                        scrollContainer.innerHTML = reviewsHtml;
                        initReviewSlider();
                    }

                    // Update Photos Gallery
                    const photoGrid = document.getElementById('customerPhotosGrid');
                    const allPhotosTitle = document.getElementById('allPhotosTitle');
                    
                    if (photos && photos.length > 0) {
                        photoGrid.style.display = 'grid';
                        allPhotosTitle.textContent = `Customer Photos (${photos.length})`;
                        
                        // Populate modal grid
                        const allImagesGrid = document.getElementById('allImagesGrid');
                        if (allImagesGrid) {
                            window.allGalleryImages = photos.map(p => p.image_path);
                            let modalHtml = '';
                            photos.forEach((p, idx) => {
                                modalHtml += `<div onclick="openSingleImageModal(${idx}, window.allGalleryImages)" style="aspect-ratio: 1/1; background: #f3f4f6; overflow: hidden; cursor: pointer;">
                                                <img src="${p.image_path}" style="width: 100%; height: 100%; object-fit: cover; transition: opacity 0.2s;" onmouseover="this.style.opacity=0.8" onmouseout="this.style.opacity=1" />
                                             </div>`;
                            });
                            allImagesGrid.innerHTML = modalHtml;
                        }

                        // Populate small display grid (up to 5 photos)
                        let gridHtml = '';
                        if (photos.length > 0) {
                            gridHtml += `<div onclick="openAllImagesModal()" style="grid-column: span 2; grid-row: span 2;" class="relative overflow-hidden rounded-[4px] cursor-pointer">
                                            <img src="${photos[0].image_path}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" />
                                         </div>`;
                        }
                        if (photos.length > 1) {
                            gridHtml += `<div onclick="openAllImagesModal()" style="grid-column: span 1; grid-row: span 1;" class="relative overflow-hidden rounded-[4px] cursor-pointer">
                                            <img src="${photos[1].image_path}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" />
                                         </div>`;
                        }
                        if (photos.length > 2) {
                            gridHtml += `<div onclick="openAllImagesModal()" style="grid-column: span 1; grid-row: span 1;" class="relative overflow-hidden rounded-[4px] cursor-pointer">
                                            <img src="${photos[2].image_path}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" />
                                         </div>`;
                        }
                        if (photos.length > 3) {
                            gridHtml += `<div onclick="openAllImagesModal()" style="grid-column: span 1; grid-row: span 1;" class="relative overflow-hidden rounded-[4px] cursor-pointer">
                                            <img src="${photos[3].image_path}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" />
                                         </div>`;
                        }
                        if (photos.length > 4) {
                            let overlay = '';
                            if (photos.length > 5) {
                                overlay = `<div class="absolute inset-0 bg-black/60 flex items-center justify-center transition-colors">
                                              <span class="text-white font-bold text-xl">+${photos.length - 5}</span>
                                           </div>`;
                            }
                            gridHtml += `<div onclick="openAllImagesModal()" style="grid-column: span 1; grid-row: span 1;" class="relative rounded-[4px] cursor-pointer overflow-hidden group">
                                            <img src="${photos[4].image_path}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                                            ${overlay}
                                         </div>`;
                        }
                        photoGrid.innerHTML = gridHtml;
                    } else {
                        photoGrid.style.display = 'none';
                    }
                }
            } catch (err) {
                console.error("Error loading reviews:", err);
            }
        }
    </script>

    <!-- Write a Review Modal -->
    <div id="writeReviewModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 10000; align-items: center; justify-content: center; padding: 1rem;">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,0.6);" class="backdrop-blur-sm" onclick="closeWriteReviewModal()"></div>
        <div style="position: relative; background-color: white; border-radius: 1rem; width: 100%; max-width: 600px; max-height: 90vh; overflow-y: auto; display: flex; flex-direction: column; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
            
            <!-- Header -->
            <div class="px-8 pt-8 pb-4">
                <div class="flex items-start justify-between mb-2">
                    <h2 class="text-[28px] font-bold text-[#212121] leading-tight">Write a Review</h2>
                    <button onclick="closeWriteReviewModal()" class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-gray-100 text-gray-500 hover:text-black transition-colors">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
                <p class="text-[#878787] text-[14px]">You're reviewing: <span class="text-[#212121] font-semibold">NutroActive Keto Atta 750g with Keto Sugar 250g Combo</span></p>
            </div>

            <!-- Form Body -->
            <div class="px-8 pb-8 flex-1 flex flex-col gap-6">
                
                <!-- Error Message Container -->
                <div id="reviewErrorContainer" class="hidden bg-red-50 text-red-700 p-3 rounded-lg text-sm mb-2">
                    <i class="fa-solid fa-circle-exclamation mr-2"></i><span id="reviewErrorMsg"></span>
                </div>
                
                <!-- Rating -->
                <div>
                    <label class="block text-[#212121] font-bold text-[14px] mb-2">Overall Rating <span class="text-red-500">*</span></label>
                    <div class="flex items-center gap-1 cursor-pointer" id="starRatingContainer">
                        <i class="fa-regular fa-star text-[32px] text-gray-300 hover:text-[#ea580c] transition-colors" onclick="setRating(1)"></i>
                        <i class="fa-regular fa-star text-[32px] text-gray-300 hover:text-[#ea580c] transition-colors" onclick="setRating(2)"></i>
                        <i class="fa-regular fa-star text-[32px] text-gray-300 hover:text-[#ea580c] transition-colors" onclick="setRating(3)"></i>
                        <i class="fa-regular fa-star text-[32px] text-gray-300 hover:text-[#ea580c] transition-colors" onclick="setRating(4)"></i>
                        <i class="fa-regular fa-star text-[32px] text-gray-300 hover:text-[#ea580c] transition-colors" onclick="setRating(5)"></i>
                    </div>
                </div>

                <!-- Review Title -->
                <div>
                    <label class="block text-[#212121] font-bold text-[14px] mb-2">Review Title <span class="text-red-500">*</span></label>
                    <input type="text" id="reviewTitleInput" placeholder="Summarize your experience in a few words" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-[14px] focus:outline-none focus:border-[#106e39] focus:ring-1 focus:ring-[#106e39] transition-all placeholder:text-gray-400">
                </div>

                <!-- Your Review -->
                <div>
                    <label class="block text-[#212121] font-bold text-[14px] mb-2">Your Review</label>
                    <textarea id="reviewContentInput" rows="5" placeholder="Share your experience with this product..." class="w-full border border-gray-300 rounded-lg px-4 py-3 text-[14px] focus:outline-none focus:border-[#106e39] focus:ring-1 focus:ring-[#106e39] transition-all placeholder:text-gray-400 resize-none"></textarea>
                </div>

                <!-- Size / Variant Purchased -->
                <div>
                    <label class="block text-[#212121] font-bold text-[14px] mb-2">Size / Variant Purchased <span class="font-normal text-gray-400">(optional)</span></label>
                    <input type="text" id="reviewVariantInput" placeholder="e.g. 10 Lb, 20 Lb" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-[14px] focus:outline-none focus:border-[#106e39] focus:ring-1 focus:ring-[#106e39] transition-all placeholder:text-gray-400">
                </div>

                <!-- Add Photos -->
                <div>
                    <label class="block text-[#212121] font-bold text-[14px] mb-2">Add Photos <span class="font-normal text-gray-400">(up to 3)</span></label>
                    <input type="file" id="reviewPhotoInput" accept="image/jpeg, image/png, image/webp" multiple style="display: none;" onchange="updatePhotoCount(this)">
                    <button onclick="document.getElementById('reviewPhotoInput').click()" class="w-24 h-24 rounded-lg border-2 border-dashed border-gray-300 flex flex-col items-center justify-center gap-2 text-gray-400 hover:text-[#106e39] hover:border-[#106e39] transition-all">
                        <i class="fa-solid fa-camera text-[24px]"></i>
                        <span id="photoCountText" class="text-[12px] font-medium text-center leading-tight">Add Photo</span>
                    </button>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button id="btn-submit-review" onclick="submitReview()" style="background-color: #ea580c; color: white;" class="px-8 py-3 rounded-lg font-bold text-[15px] hover:opacity-90 transition-opacity shadow-md">
                        Submit Review
                    </button>
                </div>

            </div>
        </div>
    </div>

    <script>
        let currentReviewRating = 0;

        function updatePhotoCount(input) {
            const countText = document.getElementById('photoCountText');
            if (input.files && input.files.length > 0) {
                const count = Math.min(input.files.length, 3);
                countText.textContent = `${count} Photo${count > 1 ? 's' : ''} Selected`;
                countText.classList.add('text-[#106e39]', 'font-bold');
            } else {
                countText.textContent = 'Add Photo';
                countText.classList.remove('text-[#106e39]', 'font-bold');
            }
        }

        function openWriteReviewModal() {
            document.getElementById('writeReviewModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
            document.getElementById('reviewErrorContainer').classList.add('hidden');
        }
        function closeWriteReviewModal() {
            document.getElementById('writeReviewModal').style.display = 'none';
            document.body.style.overflow = '';
            // Reset form visually when closed
            setRating(0);
            document.getElementById('reviewTitleInput').value = '';
            document.getElementById('reviewContentInput').value = '';
            document.getElementById('reviewVariantInput').value = '';
            document.getElementById('reviewErrorContainer').classList.add('hidden');
        }
        
        function setRating(rating) {
            currentReviewRating = rating;
            const container = document.getElementById('starRatingContainer');
            if(!container) return;
            const stars = container.querySelectorAll('i');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('fa-regular', 'text-gray-300');
                    star.classList.add('fa-solid');
                    star.style.color = '#ea580c';
                } else {
                    star.classList.remove('fa-solid');
                    star.classList.add('fa-regular', 'text-gray-300');
                    star.style.color = '';
                }
            });
        }
        
        function submitReview() {
            const errorContainer = document.getElementById('reviewErrorContainer');
            const errorMsg = document.getElementById('reviewErrorMsg');
            const submitBtn = document.getElementById('btn-submit-review');
            
            errorContainer.classList.add('hidden');
            
            const title = document.getElementById('reviewTitleInput').value.trim();
            const content = document.getElementById('reviewContentInput').value.trim();
            const variant = document.getElementById('reviewVariantInput').value.trim();
            const productId = new URLSearchParams(window.location.search).get('id');

            if (!productId) {
                errorMsg.textContent = "Product not found.";
                errorContainer.classList.remove('hidden');
                return;
            }

            if (currentReviewRating === 0) {
                errorMsg.textContent = "Please select a rating.";
                errorContainer.classList.remove('hidden');
                return;
            }

            if (!title) {
                errorMsg.textContent = "Please enter a review title.";
                errorContainer.classList.remove('hidden');
                return;
            }

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Submitting...';
            submitBtn.style.opacity = '0.7';

            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('rating', currentReviewRating);
            formData.append('title', title);
            formData.append('content', content);
            formData.append('variant', variant);
            
            const photoInput = document.getElementById('reviewPhotoInput');
            if (photoInput && photoInput.files.length > 0) {
                const maxFiles = Math.min(photoInput.files.length, 3);
                for(let i=0; i<maxFiles; i++) {
                    formData.append('photos[]', photoInput.files[i]);
                }
            }

            // Since HBM_API.request supports FormData, we can use it directly
            window.HBM_API.request('/store/reviews', 'POST', formData)
            .then(res => {
                if (res.success) {
                    closeWriteReviewModal();
                    alert('Review submitted successfully! It will be published once approved.');
                } else {
                    errorMsg.textContent = res.message || "Failed to submit review. Please try again.";
                    errorContainer.classList.remove('hidden');
                    if (res.message && res.message.toLowerCase().includes('login')) {
                        errorMsg.innerHTML = 'You must be logged in to submit a review. <a href="/login" class="underline font-bold">Login here</a>.';
                    }
                }
            })
            .catch(err => {
                console.error('Review submit error:', err);
                errorMsg.textContent = "A network error occurred. Please try again later.";
                errorContainer.classList.remove('hidden');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Submit Review';
                submitBtn.style.opacity = '1';
            });
        }

        const gridImages = [
            'https://images.unsplash.com/photo-1627485937980-221c88ac04f9?w=800&h=800&fit=crop',
            'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400&h=400&fit=crop',
            'https://images.unsplash.com/photo-1625940629601-8f2570086b06?w=400&h=400&fit=crop',
            'https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=400&h=400&fit=crop'
        ];
        let currentSingleImageIndex = 0;
        let currentImageArray = gridImages;

        function openSingleImageModal(index, imageArray = gridImages) {
            currentSingleImageIndex = index;
            currentImageArray = imageArray;
            updateSingleImageView();
            document.getElementById('singleImageModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function updateSingleImageView() {
            document.getElementById('singleImageDisplay').src = currentImageArray[currentSingleImageIndex];
        }

        function closeSingleImageModal() {
            document.getElementById('singleImageModal').style.display = 'none';
            document.body.style.overflow = '';
        }

        function nextSingleImage(event) {
            if(event) event.stopPropagation();
            currentSingleImageIndex = (currentSingleImageIndex + 1) % currentImageArray.length;
            updateSingleImageView();
        }

        function prevSingleImage(event) {
            if(event) event.stopPropagation();
            currentSingleImageIndex = (currentSingleImageIndex - 1 + currentImageArray.length) % currentImageArray.length;
            updateSingleImageView();
        }
    </script>

    <!-- Single Image Modal -->
    <div id="singleImageModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 11000; align-items: center; justify-content: center; padding: 2rem;">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,0.85);" class="backdrop-blur-sm" onclick="closeSingleImageModal()"></div>
        
        <div style="position: relative; width: 90vw; height: 90vh; display: flex; align-items: center; justify-content: center;">
            <button onclick="closeSingleImageModal()" style="position: absolute; top: -40px; right: -20px; cursor: pointer; color: white; background: none; border: none; font-size: 28px; padding: 4px; z-index: 20;">
                <i class="fa-solid fa-xmark"></i>
            </button>
            
            <button onclick="prevSingleImage(event)" style="position: absolute; left: -20px; top: 50%; transform: translateY(-50%); cursor: pointer; color: white; background: rgba(0,0,0,0.5); border: none; font-size: 24px; padding: 12px 18px; border-radius: 50%; z-index: 20; transition: background 0.2s;" onmouseover="this.style.background='rgba(0,0,0,0.8)'" onmouseout="this.style.background='rgba(0,0,0,0.5)'">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            
            <img id="singleImageDisplay" src="" style="width: 100%; height: 100%; object-fit: contain; border-radius: 8px; filter: drop-shadow(0 25px 50px rgba(0, 0, 0, 0.5));" alt="Enlarged customer photo" />
            
            <button onclick="nextSingleImage(event)" style="position: absolute; right: -20px; top: 50%; transform: translateY(-50%); cursor: pointer; color: white; background: rgba(0,0,0,0.5); border: none; font-size: 24px; padding: 12px 18px; border-radius: 50%; z-index: 20; transition: background 0.2s;" onmouseover="this.style.background='rgba(0,0,0,0.8)'" onmouseout="this.style.background='rgba(0,0,0,0.5)'">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const urlProductId = new URLSearchParams(window.location.search).get('id');
            if (urlProductId) {
                loadProductReviews(urlProductId);
            }
        });
    </script>
</body>

</html>