<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Product Management</h2>
        <p class="text-sm text-gray-500 mt-1">Manage store products, pricing, and inventory.</p>
    </div>
    <div class="flex items-center gap-3">
        <div class="bg-white rounded-lg border border-gray-100 px-4 py-2 flex items-center gap-3 text-sm shadow-sm">
            <i class="fa-solid fa-box text-[#106e39]"></i>
            <span class="font-medium text-gray-600">Total Products: <span id="total-count-badge" class="font-bold text-gray-800">...</span></span>
        </div>
        <a href="add-product.php" class="bg-[#106e39] text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-[#0b5028] transition-colors flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Add Product
        </a>
    </div>
</div>

<!-- Filters & Search -->
<div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm mb-6 flex flex-col md:flex-row gap-4 items-end">
    <div class="w-full md:w-1/3">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Search Products</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-search text-gray-400"></i>
            </div>
            <input type="text" id="search-input" placeholder="Search by name or slug..." class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
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
            <option value="1">Active</option>
            <option value="0">Draft / Inactive</option>
        </select>
    </div>
</div>

<!-- Products Table -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="products-table">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500">
                    <th class="px-6 py-4 font-bold">ID</th>
                    <th class="px-6 py-4 font-bold">Product</th>
                    <th class="px-6 py-4 font-bold">Category</th>
                    <th class="px-6 py-4 font-bold text-right">Price</th>
                    <th class="px-6 py-4 font-bold text-right">Stock</th>
                    <th class="px-6 py-4 font-bold text-center">Status</th>
                    <th class="px-6 py-4 font-bold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm" id="products-tbody">
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                        <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
                        <p>Loading products...</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Empty State -->
    <div id="empty-state" class="hidden flex-col items-center justify-center p-12 text-center">
        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 text-2xl mb-4">
            <i class="fa-solid fa-box-open"></i>
        </div>
        <h3 class="font-bold text-gray-800 text-lg mb-1">No products found</h3>
        <p class="text-sm text-gray-500 max-w-sm">No products matched your search or you haven't added any yet.</p>
    </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', () => {
    let allProducts = [];
    let categories = [];
    
    const tbody = document.getElementById('products-tbody');
    const emptyState = document.getElementById('empty-state');
    const tableHeader = document.querySelector('thead');
    const searchInput = document.getElementById('search-input');
    const categoryFilter = document.getElementById('category-filter');
    const statusFilter = document.getElementById('status-filter');
    const totalCountBadge = document.getElementById('total-count-badge');
    

    

    async function loadInitialData() {
        try {
            // Load Categories
            const catRes = await window.HBM_API.request('/product-categories');
            if (catRes.data) {
                categories = catRes.data;
                const catOptions = categories.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
                document.getElementById('category-filter').innerHTML += catOptions;
            }
            
            // Load Products (Using our new admin endpoint which includes inactive products)
            await fetchProducts();
        } catch (error) {
            console.error("Initialization failed", error);
        }
    }
    
    async function fetchProducts() {
        try {
            const res = await window.HBM_API.request('/admin/products');
            if (res.data && res.data.products) {
                allProducts = res.data.products;
                totalCountBadge.textContent = allProducts.length;
                renderProducts();
            }
        } catch (error) {
            console.error("Failed to fetch products", error);
            tbody.innerHTML = `<tr><td colspan="7" class="px-6 py-8 text-center text-red-500 font-medium">Failed to load products.</td></tr>`;
        }
    }
    
    function formatCurrency(amount) {
        return new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' }).format(amount);
    }
    
    function renderProducts() {
        const searchTerm = searchInput.value.toLowerCase();
        const catTerm = categoryFilter.value;
        const statusTerm = statusFilter.value;
        
        const filtered = allProducts.filter(p => {
            const matchesSearch = p.name.toLowerCase().includes(searchTerm) || p.slug.toLowerCase().includes(searchTerm);
            const matchesCat = catTerm === '' || p.category_id == catTerm;
            const matchesStatus = statusTerm === '' || p.is_active == statusTerm;
            return matchesSearch && matchesCat && matchesStatus;
        });
        
        if (filtered.length === 0) {
            tbody.innerHTML = '';
            tableHeader.style.display = allProducts.length === 0 ? 'none' : 'table-header-group';
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
                
            const stockColor = p.stock > 10 ? 'text-green-600' : (p.stock > 0 ? 'text-orange-500' : 'text-red-500');
            const imgUrl = p.thumbnail_url || '../assets/images/products/product-placeholder.jpg';
            
            return `
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-gray-500 font-mono text-xs">#${p.id}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden shrink-0">
                                <img src="${imgUrl}" alt="${p.name}" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='../assets/images/products/product-placeholder.jpg'">
                            </div>
                            <div>
                                <p class="font-bold text-gray-800 text-sm truncate max-w-[200px]" title="${p.name}">${p.name}</p>
                                <p class="text-[11px] text-gray-500 truncate max-w-[200px]">/${p.slug}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">${p.category_name || 'Uncategorized'}</td>
                    <td class="px-6 py-4 text-sm font-bold text-gray-800 text-right">${formatCurrency(p.price)}</td>
                    <td class="px-6 py-4 text-sm font-bold ${stockColor} text-right">${p.stock}</td>
                    <td class="px-6 py-4 text-center">${statusBadge}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="add-product.php?id=${p.id}" class="p-2 text-gray-400 hover:text-[#106e39] hover:bg-[#f2fbf5] rounded-lg transition-colors inline-block" title="Edit Product">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </td>
                </tr>
            `;
        }).join('');
    }
    
    // Search & Filter Listeners
    searchInput.addEventListener('input', renderProducts);
    categoryFilter.addEventListener('change', renderProducts);
    statusFilter.addEventListener('change', renderProducts);


    loadInitialData();
});
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
