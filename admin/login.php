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

            // Handle Login
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                
                const email = emailInput.value.trim();
                const password = passwordInput.value.trim();
                
                if (!email || !password) return;

                // Loading State
                submitBtn.disabled = true;
                btnText.textContent = 'Authenticating...';
                btnSpinner.classList.remove('hidden');
                errorMsg.classList.add('hidden');

                try {
                    // Call backend API
                    const res = await window.HBM_API.auth.login({ email, password });
                    
                    // The token is also returned in the body
                    if (res.data && res.data.token) {
                        window.HBM_API.setToken(res.data.token);
                        // Manually set cookie for the frontend PHP server to read since fetch may ignore cross-port Set-Cookie
                        document.cookie = `auth_token=${res.data.token}; path=/; max-age=2592000`;
                    }
                    
                    // We must verify if the logged in user is actually an admin!
                    // We call /api/auth/me to check their role.
                    const meRes = await window.HBM_API.auth.getMe();
                    const role = meRes.data.role || meRes.data.role_slug;

                    if (role === 'admin' || role === 'super_admin' || role === 'superadmin') {
                        // Success!
                        window.location.href = 'dashboard.php';
                    } else {
                        // Authorized as user, but not admin. Log them back out!
                        await window.HBM_API.auth.logout();
                        window.HBM_API.setToken(null);
                        document.cookie = "auth_token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                        
                        throw new Error("Access denied. Administrator privileges required.");
                    }
                    
                } catch (err) {
                    errorText.textContent = err.message || 'Login failed. Please check your credentials.';
                    errorMsg.classList.remove('hidden');
                    
                    // Reset State
                    submitBtn.disabled = false;
                    btnText.textContent = 'Sign In';
                    btnSpinner.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
