document.addEventListener('DOMContentLoaded', () => {
    // Check authentication on all checkout pages
    if (!HBM_API.getToken()) {
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

    async function fetchAndRenderCartSummary() {
        try {
            const res = await HBM_API.request('/cart');
            if (res.success && res.data) {
                const cart = res.data;
                const container = document.getElementById('checkout-order-summary-items');
                if (container) {
                    if (cart.items.length === 0) {
                        container.innerHTML = '<div class="text-center py-4 text-gray-500 text-[13px]">Your cart is empty.</div>';
                    } else {
                        container.innerHTML = cart.items.map(item => `
                            <div class="flex justify-between gap-4">
                                <div class="flex gap-4">
                                    <div class="w-16 h-16 rounded-xl border border-gray-200 bg-[#f4f6f8] p-1 flex items-center justify-center flex-shrink-0">
                                        ${item.primary_image || item.thumbnail_url 
                                            ? `<img src="${item.primary_image || item.thumbnail_url}" class="max-w-full max-h-full object-contain mix-blend-multiply" alt="${item.name}" onerror="this.parentElement.innerHTML='<i class=\\'fa-regular fa-image text-2xl text-gray-300\\'></i>'">`
                                            : `<i class="fa-regular fa-image text-2xl text-gray-300"></i>`
                                        }
                                    </div>
                                    <div>
                                        <h3 class="text-[#1e293b] font-bold text-[13px] leading-tight mb-1 max-w-[150px]">${item.name}</h3>
                                    </div>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <div class="text-[#106e39] font-black text-[15px]">₹${(item.price * item.quantity).toFixed(2)}</div>
                                    <div class="text-gray-500 text-[13px] font-medium mt-1">Qty: ${item.quantity}</div>
                                </div>
                            </div>
                        `).join('');
                    }
                }

                // Update totals
                const subEl = document.getElementById('checkout-subtotal');
                const subLblEl = document.getElementById('checkout-subtotal-label');
                const totEl = document.getElementById('checkout-total');
                const discRow = document.getElementById('checkout-discount-row');
                const discEl = document.getElementById('checkout-discount');
                const savContainer = document.getElementById('checkout-savings');
                const savText = document.getElementById('checkout-savings-text');

                if (subLblEl) subLblEl.innerText = `Subtotal (${cart.total_items} items)`;
                if (subEl) subEl.innerText = `₹${(cart.subtotal || 0).toFixed(2)}`;
                
                // Get discount if any from window state (if passed) or localstorage
                const discount = window.currentDiscount || parseFloat(sessionStorage.getItem('hbm_discount')) || 0;

                // Calculate Shipping
                let shipping = 0;
                const shippingEl = document.getElementById('checkout-shipping');
                if (cart.subtotal > 0 && (cart.subtotal - discount) < 499) {
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
                const taxableAmount = Math.max(0, cart.subtotal - discount);
                const tax = taxableAmount * 0.05;
                const taxEl = document.getElementById('checkout-tax');
                if (taxEl) taxEl.innerText = `₹${tax.toFixed(2)}`;

                const total = taxableAmount + shipping + tax;

                if (totEl) totEl.innerText = `₹${total.toFixed(2)}`;

                if (discount > 0) {
                    if (discRow) discRow.classList.remove('hidden');
                    if (discEl) discEl.innerText = `-₹${discount.toFixed(2)}`;
                    if (savContainer) savContainer.classList.remove('hidden');
                    if (savContainer) savContainer.classList.add('flex');
                    if (savText) savText.innerText = `You save ₹${discount.toFixed(2)} on this order!`;
                } else {
                    if (discRow) discRow.classList.add('hidden');
                    if (savContainer) savContainer.classList.add('hidden');
                    if (savContainer) savContainer.classList.remove('flex');
                }
            }
        } catch (e) {
            console.error("Failed to load cart summary", e);
        }
    }

    async function initAddressPage() {
        // Render Cart Summary First
        fetchAndRenderCartSummary();

        let useSavedAddressId = null;
        let editAddressId = null;
        let addressDataCache = []; // Store fetched addresses for editing

        const savedContainer = document.getElementById('saved-addresses-container');
        const formContainer = document.getElementById('new-address-form-container');
        const btnAddNew = document.getElementById('btn-add-new-address');
        const addAddressHeader = document.getElementById('add-address-header');
        
        try {
            const addrsRes = await HBM_API.checkout.getAddresses();
            if (addrsRes.success && addrsRes.data && addrsRes.data.length > 0) {
                addressDataCache = addrsRes.data;
                savedContainer.classList.remove('hidden');
                formContainer.classList.add('hidden');
                if (addAddressHeader) addAddressHeader.classList.remove('hidden');
                
                // Do not select any address by default
                useSavedAddressId = null;
                
                const cardsContent = addrsRes.data.map(addr => `
                    <div class="relative group">
                        <label class="cursor-pointer w-full h-full block">
                            <input type="radio" name="saved_address" value="${addr.id}" class="peer hidden">
                            <div class="address-card-inner h-full border border-gray-200 rounded-xl p-4 transition-all hover:border-[#106e39] bg-white">
                                <div class="flex items-center gap-3 mb-2 pr-10">
                                    <span class="font-bold text-[#1e293b] truncate">${addr.first_name} ${addr.last_name}</span>
                                    <span class="bg-white border border-gray-200 shadow-sm text-gray-600 text-[10px] px-2 py-0.5 rounded font-bold uppercase tracking-wide">${addr.type || 'Home'}</span>
                                </div>
                                <p class="text-[13px] text-gray-600 leading-relaxed">${addr.address_line_1}${addr.address_line_2 ? ', ' + addr.address_line_2 : ''}</p>
                                <p class="text-[13px] text-gray-600 leading-relaxed">${addr.city}, ${addr.state} - ${addr.pincode}</p>
                                <p class="text-[13px] text-gray-600 mt-2 font-medium"><i class="fa-solid fa-phone text-[11px]"></i> +91 ${addr.phone}</p>
                            </div>
                        </label>
                        <button class="btn-edit-address absolute top-3 right-12 w-8 h-8 flex items-center justify-center rounded-lg text-[#106e39] bg-white hover:bg-[#f0fbf4] hover:text-[#0a4d27] transition-colors z-10 shadow-sm border border-[#e2f6e9]" data-id="${addr.id}" title="Edit Address">
                            <i class="fa-solid fa-pencil text-[12px] pointer-events-none"></i>
                        </button>
                        <button class="btn-delete-address absolute top-3 right-3 w-8 h-8 flex items-center justify-center rounded-lg text-red-500 bg-white hover:bg-red-50 hover:text-red-600 transition-colors z-10 shadow-sm border border-red-100" data-id="${addr.id}" title="Delete Address">
                            <i class="fa-regular fa-trash-can text-[13px] pointer-events-none"></i>
                        </button>
                    </div>
                `).join('');
                
                const addrsHtml = `<div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">${cardsContent}</div>`;
                
                // Insert cards inside the container, replacing old content
                savedContainer.innerHTML = addrsHtml;
                
                // Add listener to radio buttons
                const radioBtns = savedContainer.querySelectorAll('input[type="radio"]');
                radioBtns.forEach(rb => {
                    rb.addEventListener('change', (e) => {
                        useSavedAddressId = parseInt(e.target.value);
                        formContainer.classList.add('hidden'); // Hide form if it was open
                        
                        // Explicitly handle class toggling for highlighting
                        document.querySelectorAll('.address-card-inner').forEach(card => {
                            card.classList.remove('border-2', 'border-[#106e39]', 'bg-[#f0fbf4]');
                            card.classList.add('border', 'border-gray-200', 'bg-white');
                        });
                        
                        const selectedCard = e.target.closest('label').querySelector('.address-card-inner');
                        if (selectedCard) {
                            selectedCard.classList.remove('border', 'border-gray-200', 'bg-white');
                            selectedCard.classList.add('border-2', 'border-[#106e39]', 'bg-[#f0fbf4]');
                        }
                    });
                });

                // Add listener for delete buttons
                const deleteModal = document.getElementById('delete-address-modal');
                const deleteModalContent = document.getElementById('delete-modal-content');
                let addressToDelete = null;

                const deleteBtns = savedContainer.querySelectorAll('.btn-delete-address');
                deleteBtns.forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        addressToDelete = btn.getAttribute('data-id');
                        deleteModal.classList.remove('hidden');
                        setTimeout(() => deleteModalContent.classList.remove('scale-95', 'opacity-0'), 10);
                    });
                });

                document.getElementById('btn-cancel-delete')?.addEventListener('click', () => {
                    deleteModalContent.classList.add('scale-95', 'opacity-0');
                    setTimeout(() => deleteModal.classList.add('hidden'), 200);
                    addressToDelete = null;
                });

                document.getElementById('btn-confirm-delete')?.addEventListener('click', async () => {
                    if (addressToDelete) {
                        try {
                            const res = await HBM_API.checkout.deleteAddress(addressToDelete);
                            if (res.success) {
                                if (window.showNotification) {
                                    window.showNotification('Address deleted successfully.', 'success');
                                }
                                setTimeout(() => window.location.reload(), 1000);
                            }
                        } catch (error) {
                            console.error('Failed to delete address', error);
                        }
                    }
                });

                // Add listener for edit buttons
                const editBtns = savedContainer.querySelectorAll('.btn-edit-address');
                editBtns.forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        const id = parseInt(btn.getAttribute('data-id'));
                        const addr = addressDataCache.find(a => a.id === id);
                        if (addr) {
                            editAddressId = id;
                            document.getElementById('checkout-name').value = `${addr.first_name} ${addr.last_name}`;
                            document.getElementById('checkout-phone').value = addr.phone;
                            document.getElementById('checkout-pincode').value = addr.pincode;
                            document.getElementById('checkout-address1').value = addr.address_line_1;
                            document.getElementById('checkout-address2').value = addr.address_line_2 || '';
                            document.getElementById('checkout-landmark').value = addr.landmark || '';
                            document.getElementById('checkout-city').value = addr.city;
                            document.getElementById('checkout-state').value = addr.state;
                            
                            formContainer.classList.remove('hidden');
                            useSavedAddressId = null;
                            const radioBtns = savedContainer.querySelectorAll('input[type="radio"]');
                            radioBtns.forEach(rb => rb.checked = false);

                            const submitBtnText = document.querySelector('#btn-submit-address .submit-text');
                            if (submitBtnText) submitBtnText.innerText = 'Update Address';
                            
                            // Scroll to form
                            formContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    });
                });
                
            } else {
                // No saved addresses, force form
                savedContainer.classList.add('hidden');
                if (addAddressHeader) addAddressHeader.classList.add('hidden');
                formContainer.classList.remove('hidden');
            }
        } catch(e) {
            console.error("Error fetching addresses:", e);
            formContainer.classList.remove('hidden');
        }

        if (btnAddNew) {
            btnAddNew.addEventListener('click', (e) => {
                e.preventDefault();
                formContainer.classList.remove('hidden');
                useSavedAddressId = null; // Unset saved address selection
                editAddressId = null; // Unset edit mode
                
                // Clear form inputs
                document.getElementById('checkout-name').value = '';
                document.getElementById('checkout-phone').value = '';
                document.getElementById('checkout-pincode').value = '';
                document.getElementById('checkout-address1').value = '';
                document.getElementById('checkout-address2').value = '';
                document.getElementById('checkout-landmark').value = '';
                document.getElementById('checkout-city').value = '';
                document.getElementById('checkout-state').value = '';

                const radioBtns = savedContainer.querySelectorAll('input[type="radio"]');
                radioBtns.forEach(rb => rb.checked = false);
            });
        }

        // Pincode API integration
        const pincodeInput = document.getElementById('checkout-pincode');
        const checkBtn = document.getElementById('checkout-btn-pincode');
        const pincodeMsg = document.getElementById('pincode-message');
        const cityInput = document.getElementById('checkout-city');
        const stateInput = document.getElementById('checkout-state');

        const fetchPincode = async () => {
            const pin = pincodeInput.value.trim();
            if (pin.length !== 6 || isNaN(pin)) {
                pincodeMsg.innerText = 'Please enter a valid 6-digit pincode';
                pincodeMsg.className = 'text-[12px] font-bold mt-1 text-red-500';
                return;
            }

            try {
                checkBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i>';
                const response = await fetch(`https://api.postalpincode.in/pincode/${pin}`);
                const data = await response.json();

                if (data && data[0].Status === 'Success' && data[0].PostOffice && data[0].PostOffice.length > 0) {
                    const po = data[0].PostOffice[0];
                    cityInput.value = po.District || po.Block;
                    stateInput.value = po.State;
                    
                    pincodeMsg.innerText = 'Serviceable area!';
                    pincodeMsg.className = 'text-[12px] font-bold mt-1 text-[#106e39]';
                    
                    // Trigger validation state update manually
                    cityInput.dispatchEvent(new Event('input'));
                    stateInput.dispatchEvent(new Event('input'));
                } else {
                    pincodeMsg.innerText = 'Invalid pincode or not serviceable';
                    pincodeMsg.className = 'text-[12px] font-bold mt-1 text-red-500';
                    cityInput.value = '';
                    stateInput.value = '';
                    cityInput.dispatchEvent(new Event('input'));
                    stateInput.dispatchEvent(new Event('input'));
                }
            } catch (e) {
                pincodeMsg.innerText = 'Error checking pincode';
                pincodeMsg.className = 'text-[12px] font-bold mt-1 text-red-500';
            } finally {
                checkBtn.innerText = 'Check';
            }
        };

        if (checkBtn) {
            checkBtn.addEventListener('click', fetchPincode);
        }
        
        if (pincodeInput) {
            pincodeInput.addEventListener('input', (e) => {
                if (e.target.value.length === 6) {
                    fetchPincode();
                } else {
                    pincodeMsg.innerText = '';
                }
            });
        }

        // Form Validation and Submit
        const continueBtn = Array.from(document.querySelectorAll('a, button')).find(el => el.textContent.includes('Pay Now'));
        
        // Get inputs
        const nameEl = document.getElementById('checkout-name');
        const phoneEl = document.getElementById('checkout-phone');
        const address1El = document.getElementById('checkout-address1');
        const address2El = document.getElementById('checkout-address2');
        const cityEl = document.getElementById('checkout-city');
        const stateEl = document.getElementById('checkout-state');
        const landmarkEl = document.getElementById('checkout-landmark');

        if (continueBtn) {
            continueBtn.addEventListener('click', async (e) => {
                e.preventDefault();
                
                // If form is hidden, they are in "Select Address" mode
                if (formContainer && formContainer.classList.contains('hidden')) {
                    if (!useSavedAddressId) {
                        if (typeof window.showNotification === 'function') {
                            window.showNotification('Please select a delivery address to continue.', 'error');
                        } else {
                            alert('Please select a delivery address to continue.');
                        }
                        return;
                    }
                    
                    // Bypass form and use the saved address directly
                    try {
                        const originalText = continueBtn.innerHTML;
                        continueBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Saving...';
                        continueBtn.style.pointerEvents = 'none';
                        
                        const selectedAddr = addressDataCache.find(a => a.id == useSavedAddressId);
                        
                        checkoutState.address_id = useSavedAddressId;
                        if (selectedAddr) {
                            checkoutState.address_snapshot = selectedAddr;
                        }
                        
                        localStorage.setItem('hbm_checkout_state', JSON.stringify(checkoutState));
                        
                        await processOrderAndLaunchPayment(useSavedAddressId, selectedAddr, continueBtn);
                    } catch (e) {
                        console.error("Error proceeding with saved address", e);
                        alert("Error proceeding with saved address");
                        continueBtn.innerHTML = 'Pay Now <i class="fa-solid fa-arrow-right"></i>';
                        continueBtn.style.pointerEvents = 'auto';
                    }
                    return;
                }

                // Helper to process order and launch payment
                async function processOrderAndLaunchPayment(addressId, addressSnapshot, btn) {
                    try {
                        btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Creating Order...';
                        btn.style.pointerEvents = 'none';
                        
                        const orderPayload = {
                            address_id: addressId,
                            payment_method: 'card', // the backend expects upi, card, net_banking, or cod
                            discount: parseFloat(sessionStorage.getItem('hbm_discount') || 0)
                        };

                        const response = await HBM_API.checkout.createOrder(orderPayload);
                        
                        if (response.success) {
                            const order = response.data;
                            checkoutState.last_order = order;
                            localStorage.setItem('hbm_checkout_state', JSON.stringify(checkoutState));

                            // Launch Razorpay
                            btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Awaiting Payment...';
                            const options = {
                                key: "rzp_test_Smv6k8a60175SA",
                                amount: order.total_amount * 100, // Amount is in paise
                                currency: "INR",
                                name: "Healthy Bharat Mission",
                                description: "Order #" + order.order_number,
                                order_id: order.razorpay_order_id,
                                handler: async function (paymentResponse) {
                                    try {
                                        btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Verifying Payment...';
                                        const verifyRes = await HBM_API.checkout.verifyPayment({
                                            order_id: order.order_id,
                                            razorpay_payment_id: paymentResponse.razorpay_payment_id,
                                            razorpay_order_id: paymentResponse.razorpay_order_id,
                                            razorpay_signature: paymentResponse.razorpay_signature,
                                            status: 'captured'
                                        });
                                        if (verifyRes.success) {
                                            window.location.href = 'order-confirmation.html';
                                        } else {
                                            alert("Payment verification failed. Please contact support.");
                                            btn.innerHTML = 'Pay Now <i class="fa-solid fa-arrow-right"></i>';
                                            btn.style.pointerEvents = 'auto';
                                        }
                                    } catch (err) {
                                        console.error(err);
                                        alert("Error verifying payment.");
                                        btn.innerHTML = 'Continue to Payment <i class="fa-solid fa-arrow-right"></i>';
                                        btn.style.pointerEvents = 'auto';
                                    }
                                },
                                prefill: {
                                    name: addressSnapshot.first_name + ' ' + addressSnapshot.last_name,
                                    email: addressSnapshot.email || "",
                                    contact: addressSnapshot.phone
                                },
                                theme: {
                                    color: "#106e39"
                                },
                                modal: {
                                    ondismiss: function() {
                                        btn.innerHTML = 'Pay Now <i class="fa-solid fa-arrow-right"></i>';
                                        btn.style.pointerEvents = 'auto';
                                    }
                                }
                            };
                            
                            const rzp1 = new window.Razorpay(options);
                            rzp1.open();
                        } else {
                            alert(response.message || 'Failed to place order.');
                            btn.innerHTML = 'Continue to Payment <i class="fa-solid fa-arrow-right"></i>';
                            btn.style.pointerEvents = 'auto';
                        }
                    } catch (error) {
                        console.error('Order creation error:', error);
                        alert('An error occurred during checkout.');
                        btn.innerHTML = 'Continue to Payment <i class="fa-solid fa-arrow-right"></i>';
                        btn.style.pointerEvents = 'auto';
                    }
                }

                // Advanced validation helper
                let isValid = true;
                const errors = [];
                const validateField = (el, rules, fieldName) => {
                    if (!el) return;
                    let fieldValid = true;
                    let errorMsg = null;
                    const val = el.value.trim();

                    for (const rule of rules) {
                        if (!rule.test(val)) {
                            fieldValid = false;
                            errorMsg = rule.message;
                            break;
                        }
                    }

                    if (!fieldValid) {
                        el.classList.add('border-red-500', 'ring-red-500');
                        isValid = false;
                        errors.push(errorMsg || `${fieldName} is invalid`);
                    } else {
                        el.classList.remove('border-red-500', 'ring-red-500');
                    }
                };

                const isNotEmpty = { test: (v) => v.length > 0, message: "Please fill in all required fields." };
                const isLettersOnly = { test: (v) => /^[a-zA-Z\s.-]+$/.test(v), message: "Must not contain numbers or special characters." };
                const isTenDigits = { test: (v) => v.length === 10 && !isNaN(v), message: "Must be a valid 10-digit number." };
                const isSixDigits = { test: (v) => v.length === 6 && !isNaN(v), message: "Must be a valid 6-digit number." };

                validateField(nameEl, [isNotEmpty, { ...isLettersOnly, message: "Full Name must not contain numbers." }], 'Full Name');
                validateField(phoneEl, [isNotEmpty, { ...isTenDigits, message: "Phone Number must be 10 digits." }], 'Phone Number');
                validateField(pincodeInput, [isNotEmpty, { ...isSixDigits, message: "Pincode must be 6 digits." }], 'Pincode');
                validateField(address1El, [isNotEmpty], 'Address Line 1');
                validateField(cityEl, [isNotEmpty, { ...isLettersOnly, message: "City must not contain numbers." }], 'City');
                validateField(stateEl, [isNotEmpty, { ...isLettersOnly, message: "State must not contain numbers." }], 'State');

                if (!isValid) {
                    if (typeof window.showNotification === 'function') {
                        const uniqueErrors = [...new Set(errors)];
                        window.showNotification(uniqueErrors.join(' '), 'error');
                    } else {
                        alert(errors.join('\n'));
                    }
                    return;
                }

                const nameParts = nameEl.value.trim().split(' ');
                
                const addressData = {
                    first_name: nameParts[0],
                    last_name: nameParts.slice(1).join(' ') || '.',
                    phone: phoneEl.value.trim(),
                    pincode: pincodeInput.value.trim(),
                    address_line_1: address1El.value.trim(),
                    address_line_2: address2El ? address2El.value.trim() : '',
                    city: cityEl.value.trim(),
                    state: stateEl.value.trim(),
                    landmark: landmarkEl ? landmarkEl.value.trim() : '',
                    type: 'home'
                };

                try {
                    const originalText = continueBtn.innerHTML;
                    continueBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Saving...';
                    continueBtn.style.pointerEvents = 'none';

                    let response;
                    if (editAddressId) {
                        response = await HBM_API.checkout.updateAddress(editAddressId, addressData);
                    } else {
                        response = await HBM_API.checkout.saveAddress(addressData);
                    }
                    
                    if (response.success) {
                        checkoutState.address_id = response.data.id;
                        checkoutState.address_snapshot = response.data;
                        localStorage.setItem('hbm_checkout_state', JSON.stringify(checkoutState));
                        await processOrderAndLaunchPayment(response.data.id, response.data, continueBtn);
                    } else {
                        if (typeof window.showNotification === 'function') {
                            window.showNotification(response.message || 'Failed to save address', 'error');
                        } else {
                            alert(response.message || 'Failed to save address');
                        }
                    }
                } catch (error) {
                    console.error('Save address error:', error);
                    if (typeof window.showNotification === 'function') {
                        window.showNotification(error.message || 'An error occurred. Please try again.', 'error');
                    } else {
                        alert(error.message || 'An error occurred. Please try again.');
                    }
                } finally {
                    continueBtn.innerHTML = 'Continue to Payment <i class="fa-solid fa-arrow-right"></i>';
                    continueBtn.style.pointerEvents = 'auto';
                }
            });
        }
    }

    function initPaymentPage() {
        // Fetch and render the dynamic order summary
        fetchAndRenderCartSummary();

        // Find the continue button
        const continueBtn = Array.from(document.querySelectorAll('a, button')).find(el => el.textContent.includes('Continue to Review'));
        
        const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
        let selectedPayment = 'upi'; // default

        function updatePaymentCards() {
            document.querySelectorAll('.payment-method-card').forEach(card => {
                const radio = card.querySelector('input[type="radio"]');
                if (radio.checked) {
                    card.classList.add('border-2', 'border-[#106e39]', 'bg-[#f0fbf4]');
                    card.classList.remove('border', 'border-gray-200', 'bg-white');
                    selectedPayment = radio.value;
                } else {
                    card.classList.remove('border-2', 'border-[#106e39]', 'bg-[#f0fbf4]');
                    card.classList.add('border', 'border-gray-200', 'bg-white');
                }
            });
        }

        paymentRadios.forEach(radio => {
            radio.addEventListener('change', updatePaymentCards);
        });
        
        // Initial state
        updatePaymentCards();

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
                            // Launch Razorpay
                            const options = {
                                key: "rzp_test_Smv6k8a60175SA",
                                amount: order.total_amount * 100, // Amount is in paise
                                currency: "INR",
                                name: "Healthy Bharat Mission",
                                description: "Order #" + order.order_number,
                                order_id: order.razorpay_order_id,
                                handler: async function (paymentResponse) {
                                    try {
                                        placeOrderBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Verifying Payment...';
                                        const verifyRes = await HBM_API.checkout.verifyPayment({
                                            order_id: order.order_id,
                                            razorpay_payment_id: paymentResponse.razorpay_payment_id,
                                            razorpay_order_id: paymentResponse.razorpay_order_id,
                                            razorpay_signature: paymentResponse.razorpay_signature,
                                            status: 'captured'
                                        });
                                        if (verifyRes.success) {
                                            window.location.href = 'order-confirmation.html';
                                        } else {
                                            alert("Payment verification failed. Please contact support.");
                                            placeOrderBtn.innerHTML = 'Place Order <i class="fa-solid fa-arrow-right"></i>';
                                            placeOrderBtn.style.pointerEvents = 'auto';
                                        }
                                    } catch (err) {
                                        console.error(err);
                                        alert("Error verifying payment.");
                                        placeOrderBtn.innerHTML = 'Place Order <i class="fa-solid fa-arrow-right"></i>';
                                        placeOrderBtn.style.pointerEvents = 'auto';
                                    }
                                },
                                prefill: {
                                    name: checkoutState.address_snapshot.first_name + ' ' + checkoutState.address_snapshot.last_name,
                                    email: checkoutState.address_snapshot.email || "web.abhl.dev@gmail.com",
                                    contact: checkoutState.address_snapshot.phone || "9999999999",
                                    method: 'card'
                                },
                                theme: {
                                    color: "#106e39"
                                },
                                modal: {
                                    ondismiss: function() {
                                        placeOrderBtn.innerHTML = 'Place Order <i class="fa-solid fa-arrow-right"></i>';
                                        placeOrderBtn.style.pointerEvents = 'auto';
                                    }
                                }
                            };
                            
                            const rzp1 = new window.Razorpay(options);
                            rzp1.open();
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
        const address = checkoutState.address_snapshot;
        
        // --- 1. Order Number & Date ---
        const orderNumEl = document.getElementById('confirm-order-number');
        if (orderNumEl) orderNumEl.textContent = '#' + order.order_number;
        
        const orderDateEl = document.getElementById('confirm-order-date');
        if (orderDateEl) orderDateEl.textContent = new Date().toLocaleString('en-US', { dateStyle: 'medium', timeStyle: 'short' });

        // --- 2. Delivery Information ---
        if (address) {
            const nameEl = document.getElementById('confirm-delivery-name');
            if (nameEl) nameEl.textContent = `${address.first_name} ${address.last_name}`;

            const addrEl = document.getElementById('confirm-delivery-address');
            if (addrEl) {
                addrEl.innerHTML = `
                    ${address.address_line_1}<br>
                    ${address.address_line_2 ? address.address_line_2 + '<br>' : ''}
                    ${address.city}, ${address.state} - ${address.pincode}
                `;
            }

            const phoneEl = document.getElementById('confirm-delivery-phone');
            if (phoneEl) {
                phoneEl.innerHTML = `<i class="fa-solid fa-phone text-[10px] text-gray-400"></i> +91 ${address.phone}`;
            }
        }

        // --- 3. Items Ordered ---
        const itemsContainer = document.getElementById('confirm-items-container');
        
        // Fetch full order details from backend to get the items
        HBM_API.orders.getDetails(order.order_id).then(res => {
            if (res.success && res.data && res.data.items) {
                const items = res.data.items;
                
                if (itemsContainer) {
                    const h2 = itemsContainer.querySelector('h2');
                    if (h2) h2.textContent = `Items Ordered (${items.length})`;
                    
                    // Keep only H2
                    while (itemsContainer.lastChild && itemsContainer.lastChild !== h2) {
                        itemsContainer.removeChild(itemsContainer.lastChild);
                    }

                    items.forEach((item, idx) => {
                        const isLast = idx === items.length - 1;
                        const borderClass = isLast ? 'border-0 pb-0' : 'border-b border-gray-100 pb-5 mt-5';
                        
                        const html = `
                        <div class="flex flex-col sm:flex-row sm:items-center gap-6 py-5 ${borderClass} mt-2">
                            <div class="w-16 h-16 rounded-lg bg-[#f9fbf9] border border-gray-100 p-1 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                <img src="${item.image_url || item.thumbnail_url || ''}" class="w-full h-full object-contain mix-blend-multiply" alt="${item.product_name_snapshot || 'Product'}" onerror="this.outerHTML='<i class=\\'fa-regular fa-image text-gray-300 text-xl\\'></i>'">
                            </div>
                            
                            <div class="flex-1">
                                <h3 class="text-[#1e293b] font-bold text-[14px] leading-snug mb-1">${item.product_name_snapshot || 'Product'}</h3>
                                <div class="text-gray-400 text-[12px] font-medium">${item.category_name || 'Product'}</div>
                            </div>
                            
                            <div class="flex items-center justify-between sm:justify-end gap-12 w-full sm:w-auto mt-4 sm:mt-0">
                                <div class="text-[#1e293b] font-bold text-[13px]">Qty: ${item.quantity}</div>
                                <div class="text-[#106e39] font-black text-[15px] w-20 text-right">₹${(item.price_snapshot * item.quantity).toFixed(2)}</div>
                            </div>
                        </div>
                        `;
                        itemsContainer.insertAdjacentHTML('beforeend', html);
                    });
                    
                    // --- 4. Order Summary ---
                    // Calculate Totals based on items (or order object)
                    let subtotal = 0;
                    items.forEach(i => subtotal += ((i.price_snapshot || i.price || 0) * i.quantity));
                    if (subtotal === 0 && order.subtotal) subtotal = parseFloat(order.subtotal); // fallback

                    const discount = order.discount || parseFloat(sessionStorage.getItem('hbm_discount') || 0);
                    const taxableAmount = Math.max(0, subtotal - discount);
                    const shipping = taxableAmount < 499 && taxableAmount > 0 ? 59 : 0;
                    const tax = taxableAmount * 0.05;
                    const total = taxableAmount + shipping + tax;

                    const subtotalLabel = document.getElementById('confirm-subtotal-label');
                    if (subtotalLabel) subtotalLabel.textContent = `Subtotal (${items.length} items)`;

                    const subtotalEl = document.getElementById('confirm-subtotal');
                    if (subtotalEl) subtotalEl.textContent = `₹${subtotal.toFixed(2)}`;

                    const discountRow = document.getElementById('confirm-discount-row');
                    const discountEl = document.getElementById('confirm-discount');
                    if (discount > 0) {
                        if (discountRow) discountRow.classList.remove('hidden');
                        if (discountEl) discountEl.textContent = `- ₹${discount.toFixed(2)}`;
                    }

                    // Add Tax Row if not exists
                    let taxRow = document.getElementById('confirm-tax-row');
                    if (!taxRow && subtotalLabel) {
                        const newRow = document.createElement('div');
                        newRow.id = 'confirm-tax-row';
                        newRow.className = 'flex justify-between text-gray-500 font-medium';
                        newRow.innerHTML = `<span>Tax (5% GST)</span><span class="font-bold text-[#1e293b]" id="confirm-tax">₹${tax.toFixed(2)}</span>`;
                        subtotalLabel.parentElement.parentElement.insertBefore(newRow, subtotalLabel.parentElement.nextSibling);
                    } else if (taxRow) {
                        const taxEl = document.getElementById('confirm-tax');
                        if (taxEl) taxEl.textContent = `₹${tax.toFixed(2)}`;
                    }

                    const shippingEl = document.getElementById('confirm-shipping');
                    if (shippingEl) shippingEl.textContent = shipping === 0 ? 'Free' : `₹${shipping.toFixed(2)}`;

                    const totalEl = document.getElementById('confirm-total');
                    if (totalEl) totalEl.textContent = `₹${total.toFixed(2)}`;
                }
            }
        }).catch(err => console.error("Could not fetch order items", err));

        // Clear cart globally after successful order
        localStorage.removeItem('hbm_cart');
        sessionStorage.removeItem('hbm_discount');
        
        // Optional: you can clear checkout state if you no longer need it.
        // localStorage.removeItem('hbm_checkout_state');
    }
});
