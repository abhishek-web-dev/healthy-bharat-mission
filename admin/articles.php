<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Health Library Articles</h2>
        <p class="text-sm text-gray-500 mt-1">Manage health, nutrition, and fitness articles.</p>
    </div>
    <div class="flex items-center gap-3">
        <div class="bg-white rounded-lg border border-gray-100 px-4 py-2 flex items-center gap-3 text-sm shadow-sm">
            <i class="fa-solid fa-book-medical text-[#106e39]"></i>
            <span class="font-medium text-gray-600">Total Articles: <span id="total-count-badge" class="font-bold text-gray-800">...</span></span>
        </div>
        <a href="article-create.php" class="bg-[#106e39] text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-[#0b5028] transition-colors flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Write Article
        </a>
    </div>
</div>

<!-- Tabs Navigation -->
<div class="mb-6 border-b border-gray-200">
    <nav class="-mb-px flex space-x-4" aria-label="Tabs">
        <button onclick="switchTab('articles')" id="nav-tab-articles" class="whitespace-nowrap py-4 px-6 border-b-2 font-bold text-sm border-[#106e39] text-[#106e39] hover:bg-gray-50 transition-colors focus:outline-none">
            <i class="fa-solid fa-file-lines mr-2"></i> Articles
        </button>
        <button onclick="switchTab('contact-form')" id="nav-tab-contact-form" class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 hover:bg-gray-50 transition-colors focus:outline-none">
            <i class="fa-solid fa-envelope mr-2"></i> Contact Form
        </button>
    </nav>
</div>

<div id="tab-articles-content" class="block">

<!-- Filters & Search -->
<div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm mb-6 flex flex-col md:flex-row gap-4 items-end">
    <div class="w-full md:w-1/3">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Search Articles</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-search text-gray-400"></i>
            </div>
            <input type="text" id="search-input" placeholder="Search by title or slug..." class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
        </div>
    </div>
    
    <div class="w-full md:w-1/4">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Filter by Category</label>
        <select id="category-filter" class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
            <option value="">All Categories</option>
            <!-- Populated by JS -->
        </select>
    </div>
    
    <div class="w-full md:w-1/4">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Filter by Status</label>
        <select id="status-filter" class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
            <option value="">All Statuses</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
            <option value="archived">Archived</option>
        </select>
    </div>
</div>

<!-- Articles Table -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="articles-table">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500">
                    <th class="px-6 py-4 font-bold">ID</th>
                    <th class="px-6 py-4 font-bold">Article</th>
                    <th class="px-6 py-4 font-bold">Category</th>
                    <th class="px-6 py-4 font-bold text-center">Status</th>
                    <th class="px-6 py-4 font-bold">Date Published</th>
                    <th class="px-6 py-4 font-bold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm" id="articles-tbody">
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                        <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
                        <p>Loading articles...</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Empty State -->
    <div id="empty-state" class="hidden flex-col items-center justify-center p-12 text-center">
        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 text-2xl mb-4">
            <i class="fa-solid fa-newspaper"></i>
        </div>
        <h3 class="font-bold text-gray-800 text-lg mb-1">No articles found</h3>
        <p class="text-sm text-gray-500 max-w-sm">No articles matched your search or you haven't written any yet.</p>
    </div>
</div>
</div> <!-- End Articles Tab -->

<!-- Contact Form Tab -->
<div id="tab-contact-form-content" class="hidden">
    <div class="mb-4">
        <h3 class="text-xl font-bold text-gray-800">Interested In Options</h3>
        <p class="text-sm text-gray-500 mt-1">Manage dropdown options for the public article contact inquiry forms.</p>
    </div>

    <div class="flex justify-end mb-4">
        <button onclick="openOptionModal()" class="px-4 py-2 bg-[#106e39] text-white font-medium rounded-lg hover:bg-[#0b5028] flex items-center gap-2 text-sm shadow-sm">
            <i class="fa-solid fa-plus"></i> Add Option
        </button>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Label</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Value</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Sort Order</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="options-tbody" class="divide-y divide-gray-100 text-sm">
                    <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500"><i class="fa-solid fa-spinner fa-spin mr-2"></i> Loading options...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div> <!-- End Contact Form Tab -->

