<?php
// If already logged in, redirect to dashboard
$token = $_COOKIE['auth_token'] ?? null;
if ($token) {
    // Attempt simple verification.
    $backendDir = __DIR__ . '/../../backend';
    if (file_exists($backendDir . '/vendor/autoload.php')) {
        require_once $backendDir . '/vendor/autoload.php';
        spl_autoload_register(function ($class) use ($backendDir) {
            $prefix = 'HBM\\';
            $base_dir = $backendDir . '/src/';
            $len = strlen($prefix);
            if (strncmp($prefix, $class, $len) !== 0) return;
            $relative_class = substr($class, $len);
            $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
            if (file_exists($file)) require $file;
        });
        \HBM\Helpers\Env::load($backendDir . '/.env');
        try {
            $repo = new \HBM\Repositories\AuthRepository();
            $session = $repo->getSession($token);
            if ($session) {
                $user = $repo->getUserById($session['user_id']);
                if ($user && in_array($user['role_slug'], ['admin', 'superadmin'])) {
                    header("Location: dashboard.php");
                    exit;
                }
            }
        } catch (Exception $e) {
            // Ignore DB errors on login page check
        }
    }
}
?>
<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Healthy Bharat Mission</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tailwind CSS -->
    <link href="../dist/output.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../assets/images/favicon/favicon-96x96.png" sizes="96x96" />
