// Store logic
document.addEventListener('DOMContentLoaded', async () => {
    // Determine which page we are on
    const path = window.location.pathname;

    if (path.includes('store') && !path.includes('store/')) {
        await initStore();
    } else if (path.includes('store/product')) {
        await initProductDetail();
    } else if (path.includes('store/cart')) {
        await initCart();
    } else if (path.includes('wishlist')) {
        await initWishlist();
    }
});

function createProductCard(product, isSlider = false) {
    const isDigital = product.is_digital ? '<span class="bg-[#e2f6e9] text-[#106e39] text-[9px] font-black uppercase tracking-wider px-2 py-1 rounded shadow-sm">Digital</span>' : '';
    const stockBadge = product.stock > 0
        ? '<div class="absolute top-3 right-3 bg-white text-emerald-600 border border-emerald-100 text-[9px] font-black uppercase tracking-wider px-2 py-1 rounded shadow-sm flex items-center gap-1.5 z-10"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div> IN STOCK</div>'
        : '<div class="absolute top-3 right-3 bg-white text-red-600 border border-red-100 text-[9px] font-black uppercase tracking-wider px-2 py-1 rounded shadow-sm flex items-center gap-1.5 z-10">OUT OF STOCK</div>';

    let cartUI = '';
    const cartItem = window.cartState && window.cartState.items ? window.cartState.items[product.id] : null;

    if (product.stock <= 0) {
        cartUI = `
            <button onclick="alert('You will be notified when this item is back in stock.')" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2.5 rounded-lg text-sm font-bold shadow-sm transition-all flex items-center justify-center gap-2 shrink-0 whitespace-nowrap z-10">
                <i class="fa-regular fa-bell"></i> Notify Me
            </button>
        `;
    } else if (cartItem && cartItem.quantity > 0) {
        cartUI = `
            <div class="flex items-center gap-3 shrink-0 z-10">
                <div class="flex items-center bg-[#f8fcf9] rounded-lg border border-gray-200 p-1 relative">
                    <button onclick="window.updateStoreCart(${product.id}, ${cartItem.quantity - 1})" class="w-7 h-7 flex items-center justify-center text-gray-500 hover:text-[#064e3b] font-bold rounded-md hover:bg-white transition-colors">-</button>
                    <span class="w-8 text-center text-[13px] font-bold text-[#1e293b]">${cartItem.quantity}</span>
                    <button onclick="window.updateStoreCart(${product.id}, ${cartItem.quantity + 1})" class="w-7 h-7 flex items-center justify-center text-[#064e3b] font-bold rounded-md hover:bg-white transition-colors">+</button>
                </div>
            </div>
        `;
    } else {
        cartUI = `
            <button onclick="window.addToCart(${product.id}, 1)" class="bg-[#14532d] hover:bg-[#0f3f22] text-white px-4 py-2.5 rounded-lg text-sm font-bold shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 transform active:scale-95 z-10 shrink-0 whitespace-nowrap">
                <i class="fa-solid fa-cart-plus"></i> Add to Cart
            </button>
        `;
    }

    const extraClasses = isSlider ? 'w-[260px] lg:w-[280px] shrink-0 slider-card snap-start self-stretch h-auto' : 'h-full';
    const extraAttrs = isSlider ? `data-category="${product.category_slug}" data-product-id="${product.id}"` : `data-product-id="${product.id}"`;

    return `
        <!-- Product Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg hover:border-[#064e3b]/20 transition-all duration-300 group flex flex-col relative ${extraClasses}" ${extraAttrs}>
            <div class="bg-[#f8fafc] p-4 relative flex items-center justify-center h-56 border-b border-gray-50 shrink-0">
                <div class="absolute top-3 left-3 flex gap-2 z-10">
                    <div class="bg-[#064e3b] text-white text-[9px] font-black tracking-wider uppercase px-2.5 py-1 rounded shadow-sm">
                        ${product.category_name}
                    </div>
                    ${isDigital}
                </div>
                ${stockBadge}
                
                <!-- Wishlist Button -->
                <button onclick="window.addToWishlist(${product.id}, this)" class="absolute bottom-3 right-3 bg-white text-gray-400 hover:text-red-500 hover:scale-110 border border-gray-100 text-[14px] w-8 h-8 rounded-full shadow-sm flex items-center justify-center transition-all z-20">
                    <i class="fa-regular fa-heart"></i>
                </button>
                
                <img src="${product.primary_image || 'https://via.placeholder.com/300'}" alt="${product.name}" class="h-full w-full object-contain mix-blend-multiply group-hover:scale-110 transition-transform duration-500 ease-out z-0 cursor-pointer" onclick="goToProduct(event, ${product.id})">
            </div>
            <div class="p-5 flex flex-col flex-1">
                <h3 class="font-extrabold text-gray-900 text-[15px] mb-2 leading-snug hover:text-[#064e3b] transition-colors line-clamp-2 cursor-pointer" onclick="goToProduct(event, ${product.id})">${product.name}</h3>
                <div class="flex items-end justify-between mt-auto pt-4 gap-2">
                    <div class="min-w-0">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Price</div>
                        ${product.mrp && parseFloat(product.mrp) > parseFloat(product.price) 
                            ? `<div class="flex items-center gap-1.5 flex-wrap"><span class="text-lg font-black text-[#064e3b] leading-none">₹${product.price}</span><span class="text-xs text-gray-400 line-through leading-none whitespace-nowrap">₹${product.mrp}</span></div>` 
                            : `<div class="text-lg font-black text-[#064e3b] leading-none">₹${product.price}</div>`}
                    </div>
                    ${cartUI}
                </div>
            </div>
        </div>
    `;
}

