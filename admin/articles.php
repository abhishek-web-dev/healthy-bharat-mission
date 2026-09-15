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
        <button onclick="openArticleModal()" class="bg-[#106e39] text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-[#0b5028] transition-colors flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Write Article
        </button>
    </div>
</div>

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

<!-- Add/Edit Article Modal -->
<div id="article-modal" class="fixed inset-0 bg-gray-900/50 z-50 hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-300 overflow-y-auto pt-16 pb-16">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-5xl overflow-hidden transform scale-95 transition-transform duration-300" id="article-modal-content">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50 sticky top-0 z-10">
            <h3 class="text-lg font-bold text-gray-800" id="modal-title">Write Article</h3>
            <button id="close-modal-btn" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
        
        <!-- Loading Overlay for Edit fetch -->
        <div id="modal-loading" class="hidden absolute inset-0 bg-white/90 z-20 flex-col items-center justify-center top-[73px]">
            <i class="fa-solid fa-spinner fa-spin text-3xl text-[#106e39] mb-3"></i>
            <p class="text-gray-500 font-medium">Loading content...</p>
        </div>

        <div class="p-6 max-h-[75vh] overflow-y-auto custom-scrollbar relative">
            <div id="modal-error" class="hidden mb-4 p-3 rounded-lg bg-red-50 text-red-600 text-sm font-medium border border-red-100"></div>
            
            <form id="article-form" class="space-y-5">
                <input type="hidden" id="article-id" value="">
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Content Column -->
                    <div class="lg:col-span-2 space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Article Title *</label>
                            <input type="text" id="article-title" required class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-lg font-bold transition-colors">
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Excerpt (Short Description)</label>
                            <textarea id="article-excerpt" rows="2" class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors custom-scrollbar" placeholder="A brief summary of the article..."></textarea>
                        </div>
                        
                        <div class="flex flex-col h-[400px]">
                            <div class="flex justify-between items-center mb-1.5">
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">HTML Content *</label>
                                <span class="text-[10px] bg-gray-100 text-gray-500 px-2 py-0.5 rounded border border-gray-200">Raw HTML mode active</span>
                            </div>
                            <!-- Minimal Raw HTML Textarea to preserve existing styling without bloating the Admin -->
                            <textarea id="article-content" required class="block w-full flex-1 px-4 py-3 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm font-mono transition-colors custom-scrollbar bg-gray-50" placeholder="<p>Write your HTML content here...</p>"></textarea>
                        </div>
                    </div>
                    
                    <!-- Sidebar Column -->
                    <div class="space-y-6">
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-4">
                            <h4 class="font-bold text-gray-700 uppercase tracking-wider text-xs border-b border-gray-200 pb-2">Publishing details</h4>
                            
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Status *</label>
                                <select id="article-status" required class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm font-bold transition-colors">
                                    <option value="draft">Draft (Hidden)</option>
                                    <option value="published">Published (Visible)</option>
                                    <option value="archived">Archived</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Category</label>
                                <select id="article-category" class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors">
                                    <option value="">Select a category</option>
                                    <!-- Populated by JS -->
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">URL Slug *</label>
                                <input type="text" id="article-slug" required class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors" placeholder="e.g. healthy-eating-tips">
                            </div>
                        </div>
                        
                        <div class="bg-white p-4 rounded-xl border border-gray-100 space-y-4 shadow-sm">
                            <h4 class="font-bold text-gray-700 uppercase tracking-wider text-xs border-b border-gray-100 pb-2">Media</h4>
                            
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Featured Image URL</label>
                                <input type="text" id="article-image" class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors" placeholder="/assets/images/articles/hero.jpg">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-100 flex justify-end gap-3 sticky bottom-0 bg-white">
                    <button type="button" id="cancel-modal-btn" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors">Cancel</button>
                    <button type="submit" id="save-article-btn" class="px-6 py-2 bg-[#106e39] border border-transparent rounded-lg text-sm font-bold text-white hover:bg-[#0b5028] transition-colors flex items-center gap-2">
                        <span id="save-btn-text">Publish Article</span>
                        <i id="save-btn-spinner" class="fa-solid fa-spinner fa-spin hidden"></i>
                    </button>
                </div>
            </form>
        </div>
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
    
    // Modal Elements
    const modal = document.getElementById('article-modal');
    const modalContent = document.getElementById('article-modal-content');
    const modalLoading = document.getElementById('modal-loading');
    const closeBtn = document.getElementById('close-modal-btn');
    const cancelBtn = document.getElementById('cancel-modal-btn');
    const form = document.getElementById('article-form');
    const errorMsg = document.getElementById('modal-error');
    
    // Auto-generate slug from title
    document.getElementById('article-title').addEventListener('input', function(e) {
        if (!document.getElementById('article-id').value) {
            const slug = e.target.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
            document.getElementById('article-slug').value = slug;
        }
    });
    
    // Update button text based on status
    document.getElementById('article-status').addEventListener('change', function(e) {
        const btnText = document.getElementById('save-btn-text');
        btnText.textContent = e.target.value === 'published' ? 'Publish Article' : 'Save ' + e.target.value.charAt(0).toUpperCase() + e.target.value.slice(1);
    });

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
                
                // For the form we need IDs
                // Note: since we might only have names in fallback, we'll try to use category_id if we have the proper API
                const formCatsHtml = categories.map(c => `<option value="${c.id || ''}">${c.name}</option>`).join('');
                document.getElementById('article-category').innerHTML = `<option value="">Select a category</option>` + formCatsHtml;
                
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
            const imgUrl = a.image_url || '../assets/images/articles/placeholder.jpg';
            const pubDate = a.published_at ? new Date(a.published_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) : '-';
            const catDisplay = a.category_name || 'Uncategorized';
            
            return `
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-gray-500 font-mono text-xs">#${a.id}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-10 rounded bg-gray-100 border border-gray-200 overflow-hidden shrink-0">
                                <img src="${imgUrl}" alt="${a.title}" class="w-full h-full object-cover" onerror="this.src='../assets/images/articles/placeholder.jpg'">
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
                        <button onclick="openArticleModal(${a.id})" class="p-2 text-gray-400 hover:text-[#106e39] hover:bg-[#f2fbf5] rounded-lg transition-colors" title="Edit Article">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
    }
    
    window.openArticleModal = async function(id = null) {
        errorMsg.classList.add('hidden');
        form.reset();
        
        // Show Modal
        modal.classList.remove('hidden');
        void modal.offsetWidth;
        modal.classList.remove('opacity-0');
        modalContent.classList.remove('scale-95');
        
        if (id) {
            // Edit Mode - Fetch complete content
            document.getElementById('modal-title').textContent = 'Edit Article';
            modalLoading.classList.remove('hidden');
            document.getElementById('article-id').value = id;
            
            try {
                const res = await window.HBM_API.request(`/admin/articles/${id}`);
                const a = res.data;
                
                document.getElementById('article-title').value = a.title || '';
                document.getElementById('article-slug').value = a.slug || '';
                document.getElementById('article-excerpt').value = a.excerpt || '';
                document.getElementById('article-content').value = a.content || '';
                
                if (a.category_id) {
                    document.getElementById('article-category').value = a.category_id;
                }
                
                document.getElementById('article-image').value = a.image_url || '';
                document.getElementById('article-status').value = a.status || 'draft';
                document.getElementById('article-status').dispatchEvent(new Event('change'));
                
            } catch (err) {
                errorMsg.textContent = 'Failed to fetch full article details.';
                errorMsg.classList.remove('hidden');
            } finally {
                modalLoading.classList.add('hidden');
            }
            
        } else {
            // Add Mode
            document.getElementById('modal-title').textContent = 'Write Article';
            document.getElementById('article-id').value = '';
            document.getElementById('article-status').value = 'draft';
            document.getElementById('article-status').dispatchEvent(new Event('change'));
        }
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
    searchInput.addEventListener('input', renderArticles);
    statusFilter.addEventListener('change', renderArticles);
    categoryFilter.addEventListener('change', renderArticles);
    
    // Form Submit
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const id = document.getElementById('article-id').value;
        const payload = {
            title: document.getElementById('article-title').value.trim(),
            slug: document.getElementById('article-slug').value.trim(),
            excerpt: document.getElementById('article-excerpt').value.trim(),
            content: document.getElementById('article-content').value,
            category_id: document.getElementById('article-category').value,
            image_url: document.getElementById('article-image').value.trim(),
            status: document.getElementById('article-status').value,
        };
        
        const btnText = document.getElementById('save-btn-text');
        const btnSpinner = document.getElementById('save-btn-spinner');
        const submitBtn = document.getElementById('save-article-btn');
        
        submitBtn.disabled = true;
        const originalText = btnText.textContent;
        btnText.textContent = 'Saving...';
        btnSpinner.classList.remove('hidden');
        errorMsg.classList.add('hidden');
        
        try {
            if (id) {
                await window.HBM_API.request(`/admin/articles/${id}`, 'PUT', payload);
            } else {
                await window.HBM_API.request('/admin/articles', 'POST', payload);
            }
            closeModal();
            fetchArticles(); // Refresh listing
        } catch (err) {
            errorMsg.textContent = err.message || 'An error occurred while saving the article.';
            errorMsg.classList.remove('hidden');
        } finally {
            submitBtn.disabled = false;
            btnText.textContent = originalText;
            btnSpinner.classList.add('hidden');
        }
    });

    loadInitialData();
});
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
