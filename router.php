<?php
// Local Development Router
// Serves frontend files natively and routes /api/* to the backend.

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// 1. API Routing (Route to backend)
if (preg_match('#^/api/(.*)$#', $uri)) {
    // Include the backend entry point
    require __DIR__ . '/../backend/public/index.php';
    return true;
}

// 2. Uploads Routing (Route to backend storage)
if (preg_match('#^/uploads/(.*)$#', $uri, $matches)) {
    $filePath = __DIR__ . '/../backend/public/uploads/' . $matches[1];
    if (file_exists($filePath)) {
        $mime = mime_content_type($filePath) ?: 'application/octet-stream';
        header("Content-Type: " . $mime);
        readfile($filePath);
        return true;
    }
}

// 2.5 Storage Routing (Route to backend storage like invoices)
if (preg_match('#^/storage/(.*)$#', $uri, $matches)) {
    $filePath = __DIR__ . '/../backend/storage/' . $matches[1];
    if (file_exists($filePath)) {
        $mime = mime_content_type($filePath) ?: 'application/octet-stream';
        if (pathinfo($filePath, PATHINFO_EXTENSION) === 'pdf') {
            $mime = 'application/pdf';
        }
        header("Content-Type: " . $mime);
        readfile($filePath);
        return true;
    }
}

// 3. Prevent duplicate content for /index
if ($uri === '/index' || $uri === '/index.php') {
    header("Location: /", true, 301);
    exit;
}

// 4. Extensionless PHP URLs (simulate .htaccess)
if ($uri !== '/' && file_exists(__DIR__ . $uri . '.php')) {
    require __DIR__ . $uri . '.php';
    return true;
}

// 5. Index routing
if ($uri === '/' || $uri === '') {
    if (file_exists(__DIR__ . '/index.php')) {
        require __DIR__ . '/index.php';
        return true;
    }
}

// 5. Let PHP's built-in server handle existing static files (CSS, JS, images)
if (file_exists(__DIR__ . $uri) && !is_dir(__DIR__ . $uri)) {
    return false;
}

// 6. Store product reviews photos routing
if (preg_match('#^/store/([^/]+)/reviews/photos$#', $uri, $matches)) {
    $_GET['slug'] = $matches[1];
    require __DIR__ . '/store/all-photos.php';
    return true;
}

// 7. Store product reviews routing
if (preg_match('#^/store/([^/]+)/reviews$#', $uri, $matches)) {
    $_GET['slug'] = $matches[1];
    require __DIR__ . '/store/all-reviews.php';
    return true;
}

// 8. Store product routing fallback (store/slug)
if (preg_match('#^/store/([^/]+)$#', $uri, $matches)) {
    // Make sure we are not conflicting with known store directories/pages like 'cart', 'checkout', etc.
    $reserved_store_paths = ['cart', 'checkout', 'my-orders', 'checkout-payment', 'checkout-review', 'order-confirmation', 'order-details', 'product'];
    if (!in_array($matches[1], $reserved_store_paths)) {
        $_GET['slug'] = $matches[1];
        require __DIR__ . '/store/product.php';
        return true;
    }
}

// 8.5. Program routing mapping (Map backend API slugs to physical files)
if (preg_match('#^/program/([^/]+)$#', $uri, $matches)) {
    $requestedSlug = $matches[1];
    $programMap = [
        'diabetes-reversal' => 'diabetes-care',
        'weight-loss-journey' => 'weight-management',
        'weight-loss' => 'weight-management'
    ];
    $mappedFile = $programMap[$requestedSlug] ?? $requestedSlug;
    if (file_exists(__DIR__ . '/program/' . $mappedFile . '.php')) {
        require __DIR__ . '/program/' . $mappedFile . '.php';
        return true;
    }
}

// 9. Article routing fallback (root-level slugs)
if (!preg_match('#^/(api|uploads|admin)/#', $uri)) {
    // If it's not a known file and not in reserved paths, assume it's an article slug
    $slug = trim($uri, '/');
    if (!empty($slug)) {
        $_GET['slug'] = $slug;
        require __DIR__ . '/article.php';
        return true;
    }
}


// 6. 404 Fallback
http_response_code(404);
if (file_exists(__DIR__ . '/404.php')) {
    require __DIR__ . '/404.php';
    return true;
}

echo "404 Not Found";
return true;