function goToProduct(event, productId) {
    if (event.target.closest('button')) return;
    const basePath = document.querySelector('hbm-header')?.getAttribute('base-path') || '';
    window.location.href = basePath + `store/product?id=${productId}`;
}

// --- Store Listing ---
async function initStore() {
    try {
        if (typeof window.fetchCartData === 'function') {
            await window.fetchCartData();
        }

        // Fetch products and categories
        const [productsRes, categoriesRes] = await Promise.all([
            HBM_API.request('/products'),
            HBM_API.request('/product-categories')
        ]);

        const products = productsRes.data;
        const categories = categoriesRes.data;

        // Render Sidebar Categories
        const catList = document.getElementById('store-categories-list');
        if (catList) {
            const iconMap = {
                'atta': 'fa-wheat-awn text-primary',
                'cookies': 'fa-cookie text-primary',
                'supplements': 'fa-pills text-emerald-500',
                'health': 'fa-leaf text-green-500'
            };

            let catHtml = '';
            categories.forEach(cat => {
                const icon = iconMap[cat.slug] || 'fa-box text-gray-500';
                catHtml += `
                    <li>
                        <a href="#section-${cat.slug}"
                            class="sidebar-category-link flex items-center justify-between text-sm py-2 px-3 rounded-lg hover:bg-white text-gray-700 hover:text-[#064e3b] font-semibold transition-colors">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid ${icon}"></i> ${cat.name}
                            </div>
                            <span
                                class="text-xs font-bold text-gray-400 bg-white px-2 py-0.5 rounded-full border border-gray-100">${cat.product_count || 0}</span>
                        </a>
                    </li>
                `;
            });
            catList.innerHTML = catHtml;
        }

        // Group dynamically by category slug
        const grouped = {};
        categories.forEach(cat => grouped[cat.slug] = []);
        grouped['default'] = [];

        products.forEach(p => {
            if (grouped[p.category_slug]) {
                grouped[p.category_slug].push(p);
            } else {
                grouped['default'].push(p);
            }
        });

        window.storeGroupedProducts = grouped;
        window.storeCategories = categories;
        
        // Dynamically build top nav, main sections and filters
        const topNav = document.getElementById('top-category-nav');
        const mainContent = document.getElementById('store-main-content');
        const filters = document.getElementById('popular-products-filters');
        
        const iconMap = {
            'atta': 'fa-wheat-awn text-[#064e3b]',
            'cookies': 'fa-cookie text-[#064e3b]',
            'supplements': 'fa-pills text-emerald-600',
            'health': 'fa-leaf text-green-600'
        };

        if (topNav) {
            topNav.innerHTML = categories.map(cat => {
                const icon = iconMap[cat.slug] || 'fa-box text-[#064e3b]';
                return `<a href="#section-${cat.slug}" class="category-pill flex items-center gap-2 px-5 py-2.5 bg-white text-gray-700 hover:text-[#064e3b] border border-gray-200 hover:border-[#064e3b]/30 rounded-full text-sm font-bold shadow-sm whitespace-nowrap transition-colors">
                    <i class="fa-solid ${icon}"></i> ${cat.name}
                </a>`;
            }).join('');
            // Make the first one active style (if needed, adjust classes)
            const firstPill = topNav.querySelector('a');
            if(firstPill) {
                firstPill.className = firstPill.className.replace('bg-white text-gray-700 hover:text-[#064e3b] border border-gray-200 hover:border-[#064e3b]/30', 'bg-[#064e3b] text-white');
            }
        }

        if (filters) {
            let filterHtml = `<button data-filter="all" class="filter-btn snap-start shrink-0 px-6 py-2 rounded-full bg-primary text-white text-sm font-bold shadow-sm">All</button>`;
            filterHtml += categories.map(cat => {
                return `<button data-filter="${cat.slug}" class="filter-btn snap-start shrink-0 px-6 py-2 rounded-full bg-white border border-gray-200 text-gray-600 hover:text-primary hover:border-primary text-sm font-semibold transition-colors shadow-sm flex items-center gap-2">
                    ${cat.name}
                </button>`;
            }).join('');
            filters.innerHTML = filterHtml;
        }

        if (mainContent) {
            mainContent.innerHTML = categories.map(cat => {
                const icon = iconMap[cat.slug] || 'fa-box text-[#064e3b]';
                return `<div id="section-${cat.slug}" class="product-category-section scroll-mt-[200px]">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-[#f0fdf4] text-[#064e3b] flex items-center justify-center shadow-sm border border-[#064e3b]/10">
                                <i class="fa-solid ${icon} text-lg"></i>
                            </div>
                            <h2 class="text-2xl font-extrabold text-[#064e3b] tracking-tight">${cat.name}</h2>
                        </div>
                        <span class="text-xs font-bold text-[#064e3b] bg-[#f0fdf4] px-3 py-1 rounded-full border border-[#064e3b]/10 product-count-badge">${cat.product_count || 0} Products</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 mb-16 product-grid">
                        <!-- Products injected here -->
                    </div>
                </div>`;
            }).join('');
        }

        window.renderStoreGrids();

        if (typeof window.renderPopularProducts === 'function') {
            window.renderPopularProducts();
        }

    } catch (e) {
        console.error("Failed to load store products", e);
    }
}

