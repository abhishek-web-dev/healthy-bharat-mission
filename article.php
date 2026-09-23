<?php
$articleSlug = '';

// Check if old URL format is used and redirect
if (strpos($_SERVER['REQUEST_URI'], 'article.php?slug=') !== false) {
    $slug = $_GET['slug'] ?? '';
    if ($slug) {
        header("Location: /" . $slug, true, 301);
        exit;
    }
}

// Legacy slug mapping for 301 redirects
$legacyMap = [
    'benefits-of-traditional-herbs' => 'the-benefits-of-traditional-herbs',
    'cardio-for-beginners' => 'cardio-exercises-for-beginners',
    'test-article-1789415296' => 'test-article',
    'beginners-guide-balanced-diet' => 'a-beginner-s-guide-to-a-balanced-diet',
    '10-daily-habits-manage-diabetes' => 'daily-habits-to-manage-diabetes-naturally',
    'power-of-daily-movement' => 'the-power-of-daily-movement',
    '5-natural-ways-boost-immunity' => 'natural-ways-to-boost-your-immunity',
    'how-better-sleep-improves-health' => 'how-better-sleep-improves-your-health',
    'foods-for-happier-gut' => 'foods-for-a-happier-gut',
    'keep-heart-healthy' => 'keep-your-heart-healthy-with-simple-lifestyle-changes',
    'pcos-diet-exercise-tips' => 'pcos-diet-exercise-lifestyle-tips',
    'type-2-diabetes' => 'understanding-type-2-diabetes-causes-symptoms-and-how-to-manage-it'
];

if (isset($_GET['slug']) && !empty($_GET['slug'])) {
    $articleSlug = $_GET['slug'];
} else {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $articleSlug = trim($uri, '/');
}

