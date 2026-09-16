<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Offers</h2>
        <p class="text-sm text-gray-500 mt-1">Manage products and the offers attached to them.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="add-offer.php" class="bg-[#106e39] text-white px-4 py-2 rounded-lg font-medium text-sm hover:bg-[#0c572b] transition-colors flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-plus"></i> Add New Offer
        </a>
    </div>
</div>

<!-- Toolbar -->
<div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center mb-6">
    <div class="relative w-full md:w-96">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="fa-solid fa-search text-gray-400"></i>
        </div>
        <input type="text" id="search-input" placeholder="Search offers or codes..." 
               class="pl-10 w-full rounded-lg border border-gray-200 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 transition-all text-sm py-2.5">
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
        <select id="status-filter" class="rounded-lg border border-gray-200 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 transition-all text-sm py-2.5 min-w-[140px]">
            <option value="all">All Statuses</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="expired">Expired</option>
        </select>
    </div>
</div>

<div id="content-loading" class="py-12 text-center text-gray-400">
    <i class="fa-solid fa-circle-notch fa-spin text-3xl mb-3 text-[#106e39]"></i>
    <p class="font-medium text-gray-500">Loading offers...</p>
</div>

<div id="content-error" class="hidden py-12 text-center">
    <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center mx-auto text-red-500 text-xl mb-3">
        <i class="fa-solid fa-triangle-exclamation"></i>
    </div>
    <h3 class="font-bold text-gray-800 text-lg mb-1">Unable to load offers.</h3>
    <button onclick="loadOffers()" class="text-sm font-bold text-[#106e39] hover:underline">Retry</button>
</div>

<!-- Grid View -->
<div id="offers-grid" class="hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-6">
    <!-- Grid items injected here -->
</div>

<!-- List View -->
<div id="offers-list" class="hidden bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mb-6">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500">
                    <th class="px-6 py-4 font-bold">Offer</th>
                    <th class="px-6 py-4 font-bold">Applied To</th>
                    <th class="px-6 py-4 font-bold">Status</th>
                    <th class="px-6 py-4 font-bold">Validity</th>
                    <th class="px-6 py-4 font-bold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm" id="offers-tbody">
                <!-- List items injected here -->
            </tbody>
        </table>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 bg-gray-900/50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 overflow-hidden transform scale-95 opacity-0 transition-all duration-200" id="delete-modal-content">
        <div class="p-6">
            <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center text-red-500 text-xl mb-4">
                <i class="fa-solid fa-trash"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Delete Offer?</h3>
            <p class="text-gray-500">Are you sure you want to delete this offer? This action cannot be undone.</p>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex gap-3 justify-end">
            <button onclick="closeDeleteModal()" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                Cancel
            </button>
            <button onclick="confirmDelete()" id="btn-confirm-delete" class="px-4 py-2 bg-red-600 text-white rounded-lg font-bold hover:bg-red-700 transition-colors flex items-center gap-2">
                Delete Offer
            </button>
        </div>
    </div>
</div>

<script>
let currentViewMode = 'grid';
let offersData = [];
let searchTimeout;
let deleteId = null;

document.addEventListener('DOMContentLoaded', () => {
    loadOffers();
    
    document.getElementById('search-input').addEventListener('input', () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(loadOffers, 400);
    });
    
    document.getElementById('status-filter').addEventListener('change', loadOffers);
});

function setViewMode(mode) {
    currentViewMode = mode;
    
    if (mode === 'grid') {
        document.getElementById('view-grid').classList.add('bg-white', 'text-gray-800', 'shadow-sm');
        document.getElementById('view-grid').classList.remove('text-gray-500');
        
        document.getElementById('view-list').classList.add('text-gray-500');
        document.getElementById('view-list').classList.remove('bg-white', 'text-gray-800', 'shadow-sm');
        
        document.getElementById('offers-grid').classList.remove('hidden');
        document.getElementById('offers-list').classList.add('hidden');
    } else {
        document.getElementById('view-list').classList.add('bg-white', 'text-gray-800', 'shadow-sm');
        document.getElementById('view-list').classList.remove('text-gray-500');
        
        document.getElementById('view-grid').classList.add('text-gray-500');
        document.getElementById('view-grid').classList.remove('bg-white', 'text-gray-800', 'shadow-sm');
        
        document.getElementById('offers-list').classList.remove('hidden');
        document.getElementById('offers-grid').classList.add('hidden');
    }
    
    if (offersData.length > 0) {
        renderOffers();
    }
}

