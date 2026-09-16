<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Programs Management</h2>
        <p class="text-sm text-gray-500 mt-1">Create and manage health and fitness programs.</p>
    </div>
    <div class="flex items-center gap-3">
        <div class="bg-white rounded-lg border border-gray-100 px-4 py-2 flex items-center gap-3 text-sm shadow-sm">
            <i class="fa-solid fa-dumbbell text-[#106e39]"></i>
            <span class="font-medium text-gray-600">Total Programs: <span id="total-count-badge" class="font-bold text-gray-800">...</span></span>
        </div>
        <button onclick="openProgramModal()" class="bg-[#106e39] text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-[#0b5028] transition-colors flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Add Program
        </button>
    </div>
</div>

<!-- Filters & Search -->
<div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm mb-6 flex flex-col md:flex-row gap-4 items-end">
    <div class="w-full md:w-1/2">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Search Programs</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-search text-gray-400"></i>
            </div>
            <input type="text" id="search-input" placeholder="Search by title or slug..." class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
        </div>
    </div>
    
    <div class="w-full md:w-1/4">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Filter by Price</label>
        <select id="price-filter" class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
            <option value="">All Programs</option>
            <option value="paid">Paid Only</option>
            <option value="free">Free Only</option>
        </select>
    </div>
    
    <div class="w-full md:w-1/4">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Filter by Status</label>
        <select id="status-filter" class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
            <option value="">All Statuses</option>
            <option value="1">Active</option>
            <option value="0">Draft / Inactive</option>
        </select>
    </div>
</div>

<!-- Programs Table -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="programs-table">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500">
                    <th class="px-6 py-4 font-bold">ID</th>
                    <th class="px-6 py-4 font-bold">Program</th>
                    <th class="px-6 py-4 font-bold">Price</th>
                    <th class="px-6 py-4 font-bold text-center">Status</th>
                    <th class="px-6 py-4 font-bold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm" id="programs-tbody">
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
                        <p>Loading programs...</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Empty State -->
    <div id="empty-state" class="hidden flex-col items-center justify-center p-12 text-center">
        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 text-2xl mb-4">
            <i class="fa-solid fa-dumbbell"></i>
        </div>
        <h3 class="font-bold text-gray-800 text-lg mb-1">No programs found</h3>
        <p class="text-sm text-gray-500 max-w-sm">No programs matched your search or you haven't added any yet.</p>
    </div>
</div>

