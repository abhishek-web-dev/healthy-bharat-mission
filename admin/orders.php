<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Order Management</h2>
        <p class="text-sm text-gray-500 mt-1">Track customer orders, update fulfillment statuses, and view payments.</p>
    </div>
    <div class="flex items-center gap-3">
        <div class="bg-white rounded-lg border border-gray-100 px-4 py-2 flex items-center gap-3 text-sm shadow-sm">
            <i class="fa-solid fa-shopping-cart text-[#106e39]"></i>
            <span class="font-medium text-gray-600">Total Orders: <span id="total-count-badge" class="font-bold text-gray-800">...</span></span>
        </div>
    </div>
</div>

<!-- Filters & Search -->
<div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm mb-6 flex flex-col md:flex-row gap-4 items-end">
    <div class="w-full md:w-1/3">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Search Orders</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-search text-gray-400"></i>
            </div>
            <input type="text" id="search-input" placeholder="Search by Order ID, Name, Phone..." class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
        </div>
    </div>
    
    <div class="w-full md:w-1/4">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Fulfillment Status</label>
        <select id="status-filter" class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
            <option value="">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="processing">Processing</option>
            <option value="shipped">Shipped</option>
            <option value="delivered">Delivered</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>
    
    <div class="w-full md:w-1/4">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Payment Status</label>
        <select id="payment-filter" class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
            <option value="">All Payments</option>
            <option value="success">Success / Paid</option>
            <option value="pending">Pending</option>
            <option value="failed">Failed</option>
        </select>
    </div>
</div>

