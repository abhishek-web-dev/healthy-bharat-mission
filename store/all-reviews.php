<?php
$slug = $_GET['slug'] ?? '';
if (empty($slug)) {
    header("Location: /store");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Reviews - Healthy Bharat Mission</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="/dist/output.css" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/images/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/assets/images/favicon/favicon.svg" />
    <link rel="shortcut icon" href="/assets/images/favicon/favicon.ico" />
</head>
<body class="font-body text-gray-800 bg-white antialiased">
    <hbm-header base-path="/"></hbm-header>

    <main class="container mx-auto max-w-[1000px] px-2 lg:px-8 py-16">
        <!-- Breadcrumbs -->
        <nav class="flex text-[13px] text-gray-500 mb-8 font-medium">
            <ol class="flex items-center space-x-2">
                <li><a href="/index" class="hover:text-[#106e39] transition-colors">Home</a></li>
                <li><i class="fa-solid fa-chevron-right text-[10px] mx-1"></i></li>
                <li><a href="/store" class="hover:text-[#106e39] transition-colors">Store</a></li>
                <li><i class="fa-solid fa-chevron-right text-[10px] mx-1"></i></li>
                <li><a href="/store/<?php echo htmlspecialchars($slug); ?>" class="hover:text-[#106e39] transition-colors" id="product-breadcrumb-name">Product</a></li>
                <li><i class="fa-solid fa-chevron-right text-[10px] mx-1"></i></li>
                <li><span class="text-gray-900 font-bold">All Reviews</span></li>
            </ol>
        </nav>

        <h1 class="text-3xl font-bold text-[#052b14] mb-8" id="pageTitle">All Reviews</h1>

        <div class="flex flex-col md:flex-row gap-10 xl:gap-14">
            <!-- Left Column: Summary -->
            <div class="w-full md:w-1/3">
                <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 sticky top-24">
                    <h2 class="text-[18px] font-bold text-[#212121] mb-4">Rating Summary</h2>
                    <div class="flex items-center gap-2 mb-2" id="reviewAggregateStats">
                        <div class="text-[32px] font-medium text-[#212121] leading-none"><span id="avgRatingText">--</span> <i class="fa-solid fa-star text-[20px] text-[#212121] -mt-1"></i></div>
                        <span class="bg-[#e2f6e9] text-[#106e39] text-[13px] font-medium px-2 py-0.5 rounded ml-2" id="ratingBadgeText">No Ratings Yet</span>
                    </div>
                    <div class="text-[#878787] text-[13px] mb-6">
                        based on <span id="totalRatingsText">0</span> ratings
                    </div>

                    <!-- Progress bars -->
                    <div class="flex flex-col gap-3" id="ratingBarsContainer">
                        <!-- Filled by JS -->
                    </div>
                </div>
            </div>

            <!-- Right Column: Reviews List -->
            <div class="w-full md:w-2/3">
                <div id="noReviewsMsg" style="display: none;" class="text-center py-12 text-gray-500">
                    No reviews found for this product.
                </div>
                <div id="reviewsListContainer" class="flex flex-col gap-6">
                    <!-- Reviews injected here -->
                </div>
            </div>
        </div>
    </main>

    <hbm-footer base-path="/"></hbm-footer>
    <script src="/js/components_v15.js"></script>
    <script src="/js/api.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const slug = '<?php echo htmlspecialchars($slug); ?>';
            
            // First fetch product name to update breadcrumb/title
            try {
                const pData = await window.HBM_API.request(`/store/products/${slug}`);
                if (pData.success) {
                    document.getElementById('product-breadcrumb-name').textContent = pData.data.name;
                    document.getElementById('pageTitle').textContent = `All Reviews for ${pData.data.name}`;
                }
            } catch(e) {}

            try {
                const data = await window.HBM_API.request(`/store/products/${slug}/reviews`);
                if (data.success) {
                    const stats = data.data.stats;
                    const reviews = data.data.reviews;
                    const photos = data.data.photos || [];

                    // Prepare global photo data
                    if (photos.length > 0) {
                        globalPhotoData = photos.map(p => {
                            const parentReview = reviews.find(r => r.id === p.review_id) || {};
                            return {
                                src: p.image_path,
                                rating: parentReview.rating || 5,
                                title: parentReview.title || '',
                                content: parentReview.content || '',
                                reviewer_name: parentReview.reviewer_name || '',
                                created_at: parentReview.created_at || ''
                            };
                        });
                    }
                    
                    if(stats.total_reviews > 0) {
                        const avg = parseFloat(stats.average_rating).toFixed(1);
                        document.getElementById('avgRatingText').textContent = avg;
                        document.getElementById('totalRatingsText').textContent = stats.total_reviews;
                        
                        const badge = document.getElementById('ratingBadgeText');
                        if(avg >= 4.5) badge.textContent = 'Excellent';
                        else if(avg >= 4) badge.textContent = 'Very Good';
                        else if(avg >= 3) badge.textContent = 'Good';
                        else badge.textContent = 'Average';
                        
                        // Rating Bars
                        let barsHtml = '';
                        const total = parseInt(stats.total_reviews);
                        for(let i=5; i>=1; i--) {
                            const count = parseInt(stats[`star_${i}`]) || 0;
                            const pct = total > 0 ? (count / total) * 100 : 0;
                            barsHtml += `
                            <div class="flex items-center gap-3 text-[13px] text-[#212121]">
                                <span class="w-6 shrink-0 font-medium">${i} <i class="fa-solid fa-star text-[10px]"></i></span>
                                <div class="flex-1 h-2.5 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-[#106e39] rounded-full" style="width: ${pct}%"></div>
                                </div>
                                <span class="w-8 shrink-0 text-right text-gray-500">${count}</span>
                            </div>`;
                        }
                        document.getElementById('ratingBarsContainer').innerHTML = barsHtml;
                    }

                    const container = document.getElementById('reviewsListContainer');
                    const noReviewsMsg = document.getElementById('noReviewsMsg');
                    
                    if (reviews.length === 0) {
                        noReviewsMsg.style.display = 'block';
                    } else {
                        noReviewsMsg.style.display = 'none';
                        let html = '';
                        
                        // Helper for time ago
                        const timeAgo = (dateStr) => {
                            const date = new Date(dateStr);
                            const seconds = Math.floor((new Date() - date) / 1000);
                            let interval = seconds / 31536000;
                            if (interval > 1) return Math.floor(interval) + " years ago";
                            interval = seconds / 2592000;
                            if (interval > 1) return Math.floor(interval) + " months ago";
                            interval = seconds / 86400;
                            if (interval > 1) return Math.floor(interval) + " days ago";
                            interval = seconds / 3600;
                            if (interval > 1) return Math.floor(interval) + " hours ago";
                            interval = seconds / 60;
                            if (interval > 1) return Math.floor(interval) + " mins ago";
                            return "Just now";
                        };

                        reviews.forEach(r => {
                            let photosHtml = '';
                            if(r.photos && r.photos.length > 0) {
                                photosHtml = '<div class="flex flex-wrap gap-3 mt-4">';
                                r.photos.forEach(img => {
                                    const gIdx = globalPhotoData.findIndex(gp => gp.src === img);
                                    photosHtml += `<img src="${img}" class="h-20 w-20 object-cover rounded shadow-sm border border-gray-100 cursor-pointer" onclick="openUnifiedLightbox(event, ${gIdx})">`;
                                });
                                photosHtml += '</div>';
                            }
                            
                            html += `
                            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <span class="bg-[#106e39] text-white font-bold px-2 py-1 rounded-[4px] text-[13px] inline-flex items-center gap-1 leading-none">${r.rating} <i class="fa-solid fa-star text-[10px]"></i></span>
                                        <h3 class="font-bold text-[#212121] text-[16px]">${r.title}</h3>
                                    </div>
                                    <span class="text-[#878787] text-[13px]">${timeAgo(r.created_at)}</span>
                                </div>
                                <p class="text-[#212121] text-[14px] leading-relaxed">${r.content}</p>
                                ${photosHtml}
                                <div class="flex items-center gap-3 mt-5 pt-4 border-t border-gray-50">
                                    <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold text-sm">
                                        ${r.reviewer_name.charAt(0).toUpperCase()}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[#212121] text-[13px] font-bold">${r.reviewer_name}</span>
                                        <span class="text-[#878787] text-[11px] flex items-center gap-1"><i class="fa-regular fa-circle-check text-[#106e39]"></i> Verified Buyer</span>
                                    </div>
                                </div>
                            </div>`;
                        });
                        container.innerHTML = html;
                    }
                }
            } catch (err) {
                console.error("Error loading reviews:", err);
            }
        });
    </script>
