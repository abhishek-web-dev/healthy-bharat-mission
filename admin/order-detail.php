<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <a href="orders.php" class="text-gray-400 hover:text-[#106e39] transition-colors"><i class="fa-solid fa-arrow-left"></i></a>
            <h2 class="text-2xl font-bold text-gray-800">Order Details</h2>
        </div>
        <p class="text-sm text-gray-500 mt-1 font-mono" id="page-order-number">Loading...</p>
    </div>
</div>

<!-- Loading Overlay -->
<div id="page-loading" class="py-12 text-center text-gray-400">
    <i class="fa-solid fa-circle-notch fa-spin text-3xl mb-3 text-[#106e39]"></i>
    <p class="font-medium text-gray-500">Fetching complete order details...</p>
</div>

<div id="page-error" class="hidden py-12 text-center">
    <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center mx-auto text-red-500 text-xl mb-3">
        <i class="fa-solid fa-triangle-exclamation"></i>
    </div>
    <h3 class="font-bold text-gray-800 text-lg mb-1">Unable to load order</h3>
    <p class="text-sm text-gray-500 mb-4" id="page-error-msg">The order could not be found.</p>
    <a href="orders.php" class="text-sm font-bold text-[#106e39] hover:underline">Back to Orders</a>
</div>

<div id="page-content" class="hidden grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Items and Customer Info -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Order Items -->
        <div class="border border-gray-100 rounded-xl overflow-hidden bg-white shadow-sm">
            <div class="bg-gray-50 px-4 py-3 border-b border-gray-100">
                <h4 class="font-bold text-gray-700 uppercase tracking-wider text-xs">Ordered Items</h4>
            </div>
            <div class="p-0">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-xs uppercase tracking-wider text-gray-400 border-b border-gray-50">
                            <th class="px-4 py-3 font-bold">Product</th>
                            <th class="px-4 py-3 font-bold text-right">Price</th>
                            <th class="px-4 py-3 font-bold text-right">Qty</th>
                            <th class="px-4 py-3 font-bold text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm" id="page-order-items">
                        <!-- Items Injected by JS -->
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Customer Info Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Shipping Address -->
            <div class="border border-gray-100 rounded-xl overflow-hidden flex flex-col bg-white shadow-sm">
                <div class="bg-gray-50 px-4 py-3 border-b border-gray-100">
                    <h4 class="font-bold text-gray-700 uppercase tracking-wider text-xs">Shipping Information</h4>
                </div>
                <div class="p-4 text-sm text-gray-600 flex-1">
                    <p class="font-bold text-gray-800 mb-1" id="page-cust-name"></p>
                    <p id="page-cust-phone" class="mb-2"><i class="fa-solid fa-phone text-gray-400 w-4"></i> <span></span></p>
                    <p id="page-cust-email" class="mb-3 hidden"><i class="fa-solid fa-envelope text-gray-400 w-4"></i> <span></span></p>
                    
                    <div class="text-gray-500 pt-3 border-t border-gray-50">
                        <p id="page-cust-address1"></p>
                        <p id="page-cust-address2"></p>
                        <p><span id="page-cust-city"></span>, <span id="page-cust-state"></span></p>
                        <p id="page-cust-pincode" class="font-mono mt-1"></p>
                        <p id="page-cust-landmark" class="text-xs italic mt-1"></p>
                    </div>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="border border-gray-100 rounded-xl overflow-hidden flex flex-col bg-white shadow-sm">
                <div class="bg-gray-50 px-4 py-3 border-b border-gray-100">
                    <h4 class="font-bold text-gray-700 uppercase tracking-wider text-xs">Order Summary</h4>
                </div>
                <div class="p-4 text-sm">
                    <div class="flex justify-between py-1.5 text-gray-500">
                        <span>Subtotal</span>
                        <span id="page-subtotal" class="font-medium text-gray-700"></span>
                    </div>
                    <div id="page-discount-row" class="flex justify-between py-1.5 text-gray-500" style="display: none;">
                        <span>Discount / Offer</span>
                        <span id="page-discount" class="font-bold text-[#e85d04]"></span>
                    </div>
                    <div class="flex justify-between py-1.5 text-gray-500">
                        <span>Tax / Charges</span>
                        <span id="page-tax" class="font-medium text-gray-700"></span>
                    </div>
                    <div class="flex justify-between py-1.5 text-gray-500">
                        <span>Shipping Fee</span>
                        <span id="page-shipping-fee" class="font-medium text-gray-700"></span>
                    </div>
                    <div class="flex justify-between py-3 border-t border-gray-100 mt-2">
                        <span class="font-bold text-gray-800">Total Amount</span>
                        <span id="page-total" class="font-bold text-lg text-[#106e39]"></span>
                    </div>
                    <p class="text-xs text-gray-400 text-right mt-1">Method: <span id="page-payment-method" class="uppercase font-bold"></span></p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Right Column: Status Controls -->
    <div class="space-y-6">
        <form id="order-status-form" class="border border-gray-100 rounded-xl overflow-hidden shadow-sm bg-white">
            <div class="bg-gray-50 px-4 py-3 border-b border-gray-100">
                <h4 class="font-bold text-gray-700 uppercase tracking-wider text-xs flex items-center gap-2">
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
                <button type="submit" id="save-status-btn" class="w-full py-2.5 bg-[#106e39] text-white rounded-lg text-sm font-bold shadow hover:opacity-90 transition-opacity flex justify-center items-center gap-2">
                    <span id="save-status-text">Update Status</span>
                    <i id="save-status-spinner" class="fa-solid fa-spinner fa-spin hidden"></i>
                </button>
            </div>
        </form>
        
        <div id="payment-status-container" class="border border-gray-100 rounded-xl overflow-hidden shadow-sm bg-white">
            <div class="bg-gray-50 px-4 py-3 border-b border-gray-100">
                <h4 class="font-bold text-gray-700 uppercase tracking-wider text-xs flex items-center gap-2">
                    <i class="fa-solid fa-credit-card"></i> Payment Status
                </h4>
            </div>
            <div class="p-4 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Current Status</label>
                    <div id="display-payment-status" class="inline-flex px-3 py-1.5 rounded-md text-xs font-bold uppercase tracking-wider border bg-gray-50 text-gray-600 border-gray-200">
                        Loading...
                    </div>
                </div>
                
                <!-- Payment Gateway Reference (Safe Display) -->
                <div id="payment-gateway-ref" class="hidden mt-4 pt-4 border-t border-gray-100 text-xs">
                    <p class="font-bold text-gray-600 mb-1">Gateway Details</p>
                    <p class="text-gray-400 font-mono truncate" title="Razorpay Order ID">Rzp Ord: <span id="ref-rzp-order" class="text-gray-600"></span></p>
                    <p class="text-gray-400 font-mono truncate" title="Razorpay Payment ID">Rzp Pay: <span id="ref-rzp-pay" class="text-gray-600"></span></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>

