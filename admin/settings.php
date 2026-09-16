<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Global Settings</h2>
        <p class="text-sm text-gray-500 mt-1">Manage core application configurations.</p>
    </div>
</div>

<div id="settings-loading" class="flex flex-col items-center justify-center p-12">
    <i class="fa-solid fa-spinner fa-spin text-4xl text-[#106e39] mb-4"></i>
    <p class="text-gray-500 font-medium">Loading settings...</p>
</div>

<div id="settings-error" class="hidden bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl mb-6">
    <p class="font-bold"><i class="fa-solid fa-triangle-exclamation mr-2"></i> Error</p>
    <p class="text-sm mt-1" id="settings-error-msg"></p>
</div>

<div id="settings-success" class="hidden bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl mb-6">
    <p class="font-bold"><i class="fa-solid fa-check-circle mr-2"></i> Success</p>
    <p class="text-sm mt-1">Settings updated successfully.</p>
</div>

<div id="settings-content" class="hidden">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-8 max-w-4xl">
        <form id="settings-form" class="space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Site Name -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Site Name</label>
                    <input type="text" id="site_name" name="site_name" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#106e39] focus:border-transparent outline-none">
                </div>

                <!-- Currency -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Store Currency</label>
                    <select id="currency" name="currency" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#106e39] focus:border-transparent outline-none bg-white">
                        <option value="INR">INR (₹)</option>
                        <option value="USD">USD ($)</option>
                    </select>
                </div>

                <!-- Contact Email -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Contact Email</label>
                    <input type="email" id="contact_email" name="contact_email" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#106e39] focus:border-transparent outline-none">
                </div>

                <!-- Support Email -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Support Email</label>
                    <input type="email" id="support_email" name="support_email" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#106e39] focus:border-transparent outline-none">
                </div>

                <!-- Contact Phone -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Contact Phone</label>
                    <input type="text" id="contact_phone" name="contact_phone" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#106e39] focus:border-transparent outline-none">
                </div>

                <!-- Maintenance Mode -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Maintenance Mode</label>
                    <select id="maintenance_mode" name="maintenance_mode" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#106e39] focus:border-transparent outline-none bg-white">
                        <option value="0">Disabled (Site Live)</option>
                        <option value="1">Enabled (Site Offline)</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">When enabled, visitors will see a maintenance page.</p>
                </div>
            </div>

            <!-- Site Description -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Site Description</label>
                <textarea id="site_description" name="site_description" rows="3" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#106e39] focus:border-transparent outline-none"></textarea>
            </div>
            
            <div class="pt-4 border-t border-gray-100 flex justify-end">
                <button type="submit" id="save-btn" class="bg-[#106e39] hover:bg-green-800 text-white px-6 py-2 rounded-lg font-bold transition-colors flex items-center shadow-md">
                    <i class="fa-solid fa-save mr-2"></i> Save Settings
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    const loading = document.getElementById('settings-loading');
    const content = document.getElementById('settings-content');
    const errorBlock = document.getElementById('settings-error');
    const errorMsg = document.getElementById('settings-error-msg');
    const successBlock = document.getElementById('settings-success');
    const form = document.getElementById('settings-form');
    const saveBtn = document.getElementById('save-btn');

    // Super Admin Check (Basic UI guard)
    const adminRole = <?php echo json_encode($GLOBALS['adminUser']['role_slug'] ?? ''); ?>;
    if (adminRole !== 'superadmin') {
        loading.classList.add('hidden');
        errorMsg.textContent = 'Only Super Admins can view and edit global settings.';
        errorBlock.classList.remove('hidden');
        return;
    }

    // Load Settings
    try {
        const res = await window.HBM_API.request('/admin/settings');
        const settings = res.data || {};

        if (settings.site_name) document.getElementById('site_name').value = settings.site_name;
        if (settings.site_description) document.getElementById('site_description').value = settings.site_description;
        if (settings.contact_email) document.getElementById('contact_email').value = settings.contact_email;
        if (settings.support_email) document.getElementById('support_email').value = settings.support_email;
        if (settings.contact_phone) document.getElementById('contact_phone').value = settings.contact_phone;
        if (settings.maintenance_mode) document.getElementById('maintenance_mode').value = settings.maintenance_mode;
        if (settings.currency) document.getElementById('currency').value = settings.currency;

        loading.classList.add('hidden');
        content.classList.remove('hidden');
    } catch (err) {
        console.error(err);
        loading.classList.add('hidden');
        errorMsg.textContent = err.message || 'Failed to load settings.';
        errorBlock.classList.remove('hidden');
    }

    // Save Settings
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        successBlock.classList.add('hidden');
        errorBlock.classList.add('hidden');
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Saving...';

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        try {
            await window.HBM_API.request('/admin/settings', 'PUT', data);
            successBlock.classList.remove('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } catch (err) {
            console.error(err);
            errorMsg.textContent = err.message || 'Failed to save settings.';
            errorBlock.classList.remove('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } finally {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="fa-solid fa-save mr-2"></i> Save Settings';
        }
    });
});
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
