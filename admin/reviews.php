<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Customer Reviews</h2>
        <p class="text-sm text-gray-500 mt-1">Approve or reject customer reviews before they go public.</p>
    </div>
    <div class="flex items-center gap-3">
        <button onclick="refreshData()" id="refresh-btn" class="bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium text-sm hover:bg-gray-50 hover:text-gray-900 transition-colors flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-arrows-rotate"></i> Refresh
        </button>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 flex flex-col relative overflow-hidden">
        <div class="absolute top-0 right-0 p-4 opacity-5">
            <i class="fa-solid fa-clock text-6xl text-orange-500"></i>
        </div>
        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Pending Review</p>
        <h3 class="text-3xl font-extrabold text-gray-800" id="count-pending">-</h3>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 flex flex-col relative overflow-hidden">
        <div class="absolute top-0 right-0 p-4 opacity-5">
            <i class="fa-solid fa-check-circle text-6xl text-[#106e39]"></i>
        </div>
        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Approved</p>
        <h3 class="text-3xl font-extrabold text-[#106e39]" id="count-approved">-</h3>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 flex flex-col relative overflow-hidden">
        <div class="absolute top-0 right-0 p-4 opacity-5">
            <i class="fa-solid fa-times-circle text-6xl text-red-500"></i>
        </div>
        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Rejected</p>
        <h3 class="text-3xl font-extrabold text-red-600" id="count-rejected">-</h3>
    </div>
</div>

<!-- Toolbar -->
<div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center mb-6">
    <div class="relative w-full md:w-96">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="fa-solid fa-search text-gray-400"></i>
        </div>
        <input type="text" id="search-input" placeholder="Search by product, SKU, or reviewer..." 
               class="pl-10 w-full rounded-lg border-gray-200 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 transition-all text-sm py-2.5">
    </div>
    <div class="w-full md:w-auto flex items-center gap-3">
        <select id="status-filter" class="rounded-lg border-gray-200 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 transition-all text-sm py-2.5 min-w-[150px]">
            <option value="all">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
        </select>
    </div>
</div>

<!-- Main Table -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mb-6">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500">
                    <th class="px-6 py-4 font-bold">Product</th>
                    <th class="px-6 py-4 font-bold">Reviewer</th>
                    <th class="px-6 py-4 font-bold">Rating & Title</th>
                    <th class="px-6 py-4 font-bold">Status</th>
                    <th class="px-6 py-4 font-bold">Date</th>
                    <th class="px-6 py-4 font-bold text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm" id="reviews-tbody">
                <!-- Skeleton Loader -->
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                        <i class="fa-solid fa-circle-notch fa-spin text-3xl mb-3 text-[#106e39]"></i>
                        <p class="font-medium text-gray-500">Loading reviews...</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination Footer -->
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between">
        <p class="text-sm text-gray-500" id="pagination-info">Showing latest reviews</p>
        <div class="flex items-center gap-2" id="pagination-controls">
            <!-- Future pagination buttons can go here -->
        </div>
    </div>
</div>

<script>
let searchTimeout;

document.addEventListener('DOMContentLoaded', () => {
    loadData();
    
    document.getElementById('search-input').addEventListener('input', (e) => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(loadReviews, 400); // debounce
    });
    
    document.getElementById('status-filter').addEventListener('change', loadReviews);
});

function refreshData() {
    const btn = document.getElementById('refresh-btn');
    const icon = btn.querySelector('i');
    icon.classList.add('fa-spin');
    
    loadData().finally(() => {
        setTimeout(() => icon.classList.remove('fa-spin'), 500);
    });
}

function loadData() {
    return Promise.all([loadCounts(), loadReviews()]);
}

function loadCounts() {
    return window.HBM_API.request('/admin/reviews/counts')
        .then(res => {
            if (res.success && res.data.counts) {
                document.getElementById('count-pending').textContent = res.data.counts.pending || 0;
                document.getElementById('count-approved').textContent = res.data.counts.approved || 0;
                document.getElementById('count-rejected').textContent = res.data.counts.rejected || 0;
            }
        });
}

