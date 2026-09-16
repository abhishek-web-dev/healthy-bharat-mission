<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6">
    <div class="flex items-center gap-2 mb-1">
        <a href="offers.php" class="text-gray-400 hover:text-[#106e39] transition-colors"><i class="fa-solid fa-arrow-left"></i></a>
        <h2 class="text-2xl font-bold text-gray-800">Add New Offer</h2>
    </div>
    <p class="text-sm text-gray-500 mt-1">Create a new discount offer.</p>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm max-w-4xl mb-6">
    <div class="p-6 sm:p-8">
        <form id="offer-form" class="space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Offer Name <span class="text-red-500">*</span></label>
                    <input type="text" id="offer-name" required class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Offer Code (Optional)</label>
                    <input type="text" id="offer-code" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm uppercase">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Discount Type <span class="text-red-500">*</span></label>
                    <select id="offer-discount-type" required class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm">
                        <option value="percentage">Percentage (%)</option>
                        <option value="fixed">Fixed Amount</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Discount Value <span class="text-red-500">*</span></label>
                    <input type="number" id="offer-discount-value" required step="0.01" min="0" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Start Date</label>
                    <input type="datetime-local" id="offer-start-date" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">End Date</label>
                    <input type="datetime-local" id="offer-end-date" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Status</label>
                    <select id="offer-status" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm">
                        <option value="active">Active</option>
                        <option value="inactive" selected>Inactive</option>
                        <option value="expired">Expired</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Applicable To</label>
                    <select id="offer-applicable-to" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm">
                        <option value="all">All Products</option>
                        <option value="products">Specific Products</option>
                        <option value="categories">Specific Categories</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Usage Limit</label>
                    <input type="number" id="offer-usage-limit" min="1" placeholder="Unlimited" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm">
                </div>
            </div>
            
            <div id="targets-container" class="hidden">
                <label class="block text-sm font-bold text-gray-700 mb-2">Select IDs (comma separated)</label>
                <input type="text" id="offer-targets" placeholder="e.g. 1, 2, 5" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm">
                <p class="text-xs text-gray-500 mt-1">Enter the database IDs of the products or categories this applies to.</p>
            </div>
        </form>
    </div>
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex gap-3 justify-end rounded-b-xl">
        <a href="offers.php" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-lg font-bold hover:bg-gray-50 transition-colors">
            Cancel
        </a>
        <button type="button" onclick="saveOffer()" id="btn-save" class="px-5 py-2.5 bg-[#106e39] text-white rounded-lg font-bold hover:bg-[#0c572b] transition-colors shadow-sm flex items-center gap-2">
            <i class="fa-solid fa-save"></i> Save Offer
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Set default date to now
    const now = new Date();
    document.getElementById('offer-start-date').value = now.toISOString().slice(0, 16);
    
    document.getElementById('offer-applicable-to').addEventListener('change', (e) => {
        const container = document.getElementById('targets-container');
        if (e.target.value === 'all') {
            container.classList.add('hidden');
        } else {
            container.classList.remove('hidden');
        }
    });
});

function saveOffer() {
    const form = document.getElementById('offer-form');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    const btn = document.getElementById('btn-save');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> Saving...`;
    
    let targets = [];
    if (document.getElementById('offer-applicable-to').value !== 'all') {
        const val = document.getElementById('offer-targets').value;
        if (val) {
            targets = val.split(',').map(s => parseInt(s.trim())).filter(n => !isNaN(n));
        }
    }
    
    const payload = {
        name: document.getElementById('offer-name').value,
        code: document.getElementById('offer-code').value,
        discount_type: document.getElementById('offer-discount-type').value,
        discount_value: document.getElementById('offer-discount-value').value,
        start_date: document.getElementById('offer-start-date').value || null,
        end_date: document.getElementById('offer-end-date').value || null,
        status: document.getElementById('offer-status').value,
        applicable_to: document.getElementById('offer-applicable-to').value,
        usage_limit: document.getElementById('offer-usage-limit').value || null,
        targets: targets
    };
    
    window.HBM_API.request('/admin/offers', 'POST', payload)
        .then(res => {
            if (res.success) {
                window.location.href = 'offers.php?success=created';
            } else {
                alert(res.message || "Failed to save offer.");
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        })
        .catch(err => {
            console.error(err);
            alert("An error occurred. Please check your network and try again.");
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
}
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