</head>
<body class="font-body text-gray-800 bg-gray-50 flex items-center justify-center min-h-screen">
    
    <div class="w-full max-w-md p-6">
        <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-[#f2fbf5] rounded-2xl flex items-center justify-center mx-auto mb-4 border border-[#e2f6e9]">
                    <i class="fa-solid fa-user-shield text-2xl text-[#106e39]"></i>
                </div>
                <h1 class="text-2xl font-heading font-extrabold text-gray-900 tracking-tight">HBM Admin</h1>
                <p class="text-sm text-gray-500 mt-2">Sign in to access the control panel</p>
            </div>
            
            <div id="error-message" class="hidden mb-6 p-4 rounded-lg bg-red-50 text-red-600 text-sm font-medium border border-red-100 flex items-center gap-3">
                <i class="fa-solid fa-circle-exclamation shrink-0"></i>
                <span id="error-text">Authentication failed.</span>
            </div>

            <div id="step-1">
                <form id="admin-login-form" class="space-y-5">
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-1.5">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" id="email" required
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors"
                                placeholder="admin@healthybharatmission.com">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-1.5">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="password" required
                                class="block w-full pl-10 pr-10 py-2.5 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors"
                                placeholder="••••••••">
                            <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#106e39]">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" id="submit-btn" class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-[#106e39] hover:bg-[#0b5028] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#106e39] transition-all disabled:opacity-70 disabled:cursor-not-allowed">
                        <span id="btn-text">Sign In</span>
                        <i id="btn-spinner" class="fa-solid fa-circle-notch fa-spin hidden"></i>
                    </button>
                </form>
                
                <div class="mt-6 text-center">
                    <a href="../" class="text-sm font-medium text-gray-500 hover:text-[#106e39] transition-colors"><i class="fa-solid fa-arrow-left text-[10px] mr-1"></i> Return to Main Website</a>
                </div>
            </div>

            <div id="step-2" class="hidden text-center">
                <div class="mb-6">
                    <p class="text-sm text-gray-500">We've sent a 6-digit verification code to:</p>
                    <p id="masked-email-display" class="font-bold text-gray-700 mt-1"></p>
                </div>
                
                <div id="otp-error-message" class="hidden mb-6 p-3 rounded-lg bg-red-50 text-red-600 text-sm font-medium border border-red-100 flex items-center gap-2 justify-center">
                    <i class="fa-solid fa-circle-exclamation shrink-0"></i>
                    <span id="otp-error-text">Invalid code.</span>
                </div>

                <form id="otp-form" class="space-y-5">
                    <div class="flex justify-center gap-2 mb-4" id="otp-inputs">
                        <input type="text" maxlength="1" class="w-11 h-12 text-center text-xl font-bold border border-gray-300 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] bg-gray-50 focus:bg-white" required>
                        <input type="text" maxlength="1" class="w-11 h-12 text-center text-xl font-bold border border-gray-300 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] bg-gray-50 focus:bg-white" required>
                        <input type="text" maxlength="1" class="w-11 h-12 text-center text-xl font-bold border border-gray-300 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] bg-gray-50 focus:bg-white" required>
                        <input type="text" maxlength="1" class="w-11 h-12 text-center text-xl font-bold border border-gray-300 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] bg-gray-50 focus:bg-white" required>
                        <input type="text" maxlength="1" class="w-11 h-12 text-center text-xl font-bold border border-gray-300 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] bg-gray-50 focus:bg-white" required>
                        <input type="text" maxlength="1" class="w-11 h-12 text-center text-xl font-bold border border-gray-300 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] bg-gray-50 focus:bg-white" required>
                    </div>
                    
                    <button type="submit" id="verify-btn" class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-[#106e39] hover:bg-[#0b5028] transition-all disabled:opacity-70">
                        <span id="verify-btn-text">Verify OTP</span>
                        <i id="verify-btn-spinner" class="fa-solid fa-circle-notch fa-spin hidden"></i>
                    </button>
                    
                    <div class="pt-4 flex flex-col gap-3">
                        <button type="button" id="resend-btn" class="text-sm font-bold text-[#106e39] hover:text-[#0b5028] disabled:text-gray-400 disabled:cursor-not-allowed">
                            Resend OTP
                        </button>
                        <button type="button" id="back-btn" class="text-sm font-medium text-gray-500 hover:text-gray-800">
                            Back to Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../js/api.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('admin-login-form');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const togglePasswordBtn = document.getElementById('toggle-password');
            const submitBtn = document.getElementById('submit-btn');
            const btnText = document.getElementById('btn-text');
            const btnSpinner = document.getElementById('btn-spinner');
            const errorMsg = document.getElementById('error-message');
            const errorText = document.getElementById('error-text');

            // Toggle Password Visibility
            togglePasswordBtn.addEventListener('click', () => {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                togglePasswordBtn.innerHTML = type === 'password' 
                    ? '<i class="fa-solid fa-eye"></i>' 
                    : '<i class="fa-solid fa-eye-slash text-[#106e39]"></i>';
            });

            // State variables
            let currentChallengeId = null;
            let cooldownTimer = null;
            let cooldownSeconds = 0;

            const step1 = document.getElementById('step-1');
            const step2 = document.getElementById('step-2');
            
            // OTP UI Elements
            const otpForm = document.getElementById('otp-form');
            const otpInputs = document.querySelectorAll('#otp-inputs input');
            const verifyBtn = document.getElementById('verify-btn');
            const verifyBtnText = document.getElementById('verify-btn-text');
            const verifyBtnSpinner = document.getElementById('verify-btn-spinner');
            const resendBtn = document.getElementById('resend-btn');
            const backBtn = document.getElementById('back-btn');
            const maskedEmailDisplay = document.getElementById('masked-email-display');
            const otpErrorMsg = document.getElementById('otp-error-message');
            const otpErrorText = document.getElementById('otp-error-text');

            // Handle OTP input auto-advance
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    if (e.target.value.length === 1 && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                });
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && e.target.value.length === 0 && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                });
                // Handle paste
                input.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const pastedData = e.clipboardData.getData('text').slice(0, 6).replace(/[^0-9]/g, '');
                    for (let i = 0; i < pastedData.length; i++) {
                        if (otpInputs[i]) {
                            otpInputs[i].value = pastedData[i];
                        }
                    }
                    if (pastedData.length > 0) {
                        otpInputs[Math.min(pastedData.length - 1, 5)].focus();
                    }
                });
            });

            function startResendCooldown() {
                cooldownSeconds = 60;
                resendBtn.disabled = true;
                
                if (cooldownTimer) clearInterval(cooldownTimer);
                
                cooldownTimer = setInterval(() => {
                    cooldownSeconds--;
                    if (cooldownSeconds <= 0) {
                        clearInterval(cooldownTimer);
                        resendBtn.disabled = false;
                        resendBtn.textContent = 'Resend OTP';
                    } else {
                        resendBtn.textContent = `Resend OTP in ${cooldownSeconds}s`;
                    }
                }, 1000);
            }

            // Handle Login (Step 1)
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                
                const email = emailInput.value.trim();
                const password = passwordInput.value.trim();
                
                if (!email || !password) return;

                // Loading State
                submitBtn.disabled = true;
                btnText.textContent = 'Verifying...';
                btnSpinner.classList.remove('hidden');
                errorMsg.classList.add('hidden');

                try {
                    // Call backend Admin API
                    const res = await window.HBM_API.request('/auth/admin/login', 'POST', { email, password });
                    
                    if (res.data && res.data.challenge_id) {
                        currentChallengeId = res.data.challenge_id;
                        maskedEmailDisplay.textContent = res.data.masked_email;
                        
                        // Transition to Step 2
                        step1.classList.add('hidden');
                        step2.classList.remove('hidden');
                        document.querySelector('h1').textContent = "Verify Your Login";
                        document.querySelector('h1').nextElementSibling.classList.add('hidden');
                        
                        // Clear inputs and focus first
                        otpInputs.forEach(i => i.value = '');
                        setTimeout(() => otpInputs[0].focus(), 100);
                        
                        startResendCooldown();
                    }
                } catch (err) {
                    errorText.textContent = err.message || 'Login failed. Please check your credentials.';
                    errorMsg.classList.remove('hidden');
                } finally {
                    submitBtn.disabled = false;
                    btnText.textContent = 'Sign In';
                    btnSpinner.classList.add('hidden');
                }
            });

            // Handle Verify OTP (Step 2)
            otpForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                
                const otp = Array.from(otpInputs).map(i => i.value).join('');
                if (otp.length !== 6 || !currentChallengeId) return;

                verifyBtn.disabled = true;
                verifyBtnText.textContent = 'Verifying...';
                verifyBtnSpinner.classList.remove('hidden');
                otpErrorMsg.classList.add('hidden');

                try {
                    const res = await window.HBM_API.request('/auth/admin/verify-otp', 'POST', { 
                        challenge_id: currentChallengeId,
                        otp: otp 
                    });
                    
                    if (res.data && res.data.token) {
                        window.HBM_API.setToken(res.data.token);
                        document.cookie = `auth_token=${res.data.token}; path=/; max-age=2592000`;
                        window.location.href = 'dashboard.php';
                    }
                } catch (err) {
                    otpErrorText.textContent = err.message || 'Invalid code.';
                    otpErrorMsg.classList.remove('hidden');
                    verifyBtn.disabled = false;
                    verifyBtnText.textContent = 'Verify OTP';
                    verifyBtnSpinner.classList.add('hidden');
                    
                    // Clear inputs on error
                    otpInputs.forEach(i => i.value = '');
                    otpInputs[0].focus();
                    
                    if (err.message && err.message.includes("start over")) {
                        setTimeout(() => backBtn.click(), 2000);
                    }
                }
            });

            // Handle Resend
            resendBtn.addEventListener('click', async () => {
                if (!currentChallengeId || cooldownSeconds > 0) return;
                
                resendBtn.disabled = true;
                resendBtn.textContent = 'Sending...';
                otpErrorMsg.classList.add('hidden');

                try {
                    const res = await window.HBM_API.request('/auth/admin/resend-otp', 'POST', { 
                        challenge_id: currentChallengeId
                    });
                    
                    if (res.data && res.data.challenge_id) {
                        currentChallengeId = res.data.challenge_id;
                        startResendCooldown();
                        // Clear inputs
                        otpInputs.forEach(i => i.value = '');
                        otpInputs[0].focus();
                    }
                } catch (err) {
                    otpErrorText.textContent = err.message || 'Failed to resend code.';
                    otpErrorMsg.classList.remove('hidden');
                    resendBtn.disabled = false;
                    resendBtn.textContent = 'Resend OTP';
                }
            });

            // Handle Back to Login
            backBtn.addEventListener('click', () => {
                step2.classList.add('hidden');
                step1.classList.remove('hidden');
                document.querySelector('h1').textContent = "HBM Admin";
                document.querySelector('h1').nextElementSibling.classList.remove('hidden');
                currentChallengeId = null;
                otpErrorMsg.classList.add('hidden');
                errorMsg.classList.add('hidden');
                passwordInput.value = '';
                if (cooldownTimer) clearInterval(cooldownTimer);
            });
        });
    </script>
</body>
</html>
