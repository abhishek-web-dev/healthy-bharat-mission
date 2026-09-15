document.addEventListener('DOMContentLoaded', () => {
    // 1. Mobile Sidebar Logic
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const mobileSidebarOverlay = document.getElementById('mobile-sidebar-overlay');
    const desktopSidebar = document.querySelector('aside.hidden.md\\:flex');

    if (mobileSidebar && desktopSidebar) {
        // Clone the contents of desktop sidebar into mobile sidebar to keep it DRY
        mobileSidebar.innerHTML = desktopSidebar.innerHTML;
        
        // Add Close Button to Mobile Sidebar
        const headerDiv = mobileSidebar.querySelector('.h-16');
        if (headerDiv) {
            const closeBtn = document.createElement('button');
            closeBtn.className = 'w-10 h-10 rounded-lg text-gray-500 hover:bg-gray-50 flex items-center justify-center ml-auto';
            closeBtn.innerHTML = '<i class="fa-solid fa-times text-lg"></i>';
            closeBtn.onclick = closeMobileSidebar;
            headerDiv.appendChild(closeBtn);
        }
    }

    function openMobileSidebar() {
        if (!mobileSidebar) return;
        mobileSidebarOverlay.classList.remove('hidden');
        // Small delay to allow display:block to apply before animating transform
        setTimeout(() => {
            mobileSidebar.classList.remove('-translate-x-full');
        }, 10);
    }

    function closeMobileSidebar() {
        if (!mobileSidebar) return;
        mobileSidebar.classList.add('-translate-x-full');
        setTimeout(() => {
            mobileSidebarOverlay.classList.add('hidden');
        }, 300); // Wait for transition to finish
    }

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', openMobileSidebar);
    }
    
    if (mobileSidebarOverlay) {
        mobileSidebarOverlay.addEventListener('click', closeMobileSidebar);
    }

    // 2. Logout Logic
    const logoutBtn = document.getElementById('admin-logout-btn');
    if (logoutBtn && window.HBM_API) {
        logoutBtn.addEventListener('click', async () => {
            if (!confirm('Are you sure you want to log out?')) return;
            
            try {
                // Call backend logout API
                await window.HBM_API.auth.logout();
            } catch (err) {
                console.error("Logout error", err);
            } finally {
                // Remove token and clear cookie
                window.HBM_API.setToken(null);
                document.cookie = "auth_token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                window.location.href = 'login.php';
            }
        });
    }
});
