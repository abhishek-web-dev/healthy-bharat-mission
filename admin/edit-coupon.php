<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6">
    <div class="flex items-center gap-2 mb-1">
        <a href="coupons.php" class="text-gray-400 hover:text-[#106e39] transition-colors"><i class="fa-solid fa-arrow-left"></i></a>
        <h2 class="text-2xl font-bold text-gray-800">Edit Coupon</h2>
    </div>
    <p class="text-gray-600 text-sm pl-6" id="edit-subtitle">Loading coupon details...</p>
</div>

<div id="loading-state" class="py-12 flex justify-center">
    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#106e39]"></div>
</div>

<div id="error-state" class="hidden py-12 text-center bg-white rounded-xl shadow-sm border border-gray-100">
    <i class="fa-solid fa-circle-exclamation text-red-500 text-4xl mb-3"></i>
    <p id="error-text-main" class="text-gray-800 font-medium"></p>
    <a href="coupons.php" class="mt-4 inline-block text-[#106e39] font-medium hover:underline text-sm">Back to Coupons</a>
</div>

<div id="form-container" class="hidden bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-4xl">
    <div id="error-alert" class="hidden mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm flex items-start gap-3">
        <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
        <span id="error-text"></span>
    </div>

    <form id="edit-coupon-form" class="space-y-6">
        <input type="hidden" id="coupon-id">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Coupon Code <span class="text-red-500">*</span></label>
                <input type="text" id="coupon-code" required class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm uppercase">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Coupon Name <span class="text-red-500">*</span></label>
                <input type="text" id="coupon-name" required class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm">
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
                    <option value="inactive">Inactive</option>
                    <option value="expired">Expired</option>
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
                <input type="number" id="coupon-min-order" min="0" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Total Usage Limit</label>
                <input type="number" id="coupon-usage-limit" min="1" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Per User Limit</label>
                <input type="number" id="coupon-per-user-limit" min="1" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-[#106e39] focus:ring focus:ring-[#106e39] focus:ring-opacity-20 text-sm">
            </div>
        </div>

        <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
            <a href="coupons.php" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg font-medium text-sm hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit" id="save-btn" class="bg-[#106e39] text-white px-5 py-2.5 rounded-lg font-medium text-sm hover:bg-[#0c572b] transition-colors shadow-sm flex items-center gap-2">
                <i class="fa-solid fa-save"></i> Save Changes
            </button>
        </div>
    </form>
</div>

<script>
const urlParams = new URLSearchParams(window.location.search);
const couponId = urlParams.get('id');

document.addEventListener('DOMContentLoaded', () => {
    if (!couponId) {
        document.getElementById('loading-state').classList.add('hidden');
        document.getElementById('error-text-main').innerText = 'Invalid coupon ID.';
        document.getElementById('error-state').classList.remove('hidden');
        return;
    }

    loadCoupon();
});

document.getElementById('coupon-applicable-to').addEventListener('change', (e) => {
    const container = document.getElementById('targets-container');
    if (e.target.value === 'all') {
        container.classList.add('hidden');
    } else {
        container.classList.remove('hidden');
    }
});

function loadCoupon() {
    window.HBM_API.request(`/admin/coupons/${couponId}`)
    .then(res => {
        document.getElementById('loading-state').classList.add('hidden');
        
        if (res.success || res.status === 'success') {
            populateForm(res.data.coupon);
            document.getElementById('form-container').classList.remove('hidden');
        } else {
            document.getElementById('error-text-main').innerText = res.message || 'Coupon not found.';
            document.getElementById('error-state').classList.remove('hidden');
        }
    })
    .catch(err => {
        console.error(err);
        document.getElementById('loading-state').classList.add('hidden');
        document.getElementById('error-text-main').innerText = 'Network error occurred.';
        document.getElementById('error-state').classList.remove('hidden');
    });
}

function formatDatetime(dt) {
    if (!dt) return '';
    return dt.slice(0, 16);
}

function populateForm(coupon) {
    document.getElementById('edit-subtitle').innerText = `Update settings for code ${coupon.code}`;
    
    document.getElementById('coupon-id').value = coupon.id;
    document.getElementById('coupon-code').value = coupon.code;
    document.getElementById('coupon-name').value = coupon.name;
    document.getElementById('coupon-description').value = coupon.description || '';
    document.getElementById('coupon-discount-type').value = coupon.discount_type;
    document.getElementById('coupon-discount-value').value = coupon.discount_value;
    document.getElementById('coupon-start-date').value = formatDatetime(coupon.start_date);
    document.getElementById('coupon-end-date').value = formatDatetime(coupon.end_date);
    document.getElementById('coupon-status').value = coupon.status;
    document.getElementById('coupon-applicable-to').value = coupon.applicable_to;
    document.getElementById('coupon-min-order').value = coupon.min_order_value || '';
    document.getElementById('coupon-usage-limit').value = coupon.usage_limit || '';
    document.getElementById('coupon-per-user-limit').value = coupon.per_user_limit || '';

    if (coupon.applicable_to !== 'all') {
        document.getElementById('targets-container').classList.remove('hidden');
        const targetIds = coupon.targets.map(t => t.target_id).join(', ');
        document.getElementById('coupon-targets').value = targetIds;
    }
}

document.getElementById('edit-coupon-form').addEventListener('submit', (e) => {
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

    window.HBM_API.request(`/admin/coupons/${couponId}`, 'PUT', payload)
    .then(res => {
        btn.innerHTML = originalText;
        btn.disabled = false;

        if (res.success || res.status === 'success') {
            window.location.href = 'coupons.php';
        } else {
            showError(res.message || 'Failed to update coupon.');
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
