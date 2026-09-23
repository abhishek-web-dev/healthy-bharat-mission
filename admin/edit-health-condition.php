<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex items-center justify-between">
    <div>
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
            <a href="health-conditions.php" class="hover:text-[#106e39] transition-colors"><i class="fa-solid fa-arrow-left mr-1"></i> Back to Conditions</a>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">Edit Health Condition</h2>
        <p class="text-sm text-gray-500 mt-1">Update health condition details.</p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div id="page-error" class="hidden m-6 p-4 rounded-xl bg-red-50 text-red-600 text-sm font-medium border border-red-100"></div>
    
    <div id="loading-state" class="p-12 text-center text-gray-400">
        <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
        <p>Loading condition details...</p>
    </div>

    <form id="condition-form" class="p-6 space-y-6 hidden">
        <input type="hidden" id="condition-id" value="">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left Column -->
            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Condition Name *</label>
                    <input type="text" id="condition-name" required class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors bg-gray-50 focus:bg-white">
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">URL Slug *</label>
                    <input type="text" id="condition-slug" required class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors bg-gray-50 focus:bg-white" placeholder="e.g. type-2-diabetes">
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Description (HTML Content)</label>
                    <textarea id="condition-description" rows="8" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm font-mono transition-colors custom-scrollbar bg-gray-50 focus:bg-white" placeholder="<p>Information about the condition...</p>"></textarea>
                </div>
            </div>
            
            <!-- Right Column -->
            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Image URL</label>
                    <input type="text" id="condition-image" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors bg-gray-50 focus:bg-white" placeholder="/assets/images/conditions/banner.jpg">
                </div>

                <div class="bg-gray-50 p-5 rounded-xl border border-gray-100 space-y-3">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" id="condition-active" checked class="w-5 h-5 text-[#106e39] bg-white border-gray-300 rounded focus:ring-[#106e39]">
                        <span class="text-sm font-bold text-gray-700">Active (Visible)</span>
                    </label>
                    <p class="text-xs text-gray-500 mt-2 leading-relaxed"><i class="fa-solid fa-triangle-exclamation text-yellow-500 mr-1"></i> If inactive, it will be hidden from the public library, but remains linked to users who already selected it.</p>
                </div>
                
                <div class="bg-red-50 p-4 rounded-xl border border-red-100 flex gap-3 text-sm text-red-800">
                    <i class="fa-solid fa-ban mt-1"></i>
                    <p><strong>No Deletion Allowed:</strong> Conditions cannot be permanently deleted to prevent corrupting existing user health profiles.</p>
                </div>
            </div>
        </div>
        
        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3">
            <a href="health-conditions.php" class="px-5 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors">Cancel</a>
            <button type="submit" id="save-condition-btn" class="px-6 py-2.5 bg-[#106e39] border border-transparent rounded-xl text-sm font-bold text-white hover:bg-[#0b5028] transition-colors flex items-center gap-2">
                <span id="save-btn-text">Save Changes</span>
                <i id="save-btn-spinner" class="fa-solid fa-spinner fa-spin hidden"></i>
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');
    
    if (!id) {
        window.location.href = 'health-conditions.php';
        return;
    }

    const form = document.getElementById('condition-form');
    const loadingState = document.getElementById('loading-state');
    const errorMsg = document.getElementById('page-error');
    
    async function loadCondition() {
        try {
            // We fetch all conditions and find the one with this ID, because there is no specific GET /admin/health-conditions/{id} endpoint yet.
            const res = await window.HBM_API.request('/admin/health-conditions');
            if (res.data && res.data.data) {
                const c = res.data.data.find(x => x.id == id);
                if (c) {
                    document.getElementById('condition-id').value = c.id;
                    document.getElementById('condition-name').value = c.name;
                    document.getElementById('condition-slug').value = c.slug;
                    document.getElementById('condition-description').value = c.description || '';
                    document.getElementById('condition-image').value = c.image_url || '';
                    document.getElementById('condition-active').checked = c.is_active == 1;
                    
                    loadingState.classList.add('hidden');
                    form.classList.remove('hidden');
                } else {
                    throw new Error('Condition not found');
                }
            }
        } catch (error) {
            console.error("Failed to fetch condition details", error);
            errorMsg.textContent = "Failed to load condition details.";
            errorMsg.classList.remove('hidden');
            loadingState.innerHTML = `<p class="text-red-500"><i class="fa-solid fa-circle-xmark mr-2"></i>Failed to load condition.</p>`;
        }
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
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
            await window.HBM_API.request(`/admin/health-conditions/${id}`, 'PUT', payload);
            window.location.href = 'health-conditions.php';
        } catch (err) {
            errorMsg.textContent = err.message || 'An error occurred while saving the condition.';
            errorMsg.classList.remove('hidden');
            submitBtn.disabled = false;
            btnText.textContent = 'Save Changes';
            btnSpinner.classList.add('hidden');
        }
    });

    loadCondition();
});
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
