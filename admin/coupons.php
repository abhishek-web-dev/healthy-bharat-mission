<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Coupons</h2>
        <p class="text-gray-600 text-sm mt-1">Manage products and the coupons attached to them.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="add-coupon.php" class="bg-[#106e39] text-white px-4 py-2 rounded-lg font-medium text-sm hover:bg-[#0c572b] transition-colors flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-plus"></i> Add New Coupon
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
    <div class="relative w-full md:w-96">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="fa-solid fa-search text-gray-400"></i>
        </div>
        <input type="text" id="search-input" placeholder="Search by code or name..." 
               class="pl-10 w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 transition-all text-sm">
    </div>
    <div class="w-full md:w-auto flex items-center gap-3">
        <div class="bg-gray-100 p-1 rounded-lg flex items-center shrink-0">
            <button onclick="setViewMode('grid')" id="view-grid" class="px-3 py-1.5 rounded-md text-sm font-medium transition-colors bg-white text-gray-800 shadow-sm">
                <i class="fa-solid fa-border-all"></i> <span class="sr-only">Grid View</span>
            </button>
            <button onclick="setViewMode('list')" id="view-list" class="px-3 py-1.5 rounded-md text-sm font-medium transition-colors text-gray-500 hover:text-gray-700">
                <i class="fa-solid fa-list-ul"></i> <span class="sr-only">List View</span>
            </button>
        </div>
        <select id="status-filter" class="px-4 py-2.5 rounded-lg border border-gray-200 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 transition-all text-sm min-w-[140px]">
            <option value="all">All Statuses</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="expired">Expired</option>
        </select>
    </div>
</div>

<div id="loading-state" class="py-12 flex justify-center hidden">
    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#106e39]"></div>
</div>

<div id="error-state" class="py-12 text-center hidden">
    <i class="fa-solid fa-circle-exclamation text-red-500 text-4xl mb-3"></i>
    <p id="error-message" class="text-gray-800 font-medium"></p>
    <button onclick="loadCoupons()" class="mt-4 text-[#106e39] font-medium hover:underline text-sm">Retry</button>
</div>

<!-- Grid View -->
<div id="grid-view" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    <!-- Populated by JS -->
</div>

<!-- List View -->
<div id="list-view" class="hidden">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Coupon Code</th>
                        <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Discount</th>
                        <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Applied To</th>
                        <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="list-view-body" class="divide-y divide-gray-100">
                    <!-- Populated by JS -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Empty State -->
<div id="empty-state" class="hidden py-16 text-center bg-white rounded-xl shadow-sm border border-gray-100">
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-50 text-[#106e39] mb-4">
        <i class="fa-solid fa-ticket text-2xl"></i>
    </div>
    <h3 class="text-lg font-bold text-gray-800 mb-2">No coupons found</h3>
    <p class="text-gray-500 text-sm max-w-md mx-auto mb-6">Create your first coupon to offer discounts to customers.</p>
    <a href="add-coupon.php" class="bg-[#106e39] text-white px-5 py-2.5 rounded-lg font-medium text-sm hover:bg-[#0c572b] transition-colors inline-flex items-center gap-2 shadow-sm">
        <i class="fa-solid fa-plus"></i> Add New Coupon
    </a>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 bg-gray-900/50 z-50 hidden flex items-center justify-center backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-100 text-red-600 mb-4 mx-auto">
                <i class="fa-solid fa-triangle-exclamation text-xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 text-center mb-2">Delete Coupon?</h3>
            <p class="text-sm text-gray-500 text-center mb-6">Are you sure you want to delete this coupon? This action cannot be undone.</p>
            <div class="flex gap-3">
                <button type="button" onclick="closeDeleteModal()" class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                    Cancel
                </button>
                <button type="button" id="confirm-delete-btn" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition-colors">
                    Delete Coupon
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let allCoupons = [];
let currentView = 'grid';
let deleteCouponId = null;
let searchTimeout = null;

document.addEventListener('DOMContentLoaded', () => {
    loadCoupons();
    
    document.getElementById('search-input').addEventListener('input', (e) => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            loadCoupons();
        }, 300);
    });

    document.getElementById('status-filter').addEventListener('change', () => {
        loadCoupons();
    });
});