<script src="../js/api.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const currentOrderId = urlParams.get('id');
    
    if (!currentOrderId) {
        document.getElementById('page-loading').classList.add('hidden');
        document.getElementById('page-error').classList.remove('hidden');
        return;
    }

    const pageLoading = document.getElementById('page-loading');
    const pageError = document.getElementById('page-error');
    const pageContent = document.getElementById('page-content');
    
    const statusForm = document.getElementById('order-status-form');
    
    function formatCurrency(amount) {
        return '₹' + parseFloat(amount).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    async function loadOrderDetails() {
        try {
            const res = await window.HBM_API.request(`/admin/orders/${currentOrderId}`);
            const o = res.data;
            
            if (!o) throw new Error("Order data missing");
            
            // Populate Header
            document.getElementById('page-order-number').textContent = o.order_number;
            
            // Populate Customer
            document.getElementById('page-cust-name').textContent = `${o.shipping_first_name || ''} ${o.shipping_last_name || ''}`.trim() || 'Unknown Customer';
            document.getElementById('page-cust-phone').querySelector('span').textContent = o.shipping_phone || 'N/A';
            
            if (o.shipping_email) {
                document.getElementById('page-cust-email').classList.remove('hidden');
                document.getElementById('page-cust-email').querySelector('span').textContent = o.shipping_email;
            } else {
                document.getElementById('page-cust-email').classList.add('hidden');
            }
            
            document.getElementById('page-cust-address1').textContent = o.shipping_address_line_1 || '';
            document.getElementById('page-cust-address2').textContent = o.shipping_address_line_2 || '';
            document.getElementById('page-cust-city').textContent = o.shipping_city || '';
            document.getElementById('page-cust-state').textContent = o.shipping_state || '';
            document.getElementById('page-cust-pincode').textContent = o.shipping_pincode || '';
            document.getElementById('page-cust-landmark').textContent = o.shipping_landmark ? `Landmark: ${o.shipping_landmark}` : '';
            
            // Populate Summary
            document.getElementById('page-subtotal').textContent = formatCurrency(o.subtotal);
            document.getElementById('page-shipping-fee').textContent = formatCurrency(o.shipping_fee);
            
            const expectedTotal = parseFloat(o.subtotal) + parseFloat(o.shipping_fee);
            const actualTotal = parseFloat(o.total_amount);
            
            let tax = 0;
            let discount = 0;
            const difference = actualTotal - expectedTotal;
            
            // Generic net calculation without hardcoded tax rates
            if (difference > 0.01) {
                tax = difference; // Net charge
            } else if (difference < -0.01) {
                discount = Math.abs(difference); // Net discount
            }
            
            if (discount > 0.01) {
                document.getElementById('page-discount-row').style.display = 'flex';
                document.getElementById('page-discount').textContent = '- ' + formatCurrency(discount);
            } else {
                document.getElementById('page-discount-row').style.display = 'none';
            }
            
            document.getElementById('page-tax').textContent = '+ ' + formatCurrency(tax);
            document.getElementById('page-total').textContent = formatCurrency(o.total_amount);
            document.getElementById('page-payment-method').textContent = o.payment_method || 'N/A';
            
            // Set Selects
            document.getElementById('edit-order-status').value = o.order_status || 'pending';
            
            // Set payment status badge
            const pStatus = (o.payment_status || 'pending').toLowerCase();
            const badge = document.getElementById('display-payment-status');
            badge.textContent = pStatus;
            
            badge.className = 'inline-flex px-3 py-1.5 rounded-md text-xs font-bold uppercase tracking-wider border';
            if (pStatus === 'success') {
                badge.classList.add('bg-green-50', 'text-green-700', 'border-green-200');
            } else if (pStatus === 'failed') {
                badge.classList.add('bg-red-50', 'text-red-700', 'border-red-200');
            } else {
                badge.classList.add('bg-gray-50', 'text-gray-600', 'border-gray-200');
            }
            
            // Enforce status transition UI
            const statusSelect = document.getElementById('edit-order-status');
            const currentStatus = o.order_status || 'pending';
            
            const allowedTransitions = {
                'pending': ['pending', 'processing', 'shipped', 'delivered', 'cancelled'],
                'processing': ['processing', 'shipped', 'delivered', 'cancelled'],
                'shipped': ['shipped', 'delivered', 'cancelled'],
                'delivered': ['delivered'],
                'cancelled': ['cancelled']
            };
            
            const allowed = allowedTransitions[currentStatus] || [currentStatus];
            
            Array.from(statusSelect.options).forEach(opt => {
                if (!allowed.includes(opt.value)) {
                    opt.disabled = true;
                    opt.classList.add('hidden'); // Hide impossible options
                } else {
                    opt.disabled = false;
                    opt.classList.remove('hidden');
                }
            });
            
            const saveStatusBtn = document.getElementById('save-status-btn');
            // If the state is terminal, disable the save button entirely
            if (currentStatus === 'delivered' || currentStatus === 'cancelled') {
                statusSelect.disabled = true;
                saveStatusBtn.disabled = true;
                saveStatusBtn.classList.add('opacity-50', 'cursor-not-allowed');
                document.getElementById('save-status-text').textContent = 'Terminal State';
            } else {
                statusSelect.disabled = false;
                saveStatusBtn.disabled = false;
                saveStatusBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                document.getElementById('save-status-text').textContent = 'Update Status';
            }
            
            // Populate Items
            const itemsTbody = document.getElementById('page-order-items');
            if (o.items && o.items.length > 0) {
                itemsTbody.innerHTML = o.items.map(item => {
                    const total = item.price_snapshot * item.quantity;
                    return `
                        <tr>
                            <td class="px-4 py-3 border-b border-gray-50">
                                <p class="font-bold text-gray-800 line-clamp-2" title="${item.product_name_snapshot}">${item.product_name_snapshot}</p>
                                <p class="text-[10px] text-gray-400 font-mono mt-0.5">Prod ID: ${item.product_id}</p>
                            </td>
                            <td class="px-4 py-3 border-b border-gray-50 text-right text-gray-600 font-medium">${formatCurrency(item.price_snapshot)}</td>
                            <td class="px-4 py-3 border-b border-gray-50 text-right font-bold text-gray-800">x${item.quantity}</td>
                            <td class="px-4 py-3 border-b border-gray-50 text-right font-bold text-[#106e39]">${formatCurrency(total)}</td>
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
            
            pageLoading.classList.add('hidden');
            pageContent.classList.remove('hidden');
            
        } catch (err) {
            document.getElementById('page-error-msg').textContent = err.message || 'Failed to load complete order details.';
            pageLoading.classList.add('hidden');
            pageError.classList.remove('hidden');
        }
    }
    
    // Status Updates
    statusForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
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
        } catch (err) {
            alert(err.message || "Failed to update order status");
        } finally {
            if (newStatus !== 'delivered' && newStatus !== 'cancelled') {
                submitBtn.disabled = false;
            }
            btnSpinner.classList.add('hidden');
            
            // Reload page to reflect new state restrictions if successful
            if (btnText.textContent === 'Updated!') {
                setTimeout(() => window.location.reload(), 500);
            }
        }
    });



    // Initial Load
    loadOrderDetails();
});
</script>