<!-- Add/Edit Program Modal -->
<div id="program-modal" class="fixed inset-0 bg-gray-900/50 z-50 hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-300 overflow-y-auto pt-16 pb-16">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl overflow-hidden transform scale-95 transition-transform duration-300" id="program-modal-content">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50 sticky top-0 z-10">
            <h3 class="text-lg font-bold text-gray-800" id="modal-title">Add Program</h3>
            <button id="close-modal-btn" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
        
        <div class="p-6 max-h-[70vh] overflow-y-auto custom-scrollbar">
            <div id="modal-error" class="hidden mb-4 p-3 rounded-lg bg-red-50 text-red-600 text-sm font-medium border border-red-100"></div>
            
            <form id="program-form" class="space-y-5">
                <input type="hidden" id="program-id" value="">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Program Title *</label>
                            <input type="text" id="program-title" required class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors">
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Slug *</label>
                            <input type="text" id="program-slug" required class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors" placeholder="e.g. diabetes-reversal">
                            <p class="text-[10px] text-gray-400 mt-1">Used in the URL (must be unique, no spaces).</p>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Description</label>
                            <textarea id="program-description" rows="5" class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors custom-scrollbar"></textarea>
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Price (₹) *</label>
                                <input type="number" step="0.01" min="0" id="program-price" value="0" required class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors disabled:opacity-50">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Image URL</label>
                            <input type="text" id="program-image" class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors" placeholder="/assets/images/programs/banner.jpg">
                            <p class="text-[10px] text-gray-400 mt-1">Relative or absolute URL to the program banner.</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-3">
                            <label class="flex items-center gap-3">
                                <input type="checkbox" id="program-free" class="w-4 h-4 text-[#106e39] bg-white border-gray-300 rounded focus:ring-[#106e39]">
                                <span class="text-sm font-bold text-gray-700">Is Free?</span>
                            </label>
                            <label class="flex items-center gap-3">
                                <input type="checkbox" id="program-active" checked class="w-4 h-4 text-[#106e39] bg-white border-gray-300 rounded focus:ring-[#106e39]">
                                <span class="text-sm font-bold text-gray-700">Active (Visible to users)</span>
                            </label>
                        </div>
                        
                        <div class="bg-orange-50 p-3 rounded-lg border border-orange-100 flex gap-3 text-sm text-orange-800">
                            <i class="fa-solid fa-circle-info mt-0.5"></i>
                            <p><strong>Note on Modules:</strong> Program Modules are currently managed via the database directly. A full module builder UI is planned for a future enhancement.</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-100 flex justify-end gap-3 sticky bottom-0 bg-white">
                    <button type="button" id="cancel-modal-btn" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors">Cancel</button>
                    <button type="submit" id="save-program-btn" class="px-4 py-2 bg-[#106e39] border border-transparent rounded-lg text-sm font-bold text-white hover:bg-[#0b5028] transition-colors flex items-center gap-2">
                        <span id="save-btn-text">Save Program</span>
                        <i id="save-btn-spinner" class="fa-solid fa-spinner fa-spin hidden"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let allPrograms = [];
    
    const tbody = document.getElementById('programs-tbody');
    const emptyState = document.getElementById('empty-state');
    const tableHeader = document.querySelector('thead');
    const searchInput = document.getElementById('search-input');
    const statusFilter = document.getElementById('status-filter');
    const priceFilter = document.getElementById('price-filter');
    const totalCountBadge = document.getElementById('total-count-badge');
    
    // Modal Elements
    const modal = document.getElementById('program-modal');
    const modalContent = document.getElementById('program-modal-content');
    const closeBtn = document.getElementById('close-modal-btn');
    const cancelBtn = document.getElementById('cancel-modal-btn');
    const form = document.getElementById('program-form');
    const errorMsg = document.getElementById('modal-error');
    
    // Free Checkbox Toggle Logic
    const freeCheckbox = document.getElementById('program-free');
    const priceInput = document.getElementById('program-price');
    
    freeCheckbox.addEventListener('change', (e) => {
        if (e.target.checked) {
            priceInput.value = 0;
            priceInput.disabled = true;
        } else {
            priceInput.disabled = false;
        }
    });

    // Auto-generate slug from name
    document.getElementById('program-title').addEventListener('input', function(e) {
        if (!document.getElementById('program-id').value) {
            const slug = e.target.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
            document.getElementById('program-slug').value = slug;
        }
    });

    async function fetchPrograms() {
        try {
            // Using the admin endpoint that we verified returns { data: [...], meta: {...} }
            const res = await window.HBM_API.request('/admin/programs');
            if (res.data && res.data.data) {
                allPrograms = res.data.data;
                totalCountBadge.textContent = res.data.meta.total || allPrograms.length;
                renderPrograms();
            }
        } catch (error) {
            console.error("Failed to fetch programs", error);
            tbody.innerHTML = `<tr><td colspan="5" class="px-6 py-8 text-center text-red-500 font-medium">Failed to load programs.</td></tr>`;
        }
    }
    
    function formatCurrency(amount) {
        return new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' }).format(amount);
    }
    
    function renderPrograms() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusTerm = statusFilter.value;
        const priceTerm = priceFilter.value;
        
        const filtered = allPrograms.filter(p => {
            const matchesSearch = p.title.toLowerCase().includes(searchTerm) || p.slug.toLowerCase().includes(searchTerm);
            const matchesStatus = statusTerm === '' || p.is_active == statusTerm;
            
            let matchesPrice = true;
            if (priceTerm === 'paid') matchesPrice = p.is_free == 0;
            if (priceTerm === 'free') matchesPrice = p.is_free == 1;
            
            return matchesSearch && matchesStatus && matchesPrice;
        });
        
        if (filtered.length === 0) {
            tbody.innerHTML = '';
            tableHeader.style.display = allPrograms.length === 0 ? 'none' : 'table-header-group';
            emptyState.classList.remove('hidden');
            emptyState.classList.add('flex');
            return;
        }
        
        emptyState.classList.add('hidden');
        emptyState.classList.remove('flex');
        tableHeader.style.display = 'table-header-group';
        
        tbody.innerHTML = filtered.map(p => {
            const statusBadge = p.is_active 
                ? '<span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider bg-green-100 text-green-700 border border-green-200">Active</span>'
                : '<span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-500 border border-gray-200">Draft</span>';
                
            const priceDisplay = p.is_free == 1 
                ? '<span class="text-green-600 font-bold uppercase text-xs">Free</span>' 
                : `<span class="font-bold text-gray-800">${formatCurrency(p.price)}</span>`;
                
            const imgUrl = p.image_url || '../assets/images/programs/program-placeholder.jpg';
            
            return `
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-gray-500 font-mono text-xs">#${p.id}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-10 rounded bg-gray-100 border border-gray-200 overflow-hidden shrink-0">
                                <img src="${imgUrl}" alt="${p.title}" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='../assets/images/programs/program-placeholder.jpg'">
                            </div>
                            <div>
                                <p class="font-bold text-gray-800 text-sm truncate max-w-[250px]" title="${p.title}">${p.title}</p>
                                <p class="text-[11px] text-gray-500 truncate max-w-[250px]">/${p.slug}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm">${priceDisplay}</td>
                    <td class="px-6 py-4 text-center">${statusBadge}</td>
                    <td class="px-6 py-4 text-right">
                        <button onclick="openProgramModal(${p.id})" class="p-2 text-gray-400 hover:text-[#106e39] hover:bg-[#f2fbf5] rounded-lg transition-colors" title="Edit Program">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
    }
    
    window.openProgramModal = function(id = null) {
        errorMsg.classList.add('hidden');
        form.reset();
        priceInput.disabled = false;
        
        if (id) {
            // Edit Mode
            document.getElementById('modal-title').textContent = 'Edit Program';
            const p = allPrograms.find(x => x.id === id);
            if (!p) return;
            
            document.getElementById('program-id').value = p.id;
            document.getElementById('program-title').value = p.title;
            document.getElementById('program-slug').value = p.slug;
            document.getElementById('program-description').value = p.description || '';
            document.getElementById('program-price').value = p.price;
            document.getElementById('program-image').value = p.image_url || '';
            document.getElementById('program-active').checked = p.is_active == 1;
            
            const isFree = p.is_free == 1;
            document.getElementById('program-free').checked = isFree;
            if (isFree) priceInput.disabled = true;
            
        } else {
            // Add Mode
            document.getElementById('modal-title').textContent = 'Add Program';
            document.getElementById('program-id').value = '';
            document.getElementById('program-active').checked = true;
        }
        
        // Show Modal
        modal.classList.remove('hidden');
        void modal.offsetWidth;
        modal.classList.remove('opacity-0');
        modalContent.classList.remove('scale-95');
    };
    
    function closeModal() {
        modal.classList.add('opacity-0');
        modalContent.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
    
    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);
    
    // Search & Filter Listeners
    searchInput.addEventListener('input', renderPrograms);
    statusFilter.addEventListener('change', renderPrograms);
    priceFilter.addEventListener('change', renderPrograms);
    
    // Form Submit
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const id = document.getElementById('program-id').value;
        const payload = {
            title: document.getElementById('program-title').value.trim(),
            slug: document.getElementById('program-slug').value.trim(),
            description: document.getElementById('program-description').value.trim(),
            price: document.getElementById('program-price').value,
            image_url: document.getElementById('program-image').value.trim(),
            is_free: document.getElementById('program-free').checked ? 1 : 0,
            is_active: document.getElementById('program-active').checked ? 1 : 0,
        };
        
        const btnText = document.getElementById('save-btn-text');
        const btnSpinner = document.getElementById('save-btn-spinner');
        const submitBtn = document.getElementById('save-program-btn');
        
        submitBtn.disabled = true;
        btnText.textContent = 'Saving...';
        btnSpinner.classList.remove('hidden');
        errorMsg.classList.add('hidden');
        
        try {
            if (id) {
                await window.HBM_API.request(`/admin/programs/${id}`, 'PUT', payload);
            } else {
                await window.HBM_API.request('/admin/programs', 'POST', payload);
            }
            closeModal();
            fetchPrograms();
        } catch (err) {
            errorMsg.textContent = err.message || 'An error occurred while saving the program.';
            errorMsg.classList.remove('hidden');
        } finally {
            submitBtn.disabled = false;
            btnText.textContent = 'Save Program';
            btnSpinner.classList.add('hidden');
        }
    });

    fetchPrograms();
});
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
