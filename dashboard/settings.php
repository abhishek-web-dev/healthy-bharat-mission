<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Healthy Bharat Mission</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="../dist/output.css" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../assets/images/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="../assets/images/favicon/favicon.svg" />
    <link rel="shortcut icon" href="../assets/images/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="../assets/images/favicon/site.webmanifest" />
</head>
<body class="font-body text-gray-800 bg-gray-50/50 antialiased min-h-screen flex flex-col">

    <hbm-header base-path="../"></hbm-header>

    <div class="flex-grow py-8 px-4 lg:px-8 max-w-[1500px] mx-auto w-full">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar -->
            <hbm-dashboard-sidebar active-page="settings"></hbm-dashboard-sidebar>

            <!-- Main Content -->
            <div id="dashboard-main" class="flex-1 bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-gray-100 p-6 lg:p-10 transition-opacity duration-300 relative">
                
                <style>
                    /* Custom Toggle Switch to avoid missing Tailwind classes */
                    .toggle-switch {
                        position: relative;
                        display: inline-block;
                        width: 48px;
                        height: 26px;
                    }
                    .toggle-switch input {
                        opacity: 0;
                        width: 0;
                        height: 0;
                    }
                    .slider {
                        position: absolute;
                        cursor: pointer;
                        top: 0; left: 0; right: 0; bottom: 0;
                        background-color: #cbd5e1; /* slate-300 */
                        transition: .3s;
                        border-radius: 26px;
                    }
                    .slider:before {
                        position: absolute;
                        content: "";
                        height: 22px;
                        width: 22px;
                        left: 2px;
                        bottom: 2px;
                        background-color: white;
                        transition: .3s;
                        border-radius: 50%;
                        box-shadow: 0 1px 3px rgba(0,0,0,0.15);
                    }
                    input:checked + .slider {
                        background-color: #106e39;
                    }
                    input:focus + .slider {
                        box-shadow: 0 0 1px #106e39;
                    }
                    input:checked + .slider:before {
                        transform: translateX(22px);
                    }
                </style>

                <div class="mb-10">
                    <h2 class="text-3xl font-heading font-extrabold text-[#052b14]">Account Settings</h2>
                    <p class="text-gray-500 font-medium text-[15px] mt-2">Manage your account security and preferences.</p>
                </div>

                <!-- Security Section -->
                <div style="margin-bottom: 32px;">
                    <h3 class="font-bold text-gray-900 text-[16px]" style="margin-bottom: 16px;">Security</h3>
                    <div class="bg-gray-50 rounded-xl border border-gray-100 p-6 flex items-center justify-between gap-6">
                        <div>
                            <h4 class="font-bold text-gray-900 text-[15px] mb-1">Two-Factor Authentication (2FA)</h4>
                            <p class="text-gray-500 text-[14px]">Add an extra layer of security to your account. When enabled, you'll need to enter an OTP sent to your email to log in.</p>
                        </div>
                        <div class="shrink-0">
                            <label class="toggle-switch">
                                <input type="checkbox" id="two-factor-toggle">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-b border-gray-100" style="margin: 32px 0;"></div>

                <!-- Password Section -->
                <div style="margin-bottom: 32px;">
                    <h3 class="font-bold text-gray-900 text-[16px]" style="margin-bottom: 16px;">Password</h3>
                    <div id="change-password-btn" class="flex items-center justify-between cursor-pointer group hover:bg-gray-50 rounded-lg transition-colors" style="padding: 12px; margin: 0 -12px;">
                        <span class="text-gray-700 font-medium text-[15px] group-hover:text-gray-900">Change Password</span>
                        <i class="fa-solid fa-chevron-right text-gray-400 group-hover:text-gray-700 text-[13px]"></i>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-b border-gray-100" style="margin: 32px 0;"></div>

                <!-- Danger Zone -->
                <div style="margin-bottom: 16px;">
                    <h3 class="font-bold text-red-600 text-[16px]" style="margin-bottom: 8px;">Danger Zone</h3>
                    <p class="text-gray-500 text-[14px]" style="margin-bottom: 20px;">Once you delete your account, there is no going back. Please be certain.</p>
                    <button id="delete-account-btn" style="background-color: #e11d48; color: white; padding: 10px 24px;" class="font-bold text-sm rounded-lg hover:opacity-90 transition-opacity shadow-sm">
                        Delete Account
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
        <!-- Change Password Modal -->
    <div id="password-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 transition-opacity duration-300 opacity-0" style="padding: 1rem;">
        <div class="bg-white rounded-[1.5rem] p-8 max-w-[420px] w-full shadow-2xl relative transform scale-95 transition-transform duration-300">
            <button id="close-password-modal" class="absolute top-6 right-6 w-8 h-8 flex items-center justify-center rounded-full bg-gray-50 text-gray-400 hover:bg-gray-100 hover:text-gray-900 transition-colors">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
            <h3 class="text-2xl font-heading font-extrabold text-gray-900 mb-2">Change Password</h3>
            <p class="text-[14px] text-gray-500 mb-6">Create a strong, new password to keep your account secure.</p>
            <form id="password-form" class="flex flex-col gap-5">
                <div id="password-error" class="hidden text-red-600 bg-red-50 px-4 py-3 border border-red-100 rounded-xl text-[13px] font-medium flex items-start gap-2">
                    <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
                    <span class="flex-1 error-text"></span>
                </div>
                
                <div>
                    <label class="block text-[13px] font-bold text-gray-700 mb-2">Current Password</label>
                    <input type="password" id="current_password" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-[14px] focus:outline-none focus:border-[#106e39] focus:ring-1 focus:ring-[#106e39] transition-all" placeholder="Enter current password">
                </div>
                <div>
                    <label class="block text-[13px] font-bold text-gray-700 mb-2">New Password</label>
                    <input type="password" id="new_password" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-[14px] focus:outline-none focus:border-[#106e39] focus:ring-1 focus:ring-[#106e39] transition-all" placeholder="Enter new password">
                </div>
                <div>
                    <label class="block text-[13px] font-bold text-gray-700 mb-2">Confirm New Password</label>
                    <input type="password" id="confirm_password" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-[14px] focus:outline-none focus:border-[#106e39] focus:ring-1 focus:ring-[#106e39] transition-all" placeholder="Confirm new password">
                </div>
                
                <button type="submit" id="submit-password" class="mt-2 w-full py-3.5 bg-[#106e39] text-white text-[14px] font-bold rounded-xl hover:bg-[#0a4d27] transition-all shadow-md flex items-center justify-center gap-2">
                    Update Password
                </button>
            </form>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div id="delete-modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 shadow-xl" style="position: relative;">
            <button id="close-delete-modal" class="text-gray-400 hover:text-gray-600 transition-colors" style="position: absolute; top: 16px; right: 16px; cursor: pointer; padding: 4px;">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
            <div class="w-12 h-12 bg-red-50 text-red-600 rounded-full flex items-center justify-center mb-4">
                <i class="fa-solid fa-triangle-exclamation text-xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-red-600 mb-2">Delete Account</h3>
            <p class="text-gray-500 text-[14px] mb-6">This action cannot be undone. To confirm, please enter your password below.</p>
            
            <form id="delete-form" class="flex flex-col gap-4">
                <div id="delete-error" class="hidden text-red-600 bg-red-50 p-3 rounded-lg text-[13px] font-medium"></div>
                
                <div>
                    <label class="block text-[13px] font-bold text-gray-700 mb-1.5">Account Password</label>
                    <div class="relative">
                        <input type="password" id="delete_password" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 pr-10 text-[14px] focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all">
                        <button type="button" id="toggle-delete-pwd" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fa-regular fa-eye" id="toggle-delete-icon"></i>
                        </button>
                    </div>
                </div>
                
                <button type="submit" id="submit-delete" style="background-color: #e11d48; color: white;" class="mt-2 w-full py-3 font-bold rounded-xl hover:opacity-90 transition-opacity shadow-sm flex items-center justify-center gap-2">
                    Permanently Delete
                </button>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../js/api.js"></script>
    <script src="../js/components_v15.js"></script>
    <script src="../js/dashboard.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const twoFactorToggle = document.getElementById('two-factor-toggle');
            
            // Password Modal elements
            const passwordModal = document.getElementById('password-modal');
            const changePasswordBtn = document.getElementById('change-password-btn');
            const closePasswordModal = document.getElementById('close-password-modal');
            const passwordForm = document.getElementById('password-form');
            const passwordError = document.getElementById('password-error');
            const submitPasswordBtn = document.getElementById('submit-password');

            // Delete Modal elements
            const deleteModal = document.getElementById('delete-modal');
            const deleteAccountBtn = document.getElementById('delete-account-btn');
            const closeDeleteModal = document.getElementById('close-delete-modal');
            const deleteForm = document.getElementById('delete-form');
            const deleteError = document.getElementById('delete-error');
            const submitDeleteBtn = document.getElementById('submit-delete');
            const toggleDeletePwdBtn = document.getElementById('toggle-delete-pwd');
            const toggleDeleteIcon = document.getElementById('toggle-delete-icon');
            const deletePasswordInput = document.getElementById('delete_password');

            // Load 2FA setting
            async function loadSettings() {
                try {
                    const res = await HBM_API.request('/user/settings');
                    if (res.data && res.data.two_factor_enabled !== undefined) {
                        twoFactorToggle.checked = !!res.data.two_factor_enabled;
                    }
                } catch (error) {
                    console.error('Failed to load settings', error);
                }
            }
            loadSettings();

            twoFactorToggle.addEventListener('change', async (e) => {
                const isEnabled = e.target.checked;
                try {
                    await HBM_API.request('/user/settings/2fa', 'PUT', { enabled: isEnabled });
                    if (window.showNotification) {
                        window.showNotification(isEnabled ? '2FA enabled successfully' : '2FA disabled successfully');
                    }
                } catch (error) {
                    // Revert toggle if failed
                    e.target.checked = !isEnabled;
                    alert(error.message || 'Failed to update 2FA setting');
                }
            });

            // Password Modal Logic
            changePasswordBtn.addEventListener('click', () => {
                passwordModal.classList.remove('hidden');
                passwordModal.classList.add('flex');
                // Trigger reflow for animation
                void passwordModal.offsetWidth;
                passwordModal.classList.remove('opacity-0');
                passwordModal.querySelector('div').classList.remove('scale-95');
                
                passwordForm.reset();
                passwordError.classList.add('hidden');
            });

            closePasswordModal.addEventListener('click', () => {
                passwordModal.classList.add('opacity-0');
                passwordModal.querySelector('div').classList.add('scale-95');
                setTimeout(() => {
                    passwordModal.classList.add('hidden');
                    passwordModal.classList.remove('flex');
                }, 300);
            });

            passwordForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                passwordError.classList.add('hidden');
                const errorText = passwordError.querySelector('.error-text');
                
                const current_password = document.getElementById('current_password').value;
                const new_password = document.getElementById('new_password').value;
                const confirm_password = document.getElementById('confirm_password').value;

                if (new_password !== confirm_password) {
                    errorText.textContent = "New passwords do not match.";
                    passwordError.classList.remove('hidden');
                    return;
                }

                submitPasswordBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Updating...';
                submitPasswordBtn.disabled = true;

                try {
                    await HBM_API.auth.changePassword({ current_password, new_password, confirm_password });
                    window.showNotification ? window.showNotification('Password changed successfully!') : alert('Password changed successfully!');
                    closePasswordModal.click();
                } catch (error) {
                    errorText.textContent = error.message || 'Failed to change password.';
                    passwordError.classList.remove('hidden');
                } finally {
                    submitPasswordBtn.innerHTML = 'Update Password';
                    submitPasswordBtn.disabled = false;
                }
            });

            // Delete Account Modal Logic
            deleteAccountBtn.addEventListener('click', () => {
                deleteModal.classList.remove('hidden');
                deleteModal.classList.add('flex');
                deleteForm.reset();
                deleteError.classList.add('hidden');
            });

            closeDeleteModal.addEventListener('click', () => {
                deleteModal.classList.add('hidden');
                deleteModal.classList.remove('flex');
            });

            deleteForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                deleteError.classList.add('hidden');
                
                const password = document.getElementById('delete_password').value;

                submitDeleteBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Deleting...';
                submitDeleteBtn.disabled = true;

                try {
                    await HBM_API.auth.deleteAccount({ password });
                    alert('Account deleted successfully.');
                    // Log out and redirect
                    localStorage.removeItem('hbm_token');
                    window.location.href = '../index';
                } catch (error) {
                    deleteError.textContent = error.message || 'Incorrect password or failed to delete account.';
                    deleteError.classList.remove('hidden');
                } finally {
                    submitDeleteBtn.innerHTML = 'Permanently Delete';
                    submitDeleteBtn.disabled = false;
                }
            });

            // Password Toggle Logic
            if (toggleDeletePwdBtn) {
                toggleDeletePwdBtn.addEventListener('click', () => {
                    if (deletePasswordInput.type === 'password') {
                        deletePasswordInput.type = 'text';
                        toggleDeleteIcon.classList.replace('fa-eye', 'fa-eye-slash');
                    } else {
                        deletePasswordInput.type = 'password';
                        toggleDeleteIcon.classList.replace('fa-eye-slash', 'fa-eye');
                    }
                });
            }
        });
    </script>
</body>
</html>