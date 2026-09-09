document.addEventListener('DOMContentLoaded', async () => {
    // We expect api.js to be loaded
    if (!window.HBM_API) {
        console.error('API script missing');
        return;
    }

    if (!HBM_API.getToken()) {
        window.location.href = '../auth/login.html';
        return;
    }

    // Show loading state if main content exists
    const mainContent = document.getElementById('dashboard-main');
    if (mainContent) {
        mainContent.style.opacity = '0.5';
        mainContent.style.pointerEvents = 'none';
    }

    try {
        // Check auth status
        const res = await HBM_API.request('/auth/me');
        window.HBM_USER = res.data;
        
        if (mainContent) {
            mainContent.style.opacity = '1';
            mainContent.style.pointerEvents = 'auto';
        }

        // Dispatch event for individual pages to load their specific data
        document.dispatchEvent(new Event('hbm:auth-ready'));
    } catch (error) {
        console.error('Auth error:', error);
        
        if (error.status === 401) {
            // Token invalid or expired
            HBM_API.setToken(null);
            window.location.href = '../auth/login.html';
        } else {
            // Network or server error
            if (mainContent) {
                mainContent.style.opacity = '1';
                mainContent.style.pointerEvents = 'auto';
                mainContent.innerHTML = `
                    <div class="bg-red-50 text-red-600 p-6 rounded-2xl border border-red-100 flex flex-col items-center justify-center text-center">
                        <i class="fa-solid fa-triangle-exclamation text-4xl mb-4"></i>
                        <h3 class="text-lg font-bold mb-2">Connection Error</h3>
                        <p class="text-[14px]">We couldn't connect to the server to load your dashboard. Please check your internet connection or try again later.</p>
                        <button onclick="window.location.reload()" class="mt-4 px-6 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition-colors">Retry</button>
                    </div>
                `;
            }
        }
    }
});
