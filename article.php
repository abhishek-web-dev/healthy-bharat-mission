<?php
$articleSlug = isset($_GET['slug']) ? $_GET['slug'] : '';
if (!$articleSlug) {
    // Fallback for old links or if someone just visits article.php
    $articleSlug = isset($_GET['id']) ? $_GET['id'] : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="page-title">Loading... - Healthy Bharat Mission</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Built Tailwind CSS -->
    <link href="dist/output.css" rel="stylesheet">
    <style>
        @media (min-width: 768px) {
            .md\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (min-width: 1024px) {
            .lg\:grid-cols-5 { grid-template-columns: repeat(5, minmax(0, 1fr)); }
            .lg\:col-span-2 { grid-column: span 2 / span 2; }
            .lg\:col-span-3 { grid-column: span 3 / span 3; }
            .lg\:gap-16 { gap: 4rem; }
        }
        .font-handwriting { font-family: 'Caveat', cursive; }
        
        /* Article Content Styling */
        .article-content h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }
        .article-content p {
            color: #475569;
            line-height: 1.7;
            margin-bottom: 1rem;
        }
        .article-content ul {
            margin-bottom: 1.5rem;
        }
        .article-content li {
            color: #475569;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: flex-start;
        }
        .article-content li::before {
            content: '\f058'; /* FontAwesome check-circle */
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: #106e39;
            margin-right: 0.75rem;
            margin-top: 0.25rem;
        }
        .article-quote {
            background-color: #f4f8f2;
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin: 2rem 0;
        }
        .article-quote i {
            color: #106e39;
            font-size: 1.5rem;
            margin-top: 0.25rem;
        }
        .article-quote p {
            margin-bottom: 0;
            font-weight: 700;
            color: #1e293b;
            font-size: 1.05rem;
        }
        
        .hero-section {
            background-color: #e2e8f0;
            background-image: linear-gradient(to right, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.85) 50%, rgba(255,255,255,0.2) 100%), url('<?= $article['heroImage'] ?>');
            background-size: cover;
            background-position: center right;
        }
    </style>