<!-- Add Option Modal -->
<div id="option-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl w-full max-w-lg p-6 mx-4">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-800" id="modal-title">Add Option</h3>
            <button onclick="closeOptionModal()" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-times"></i></button>
        </div>
        <form id="option-form" class="space-y-4">
            <input type="hidden" id="option-id">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Option Label *</label>
                <input type="text" id="option-label" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-[#106e39] text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Option Value (Slug) *</label>
                <input type="text" id="option-value" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-[#106e39] text-sm" placeholder="e.g. consultation">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                <input type="number" id="option-sort" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-[#106e39] text-sm" value="0">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="option-status" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-[#106e39] text-sm">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <div id="modal-error" class="hidden p-3 bg-red-50 text-red-600 text-sm rounded-lg"></div>
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeOptionModal()" class="px-5 py-2 text-gray-600 text-sm font-medium hover:bg-gray-50 rounded-lg">Cancel</button>
                <button type="submit" class="px-5 py-2 bg-[#106e39] text-white text-sm font-medium rounded-lg hover:bg-[#0b5028]">Save Option</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let allArticles = [];
    let categories = [];
    
    const tbody = document.getElementById('articles-tbody');
    const emptyState = document.getElementById('empty-state');
    const tableHeader = document.querySelector('thead');
    const searchInput = document.getElementById('search-input');
    const statusFilter = document.getElementById('status-filter');
    const categoryFilter = document.getElementById('category-filter');
    const totalCountBadge = document.getElementById('total-count-badge');

    async function loadInitialData() {
        try {
            // Load Categories (using public endpoint if available or just skip if none. The public store didn't have a clear endpoint but let's try standard)
            // Wait, there might not be a public endpoint. Let's extract categories from the fetched articles dynamically for the filter if no API exists.
            await fetchArticles();
        } catch (error) {
            console.error("Initialization failed", error);
        }
    }
    
    async function fetchArticles() {
        try {
            const res = await window.HBM_API.request('/admin/articles');
            if (res.data && res.data.data) {
                allArticles = res.data.data;
                totalCountBadge.textContent = res.data.meta.total || allArticles.length;
                
                // Extract unique categories for filter
                const uniqueCats = [...new Set(allArticles.map(a => a.category_name).filter(Boolean))];
                
                // Check if we already have the categories API
                try {
                    const catRes = await window.HBM_API.request('/article-categories'); // Usually exists
                    if (catRes.data) {
                        categories = catRes.data;
                    }
                } catch(e) {
                    // Fallback to extracted cats
                    categories = uniqueCats.map(name => {
                        const art = allArticles.find(a => a.category_name === name);
                        return { id: art.category_id, name: name, slug: art.category_slug };
                    });
                }
                
                // Populate category selects
                const filterHtml = categories.map(c => `<option value="${c.name}">${c.name}</option>`).join('');
                document.getElementById('category-filter').innerHTML = `<option value="">All Categories</option>` + filterHtml;
                
                // For the form we need IDs (This was for the old modal, now removed)
                
                renderArticles();
            }
        } catch (error) {
            console.error("Failed to fetch articles", error);
            tbody.innerHTML = `<tr><td colspan="6" class="px-6 py-8 text-center text-red-500 font-medium">Failed to load articles.</td></tr>`;
        }
    }
    
    function getStatusBadge(status) {
        status = status || 'draft';
        switch(status.toLowerCase()) {
            case 'published': return `<span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider bg-green-100 text-green-700 border border-green-200">Published</span>`;
            case 'archived': return `<span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider bg-red-100 text-red-600 border border-red-200">Archived</span>`;
            default: return `<span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-500 border border-gray-200">Draft</span>`;
        }
    }
    
    function renderArticles() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusTerm = statusFilter.value;
        const categoryTerm = categoryFilter.value; // By Name
        
        const filtered = allArticles.filter(a => {
            const matchesSearch = a.title.toLowerCase().includes(searchTerm) || (a.slug && a.slug.toLowerCase().includes(searchTerm));
            const matchesStatus = statusTerm === '' || a.status === statusTerm;
            const matchesCategory = categoryTerm === '' || a.category_name === categoryTerm;
            
            return matchesSearch && matchesStatus && matchesCategory;
        });
        
        if (filtered.length === 0) {
            tbody.innerHTML = '';
            tableHeader.style.display = allArticles.length === 0 ? 'none' : 'table-header-group';
            emptyState.classList.remove('hidden');
            emptyState.classList.add('flex');
            return;
        }
        
        emptyState.classList.add('hidden');
        emptyState.classList.remove('flex');
        tableHeader.style.display = 'table-header-group';
        
        tbody.innerHTML = filtered.map(a => {
            let imgUrl = a.image_url || '../assets/images/articles/placeholder.jpg';
            if (imgUrl.startsWith('assets/')) {
                imgUrl = '../' + imgUrl;
            }
            const pubDate = a.published_at ? new Date(a.published_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) : '-';
            const catDisplay = a.category_name || 'Uncategorized';
            
            return `
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-gray-500 font-mono text-xs">#${a.id}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-10 rounded bg-gray-100 border border-gray-200 overflow-hidden shrink-0">
                                <img src="${imgUrl}" alt="${a.title}" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='../assets/images/articles/placeholder.jpg'">
                            </div>
                            <div>
                                <p class="font-bold text-gray-800 text-sm truncate max-w-[250px]" title="${a.title}">${a.title}</p>
                                <p class="text-[11px] text-gray-500 truncate max-w-[250px]">/${a.slug}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">${catDisplay}</td>
                    <td class="px-6 py-4 text-center">${getStatusBadge(a.status)}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">${pubDate}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="article-edit.php?id=${a.id}" class="inline-block p-2 text-gray-400 hover:text-[#106e39] hover:bg-[#f2fbf5] rounded-lg transition-colors" title="Edit Article">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </td>
                </tr>
            `;
        }).join('');
    }
    
    // Search & Filter Listeners
    searchInput.addEventListener('input', renderArticles);
    statusFilter.addEventListener('change', renderArticles);
    categoryFilter.addEventListener('change', renderArticles);

    loadInitialData();
});

