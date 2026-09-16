<?php 
require_once __DIR__ . '/components/admin-header.php'; 
?>

<style>
.btn-brand {
    background-color: #106e39;
}
.btn-brand:hover {
    background-color: #0b5229;
}
</style>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800" id="page-title">Edit User</h2>
        <p class="text-sm text-gray-500 mt-1" id="page-subtitle">Update user account details and permissions.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="users.php" class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-gray-50 transition-colors">
            Cancel
        </a>
        <button type="button" id="save-user-btn" class="btn-brand text-white px-6 py-2 rounded-lg text-sm font-bold shadow-sm transition-colors flex items-center gap-2">
            <i class="fa-regular fa-save"></i> <span id="save-btn-text">Save Changes</span>
            <i id="save-btn-spinner" class="fa-solid fa-spinner fa-spin hidden"></i>
        </button>
    </div>
</div>

<div id="error-message" class="hidden mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm font-medium"></div>

<form id="edit-user-form" style="display: flex; gap: 24px; padding-bottom: 3rem;">
    
    <!-- Left Column -->
    <div style="flex: 0 0 calc(65% - 12px); max-width: calc(65% - 12px);" class="space-y-6 min-w-0">
        <input type="hidden" id="edit-user-id" value="">
        
        <!-- Main User Data -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6" style="border: 1px solid #106e39;">
            <div class="p-6 pb-4" style="background-color: white; border-bottom: 1px solid #106e39;">
                <h3 class="font-bold text-gray-800 text-sm">Main User Data</h3>
            </div>
            
            <div class="p-8 bg-white space-y-6">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">User Name</label>
                    <input type="text" id="edit-user-name" disabled class="block w-full px-3 py-2 border border-[#a3c9b3] rounded-lg bg-gray-50 text-gray-500 sm:text-sm">
                    <p class="text-[10px] text-gray-400 mt-1"><i class="fa-solid fa-info-circle"></i> Name cannot be edited by admin.</p>
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Email</label>
                    <input type="email" id="edit-user-email" disabled class="block w-full px-3 py-2 border border-[#a3c9b3] rounded-lg bg-gray-50 text-gray-500 sm:text-sm">
                    <p class="text-[10px] text-gray-400 mt-1"><i class="fa-solid fa-info-circle"></i> Email address cannot be edited by admin.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Right Column -->
    <div style="flex: 1; min-width: 0;" class="space-y-6">
        
        <!-- Account Status & Role -->
        <div class="bg-white rounded-xl border border-[#106e39] shadow-sm overflow-hidden">
            <div class="p-6 pb-2">
                <h3 class="font-bold text-gray-800">Permissions & Status</h3>
            </div>
            <div class="p-6 pt-2 space-y-4">
                
                <div id="role-container">
                    <label for="edit-user-role" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Role <span class="text-[10px] text-orange-500 ml-2 normal-case"><i class="fa-solid fa-lock"></i> Super Admin Only</span></label>
                    <select id="edit-user-role" class="block w-full px-3 py-2 border border-[#a3c9b3] rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors">
                        <option value="user">User</option>
                        <option value="expert">Expert</option>
                        <option value="admin">Admin</option>
                        <option value="superadmin">Super Admin</option>
                    </select>
                </div>

                <div id="role-display-container" class="hidden">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Role</label>
                    <input type="text" id="edit-user-role-display" disabled class="block w-full px-3 py-2 border border-[#a3c9b3] rounded-lg bg-gray-50 text-gray-500 sm:text-sm capitalize">
                    <p class="text-[10px] text-gray-400 mt-1"><i class="fa-solid fa-info-circle"></i> Only Super Admins can change user roles.</p>
                </div>
                
                <div>
                    <label for="edit-user-status" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Account Status</label>
                    <select id="edit-user-status" class="block w-full px-3 py-2 border border-[#a3c9b3] rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="banned">Banned</option>
                    </select>
                </div>
                
            </div>
        </div>
        
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    // Get user ID from URL
    const urlParams = new URLSearchParams(window.location.search);
    const userId = urlParams.get('id');
    
    const form = document.getElementById('edit-user-form');
    const errorMsg = document.getElementById('error-message');
    const submitBtn = document.getElementById('save-user-btn');
    const btnText = document.getElementById('save-btn-text');
    const btnSpinner = document.getElementById('save-btn-spinner');
    
    let originalStatus = '';
    let originalRole = '';
    
    // Auth context
    let currentAdminRole = 'admin'; // fallback
    try {
        const meRes = await window.HBM_API.request('/admin/me', 'GET');
        currentAdminRole = meRes.data.user.role_slug;
    } catch (e) {
        console.error("Failed to get admin role:", e);
    }
    
    // Toggle role editing
    if (currentAdminRole === 'superadmin') {
        document.getElementById('role-container').classList.remove('hidden');
        document.getElementById('role-display-container').classList.add('hidden');
    } else {
        document.getElementById('role-container').classList.add('hidden');
        document.getElementById('role-display-container').classList.remove('hidden');
    }
    
    if (!userId) {
        errorMsg.textContent = 'No User ID provided.';
        errorMsg.classList.remove('hidden');
        submitBtn.disabled = true;
        return;
    }
    
    // Load user data
    try {
        const res = await window.HBM_API.request(`/admin/users/${userId}`, 'GET');
        const user = res.data;
        
        document.getElementById('edit-user-id').value = user.id;
        document.getElementById('edit-user-name').value = `${user.first_name} ${user.last_name}`;
        document.getElementById('edit-user-email').value = user.email;
        
        originalStatus = user.status;
        originalRole = user.role_slug;
        
        document.getElementById('edit-user-status').value = user.status;
        
        if (currentAdminRole === 'superadmin') {
            document.getElementById('edit-user-role').value = user.role_slug;
        } else {
            document.getElementById('edit-user-role-display').value = user.role_slug;
        }
    } catch (e) {
        errorMsg.textContent = 'Failed to load user details: ' + (e.message || 'Unknown error');
        errorMsg.classList.remove('hidden');
        submitBtn.disabled = true;
    }
    
    // Save user
    submitBtn.addEventListener('click', async () => {
        const id = document.getElementById('edit-user-id').value;
        const newStatus = document.getElementById('edit-user-status').value;
        const newRole = currentAdminRole === 'superadmin' ? document.getElementById('edit-user-role').value : null;
        
        submitBtn.disabled = true;
        btnText.textContent = 'Saving...';
        btnSpinner.classList.remove('hidden');
        errorMsg.classList.add('hidden');
        
        try {
            if (newStatus !== originalStatus) {
                await window.HBM_API.request(`/admin/users/${id}/status`, 'PUT', { status: newStatus });
            }
            
            if (currentAdminRole === 'superadmin' && newRole && newRole !== originalRole) {
                await window.HBM_API.request(`/admin/users/${id}/role`, 'PUT', { role: newRole });
            }
            
            // Redirect back to users list on success
            window.location.href = 'users.php';
        } catch (err) {
            errorMsg.textContent = err.message || 'An error occurred while updating the user.';
            errorMsg.classList.remove('hidden');
            
            submitBtn.disabled = false;
            btnText.textContent = 'Save Changes';
            btnSpinner.classList.add('hidden');
        }
    });
});
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