window.renderStoreGrids = function () {
    if (!window.storeGroupedProducts || !window.storeCategories) return;
    
    window.storeCategories.forEach(cat => {
        const slug = cat.slug;
        const sectionDiv = document.getElementById(`section-${slug}`);
        if (sectionDiv) {
            const grid = sectionDiv.querySelector('.product-grid');
            const countBadge = sectionDiv.querySelector('.product-count-badge');
            
            const catProducts = window.storeGroupedProducts[slug] || [];
            
            if (grid) {
                grid.innerHTML = catProducts.map(p => createProductCard(p)).join('');
            }
            if (countBadge) {
                countBadge.innerText = `${catProducts.length} Products`;
            }
        }
    });

    if (typeof window.renderPopularProducts === 'function') {
        window.renderPopularProducts();
    }
};

window.renderPopularProducts = function () {
    if (!window.storeGroupedProducts) return;
    const track = document.getElementById('popular-products-track');
    const slider = document.getElementById('popular-products-slider');
    if (!track || !slider) return;

    // Remember scroll position
    const currentScroll = slider.scrollLeft;

    let allProducts = [];
    Object.keys(window.storeGroupedProducts).forEach(key => {
        if (key !== 'default') {
            allProducts = allProducts.concat(window.storeGroupedProducts[key]);
        }
    });

    // Take the first 12 products as "popular"
    let popular = allProducts.slice(0, 12);

    // Preserve current slider order if it exists (so it doesn't jump back when cart updates)
    const currentOrderIds = Array.from(track.children).map(card => card.getAttribute('data-product-id'));
    if (currentOrderIds.length > 0) {
        popular = currentOrderIds.map(id => popular.find(p => p.id == id)).filter(Boolean);
    }

    track.innerHTML = popular.map(p => createProductCard(p, true)).join('');

    // Force exactly integer number of cards to prevent half-cards showing
    const updateSliderWidth = () => {
        const parent = track.parentElement;
        parent.style.maxWidth = '100%'; // reset
        const availableWidth = parent.offsetWidth;
        const cardWidth = window.innerWidth >= 1024 ? 280 + 24 : 260 + 16; // width + gap
        const visibleCards = Math.max(1, Math.floor((availableWidth + 24) / cardWidth));
        const exactWidth = (visibleCards * cardWidth) - (window.innerWidth >= 1024 ? 24 : 16);
        parent.style.maxWidth = exactWidth + 'px';
        parent.style.margin = '0 auto';
    };
    updateSliderWidth();
    window.addEventListener('resize', updateSliderWidth);

    // Initialize auto-slider only once
    if (!window.popularSliderInitialized) {
        window.popularSliderInitialized = true;

        let autoSlideInterval;
        let isTransitioning = false;

        const slideOne = () => {
            if (isTransitioning) return;
            const firstCard = track.firstElementChild;
            const secondCard = firstCard ? firstCard.nextElementSibling : null;
            if (!firstCard || !secondCard) return;

            isTransitioning = true;

            // Calculate exact distance to slide (including gap)
            const slideDistance = secondCard.getBoundingClientRect().left - firstCard.getBoundingClientRect().left;

            track.style.transition = 'transform 0.5s ease-in-out';
            track.style.transform = `translateX(-${slideDistance}px)`;

            setTimeout(() => {
                track.style.transition = 'none';
                track.style.transform = 'translateX(0)';
                track.appendChild(firstCard);
                isTransitioning = false;
            }, 500);
        };

        autoSlideInterval = setInterval(slideOne, 3000);

        // Pause on hover
        slider.addEventListener('mouseenter', () => clearInterval(autoSlideInterval));
        slider.addEventListener('mouseleave', () => {
            autoSlideInterval = setInterval(slideOne, 3000);
        });
    }
};

