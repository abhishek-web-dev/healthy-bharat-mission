<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">User Management</h2>
        <p class="text-sm text-gray-500 mt-1">Manage system users, roles, and account statuses.</p>
    </div>
    <div class="flex items-center gap-3">
        <div class="bg-white rounded-lg border border-gray-100 px-4 py-2 flex items-center gap-3 text-sm shadow-sm">
            <i class="fa-solid fa-users text-[#106e39]"></i>
            <span class="font-medium text-gray-600">Total Users: <span id="total-count-badge" class="font-bold text-gray-800">...</span></span>
        </div>
    </div>
</div>

<!-- Filters & Search -->
<div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm mb-6 flex flex-col md:flex-row gap-4 items-end">
    <div class="w-full md:w-1/3">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Search Users</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-search text-gray-400"></i>
            </div>
            <input type="text" id="search-input" placeholder="Search by name or email..." class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
        </div>
    </div>
    
    <div class="w-full md:w-1/4">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Filter by Role</label>
        <select id="role-filter" class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
            <option value="">All Roles</option>
            <option value="superadmin">Super Admin</option>
            <option value="admin">Admin</option>
            <option value="expert">Expert</option>
            <option value="user">User</option>
        </select>
    </div>
    
    <div class="w-full md:w-1/4">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Filter by Status</label>
        <select id="status-filter" class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
            <option value="">All Statuses</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="banned">Banned</option>
        </select>
    </div>
</div>

<!-- Users Table -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="users-table">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500">
                    <th class="px-6 py-4 font-bold">ID</th>
                    <th class="px-6 py-4 font-bold">User</th>
                    <th class="px-6 py-4 font-bold">Role</th>
                    <th class="px-6 py-4 font-bold">Status</th>
                    <th class="px-6 py-4 font-bold">Registered</th>
                    <th class="px-6 py-4 font-bold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm" id="users-tbody">
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                        <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
                        <p>Loading users...</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Empty State -->
    <div id="empty-state" class="hidden flex-col items-center justify-center p-12 text-center">
        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 text-2xl mb-4">
            <i class="fa-solid fa-users-slash"></i>
        </div>
        <h3 class="font-bold text-gray-800 text-lg mb-1">No users found</h3>
        <p class="text-sm text-gray-500 max-w-sm">No users matched your current search and filter criteria.</p>
    </div>
</div>

<!-- Edit User Modal -->
<div id="edit-user-modal" class="fixed inset-0 bg-gray-900/50 z-50 hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform scale-95 transition-transform duration-300" id="edit-user-modal-content">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 class="text-lg font-bold text-gray-800" id="modal-title">Edit User</h3>
            <button id="close-modal-btn" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
        
        <div class="p-6">
            <div id="edit-error" class="hidden mb-4 p-3 rounded-lg bg-red-50 text-red-600 text-sm font-medium border border-red-100"></div>
            
            <form id="edit-user-form" class="space-y-4">
                <input type="hidden" id="edit-user-id">
                
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">User Name</label>
                    <input type="text" id="edit-user-name" disabled class="block w-full px-3 py-2 border border-gray-200 rounded-lg bg-gray-50 text-gray-500 sm:text-sm">
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Email</label>
                    <input type="email" id="edit-user-email" disabled class="block w-full px-3 py-2 border border-gray-200 rounded-lg bg-gray-50 text-gray-500 sm:text-sm">
                </div>
                
                <?php if ($GLOBALS['adminUser']['role_slug'] === 'superadmin'): ?>
                <div>
                    <label for="edit-user-role" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Role <span class="text-[10px] text-orange-500 ml-2 normal-case"><i class="fa-solid fa-lock"></i> Super Admin Only</span></label>
                    <select id="edit-user-role" class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors">
                        <option value="user">User</option>
                        <option value="expert">Expert</option>
                        <option value="admin">Admin</option>
                        <option value="superadmin">Super Admin</option>
                    </select>
                </div>
                <?php else: ?>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Role</label>
                    <input type="text" id="edit-user-role-display" disabled class="block w-full px-3 py-2 border border-gray-200 rounded-lg bg-gray-50 text-gray-500 sm:text-sm capitalize">
                    <p class="text-[10px] text-gray-400 mt-1"><i class="fa-solid fa-info-circle"></i> Only Super Admins can change user roles.</p>
                </div>
                <?php endif; ?>
                
                <div>
                    <label for="edit-user-status" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Account Status</label>
                    <select id="edit-user-status" class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="banned">Banned</option>
                    </select>
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" id="cancel-modal-btn" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors">Cancel</button>
                    <button type="submit" id="save-user-btn" class="px-4 py-2 bg-[#106e39] border border-transparent rounded-lg text-sm font-bold text-white hover:bg-[#0b5028] transition-colors flex items-center gap-2">
                        <span id="save-btn-text">Save Changes</span>
                        <i id="save-btn-spinner" class="fa-solid fa-spinner fa-spin hidden"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Pass current user role to JS safely
