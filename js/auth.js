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

    if (form) {
        // Prevent default submit
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = form.querySelector('button[type="submit"]');

            if (path.includes('login.html')) {
                const email = form.querySelector('input[type="email"]').value;
                const password = form.querySelector('input[type="password"]').value;
                
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
            
            else if (path.includes('register.html')) {
                const fName = form.querySelector('input[placeholder="Enter your first name"]').value;
                const lName = form.querySelector('input[placeholder="Enter your last name"]').value;
                const email = form.querySelector('input[type="email"]').value;
                const phone = form.querySelector('input[type="tel"]').value;
                const password = form.querySelector('input[placeholder="Password"]').value;
                const confirm = form.querySelector('input[placeholder="Confirm"]').value;
                const terms = form.querySelector('input[type="checkbox"]');

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

            else if (path.includes('forgot-password.html')) {
                const email = form.querySelector('input[type="email"]').value;
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

            else if (path.includes('reset-password.html')) {
                // We'd extract token from URL, e.g., ?token=xyz
                const urlParams = new URLSearchParams(window.location.search);
                const token = urlParams.get('token') || '';
                
                const newPassword = form.querySelector('input[placeholder="Enter your new password"]').value;
                const confirmPassword = form.querySelector('input[placeholder="Confirm your new password"]').value;
                
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

            else if (path.includes('verify-otp.html')) {
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
    if (path.includes('verify-otp.html')) {
        const otpInputs = document.querySelectorAll('input[type="text"][maxlength="1"]');
        if (otpInputs.length > 0) {
            // clear dummy values
            otpInputs.forEach(input => input.value = '');
            
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', function() {
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
});