</body>
</html>
<!-- Unified Review Photo Lightbox -->
<div id="hbmReviewLightbox" class="fixed inset-0 flex flex-col items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300" style="background-color: #000; z-index: 9999;">
    
    <!-- Top Bar -->
    <div class="absolute top-0 left-0 w-full p-6 flex items-start justify-between" style="z-index: 10000;">
        <div class="w-10"></div> <!-- Spacer -->
        <div class="text-white text-sm font-semibold px-4 py-2 rounded-full" id="lightboxCounter" style="background-color: rgba(255,255,255,0.15);">1 / 10</div>
        <button onclick="closeUnifiedLightbox(event)" class="text-gray-300 hover:text-white p-2 cursor-pointer transition-colors">
            <i class="fa-solid fa-xmark fa-2x"></i>
        </button>
    </div>
    
    <!-- Left Navigation -->
    <button id="lightboxPrevBtn" onclick="prevUnifiedLightbox(event)" class="absolute top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white flex items-center justify-center cursor-pointer transition-colors p-4" style="left: 20px; z-index: 10000;">
        <i class="fa-solid fa-chevron-left fa-3x md:fa-4x"></i>
    </button>
    
    <!-- Right Navigation -->
    <button id="lightboxNextBtn" onclick="nextUnifiedLightbox(event)" class="absolute top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white flex items-center justify-center cursor-pointer transition-colors p-4" style="right: 20px; z-index: 10000;">
        <i class="fa-solid fa-chevron-right fa-3x md:fa-4x"></i>
    </button>

    <!-- Main Content Area -->
    <div class="w-full h-full flex items-center justify-center p-8">
        <!-- Image -->
        <img id="lightboxImage" src="" alt="Customer Photo" class="object-contain" style="max-width: 85vw; max-height: 85vh;">
    </div>

    <!-- Metadata Overlay (Bottom Left) -->
    <div class="absolute bottom-0 left-0 w-full p-8 pt-16 text-white flex flex-col items-start text-left pointer-events-none" style="z-index: 10000; background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0) 100%);">
        <div class="flex items-center justify-start mb-2" style="gap: 8px;">
            <span id="lightboxRating" class="text-white font-bold px-2 py-1 rounded text-xs flex items-center shadow-sm" style="background-color: #106e39; gap: 4px;">
                5 <i class="fa-solid fa-star" style="font-size: 10px;"></i>
            </span>
            <h3 id="lightboxTitle" class="font-bold text-lg md:text-xl leading-tight m-0" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.8);"></h3>
        </div>
        <p id="lightboxContent" class="text-gray-200 text-sm md:text-base leading-relaxed mb-4 max-w-3xl" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.8);"></p>
        
        <div class="flex flex-wrap items-center justify-start text-gray-300 text-xs" style="gap: 12px; text-shadow: 1px 1px 2px rgba(0,0,0,0.8);">
            <span id="lightboxAuthor" class="font-bold text-white"></span>
            <span class="flex items-center" style="gap: 4px;"><i class="fa-solid fa-circle-check text-blue-400"></i> <span>Certified Buyer</span></span>
            <span id="lightboxDateText"></span>
        </div>
    </div>