function setViewMode(mode) {
    currentView = mode;
    
    document.getElementById('view-grid').className = mode === 'grid' 
        ? 'px-3 py-1.5 rounded-md text-sm font-medium transition-colors bg-white text-gray-800 shadow-sm'
        : 'px-3 py-1.5 rounded-md text-sm font-medium transition-colors text-gray-500 hover:text-gray-700';
        
    document.getElementById('view-list').className = mode === 'list' 
        ? 'px-3 py-1.5 rounded-md text-sm font-medium transition-colors bg-white text-gray-800 shadow-sm'
        : 'px-3 py-1.5 rounded-md text-sm font-medium transition-colors text-gray-500 hover:text-gray-700';

    if (allCoupons.length > 0) {
        if (mode === 'grid') {
            document.getElementById('grid-view').classList.remove('hidden');
            document.getElementById('list-view').classList.add('hidden');
        } else {
            document.getElementById('grid-view').classList.add('hidden');
            document.getElementById('list-view').classList.remove('hidden');
        }
    }
}

function loadCoupons() {
    const search = document.getElementById('search-input').value;
    const status = document.getElementById('status-filter').value;

    document.getElementById('loading-state').classList.remove('hidden');
    document.getElementById('grid-view').classList.add('hidden');
    document.getElementById('list-view').classList.add('hidden');
    document.getElementById('empty-state').classList.add('hidden');
    document.getElementById('error-state').classList.add('hidden');

    window.HBM_API.request(`/admin/coupons?search=${encodeURIComponent(search)}&status=${encodeURIComponent(status)}`)
    .then(res => {
        document.getElementById('loading-state').classList.add('hidden');
        
        if (res.success || res.status === 'success') {
            allCoupons = res.data.coupons || [];
            renderCoupons();
        } else {
            showError(res.message || 'Failed to load coupons.');
        }
    })
    .catch(err => {
        console.error(err);
        document.getElementById('loading-state').classList.add('hidden');
        showError('Network error occurred. Please try again.');
    });
}

function showError(msg) {
    document.getElementById('error-message').innerText = msg;
    document.getElementById('error-state').classList.remove('hidden');
}

function getStatusBadge(status) {
    switch (status) {
        case 'active': return '<span class="bg-green-100 text-green-800 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">Active</span>';
        case 'inactive': return '<span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">Inactive</span>';
        case 'expired': return '<span class="bg-red-100 text-red-800 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">Expired</span>';
        default: return `<span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">${status}</span>`;
    }
}

function getDiscountText(type, value) {
    return type === 'percentage' ? `${value}% OFF` : `₹${value} OFF`;
}

function getApplicableText(appTo, targets) {
    if (appTo === 'all') return 'All Products';
    if (appTo === 'products') return `${targets.length} Products`;
    if (appTo === 'categories') return `${targets.length} Categories`;
    return appTo;
}