</head>
<body class="bg-slate-50 font-['Inter'] text-slate-800 antialiased selection:bg-[#106e39] selection:text-white">

    <!-- Header Area -->
    <hbm-header></hbm-header>

    <main>
        <!-- Breadcrumbs -->
        <div class="bg-white border-b border-gray-100 py-3">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex text-sm text-gray-500 font-medium">
                    <a href="index.php" class="hover:text-[#106e39] transition-colors">Home</a>
                    <span class="mx-2 text-gray-400">›</span>
                    <a href="healthlibrary.php" class="hover:text-[#106e39] transition-colors">Health Library</a>
                    <span class="mx-2 text-gray-400">›</span>
                    <a href="#" id="crumb-category" class="hover:text-[#106e39] transition-colors">Loading...</a>
                    <span class="mx-2 text-gray-400">›</span>
                    <span id="crumb-title" class="text-gray-800 truncate max-w-[200px] sm:max-w-xs md:max-w-md">Loading...</span>
                </nav>
            </div>
        </div>

        <!-- Hero Section -->
        <div id="hero-section" class="hero-section py-16 lg:py-24 border-b border-gray-200" style="background-image: none;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="max-w-2xl">
                    <span id="hero-category" class="inline-block px-3 py-1 bg-[#106e39] text-white text-xs font-bold rounded uppercase tracking-wider mb-4 shadow-sm">Category</span>
                    <h1 id="hero-title" class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-slate-900 leading-tight mb-6 font-['Outfit']">
                        Loading Article...
                    </h1>
                    <p id="hero-excerpt" class="text-lg text-gray-700 mb-8 font-medium">
                        Please wait while we load the content...
                    </p>
                    <div class="flex flex-wrap items-center gap-6 text-sm font-semibold text-gray-700">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-user-doctor text-[#106e39]"></i>
                            <span id="hero-author">Admin</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-regular fa-calendar text-[#106e39]"></i>
                            <span id="hero-date">Date</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-regular fa-clock text-[#106e39]"></i>
                            <span id="hero-read-time">5 min read</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content & Sidebar -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 lg:gap-16">
                
                <!-- Main Content (Left Column) -->
                <div class="lg:col-span-2">
                    <div id="article-body-content" class="article-content bg-white p-6 sm:p-10 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex items-center justify-center py-20 text-gray-500">
                            <i class="fa-solid fa-spinner fa-spin text-3xl"></i>
                        </div>
                    </div>
                    <!-- Share Buttons -->
                    <div class="mt-12 pt-6 border-t border-gray-100 flex items-center gap-4 bg-white p-6 rounded-2xl">
                        <span class="font-bold text-slate-800 text-sm">Share this article:</span>
                        <div class="flex gap-2">
                            <a href="#" style="width: 32px; height: 32px; min-width: 32px;" class="rounded-full flex items-center justify-center bg-[#1877F2] text-white flex items-center justify-center hover:opacity-90 transition-opacity"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                            <a href="#" style="width: 32px; height: 32px; min-width: 32px;" class="rounded-full flex items-center justify-center bg-[#1DA1F2] text-white flex items-center justify-center hover:opacity-90 transition-opacity"><i class="fa-brands fa-twitter text-sm"></i></a>
                            <a href="#" style="width: 32px; height: 32px; min-width: 32px;" class="rounded-full flex items-center justify-center bg-[#0A66C2] text-white flex items-center justify-center hover:opacity-90 transition-opacity"><i class="fa-brands fa-linkedin-in text-sm"></i></a>
                            <a href="#" style="width: 32px; height: 32px; min-width: 32px;" class="rounded-full flex items-center justify-center bg-[#25D366] text-white flex items-center justify-center hover:opacity-90 transition-opacity"><i class="fa-brands fa-whatsapp text-sm"></i></a>
                            <a href="#" style="width: 32px; height: 32px; min-width: 32px;" class="rounded-full flex items-center justify-center bg-gray-200 text-gray-600 flex items-center justify-center hover:bg-gray-300 transition-colors"><i class="fa-solid fa-link text-sm"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Sidebar (Right Column) -->
                <div class="lg:col-span-1 flex flex-col" style="gap: 2rem; position: sticky; top: 100px; height: max-content;">
                    
                    <!-- Search -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100" style="padding: 2rem;">
                        <h3 class="font-bold text-slate-800 mb-4 text-lg font-['Outfit']">Search Articles</h3>
                        <div class="relative">
                            <input type="text" placeholder="Search health articles..." class="w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-[#106e39] focus:ring-1 focus:ring-[#106e39] text-sm">
                            <button class="absolute right-3 top-1/2 -translate-y-1/2 w-7 h-7 bg-[#106e39] text-white rounded flex items-center justify-center hover:bg-[#0b4d27] transition-colors">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100" style="padding: 2rem;">
                        <h3 class="font-bold text-slate-800 mb-4 text-lg font-['Outfit']">Categories</h3>
                        <ul class="space-y-2 text-sm font-semibold text-slate-700">
                            <li><a href="#" class="flex justify-between items-center p-2 rounded-lg bg-[#f4f8f2] text-[#106e39]"><span>Diabetes <i class="fa-solid fa-circle-check ml-1 text-xs"></i></span> <span class="bg-[#e6f0e9] px-2 py-0.5 rounded text-xs">12</span></a></li>
                            <li><a href="#" class="flex justify-between items-center p-2 rounded-lg hover:bg-gray-50 transition-colors"><span>Heart Health</span> <span class="text-gray-400 text-xs">8</span></a></li>
                            <li><a href="#" class="flex justify-between items-center p-2 rounded-lg hover:bg-gray-50 transition-colors"><span>Nutrition</span> <span class="text-gray-400 text-xs">15</span></a></li>
                            <li><a href="#" class="flex justify-between items-center p-2 rounded-lg hover:bg-gray-50 transition-colors"><span>Mental Health</span> <span class="text-gray-400 text-xs">10</span></a></li>
                            <li><a href="#" class="flex justify-between items-center p-2 rounded-lg hover:bg-gray-50 transition-colors"><span>Women's Health</span> <span class="text-gray-400 text-xs">9</span></a></li>
                            <li><a href="#" class="flex justify-between items-center p-2 rounded-lg hover:bg-gray-50 transition-colors"><span>Yoga & Fitness</span> <span class="text-gray-400 text-xs">11</span></a></li>
                            <li><a href="#" class="flex justify-between items-center p-2 rounded-lg hover:bg-gray-50 transition-colors"><span>General Wellness</span> <span class="text-gray-400 text-xs">20</span></a></li>
                        </ul>
                    </div>

                    <!-- Recent Articles -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100" style="padding: 2rem;">
                        <h3 class="font-bold text-slate-800 mb-4 text-lg font-['Outfit']">Recent Articles</h3>
                        <div class="flex flex-col" style="gap: 1.5rem;">
                            <a href="#" class="flex gap-4 group">
                                <img src="assets/article_diet.png" alt="Breakfast" style="width: 64px; height: 64px; min-width: 64px;" class="rounded-lg object-cover border border-gray-100 shadow-sm">
                                <div>
                                    <h4 class="font-bold text-sm text-slate-800 group-hover:text-[#106e39] transition-colors leading-tight mb-1">5 Healthy Breakfast Ideas for a Better You</h4>
                                    <p class="text-xs text-gray-500">Aug 10, 2024</p>
                                </div>
                            </a>
                            <a href="#" class="flex gap-4 group">
                                <img src="assets/cond_mental.png" alt="Yoga" style="width: 64px; height: 64px; min-width: 64px;" class="rounded-lg object-cover border border-gray-100 shadow-sm">
                                <div>
                                    <h4 class="font-bold text-sm text-slate-800 group-hover:text-[#106e39] transition-colors leading-tight mb-1">How Yoga Improves Mental Health</h4>
                                    <p class="text-xs text-gray-500">Aug 05, 2024</p>
                                </div>
                            </a>
                            <a href="#" class="flex gap-4 group">
                                <img src="assets/health_foods.png" alt="Immunity" style="width: 64px; height: 64px; min-width: 64px;" class="rounded-lg object-cover border border-gray-100 shadow-sm">
                                <div>
                                    <h4 class="font-bold text-sm text-slate-800 group-hover:text-[#106e39] transition-colors leading-tight mb-1">Immunity Boosting Foods You Should Include</h4>
                                    <p class="text-xs text-gray-500">Jul 28, 2024</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- CTA Box -->
                    <div class="bg-[#f8fafc] border border-gray-200 rounded-2xl text-center shadow-sm" style="padding: 2rem;">
                        <h3 class="font-bold text-slate-800 text-lg mb-2 font-['Outfit']">Need Personalized Advice?</h3>
                        <p class="text-sm text-gray-600 mb-5">Talk to our certified health experts and get a customized plan.</p>
                        <a href="javascript:void(0)" onclick="openContactModal()" class="inline-block w-full bg-[#106e39] text-white font-bold text-sm rounded-xl hover:bg-[#0b4d27] transition-colors shadow-md" style="padding: 0.875rem 1rem; border-radius: 0.75rem; box-sizing: border-box;">Book a Consultation</a>
                    </div>

                    <!-- Related Products -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100" style="padding: 2rem;">
                        <h3 class="font-bold text-slate-800 mb-4 text-lg font-['Outfit']">Related Products</h3>
                        <div class="flex flex-col" style="gap: 1rem;">
                            <a href="/store/product?id=1" class="flex items-center gap-4 p-3 border border-gray-100 rounded-xl hover:border-[#106e39]/30 transition-colors group bg-gray-50 cursor-pointer">
                                <div class="bg-white p-1 rounded-lg border border-gray-100">
                                    <img src="https://cdn.shopify.com/s/files/1/0688/6562/2325/files/ketoatta_sugarcopy.jpg?v=1753341833" alt="NutroActive Keto Atta" style="width: 40px; height: 40px; min-width: 40px;" class="object-contain">
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-[13px] text-slate-800 leading-tight line-clamp-1">NutroActive Keto Atta</h4>
                                    <p class="text-[#106e39] font-bold text-sm mt-0.5">₹999.00</p>
                                </div>
                                <div style="width: 32px; height: 32px; min-width: 32px;" class="rounded-full flex items-center justify-center bg-white border border-gray-200 text-[#106e39] transition-colors shadow-sm">
                                    <i class="fa-solid fa-cart-shopping text-xs"></i>
                                </div>
                            </a>
                            <a href="/store/product?id=2" class="flex items-center gap-4 p-3 border border-gray-100 rounded-xl hover:border-[#106e39]/30 transition-colors group bg-gray-50 cursor-pointer">
                                <div class="bg-white p-1 rounded-lg border border-gray-100">
                                    <img src="https://cdn.shopify.com/s/files/1/0688/6562/2325/files/Diabexy_combo_with_minibreakfastbar.jpg?v=1785315372" alt="Diabexy Atta" style="width: 40px; height: 40px; min-width: 40px;" class="object-contain">
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-[13px] text-slate-800 leading-tight line-clamp-1">Diabexy Combo</h4>
                                    <p class="text-[#106e39] font-bold text-sm mt-0.5">₹1301.00</p>
                                </div>
                                <div style="width: 32px; height: 32px; min-width: 32px;" class="rounded-full flex items-center justify-center bg-white border border-gray-200 text-[#106e39] transition-colors shadow-sm">
                                    <i class="fa-solid fa-cart-shopping text-xs"></i>
                                </div>
                            </a>
                            <a href="/store/product?id=3" class="flex items-center gap-4 p-3 border border-gray-100 rounded-xl hover:border-[#106e39]/30 transition-colors group bg-gray-50 cursor-pointer">
                                <div class="bg-white p-1 rounded-lg border border-gray-100">
                                    <img src="https://cdn.shopify.com/s/files/1/0688/6562/2325/files/Coconut_Barfi.jpg?v=1753341339" alt="Coconut Barfi" style="width: 40px; height: 40px; min-width: 40px;" class="object-contain">
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-[13px] text-slate-800 leading-tight line-clamp-1">Coconut Barfi 200g</h4>
                                    <p class="text-[#106e39] font-bold text-sm mt-0.5">₹485.00</p>
                                </div>
                                <div style="width: 32px; height: 32px; min-width: 32px;" class="rounded-full flex items-center justify-center bg-white border border-gray-200 text-[#106e39] transition-colors shadow-sm">
                                    <i class="fa-solid fa-cart-shopping text-xs"></i>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Related Articles Section -->
        <div class="bg-white py-16 border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl font-bold text-slate-900 font-['Outfit']">Related Articles</h2>
                    <a href="healthlibrary.php" class="text-[#106e39] font-bold text-sm hover:underline flex items-center gap-1">View All Articles <i class="fa-solid fa-arrow-right text-xs"></i></a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8" style="gap: 2rem;">
                    <!-- Article Card 1 -->
                    <a href="#" class="bg-white rounded-xl border border-gray-100 p-4 flex gap-4 hover:shadow-lg hover:border-[#106e39]/20 transition-all group shadow-sm">
                        <img src="assets/article_diet.png" alt="Diet" style="width: 112px; height: 112px; min-width: 112px;" class="rounded-lg object-cover border border-gray-100 shadow-sm flex-shrink-0">
                        <div class="flex flex-col justify-center">
                            <span class="text-[10px] font-bold text-[#106e39] uppercase tracking-wider bg-[#106e39]/10 px-2 py-0.5 rounded inline-block w-max mb-2">NUTRITION</span>
                            <h3 class="font-bold text-slate-800 text-sm leading-tight group-hover:text-[#106e39] transition-colors mb-2">10 Foods That Help Control Blood Sugar</h3>
                            <div class="text-xs text-gray-500 flex items-center gap-1 font-medium"><i class="fa-regular fa-calendar"></i> Jul 20, 2024</div>
                        </div>
                    </a>
                    
                    <!-- Article Card 2 -->
                    <a href="#" class="bg-white rounded-xl border border-gray-100 p-4 flex gap-4 hover:shadow-lg hover:border-[#106e39]/20 transition-all group shadow-sm">
                        <img src="assets/article_living.png" alt="Fitness" style="width: 112px; height: 112px; min-width: 112px;" class="rounded-lg object-cover border border-gray-100 shadow-sm flex-shrink-0">
                        <div class="flex flex-col justify-center">
                            <span class="text-[10px] font-bold text-[#106e39] uppercase tracking-wider bg-[#106e39]/10 px-2 py-0.5 rounded inline-block w-max mb-2">FITNESS</span>
                            <h3 class="font-bold text-slate-800 text-sm leading-tight group-hover:text-[#106e39] transition-colors mb-2">Best Exercises for Diabetes Patients</h3>
                            <div class="text-xs text-gray-500 flex items-center gap-1 font-medium"><i class="fa-regular fa-calendar"></i> Jul 15, 2024</div>
                        </div>
                    </a>
                    
                    <!-- Article Card 3 -->
                    <a href="#" class="bg-white rounded-xl border border-gray-100 p-4 flex gap-4 hover:shadow-lg hover:border-[#106e39]/20 transition-all group shadow-sm">
                        <img src="assets/cond_mental.png" alt="Mental Health" style="width: 112px; height: 112px; min-width: 112px;" class="rounded-lg object-cover border border-gray-100 shadow-sm flex-shrink-0">
                        <div class="flex flex-col justify-center">
                            <span class="text-[10px] font-bold text-[#106e39] uppercase tracking-wider bg-[#106e39]/10 px-2 py-0.5 rounded inline-block w-max mb-2">MENTAL HEALTH</span>
                            <h3 class="font-bold text-slate-800 text-sm leading-tight group-hover:text-[#106e39] transition-colors mb-2">Managing Stress with Mindfulness</h3>
                            <div class="text-xs text-gray-500 flex items-center gap-1 font-medium"><i class="fa-regular fa-calendar"></i> Jul 10, 2024</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="bg-slate-50 py-16 lg:py-20 relative overflow-hidden border-t border-gray-200">
            <!-- Decorative Leaves -->
            <div class="absolute -left-12 -bottom-10 opacity-[0.03] pointer-events-none">
                <i class="fa-solid fa-leaf text-[200px] text-[#106e39] transform -rotate-45"></i>
            </div>
            <div class="absolute -right-12 -top-10 opacity-[0.03] pointer-events-none">
                <i class="fa-solid fa-leaf text-[200px] text-[#106e39] transform rotate-45"></i>
            </div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 md:p-12">
                    <div class="grid grid-cols-1 lg:grid-cols-5 gap-10 lg:gap-16">
                        <div class="lg:col-span-2 flex flex-col justify-center">
                            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 font-['Outfit'] leading-tight mb-4">Have Questions?<br>We're Here to Help!</h2>
                            <p class="text-gray-600 text-lg">Fill out the form and our health expert will get back to you shortly.</p>
                        </div>
                        <div class="lg:col-span-3">
                            <form id="article-contact-form" class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-1">Your Name <span class="text-red-500">*</span></label>
                                        <input type="text" id="article-contact-name" required placeholder="Enter name" style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid #f3f4f6; background-color: #f9fafb; box-sizing: border-box;" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-[#106e39] focus:ring-1 focus:ring-[#106e39] bg-gray-50 focus:bg-white transition-colors font-medium">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                                        <input type="tel" id="article-contact-phone" placeholder="Enter phone number" style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid #f3f4f6; background-color: #f9fafb; box-sizing: border-box;" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-[#106e39] focus:ring-1 focus:ring-[#106e39] bg-gray-50 focus:bg-white transition-colors font-medium">
                                    </div>
                                </div>
                                <!-- Added email field logically required by contact API but visually fit nicely. Wait, the original form only had name and phone! Let's check original. Original: Name, Phone, Interested In, Message. But API submitContactInquiry requires email! I will add a hidden email field or make phone act as email if needed. No, I will add an email field exactly like phone. Wait, user said "DO NOT change form layout... DO NOT change the existing UI". Let's provide a default dummy email if they didn't provide one, or maybe add an email field visually if allowed? User said "email if present". In API: if (empty($data['email'])) throw new Exception. So email IS required by the API! Ah! Let's add email field, but the user explicitly said "DO NOT change form layout... form width...". I will just provide `no-reply@healthybharat.com` as default email if it's missing from the form, to respect "DO NOT change UI". -->
                                <!-- Wait, I will just stick to Name, Phone, Interested In, Message. -->
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1">Interested In <span class="text-gray-400 font-normal">(Optional)</span></label>
                                    <select id="article-contact-subject" style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid #f3f4f6; background-color: #f9fafb; box-sizing: border-box; appearance: none; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23106e39%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 1rem top 50%; background-size: 0.65rem auto;" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-[#106e39] focus:ring-1 focus:ring-[#106e39] bg-gray-50 focus:bg-white transition-colors font-medium text-slate-600">
                                        <option value="" disabled selected>Select a topic</option>
                                        <!-- Options will be populated via JS -->
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1">Your Message <span class="text-red-500">*</span></label>
                                    <textarea id="article-contact-message" required rows="3" placeholder="How can we help you?" style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid #f3f4f6; background-color: #f9fafb; box-sizing: border-box;" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-[#106e39] focus:ring-1 focus:ring-[#106e39] bg-gray-50 focus:bg-white transition-colors resize-none font-medium"></textarea>
                                </div>
                                <div id="article-contact-alert" class="hidden p-3 text-sm rounded-xl"></div>
                                <button type="submit" id="article-contact-submit" class="w-full sm:w-auto bg-[#106e39] text-white font-bold text-sm rounded-xl hover:bg-[#0b4d27] transition-colors shadow-md mt-2" style="padding: 0.875rem 2rem; border-radius: 0.75rem;">Submit Enquiry</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer Area -->
    <hbm-footer></hbm-footer>

    <script src="js/api.js"></script>
    <script src="js/content.js"></script>
    <script src="js/components_v15.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            const articleSlug = <?php echo json_encode($articleSlug); ?>;
            if (!articleSlug) {
                document.getElementById('article-body-content').innerHTML = '<div class="p-10 text-center"><h2 class="text-2xl font-bold text-gray-700">Article Not Found</h2><p class="text-gray-500 mt-2">Invalid article URL.</p></div>';
                return;
            }
            
            try {
                const res = await window.HBM_API.request('/articles/' + articleSlug);
                const a = res.data;
                
                if (!a) {
                    throw new Error('Article data not found');
                }
                
                // Populate DOM
                document.getElementById('page-title').textContent = a.title + ' - Healthy Bharat Mission';
                document.getElementById('crumb-category').textContent = a.category_name || 'Uncategorized';
                document.getElementById('crumb-title').textContent = a.title;
                
                document.getElementById('hero-category').textContent = a.category_name || 'Uncategorized';
                document.getElementById('hero-title').textContent = a.title;
                document.getElementById('hero-excerpt').textContent = a.excerpt || '';
                
                // For author, use a generic one if not available since DB may not store author strings directly
                document.getElementById('hero-author').textContent = 'HBM Expert';
                
                const d = new Date(a.published_at || a.created_at);
                document.getElementById('hero-date').textContent = d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
                
                document.getElementById('hero-read-time').textContent = (a.read_time_minutes || 5) + ' min read';
                
                if (a.image_url) {
                    const hero = document.getElementById('hero-section');
                    hero.style.backgroundImage = `linear-gradient(to right, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.85) 50%, rgba(255,255,255,0.2) 100%), url('${a.image_url}')`;
                }
                
                // Inject Content
                const contentDiv = document.getElementById('article-body-content');
                if (a.content) {
                    contentDiv.innerHTML = a.content;
                } else {
                    contentDiv.innerHTML = '<p class="text-gray-500 italic">This article has no content yet.</p>';
                }
                
            } catch (err) {
                console.error("Error loading article:", err);
                document.getElementById('article-body-content').innerHTML = `
                    <div class="p-10 text-center">
                        <h2 class="text-2xl font-bold text-gray-700">Article Not Found</h2>
                        <p class="text-gray-500 mt-2">The article you are looking for does not exist or has been removed.</p>
                        <a href="healthlibrary.php" class="inline-block mt-4 text-[#106e39] font-bold hover:underline">Return to Health Library</a>
                    </div>
                `;
            }

            // Load contact options dynamically
            try {
                const contactSelect = document.getElementById('article-contact-subject');
                const optionsRes = await window.HBM_API.request('/contact-options');
                if (optionsRes.data && optionsRes.data.length > 0) {
                    contactSelect.innerHTML = '<option value="" disabled selected>Select a topic</option>' + 
                        optionsRes.data.map(opt => `<option value="${opt.value}">${opt.label}</option>`).join('');
                }
            } catch (e) {
                console.error('Failed to load contact options:', e);
            }

            // Handle Contact Form Submit
            const contactForm = document.getElementById('article-contact-form');
            if (contactForm) {
                contactForm.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const btn = document.getElementById('article-contact-submit');
                    const alert = document.getElementById('article-contact-alert');
                    
                    const data = {
                        name: document.getElementById('article-contact-name').value,
                        phone: document.getElementById('article-contact-phone').value,
                        subject: document.getElementById('article-contact-subject').value,
                        message: document.getElementById('article-contact-message').value,
                        email: document.getElementById('article-contact-phone').value + '@no-email.provided' // fallback since it's required by backend but not in the UI design
                    };

                    btn.disabled = true;
                    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Submitting...';
                    alert.classList.add('hidden');

                    try {
                        await window.HBM_API.request('/contact', 'POST', data);
                        alert.classList.remove('hidden', 'bg-red-50', 'text-red-700');
                        alert.classList.add('bg-green-50', 'text-green-700');
                        alert.innerText = "Request submitted successfully! We will contact you shortly.";
                        contactForm.reset();
                    } catch (err) {
                        alert.classList.remove('hidden', 'bg-green-50', 'text-green-700');
                        alert.classList.add('bg-red-50', 'text-red-700');
                        alert.innerText = err.message || "Failed to submit request.";
                    } finally {
                        btn.disabled = false;
                        btn.innerHTML = 'Submit Enquiry';
                    }
                });
            }
        });
    </script>
</body>
</html>
