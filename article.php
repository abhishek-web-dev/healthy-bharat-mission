<?php
// Mock Data for the Article (In a real app, this would come from a database based on $_GET['id'])
$articleId = isset($_GET['id']) ? $_GET['id'] : 'type-2-diabetes';

// Base mock content for Type 2 Diabetes
$article = [
    'title' => 'Understanding Type 2 Diabetes: Causes, Symptoms and How to Manage It',
    'category' => 'Diabetes Care',
    'categorySlug' => 'diabetes',
    'author' => 'Dr. Priya Sharma',
    'date' => 'Aug 12, 2024',
    'readTime' => '8 min read',
    'heroImage' => 'assets/cond_diabetes.png',
    'contentImage' => 'assets/article_diabetes.png'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article['title']) ?> - Healthy Bharat Mission</title>
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
                    <a href="#" class="hover:text-[#106e39] transition-colors"><?= htmlspecialchars($article['category']) ?></a>
                    <span class="mx-2 text-gray-400">›</span>
                    <span class="text-gray-800 truncate max-w-[200px] sm:max-w-xs md:max-w-md"><?= htmlspecialchars($article['title']) ?></span>
                </nav>
            </div>
        </div>

        <!-- Hero Section -->
        <div class="hero-section py-16 lg:py-24 border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="max-w-2xl">
                    <span class="inline-block px-3 py-1 bg-[#106e39] text-white text-xs font-bold rounded uppercase tracking-wider mb-4 shadow-sm"><?= htmlspecialchars($article['category']) ?></span>
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-slate-900 leading-tight mb-6 font-['Outfit']">
                        <?= htmlspecialchars($article['title']) ?>
                    </h1>
                    <p class="text-lg text-gray-700 mb-8 font-medium">
                        Learn about the early signs, risk factors and simple lifestyle changes that can help you keep diabetes under control.
                    </p>
                    <div class="flex flex-wrap items-center gap-6 text-sm font-semibold text-gray-700">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-user-doctor text-[#106e39]"></i>
                            <span>By <?= htmlspecialchars($article['author']) ?></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-regular fa-calendar text-[#106e39]"></i>
                            <span><?= htmlspecialchars($article['date']) ?></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-regular fa-clock text-[#106e39]"></i>
                            <span><?= htmlspecialchars($article['readTime']) ?></span>
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
                    <div class="article-content bg-white p-6 sm:p-10 rounded-2xl shadow-sm border border-gray-100">
                        <h2>Introduction</h2>
                        <p>Type 2 diabetes is a common chronic condition that affects the way your body processes blood sugar (glucose). It develops when your body becomes resistant to insulin or doesn't produce enough insulin. With the right knowledge and lifestyle changes, it can be effectively managed.</p>
                        
                        <img src="<?= htmlspecialchars($article['contentImage']) ?>" alt="Healthy Diet" class="w-full rounded-xl my-8 shadow-sm border border-gray-100">
                        
                        <h2>What is Type 2 Diabetes?</h2>
                        <p>Type 2 diabetes is a long-term condition that affects how your body uses glucose for energy. Unlike type 1 diabetes, the body still produces insulin, but the cells become resistant to it over time.</p>

                        <h2>Common Symptoms</h2>
                        <p>The symptoms of type 2 diabetes can be mild at first. Some common signs include:</p>
                        <ul>
                            <li>Increased thirst</li>
                            <li>Frequent urination</li>
                            <li>Unexplained weight loss</li>
                            <li>Fatigue</li>
                            <li>Blurred vision</li>
                            <li>Slow healing of wounds</li>
                        </ul>

                        <h2>Causes and Risk Factors</h2>
                        <p>Several factors can increase the risk of developing type 2 diabetes, including:</p>
                        <ul>
                            <li>Being overweight or obese</li>
                            <li>Physical inactivity</li>
                            <li>Unhealthy diet (high in sugar and processed foods)</li>
                            <li>Family history of diabetes</li>
                            <li>Increasing age (especially over 45)</li>
                        </ul>

                        <h2>How to Manage Type 2 Diabetes</h2>
                        <p>While there is no permanent cure, type 2 diabetes can be managed with:</p>
                        <ul>
                            <li>A balanced and nutritious diet</li>
                            <li>Regular physical activity</li>
                            <li>Maintaining a healthy weight</li>
                            <li>Taking prescribed medications</li>
                            <li>Regular monitoring of blood sugar levels</li>
                            <li>Stress management and adequate sleep</li>
                        </ul>

                        <div class="article-quote">
                            <i class="fa-solid fa-leaf"></i>
                            <p>"Small, consistent changes in your lifestyle can make a big difference in managing diabetes and living a healthier, happier life."</p>
                        </div>

                        <h2>Conclusion</h2>
                        <p>Type 2 diabetes is manageable with the right approach. Early detection, a healthy lifestyle, and regular check-ups can help prevent complications and improve your quality of life.</p>
                        
                        <!-- Share Buttons -->
                        <div class="mt-12 pt-6 border-t border-gray-100 flex items-center gap-4">
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
                            <form class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-1">Your Name <span class="text-red-500">*</span></label>
                                        <input type="text" placeholder="Enter name" style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid #f3f4f6; background-color: #f9fafb; box-sizing: border-box;" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-[#106e39] focus:ring-1 focus:ring-[#106e39] bg-gray-50 focus:bg-white transition-colors font-medium">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                                        <input type="tel" placeholder="Enter phone number" style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid #f3f4f6; background-color: #f9fafb; box-sizing: border-box;" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-[#106e39] focus:ring-1 focus:ring-[#106e39] bg-gray-50 focus:bg-white transition-colors font-medium">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1">Interested In <span class="text-gray-400 font-normal">(Optional)</span></label>
                                    <select style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid #f3f4f6; background-color: #f9fafb; box-sizing: border-box; appearance: none; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23106e39%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 1rem top 50%; background-size: 0.65rem auto;" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-[#106e39] focus:ring-1 focus:ring-[#106e39] bg-gray-50 focus:bg-white transition-colors font-medium text-slate-600">
                                        <option value="" disabled selected>Select a topic</option>
                                        <option value="consultation">Health Consultation</option>
                                        <option value="diet">Customized Diet Plan</option>
                                        <option value="products">Supplements & Products</option>
                                        <option value="other">General Inquiry</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1">Your Message <span class="text-red-500">*</span></label>
                                    <textarea rows="3" placeholder="How can we help you?" style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid #f3f4f6; background-color: #f9fafb; box-sizing: border-box;" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-[#106e39] focus:ring-1 focus:ring-[#106e39] bg-gray-50 focus:bg-white transition-colors resize-none font-medium"></textarea>
                                </div>
                                <button type="submit" class="w-full sm:w-auto bg-[#106e39] text-white font-bold text-sm rounded-xl hover:bg-[#0b4d27] transition-colors shadow-md mt-2" style="padding: 0.875rem 2rem; border-radius: 0.75rem;">Submit Enquiry</button>
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
</body>
</html>
