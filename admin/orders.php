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
    
    <!-- Empty State -->
    <div id="empty-state" class="hidden flex-col items-center justify-center p-12 text-center">
        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 text-2xl mb-4">
            <i class="fa-solid fa-receipt"></i>
        </div>
        <h3 class="font-bold text-gray-800 text-lg mb-1">No orders found</h3>
        <p class="text-sm text-gray-500 max-w-sm">No orders matched your search or filter criteria.</p>
    </div>
</div>

<!-- View/Edit Order Modal -->
<div id="order-modal" class="fixed inset-0 bg-gray-900/50 z-50 hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-300 overflow-y-auto pt-16 pb-16">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl overflow-hidden transform scale-95 transition-transform duration-300 flex flex-col max-h-[90vh]" id="order-modal-content">
        <!-- Modal Header -->
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50 shrink-0">
            <div>
                <h3 class="text-xl font-bold text-gray-800" id="modal-title">Order Details</h3>
                <p class="text-sm text-gray-500 mt-1 font-mono" id="modal-order-number">HBM...</p>
            </div>
            <button id="close-modal-btn" class="text-gray-400 hover:text-gray-600 transition-colors w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-200">
                <i class="fa-solid fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-6 overflow-y-auto custom-scrollbar flex-1 relative" id="modal-body">
            <!-- Loading Overlay -->
            <div id="modal-loading" class="absolute inset-0 bg-white/90 z-10 flex flex-col items-center justify-center hidden">
                <i class="fa-solid fa-spinner fa-spin text-3xl text-[#106e39] mb-3"></i>
                <p class="text-gray-500 font-medium">Fetching complete order details...</p>
            </div>
            
            <div id="modal-error" class="hidden mb-6 p-4 rounded-lg bg-red-50 text-red-600 text-sm font-medium border border-red-100 flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation"></i> <span></span>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Items and Customer Info -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Order Items -->
                    <div class="border border-gray-100 rounded-xl overflow-hidden">
                        <div class="bg-gray-50 px-4 py-3 border-b border-gray-100">
                            <h4 class="font-bold text-gray-700 uppercase tracking-wider text-xs">Ordered Items</h4>
                        </div>
                        <div class="p-0">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="text-xs uppercase tracking-wider text-gray-400 border-b border-gray-50">
                                        <th class="px-4 py-2 font-bold">Product</th>
                                        <th class="px-4 py-2 font-bold text-right">Price</th>
                                        <th class="px-4 py-2 font-bold text-right">Qty</th>
                                        <th class="px-4 py-2 font-bold text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 text-sm" id="modal-order-items">
                                    <!-- Items Injected by JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Customer Info Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Shipping Address -->
                        <div class="border border-gray-100 rounded-xl overflow-hidden flex flex-col">
                            <div class="bg-gray-50 px-4 py-3 border-b border-gray-100">
                                <h4 class="font-bold text-gray-700 uppercase tracking-wider text-xs">Shipping Information</h4>
                            </div>
                            <div class="p-4 text-sm text-gray-600 flex-1">
                                <p class="font-bold text-gray-800 mb-1" id="modal-cust-name"></p>
                                <p id="modal-cust-phone" class="mb-2"><i class="fa-solid fa-phone text-gray-400 w-4"></i> <span></span></p>
                                <p id="modal-cust-email" class="mb-3 hidden"><i class="fa-solid fa-envelope text-gray-400 w-4"></i> <span></span></p>
                                
                                <div class="text-gray-500 pt-3 border-t border-gray-50">
                                    <p id="modal-cust-address1"></p>
                                    <p id="modal-cust-address2"></p>
                                    <p><span id="modal-cust-city"></span>, <span id="modal-cust-state"></span></p>
                                    <p id="modal-cust-pincode" class="font-mono mt-1"></p>
                                    <p id="modal-cust-landmark" class="text-xs italic mt-1"></p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Order Summary -->
                        <div class="border border-gray-100 rounded-xl overflow-hidden flex flex-col">
                            <div class="bg-gray-50 px-4 py-3 border-b border-gray-100">
                                <h4 class="font-bold text-gray-700 uppercase tracking-wider text-xs">Order Summary</h4>
                            </div>
                            <div class="p-4 text-sm">
                                <div class="flex justify-between py-1.5 text-gray-500">
                                    <span>Subtotal</span>
                                    <span id="modal-subtotal" class="font-medium text-gray-700"></span>
                                </div>
                                <div class="flex justify-between py-1.5 text-gray-500">
                                    <span>Shipping Fee</span>
                                    <span id="modal-shipping-fee" class="font-medium text-gray-700"></span>
                                </div>
                                <div class="flex justify-between py-3 border-t border-gray-100 mt-2">
                                    <span class="font-bold text-gray-800">Total Amount</span>
                                    <span id="modal-total" class="font-bold text-lg text-[#106e39]"></span>
                                </div>
                                <p class="text-xs text-gray-400 text-right mt-1">Method: <span id="modal-payment-method" class="uppercase font-bold"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column: Status Controls -->
                <div class="space-y-6">
                    <form id="order-status-form" class="border border-gray-100 rounded-xl overflow-hidden shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                        <div class="bg-[#106e39]/5 px-4 py-3 border-b border-gray-100">
                            <h4 class="font-bold text-[#106e39] uppercase tracking-wider text-xs flex items-center gap-2">
                                <i class="fa-solid fa-truck-fast"></i> Fulfillment Status
                            </h4>
                        </div>
                        <div class="p-4 space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Current Status</label>
                                <select id="edit-order-status" class="block w-full px-3 py-2.5 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm font-bold bg-gray-50">
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="shipped">Shipped</option>
                                    <option value="delivered">Delivered</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            <button type="submit" id="save-status-btn" class="w-full py-2 bg-gray-900 text-white rounded-lg text-sm font-bold shadow-sm hover:bg-gray-800 transition-colors flex justify-center items-center gap-2">
                                <span id="save-status-text">Update Status</span>
                                <i id="save-status-spinner" class="fa-solid fa-spinner fa-spin hidden"></i>
                            </button>
                        </div>
                    </form>
                    
                    <form id="payment-status-form" class="border border-gray-100 rounded-xl overflow-hidden">
                        <div class="bg-gray-50 px-4 py-3 border-b border-gray-100">
                            <h4 class="font-bold text-gray-700 uppercase tracking-wider text-xs flex items-center gap-2">
                                <i class="fa-solid fa-credit-card"></i> Payment Status
                            </h4>
                        </div>
                        <div class="p-4 space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Current Status</label>
                                <select id="edit-payment-status" class="block w-full px-3 py-2.5 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm font-bold bg-gray-50">
                                    <option value="pending">Pending</option>
                                    <option value="success">Success</option>
                                    <option value="failed">Failed</option>
                                </select>
                            </div>
                            <button type="submit" id="save-payment-btn" class="w-full py-2 bg-white border border-gray-200 text-gray-700 rounded-lg text-sm font-bold hover:bg-gray-50 transition-colors flex justify-center items-center gap-2">
                                <span id="save-payment-text">Update Payment</span>
                                <i id="save-payment-spinner" class="fa-solid fa-spinner fa-spin hidden"></i>
                            </button>
                            
                            <!-- Payment Gateway Reference (Safe Display) -->
                            <div id="payment-gateway-ref" class="hidden mt-4 pt-4 border-t border-gray-100 text-xs">
                                <p class="font-bold text-gray-600 mb-1">Gateway Details</p>
                                <p class="text-gray-400 font-mono truncate" title="Razorpay Order ID">Rzp Ord: <span id="ref-rzp-order" class="text-gray-600"></span></p>
                                <p class="text-gray-400 font-mono truncate" title="Razorpay Payment ID">Rzp Pay: <span id="ref-rzp-pay" class="text-gray-600"></span></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let allOrders = [];
    let currentOrderId = null;
    
    const tbody = document.getElementById('orders-tbody');
    const emptyState = document.getElementById('empty-state');
    const tableHeader = document.querySelector('thead');
    const searchInput = document.getElementById('search-input');
    const statusFilter = document.getElementById('status-filter');
    const paymentFilter = document.getElementById('payment-filter');
    const totalCountBadge = document.getElementById('total-count-badge');
    
    // Modal Elements
    const modal = document.getElementById('order-modal');
    const modalContent = document.getElementById('order-modal-content');
    const closeBtn = document.getElementById('close-modal-btn');
    const modalLoading = document.getElementById('modal-loading');
    const modalError = document.getElementById('modal-error');
    
    // Status Forms
    const statusForm = document.getElementById('order-status-form');
    const paymentForm = document.getElementById('payment-status-form');

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
            return;
        }
        
        emptyState.classList.add('hidden');
        emptyState.classList.remove('flex');
        tableHeader.style.display = 'table-header-group';
        
        tbody.innerHTML = filtered.map(o => {
            const date = new Date(o.created_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute:'2-digit' });
            const name = `${o.shipping_first_name || ''} ${o.shipping_last_name || ''}`.trim() || 'Unknown Customer';
            
            return `
                <tr class="hover:bg-gray-50/50 transition-colors cursor-pointer" onclick="openOrderModal(${o.id})">
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
    
    window.openOrderModal = async function(id) {
        currentOrderId = id;
        modalError.classList.add('hidden');
        
        // Show Modal & Loading
        modal.classList.remove('hidden');
        void modal.offsetWidth;
        modal.classList.remove('opacity-0');
        modalContent.classList.remove('scale-95');
        modalLoading.classList.remove('hidden');
        
        try {
            // Fetch detailed order (includes items and payment info)
            const res = await window.HBM_API.request(`/admin/orders/${id}`);
            const o = res.data;
            
            if (!o) throw new Error("Order data missing");
            
            // Populate Header
            document.getElementById('modal-order-number').textContent = o.order_number;
            
            // Populate Customer
            document.getElementById('modal-cust-name').textContent = `${o.shipping_first_name || ''} ${o.shipping_last_name || ''}`.trim() || 'Unknown Customer';
            document.getElementById('modal-cust-phone').querySelector('span').textContent = o.shipping_phone || 'N/A';
            
            if (o.shipping_email) {
                document.getElementById('modal-cust-email').classList.remove('hidden');
                document.getElementById('modal-cust-email').querySelector('span').textContent = o.shipping_email;
            } else {
                document.getElementById('modal-cust-email').classList.add('hidden');
            }
            
            document.getElementById('modal-cust-address1').textContent = o.shipping_address_line_1 || '';
            document.getElementById('modal-cust-address2').textContent = o.shipping_address_line_2 || '';
            document.getElementById('modal-cust-city').textContent = o.shipping_city || '';
            document.getElementById('modal-cust-state').textContent = o.shipping_state || '';
            document.getElementById('modal-cust-pincode').textContent = o.shipping_pincode || '';
            document.getElementById('modal-cust-landmark').textContent = o.shipping_landmark ? `Landmark: ${o.shipping_landmark}` : '';
            
            // Populate Summary
            document.getElementById('modal-subtotal').textContent = formatCurrency(o.subtotal);
            document.getElementById('modal-shipping-fee').textContent = formatCurrency(o.shipping_fee);
            document.getElementById('modal-total').textContent = formatCurrency(o.total_amount);
            document.getElementById('modal-payment-method').textContent = o.payment_method || 'N/A';
            
            // Set Selects
            document.getElementById('edit-order-status').value = o.order_status || 'pending';
            document.getElementById('edit-payment-status').value = o.payment_status || 'pending';
            
            // Populate Items
            const itemsTbody = document.getElementById('modal-order-items');
            if (o.items && o.items.length > 0) {
                itemsTbody.innerHTML = o.items.map(item => {
                    const total = item.price_snapshot * item.quantity;
                    return `
                        <tr>
                            <td class="px-4 py-3">
                                <p class="font-bold text-gray-800 line-clamp-2" title="${item.product_name_snapshot}">${item.product_name_snapshot}</p>
                                <p class="text-[10px] text-gray-400 font-mono mt-0.5">Prod ID: ${item.product_id}</p>
                            </td>
                            <td class="px-4 py-3 text-right text-gray-600 font-medium">${formatCurrency(item.price_snapshot)}</td>
                            <td class="px-4 py-3 text-right font-bold text-gray-800">x${item.quantity}</td>
                            <td class="px-4 py-3 text-right font-bold text-[#106e39]">${formatCurrency(total)}</td>
                        </tr>
                    `;
                }).join('');
            } else {
                itemsTbody.innerHTML = `<tr><td colspan="4" class="px-4 py-6 text-center text-gray-400">No items found for this order.</td></tr>`;
            }
            
            // Populate Payment Gateway Ref if available safely
            const gwDiv = document.getElementById('payment-gateway-ref');
            if (o.payment && o.payment.razorpay_payment_id) {
                gwDiv.classList.remove('hidden');
                document.getElementById('ref-rzp-order').textContent = o.payment.razorpay_order_id || 'N/A';
                document.getElementById('ref-rzp-pay').textContent = o.payment.razorpay_payment_id;
            } else {
                gwDiv.classList.add('hidden');
            }
            
        } catch (err) {
            modalError.querySelector('span').textContent = err.message || 'Failed to load complete order details.';
            modalError.classList.remove('hidden');
        } finally {
            modalLoading.classList.add('hidden');
        }
    };
    
    function closeModal() {
        modal.classList.add('opacity-0');
        modalContent.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
    
    closeBtn.addEventListener('click', closeModal);
    
    // Search & Filter Listeners
    searchInput.addEventListener('input', renderOrders);
    statusFilter.addEventListener('change', renderOrders);
    paymentFilter.addEventListener('change', renderOrders);
    
    // Status Updates
    statusForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (!currentOrderId) return;
        
        const newStatus = document.getElementById('edit-order-status').value;
        const btnText = document.getElementById('save-status-text');
        const btnSpinner = document.getElementById('save-status-spinner');
        const submitBtn = document.getElementById('save-status-btn');
        
        submitBtn.disabled = true;
        btnText.textContent = 'Updating...';
        btnSpinner.classList.remove('hidden');
        
        try {
            await window.HBM_API.request(`/admin/orders/${currentOrderId}/status`, 'PUT', { status: newStatus });
            // Show brief success UI
            btnText.textContent = 'Updated!';
            btnText.classList.replace('text-white', 'text-green-400');
            setTimeout(() => {
                btnText.textContent = 'Update Status';
                btnText.classList.replace('text-green-400', 'text-white');
            }, 2000);
            
            fetchOrders(); // Refresh table in background
        } catch (err) {
            alert(err.message || "Failed to update order status");
        } finally {
            submitBtn.disabled = false;
            btnSpinner.classList.add('hidden');
        }
    });
    
    paymentForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (!currentOrderId) return;
        
        const newStatus = document.getElementById('edit-payment-status').value;
        const btnText = document.getElementById('save-payment-text');
        const btnSpinner = document.getElementById('save-payment-spinner');
        const submitBtn = document.getElementById('save-payment-btn');
        
        submitBtn.disabled = true;
        btnText.textContent = 'Updating...';
        btnSpinner.classList.remove('hidden');
        
        try {
            await window.HBM_API.request(`/admin/orders/${currentOrderId}/payment-status`, 'PUT', { status: newStatus });
            // Show brief success UI
            btnText.textContent = 'Updated!';
            btnText.classList.replace('text-gray-700', 'text-green-600');
            setTimeout(() => {
                btnText.textContent = 'Update Payment';
                btnText.classList.replace('text-green-600', 'text-gray-700');
            }, 2000);
            
            fetchOrders(); // Refresh table in background
        } catch (err) {
            alert(err.message || "Failed to update payment status");
        } finally {
            submitBtn.disabled = false;
            btnSpinner.classList.add('hidden');
        }
    });

    fetchOrders();
});
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