function loadReviews() {
    const tbody = document.getElementById('reviews-tbody');
    tbody.innerHTML = `
        <tr>
            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                <i class="fa-solid fa-circle-notch fa-spin text-3xl mb-3 text-[#106e39]"></i>
                <p class="font-medium text-gray-500">Loading reviews...</p>
            </td>
        </tr>
    `;
    
    const status = document.getElementById('status-filter').value;
    const search = document.getElementById('search-input').value;
    
    const params = new URLSearchParams();
    if (status !== 'all') params.append('status', status);
    if (search.trim()) params.append('search', search.trim());
    params.append('limit', 50);
    
    const url = `/admin/reviews?${params.toString()}`;
    
    return window.HBM_API.request(url)
        .then(res => {
            if (res.success) {
                renderTable(res.data.reviews);
            } else {
                showErrorState(res.message);
            }
        })
        .catch(err => {
            console.error(err);
            showErrorState('Failed to connect to the server.');
        });
}

function renderTable(reviews) {
    const tbody = document.getElementById('reviews-tbody');
    
    if (!reviews || reviews.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-16 text-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto text-gray-300 text-2xl mb-4">
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 text-lg mb-1">No reviews found</h3>
                    <p class="text-sm text-gray-500 max-w-sm mx-auto">Try changing your search or filter settings, or clear them to see all reviews.</p>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = reviews.map(r => {
        // Status Badge
        let statusBadge = '';
        if (r.status === 'approved') {
            statusBadge = `<span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-bold bg-green-50 text-green-700 border border-green-200">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Approved
            </span>`;
        } else if (r.status === 'rejected') {
            statusBadge = `<span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-bold bg-red-50 text-red-700 border border-red-200">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Rejected
            </span>`;
        } else {
            statusBadge = `<span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-bold bg-orange-50 text-orange-700 border border-orange-200">
                <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span> Pending
            </span>`;
        }
        
        // Stars
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= r.rating) stars += '<i class="fa-solid fa-star text-yellow-400"></i>';
            else stars += '<i class="fa-regular fa-star text-gray-300"></i>';
        }
        
        const dateObj = new Date(r.created_at);
        const dateStr = dateObj.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
        
        return `
            <tr class="hover:bg-gray-50/50 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded bg-gray-100 flex items-center justify-center overflow-hidden shrink-0">
                            ${r.product_image ? `<img src="${r.product_image}" class="w-full h-full object-cover">` : `<i class="fa-solid fa-box text-gray-400 text-xs"></i>`}
                        </div>
                        <div class="min-w-0">
                            <div class="font-medium text-gray-800 truncate max-w-[200px]" title="${r.product_name}">${r.product_name}</div>
                            <div class="text-xs text-gray-500">SKU: ${r.product_sku || 'N/A'}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-800">${r.reviewer_name}</div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-[10px] tracking-widest mb-1 flex gap-0.5">${stars}</div>
                    <div class="text-sm font-bold text-gray-800 truncate max-w-[200px]" title="${r.title}">${r.title}</div>
                </td>
                <td class="px-6 py-4">
                    ${statusBadge}
                </td>
                <td class="px-6 py-4 text-gray-500 text-sm">
                    ${dateStr}
                </td>
                <td class="px-6 py-4 text-right">
                    <a href="review-detail.php?id=${r.id}" class="inline-flex items-center justify-center w-8 h-8 rounded hover:bg-gray-100 text-gray-500 hover:text-[#106e39] transition-colors" title="View Review">
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </td>
            </tr>
        `;
    }).join('');
}

function showErrorState(message) {
    const tbody = document.getElementById('reviews-tbody');
    tbody.innerHTML = `
        <tr>
            <td colspan="6" class="px-6 py-12 text-center">
                <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center mx-auto text-red-500 text-xl mb-3">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <h3 class="font-bold text-gray-800 text-lg mb-1">Unable to load customer reviews</h3>
                <p class="text-sm text-gray-500 mb-4">${message}</p>
                <button onclick="loadReviews()" class="text-sm font-bold text-[#106e39] hover:underline">Retry</button>
            </td>
        </tr>
    `;
}
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
