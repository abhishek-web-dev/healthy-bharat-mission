document.addEventListener('DOMContentLoaded', async () => {
    const loadingState = document.getElementById('loading-state');
    const errorState = document.getElementById('error-state');
    const contentState = document.getElementById('content-state');
    
    // Get Order ID from URL
    const urlParams = new URLSearchParams(window.location.search);
    const orderId = urlParams.get('id');

    if (!orderId) {
        showError();
        return;
    }

    try {
        const response = await HBM_API.request(`/orders/${orderId}`);
        
        if (response.success && response.data) {
            renderOrderDetails(response.data);
        } else {
            showError();
        }
    } catch (error) {
        console.error('Failed to load order details:', error);
        showError();
    }

    function renderOrderDetails(order) {
        loadingState.classList.add('hidden');
        contentState.classList.remove('hidden');

        // Format Date
        const dateObj = new Date(order.created_at);
        const formattedDate = dateObj.toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
        
        // Format Money
        const formatMoney = (amount) => '₹' + parseFloat(amount).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        
        // Format Order Number
        const orderNumberDisplay = order.order_number.toString().startsWith('HBM') ? order.order_number : `HBM${order.order_number}`;

        // Populate Summary Fields
        document.getElementById('detail-order-id').textContent = '#' + orderNumberDisplay;
        document.getElementById('detail-order-date').textContent = formattedDate;
        
        // Order Status Badge
        let statusClass = order.order_status.toLowerCase();
        let statusBadge = '';
        if (statusClass === 'delivered') {
            statusBadge = `<span class="bg-[#f2faf5] text-[#106e39] text-[11px] font-bold px-3 py-1 rounded-md">Delivered</span>`;
        } else if (statusClass === 'processing' || statusClass === 'shipped') {
            statusBadge = `<span class="bg-[#f0f6fc] text-blue-600 text-[11px] font-bold px-3 py-1 rounded-md capitalize">${statusClass}</span>`;
        } else if (statusClass === 'cancelled') {
            statusBadge = `<span class="bg-[#fff5f5] text-red-500 text-[11px] font-bold px-3 py-1 rounded-md">Cancelled</span>`;
        } else {
            statusBadge = `<span class="bg-gray-100 text-gray-600 text-[11px] font-bold px-3 py-1 rounded-md capitalize">${statusClass}</span>`;
        }
        document.getElementById('detail-order-status').innerHTML = statusBadge;
        
        document.getElementById('detail-total-amount').textContent = formatMoney(order.total_amount);
        
        let paymentMethod = 'Online';
        if (order.payment && order.payment.payment_method) {
            paymentMethod = order.payment.payment_method;
        } else if (order.payment_method) {
            paymentMethod = order.payment_method;
        }
        
        document.getElementById('detail-payment-method').textContent = paymentMethod;
        document.getElementById('detail-payment-method-bottom').textContent = paymentMethod;
        
        // Payment Status Badge
        let paymentClass = (order.payment_status || (order.payment && order.payment.status) || 'pending').toLowerCase();
        let paymentBadge = '';
        if (paymentClass === 'completed' || paymentClass === 'paid' || paymentClass === 'captured' || paymentClass === 'success') {
            paymentBadge = `<span class="text-[#106e39] font-bold text-[12px]"><i class="fa-solid fa-circle-check mr-1"></i>Paid</span>`;
        } else if (paymentClass === 'failed') {
            paymentBadge = `<span class="text-red-500 font-bold text-[12px]"><i class="fa-solid fa-circle-xmark mr-1"></i>Failed</span>`;
        } else {
            paymentBadge = `<span class="text-blue-600 font-bold text-[12px] capitalize"><i class="fa-solid fa-clock mr-1"></i>${paymentClass}</span>`;
        }
        document.getElementById('detail-payment-status').innerHTML = paymentBadge;
        
        let transactionId = 'N/A';
        if (order.payment && order.payment.razorpay_payment_id) {
            transactionId = order.payment.razorpay_payment_id;
        } else if (order.transaction_id) {
            transactionId = order.transaction_id;
        }
        document.getElementById('detail-transaction-id').textContent = transactionId;
        document.getElementById('detail-amount-paid').textContent = formatMoney(order.total_amount);

        // Shipping Address
        let addressHtml = 'Address not provided.';
        if (order.shipping_address_line_1 || order.shipping_first_name) {
            const name = [order.shipping_first_name, order.shipping_last_name].filter(Boolean).join(' ') || 'Customer';
            addressHtml = `
                <p class="font-bold text-gray-800 mb-1">${name}</p>
                <p>${order.shipping_address_line_1 || ''}</p>
                ${order.shipping_address_line_2 ? `<p>${order.shipping_address_line_2}</p>` : ''}
                <p>${order.shipping_city || ''}, ${order.shipping_state || ''} ${order.shipping_pincode || ''}</p>
                ${order.shipping_landmark ? `<p class="text-xs text-gray-500 mt-1">Landmark: ${order.shipping_landmark}</p>` : ''}
                <p class="mt-2 text-gray-500"><i class="fa-solid fa-phone mr-1.5 text-[11px]"></i> ${order.shipping_phone || 'N/A'}</p>
                ${order.shipping_email ? `<p class="text-gray-500"><i class="fa-solid fa-envelope mr-1.5 text-[11px]"></i> ${order.shipping_email}</p>` : ''}
            `;
        }
        document.getElementById('shipping-address').innerHTML = addressHtml;

        // Products List
        const productList = document.getElementById('product-list');
        if (order.items && order.items.length > 0) {
            let itemsHtml = '';
            order.items.forEach(item => {
                const img = item.image_url || '../assets/logo.webp';
                itemsHtml += `
                    <div class="flex items-start gap-4 pb-6 border-b border-gray-50 last:border-0 last:pb-0">
                        <div class="w-20 h-20 bg-gray-50 rounded-xl border border-gray-100 p-2 shrink-0 flex items-center justify-center">
                            <img src="${img}" alt="${item.product_name_snapshot}" class="w-full h-full object-contain" onerror="this.src='../assets/logo.webp'">
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-gray-800 text-[14px] mb-1 leading-snug">${item.product_name_snapshot}</h4>
                            <p class="text-[12px] text-gray-500 mb-2">Qty: <span class="font-bold text-gray-700">${item.quantity}</span></p>
                            <span class="font-bold text-[#052b14]">${formatMoney(item.price_snapshot)}</span>
                        </div>
                    </div>
                `;
            });
            productList.innerHTML = itemsHtml;
        } else {
            productList.innerHTML = '<p class="text-sm text-gray-500">No items found for this order.</p>';
        }
    }

    function showError() {
        loadingState.classList.add('hidden');
        contentState.classList.add('hidden');
        errorState.classList.remove('hidden');
    }
});
