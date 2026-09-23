<?php
require_once __DIR__ . '/admin-auth.php'; // Ensures protection is applied immediately
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HBM Admin Panel</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS (Reusing existing public build) -->
    <link href="../dist/output.css" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../assets/images/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="../assets/images/favicon/favicon.svg" />
    <link rel="shortcut icon" href="../assets/images/favicon/favicon.ico" />
    
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #e5e7eb; border-radius: 20px; }
        @media (min-width: 768px) {
            .md\:pl-64 { padding-left: 16rem; }
        }
    </style>

    <script>
        // Prevent browser from restoring previous scroll position on reload/navigation
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
        window.scrollTo(0, 0);
    </script>
</head>
<body class="font-body text-gray-800 bg-gray-50/50 antialiased min-h-screen">

    <?php require_once __DIR__ . '/admin-sidebar.php'; ?>
    
    <!-- Main Content Area -->
    <div class="md:pl-64 flex flex-col min-h-screen transition-all duration-300">
        
        <!-- Topbar -->
        <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-4 lg:px-8 sticky top-0 z-10 shadow-[0_4px_24px_rgba(0,0,0,0.02)]">
            <div class="flex items-center gap-4">
                <button id="mobile-menu-btn" class="md:hidden w-10 h-10 rounded-lg text-gray-500 hover:bg-gray-50 flex items-center justify-center">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <h1 class="text-xl font-bold text-gray-800 hidden sm:block">
                    <?php 
                    $pageFile = basename($_SERVER['PHP_SELF']);
                    $displayName = ucfirst(str_replace('-', ' ', basename($pageFile, '.php')));
                    
                    if (isset($menuItems)) {
                        foreach ($menuItems as $item) {
                            if (basename($item['url']) === $pageFile) {
                                $displayName = $item['name'];
                                break;
                            }
                        }
                    }
                    echo htmlspecialchars($displayName);
                    ?>
                </h1>
            </div>
            
            <div class="flex items-center gap-4">
                <button id="admin-logout-btn" class="flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-red-600 transition-colors px-3 py-1.5 rounded-lg hover:bg-red-50">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> <span class="hidden sm:inline">Logout</span>
                </button>
            </div>
        </header>
        
        <!-- Main Content -->
        <main class="flex-1 p-4 lg:p-8">