// --- Product Details ---
async function initProductDetail() {
    const params = new URLSearchParams(window.location.search);
    const productId = params.get('id');

    if (!productId) {
        window.location.href = '../store';
        return;
    }

    try {
        const res = await HBM_API.request(`/products/${productId}`);
        const product = res.data;

        // Update document title
        document.title = `${product.name} - Healthy Bharat Mission`;

        // Update breadcrumb
        const bc = document.getElementById('product-breadcrumb-name');
        if (bc) bc.innerText = product.name;

        const bcCategory = document.getElementById('product-breadcrumb-category');
        if (bcCategory) {
            bcCategory.innerText = product.category_name || 'Store';
            bcCategory.href = `../store#section-${product.category_slug}`;
        }

        // Update Product Info
        const titleEl = document.getElementById('product-title');
        if (titleEl) titleEl.innerText = product.name;

        const priceEl = document.getElementById('product-price');
        const mrpEl = document.getElementById('product-mrp');
        const discountBadge = document.getElementById('product-discount-badge');
        
        if (priceEl) priceEl.innerText = `₹${product.price}`;
        if (mrpEl && discountBadge) {
            if (product.mrp && parseFloat(product.mrp) > parseFloat(product.price)) {
                const mrp = parseFloat(product.mrp);
                const price = parseFloat(product.price);
                const saveAmount = mrp - price;
                const savePercent = Math.round((saveAmount / mrp) * 100);
                
                mrpEl.innerText = `₹${mrp.toFixed(2)}`;
                mrpEl.classList.remove('hidden');
                
                discountBadge.innerText = `You save ₹${saveAmount.toFixed(2)} (${savePercent}%)`;
                discountBadge.classList.remove('hidden');
            } else {
                mrpEl.classList.add('hidden');
                discountBadge.classList.add('hidden');
            }
        }

        const descEl = document.getElementById('dynamic-description');
        if (descEl) descEl.innerText = product.description || 'No description available.';
        
        const ingredientsEl = document.getElementById('dynamic-ingredients');
        if (ingredientsEl) ingredientsEl.innerText = product.ingredients || 'No ingredients information available.';
        
        const nutritionEl = document.getElementById('dynamic-nutrition');
        if (nutritionEl) nutritionEl.innerText = product.nutritional_info || 'No nutritional information available.';
        
        const usageEl = document.getElementById('dynamic-usage');
        if (usageEl) usageEl.innerText = product.how_to_use || 'No instructions available.';

        // Update Category tag
        const tagEl = document.getElementById('product-category-tag');
        if (tagEl) tagEl.innerText = product.category_name || 'Health Foods';

        // Images
        const imgGallery = document.getElementById('product-main-image');
        if (imgGallery && product.thumbnail_url) {
            imgGallery.src = product.thumbnail_url;
        }

        const thumbsContainer = document.getElementById('product-thumbnails-container');
        if (thumbsContainer && product.images && product.images.length > 0) {
            thumbsContainer.innerHTML = '';
            product.images.forEach((imgObj, idx) => {
                const imgUrl = typeof imgObj === 'string' ? imgObj : (imgObj.image_url || imgObj);
                const borderClass = idx === 0 ? 'border-black' : 'border-transparent hover:border-gray-300';
                thumbsContainer.innerHTML += `
                    <button onclick="changeMainImage(this, '${imgUrl}')" class="thumbnail-btn w-24 h-24 shrink-0 rounded-lg overflow-hidden border-2 ${borderClass} snap-start hover:opacity-80 transition-opacity bg-white">
                        <img src="${imgUrl}" alt="Thumb ${idx + 1}" class="w-full h-full object-contain">
                    </button>
                `;
            });
        }

        // Fetch all products for "You May Also Like"
        try {
            const allRes = await HBM_API.request('/products');
            window.allStoreProducts = allRes.data.filter(p => p.id !== product.id); // exclude current
        } catch (e) {
            window.allStoreProducts = [];
        }

        window.currentProduct = product;

        window.renderYouMayAlsoLike = function () {
            if (!window.allStoreProducts) return;
            const track = document.getElementById('youMayAlsoLikeScroll');
            if (!track) return;

            // Remember scroll position
            const currentScroll = track.scrollLeft;

            // Get products in same category first, then others
            let related = window.allStoreProducts.filter(p => p.category_slug === product.category_slug);
            let others = window.allStoreProducts.filter(p => p.category_slug !== product.category_slug);
            let combined = related.concat(others).slice(0, 8); // take 8

            // Preserve current slider order if it exists (so it doesn't jump back when cart updates)
            const currentOrderIds = Array.from(track.children).map(card => card.getAttribute('data-product-id'));
            if (currentOrderIds.length > 0) {
                combined = currentOrderIds.map(id => combined.find(p => p.id == id)).filter(Boolean);
            }

            track.innerHTML = combined.map(p => createProductCard(p, true)).join('');

            // Force exactly integer number of cards to prevent half-cards showing
            const updateSliderWidth = () => {
                const parent = track.parentElement;
                parent.style.maxWidth = '100%'; // reset
                const availableWidth = parent.offsetWidth;
                const cardWidth = window.innerWidth >= 1024 ? 280 + 24 : 260 + 16; // width + gap
                const visibleCards = Math.max(1, Math.floor((availableWidth + 24) / cardWidth));
                const exactWidth = (visibleCards * cardWidth) - (window.innerWidth >= 1024 ? 24 : 16);
                parent.style.maxWidth = exactWidth + 'px';
                parent.style.margin = '0 auto';
            };
            updateSliderWidth();
            window.addEventListener('resize', updateSliderWidth);

            // Restore scroll position
            track.scrollLeft = currentScroll;

            // Initialize auto-slider only once
            if (!window.youMayAlsoLikeInitialized) {
                window.youMayAlsoLikeInitialized = true;

                let autoSlideInterval;
                let isTransitioning = false;

                const slideOne = () => {
                    if (isTransitioning) return;
                    const firstCard = track.firstElementChild;
                    const secondCard = firstCard ? firstCard.nextElementSibling : null;
                    if (!firstCard || !secondCard) return;

                    isTransitioning = true;

                    const slideDistance = secondCard.getBoundingClientRect().left - firstCard.getBoundingClientRect().left;

                    track.style.transition = 'transform 0.5s ease-in-out';
                    track.style.transform = `translateX(-${slideDistance}px)`;

                    setTimeout(() => {
                        track.style.transition = 'none';
                        track.style.transform = 'translateX(0)';
                        track.appendChild(firstCard);
                        isTransitioning = false;
                    }, 500);
                };

                autoSlideInterval = setInterval(slideOne, 3000);

                const sliderContainer = track.parentElement;
                sliderContainer.addEventListener('mouseenter', () => clearInterval(autoSlideInterval));
                sliderContainer.addEventListener('mouseleave', () => {
                    autoSlideInterval = setInterval(slideOne, 3000);
                });
            }
        };

        window.renderProductDetailCartUI = function () {
            const product = window.currentProduct;
            if (!product) return;
            const cartItem = window.cartState && window.cartState.items ? window.cartState.items[product.id] : null;

            const container = document.getElementById('product-cart-ui');
            if (!container) return;

            if (product.stock <= 0) {
                container.innerHTML = `
                    <button class="w-full bg-gray-100 text-gray-500 h-[52px] rounded-xl font-bold flex items-center justify-center gap-2 cursor-not-allowed border border-gray-200">
                        <i class="fa-solid fa-bell"></i> Notify Me
                    </button>
                `;
            } else if (cartItem && cartItem.quantity > 0) {
                container.innerHTML = `
                    <div class="w-full flex items-center justify-between bg-[#f8fcf9] rounded-xl border border-[#106e39] h-[52px] px-2 shadow-sm">
                        <button onclick="window.updateStoreCart(${product.id}, ${cartItem.quantity - 1})" class="w-12 h-full flex items-center justify-center text-gray-500 hover:text-[#106e39] font-bold text-xl transition-colors">-</button>
                        <span class="flex-1 text-center font-bold text-[#1e293b] text-lg">${cartItem.quantity}</span>
                        <button onclick="window.updateStoreCart(${product.id}, ${cartItem.quantity + 1})" class="w-12 h-full flex items-center justify-center text-[#106e39] font-bold text-xl transition-colors">+</button>
                    </div>
                `;
            } else {
                container.innerHTML = `
                    <button onclick="window.addToCart(${product.id}, 1)" class="w-full bg-[#106e39] hover:bg-[#0d592e] text-white h-[52px] rounded-xl font-bold flex items-center justify-center gap-2 shadow-[0_4px_12px_rgba(16,110,57,0.2)] transition-all">
                        <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                    </button>
                `;
            }

            if (typeof window.renderYouMayAlsoLike === 'function') {
                window.renderYouMayAlsoLike();
            }
        };

        // Initial render
        await window.fetchCartData();
        window.renderProductDetailCartUI();

        const buyNowBtn = document.getElementById('btn-buy-now');
        if (buyNowBtn) {
            buyNowBtn.onclick = async function () {
                // Change button state to show loading
                const originalHtml = buyNowBtn.innerHTML;
                buyNowBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Adding...';
                buyNowBtn.disabled = true;
                
                await window.addToCart(product.id, 1);
                
                const basePath = document.querySelector('hbm-header')?.getAttribute('base-path') || '';
                window.location.href = basePath + 'store/cart';
            };
        }

    } catch (e) {
        console.error("Failed to load product details", e);
    }
}