// 301 Redirect if accessing a legacy slug directly
if (isset($legacyMap[$articleSlug])) {
    header("Location: /" . $legacyMap[$articleSlug], true, 301);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="page-title">Loading... - Healthy Bharat Mission</title>
    <link rel="canonical" id="canonical-url" href="https://www.healthybharatmission.com/<?php echo htmlspecialchars($articleSlug); ?>">
    <meta property="og:url" id="og-url" content="https://www.healthybharatmission.com/<?php echo htmlspecialchars($articleSlug); ?>">
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
                            <a href="#" id="share-facebook" target="_blank" style="width: 32px; height: 32px; min-width: 32px;" class="rounded-full flex items-center justify-center bg-[#1877F2] text-white flex items-center justify-center hover:opacity-90 transition-opacity"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                            <a href="#" id="share-twitter" target="_blank" style="width: 32px; height: 32px; min-width: 32px;" class="rounded-full flex items-center justify-center bg-[#1DA1F2] text-white flex items-center justify-center hover:opacity-90 transition-opacity"><i class="fa-brands fa-twitter text-sm"></i></a>
                            <a href="#" id="share-linkedin" target="_blank" style="width: 32px; height: 32px; min-width: 32px;" class="rounded-full flex items-center justify-center bg-[#0A66C2] text-white flex items-center justify-center hover:opacity-90 transition-opacity"><i class="fa-brands fa-linkedin-in text-sm"></i></a>
                            <a href="#" id="share-whatsapp" target="_blank" style="width: 32px; height: 32px; min-width: 32px;" class="rounded-full flex items-center justify-center bg-[#25D366] text-white flex items-center justify-center hover:opacity-90 transition-opacity"><i class="fa-brands fa-whatsapp text-sm"></i></a>
                            <button id="share-copy-link" title="Copy Link" style="width: 32px; height: 32px; min-width: 32px;" class="relative rounded-full flex items-center justify-center bg-gray-200 text-gray-600 flex items-center justify-center hover:bg-gray-300 transition-colors">
                                <i class="fa-solid fa-link text-sm"></i>
                                <span id="copy-tooltip" class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded hidden whitespace-nowrap">Copied!</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar (Right Column) -->
                <div class="lg:col-span-1 flex flex-col" style="gap: 2rem; position: sticky; top: 100px; height: max-content;">
                    
                    <!-- Search -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100" style="padding: 2rem;">
                        <h3 class="font-bold text-slate-800 mb-4 text-lg font-['Outfit']">Search Articles</h3>
                        <div class="relative">
                            <form id="article-search-form" action="healthlibrary.php" method="GET">
                                <input type="text" name="search" placeholder="Search health articles..." required class="w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-[#106e39] focus:ring-1 focus:ring-[#106e39] text-sm">
                                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 w-7 h-7 bg-[#106e39] text-white rounded flex items-center justify-center hover:bg-[#0b4d27] transition-colors">
                                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100" style="padding: 2rem;">
                        <h3 class="font-bold text-slate-800 mb-4 text-lg font-['Outfit']">Categories</h3>
                        <ul id="article-categories-list" class="space-y-2 text-sm font-semibold text-slate-700">
                            <li class="text-gray-500 text-sm"><i class="fa-solid fa-spinner fa-spin mr-2"></i>Loading categories...</li>
                        </ul>
                    </div>

                    <!-- Recent Articles -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100" style="padding: 2rem;">
                        <h3 class="font-bold text-slate-800 mb-4 text-lg font-['Outfit']">Recent Articles</h3>
                        <div class="flex flex-col" style="gap: 1.5rem;" id="recent-articles-list">
                            <div class="text-sm text-gray-500"><i class="fa-solid fa-spinner fa-spin mr-2"></i>Loading...</div>
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
                        <div id="related-products-list" class="flex flex-col" style="gap: 1rem;">
                            <div class="text-sm text-gray-500"><i class="fa-solid fa-spinner fa-spin mr-2"></i>Loading products...</div>
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
                
                <div id="related-articles-grid" class="grid grid-cols-1 md:grid-cols-3 gap-8" style="gap: 2rem;">
                    <div class="col-span-full text-center text-sm text-gray-500 py-10"><i class="fa-solid fa-spinner fa-spin mr-2"></i>Loading related articles...</div>
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
                                        <input type="tel" id="article-contact-phone" required pattern="[6-9][0-9]{9}" maxlength="10" title="Please enter a valid 10-digit Indian mobile number starting with 6, 7, 8, or 9." placeholder="Enter phone number" style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid #f3f4f6; background-color: #f9fafb; box-sizing: border-box;" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-[#106e39] focus:ring-1 focus:ring-[#106e39] bg-gray-50 focus:bg-white transition-colors font-medium" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                                    </div>
                                </div>
                                <!-- Added email field logically required by contact API but visually fit nicely. Wait, the original form only had name and phone! Let's check original. Original: Name, Phone, Interested In, Message. But API submitContactInquiry requires email! I will add a hidden email field or make phone act as email if needed. No, I will add an email field exactly like phone. Wait, user said "DO NOT change form layout... DO NOT change the existing UI". Let's provide a default dummy email if they didn't provide one, or maybe add an email field visually if allowed? User said "email if present". In API: if (empty($data['email'])) throw new Exception. So email IS required by the API! Ah! Let's add email field, but the user explicitly said "DO NOT change form layout... form width...". I will just provide `no-reply@healthybharat.com` as default email if it's missing from the form, to respect "DO NOT change UI". -->
                                <!-- Wait, I will just stick to Name, Phone, Interested In, Message. -->
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1">Interested In <span class="text-gray-400 font-normal">(Optional)</span></label>
                                    <select id="article-contact-subject" style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid #f3f4f6; background-color: #f9fafb; box-sizing: border-box;" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-[#106e39] focus:ring-1 focus:ring-[#106e39] bg-gray-50 focus:bg-white transition-colors font-medium text-slate-600">
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
                window.location.replace('/404');
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
                
                // --- Start dynamic fetching of recent and related ---
                
                
                // Load Categories
                try {
                    const catRes = await window.HBM_API.request('/article-categories');
                    const catList = document.getElementById('article-categories-list');
                    if (catList && catRes.data) {
                        catList.innerHTML = catRes.data.map(c => {
                            const isActive = a.category_slug && c.slug === a.category_slug;
                            const activeClass = isActive ? 'bg-[#f4f8f2] text-[#106e39]' : 'hover:bg-gray-50 transition-colors text-slate-700';
                            const activeIcon = isActive ? '<i class="fa-solid fa-circle-check ml-1 text-xs"></i>' : '';
                            const countClass = isActive ? 'bg-[#e6f0e9]' : 'text-gray-400';
                            return `
                                <li>
                                    <a href="healthlibrary.php?category=${c.slug}" class="flex justify-between items-center p-2 rounded-lg ${activeClass}">
                                        <span>${c.name} ${activeIcon}</span> 
                                        <span class="${countClass} px-2 py-0.5 rounded text-xs">${c.article_count || 0}</span>
                                    </a>
                                </li>
                            `;
                        }).join('');
                    }
                } catch(e) {
                    console.error("Failed to load categories", e);
                }

                // Load Related Products
                try {
                    const prodRes = await window.HBM_API.request('/products?perPage=3');
                    let products = prodRes.data || [];
                    if(products.data) products = products.data; // Handle pagination wrapper
                    
                    const prodList = document.getElementById('related-products-list');
                    if (prodList) {
                        if (products.length === 0) {
                            prodList.innerHTML = '<p class="text-sm text-gray-500">No products found.</p>';
                        } else {
                            prodList.innerHTML = products.map(p => `
                                <a href="store/product.php?id=${p.id}" class="flex items-center gap-4 p-3 border border-gray-100 rounded-xl hover:border-[#106e39]/30 transition-colors group bg-gray-50 cursor-pointer">
                                    <div class="bg-white p-1 rounded-lg border border-gray-100 flex items-center justify-center" style="width: 48px; height: 48px;">
                                        <img src="${p.image_url || 'https://via.placeholder.com/40'}" alt="${p.name}" style="max-width: 40px; max-height: 40px;" class="object-contain">
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-[13px] text-slate-800 leading-tight line-clamp-1">${p.name}</h4>
                                        <p class="text-[#106e39] font-bold text-sm mt-0.5">₹${parseFloat(p.price).toFixed(2)}</p>
                                    </div>
                                    <div style="width: 32px; height: 32px; min-width: 32px;" class="rounded-full flex items-center justify-center bg-white border border-gray-200 text-[#106e39] transition-colors shadow-sm">
                                        <i class="fa-solid fa-cart-shopping text-xs"></i>
                                    </div>
                                </a>
                            `).join('');
                        }
                    }
                } catch(e) {
                    console.error("Failed to load products", e);
                }

                // Set up Share Links
                const currentUrl = window.location.href;
                const encodedUrl = encodeURIComponent(currentUrl);
                const encodedTitle = encodeURIComponent(a.title);
                
                document.getElementById('share-facebook').href = `https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}`;
                document.getElementById('share-twitter').href = `https://twitter.com/intent/tweet?url=${encodedUrl}&text=${encodedTitle}`;
                document.getElementById('share-linkedin').href = `https://www.linkedin.com/sharing/share-offsite/?url=${encodedUrl}`;
                document.getElementById('share-whatsapp').href = `https://api.whatsapp.com/send?text=${encodedTitle} - ${encodedUrl}`;
                
                const copyBtn = document.getElementById('share-copy-link');
                const copyTooltip = document.getElementById('copy-tooltip');
                if (copyBtn) {
                    copyBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        navigator.clipboard.writeText(currentUrl).then(() => {
                            copyTooltip.classList.remove('hidden');
                            setTimeout(() => {
                                copyTooltip.classList.add('hidden');
                            }, 2000);
                        }).catch(err => {
                            console.error('Failed to copy', err);
                        });
                    });
                }

                // Load Recent Articles
                try {
                    const recentRes = await window.HBM_API.request('/articles?perPage=3');
                    let recentArticles = recentRes.data || [];
                    if(recentArticles.data) recentArticles = recentArticles.data;
                    
                    // Filter out the current article
                    recentArticles = recentArticles.filter(ra => ra.slug !== articleSlug).slice(0, 3);
                    
                    const recentList = document.getElementById('recent-articles-list');
                    if (recentList) {
                        if (recentArticles.length === 0) {
                            recentList.innerHTML = '<p class="text-sm text-gray-500">No recent articles found.</p>';
                        } else {
                            recentList.innerHTML = recentArticles.map(ra => `
                                <a href="/${ra.slug}" class="flex gap-4 group">
                                    <img src="${ra.image_url || 'assets/article_diet.png'}" alt="${ra.title}" style="width: 64px; height: 64px; min-width: 64px;" class="rounded-lg object-cover border border-gray-100 shadow-sm">
                                    <div>
                                        <h4 class="font-bold text-sm text-slate-800 group-hover:text-[#106e39] transition-colors leading-tight mb-1 line-clamp-2">${ra.title}</h4>
                                        <p class="text-xs text-gray-500">${new Date(ra.published_at || ra.created_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })}</p>
                                    </div>
                                </a>
                            `).join('');
                        }
                    }
                } catch(e) {
                    console.error("Failed to load recent articles", e);
                }

                // Load Related Articles
                try {
                    // Try fetching by category first
                    let apiUrl = '/articles?perPage=4';
                    if (a.category_slug) {
                        apiUrl += '&category=' + encodeURIComponent(a.category_slug);
                    }
                    
                    const relatedRes = await window.HBM_API.request(apiUrl);
                    let relatedArticles = relatedRes.data || [];
                    if(relatedArticles.data) relatedArticles = relatedArticles.data;
                    
                    // Filter out the current article
                    relatedArticles = relatedArticles.filter(ra => ra.slug !== articleSlug).slice(0, 3);
                    
                    const relatedGrid = document.getElementById('related-articles-grid');
                    if (relatedGrid) {
                        if (relatedArticles.length === 0) {
                            relatedGrid.innerHTML = '<p class="col-span-full text-center text-gray-500 py-10">No related articles found.</p>';
                        } else {
                            relatedGrid.innerHTML = relatedArticles.map(ra => `
                                <a href="/${ra.slug}" class="bg-white rounded-xl border border-gray-100 p-4 flex gap-4 hover:shadow-lg hover:border-[#106e39]/20 transition-all group shadow-sm">
                                    <img src="${ra.image_url || 'assets/article_living.png'}" alt="${ra.title}" style="width: 112px; height: 112px; min-width: 112px;" class="rounded-lg object-cover border border-gray-100 shadow-sm flex-shrink-0">
                                    <div class="flex flex-col justify-center">
                                        ${ra.category_name ? `<span class="text-[10px] font-bold text-[#106e39] uppercase tracking-wider bg-[#106e39]/10 px-2 py-0.5 rounded inline-block w-max mb-2">${ra.category_name}</span>` : ''}
                                        <h3 class="font-bold text-slate-800 text-sm leading-tight group-hover:text-[#106e39] transition-colors mb-2 line-clamp-2">${ra.title}</h3>
                                        <div class="text-xs text-gray-500 flex items-center gap-1 font-medium"><i class="fa-regular fa-calendar"></i> ${new Date(ra.published_at || ra.created_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })}</div>
                                    </div>
                                </a>
                            `).join('');
                        }
                    }
                } catch(e) {
                    console.error("Failed to load related articles", e);
                }
                
                // --- End dynamic fetching ---

                
            } catch (err) {
                console.error("Error loading article:", err);
                window.location.replace('/404');
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
