document.addEventListener('DOMContentLoaded', async () => {
    const path = window.location.pathname;

    if (path.endsWith('/') || path.endsWith('index') || path.endsWith('index.php')) {
        await fetchHomeProducts();
        await fetchHomeArticles();
    }
});

async function fetchHomeProducts() {
    const container = document.getElementById('home-recommended-products');
    if (!container) return;

    try {
        const res = await window.HBM_API.request('/products');
        if (res.success && res.data) {
            const products = res.data.slice(0, 6);
            if (products.length === 0) {
                container.innerHTML = '<div class="w-full text-center text-sm text-gray-500 py-4">No products available at the moment.</div>';
                return;
            }

            container.innerHTML = products.map(p => {
                const img = p.thumbnail_url || p.primary_image || 'https://via.placeholder.com/200';
                return `
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg hover:border-primary/20 transition-all duration-300 group flex flex-col relative w-48 md:w-52 xl:w-56 shrink-0 cursor-pointer" onclick="window.location.href='./store.php?id=${p.id}'">
                    <div class="bg-[#f8fafc] p-4 relative flex items-center justify-center h-48 border-b border-gray-50">
                        <div class="absolute top-3 left-3 bg-primary text-white text-[9px] font-black tracking-wider uppercase px-2.5 py-1 rounded shadow-sm z-10">
                            ${p.category_name || 'Product'}
                        </div>
                        <img src="${img}" alt="${p.name}" class="h-full w-full object-contain mix-blend-multiply group-hover:scale-110 transition-transform duration-500 ease-out z-0">
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-extrabold text-gray-900 text-[13px] xl:text-sm mb-2 leading-snug group-hover:text-primary transition-colors line-clamp-2">
                            ${p.name}
                        </h3>
                        <div class="flex items-end justify-between mt-auto pt-2">
                            <div>
                                <div class="text-lg font-black text-primary">₹${p.price}</div>
                            </div>
                        </div>
                    </div>
                </div>
                `;
            }).join('');

            // Setup Auto Slide using Scroll
            const parent = container.parentElement;
            let autoSlideInterval;
            
            const startAutoSlide = () => {
                autoSlideInterval = setInterval(() => {
                    if (container.scrollLeft + container.clientWidth >= container.scrollWidth - 10) {
                        container.scrollTo({ left: 0, behavior: 'smooth' });
                    } else {
                        const cardWidth = container.firstElementChild.offsetWidth;
                        const gap = parseFloat(window.getComputedStyle(container).gap) || 16;
                        container.scrollBy({ left: cardWidth + gap, behavior: 'smooth' });
                    }
                }, 3000);
            };

            const stopAutoSlide = () => clearInterval(autoSlideInterval);
            
            if (products.length > 2) {
                startAutoSlide();
                parent.addEventListener('mouseenter', stopAutoSlide);
                parent.addEventListener('mouseleave', startAutoSlide);
                parent.addEventListener('touchstart', stopAutoSlide, {passive: true});
                parent.addEventListener('touchend', startAutoSlide, {passive: true});
            }

            // Arrow buttons
            const leftArrow = parent.querySelector('button:first-of-type');
            const rightArrow = parent.querySelector('button:last-of-type');
            
            if (leftArrow) {
                leftArrow.onclick = () => {
                    stopAutoSlide();
                    const cardWidth = container.firstElementChild.offsetWidth;
                    const gap = parseFloat(window.getComputedStyle(container).gap) || 16;
                    container.scrollBy({ left: -(cardWidth + gap), behavior: 'smooth' });
                    if (products.length > 2) startAutoSlide();
                };
            }
            if (rightArrow) {
                rightArrow.onclick = () => {
                    stopAutoSlide();
                    const cardWidth = container.firstElementChild.offsetWidth;
                    const gap = parseFloat(window.getComputedStyle(container).gap) || 16;
                    container.scrollBy({ left: cardWidth + gap, behavior: 'smooth' });
                    if (products.length > 2) startAutoSlide();
                };
            }
        }
    } catch (e) {
        container.innerHTML = '<div class="w-full text-center text-sm text-red-500 py-4">Failed to load recommended products.</div>';
        console.error(e);
    }
}

async function fetchHomeArticles() {
    const container = document.getElementById('home-latest-articles');
    if (!container) return;

    try {
        const res = await window.HBM_API.request('/articles');
        if (res.success && res.data) {
            const articles = res.data.slice(0, 3);
            if (articles.length === 0) {
                container.innerHTML = '<div class="w-full text-center text-sm text-gray-500 py-4">No articles available at the moment.</div>';
                return;
            }

            container.innerHTML = articles.map(a => {
                const dateRaw = a.published_at || a.created_at;
                let dateStr = '';
                if (dateRaw) {
                    const d = new Date(dateRaw);
                    if (!isNaN(d.valueOf())) {
                        dateStr = d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                    }
                }
                if (!dateStr) {
                    dateStr = 'Recently';
                }

                // Since DB has null for image_url, fall back to default
                const img = a.image_url || 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?w=200&q=80';

                return `
                <a href="./article.php?slug=${a.slug}" class="flex items-start space-x-4 group p-2 hover:bg-gray-50 rounded-lg transition-colors">
                    <div class="w-24 xl:w-28 h-16 xl:h-20 rounded-md overflow-hidden shrink-0 border border-gray-100">
                        <img src="${img}"
                            alt="${a.title}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="flex flex-col justify-center h-full pt-1">
                        <h4 class="font-bold text-slate-800 text-[13px] xl:text-sm leading-snug group-hover:text-primary transition-colors mb-1.5 line-clamp-2">
                            ${a.title}
                        </h4>
                        <p class="text-[10px] xl:text-[11px] text-gray-400 font-medium">
                            ${dateStr}
                            ${a.category_name ? ` • ${a.category_name}` : ''}
                        </p>
                    </div>
                </a>
                `;
            }).join('');
        }
    } catch (e) {
        container.innerHTML = '<div class="w-full text-center text-sm text-red-500 py-4">Failed to load latest articles.</div>';
        console.error(e);
    }
}
