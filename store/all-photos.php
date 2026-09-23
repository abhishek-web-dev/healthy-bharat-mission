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
    <title>Customer Photos - Healthy Bharat Mission</title>
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

    <main class="container mx-auto max-w-[1200px] px-2 lg:px-8 py-16">
        <!-- Breadcrumbs -->
        <nav class="flex text-[13px] text-gray-500 mb-8 font-medium">
            <ol class="flex items-center space-x-2">
                <li><a href="/index" class="hover:text-[#106e39] transition-colors">Home</a></li>
                <li><i class="fa-solid fa-chevron-right text-[10px] mx-1"></i></li>
                <li><a href="/store" class="hover:text-[#106e39] transition-colors">Store</a></li>
                <li><i class="fa-solid fa-chevron-right text-[10px] mx-1"></i></li>
                <li><a href="/store/<?php echo htmlspecialchars($slug); ?>" class="hover:text-[#106e39] transition-colors" id="product-breadcrumb-name">Product</a></li>
                <li><i class="fa-solid fa-chevron-right text-[10px] mx-1"></i></li>
                <li><span class="text-gray-900 font-bold">Customer Photos</span></li>
            </ol>
        </nav>

        <h1 class="text-3xl font-bold text-[#052b14] mb-2" id="pageTitle">Customer Photos</h1>
        <p class="text-gray-500 mb-8" id="photoCountText">Loading photos...</p>

        <div id="noPhotosMsg" style="display: none;" class="text-center py-12 text-gray-500">
            No customer photos found for this product.
        </div>
        
        <div id="photosGridContainer" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            <!-- Photos injected here -->
        </div>
    </main>

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

    <hbm-footer base-path="/"></hbm-footer>
    <script src="/js/components_v15.js"></script>
    <script src="/js/api.js"></script>
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

        document.addEventListener('DOMContentLoaded', async () => {
            const slug = '<?php echo htmlspecialchars($slug); ?>';
            
            try {
                const pData = await window.HBM_API.request(`/store/products/${slug}`);
                if (pData.success) {
                    document.getElementById('product-breadcrumb-name').textContent = pData.data.name;
                    document.getElementById('pageTitle').textContent = `Customer Photos for ${pData.data.name}`;
                }
            } catch(e) {}

            try {
                const data = await window.HBM_API.request(`/store/products/${slug}/reviews`);
                if (data.success) {
                    const photos = data.data.photos || [];
                    const container = document.getElementById('photosGridContainer');
                    const msg = document.getElementById('noPhotosMsg');
                    const countText = document.getElementById('photoCountText');
                    
                    if (photos.length === 0) {
                        msg.style.display = 'block';
                        countText.textContent = "0 photos";
                    } else {
                        countText.textContent = `${photos.length} customer photo${photos.length === 1 ? '' : 's'}`;
                        const reviews = data.data.reviews || [];
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
                        
                        let html = '';
                        photos.forEach((p, idx) => {
                            html += `
                            <div onclick="openUnifiedLightbox(event, ${idx})" class="aspect-square rounded-xl overflow-hidden cursor-pointer group bg-gray-50 border border-gray-100 shadow-sm relative">
                                <img src="${p.image_path}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" loading="lazy">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors"></div>
                            </div>`;
                        });
                        container.innerHTML = html;
                    }
                }
            } catch (err) {
                console.error("Error loading photos:", err);
            }
        });
    </script>
</body>
</html>
