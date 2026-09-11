document.addEventListener('DOMContentLoaded', async () => {
    const container = document.getElementById('orders-container');
    const sortSelect = document.getElementById('sort-orders');
    
    if (!container) return; // If we are not on the store orders page, do nothing.

    let allOrders = [];

    // Add a basic loading state to the container
    container.innerHTML = `
        <div class="flex flex-col items-center justify-center p-12 w-full text-center">
            <div class="w-10 h-10 border-4 border-gray-200 border-t-[#106e39] rounded-full animate-spin"></div>
            <p class="text-gray-500 text-sm mt-4 font-medium animate-pulse">Loading your orders...</p>
        </div>
    `;

    try {
        const response = await HBM_API.request('/orders');
        
        if (response.success && response.data && response.data.orders) {
            allOrders = response.data.orders;
            renderOrders(allOrders);
        } else {
            showEmptyState();
        }
    } catch (error) {
        console.error('Failed to load orders:', error);
        container.innerHTML = `
            <div class="flex flex-col items-center justify-center p-12 w-full text-center bg-white rounded-2xl border border-red-100 shadow-sm">
                <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-red-500 mb-4">
                    <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Failed to Load Orders</h3>
                <p class="text-gray-500 text-[13px] max-w-sm">We encountered an error while retrieving your orders. Please try refreshing the page.</p>
                <button onclick="window.location.reload()" class="mt-6 px-6 py-2.5 bg-[#106e39] text-white rounded-xl text-sm font-semibold hover:bg-green-800 transition-colors shadow-sm">
                    Retry
                </button>
            </div>
        `;
    }

    // Handle Sorting
    if (sortSelect) {
        sortSelect.addEventListener('change', (e) => {
            const sortValue = e.target.value;
            let sortedOrders = [...allOrders];
            
            if (sortValue === 'newest') {
                sortedOrders.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
            } else if (sortValue === 'oldest') {
                sortedOrders.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
            }
            
            renderOrders(sortedOrders);
        });
    }

    function renderOrders(orders) {
        if (orders.length === 0) {
            showEmptyState();
            return;
        }

        let html = '';
        orders.forEach(order => {
            // Format date
            const dateObj = new Date(order.created_at);
            const formattedDate = dateObj.toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
            
            // Get first item
            const firstItem = order.items && order.items.length > 0 ? order.items[0] : null;
            const productImg = firstItem && firstItem.image_url ? firstItem.image_url : '../assets/logo.webp';
            const productName = firstItem ? firstItem.product_name_snapshot : 'Order Items';
            const qty = firstItem ? firstItem.quantity : 1;
            const extraItems = order.items ? order.items.length - 1 : 0;
            
            const nameDisplay = extraItems > 0 ? `${productName} <span class="text-xs text-gray-400 font-normal ml-1">+${extraItems} more</span>` : productName;
            
            // Format Price
            const price = parseFloat(order.total_amount).toLocaleString('en-IN', { maximumFractionDigits: 0 });
            
            // Status Badge
            let statusBadge = '';
            let statusClass = order.order_status.toLowerCase();
            
            if (statusClass === 'delivered') {
                statusBadge = `<span class="bg-[#f2faf5] text-[#106e39] text-xs font-bold px-4 py-1.5 rounded-lg w-[100px] text-center inline-block">Delivered</span>`;
            } else if (statusClass === 'processing' || statusClass === 'shipped') {
                statusBadge = `<span class="bg-[#f0f6fc] text-blue-600 text-xs font-bold px-4 py-1.5 rounded-lg w-[100px] text-center inline-block capitalize">${statusClass}</span>`;
            } else if (statusClass === 'cancelled') {
                statusBadge = `<span class="bg-[#fff5f5] text-red-500 text-xs font-bold px-4 py-1.5 rounded-lg w-[100px] text-center inline-block">Cancelled</span>`;
            } else {
                statusBadge = `<span class="bg-gray-100 text-gray-600 text-xs font-bold px-4 py-1.5 rounded-lg w-[100px] text-center inline-block capitalize">${statusClass}</span>`;
            }

            // Format Order Number properly
            const orderNumberDisplay = order.order_number.toString().startsWith('HBM') ? order.order_number : `HBM${order.order_number}`;

            html += `
                <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center gap-5 hover:shadow-md transition-shadow">
                    <!-- Image -->
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-gray-50 rounded-xl border border-gray-100 shrink-0 p-1.5 shadow-[0_2px_8px_rgba(0,0,0,0.04)] overflow-hidden flex items-center justify-center">
                        <img src="${productImg}" alt="Product" class="w-full h-full object-contain" onerror="this.src='../assets/logo.webp'">
                    </div>
                    
                    <!-- Order Info -->
                    <div class="flex-1 min-w-0 flex flex-col md:flex-row md:items-center" style="gap: 1.5rem;">
                        <!-- ID & Date -->
                        <div style="width: 100%; max-width: 160px;" class="shrink-0">
                            <h4 class="font-bold text-gray-800 text-[14px] md:text-[15px] mb-1">Order #${orderNumberDisplay}</h4>
                            <p class="text-[13px] text-gray-500 font-medium"><i class="fa-regular fa-calendar text-gray-400 mr-1.5"></i>${formattedDate}</p>
                        </div>
                        
                        <!-- Product Name -->
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-gray-700 text-[14px] md:text-[15px] truncate mb-1">${nameDisplay}</h4>
                            <p class="text-[12px] text-gray-500 font-semibold uppercase tracking-wide">Qty: ${qty}</p>
                        </div>
                        
                        <!-- Price -->
                        <div style="width: 100px;" class="shrink-0">
                            <span class="font-bold text-[#052b14] text-[16px] md:text-[18px]">₹${price}</span>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex items-center justify-between md:justify-end gap-5 shrink-0 mt-3 md:mt-0 pt-4 md:pt-0 border-t md:border-0 border-gray-100" style="min-width: 240px;">
                        ${statusBadge}
                        <button onclick="window.location.href='order-details.html?id=${order.id}'" class="px-5 py-2.5 text-[13px] font-bold text-[#106e39] border border-green-200 bg-white rounded-xl hover:bg-[#106e39] hover:text-white transition-all whitespace-nowrap shadow-sm hover:shadow-md">
                            View Details
                        </button>
                    </div>
                </div>
            `;
        });
        
        container.innerHTML = html;
    }

    function showEmptyState() {
        container.innerHTML = `
            <div class="flex flex-col items-center justify-center p-16 w-full text-center bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 mb-5 shadow-inner">
                    <i class="fa-solid fa-box-open text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">No Orders Yet</h3>
                <p class="text-gray-500 text-[13px] max-w-sm mb-6 leading-relaxed">You haven't placed any orders yet. Discover our healthy products and kickstart your journey!</p>
                <a href="../store.html" class="px-6 py-3 bg-[#106e39] text-white rounded-xl text-sm font-semibold hover:bg-green-800 transition-colors shadow-sm">
                    Shop Now
                </a>
            </div>
        `;
    }
});
