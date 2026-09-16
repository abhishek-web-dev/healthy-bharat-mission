<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Category Management</h2>
        <p class="text-sm text-gray-500 mt-1">Manage product categories for your store.</p>
    </div>
    <div class="flex items-center gap-3">
        <div class="bg-white rounded-lg border border-gray-100 px-4 py-2 flex items-center gap-3 text-sm shadow-sm">
            <i class="fa-solid fa-tags text-[#106e39]"></i>
            <span class="font-medium text-gray-600">Total Categories: <span id="total-count-badge" class="font-bold text-gray-800">...</span></span>
        </div>
        <button onclick="openCategoryModal()" class="bg-[#106e39] text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-[#0b5028] transition-colors flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Add Category
        </button>
    </div>
</div>

<!-- Categories Table -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="py-3 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="py-3 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="py-3 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Slug</th>
                    <th class="py-3 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Products</th>
                    <th class="py-3 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody id="categories-tbody" class="divide-y divide-gray-100">
                <tr>
                    <td colspan="5" class="py-12 text-center text-gray-500">
                        <i class="fa-solid fa-spinner fa-spin text-2xl text-[#106e39] mb-3"></i>
                        <p>Loading categories...</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Category Modal -->
<div id="category-modal" class="fixed inset-0 bg-black/60 z-[100] hidden flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform transition-all">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 class="text-lg font-bold text-gray-800" id="modal-title">Add Category</h3>
            <button onclick="closeCategoryModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fa-solid fa-times text-xl"></i>
            </button>
        </div>
        <div class="p-6">
            <div id="modal-error" class="hidden mb-4 p-3 bg-red-50 text-red-700 border border-red-200 rounded-lg text-sm"></div>
            
            <form id="category-form" class="space-y-4">
                <input type="hidden" id="category-id">
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Category Name <span class="text-red-500">*</span></label>
                    <input type="text" id="category-name" required class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors" placeholder="e.g. Protein Powders">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Slug <span class="text-red-500">*</span></label>
                    <input type="text" id="category-slug" required class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors" placeholder="e.g. protein-powders">
                    <p class="text-[10px] text-gray-400 mt-1">URL-friendly identifier. Auto-generated if left blank.</p>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Image URL (Optional)</label>
                    <input type="text" id="category-image" class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors" placeholder="https://example.com/image.jpg">
                </div>
            </form>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
            <button onclick="closeCategoryModal()" class="px-4 py-2 text-sm font-bold text-gray-600 hover:text-gray-900 transition-colors">Cancel</button>
            <button id="save-btn" onclick="saveCategory()" class="bg-[#106e39] text-white px-6 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-[#0b5028] transition-colors flex items-center gap-2">
                <i class="fa-solid fa-save"></i> Save Category
            </button>
        </div>
    </div>
</div>

<script>
let currentCategories = [];

document.addEventListener('DOMContentLoaded', () => {
    fetchCategories();

    // Auto-generate slug from name
    const nameInput = document.getElementById('category-name');
    const slugInput = document.getElementById('category-slug');
    nameInput.addEventListener('input', () => {
        if (!document.getElementById('category-id').value) { // Only auto-fill for new categories
            slugInput.value = nameInput.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
        }
    });
});

async function fetchCategories() {
    try {
        const res = await window.HBM_API.request('/admin/categories');
        if (res.success) {
            currentCategories = res.data.categories || [];
            document.getElementById('total-count-badge').textContent = currentCategories.length;
            renderCategories();
        }
    } catch (err) {
        document.getElementById('categories-tbody').innerHTML = `
            <tr>
                <td colspan="5" class="py-8 text-center text-red-500 bg-red-50">
                    <i class="fa-solid fa-exclamation-triangle text-2xl mb-2"></i>
                    <p>${err.message || 'Failed to load categories'}</p>
                </td>
            </tr>
        `;
    }
}