// --- Cart ---
async function initCart() {
    // If not logged in, just clear it or show login prompt
    if (!localStorage.getItem('hbm_token')) {
        const container = document.getElementById('cart-items-container');
        if (container) {
            container.innerHTML = `
                <div class="text-center py-10">
                    <p class="text-gray-500 mb-4">Please log in to view your cart.</p>
                    <a href="../auth/login" class="bg-[#106e39] text-white px-6 py-2 rounded-lg font-bold">Login</a>
                </div>
            `;
        }
        updateCartTotals(0);
        return;
    }

    if (typeof window.fetchCartData === 'function') {
        await window.fetchCartData();
    }

    await renderCart();
    if (typeof window.loadAvailableCoupons === 'function') {
        await window.loadAvailableCoupons();
    }

    // Fetch recommended products dynamically
    try {
        const res = await HBM_API.request('/products');
        if (res.success && res.data) {
            // Get up to 8 products for the recommendations slider
            const products = res.data.slice(0, 8);
            const recContainer = document.getElementById('cart-recommended-products');
            if (recContainer) {
                // createProductCard(p, true) returns a slider-compatible card
                recContainer.innerHTML = products.map(p => createProductCard(p, true)).join('');

                // Initialize infinite slider
                if (window.cartSliderInterval) clearInterval(window.cartSliderInterval);
                window.cartSliderInterval = setInterval(() => {
                    if (recContainer.children.length < 2) return;
                    const firstCard = recContainer.firstElementChild;
                    // card width + gap (16px)
                    const cardWidth = firstCard.offsetWidth + 16;

                    // Enable transition and slide left
                    recContainer.style.transition = 'transform 0.5s ease-in-out';
                    recContainer.style.transform = `translateX(-${cardWidth}px)`;

                    setTimeout(() => {
                        // Instantly reset transform and move first child to end
                        recContainer.style.transition = 'none';
                        recContainer.appendChild(firstCard);
                        recContainer.style.transform = 'translateX(0)';
                    }, 500); // Wait for transition to finish
                }, 3000);
            }
        }
    } catch (e) {
        console.error("Failed to load recommended products for cart", e);
    }
}

