<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Newsletter Subscribers</h2>
        <p class="text-sm text-gray-500 mt-1">Manage users who subscribed to the newsletter.</p>
    </div>
    <div class="bg-white rounded-lg border border-gray-100 px-4 py-2 flex items-center gap-3 text-sm shadow-sm">
        <i class="fa-solid fa-envelope-open-text text-[#106e39]"></i>
        <span class="font-medium text-gray-600">Total Subscribers: <span id="total-count-badge" class="font-bold text-gray-800">...</span></span>
    </div>
</div>

<!-- Filters & Search -->
<div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm mb-6 flex flex-col md:flex-row gap-4 items-end">
    <div class="w-full md:w-1/2">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Search Subscribers</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-search text-gray-400"></i>
            </div>
            <input type="text" id="search-input" placeholder="Search by email..." class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
        </div>
    </div>
    
    <div class="w-full md:w-1/4">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Filter by Status</label>
        <select id="status-filter" class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
            <option value="">All Statuses</option>
            <option value="1">Subscribed (Active)</option>
            <option value="0">Unsubscribed (Inactive)</option>
        </select>
    </div>
</div>

<!-- Subscribers Table -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="subscribers-table">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500">
                    <th class="px-6 py-4 font-bold">Email</th>
                    <th class="px-6 py-4 font-bold">Subscribed Date</th>
                    <th class="px-6 py-4 font-bold text-center">Status</th>
                    <th class="px-6 py-4 font-bold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm" id="subscribers-tbody">
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                        <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
                        <p>Loading subscribers...</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Empty State -->
    <div id="empty-state" class="hidden flex-col items-center justify-center p-12 text-center">
        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 text-2xl mb-4">
            <i class="fa-solid fa-envelope-open-text"></i>
        </div>
        <h3 class="font-bold text-gray-800 text-lg mb-1">No subscribers found</h3>
        <p class="text-sm text-gray-500 max-w-sm">No one matches your search, or the mailing list is currently empty.</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let allSubscribers = [];
    
    const tbody = document.getElementById('subscribers-tbody');
    const emptyState = document.getElementById('empty-state');
    const tableHeader = document.querySelector('thead');
    const searchInput = document.getElementById('search-input');
    const statusFilter = document.getElementById('status-filter');
    const totalCountBadge = document.getElementById('total-count-badge');

    async function fetchSubscribers() {
        try {
            const res = await window.HBM_API.request('/admin/newsletter-subscribers');
            if (res.data && res.data.data) {
                allSubscribers = res.data.data;
                totalCountBadge.textContent = res.data.meta?.total || allSubscribers.length;
                renderSubscribers();
            }
        } catch (error) {
            console.error("Failed to fetch subscribers", error);
            tbody.innerHTML = `<tr><td colspan="4" class="px-6 py-8 text-center text-red-500 font-medium">Failed to load subscribers.</td></tr>`;
        }
    }
    
    function renderSubscribers() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusTerm = statusFilter.value;
        
        const filtered = allSubscribers.filter(s => {
            const matchesSearch = s.email.toLowerCase().includes(searchTerm);
            const matchesStatus = statusTerm === '' || s.is_active == statusTerm;
            
            return matchesSearch && matchesStatus;
        });
        
        if (filtered.length === 0) {
            tbody.innerHTML = '';
            tableHeader.style.display = allSubscribers.length === 0 ? 'none' : 'table-header-group';
            emptyState.classList.remove('hidden');
            emptyState.classList.add('flex');
            return;
        }
        
        emptyState.classList.add('hidden');
        emptyState.classList.remove('flex');
        tableHeader.style.display = 'table-header-group';
        
        tbody.innerHTML = filtered.map(s => {
            const statusBadge = s.is_active 
                ? '<span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider bg-green-100 text-green-700 border border-green-200">Subscribed</span>'
                : '<span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-500 border border-gray-200">Unsubscribed</span>';
                
            const date = new Date(s.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
            
            return `
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-800">
                        <a href="mailto:${s.email}" class="hover:text-[#106e39] transition-colors">${s.email}</a>
                    </td>
                    <td class="px-6 py-4 text-xs text-gray-500 font-mono">${date}</td>
                    <td class="px-6 py-4 text-center">${statusBadge}</td>
                    <td class="px-6 py-4 text-right">
                        <button onclick="toggleSubscriber(${s.id}, ${s.is_active})" class="px-3 py-1.5 text-xs font-bold ${s.is_active ? 'text-orange-600 bg-orange-50 hover:bg-orange-100 border-orange-200' : 'text-green-600 bg-green-50 hover:bg-green-100 border-green-200'} rounded-lg transition-colors border" title="${s.is_active ? 'Unsubscribe User' : 'Resubscribe User'}">
                            ${s.is_active ? 'Unsubscribe' : 'Resubscribe'}
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
    }
    
    window.toggleSubscriber = async function(id, currentStatus) {
        if (!confirm(`Are you sure you want to ${currentStatus ? 'unsubscribe' : 'resubscribe'} this user?`)) return;
        
        try {
            await window.HBM_API.request(`/admin/newsletter-subscribers/${id}`, 'PUT', { is_active: currentStatus ? 0 : 1 });
            fetchSubscribers();
        } catch (err) {
            alert(err.message || 'An error occurred while updating the status.');
        }
    };
    
    // Search & Filter Listeners
    searchInput.addEventListener('input', renderSubscribers);
    statusFilter.addEventListener('change', renderSubscribers);
    
    fetchSubscribers();
});
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
