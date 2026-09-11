document.addEventListener('DOMContentLoaded', () => {
    
    // UI Helpers
    function showError(form, message) {
        let existing = form.querySelector('.auth-error');
        if (existing) existing.remove();
        let existingSuccess = form.querySelector('.auth-success');
        if (existingSuccess) existingSuccess.remove();

        const div = document.createElement('div');
        div.className = 'auth-error bg-red-50 text-red-600 p-3 rounded-xl mb-4 text-[13px] font-medium border border-red-100 flex items-start gap-2';
        div.innerHTML = `<i class="fa-solid fa-circle-exclamation mt-0.5"></i> <div>${message}</div>`;
        form.insertBefore(div, form.firstChild);
        div.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        setTimeout(() => {
            if (div.parentNode) div.remove();
        }, 5000);
    }

    function showSuccess(form, message) {
        let existingError = form.querySelector('.auth-error');
        if (existingError) existingError.remove();
        let existing = form.querySelector('.auth-success');
        if (existing) existing.remove();

        const div = document.createElement('div');
        div.className = 'auth-success bg-green-50 text-[#106e39] p-3 rounded-xl mb-4 text-[13px] font-medium border border-green-100 flex items-start gap-2';
        div.innerHTML = `<i class="fa-solid fa-circle-check mt-0.5"></i> <div>${message}</div>`;
        form.insertBefore(div, form.firstChild);

        setTimeout(() => {
            if (div.parentNode) div.remove();
        }, 5000);
    }

    function setLoading(button, isLoading) {
        if (isLoading) {
            button.dataset.originalText = button.innerHTML;
            button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing...';
            button.disabled = true;
            button.style.opacity = '0.7';
        } else {
            button.innerHTML = button.dataset.originalText || 'Submit';
            button.disabled = false;
            button.style.opacity = '1';
        }
    }

    // Identify which page we are on
    const path = window.location.pathname;
    const form = document.querySelector('form');

    // Password Eye Toggle
    document.querySelectorAll('input[type="password"]').forEach(input => {
        const wrapper = input.parentElement;
        const btn = wrapper.querySelector('button');
        if (btn) {
            btn.addEventListener('click', () => {
                const icon = btn.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    if (icon) {
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                        icon.classList.add('text-[#106e39]'); // highlight
                    }
                } else {
                    input.type = 'password';
                    if (icon) {
                        icon.classList.remove('fa-eye');
                        icon.classList.remove('text-[#106e39]');
                        icon.classList.add('fa-eye-slash');
                    }
                }
            });
        }
    });

    // Validation Helpers
    function isValidEmailDomain(email) {
        const validDomains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com', 'icloud.com'];
        const domain = email.split('@')[1];
        return validDomains.includes(domain?.toLowerCase());
    }

    function isValidPhone(phone) {
        // Indian phone numbers: exactly 10 digits, starting with 6, 7, 8, or 9
        return /^[6-9]\d{9}$/.test(phone);
    }

    function isValidName(name) {
        // Only alphabets, spaces, and hyphens allowed. Must be at least 2 characters.
        return /^[A-Za-z\s\-]{2,}$/.test(name);
    }

    if (form) {
        // Prevent default submit
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = form.querySelector('button[type="submit"]');

            if (path.includes('login')) {
                const email = form.querySelector('input[type="email"]').value;
                const password = form.querySelector('input[placeholder="Enter your password"]')?.value;
                
                if (!isValidEmailDomain(email)) {
                    showError(form, 'Please use a valid email domain (e.g. @gmail.com, @yahoo.com)');
                    return;
                }

                setLoading(btn, true);
                try {
                    const res = await HBM_API.request('/auth/login', 'POST', { email, password });
                    if (res.data && res.data.token) {
                        HBM_API.setToken(res.data.token);
                        showSuccess(form, 'Login successful! Redirecting...');
                        setTimeout(() => {
                            window.location.href = '../store.html'; // Assuming dashboard exists
                        }, 1000);
                    }
                } catch (error) {
                    showError(form, error.message);
                } finally {
                    setLoading(btn, false);
                }
            }
            
            else if (path.includes('register')) {
                const fName = form.querySelector('input[placeholder="Enter your first name"]').value;
                const lName = form.querySelector('input[placeholder="Enter your last name"]').value;
                const email = form.querySelector('input[type="email"]').value;
                const phone = form.querySelector('input[placeholder="Enter your phone number"]').value;
                const password = form.querySelector('input[placeholder="Password"]')?.value;
                const confirm = form.querySelector('input[placeholder="Confirm"]')?.value;
                const terms = form.querySelector('input[type="checkbox"]');

                if (!isValidName(fName)) {
                    showError(form, 'First name must contain only letters and be at least 2 characters long.');
                    return;
                }
                if (!isValidName(lName)) {
                    showError(form, 'Last name must contain only letters and be at least 2 characters long.');
                    return;
                }
                if (!isValidEmailDomain(email)) {
                    showError(form, 'Please use a valid email domain (e.g. @gmail.com, @yahoo.com)');
                    return;
                }
                if (!isValidPhone(phone)) {
                    showError(form, 'Please enter a valid 10-digit Indian phone number (starting with 6-9).');
                    return;
                }
                if (password !== confirm) {
                    showError(form, 'Passwords do not match.');
                    return;
                }
                if (terms && !terms.checked) {
                    showError(form, 'Please accept the terms and conditions.');
                    return;
                }

                setLoading(btn, true);
                try {
                    const res = await HBM_API.request('/auth/register', 'POST', {
                        first_name: fName,
                        last_name: lName,
                        email,
                        phone,
                        password
                    });
                    showSuccess(form, 'Registration successful! Please verify your OTP.');
                    setTimeout(() => {
                        window.location.href = 'verify-otp.html?email=' + encodeURIComponent(email);
                    }, 1500);
                } catch (error) {
                    showError(form, error.message);
                } finally {
                    setLoading(btn, false);
                }
            }

            else if (path.includes('forgot-password')) {
                const email = form.querySelector('input[type="email"]').value;
                if (!isValidEmailDomain(email)) {
                    showError(form, 'Please use a valid email domain (e.g. @gmail.com, @yahoo.com)');
                    return;
                }
                setLoading(btn, true);
                try {
                    await HBM_API.request('/auth/forgot-password', 'POST', { email });
                    showSuccess(form, 'Password reset link sent to your email.');
                } catch (error) {
                    showError(form, error.message);
                } finally {
                    setLoading(btn, false);
                }
            }

            else if (path.includes('reset-password')) {
                // We'd extract token from URL, e.g., ?token=xyz
                const urlParams = new URLSearchParams(window.location.search);
                const token = urlParams.get('token') || '';
                
                const newPassword = form.querySelector('input[placeholder="Enter your new password"]')?.value;
                const confirmPassword = form.querySelector('input[placeholder="Confirm your new password"]')?.value;
                
                if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/.test(newPassword)) {
                    showError(form, 'Please ensure your password meets all requirements.');
                    return;
                }

                if (newPassword !== confirmPassword) {
                    showError(form, 'Passwords do not match.');
                    return;
                }
                
                setLoading(btn, true);
                try {
                    await HBM_API.request('/auth/reset-password', 'POST', {
                        token,
                        new_password: newPassword,
                        confirm_password: confirmPassword
                    });
                    showSuccess(form, 'Password reset successfully! Redirecting...');
                    setTimeout(() => {
                        window.location.href = 'login.html';
                    }, 1500);
                } catch (error) {
                    showError(form, error.message);
                } finally {
                    setLoading(btn, false);
                }
            }

            else if (path.includes('verify-otp')) {
                // Collect OTP from all inputs
                const inputs = form.querySelectorAll('input[type="text"]');
                let otp = '';
                inputs.forEach(input => {
                    otp += input.value;
                });

                // Get email from query param or session storage
                const urlParams = new URLSearchParams(window.location.search);
                const email = urlParams.get('email') || 'admin@healthybharatmission.com'; // fallback

                setLoading(btn, true);
                try {
                    await HBM_API.request('/auth/verify-otp', 'POST', { identifier: email, otp, purpose: 'registration' });
                    showSuccess(form, 'OTP Verified! Redirecting...');
                    setTimeout(() => {
                        window.location.href = '../store.html';
                    }, 1500);
                } catch (error) {
                    showError(form, error.message);
                } finally {
                    setLoading(btn, false);
                }
            }
        });
    }

    // OTP Input logic (auto focus next, clear values on load)
    if (path.includes('verify-otp')) {
        const otpInputs = document.querySelectorAll('.otp-input');
        
        // Timer Logic
        let timerSeconds = 120; // 2 minutes
        const timerCount = document.getElementById('timer-count');
        const timerText = document.getElementById('timer-text');
        const resendBtn = document.getElementById('resend-otp-btn');
        
        const updateTimer = () => {
            const m = Math.floor(timerSeconds / 60).toString().padStart(2, '0');
            const s = (timerSeconds % 60).toString().padStart(2, '0');
            if (timerCount) timerCount.innerText = `${m}:${s}`;
            
            if (timerSeconds <= 0) {
                clearInterval(timerInterval);
                if (timerText) timerText.style.display = 'none';
                if (resendBtn) {
                    resendBtn.disabled = false;
                    resendBtn.className = 'text-[#106e39] font-bold ml-1 hover:underline cursor-pointer';
                }
            }
            timerSeconds--;
        };
        updateTimer();
        const timerInterval = setInterval(updateTimer, 1000);

        // Edit Button Logic
        const editBtn = document.getElementById('edit-email-btn');
        if (editBtn) {
            editBtn.addEventListener('click', () => {
                window.location.href = 'register.html';
            });
        }

        // Display Email from URL
        const urlParams = new URLSearchParams(window.location.search);
        const email = urlParams.get('email') || 'user@example.com';
        const displayEmail = document.getElementById('display-email');
        if (displayEmail) {
            displayEmail.innerText = email;
        }

        if (otpInputs.length > 0) {
            // clear dummy values
            otpInputs.forEach(input => input.value = '');
            
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', function() {
                    // Remove non-numeric chars
                    this.value = this.value.replace(/[^0-9]/g, '');
                    if (this.value.length === 1) {
                        if (index < otpInputs.length - 1) otpInputs[index + 1].focus();
                    }
                });
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && !this.value) {
                        if (index > 0) otpInputs[index - 1].focus();
                    }
                });
            });
        }
    }

    // Dynamic Password Requirements Validation
    if (path.includes('reset-password')) {
        const passInput = document.querySelector('input[placeholder="Enter your new password"]');
        if (passInput) {
            passInput.addEventListener('input', function() {
                const val = this.value;
                const reqs = {
                    'req-length': val.length >= 8,
                    'req-upper': /[A-Z]/.test(val),
                    'req-lower': /[a-z]/.test(val),
                    'req-num': /[0-9]/.test(val),
                    'req-spec': /[\W_]/.test(val)
                };
                
                for (const [id, isValid] of Object.entries(reqs)) {
                    const li = document.getElementById(id);
                    if (li) {
                        const icon = li.querySelector('i');
                        if (isValid) {
                            li.className = "flex items-center gap-2.5 text-[13px] text-[#052b14] font-medium";
                            icon.className = "fa-solid fa-circle-check text-[#106e39] text-[15px]";
                        } else {
                            li.className = "flex items-center gap-2.5 text-[13px] text-gray-500 font-medium";
                            icon.className = "fa-solid fa-circle-check text-gray-300 text-[15px]";
                        }
                    }
                }
            });
        }
    }
});