async function renderCart() {
    try {
        const res = await HBM_API.request('/cart');
        const cart = res.data;

        const container = document.getElementById('cart-items-container');
        if (!container) return;

        if (cart.items.length === 0) {
            container.innerHTML = `
                <div class="text-center py-10">
                    <p class="text-gray-500 mb-4">Your cart is empty.</p>
                    <a href="../store" class="bg-[#106e39] text-white px-6 py-2 rounded-lg font-bold">Continue Shopping</a>
                </div>
            `;
            updateCartTotals(0);
            return;
        }

        let html = '';
        cart.items.forEach(item => {
            html += `
                <div class="relative flex flex-col sm:flex-row gap-5 p-5 mb-4 border border-gray-100 rounded-3xl bg-white hover:shadow-sm transition-shadow">
                    
                    <div class="w-32 h-32 shrink-0 bg-[#f4f6f8] rounded-2xl flex items-center justify-center relative overflow-hidden cursor-pointer" onclick="window.location.href='product?id=${item.product_id || item.id}'">
                        ${item.primary_image || item.thumbnail_url
                    ? `<img src="${item.primary_image || item.thumbnail_url}" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-105 transition-transform duration-300" alt="${item.name}" onerror="this.parentElement.innerHTML='&lt;i class=&quot;fa-regular fa-image text-4xl text-gray-300&quot;&gt;&lt;/i&gt;'">`
                    : `<i class="fa-regular fa-image text-4xl text-gray-300"></i>`
                }
                    </div>
                    
                    <div class="flex flex-col flex-1 cursor-pointer" onclick="window.location.href='product?id=${item.product_id || item.id}'">
                        <div>
                            <h3 class="text-[#1e293b] font-bold text-lg leading-snug mb-1.5 hover:text-[#106e39] transition-colors">${item.name}</h3>
                            <div class="text-gray-400 text-sm mb-3">${item.category_name || 'Product'}</div>
                            
                            ${(item.category_name || '').toLowerCase().includes('health') || (item.name || '').toLowerCase().includes('keto')
                    ? `<div class="inline-flex items-center gap-1.5 bg-[#e2f6e9] text-[#106e39] px-3 py-1.5 rounded-xl text-xs font-bold w-max"><i class="fa-solid fa-leaf"></i> Healthy Choice</div>`
                    : (item.brand ? `<div class="inline-flex items-center gap-1.5 bg-[#f1f5f9] text-[#64748b] px-3 py-1.5 rounded-xl text-xs font-bold w-max"><i class="fa-solid fa-tag"></i> ${item.brand}</div>` : '')
                }
                        </div>
                        
                        <div class="flex items-center justify-between mt-5">
                            <div class="flex items-baseline gap-2">
                                <div class="text-[#106e39] font-black text-2xl whitespace-nowrap">₹${(parseFloat(item.price) * item.quantity).toFixed(2)}</div>
                                ${item.quantity > 1 ? `<div class="text-gray-400 text-sm font-medium">@ ₹${parseFloat(item.price).toFixed(2)} each</div>` : ''}
                            </div>
                            
                            <div class="flex items-center bg-white rounded-xl border border-gray-200 h-11 px-1 shadow-sm" onclick="event.stopPropagation()">
                                <button onclick="updateCartQuantity(${item.cart_item_id}, ${item.quantity - 1})" class="w-9 h-full flex items-center justify-center text-[#64748b] hover:text-[#106e39] font-bold text-xl hover:bg-gray-50 transition-colors rounded-l-lg">-</button>
                                <span class="w-10 text-center text-base font-bold text-[#1e293b]">${item.quantity}</span>
                                <button onclick="updateCartQuantity(${item.cart_item_id}, ${item.quantity + 1})" class="w-9 h-full flex items-center justify-center text-[#106e39] font-bold text-xl hover:bg-gray-50 transition-colors rounded-r-lg">+</button>
                            </div>
                        </div>
                    </div>
                    
                    <button onclick="removeCartItem(${item.cart_item_id})" class="absolute top-5 right-5 w-10 h-10 flex items-center justify-center rounded-xl bg-[#fef2f2] text-red-500 hover:bg-red-100 transition-colors" title="Remove Item">
                        <i class="fa-regular fa-trash-can text-lg"></i>
                    </button>
                </div>
            `;
        });

        container.innerHTML = html;
        updateCartTotals(cart.subtotal);

        // Update Title Count
        const countHeader = document.getElementById('cart-count-header');
        if (countHeader) countHeader.innerText = `${cart.total_items} Items in Your Cart`;

        window.cartState.count = cart.total_items;
        window.updateCartBadge();

    } catch (e) {
        console.error("Failed to load cart", e);
    }
}

async function updateCartQuantity(cartItemId, qty) {
    if (qty <= 0) {
        await removeCartItem(cartItemId);
        return;
    }
    try {
        await HBM_API.request(`/cart/${cartItemId}`, 'PUT', { quantity: qty });
        await renderCart();
    } catch (e) {
        alert(e.message || "Failed to update quantity");
    }
}

async function removeCartItem(cartItemId) {
    if (!confirm("Remove item from cart?")) return;
    try {
        await HBM_API.request(`/cart/${cartItemId}`, 'DELETE');
        await renderCart();
    } catch (e) {
        alert(e.message || "Failed to remove item");
    }
}

window.currentDiscount = 0;
window.currentCartSubtotal = 0;

window.applyCoupon = async function () {
    const code = document.getElementById('coupon-input').value.trim().toUpperCase();
    const msgEl = document.getElementById('coupon-message');

    if (code === '') {
        window.currentDiscount = 0;
        sessionStorage.removeItem('hbm_discount');
        sessionStorage.removeItem('hbm_coupon_code');
        msgEl.innerText = 'Coupon removed.';
        msgEl.className = 'text-[12px] font-bold mt-2 text-gray-500 block';
        msgEl.style.display = 'block';
        updateCartTotals(window.currentCartSubtotal);
        return;
    }

    try {
        msgEl.innerText = 'Applying...';
        msgEl.className = 'text-[12px] font-bold mt-2 text-gray-500 block';
        msgEl.style.display = 'block';

        const res = await HBM_API.request(`/store/coupons/validate?code=${encodeURIComponent(code)}&subtotal=${window.currentCartSubtotal}`);
        
        if (res.success || res.status === 'success') {
            window.currentDiscount = res.data.coupon.discount_amount;
            sessionStorage.setItem('hbm_discount', window.currentDiscount);
            sessionStorage.setItem('hbm_coupon_code', code);
            
            msgEl.innerText = `Coupon applied successfully! - ₹${window.currentDiscount} OFF`;
            msgEl.className = 'text-[12px] font-bold mt-2 text-[#106e39] block';
        } else {
            window.currentDiscount = 0;
            sessionStorage.removeItem('hbm_discount');
            sessionStorage.removeItem('hbm_coupon_code');
            msgEl.innerText = res.message || 'Invalid coupon code.';
            msgEl.className = 'text-[12px] font-bold mt-2 text-red-500 block';
        }
    } catch (err) {
        console.error(err);
        window.currentDiscount = 0;
        sessionStorage.removeItem('hbm_discount');
        sessionStorage.removeItem('hbm_coupon_code');
        msgEl.innerText = 'Error validating coupon. Please try again.';
        msgEl.className = 'text-[12px] font-bold mt-2 text-red-500 block';
    }

    updateCartTotals(window.currentCartSubtotal);
};

window.loadAvailableCoupons = async function() {
    const container = document.getElementById('available-coupons-container');
    if (!container) return; // Only run on cart page

    try {
        const res = await HBM_API.request('/store/coupons');
        if (res.success && res.data.coupons && res.data.coupons.length > 0) {
            container.innerHTML = res.data.coupons.map(coupon => {
                let description = coupon.description || coupon.name;
                return `
                    <div class="flex items-start gap-2 mb-2.5">
                        <i class="fa-solid fa-tag text-[#106e39] mt-0.5 text-[10px]"></i>
                        <div class="text-[12px] text-[#1e293b]">
                            ${description} Use code: 
                            <span class="font-bold border border-dashed border-gray-300 px-1.5 py-0.5 rounded bg-gray-50 cursor-pointer hover:bg-gray-100 transition-colors ml-1" 
                                  onclick="document.getElementById('coupon-input').value='${coupon.code}';">
                                ${coupon.code}
                            </span>
                        </div>
                    </div>
                `;
            }).join('');
        } else {
            container.innerHTML = '<div class="text-[12px] text-gray-500">No active offers right now.</div>';
        }
    } catch (err) {
        console.error(err);
        container.innerHTML = '<div class="text-[12px] text-gray-500">Could not load offers.</div>';
    }
};

function updateCartTotals(subtotal) {
    window.currentCartSubtotal = subtotal;
    const discount = window.currentDiscount || parseFloat(sessionStorage.getItem('hbm_discount')) || 0;

    const subtotalEl = document.getElementById('cart-subtotal');
    if (subtotalEl) subtotalEl.innerText = `₹${subtotal.toFixed(2)}`;

    const discountEl = document.getElementById('cart-discount');
    if (discountEl) discountEl.innerText = `- ₹${discount.toFixed(2)}`;

    // Calculate Shipping
    let shipping = 0;
    const shippingEl = document.getElementById('cart-shipping');
    if (subtotal > 0 && (subtotal - discount) < 499) {
        shipping = 59;
        if (shippingEl) {
            shippingEl.innerText = `₹59.00`;
            shippingEl.classList.remove('text-[#106e39]');
            shippingEl.classList.add('text-[#1e293b]');
        }
    } else {
        shipping = 0;
        if (shippingEl) {
            shippingEl.innerText = `Free`;
            shippingEl.classList.add('text-[#106e39]');
            shippingEl.classList.remove('text-[#1e293b]');
        }
    }

    // Calculate Tax (5% GST on discounted subtotal)
    const taxableAmount = Math.max(0, subtotal - discount);
    const tax = taxableAmount * 0.05;
    const taxEl = document.getElementById('cart-tax');
    if (taxEl) taxEl.innerText = `₹${tax.toFixed(2)}`;

    // Final Total
    const total = Math.max(0, taxableAmount + shipping + tax);
    const totalEl = document.getElementById('cart-total');
    if (totalEl) totalEl.innerText = `₹${total.toFixed(2)}`;

    // Savings Banner
    const savingsBanner = document.getElementById('cart-savings-banner');
    const savingsAmount = document.getElementById('cart-savings-amount');

    if (discount > 0) {
        if (savingsBanner) {
            savingsBanner.classList.remove('hidden');
            savingsBanner.classList.add('flex');
        }
        if (savingsAmount) savingsAmount.innerText = discount.toFixed(2);
    } else {
        if (savingsBanner) {
            savingsBanner.classList.add('hidden');
            savingsBanner.classList.remove('flex');
        }
    }
}

// --- Wishlist ---
async function initWishlist() {
    if (!localStorage.getItem('hbm_token')) {
        window.location.href = '../auth/login?redirect=../dashboard/wishlist';
        return;
    }

    try {
        const res = await HBM_API.request('/wishlist');
        const wishlist = res.data;

        const container = document.getElementById('wishlist-items-container');
        if (!container) return;

        if (wishlist.items.length === 0) {
            container.innerHTML = `
                <div class="col-span-full text-center py-10 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <p class="text-gray-500 mb-4">Your wishlist is empty.</p>
                    <a href="../store" class="bg-[#106e39] text-white px-6 py-2 rounded-lg font-bold">Browse Store</a>
                </div>
            `;
            return;
        }

        let html = '';
        wishlist.items.forEach(product => {
            html += createProductCard(product);
            // the heart button will toggle it (remove it in this case).
            // A page reload or simple re-render might be needed to clear it visually, but toggleWishlist will handle backend.
            // Ideally we modify createProductCard to show solid red heart for wishlist items.
        });

        container.innerHTML = html;

        // Highlight hearts
        container.querySelectorAll('.fa-heart').forEach(i => {
            i.classList.remove('fa-regular');
            i.classList.add('fa-solid', 'text-red-500');
        });

        // Add reload to heart clicks in wishlist so item disappears from list
        container.querySelectorAll('button[onclick*="addToWishlist"]').forEach(btn => {
            const originalClick = btn.onclick;
            btn.onclick = async function (e) {
                await originalClick.call(this, e);
                initWishlist(); // reload the list
            };
        });

    } catch (e) {
        console.error("Failed to load wishlist", e);
    }
}
