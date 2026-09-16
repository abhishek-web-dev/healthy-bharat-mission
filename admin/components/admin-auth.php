<?php
// Initialize backend connection for auth verification
// We must not output anything before checking auth to allow headers to redirect.
$backendDir = __DIR__ . '/../../../backend'; // from frontend/admin/components to project root/backend
if (!file_exists($backendDir . '/vendor/autoload.php')) {
    die("Backend not found or not initialized.");
}
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

// Load Env
\HBM\Helpers\Env::load($backendDir . '/.env');

use HBM\Repositories\AuthRepository;

$token = $_COOKIE['auth_token'] ?? null;
if (!$token) {
    header("Location: /admin/login.php");
    exit;
}

try {
    $repo = new AuthRepository();
    $session = $repo->getSession($token);
    if (!$session) {
        header("Location: /admin/login.php");
        exit;
    }
    
    $adminUser = $repo->getUserById($session['user_id']);
    
    if (!$adminUser || $adminUser['role_slug'] === 'user') {
        header("Location: /"); // Redirect normal users back to home
        exit;
    }
    
    // Store user globally for the admin templates
    $GLOBALS['adminUser'] = $adminUser;

    // Enforce page-level authorization based on URL
    $currentPage = basename($_SERVER['PHP_SELF']);
    
    $pagePermissions = [
        'dashboard.php' => 'view_dashboard',
        'users.php' => 'view_users',
        'products.php' => 'view_products',
        'categories.php' => 'view_categories',
        'orders.php' => 'view_orders',
        'programs.php' => 'view_programs',
        'articles.php' => 'view_health_library',
        'health-conditions.php' => 'view_health_conditions',
        'faqs.php' => 'view_faqs',
        'appointments.php' => 'view_appointments',
        'experts.php' => 'view_experts',
        'contact-inquiries.php' => 'view_inquiries',
        'newsletter-subscribers.php' => 'view_subscribers',
        
        // System & Settings
        'team.php' => 'view_team',
        'add-employee.php' => 'create_team',
        'audit-logs.php' => 'view_logs',
        'settings.php' => 'view_settings',
    ];

    if ($adminUser['role_slug'] !== 'superadmin' && isset($pagePermissions[$currentPage])) {
        $requiredPerm = $pagePermissions[$currentPage];
        $userPerms = $adminUser['permissions'] ?? [];
        
        if (!in_array($requiredPerm, $userPerms)) {
            // Unauthorized for this specific page, redirect to dashboard or an error page
            if ($currentPage !== 'dashboard.php') {
                header("Location: dashboard.php");
                exit;
            } else {
                echo "Access Denied.";
                exit;
            }
        }
    }
} catch (Exception $e) {
    // If DB fails, fallback
    error_log("Admin Auth DB Error: " . $e->getMessage());
    header("Location: /admin/login.php");
    exit;
}
?>