function renderCoupons() {
    const grid = document.getElementById('grid-view');
    const tbody = document.getElementById('list-view-body');
    
    grid.innerHTML = '';
    tbody.innerHTML = '';

    if (allCoupons.length === 0) {
        document.getElementById('empty-state').classList.remove('hidden');
        return;
    }

    if (currentView === 'grid') {
        grid.classList.remove('hidden');
    } else {
        document.getElementById('list-view').classList.remove('hidden');
    }

    allCoupons.forEach(coupon => {
        const statusBadge = getStatusBadge(coupon.status);
        const discountText = getDiscountText(coupon.discount_type, coupon.discount_value);
        const applicableText = getApplicableText(coupon.applicable_to, coupon.targets);
        const limitText = coupon.usage_limit ? `${coupon.usage_limit} limit` : 'Unlimited';

        // Grid Card
        grid.innerHTML += `
            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-shadow flex flex-col h-full">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center gap-2 bg-[#f8fcf9] border border-dashed border-[#106e39] px-3 py-1 rounded-md">
                        <i class="fa-solid fa-ticket text-[#106e39]"></i>
                        <span class="font-bold text-[#106e39] uppercase tracking-wider text-sm">${coupon.code}</span>
                    </div>
                    ${statusBadge}
                </div>
                
                <h3 class="font-bold text-gray-800 text-lg mb-1 truncate">${coupon.name}</h3>
                
                <div class="text-2xl font-black text-[#106e39] mb-4">${discountText}</div>
                
                <div class="space-y-2 mb-6 flex-grow">
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fa-solid fa-box w-4 text-center text-gray-400"></i>
                        <span>Applied to: <span class="font-medium text-gray-800">${applicableText}</span></span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fa-solid fa-infinity w-4 text-center text-gray-400"></i>
                        <span>Usage: <span class="font-medium text-gray-800">${limitText}</span></span>
                    </div>
                    ${coupon.end_date ? `
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fa-regular fa-calendar w-4 text-center text-gray-400"></i>
                        <span>Valid till: <span class="font-medium text-gray-800">${new Date(coupon.end_date).toLocaleDateString()}</span></span>
                    </div>` : ''}
                </div>
                
                <div class="flex gap-2 pt-4 border-t border-gray-100 mt-auto">
                    <a href="edit-coupon.php?id=${coupon.id}" class="flex-1 bg-gray-50 hover:bg-gray-100 text-gray-700 py-2 rounded-lg text-sm font-medium transition-colors text-center">
                        Edit
                    </a>
                    <button onclick="confirmDelete(${coupon.id})" class="flex-1 bg-red-50 hover:bg-red-100 text-red-600 py-2 rounded-lg text-sm font-medium transition-colors">
                        Delete
                    </button>
                </div>
            </div>
        `;

        // List Row
        tbody.innerHTML += `
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="py-3 px-4">
                    <div class="inline-flex items-center gap-1 bg-[#f8fcf9] border border-dashed border-[#106e39] px-2 py-0.5 rounded text-xs font-bold text-[#106e39]">
                        <i class="fa-solid fa-ticket"></i> ${coupon.code}
                    </div>
                </td>
                <td class="py-3 px-4">
                    <div class="font-medium text-gray-800 text-sm">${coupon.name}</div>
                    ${coupon.end_date ? `<div class="text-xs text-gray-500">Till ${new Date(coupon.end_date).toLocaleDateString()}</div>` : ''}
                </td>
                <td class="py-3 px-4 text-sm font-bold text-[#106e39]">${discountText}</td>
                <td class="py-3 px-4 text-sm text-gray-600">${applicableText}</td>
                <td class="py-3 px-4">${statusBadge}</td>
                <td class="py-3 px-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="edit-coupon.php?id=${coupon.id}" class="w-8 h-8 rounded-full bg-gray-50 text-gray-500 hover:text-[#106e39] hover:bg-[#106e39]/10 flex items-center justify-center transition-colors">
                            <i class="fa-solid fa-pen text-xs"></i>
                        </a>
                        <button onclick="confirmDelete(${coupon.id})" class="w-8 h-8 rounded-full bg-gray-50 text-gray-500 hover:text-red-600 hover:bg-red-50 flex items-center justify-center transition-colors">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });
}

function confirmDelete(id) {
    deleteCouponId = id;
    document.getElementById('delete-modal').classList.remove('hidden');
}

function closeDeleteModal() {
    deleteCouponId = null;
    document.getElementById('delete-modal').classList.add('hidden');
}

document.getElementById('confirm-delete-btn').addEventListener('click', () => {
    if (!deleteCouponId) return;
    
    const btn = document.getElementById('confirm-delete-btn');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i>';
    btn.disabled = true;

    window.HBM_API.request(`/admin/coupons/${deleteCouponId}`, 'DELETE')
    .then(res => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        closeDeleteModal();
        
        if (res.success || res.status === 'success') {
            loadCoupons();
        } else {
            alert(res.message || 'Failed to delete coupon.');
        }
    })
    .catch(err => {
        console.error(err);
        btn.innerHTML = originalText;
        btn.disabled = false;
        closeDeleteModal();
        alert('Network error occurred.');
    });
});
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
