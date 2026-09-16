<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6">
    <div class="flex items-center gap-2 mb-1">
        <a href="coupons.php" class="text-gray-400 hover:text-[#106e39] transition-colors"><i class="fa-solid fa-arrow-left"></i></a>
        <h2 class="text-2xl font-bold text-gray-800">Add New Coupon</h2>
    </div>
    <p class="text-gray-600 text-sm pl-6">Create a new discount code.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-4xl">
    <div id="error-alert" class="hidden mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm flex items-start gap-3">
        <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
        <span id="error-text"></span>
    </div>

    <form id="add-coupon-form" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Coupon Code <span class="text-red-500">*</span></label>
                <input type="text" id="coupon-code" required placeholder="e.g. WELCOME10" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm uppercase">
                <p class="text-xs text-gray-500 mt-1">3-20 characters (letters, numbers, -, _).</p>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Coupon Name <span class="text-red-500">*</span></label>
                <input type="text" id="coupon-name" required placeholder="e.g. Welcome 10% Off" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm">
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Description (Optional)</label>
            <textarea id="coupon-description" rows="2" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Discount Type <span class="text-red-500">*</span></label>
                <select id="coupon-discount-type" required class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm">
                    <option value="percentage">Percentage (%)</option>
                    <option value="fixed">Fixed Amount (₹)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Discount Value <span class="text-red-500">*</span></label>
                <input type="number" id="coupon-discount-value" required step="0.01" min="0.01" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Start Date</label>
                <input type="datetime-local" id="coupon-start-date" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">End Date</label>
                <input type="datetime-local" id="coupon-end-date" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Status</label>
                <select id="coupon-status" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm">
                    <option value="active">Active</option>
                    <option value="inactive" selected>Inactive</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Applicable To</label>
                <select id="coupon-applicable-to" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm">
                    <option value="all">All Products</option>
                    <option value="products">Specific Products</option>
                    <option value="categories">Specific Categories</option>
                </select>
            </div>
        </div>

        <div id="targets-container" class="hidden">
            <label class="block text-sm font-bold text-gray-700 mb-2">Select IDs (comma separated)</label>
            <input type="text" id="coupon-targets" placeholder="e.g. 1, 2, 5" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm">
            <p class="text-xs text-gray-500 mt-1">Enter the database IDs of the products or categories this applies to.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Min Order Value (₹)</label>
                <input type="number" id="coupon-min-order" min="0" placeholder="e.g. 999" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Total Usage Limit</label>
                <input type="number" id="coupon-usage-limit" min="1" placeholder="Unlimited" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Per User Limit</label>
                <input type="number" id="coupon-per-user-limit" min="1" placeholder="Unlimited" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm">
            </div>
        </div>

        <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
            <a href="coupons.php" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg font-medium text-sm hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit" id="save-btn" class="bg-[#106e39] text-white px-5 py-2.5 rounded-lg font-medium text-sm hover:bg-[#0c572b] transition-colors shadow-sm flex items-center gap-2">
                <i class="fa-solid fa-save"></i> Save Coupon
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('coupon-applicable-to').addEventListener('change', (e) => {
    const container = document.getElementById('targets-container');
    if (e.target.value === 'all') {
        container.classList.add('hidden');
    } else {
        container.classList.remove('hidden');
    }
});

document.getElementById('add-coupon-form').addEventListener('submit', (e) => {
    e.preventDefault();
    
    const btn = document.getElementById('save-btn');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Saving...';
    btn.disabled = true;

    document.getElementById('error-alert').classList.add('hidden');

    const appTo = document.getElementById('coupon-applicable-to').value;
    const targetStr = document.getElementById('coupon-targets').value;
    let targets = [];
    if (appTo !== 'all') {
        targets = targetStr.split(',').map(s => s.trim()).filter(s => s !== '');
    }

    const payload = {
        code: document.getElementById('coupon-code').value.toUpperCase(),
        name: document.getElementById('coupon-name').value,
        description: document.getElementById('coupon-description').value,
        discount_type: document.getElementById('coupon-discount-type').value,
        discount_value: parseFloat(document.getElementById('coupon-discount-value').value),
        start_date: document.getElementById('coupon-start-date').value || null,
        end_date: document.getElementById('coupon-end-date').value || null,
        status: document.getElementById('coupon-status').value,
        applicable_to: appTo,
        targets: targets,
        min_order_value: document.getElementById('coupon-min-order').value || null,
        usage_limit: document.getElementById('coupon-usage-limit').value || null,
        per_user_limit: document.getElementById('coupon-per-user-limit').value || null
    };

    window.HBM_API.request('/admin/coupons', 'POST', payload)
    .then(res => {
        btn.innerHTML = originalText;
        btn.disabled = false;

        if (res.success || res.status === 'success') {
            window.location.href = 'coupons.php';
        } else {
            showError(res.message || 'Failed to create coupon.');
        }
    })
    .catch(err => {
        console.error(err);
        btn.innerHTML = originalText;
        btn.disabled = false;
        showError('Network error occurred.');
    });
});

function showError(msg) {
    document.getElementById('error-text').innerText = msg;
    document.getElementById('error-alert').classList.remove('hidden');
    window.scrollTo(0, 0);
}
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
