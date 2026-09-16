<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Health Conditions</h2>
        <p class="text-sm text-gray-500 mt-1">Manage health conditions available in user profiles and library.</p>
    </div>
    <div class="flex items-center gap-3">
        <div class="bg-white rounded-lg border border-gray-100 px-4 py-2 flex items-center gap-3 text-sm shadow-sm">
            <i class="fa-solid fa-notes-medical text-[#106e39]"></i>
            <span class="font-medium text-gray-600">Total Conditions: <span id="total-count-badge" class="font-bold text-gray-800">...</span></span>
        </div>
        <button onclick="openConditionModal()" class="bg-[#106e39] text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-[#0b5028] transition-colors flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Add Condition
        </button>
    </div>
</div>

<!-- Filters & Search -->
<div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm mb-6 flex flex-col md:flex-row gap-4 items-end">
    <div class="w-full md:w-1/2">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Search Conditions</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-search text-gray-400"></i>
            </div>
            <input type="text" id="search-input" placeholder="Search by name or slug..." class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
        </div>
    </div>
    
    <div class="w-full md:w-1/4">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Filter by Status</label>
        <select id="status-filter" class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
            <option value="">All Statuses</option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>
    </div>
</div>

<!-- Conditions Table -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="conditions-table">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500">
                    <th class="px-6 py-4 font-bold">ID</th>
                    <th class="px-6 py-4 font-bold">Condition</th>
                    <th class="px-6 py-4 font-bold text-center">Status</th>
                    <th class="px-6 py-4 font-bold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm" id="conditions-tbody">
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                        <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
                        <p>Loading conditions...</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Empty State -->
    <div id="empty-state" class="hidden flex-col items-center justify-center p-12 text-center">
        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 text-2xl mb-4">
            <i class="fa-solid fa-notes-medical"></i>
        </div>
        <h3 class="font-bold text-gray-800 text-lg mb-1">No conditions found</h3>
        <p class="text-sm text-gray-500 max-w-sm">No conditions matched your search or you haven't added any yet.</p>
    </div>
</div>

