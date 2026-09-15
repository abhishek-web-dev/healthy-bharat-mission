<?php
$userRole = $GLOBALS['adminUser']['role_slug'] ?? '';

$menuItems = [
    ['name' => 'Dashboard', 'icon' => 'fa-solid fa-chart-line', 'url' => 'dashboard.php', 'roles' => ['superadmin', 'admin']],
    ['name' => 'Users', 'icon' => 'fa-solid fa-users', 'url' => 'users.php', 'roles' => ['superadmin', 'admin']],
    ['name' => 'Products', 'icon' => 'fa-solid fa-box', 'url' => 'products.php', 'roles' => ['superadmin', 'admin']],
    ['name' => 'Orders', 'icon' => 'fa-solid fa-shopping-cart', 'url' => 'orders.php', 'roles' => ['superadmin', 'admin']],
    ['name' => 'Programs', 'icon' => 'fa-solid fa-dumbbell', 'url' => 'programs.php', 'roles' => ['superadmin', 'admin']],
    ['name' => 'Health Library', 'icon' => 'fa-solid fa-book-medical', 'url' => 'articles.php', 'roles' => ['superadmin', 'admin']],
    ['name' => 'Health Conditions', 'icon' => 'fa-solid fa-notes-medical', 'url' => 'health-conditions.php', 'roles' => ['superadmin', 'admin']],
    ['name' => 'Website Content (FAQs)', 'icon' => 'fa-solid fa-file-alt', 'url' => 'faqs.php', 'roles' => ['superadmin', 'admin']],
    ['name' => 'Media', 'icon' => 'fa-solid fa-images', 'url' => '#', 'roles' => ['superadmin', 'admin']],
    ['name' => 'Appointments', 'icon' => 'fa-solid fa-calendar-check', 'url' => 'appointments.php', 'roles' => ['superadmin', 'admin']],
    ['name' => 'Experts', 'icon' => 'fa-solid fa-user-md', 'url' => 'experts.php', 'roles' => ['superadmin', 'admin']],
    ['name' => 'Contact Inquiries', 'icon' => 'fa-solid fa-headset', 'url' => 'contact-inquiries.php', 'roles' => ['superadmin', 'admin']],
    ['name' => 'Subscribers', 'icon' => 'fa-solid fa-envelope-open-text', 'url' => 'newsletter-subscribers.php', 'roles' => ['superadmin', 'admin']],
    ['name' => 'Reviews', 'icon' => 'fa-solid fa-star', 'url' => '#', 'roles' => ['superadmin', 'admin']],
    
    // Super Admin Only
    ['name' => 'Team & Roles', 'icon' => 'fa-solid fa-user-shield', 'url' => '#', 'roles' => ['superadmin']],
    ['name' => 'Audit Logs', 'icon' => 'fa-solid fa-clipboard-list', 'url' => '#', 'roles' => ['superadmin']],
    ['name' => 'Deleted Accounts / Consents', 'icon' => 'fa-solid fa-user-slash', 'url' => '#', 'roles' => ['superadmin']],
    ['name' => 'Database Backups', 'icon' => 'fa-solid fa-database', 'url' => '#', 'roles' => ['superadmin']],
    ['name' => 'Settings', 'icon' => 'fa-solid fa-cog', 'url' => '#', 'roles' => ['superadmin']],
];

$currentPage = basename($_SERVER['PHP_SELF']);
?>
<aside class="w-64 bg-white border-r border-gray-200 h-screen fixed left-0 top-0 hidden md:flex flex-col shadow-[4px_0_24px_rgba(0,0,0,0.02)] z-20">
    <div class="h-16 flex items-center px-6 border-b border-gray-100 shrink-0">
        <a href="dashboard.php" class="flex items-center gap-2 text-xl font-heading font-extrabold text-gray-800 tracking-tight">
            <span class="text-[#106e39]">HBM</span> Admin
        </a>
    </div>
    
    <div class="flex-1 overflow-y-auto py-4 px-3 custom-scrollbar">
        <ul class="space-y-1">
            <?php foreach ($menuItems as $item): ?>
                <?php if (in_array($userRole, $item['roles'])): ?>
                    <li>
                        <a href="<?php echo htmlspecialchars($item['url']); ?>" 
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors <?php echo ($currentPage === basename($item['url'])) ? 'bg-[#f2fbf5] text-[#106e39] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'; ?>">
                            <i class="<?php echo htmlspecialchars($item['icon']); ?> w-5 text-center <?php echo ($currentPage === basename($item['url'])) ? 'text-[#106e39]' : 'text-gray-400'; ?>"></i>
                            <?php echo htmlspecialchars($item['name']); ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
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