const currentAdminRole = "<?php echo htmlspecialchars($GLOBALS['adminUser']['role_slug']); ?>";

document.addEventListener('DOMContentLoaded', () => {
    let allUsers = [];
    
    const tbody = document.getElementById('users-tbody');
    const emptyState = document.getElementById('empty-state');
    const tableHeader = document.querySelector('thead');
    const searchInput = document.getElementById('search-input');
    const roleFilter = document.getElementById('role-filter');
    const statusFilter = document.getElementById('status-filter');
    const totalCountBadge = document.getElementById('total-count-badge');
    
    // Modal Elements
    const modal = document.getElementById('edit-user-modal');
    const modalContent = document.getElementById('edit-user-modal-content');
    const closeBtn = document.getElementById('close-modal-btn');
    const cancelBtn = document.getElementById('cancel-modal-btn');
    const form = document.getElementById('edit-user-form');
    const errorMsg = document.getElementById('edit-error');
    
    // Fetch and render users
    async function fetchUsers() {
        try {
            const res = await window.HBM_API.request('/admin/users');
            if (res.data && res.data.users) {
                allUsers = res.data.users; // AdminUserController listUsers returns { users: [...] }
                totalCountBadge.textContent = allUsers.length;
                renderUsers();
            }
        } catch (error) {
            console.error("Failed to fetch users", error);
            tbody.innerHTML = `<tr><td colspan="6" class="px-6 py-8 text-center text-red-500 font-medium">Failed to load users. Please try again.</td></tr>`;
        }
    }
    
    function getRoleBadgeColor(role) {
        switch(role) {
            case 'superadmin': return 'bg-purple-100 text-purple-700 border-purple-200';
            case 'admin': return 'bg-blue-100 text-blue-700 border-blue-200';
            case 'expert': return 'bg-teal-100 text-teal-700 border-teal-200';
            default: return 'bg-gray-100 text-gray-700 border-gray-200';
        }
    }
    
    function getStatusBadgeColor(status) {
        switch(status) {
            case 'active': return 'bg-green-100 text-green-700 border-green-200';
            case 'inactive': return 'bg-yellow-100 text-yellow-700 border-yellow-200';
            case 'banned': return 'bg-red-100 text-red-700 border-red-200';
            default: return 'bg-gray-100 text-gray-700 border-gray-200';
        }
    }
    
    function renderUsers() {
        const searchTerm = searchInput.value.toLowerCase();
        const roleTerm = roleFilter.value;
        const statusTerm = statusFilter.value;
        
        const filtered = allUsers.filter(u => {
            const matchesSearch = (u.first_name + ' ' + u.last_name).toLowerCase().includes(searchTerm) || 
                                  u.email.toLowerCase().includes(searchTerm);
            const matchesRole = roleTerm === '' || u.role_slug === roleTerm;
            const matchesStatus = statusTerm === '' || u.status === statusTerm;
            return matchesSearch && matchesRole && matchesStatus;
        });
        
        if (filtered.length === 0) {
            tbody.innerHTML = '';
            tableHeader.style.display = allUsers.length === 0 ? 'none' : 'table-header-group';
            emptyState.classList.remove('hidden');
            emptyState.classList.add('flex');
            return;
        }
        
        emptyState.classList.add('hidden');
        emptyState.classList.remove('flex');
        tableHeader.style.display = 'table-header-group';
        
        tbody.innerHTML = filtered.map(u => {
            const date = new Date(u.created_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
            const name = `${u.first_name} ${u.last_name}`;
            
            return `
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-gray-500 font-mono text-xs">#${u.id}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-[#106e39]/10 text-[#106e39] flex items-center justify-center font-bold text-xs shrink-0">
                                ${u.first_name.charAt(0)}${u.last_name.charAt(0)}
                            </div>
                            <div>
                                <p class="font-bold text-gray-800 text-sm">${name}</p>
                                <p class="text-xs text-gray-500">${u.email}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider border capitalize inline-block ${getRoleBadgeColor(u.role_slug)}">
                            ${u.role_slug.replace('superadmin', 'Super Admin')}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider border capitalize inline-block ${getStatusBadgeColor(u.status)}">
                            ${u.status}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">${date}</td>
                    <td class="px-6 py-4 text-right">
                        <button onclick="editUser(${u.id})" class="p-2 text-gray-400 hover:text-[#106e39] hover:bg-[#f2fbf5] rounded-lg transition-colors" title="Edit User">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
    }
    
    // Expose editUser to global scope for onclick handler
    window.editUser = function(id) {
        const user = allUsers.find(u => u.id === id);
        if (!user) return;
        
        document.getElementById('edit-user-id').value = user.id;
        document.getElementById('edit-user-name').value = `${user.first_name} ${user.last_name}`;
        document.getElementById('edit-user-email').value = user.email;
        document.getElementById('edit-user-status').value = user.status;
        
        if (currentAdminRole === 'superadmin') {
            document.getElementById('edit-user-role').value = user.role_slug;
        } else {
            document.getElementById('edit-user-role-display').value = user.role_slug;
        }
        
        errorMsg.classList.add('hidden');
        
        // Show Modal
        modal.classList.remove('hidden');
        // trigger reflow
        void modal.offsetWidth;
        modal.classList.remove('opacity-0');
        modalContent.classList.remove('scale-95');
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
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });
    
    // Search & Filter Listeners
    searchInput.addEventListener('input', renderUsers);
    roleFilter.addEventListener('change', renderUsers);
    statusFilter.addEventListener('change', renderUsers);
    
    // Form Submit
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const id = document.getElementById('edit-user-id').value;
        const newStatus = document.getElementById('edit-user-status').value;
        
        let newRole = null;
        if (currentAdminRole === 'superadmin') {
            newRole = document.getElementById('edit-user-role').value;
        }
        
        const btnText = document.getElementById('save-btn-text');
        const btnSpinner = document.getElementById('save-btn-spinner');
        const submitBtn = document.getElementById('save-user-btn');
        
        submitBtn.disabled = true;
        btnText.textContent = 'Saving...';
        btnSpinner.classList.remove('hidden');
        errorMsg.classList.add('hidden');
        
        try {
            // Check if status changed
            const user = allUsers.find(u => u.id == id);
            
            if (newStatus !== user.status) {
                await window.HBM_API.request(`/admin/users/${id}/status`, 'PUT', { status: newStatus });
            }
            
            if (currentAdminRole === 'superadmin' && newRole && newRole !== user.role_slug) {
                await window.HBM_API.request(`/admin/users/${id}/role`, 'PUT', { role: newRole });
            }
            
            closeModal();
            fetchUsers(); // Refresh list to get exact latest DB state
            
        } catch (err) {
            errorMsg.textContent = err.message || 'An error occurred while updating the user.';
            errorMsg.classList.remove('hidden');
        } finally {
            submitBtn.disabled = false;
            btnText.textContent = 'Save Changes';
            btnSpinner.classList.add('hidden');
        }
    });

    // Init
    fetchUsers();
});
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