function renderCategories() {
    const tbody = document.getElementById('categories-tbody');
    
    if (currentCategories.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="py-12 text-center text-gray-500">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fa-solid fa-tags text-2xl text-gray-400"></i>
                    </div>
                    <p class="font-medium text-gray-900">No categories found</p>
                    <p class="text-sm mt-1">Add your first category to get started.</p>
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = currentCategories.map(cat => `
        <tr class="hover:bg-gray-50 transition-colors group">
            <td class="py-3 px-6 text-sm text-gray-500">#${cat.id}</td>
            <td class="py-3 px-6">
                <div class="flex items-center gap-3">
                    ${cat.image_url ? `<img src="${cat.image_url}" class="w-8 h-8 rounded object-cover border border-gray-200">` : `<div class="w-8 h-8 rounded bg-gray-100 flex items-center justify-center border border-gray-200"><i class="fa-solid fa-image text-gray-300 text-xs"></i></div>`}
                    <span class="font-bold text-gray-800">${cat.name}</span>
                </div>
            </td>
            <td class="py-3 px-6 text-sm text-gray-500 font-mono">${cat.slug}</td>
            <td class="py-3 px-6">
                <span class="bg-gray-100 text-gray-700 py-1 px-2.5 rounded-full text-xs font-bold">${cat.product_count || 0} Products</span>
            </td>
            <td class="py-3 px-6 text-right">
                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button onclick='openCategoryModal(${JSON.stringify(cat).replace(/'/g, "&#39;")})' class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-100 flex items-center justify-center transition-colors" title="Edit">
                        <i class="fa-solid fa-pen text-xs"></i>
                    </button>
                    <button onclick="deleteCategory(${cat.id}, ${cat.product_count || 0})" class="w-8 h-8 rounded-full bg-red-50 text-red-600 hover:bg-red-100 flex items-center justify-center transition-colors" title="Delete">
                        <i class="fa-solid fa-trash text-xs"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

function openCategoryModal(cat = null) {
    const modal = document.getElementById('category-modal');
    const title = document.getElementById('modal-title');
    const form = document.getElementById('category-form');
    const errorBox = document.getElementById('modal-error');
    
    errorBox.classList.add('hidden');
    form.reset();
    
    if (cat) {
        title.textContent = 'Edit Category';
        document.getElementById('category-id').value = cat.id;
        document.getElementById('category-name').value = cat.name;
        document.getElementById('category-slug').value = cat.slug;
        document.getElementById('category-image').value = cat.image_url || '';
    } else {
        title.textContent = 'Add Category';
        document.getElementById('category-id').value = '';
    }
    
    modal.classList.remove('hidden');
}

function closeCategoryModal() {
    document.getElementById('category-modal').classList.add('hidden');
}

async function saveCategory() {
    const id = document.getElementById('category-id').value;
    const name = document.getElementById('category-name').value.trim();
    const slug = document.getElementById('category-slug').value.trim();
    const image_url = document.getElementById('category-image').value.trim();
    const errorBox = document.getElementById('modal-error');
    
    if (!name || !slug) {
        errorBox.textContent = 'Name and Slug are required.';
        errorBox.classList.remove('hidden');
        return;
    }
    
    const btn = document.getElementById('save-btn');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
    btn.disabled = true;
    errorBox.classList.add('hidden');
    
    try {
        const payload = { name, slug, image_url };
        let res;
        
        if (id) {
            res = await window.HBM_API.request('/admin/categories/' + id, 'PUT', payload);
        } else {
            res = await window.HBM_API.request('/admin/categories', 'POST', payload);
        }
        
        if (res.success) {
            closeCategoryModal();
            fetchCategories(); // Refresh list
        }
    } catch (err) {
        errorBox.textContent = err.message || 'An error occurred.';
        errorBox.classList.remove('hidden');
    } finally {
        btn.innerHTML = originalText;
        btn.disabled = false;
    }
}

async function deleteCategory(id, count) {
    if (count > 0) {
        alert('Cannot delete this category because it has active products attached.');
        return;
    }
    
    if (!confirm('Are you sure you want to delete this category? This action cannot be undone.')) {
        return;
    }
    
    try {
        const res = await window.HBM_API.request('/admin/categories/' + id, 'DELETE');
        if (res.success) {
            fetchCategories(); // Refresh list
        }
    } catch (err) {
        alert(err.message || 'Failed to delete category.');
    }
}
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