function loadOffers() {
    document.getElementById('content-loading').classList.remove('hidden');
    document.getElementById('content-error').classList.add('hidden');
    document.getElementById('offers-grid').classList.add('hidden');
    document.getElementById('offers-list').classList.add('hidden');
    
    const status = document.getElementById('status-filter').value;
    const search = document.getElementById('search-input').value;
    
    const params = new URLSearchParams();
    if (status !== 'all') params.append('status', status);
    if (search.trim()) params.append('search', search.trim());
    params.append('limit', 100);
    
    window.HBM_API.request(`/admin/offers?${params.toString()}`)
        .then(res => {
            document.getElementById('content-loading').classList.add('hidden');
            if (res.success) {
                offersData = res.data.offers || [];
                renderOffers();
                
                if (currentViewMode === 'grid') {
                    document.getElementById('offers-grid').classList.remove('hidden');
                } else {
                    document.getElementById('offers-list').classList.remove('hidden');
                }
            } else {
                document.getElementById('content-error').classList.remove('hidden');
            }
        })
        .catch(err => {
            console.error(err);
            document.getElementById('content-loading').classList.add('hidden');
            document.getElementById('content-error').classList.remove('hidden');
        });
}

function getStatusBadge(status) {
    if (status === 'active') {
        return `<span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-bold bg-green-50 text-green-700 border border-green-200">
            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Active
        </span>`;
    } else if (status === 'expired') {
        return `<span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-bold bg-red-50 text-red-700 border border-red-200">
            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Expired
        </span>`;
    } else {
        return `<span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-bold bg-gray-100 text-gray-700 border border-gray-200">
            <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span> Inactive
        </span>`;
    }
}

function renderOffers() {
    const grid = document.getElementById('offers-grid');
    const tbody = document.getElementById('offers-tbody');
    
    if (offersData.length === 0) {
        const emptyState = `
            <div class="col-span-full py-16 text-center bg-white rounded-xl border border-gray-100 shadow-sm">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto text-gray-300 text-2xl mb-4">
                    <i class="fa-solid fa-tags"></i>
                </div>
                <h3 class="font-bold text-gray-800 text-lg mb-1">No offers found</h3>
                <p class="text-sm text-gray-500 mb-6">Create your first offer to get started.</p>
                <a href="add-offer.php" class="bg-[#106e39] text-white px-5 py-2.5 rounded-lg font-bold hover:bg-[#0c572b] transition-colors shadow-sm inline-flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Add New Offer
                </a>
            </div>
        `;
        grid.innerHTML = emptyState;
        tbody.innerHTML = `<tr><td colspan="5" class="p-0 border-0">${emptyState}</td></tr>`;
        return;
    }
    
    // Render Grid
    grid.innerHTML = offersData.map(o => {
        let appliedToText = 'All Products';
        if (o.applicable_to === 'products') appliedToText = `${o.targets.length} Product(s)`;
        if (o.applicable_to === 'categories') appliedToText = `${o.targets.length} Category(s)`;
        
        let valText = o.discount_type === 'percentage' ? `${o.discount_value}% OFF` : `₹${o.discount_value} OFF`;
        
        return `
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden flex flex-col hover:border-gray-300 transition-colors">
                <div class="p-5 border-b border-gray-50 bg-gray-50/50 flex justify-between items-start">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-orange-500 shrink-0">
                            <i class="fa-solid fa-ticket"></i>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">OFFER</span>
                            <h3 class="font-bold text-gray-900 truncate max-w-[150px]" title="${o.name}">${o.name}</h3>
                        </div>
                    </div>
                    ${getStatusBadge(o.status)}
                </div>
                <div class="p-5 flex-1">
                    <div class="text-2xl font-extrabold text-[#106e39] mb-2">${valText}</div>
                    <div class="text-sm text-gray-600 mb-1"><span class="font-medium">Code:</span> ${o.code || 'None'}</div>
                    <div class="text-sm text-gray-600"><span class="font-medium">Applied to:</span> ${appliedToText}</div>
                </div>
                <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-xs text-gray-500">${o.usage_limit ? `Limit: ${o.usage_limit}` : 'No Limit'}</span>
                    <div class="flex items-center gap-2">
                        <a href="edit-offer.php?id=${o.id}" class="w-8 h-8 rounded text-gray-500 hover:bg-gray-200 hover:text-gray-700 flex items-center justify-center transition-colors" title="Edit">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <button onclick="openDeleteModal(${o.id})" class="w-8 h-8 rounded text-gray-500 hover:bg-red-50 hover:text-red-600 flex items-center justify-center transition-colors" title="Delete">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
    }).join('');
    
    // Render List
    tbody.innerHTML = offersData.map(o => {
        let appliedToText = 'All Products';
        if (o.applicable_to === 'products') appliedToText = `${o.targets.length} Product(s)`;
        if (o.applicable_to === 'categories') appliedToText = `${o.targets.length} Category(s)`;
        
        let valText = o.discount_type === 'percentage' ? `${o.discount_value}% OFF` : `₹${o.discount_value} OFF`;
        
        let validity = 'Indefinite';
        if (o.start_date || o.end_date) {
            let start = o.start_date ? new Date(o.start_date).toLocaleDateString() : 'Now';
            let end = o.end_date ? new Date(o.end_date).toLocaleDateString() : 'Never';
            validity = `${start} - ${end}`;
        }
        
        return `
            <tr class="hover:bg-gray-50/50 transition-colors">
                <td class="px-6 py-4">
                    <div class="font-bold text-gray-900">${o.name}</div>
                    <div class="text-xs text-gray-500 flex items-center gap-2 mt-1">
                        <span class="font-bold text-[#106e39]">${valText}</span>
                        ${o.code ? `• Code: ${o.code}` : ''}
                    </div>
                </td>
                <td class="px-6 py-4 text-gray-700">${appliedToText}</td>
                <td class="px-6 py-4">${getStatusBadge(o.status)}</td>
                <td class="px-6 py-4 text-xs text-gray-500">${validity}</td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="edit-offer.php?id=${o.id}" class="w-8 h-8 rounded hover:bg-gray-100 text-gray-500 transition-colors flex items-center justify-center" title="Edit">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <button onclick="openDeleteModal(${o.id})" class="w-8 h-8 rounded hover:bg-red-50 text-gray-500 hover:text-red-600 transition-colors" title="Delete">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }).join('');
}