<!-- Orders Table -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="orders-table">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500">
                    <th class="px-6 py-4 font-bold">Order ID</th>
                    <th class="px-6 py-4 font-bold">Date</th>
                    <th class="px-6 py-4 font-bold">Customer</th>
                    <th class="px-6 py-4 font-bold text-right">Total</th>
                    <th class="px-6 py-4 font-bold text-center">Payment</th>
                    <th class="px-6 py-4 font-bold text-center">Status</th>
                    <th class="px-6 py-4 font-bold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm" id="orders-tbody">
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                        <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
                        <p>Loading orders...</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div id="pagination-container" class="px-6 py-4 border-t border-gray-100 flex items-center justify-between hidden">
        <p class="text-sm text-gray-500">Showing <span id="page-start" class="font-bold">0</span> to <span id="page-end" class="font-bold">0</span> of <span id="page-total" class="font-bold">0</span> results</p>
        <div class="flex items-center gap-1" id="pagination-buttons">
            <!-- Buttons injected by JS -->
        </div>
    </div>
    
    <!-- Empty State -->
    <div id="empty-state" class="hidden flex-col items-center justify-center p-12 text-center">
        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 text-2xl mb-4">
            <i class="fa-solid fa-receipt"></i>
        </div>
        <h3 class="font-bold text-gray-800 text-lg mb-1">No orders found</h3>
        <p class="text-sm text-gray-500 max-w-sm">No orders matched your search or filter criteria.</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let allOrders = [];
    let currentOrderId = null;
    let currentPage = 1;
    const itemsPerPage = 15;
    
    const tbody = document.getElementById('orders-tbody');
    const emptyState = document.getElementById('empty-state');
    const tableHeader = document.querySelector('thead');
    const searchInput = document.getElementById('search-input');
    const statusFilter = document.getElementById('status-filter');
    const paymentFilter = document.getElementById('payment-filter');
    const totalCountBadge = document.getElementById('total-count-badge');
    
    // Pagination Elements
    const paginationContainer = document.getElementById('pagination-container');
    const pageStart = document.getElementById('page-start');
    const pageEnd = document.getElementById('page-end');
    const pageTotal = document.getElementById('page-total');
    const paginationButtons = document.getElementById('pagination-buttons');

    async function fetchOrders() {
        try {
            const res = await window.HBM_API.request('/admin/orders');
            if (res.data && res.data.orders) {
                allOrders = res.data.orders;
                totalCountBadge.textContent = allOrders.length;
                renderOrders();
            }
        } catch (error) {
            console.error("Failed to fetch orders", error);
            tbody.innerHTML = `<tr><td colspan="7" class="px-6 py-8 text-center text-red-500 font-medium">Failed to load orders.</td></tr>`;
        }
    }
    
    function formatCurrency(amount) {
        return new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' }).format(amount);
    }
    
    function getStatusBadge(status) {
        status = status || 'pending';
        switch(status.toLowerCase()) {
            case 'pending': return `<span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider border bg-orange-50 text-orange-600 border-orange-200">Pending</span>`;
            case 'processing': return `<span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider border bg-blue-50 text-blue-600 border-blue-200">Processing</span>`;
            case 'shipped': return `<span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider border bg-purple-50 text-purple-600 border-purple-200">Shipped</span>`;
            case 'delivered': return `<span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider border bg-green-50 text-green-700 border-green-200">Delivered</span>`;
            case 'cancelled': return `<span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider border bg-red-50 text-red-600 border-red-200">Cancelled</span>`;
            default: return `<span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider border bg-gray-50 text-gray-600 border-gray-200">${status}</span>`;
        }
    }
    
    function getPaymentBadge(status) {
        status = status || 'pending';
        switch(status.toLowerCase()) {
            case 'success': return `<span class="text-green-600 font-bold text-xs flex items-center justify-center gap-1"><i class="fa-solid fa-circle-check"></i> Paid</span>`;
            case 'failed': return `<span class="text-red-600 font-bold text-xs flex items-center justify-center gap-1"><i class="fa-solid fa-circle-xmark"></i> Failed</span>`;
            default: return `<span class="text-orange-500 font-bold text-xs flex items-center justify-center gap-1"><i class="fa-regular fa-clock"></i> Pending</span>`;
        }
    }
    
    function renderOrders() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusTerm = statusFilter.value;
        const paymentTerm = paymentFilter.value;
        
        const filtered = allOrders.filter(o => {
            const customerName = `${o.shipping_first_name || ''} ${o.shipping_last_name || ''}`.toLowerCase();
            const matchesSearch = (o.order_number && o.order_number.toLowerCase().includes(searchTerm)) || 
                                  customerName.includes(searchTerm) || 
                                  (o.shipping_phone && o.shipping_phone.includes(searchTerm));
            const matchesStatus = statusTerm === '' || o.order_status === statusTerm;
            const matchesPayment = paymentTerm === '' || o.payment_status === paymentTerm;
            return matchesSearch && matchesStatus && matchesPayment;
        });
        
        if (filtered.length === 0) {
            tbody.innerHTML = '';
            tableHeader.style.display = allOrders.length === 0 ? 'none' : 'table-header-group';
            emptyState.classList.remove('hidden');
            emptyState.classList.add('flex');
            if (paginationContainer) paginationContainer.classList.add('hidden');
            return;
        }
        
        const totalPages = Math.ceil(filtered.length / itemsPerPage);
        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;
        
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = Math.min(startIndex + itemsPerPage, filtered.length);
        const paginated = filtered.slice(startIndex, endIndex);
        
        emptyState.classList.add('hidden');
        emptyState.classList.remove('flex');
        tableHeader.style.display = 'table-header-group';
        if (paginationContainer) paginationContainer.classList.remove('hidden');
        
        if (pageStart) pageStart.textContent = startIndex + 1;
        if (pageEnd) pageEnd.textContent = endIndex;
        if (pageTotal) pageTotal.textContent = filtered.length;
        
        renderPaginationButtons(totalPages);
        
        tbody.innerHTML = paginated.map(o => {
            const date = new Date(o.created_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute:'2-digit' });
            const name = `${o.shipping_first_name || ''} ${o.shipping_last_name || ''}`.trim() || 'Unknown Customer';
            
            return `
                <tr class="hover:bg-gray-50/50 transition-colors cursor-pointer" onclick="window.location.href='order-detail.php?id=${o.id}'">
                    <td class="px-6 py-4 font-mono text-xs font-bold text-[#106e39]">${o.order_number}</td>
                    <td class="px-6 py-4 text-xs text-gray-500">${date}</td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-gray-800 text-sm truncate max-w-[150px]">${name}</p>
                        <p class="text-[11px] text-gray-500">${o.shipping_phone || ''}</p>
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-gray-800 text-right">${formatCurrency(o.total_amount)}</td>
                    <td class="px-6 py-4 text-center">${getPaymentBadge(o.payment_status)}</td>
                    <td class="px-6 py-4 text-center">${getStatusBadge(o.order_status)}</td>
                    <td class="px-6 py-4 text-right">
                        <button class="p-2 text-gray-400 hover:text-[#106e39] hover:bg-[#f2fbf5] rounded-lg transition-colors" title="View Details">
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
    }
    


    function renderPaginationButtons(totalPages) {
        let html = '';
        if (totalPages <= 1) {
            paginationButtons.innerHTML = '';
            return;
        }
        
        html += `<button onclick="window.goToPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''} class="px-2.5 py-1 border border-gray-200 rounded-md text-sm font-medium ${currentPage === 1 ? 'text-gray-300 bg-gray-50 cursor-not-allowed' : 'text-gray-600 hover:bg-gray-50'}"><i class="fa-solid fa-chevron-left text-[10px]"></i></button>`;
        
        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, currentPage + 2);
        
        if (startPage > 1) {
            html += `<button onclick="window.goToPage(1)" class="px-3 py-1 border border-gray-200 text-gray-600 hover:bg-gray-50 rounded-md text-sm font-medium">1</button>`;
            if (startPage > 2) html += `<span class="px-2 text-gray-400">...</span>`;
        }
        
        for (let i = startPage; i <= endPage; i++) {
            html += `<button onclick="window.goToPage(${i})" class="px-3 py-1 border ${currentPage === i ? 'bg-[#106e39] text-white border-[#106e39]' : 'border-gray-200 text-gray-600 hover:bg-gray-50'} rounded-md text-sm font-medium">${i}</button>`;
        }
        
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) html += `<span class="px-2 text-gray-400">...</span>`;
            html += `<button onclick="window.goToPage(${totalPages})" class="px-3 py-1 border border-gray-200 text-gray-600 hover:bg-gray-50 rounded-md text-sm font-medium">${totalPages}</button>`;
        }
        
        html += `<button onclick="window.goToPage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''} class="px-2.5 py-1 border border-gray-200 rounded-md text-sm font-medium ${currentPage === totalPages ? 'text-gray-300 bg-gray-50 cursor-not-allowed' : 'text-gray-600 hover:bg-gray-50'}"><i class="fa-solid fa-chevron-right text-[10px]"></i></button>`;
        
        paginationButtons.innerHTML = html;
    }
    
    window.goToPage = function(page) {
        currentPage = page;
        renderOrders();
    };

    fetchOrders();
});
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