// Tab Switching Logic
function switchTab(tabId) {
    // Hide all contents
    document.getElementById('tab-articles-content').classList.add('hidden');
    document.getElementById('tab-contact-form-content').classList.add('hidden');
    
    // Reset nav styles
    const navArticles = document.getElementById('nav-tab-articles');
    const navContact = document.getElementById('nav-tab-contact-form');
    
    navArticles.className = "whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 hover:bg-gray-50 transition-colors focus:outline-none";
    navContact.className = "whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 hover:bg-gray-50 transition-colors focus:outline-none";
    
    // Show active content and style active nav
    if (tabId === 'articles') {
        document.getElementById('tab-articles-content').classList.remove('hidden');
        navArticles.className = "whitespace-nowrap py-4 px-6 border-b-2 font-bold text-sm border-[#106e39] text-[#106e39] hover:bg-gray-50 transition-colors focus:outline-none";
    } else if (tabId === 'contact-form') {
        document.getElementById('tab-contact-form-content').classList.remove('hidden');
        navContact.className = "whitespace-nowrap py-4 px-6 border-b-2 font-bold text-sm border-[#106e39] text-[#106e39] hover:bg-gray-50 transition-colors focus:outline-none";
        loadOptions(); // Load contact options when tab is opened
    }
}

// Contact Options Logic
let optionsData = [];

async function loadOptions() {
    const tbody = document.getElementById('options-tbody');
    try {
        const res = await window.HBM_API.request('/admin/contact-options');
        optionsData = res.data || [];
        
        if (optionsData.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">No options found.</td></tr>';
            return;
        }
        
        tbody.innerHTML = optionsData.map(o => `
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-bold text-gray-800">${o.label}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                    <code>${o.value}</code>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                    ${o.sort_order}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold ${o.is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700'}">
                        ${o.is_active ? 'Active' : 'Inactive'}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <button onclick="editOption(${o.id})" class="inline-block p-2 text-gray-400 hover:text-[#106e39] hover:bg-[#f2fbf5] rounded-lg transition-colors" title="Edit"><i class="fa-solid fa-edit"></i></button>
                    <button onclick="deleteOption(${o.id})" class="inline-block p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete"><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>
        `).join('');
        
    } catch (err) {
        console.error(err);
        tbody.innerHTML = `<tr><td colspan="5" class="px-6 py-8 text-center text-red-500">Failed to load options: ${err.message}</td></tr>`;
    }
}

function openOptionModal(id = null) {
    document.getElementById('modal-error').classList.add('hidden');
    if (id) {
        document.getElementById('modal-title').textContent = 'Edit Option';
        const o = optionsData.find(x => x.id == id);
        if(o) {
            document.getElementById('option-id').value = o.id;
            document.getElementById('option-label').value = o.label;
            document.getElementById('option-value').value = o.value;
            document.getElementById('option-sort').value = o.sort_order;
            document.getElementById('option-status').value = o.is_active;
        }
    } else {
        document.getElementById('modal-title').textContent = 'Add Option';
        document.getElementById('option-form').reset();
        document.getElementById('option-id').value = '';
        document.getElementById('option-sort').value = '0';
    }
    document.getElementById('option-modal').classList.remove('hidden');
}

function closeOptionModal() {
    document.getElementById('option-modal').classList.add('hidden');
}

function editOption(id) {
    openOptionModal(id);
}

async function deleteOption(id) {
    if (!confirm('Are you sure you want to disable this option? Deleting might affect past inquiries if they rely on it. Disabling is recommended instead if possible.')) return;
    try {
        await window.HBM_API.request('/admin/contact-options/' + id, 'DELETE');
        loadOptions();
    } catch (err) {
        alert(err.message || 'Failed to delete option');
    }
}

document.getElementById('option-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const id = document.getElementById('option-id').value;
    const errDiv = document.getElementById('modal-error');
    errDiv.classList.add('hidden');
    
    const payload = {
        label: document.getElementById('option-label').value.trim(),
        value: document.getElementById('option-value').value.trim(),
        sort_order: parseInt(document.getElementById('option-sort').value) || 0,
        is_active: parseInt(document.getElementById('option-status').value)
    };
    
    try {
        if (id) {
            await window.HBM_API.request('/admin/contact-options/' + id, 'PUT', payload);
        } else {
            await window.HBM_API.request('/admin/contact-options', 'POST', payload);
        }
        closeOptionModal();
        loadOptions();
    } catch (err) {
        errDiv.textContent = err.message || 'An error occurred';
        errDiv.classList.remove('hidden');
    }
});

</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
