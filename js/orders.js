document.addEventListener('DOMContentLoaded', () => {
    // Check authentication
    if (!HBM_API.getToken()) {
        localStorage.setItem('redirectUrl', window.location.pathname);
        window.location.href = '../auth/login.html';
        return;
    }

    let allOrders = [];

    if (window.location.pathname.includes('my-orders.html')) {
        loadMyOrders();
        setupSortListener();
    }

    function setupSortListener() {
        const sortSelect = document.getElementById('sort-orders');
        if (sortSelect) {
            sortSelect.addEventListener('change', (e) => {
                if (allOrders.length === 0) return;
                
                const sortBy = e.target.value;
                if (sortBy === 'newest') {
                    allOrders.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                } else if (sortBy === 'oldest') {
                    allOrders.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
                }
                
                const container = document.getElementById('orders-container');
                renderOrders(allOrders, container);
            });
        }
    }

    async function loadMyOrders() {
        const container = document.getElementById('orders-container'); // Container for orders
        if (!container) return;

        try {
            // Show loading
            container.innerHTML = '<div class="text-center py-12"><i class="fa-solid fa-circle-notch fa-spin text-3xl text-[#106e39]"></i><p class="mt-4 text-gray-500 font-medium">Loading your orders...</p></div>';

            const response = await HBM_API.orders.getAll();
            if (response.success && response.data.orders.length > 0) {
                allOrders = response.data.orders;
                // Default sort (Newest First)
                allOrders.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                renderOrders(allOrders, container);
            } else {
                container.innerHTML = `
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-12 text-center">
                        <div class="w-20 h-20 bg-[#f9fbf9] rounded-full flex items-center justify-center mx-auto mb-4 text-[#106e39] text-3xl border-2 border-gray-100">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 text-[18px] mb-2">No orders found</h3>
                        <p class="text-gray-500 text-[14px] mb-6">Looks like you haven't placed any orders yet.</p>
                        <a href="../store.html" class="inline-block px-6 py-3 bg-[#106e39] text-white font-bold rounded-lg hover:bg-[#0a4d27] transition-colors text-[14px]">Start Shopping</a>
                    </div>
                `;
            }
        } catch (error) {
            console.error('Error loading orders:', error);
            container.innerHTML = '<div class="text-center py-8 text-red-500"><p>Failed to load orders. Please try again later.</p></div>';
        }
    }

    function renderOrders(orders, container) {
        container.innerHTML = ''; // Clear

        orders.forEach(order => {
            const date = new Date(order.created_at).toLocaleString('en-US', { dateStyle: 'medium', timeStyle: 'short' });
            
            // Status styling
            let statusBadge = '';
            if (order.order_status === 'processing') {
                statusBadge = `
                <div class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-600 px-2.5 py-1 rounded w-fit border border-amber-100">
                    <i class="fa-solid fa-clock-rotate-left text-[10px]"></i>
                    <span class="text-[10px] font-bold tracking-wide uppercase">Processing</span>
                </div>`;
            } else if (order.order_status === 'shipped') {
                statusBadge = `
                <div class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-600 px-2.5 py-1 rounded w-fit border border-blue-100">
                    <i class="fa-solid fa-truck-fast text-[10px]"></i>
                    <span class="text-[10px] font-bold tracking-wide uppercase">Shipped</span>
                </div>`;
            } else if (order.order_status === 'delivered') {
                statusBadge = `
                <div class="inline-flex items-center gap-1.5 bg-[#e2f6e9] text-[#106e39] px-2.5 py-1 rounded w-fit border border-[#cbf0d8]">
                    <i class="fa-solid fa-circle-check text-[10px]"></i>
                    <span class="text-[10px] font-bold tracking-wide uppercase">Delivered</span>
                </div>`;
            } else if (order.order_status === 'cancelled') {
                statusBadge = `
                <div class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 px-2.5 py-1 rounded w-fit border border-red-100">
                    <i class="fa-solid fa-xmark text-[10px]"></i>
                    <span class="text-[10px] font-bold tracking-wide uppercase">Cancelled</span>
                </div>`;
            }

            // Images logic
            let imagesHtml = '';
            let itemsCount = order.items.length;
            let displayCount = Math.min(itemsCount, 3);
            
            for (let i=0; i<displayCount; i++) {
                imagesHtml += `
                <div class="w-16 h-16 rounded-lg bg-[#f8fafc] border border-gray-100 flex items-center justify-center p-1 overflow-hidden shrink-0">
                    <img src="${order.items[i].image_url}" class="object-contain h-full w-full mix-blend-multiply" alt="Product">
                </div>`;
            }

            if (itemsCount > 3) {
                imagesHtml += `
                <div class="w-12 h-16 rounded-lg bg-gray-50 flex items-center justify-center font-bold text-gray-500 text-[13px] shrink-0 border border-gray-100">
                    +${itemsCount - 3}
                </div>`;
            }

            let paymentText = order.payment_method === 'cod' ? 'Paid via COD' : `Paid via Razorpay (${order.payment_method.replace('_', ' ')})`;

            const html = `
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow p-5 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="flex flex-col w-full lg:w-56 shrink-0">
                    <h3 class="font-bold text-gray-900 text-[15px]">Order #${order.order_number}</h3>
                    <p class="text-[11px] text-gray-500 mt-0.5 mb-2.5">Placed on ${date}</p>
                    ${statusBadge}
                </div>
                
                <div class="flex flex-wrap gap-2 flex-1 items-center">
                    ${imagesHtml}
                </div>
                
                <div class="flex flex-col w-full lg:w-48 shrink-0 text-left">
                    <p class="text-[11px] text-gray-500 mb-0.5">${itemsCount} items</p>
                    <p class="text-[16px] text-[#052b14]"><span class="font-extrabold">Total:</span> <span class="font-bold">₹${parseFloat(order.total_amount).toFixed(2)}</span></p>
                    <p class="text-[11px] text-gray-500 mt-0.5 capitalize">${paymentText}</p>
                </div>
                
                <div class="w-full lg:w-32 shrink-0 flex lg:justify-end mt-2 lg:mt-0">
                    <a href="#" onclick="alert('Order Details screen is currently missing/under development.'); return false;" class="w-full lg:w-auto px-5 py-2.5 rounded-lg border-2 border-[#106e39] text-[#106e39] hover:bg-[#106e39] hover:text-white font-bold text-[12px] transition-colors text-center block lg:inline-block">
                        View Details
                    </a>
                </div>
            </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        });
    }
});
