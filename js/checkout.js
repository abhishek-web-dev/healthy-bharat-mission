document.addEventListener('DOMContentLoaded', () => {
    // Check authentication on all checkout pages
    if (!HBM_API.auth.getToken()) {
        localStorage.setItem('redirectUrl', window.location.pathname);
        window.location.href = '../auth/login.html';
        return;
    }

    const currentPath = window.location.pathname;

    // State management for checkout
    let checkoutState = JSON.parse(localStorage.getItem('hbm_checkout_state') || '{}');

    // ----------------------------------------------------
    // PAGE 1: Address (checkout.html)
    // ----------------------------------------------------
    if (currentPath.includes('checkout.html') && !currentPath.includes('payment') && !currentPath.includes('review')) {
        initAddressPage();
    }

    // ----------------------------------------------------
    // PAGE 2: Payment (checkout-payment.html)
    // ----------------------------------------------------
    if (currentPath.includes('checkout-payment.html')) {
        initPaymentPage();
    }

    // ----------------------------------------------------
    // PAGE 3: Review & Place Order (checkout-review.html)
    // ----------------------------------------------------
    if (currentPath.includes('checkout-review.html')) {
        initReviewPage();
    }

    // ----------------------------------------------------
    // PAGE 4: Order Confirmation (order-confirmation.html)
    // ----------------------------------------------------
    if (currentPath.includes('order-confirmation.html')) {
        initConfirmationPage();
    }

    // --- Helper Functions ---

    function initAddressPage() {
        const addressForm = document.querySelector('form') || document.querySelector('.w-full.lg\\:w-\\[65\\%\\]');
        // Let's bind an event listener to the "Continue to Payment" button.
        // We will just select the button that contains "Continue to Payment"
        const continueBtn = Array.from(document.querySelectorAll('a, button')).find(el => el.textContent.includes('Continue to Payment'));
        
        if (continueBtn) {
            continueBtn.addEventListener('click', async (e) => {
                e.preventDefault();
                // Simple validation for required fields
                const inputs = document.querySelectorAll('input[type="text"], input[type="tel"]');
                const addressData = {
                    first_name: inputs[0]?.value.split(' ')[0] || 'User',
                    last_name: inputs[0]?.value.split(' ').slice(1).join(' ') || 'Name',
                    phone: inputs[1]?.value || '9999999999',
                    pincode: inputs[2]?.value || '110001',
                    address_line_1: inputs[3]?.value || 'Test Address Line 1',
                    address_line_2: inputs[4]?.value || '',
                    city: inputs[5]?.value || 'Test City',
                    state: inputs[6]?.value || 'Test State',
                    landmark: inputs[7]?.value || '',
                    type: 'home'
                };

                try {
                    const originalText = continueBtn.innerHTML;
                    continueBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Saving...';
                    continueBtn.style.pointerEvents = 'none';

                    const response = await HBM_API.checkout.saveAddress(addressData);
                    if (response.success) {
                        checkoutState.address_id = response.data.id;
                        checkoutState.address_snapshot = response.data;
                        localStorage.setItem('hbm_checkout_state', JSON.stringify(checkoutState));
                        window.location.href = 'checkout-payment.html';
                    } else {
                        alert(response.message || 'Failed to save address');
                    }
                } catch (error) {
                    console.error('Save address error:', error);
                    alert('An error occurred. Please try again.');
                } finally {
                    continueBtn.innerHTML = 'Continue to Payment';
                    continueBtn.style.pointerEvents = 'auto';
                }
            });
        }
    }

    function initPaymentPage() {
        // Find the continue button
        const continueBtn = Array.from(document.querySelectorAll('a, button')).find(el => el.textContent.includes('Review Order'));
        
        // Listen for radio button changes
        const paymentRadios = document.querySelectorAll('input[type="radio"]');
        let selectedPayment = 'upi'; // default

        paymentRadios.forEach(radio => {
            radio.addEventListener('change', (e) => {
                if (e.target.id === 'payment-upi') selectedPayment = 'upi';
                else if (e.target.id === 'payment-card') selectedPayment = 'card';
                else if (e.target.id === 'payment-netbanking') selectedPayment = 'net_banking';
                else if (e.target.id === 'payment-cod') selectedPayment = 'cod';
            });
        });

        if (continueBtn) {
            continueBtn.addEventListener('click', (e) => {
                e.preventDefault();
                checkoutState.payment_method = selectedPayment;
                localStorage.setItem('hbm_checkout_state', JSON.stringify(checkoutState));
                window.location.href = 'checkout-review.html';
            });
        }
    }

    async function initReviewPage() {
        // Load cart items for review
        try {
            const cartResponse = await HBM_API.store.getCart();
            if (cartResponse.success && cartResponse.data.items.length > 0) {
                renderReviewItems(cartResponse.data.items);
                renderTotals(cartResponse.data.subtotal);
            } else {
                alert("Your cart is empty!");
                window.location.href = 'cart.html';
                return;
            }
        } catch (error) {
            console.error('Error loading cart for review:', error);
        }

        // Render Delivery Info from state
        if (checkoutState.address_snapshot) {
            renderDeliveryInfo(checkoutState.address_snapshot);
        } else {
            // Missing address
            window.location.href = 'checkout.html';
        }

        const placeOrderBtn = Array.from(document.querySelectorAll('a, button')).find(el => el.textContent.includes('Place Order'));
        
        if (placeOrderBtn) {
            placeOrderBtn.addEventListener('click', async (e) => {
                e.preventDefault();
                
                try {
                    const originalText = placeOrderBtn.innerHTML;
                    placeOrderBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Processing...';
                    placeOrderBtn.style.pointerEvents = 'none';

                    const orderPayload = {
                        address_id: checkoutState.address_id,
                        payment_method: checkoutState.payment_method || 'cod'
                    };

                    const response = await HBM_API.checkout.createOrder(orderPayload);
                    
                    if (response.success) {
                        const order = response.data;
                        checkoutState.last_order = order;
                        localStorage.setItem('hbm_checkout_state', JSON.stringify(checkoutState));

                        if (order.payment_method === 'cod') {
                            // Clear state and redirect to confirmation
                            window.location.href = 'order-confirmation.html';
                        } else {
                            // Mock Razorpay flow
                            await HBM_API.checkout.verifyPayment({
                                order_id: order.order_id,
                                razorpay_payment_id: 'pay_mock_' + Math.random().toString(36).substring(7),
                                razorpay_signature: 'mock_sig',
                                status: 'captured'
                            });
                            window.location.href = 'order-confirmation.html';
                        }
                    } else {
                        alert(response.message || 'Failed to place order.');
                        placeOrderBtn.innerHTML = 'Place Order';
                        placeOrderBtn.style.pointerEvents = 'auto';
                    }
                } catch (error) {
                    console.error('Order creation error:', error);
                    alert('An error occurred during checkout.');
                    placeOrderBtn.innerHTML = 'Place Order';
                    placeOrderBtn.style.pointerEvents = 'auto';
                }
            });
        }
    }

    function initConfirmationPage() {
        if (!checkoutState.last_order) {
            window.location.href = '../store.html';
            return;
        }

        const order = checkoutState.last_order;
        
        // Find elements to update
        const orderNumberEls = document.querySelectorAll('p.text-\\[\\#1e293b\\].font-bold.text-\\[15px\\]');
        if (orderNumberEls.length > 0) {
            orderNumberEls[0].textContent = '#' + order.order_number;
            orderNumberEls[1].textContent = new Date().toLocaleString('en-US', { dateStyle: 'medium', timeStyle: 'short' });
        }

        // Clear state after showing
        localStorage.removeItem('hbm_checkout_state');
    }

    function renderReviewItems(items) {
        // Let's target the review items container. 
        // We will clear existing hardcoded items and append new ones.
        const itemsContainer = document.querySelector('h2.text-\\[18px\\]').parentElement;
        if (!itemsContainer) return;

        // Clear existing siblings except the H2
        const h2 = itemsContainer.querySelector('h2');
        h2.textContent = `Items to Review (${items.length})`;
        
        // Keep only H2
        while (itemsContainer.lastChild && itemsContainer.lastChild !== h2) {
            itemsContainer.removeChild(itemsContainer.lastChild);
        }

        items.forEach((item, idx) => {
            const isLast = idx === items.length - 1;
            const borderClass = isLast ? 'border-0 pb-0' : 'border-b border-gray-100 pb-5';
            
            const html = `
            <div class="flex flex-col sm:flex-row sm:items-center gap-6 py-5 ${borderClass} mt-2">
                <img src="${item.thumbnail_url}" class="w-16 h-16 object-contain rounded-lg bg-[#f9fbf9] mix-blend-multiply border border-gray-100 p-1" alt="${item.name}">
                
                <div class="flex-1">
                    <h3 class="text-[#1e293b] font-bold text-[14px] leading-snug mb-1">${item.name}</h3>
                    <div class="text-gray-400 text-[12px] font-medium">${item.category_name || 'Product'}</div>
                </div>
                
                <div class="flex items-center justify-between sm:justify-end gap-12 w-full sm:w-auto mt-4 sm:mt-0">
                    <div class="text-[#1e293b] font-bold text-[13px]">Qty: ${item.quantity}</div>
                    <div class="text-[#106e39] font-black text-[15px] w-20 text-right">₹${(item.price * item.quantity).toFixed(2)}</div>
                </div>
            </div>
            `;
            itemsContainer.insertAdjacentHTML('beforeend', html);
        });
    }

    function renderTotals(subtotal) {
        subtotal = parseFloat(subtotal);
        const shipping = subtotal > 500 ? 0 : 50;
        const total = subtotal + shipping;

        // The review page has a right column with Order Summary
        const summaryContainer = Array.from(document.querySelectorAll('h3')).find(el => el.textContent.includes('Order Summary'))?.parentElement;
        
        if (summaryContainer) {
            const valueElements = summaryContainer.querySelectorAll('.font-bold.text-\\[\\#1e293b\\]');
            if (valueElements.length >= 3) {
                valueElements[1].textContent = `₹${subtotal.toFixed(2)}`; // Subtotal
                valueElements[2].textContent = shipping === 0 ? 'Free' : `₹${shipping.toFixed(2)}`; // Shipping
            }
            
            const totalElement = summaryContainer.querySelector('.text-\\[20px\\].font-black');
            if (totalElement) {
                totalElement.textContent = `₹${total.toFixed(2)}`;
            }
        }
    }

    function renderDeliveryInfo(address) {
        // Locate the Delivery Information block
        const deliveryHeader = Array.from(document.querySelectorAll('h3')).find(el => el.textContent.includes('Delivery Information'));
        if (deliveryHeader && deliveryHeader.parentElement) {
            const container = deliveryHeader.parentElement;
            
            const nameEl = container.querySelector('p.font-bold');
            if (nameEl) nameEl.textContent = `${address.first_name} ${address.last_name}`;
            
            const lines = container.querySelectorAll('p.text-gray-500');
            if (lines.length >= 2) {
                lines[0].innerHTML = `
                    ${address.address_line_1}<br>
                    ${address.address_line_2 ? address.address_line_2 + '<br>' : ''}
                    ${address.city}, ${address.state} - ${address.pincode}
                `;
                lines[1].innerHTML = `<i class="fa-solid fa-phone text-[10px] text-gray-400"></i> ${address.phone}`;
            }
        }
    }
});
