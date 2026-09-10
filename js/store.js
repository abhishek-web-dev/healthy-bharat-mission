// Store logic
document.addEventListener('DOMContentLoaded', async () => {
    // Determine which page we are on
    const path = window.location.pathname;
    
    if (path.includes('store.html') && !path.includes('store/')) {
        await initStore();
    } else if (path.includes('store/product.html')) {
        await initProductDetail();
    } else if (path.includes('store/cart.html')) {
        await initCart();
    } else if (path.includes('wishlist.html')) {
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
            <button onclick="alert('You will be notified when this item is back in stock.')" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2.5 rounded-lg text-sm font-bold shadow-sm transition-all flex items-center gap-2">
                <i class="fa-regular fa-bell"></i> Notify Me
            </button>
        `;
    } else if (cartItem && cartItem.quantity > 0) {
        cartUI = `
            <div class="flex items-center gap-3">
                <div class="flex items-center bg-[#f8fcf9] rounded-lg border border-gray-200 p-1 z-10 relative">
                    <button onclick="window.updateStoreCart(${product.id}, ${cartItem.quantity - 1})" class="w-7 h-7 flex items-center justify-center text-gray-500 hover:text-[#106e39] font-bold rounded-md hover:bg-white transition-colors">-</button>
                    <span class="w-8 text-center text-[13px] font-bold text-[#1e293b]">${cartItem.quantity}</span>
                    <button onclick="window.updateStoreCart(${product.id}, ${cartItem.quantity + 1})" class="w-7 h-7 flex items-center justify-center text-[#106e39] font-bold rounded-md hover:bg-white transition-colors">+</button>
                </div>
            </div>
        `;
    } else {
        cartUI = `
            <button onclick="window.addToCart(${product.id}, 1)" class="bg-primary-light hover:bg-primary text-white px-4 py-2.5 rounded-lg text-sm font-bold shadow-md hover:shadow-lg transition-all flex items-center gap-2 transform active:scale-95 z-10">
                <i class="fa-solid fa-cart-plus"></i> Add to Cart
            </button>
        `;
    }

    const extraClasses = isSlider ? 'w-[260px] lg:w-[280px] shrink-0 slider-card snap-start' : '';
    const extraAttrs = isSlider ? `data-category="${product.category_slug}" data-product-id="${product.id}"` : `data-product-id="${product.id}"`;

    return `
        <!-- Product Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg hover:border-[#064e3b]/20 transition-all duration-300 group flex flex-col relative ${extraClasses}" ${extraAttrs}>
            <div class="bg-[#f8fafc] p-4 relative flex items-center justify-center h-56 border-b border-gray-50">
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
                <div class="flex items-end justify-between mt-auto pt-4">
                    <div>
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Price</div>
                        <div class="text-lg font-black text-[#064e3b]">₹${product.price}</div>
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
    window.location.href = basePath + `store/product.html?id=${productId}`;
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

        // Group by category slug
        const grouped = {
            'atta': [],
            'cookies': [],
            'supplements': [],
            'health': [],
            'default': []
        };
        
        products.forEach(p => {
            if (grouped[p.category_slug]) {
                grouped[p.category_slug].push(p);
            } else {
                grouped['default'].push(p);
            }
        });

        window.storeGroupedProducts = grouped;
        window.renderStoreGrids();
        
        if (typeof window.renderPopularProducts === 'function') {
            window.renderPopularProducts();
        }
        
    } catch (e) {
        console.error("Failed to load store products", e);
    }
}

window.renderStoreGrids = function() {
    if (!window.storeGroupedProducts) return;
    const sections = ['atta', 'cookies', 'supplements', 'health'];
    sections.forEach(slug => {
        const sectionDiv = document.getElementById(`section-${slug}`);
        if (sectionDiv) {
            const grid = sectionDiv.querySelector('.product-grid');
            const countBadge = sectionDiv.querySelector('.rounded-full.border');
            
            if (grid) {
                grid.innerHTML = window.storeGroupedProducts[slug].map(p => createProductCard(p)).join('');
            }
            if (countBadge) {
                countBadge.innerText = `${window.storeGroupedProducts[slug].length} Products`;
            }
        }
    });

    if (typeof window.renderPopularProducts === 'function') {
        window.renderPopularProducts();
    }
};

window.renderPopularProducts = function() {
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
        window.location.href = '../store.html';
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
        
        // Update Product Info
        const titleEl = document.getElementById('product-title');
        if (titleEl) titleEl.innerText = product.name;
        
        const priceEl = document.getElementById('product-price');
        if (priceEl) priceEl.innerText = `₹${product.price}`;
        
        const descEl = document.getElementById('product-description');
        if (descEl) descEl.innerText = product.description || 'No description available.';
        
        // Update Category tag
        const tagEl = document.getElementById('product-category-tag');
        if (tagEl) tagEl.innerText = product.category_name || 'Health Foods';
        
        // Images
        const imgGallery = document.getElementById('product-main-image');
        if (imgGallery && product.primary_image) {
            imgGallery.src = product.primary_image;
            // You can also populate thumbnails if the UI has a container for it
        }
        
        // Bind Add to Cart / Wishlist
        const addToCartBtn = document.getElementById('btn-add-to-cart');
        if (addToCartBtn) {
            addToCartBtn.onclick = function() {
                const qtyInput = document.getElementById('qty');
                const qty = qtyInput ? parseInt(qtyInput.value) : 1;
                window.addToCart(product.id, qty);
            };
        }
        
        const wishlistBtn = document.getElementById('btn-add-to-wishlist');
        if (wishlistBtn) {
            wishlistBtn.onclick = function() {
                window.addToWishlist(product.id, this);
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
                    <a href="../auth/login.html" class="bg-[#106e39] text-white px-6 py-2 rounded-lg font-bold">Login</a>
                </div>
            `;
        }
        updateCartTotals(0);
        return;
    }
    
    await renderCart();
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
                    <a href="../store.html" class="bg-[#106e39] text-white px-6 py-2 rounded-lg font-bold">Continue Shopping</a>
                </div>
            `;
            updateCartTotals(0);
            return;
        }
        
        let html = '';
        cart.items.forEach(item => {
            html += `
                <div class="flex flex-col sm:flex-row sm:items-center gap-6 py-6 border-b border-gray-100 last:border-0 last:pb-0">
                    <img src="${item.primary_image || 'https://via.placeholder.com/150'}" class="w-24 h-24 object-contain rounded-lg bg-gray-50 mix-blend-multiply border border-gray-100" alt="Product">
                    
                    <div class="flex-1 cursor-pointer" onclick="window.location.href='product.html?id=${item.product_id || item.id}'">
                        <h3 class="text-[#1e293b] font-bold text-[14px] leading-snug mb-1 hover:text-[#106e39] transition-colors">${item.name}</h3>
                        <div class="text-gray-400 text-[12px] font-medium mb-3">${item.category_name || ''}</div>
                    </div>
                    
                    <div class="flex flex-row sm:flex-col items-center sm:items-end justify-between sm:justify-center gap-4 w-full sm:w-auto mt-4 sm:mt-0">
                        <div class="text-right">
                            <div class="text-[#106e39] font-bold text-lg leading-none">₹${item.price}</div>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <div class="flex items-center bg-[#f8fcf9] rounded-lg border border-gray-200 p-1">
                                <button onclick="updateCartQuantity(${item.cart_item_id}, ${item.quantity - 1})" class="w-7 h-7 flex items-center justify-center text-gray-500 hover:text-[#106e39] font-bold rounded-md hover:bg-white transition-colors">-</button>
                                <span class="w-8 text-center text-[13px] font-bold text-[#1e293b]">${item.quantity}</span>
                                <button onclick="updateCartQuantity(${item.cart_item_id}, ${item.quantity + 1})" class="w-7 h-7 flex items-center justify-center text-[#106e39] font-bold rounded-md hover:bg-white transition-colors">+</button>
                            </div>
                            <button onclick="removeCartItem(${item.cart_item_id})" class="text-gray-400 hover:text-red-500 transition-colors w-8 h-8 flex items-center justify-center rounded-lg hover:bg-red-50">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </div>
                    </div>
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

function updateCartTotals(subtotal) {
    const subtotalEl = document.getElementById('cart-subtotal');
    if (subtotalEl) subtotalEl.innerText = `₹${subtotal.toFixed(2)}`;
    
    const totalEl = document.getElementById('cart-total');
    if (totalEl) totalEl.innerText = `₹${subtotal.toFixed(2)}`; // Assuming free shipping for simplicity
}

// --- Wishlist ---
async function initWishlist() {
    if (!localStorage.getItem('hbm_token')) {
        window.location.href = '../auth/login.html?redirect=../dashboard/wishlist.html';
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
                    <a href="../store.html" class="bg-[#106e39] text-white px-6 py-2 rounded-lg font-bold">Browse Store</a>
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
            btn.onclick = async function(e) {
                await originalClick.call(this, e);
                initWishlist(); // reload the list
            };
        });
        
    } catch (e) {
        console.error("Failed to load wishlist", e);
    }
}