<!-- Add/Edit Condition Modal -->
<div id="condition-modal" class="fixed inset-0 bg-gray-900/50 z-50 hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-300 overflow-y-auto pt-16 pb-16">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl overflow-hidden transform scale-95 transition-transform duration-300" id="condition-modal-content">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50 sticky top-0 z-10">
            <h3 class="text-lg font-bold text-gray-800" id="modal-title">Add Health Condition</h3>
            <button id="close-modal-btn" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
        
        <div class="p-6 max-h-[70vh] overflow-y-auto custom-scrollbar">
            <div id="modal-error" class="hidden mb-4 p-3 rounded-lg bg-red-50 text-red-600 text-sm font-medium border border-red-100"></div>
            
            <form id="condition-form" class="space-y-5">
                <input type="hidden" id="condition-id" value="">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Condition Name *</label>
                            <input type="text" id="condition-name" required class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors">
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">URL Slug *</label>
                            <input type="text" id="condition-slug" required class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors" placeholder="e.g. type-2-diabetes">
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Description (HTML Content)</label>
                            <textarea id="condition-description" rows="6" class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm font-mono transition-colors custom-scrollbar" placeholder="<p>Information about the condition...</p>"></textarea>
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Image URL</label>
                            <input type="text" id="condition-image" class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors" placeholder="/assets/images/conditions/banner.jpg">
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-3">
                            <label class="flex items-center gap-3">
                                <input type="checkbox" id="condition-active" checked class="w-4 h-4 text-[#106e39] bg-white border-gray-300 rounded focus:ring-[#106e39]">
                                <span class="text-sm font-bold text-gray-700">Active (Visible)</span>
                            </label>
                            <p class="text-xs text-gray-500 mt-2"><i class="fa-solid fa-triangle-exclamation text-yellow-500 mr-1"></i> If inactive, it will be hidden from the public library, but remains linked to users who already selected it.</p>
                        </div>
                        
                        <div class="bg-red-50 p-3 rounded-lg border border-red-100 flex gap-3 text-sm text-red-800">
                            <i class="fa-solid fa-ban mt-0.5"></i>
                            <p><strong>No Deletion Allowed:</strong> Conditions cannot be permanently deleted to prevent corrupting existing user health profiles.</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-100 flex justify-end gap-3 sticky bottom-0 bg-white">
                    <button type="button" id="cancel-modal-btn" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors">Cancel</button>
                    <button type="submit" id="save-condition-btn" class="px-6 py-2 bg-[#106e39] border border-transparent rounded-lg text-sm font-bold text-white hover:bg-[#0b5028] transition-colors flex items-center gap-2">
                        <span id="save-btn-text">Save Condition</span>
                        <i id="save-btn-spinner" class="fa-solid fa-spinner fa-spin hidden"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let allConditions = [];
    
    const tbody = document.getElementById('conditions-tbody');
    const emptyState = document.getElementById('empty-state');
    const tableHeader = document.querySelector('thead');
    const searchInput = document.getElementById('search-input');
    const statusFilter = document.getElementById('status-filter');
    const totalCountBadge = document.getElementById('total-count-badge');
    
    // Modal Elements
    const modal = document.getElementById('condition-modal');
    const modalContent = document.getElementById('condition-modal-content');
    const closeBtn = document.getElementById('close-modal-btn');
    const cancelBtn = document.getElementById('cancel-modal-btn');
    const form = document.getElementById('condition-form');
    const errorMsg = document.getElementById('modal-error');

    // Auto-generate slug from name
    document.getElementById('condition-name').addEventListener('input', function(e) {
        if (!document.getElementById('condition-id').value) {
            const slug = e.target.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
            document.getElementById('condition-slug').value = slug;
        }
    });

    async function fetchConditions() {
        try {
            const res = await window.HBM_API.request('/admin/health-conditions');
            if (res.data && res.data.data) {
                allConditions = res.data.data;
                totalCountBadge.textContent = res.data.meta.total || allConditions.length;
                renderConditions();
            }
        } catch (error) {
            console.error("Failed to fetch conditions", error);
            tbody.innerHTML = `<tr><td colspan="4" class="px-6 py-8 text-center text-red-500 font-medium">Failed to load health conditions.</td></tr>`;
        }
    }
    
    function renderConditions() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusTerm = statusFilter.value;
        
        const filtered = allConditions.filter(c => {
            const matchesSearch = c.name.toLowerCase().includes(searchTerm) || c.slug.toLowerCase().includes(searchTerm);
            const matchesStatus = statusTerm === '' || c.is_active == statusTerm;
            
            return matchesSearch && matchesStatus;
        });
        
        if (filtered.length === 0) {
            tbody.innerHTML = '';
            tableHeader.style.display = allConditions.length === 0 ? 'none' : 'table-header-group';
            emptyState.classList.remove('hidden');
            emptyState.classList.add('flex');
            return;
        }
        
        emptyState.classList.add('hidden');
        emptyState.classList.remove('flex');
        tableHeader.style.display = 'table-header-group';
        
        tbody.innerHTML = filtered.map(c => {
            const statusBadge = c.is_active 
                ? '<span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider bg-green-100 text-green-700 border border-green-200">Active</span>'
                : '<span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-500 border border-gray-200">Inactive</span>';
                
            const imgUrl = c.image_url || '../assets/images/conditions/placeholder.jpg';
            
            return `
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-gray-500 font-mono text-xs">#${c.id}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-10 rounded bg-gray-100 border border-gray-200 overflow-hidden shrink-0">
                                <img src="${imgUrl}" alt="${c.name}" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='../assets/images/conditions/placeholder.jpg'">
                            </div>
                            <div>
                                <p class="font-bold text-gray-800 text-sm truncate max-w-[250px]" title="${c.name}">${c.name}</p>
                                <p class="text-[11px] text-gray-500 truncate max-w-[250px]">/${c.slug}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">${statusBadge}</td>
                    <td class="px-6 py-4 text-right">
                        <button onclick="openConditionModal(${c.id})" class="p-2 text-gray-400 hover:text-[#106e39] hover:bg-[#f2fbf5] rounded-lg transition-colors" title="Edit Condition">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
    }
    
    window.openConditionModal = function(id = null) {
        errorMsg.classList.add('hidden');
        form.reset();
        
        if (id) {
            // Edit Mode
            document.getElementById('modal-title').textContent = 'Edit Health Condition';
            const c = allConditions.find(x => x.id === id);
            if (!c) return;
            
            document.getElementById('condition-id').value = c.id;
            document.getElementById('condition-name').value = c.name;
            document.getElementById('condition-slug').value = c.slug;
            document.getElementById('condition-description').value = c.description || '';
            document.getElementById('condition-image').value = c.image_url || '';
            document.getElementById('condition-active').checked = c.is_active == 1;
            
        } else {
            // Add Mode
            document.getElementById('modal-title').textContent = 'Add Health Condition';
            document.getElementById('condition-id').value = '';
            document.getElementById('condition-active').checked = true;
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
    searchInput.addEventListener('input', renderConditions);
    statusFilter.addEventListener('change', renderConditions);
    
    // Form Submit
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const id = document.getElementById('condition-id').value;
        const payload = {
            name: document.getElementById('condition-name').value.trim(),
            slug: document.getElementById('condition-slug').value.trim(),
            description: document.getElementById('condition-description').value.trim(),
            image_url: document.getElementById('condition-image').value.trim(),
            is_active: document.getElementById('condition-active').checked ? 1 : 0,
        };
        
        const btnText = document.getElementById('save-btn-text');
        const btnSpinner = document.getElementById('save-btn-spinner');
        const submitBtn = document.getElementById('save-condition-btn');
        
        submitBtn.disabled = true;
        btnText.textContent = 'Saving...';
        btnSpinner.classList.remove('hidden');
        errorMsg.classList.add('hidden');
        
        try {
            if (id) {
                await window.HBM_API.request(`/admin/health-conditions/${id}`, 'PUT', payload);
            } else {
                await window.HBM_API.request('/admin/health-conditions', 'POST', payload);
            }
            closeModal();
            fetchConditions();
        } catch (err) {
            errorMsg.textContent = err.message || 'An error occurred while saving the condition.';
            errorMsg.classList.remove('hidden');
        } finally {
            submitBtn.disabled = false;
            btnText.textContent = 'Save Condition';
            btnSpinner.classList.add('hidden');
        }
    });

    fetchConditions();
});
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
