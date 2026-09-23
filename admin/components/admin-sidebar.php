<?php
$userRole = $GLOBALS['adminUser']['role_slug'] ?? '';
$userPermissions = $GLOBALS['adminUser']['permissions'] ?? [];

$menuItems = [
    ['name' => 'Dashboard', 'icon' => 'fa-solid fa-chart-line', 'url' => 'dashboard.php', 'permission' => 'view_dashboard'],
    ['name' => 'Users', 'icon' => 'fa-solid fa-users', 'url' => 'users.php', 'permission' => 'view_users'],
    ['name' => 'Products', 'icon' => 'fa-solid fa-box', 'url' => 'products.php', 'permission' => 'view_products'],
    ['name' => 'Categories', 'icon' => 'fa-solid fa-tags', 'url' => 'categories.php', 'permission' => 'view_categories'],
    ['name' => 'Orders', 'icon' => 'fa-solid fa-shopping-cart', 'url' => 'orders.php', 'permission' => 'view_orders'],
    ['name' => 'Programs', 'icon' => 'fa-solid fa-dumbbell', 'url' => 'programs.php', 'permission' => 'view_programs'],
    ['name' => 'Health Library', 'icon' => 'fa-solid fa-book-medical', 'url' => 'articles.php', 'permission' => 'view_health_library'],
    ['name' => 'Health Conditions', 'icon' => 'fa-solid fa-notes-medical', 'url' => 'health-conditions.php', 'permission' => 'view_health_conditions'],
    ['name' => 'Website Content (FAQs)', 'icon' => 'fa-solid fa-file-alt', 'url' => 'faqs.php', 'permission' => 'view_faqs'],
    ['name' => 'Media', 'icon' => 'fa-solid fa-images', 'url' => 'media.php', 'permission' => 'view_media'],
    ['name' => 'Appointments', 'icon' => 'fa-solid fa-calendar-check', 'url' => 'appointments.php', 'permission' => 'view_appointments'],
    ['name' => 'Experts', 'icon' => 'fa-solid fa-user-md', 'url' => 'experts.php', 'permission' => 'view_experts'],
    ['name' => 'Contact Inquiries', 'icon' => 'fa-solid fa-headset', 'url' => 'contact-inquiries.php', 'permission' => 'view_inquiries'],
    ['name' => 'Subscribers', 'icon' => 'fa-solid fa-envelope-open-text', 'url' => 'newsletter-subscribers.php', 'permission' => 'view_subscribers'],
    ['name' => 'Reviews', 'icon' => 'fa-solid fa-star', 'url' => 'reviews.php', 'permission' => 'view_reviews'],
    
    // System & Settings
    ['name' => 'Team & Roles', 'icon' => 'fa-solid fa-user-shield', 'url' => 'team.php', 'permission' => 'view_team'],
    ['name' => 'Offers', 'icon' => 'fa-solid fa-tags', 'url' => 'offers.php', 'permission' => 'view_offers'],
    ['name' => 'Coupons', 'icon' => 'fa-solid fa-ticket', 'url' => 'coupons.php', 'permission' => 'view_coupons'],
    ['name' => 'Logs', 'icon' => 'fa-solid fa-clipboard-list', 'url' => 'audit-logs.php', 'permission' => 'view_logs'],
    ['name' => 'Deleted Accounts', 'icon' => 'fa-solid fa-user-slash', 'url' => 'deleted-accounts.php', 'permission' => 'view_deleted_accounts'],
    ['name' => 'Database Backups', 'icon' => 'fa-solid fa-database', 'url' => 'database-backups.php', 'permission' => 'view_backups'],
    ['name' => 'Settings', 'icon' => 'fa-solid fa-cog', 'url' => 'settings.php', 'permission' => 'view_settings'],
];

$currentPage = basename($_SERVER['PHP_SELF']);

$pageMapping = [
    'article-edit.php' => 'articles.php',
    'article-create.php' => 'articles.php',
    'add-health-condition.php' => 'health-conditions.php',
    'edit-health-condition.php' => 'health-conditions.php',
    'add-offer.php' => 'offers.php',
    'edit-offer.php' => 'offers.php',
    'add-coupon.php' => 'coupons.php',
    'edit-coupon.php' => 'coupons.php',
    'add-product.php' => 'products.php',
    'add-employee.php' => 'team.php',
    'edit-user.php' => 'users.php',
    'order-detail.php' => 'orders.php',
    'review-detail.php' => 'reviews.php',
    'contact-inquiry-details.php' => 'contact-inquiries.php',
];
$activePage = $pageMapping[$currentPage] ?? $currentPage;
?>
<aside class="w-64 bg-white border-r border-gray-200 fixed top-0 left-0 hidden md:flex flex-col shadow-[4px_0_24px_rgba(0,0,0,0.02)] z-20" style="height: 100vh; max-height: 100vh; overflow: hidden;">
    <div class="h-16 flex items-center px-6 border-b border-gray-100 shrink-0">
        <a href="dashboard.php" class="flex items-center gap-2 text-xl font-heading font-extrabold text-gray-800 tracking-tight">
            <span class="text-[#106e39]">HBM</span> Admin
        </a>
    </div>
    
    <div class="custom-scrollbar" style="flex: 1 1 auto; min-height: 0; overflow-y: auto;">
        <div class="py-4 px-3">
            <ul class="space-y-1">
                <?php foreach ($menuItems as $item): ?>
                    <?php if ($userRole === 'superadmin' || in_array($item['permission'], $userPermissions)): ?>
                        <li>
                            <a href="<?php echo htmlspecialchars($item['url']); ?>" 
                               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors <?php echo ($activePage === basename($item['url']) && basename($item['url']) !== '#') ? 'bg-[#f2fbf5] text-[#106e39] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'; ?>">
                                <i class="<?php echo htmlspecialchars($item['icon']); ?> w-5 text-center <?php echo ($activePage === basename($item['url']) && basename($item['url']) !== '#') ? 'text-[#106e39]' : 'text-gray-400'; ?>"></i>
                                <?php echo htmlspecialchars($item['name']); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    
    <div class="p-4 border-t border-gray-100 shrink-0">
        <div class="bg-gray-50 rounded-xl p-3 border border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-[#106e39] text-white flex items-center justify-center font-bold text-sm shrink-0">
                <?php echo strtoupper(substr($GLOBALS['adminUser']['first_name'], 0, 1)); ?>
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-bold text-gray-800 truncate"><?php echo htmlspecialchars($GLOBALS['adminUser']['first_name'] . ' ' . $GLOBALS['adminUser']['last_name']); ?></p>
                <p class="text-xs text-gray-500 truncate capitalize"><?php echo htmlspecialchars($GLOBALS['adminUser']['role_slug']); ?></p>
            </div>
        </div>
    </div>
</aside>

<!-- Mobile Sidebar Overlay (Hidden by default) -->
<div id="mobile-sidebar-overlay" class="fixed inset-0 bg-gray-900/50 z-30 hidden md:hidden"></div>
<aside id="mobile-sidebar" class="w-64 bg-white h-screen fixed left-0 top-0 transform -translate-x-full transition-transform duration-300 md:hidden flex flex-col z-40 shadow-xl">
    <!-- Duplicate of above content for mobile, handled by JS -->
</aside>
