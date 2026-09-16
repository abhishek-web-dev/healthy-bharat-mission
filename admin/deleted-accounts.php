<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Deleted Accounts</h2>
        <p class="text-sm text-gray-500 mt-1">View and manage accounts that have been removed from the active user list.</p>
    </div>
    <div class="flex items-center gap-3">
        <div class="bg-white rounded-lg border border-gray-100 px-4 py-2 flex items-center gap-3 text-sm shadow-sm">
            <i class="fa-solid fa-user-slash text-[#106e39]"></i>
            <span class="font-medium text-gray-600">Total Deleted: <span id="total-users-badge" class="font-bold text-gray-800">...</span></span>
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
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 tracking-wider">Deleted Date</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 tracking-wider text-right">Actions</th>
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
        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
            <i class="fa-solid fa-user-slash text-3xl text-gray-300"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-1">No Deleted Accounts</h3>
        <p class="text-gray-500 text-sm max-w-md mx-auto mb-6">Deleted or removed accounts will appear here.</p>
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
    const totalUsersBadge = document.getElementById('total-users-badge');
    
    // Modal Elements
    // Fetch and render users
    async function fetchUsers() {
        try {
            const res = await window.HBM_API.request('/admin/users/deleted/all');
            if (res.data && res.data.users) {
                allUsers = res.data.users; // AdminUserController listUsers returns { users: [...] }
                totalUsersBadge.textContent = allUsers.length;
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
            const date = new Date(u.deleted_at || u.created_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
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
                        ${(window.adminUser && window.adminUser.permissions && (window.adminUser.permissions.includes('edit_deleted_accounts') || window.adminUser.permissions.includes('create_deleted_accounts'))) ? `
                        <button onclick="restoreUser(${u.id}, '${name}')" class="px-3 py-1.5 text-xs font-bold rounded-lg bg-green-50 text-[#106e39] border border-green-200 hover:bg-[#106e39] hover:text-white transition-colors" title="Restore Account">
                            <i class="fa-solid fa-rotate-left mr-1"></i> Restore
                        </button>
                        ` : ''}
                    </td>
                </tr>
            `;
        }).join('');
    }
    
    // Restore user handler
    window.restoreUser = async function(id, name) {
        if (!confirm(`Are you sure you want to restore the user account for ${name}?\n\nThis will return them to the active user list with their original role.`)) {
            return;
        }
        
        try {
            await window.HBM_API.request(`/admin/users/${id}/restore`, 'POST');
            // Remove from local array and re-render
            allUsers = allUsers.filter(u => u.id !== id);
            totalUsersBadge.textContent = allUsers.length;
            renderUsers();
        } catch (error) {
            alert('Failed to restore user: ' + (error.message || 'Unknown error'));
        }
    };
    
    // Search & Filter Listeners
    searchInput.addEventListener('input', renderUsers);
    roleFilter.addEventListener('change', renderUsers);
    statusFilter.addEventListener('change', renderUsers);
    
    // Init
    fetchUsers();
});
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