</div>
<script>
    let globalPhotoData = [];
    let currentLightboxIndex = 0;

    function openUnifiedLightbox(e, index) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        if (!globalPhotoData || globalPhotoData.length === 0) return;
        currentLightboxIndex = index;
        updateUnifiedLightboxView();
        const lb = document.getElementById('hbmReviewLightbox');
        lb.classList.remove('opacity-0', 'pointer-events-none');
        document.body.style.overflow = 'hidden';
    }

    function closeUnifiedLightbox(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        const lb = document.getElementById('hbmReviewLightbox');
        if (lb) {
            lb.classList.add('opacity-0', 'pointer-events-none');
        }
        document.body.style.overflow = '';
    }
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const lb = document.getElementById('hbmReviewLightbox');
            if (lb && !lb.classList.contains('opacity-0')) {
                closeUnifiedLightbox();
            }
        }
    });

    function updateUnifiedLightboxView() {
        const data = globalPhotoData[currentLightboxIndex];
        if (!data) return;

        document.getElementById('lightboxImage').src = data.src;
        document.getElementById('lightboxCounter').textContent = (currentLightboxIndex + 1) + ' / ' + globalPhotoData.length;
        
        const ratingEl = document.getElementById('lightboxRating');
        ratingEl.innerHTML = data.rating + ' <i class="fa-solid fa-star text-[10px]"></i>';
        document.getElementById('lightboxTitle').textContent = data.title || '';
        document.getElementById('lightboxContent').textContent = data.content || '';
        document.getElementById('lightboxAuthor').textContent = data.reviewer_name || '';
        
        const date = new Date(data.created_at);
        const dateStr = !isNaN(date.getTime()) ? date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }) : '';
        document.getElementById('lightboxDateText').textContent = dateStr;

        const prevBtn = document.getElementById('lightboxPrevBtn');
        const nextBtn = document.getElementById('lightboxNextBtn');
        
        if (currentLightboxIndex === 0) {
            prevBtn.style.visibility = 'hidden';
        } else {
            prevBtn.style.visibility = 'visible';
        }
        
        if (currentLightboxIndex === globalPhotoData.length - 1) {
            nextBtn.style.visibility = 'hidden';
        } else {
            nextBtn.style.visibility = 'visible';
        }
    }

    function prevUnifiedLightbox(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        if (currentLightboxIndex > 0) {
            currentLightboxIndex--;
            updateUnifiedLightboxView();
        }
    }

    function nextUnifiedLightbox(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        if (currentLightboxIndex < globalPhotoData.length - 1) {
            currentLightboxIndex++;
            updateUnifiedLightboxView();
        }
    }

    // Close on background click
    document.getElementById('hbmReviewLightbox').addEventListener('click', function(e) {
        if (e.target === this) closeUnifiedLightbox(e);
    });

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        const lb = document.getElementById('hbmReviewLightbox');
        if (lb && !lb.classList.contains('opacity-0')) {
            if (e.key === 'Escape') closeUnifiedLightbox(e);
            if (e.key === 'ArrowLeft') prevUnifiedLightbox(e);
            if (e.key === 'ArrowRight') nextUnifiedLightbox(e);
        }
    });
</script>
