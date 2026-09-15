<?php
// Local router for PHP built-in server (php -S)
// This simulates the Hostinger .htaccess rules to allow extensionless URLs locally.

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// If it's a request to the root, serve index.php
if ($uri === '/' || $uri === '/index.php') {
    include __DIR__ . '/index.php';
    return true;
}

// If the requested file actually exists (like images, css, js), serve it as is
if (file_exists(__DIR__ . $uri) && !is_dir(__DIR__ . $uri)) {
    return false; // Let the built-in server handle it
}

// If the requested URI doesn't end with .php, check if the .php file exists
if (!preg_match('/\.php$/', $uri)) {
    $phpFile = __DIR__ . $uri . '.php';
    if (file_exists($phpFile)) {
        // Update PHP self to reflect the actual file being loaded
        $_SERVER['PHP_SELF'] = $uri . '.php';
        $_SERVER['SCRIPT_NAME'] = $uri . '.php';
        $_SERVER['SCRIPT_FILENAME'] = $phpFile;
        
        include $phpFile;
        return true;
    }
}

// Fallback to 404
return false;