function openDeleteModal(id) {
    deleteId = id;
    showModal('delete-modal', 'delete-modal-content');
}

function closeDeleteModal() {
    deleteId = null;
    hideModal('delete-modal', 'delete-modal-content');
}

function confirmDelete() {
    if (!deleteId) return;
    
    const btn = document.getElementById('btn-confirm-delete');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> Deleting...`;
    
    window.HBM_API.request(`/admin/offers/${deleteId}`, 'DELETE')
        .then(res => {
            if (res.success) {
                closeDeleteModal();
                loadOffers();
                showNotification('Success', 'Offer deleted successfully.', 'success');
            } else {
                alert(res.message || "Failed to delete offer.");
            }
        })
        .catch(err => {
            console.error(err);
            alert("An error occurred. Please check your network and try again.");
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
}

// Modal Helpers
function showModal(backdropId, contentId) {
    const modal = document.getElementById(backdropId);
    const content = document.getElementById(contentId);
    modal.classList.remove('hidden');
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function hideModal(backdropId, contentId) {
    const modal = document.getElementById(backdropId);
    const content = document.getElementById(contentId);
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 200);
}

function showNotification(title, message, type='success') {
    const notification = document.createElement('div');
    notification.className = `fixed bottom-4 right-4 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white px-6 py-3 rounded-lg shadow-lg font-bold z-50 flex items-center gap-3 animate-fade-in-up`;
    notification.innerHTML = `<i class="fa-solid ${type === 'success' ? 'fa-check-circle' : 'fa-triangle-exclamation'}"></i> ${message}`;
    document.body.appendChild(notification);
    setTimeout(() => {
        notification.classList.add('opacity-0', 'translate-y-2', 'transition-all');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}
</script>

<style>
@keyframes fade-in-up {
    from { opacity: 0; transform: translateY(1rem); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-up {
    animation: fade-in-up 0.3s ease-out forwards;
}
</style>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
