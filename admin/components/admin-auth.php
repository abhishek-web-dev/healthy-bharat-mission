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
    
    if (!$adminUser || ($adminUser['role_slug'] !== 'admin' && $adminUser['role_slug'] !== 'superadmin')) {
        header("Location: /"); // Redirect normal users/experts back to home
        exit;
    }
    
    // Store user globally for the admin templates
    $GLOBALS['adminUser'] = $adminUser;
} catch (Exception $e) {
    // If DB fails, fallback
    error_log("Admin Auth DB Error: " . $e->getMessage());
    header("Location: /admin/login.php");
    exit;
}
?>
