<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Frequently Asked Questions</h2>
        <p class="text-sm text-gray-500 mt-1">Manage FAQs displayed across the website.</p>
    </div>
    <div class="flex items-center gap-3">
        <div class="bg-white rounded-lg border border-gray-100 px-4 py-2 flex items-center gap-3 text-sm shadow-sm">
            <i class="fa-solid fa-file-circle-question text-[#106e39]"></i>
            <span class="font-medium text-gray-600">Total FAQs: <span id="total-count-badge" class="font-bold text-gray-800">...</span></span>
        </div>
        <button onclick="openFaqModal()" class="bg-[#106e39] text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-[#0b5028] transition-colors flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Add FAQ
        </button>
    </div>
</div>

<!-- Filters & Search -->
<div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm mb-6 flex flex-col md:flex-row gap-4 items-end">
    <div class="w-full md:w-1/2">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Search FAQs</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-search text-gray-400"></i>
            </div>
            <input type="text" id="search-input" placeholder="Search questions..." class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
        </div>
    </div>
    
    <div class="w-full md:w-1/4">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Category</label>
        <select id="category-filter" class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
            <option value="">All Categories</option>
            <!-- Generated dynamically -->
        </select>
    </div>
    
    <div class="w-full md:w-1/4">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Status</label>
        <select id="status-filter" class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
            <option value="">All Statuses</option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>
    </div>
</div>

<!-- FAQs Table -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="faqs-table">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500">
                    <th class="px-6 py-4 font-bold">Sort</th>
                    <th class="px-6 py-4 font-bold">Question & Category</th>
                    <th class="px-6 py-4 font-bold text-center">Status</th>
                    <th class="px-6 py-4 font-bold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm" id="faqs-tbody">
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                        <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
                        <p>Loading FAQs...</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Empty State -->
    <div id="empty-state" class="hidden flex-col items-center justify-center p-12 text-center">
        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 text-2xl mb-4">
            <i class="fa-solid fa-comment-dots"></i>
        </div>
        <h3 class="font-bold text-gray-800 text-lg mb-1">No FAQs found</h3>
        <p class="text-sm text-gray-500 max-w-sm">No FAQs matched your search or you haven't added any yet.</p>
    </div>
</div>

<!-- Add/Edit FAQ Modal -->
<div id="faq-modal" class="fixed inset-0 bg-gray-900/50 z-50 hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-300 overflow-y-auto pt-16 pb-16">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden transform scale-95 transition-transform duration-300" id="faq-modal-content">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50 sticky top-0 z-10">
            <h3 class="text-lg font-bold text-gray-800" id="modal-title">Add FAQ</h3>
            <button id="close-modal-btn" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
        
        <div class="p-6 max-h-[70vh] overflow-y-auto custom-scrollbar">
            <div id="modal-error" class="hidden mb-4 p-3 rounded-lg bg-red-50 text-red-600 text-sm font-medium border border-red-100"></div>
            
            <form id="faq-form" class="space-y-5">
                <input type="hidden" id="faq-id" value="">
                
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Question *</label>
                    <input type="text" id="faq-question" required class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-base font-medium transition-colors" placeholder="What is...">
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Answer *</label>
                    <textarea id="faq-answer" required rows="6" class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors custom-scrollbar" placeholder="Provide a detailed answer..."></textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Category</label>
                        <input type="text" id="faq-category" class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors" placeholder="e.g. general, programs, store">
                        <p class="text-[10px] text-gray-500 mt-1">Used to group FAQs on public pages.</p>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Sort Order</label>
                        <input type="number" id="faq-sort" value="0" min="0" class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors">
                        <p class="text-[10px] text-gray-500 mt-1">Lower numbers appear first.</p>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-3">
                    <label class="flex items-center gap-3">
                        <input type="checkbox" id="faq-active" checked class="w-4 h-4 text-[#106e39] bg-white border-gray-300 rounded focus:ring-[#106e39]">
                        <span class="text-sm font-bold text-gray-700">Active (Visible publicly)</span>
                    </label>
                </div>
                
                <div class="bg-orange-50 p-3 rounded-lg border border-orange-100 flex gap-3 text-sm text-orange-800">
                    <i class="fa-solid fa-circle-info mt-0.5"></i>
                    <p><strong>Database Association Note:</strong> The current schema uses text-based <code>category</code> identifiers rather than direct ID associations to Articles or Programs. Type matching identifiers to group them safely.</p>
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-100 flex justify-end gap-3 sticky bottom-0 bg-white">
                    <button type="button" id="cancel-modal-btn" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors">Cancel</button>
                    <button type="submit" id="save-faq-btn" class="px-6 py-2 bg-[#106e39] border border-transparent rounded-lg text-sm font-bold text-white hover:bg-[#0b5028] transition-colors flex items-center gap-2">
                        <span id="save-btn-text">Save FAQ</span>
                        <i id="save-btn-spinner" class="fa-solid fa-spinner fa-spin hidden"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let allFaqs = [];
    
    const tbody = document.getElementById('faqs-tbody');
    const emptyState = document.getElementById('empty-state');
    const tableHeader = document.querySelector('thead');
    const searchInput = document.getElementById('search-input');
    const statusFilter = document.getElementById('status-filter');
    const categoryFilter = document.getElementById('category-filter');
    const totalCountBadge = document.getElementById('total-count-badge');
    
    // Modal Elements
    const modal = document.getElementById('faq-modal');
    const modalContent = document.getElementById('faq-modal-content');
    const closeBtn = document.getElementById('close-modal-btn');
    const cancelBtn = document.getElementById('cancel-modal-btn');
    const form = document.getElementById('faq-form');
    const errorMsg = document.getElementById('modal-error');

    async function fetchFaqs() {
        try {
            const res = await window.HBM_API.request('/admin/faqs');
            if (res.data && res.data.data) {
                allFaqs = res.data.data;
                totalCountBadge.textContent = res.data.meta.total || allFaqs.length;
                
                // Extract unique categories
                const uniqueCats = [...new Set(allFaqs.map(f => f.category).filter(Boolean))];
                const filterHtml = uniqueCats.map(c => `<option value="${c}">${c}</option>`).join('');
                document.getElementById('category-filter').innerHTML = `<option value="">All Categories</option>` + filterHtml;
                
                renderFaqs();
            }
        } catch (error) {
            console.error("Failed to fetch FAQs", error);
            tbody.innerHTML = `<tr><td colspan="4" class="px-6 py-8 text-center text-red-500 font-medium">Failed to load FAQs.</td></tr>`;
        }
    }
    
    function renderFaqs() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusTerm = statusFilter.value;
        const categoryTerm = categoryFilter.value;
        
        const filtered = allFaqs.filter(f => {
            const matchesSearch = f.question.toLowerCase().includes(searchTerm) || f.answer.toLowerCase().includes(searchTerm);
            const matchesStatus = statusTerm === '' || f.is_active == statusTerm;
            const matchesCategory = categoryTerm === '' || f.category === categoryTerm;
            
            return matchesSearch && matchesStatus && matchesCategory;
        });
        
        if (filtered.length === 0) {
            tbody.innerHTML = '';
            tableHeader.style.display = allFaqs.length === 0 ? 'none' : 'table-header-group';
            emptyState.classList.remove('hidden');
            emptyState.classList.add('flex');
            return;
        }
        
        emptyState.classList.add('hidden');
        emptyState.classList.remove('flex');
        tableHeader.style.display = 'table-header-group';
        
        tbody.innerHTML = filtered.map(f => {
            const statusBadge = f.is_active 
                ? '<span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider bg-green-100 text-green-700 border border-green-200">Active</span>'
                : '<span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-500 border border-gray-200">Inactive</span>';
                
            return `
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-gray-500 font-mono text-xs">
                        <div class="flex flex-col items-center gap-1 bg-gray-100 rounded px-2 py-1 w-12 border border-gray-200">
                            <i class="fa-solid fa-sort text-[10px]"></i>
                            <span class="font-bold">${f.sort_order}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-gray-800 text-sm truncate max-w-[400px]" title="${f.question}">${f.question}</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-[10px] bg-blue-50 text-blue-600 px-1.5 py-0.5 rounded border border-blue-100 font-medium uppercase tracking-wider">${f.category || 'general'}</span>
                            <span class="text-[11px] text-gray-400">ID: #${f.id}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">${statusBadge}</td>
                    <td class="px-6 py-4 text-right">
                        <button onclick="openFaqModal(${f.id})" class="p-2 text-gray-400 hover:text-[#106e39] hover:bg-[#f2fbf5] rounded-lg transition-colors" title="Edit FAQ">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
    }
    
    window.openFaqModal = function(id = null) {
        errorMsg.classList.add('hidden');
        form.reset();
        
        if (id) {
            // Edit Mode
            document.getElementById('modal-title').textContent = 'Edit FAQ';
            const f = allFaqs.find(x => x.id === id);
            if (!f) return;
            
            document.getElementById('faq-id').value = f.id;
            document.getElementById('faq-question').value = f.question;
            document.getElementById('faq-answer').value = f.answer;
            document.getElementById('faq-category').value = f.category || 'general';
            document.getElementById('faq-sort').value = f.sort_order || 0;
            document.getElementById('faq-active').checked = f.is_active == 1;
            
        } else {
            // Add Mode
            document.getElementById('modal-title').textContent = 'Add FAQ';
            document.getElementById('faq-id').value = '';
            document.getElementById('faq-category').value = 'general';
            document.getElementById('faq-sort').value = 0;
            document.getElementById('faq-active').checked = true;
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
    searchInput.addEventListener('input', renderFaqs);
    statusFilter.addEventListener('change', renderFaqs);
    categoryFilter.addEventListener('change', renderFaqs);
    
    // Form Submit
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const id = document.getElementById('faq-id').value;
        const payload = {
            question: document.getElementById('faq-question').value.trim(),
            answer: document.getElementById('faq-answer').value.trim(),
            category: document.getElementById('faq-category').value.trim(),
            sort_order: parseInt(document.getElementById('faq-sort').value) || 0,
            is_active: document.getElementById('faq-active').checked ? 1 : 0,
        };
        
        const btnText = document.getElementById('save-btn-text');
        const btnSpinner = document.getElementById('save-btn-spinner');
        const submitBtn = document.getElementById('save-faq-btn');
        
        submitBtn.disabled = true;
        btnText.textContent = 'Saving...';
        btnSpinner.classList.remove('hidden');
        errorMsg.classList.add('hidden');
        
        try {
            if (id) {
                await window.HBM_API.request(`/admin/faqs/${id}`, 'PUT', payload);
            } else {
                await window.HBM_API.request('/admin/faqs', 'POST', payload);
            }
            closeModal();
            fetchFaqs();
        } catch (err) {
            errorMsg.textContent = err.message || 'An error occurred while saving the FAQ.';
            errorMsg.classList.remove('hidden');
        } finally {
            submitBtn.disabled = false;
            btnText.textContent = 'Save FAQ';
            btnSpinner.classList.add('hidden');
        }
    });

    fetchFaqs();
});
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
