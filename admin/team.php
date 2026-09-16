<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Team & Roles</h2>
        <p class="text-sm text-gray-500 mt-1">Manage team members and access profiles.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="add-employee.php" class="bg-[#106e39] text-white px-4 py-2 rounded-lg font-medium text-sm hover:bg-[#0c572b] transition-colors flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-plus"></i> Add Team Member
        </a>
    </div>
</div>

<!-- Tabs -->
<div class="border-b border-gray-200 mb-6">
    <nav class="-mb-px flex gap-8" aria-label="Tabs">
        <button onclick="switchTab('team')" id="tab-team" class="border-[#106e39] text-[#106e39] whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm transition-colors">
            Team Members
        </button>
        <button onclick="switchTab('roles')" id="tab-roles" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm transition-colors">
            Access Profiles
        </button>
    </nav>
</div>

<!-- Team Tab Content -->
<div id="content-team">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="team-table">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500">
                        <th class="px-6 py-4 font-bold">Name</th>
                        <th class="px-6 py-4 font-bold">Role</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                        <th class="px-6 py-4 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm" id="team-tbody">
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                            <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
                            <p>Loading team members...</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Roles Tab Content (Master-Detail Layout) -->
<div id="content-roles" class="hidden flex flex-col md:flex-row gap-6 items-start">
    
    <!-- Left Panel: Access Profiles List -->
    <div class="w-full md:w-1/3 xl:w-1/4 shrink-0 flex flex-col gap-4">
        <button onclick="createNewProfile()" class="w-full bg-[#106e39] text-white px-4 py-3 rounded-xl font-medium text-sm hover:bg-[#0c572b] transition-colors flex items-center justify-center gap-2 shadow-sm">
            <i class="fa-solid fa-plus"></i> Create Profile
        </button>
        
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden flex flex-col h-[calc(100vh-250px)]">
            <div class="p-4 border-b border-gray-100 bg-gray-50 shrink-0">
                <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wide">Access Profiles</h3>
            </div>
            <div class="overflow-y-auto flex-1 p-2 space-y-1" id="roles-list">
                <div class="p-4 text-center text-gray-400 text-sm">
                    <i class="fa-solid fa-spinner fa-spin mb-2"></i><br>Loading...
                </div>
            </div>
        </div>
    </div>
    
    <!-- Right Panel: Profile Details & Permissions -->
    <div class="w-full md:w-2/3 xl:w-3/4 bg-white rounded-xl border border-gray-100 shadow-sm min-h-[calc(100vh-250px)] flex flex-col">
        
        <!-- Empty State (When no profile selected) -->
        <div id="role-empty-state" class="flex flex-col items-center justify-center h-full flex-1 p-12 text-center">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 text-2xl mb-4">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-lg mb-1">Select an Access Profile</h3>
            <p class="text-sm text-gray-500 max-w-sm">Choose a profile from the left sidebar to view or edit its module permissions.</p>
        </div>
        
        <!-- Details View -->
        <div id="role-details" class="hidden flex-col h-full">
            <div class="p-6 border-b border-gray-100 sticky top-0 bg-white z-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 rounded-t-xl">
                <div class="flex-1 w-full">
                    <input type="hidden" id="role-id">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Profile Name</label>
                    <input type="text" id="role-name" class="w-full text-xl font-bold text-gray-800 border-0 border-b-2 border-transparent hover:border-gray-200 focus:border-[#e85d04] focus:ring-0 px-0 py-1 bg-transparent transition-colors" placeholder="e.g. Content Manager">
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <button onclick="saveRole()" id="save-role-btn" class="bg-[#106e39] text-white px-6 py-2.5 rounded-lg font-bold hover:bg-[#0c572b] transition-colors shadow-sm flex items-center gap-2">
                        Save Profile
                    </button>
                </div>
            </div>
            
            <div class="p-6 bg-gray-50 flex-1 overflow-y-auto">
                <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4">Module Permissions</h4>
                
                <div id="permissions-grid" class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4">
                    <!-- Cards injected via JS -->
                </div>
            </div>
        </div>
        
    </div>
</div>

<script>
let allPermissions = {};
let allRoles = [];
let currentSelectedRoleId = null;

document.addEventListener('DOMContentLoaded', () => {
    loadTeamMembers();
    loadPermissions();
    loadRoles();
});

function switchTab(tab) {
    document.getElementById('content-team').classList.toggle('hidden', tab !== 'team');
    document.getElementById('content-roles').classList.toggle('hidden', tab !== 'roles');
    
    document.getElementById('tab-team').className = tab === 'team' 
        ? 'border-[#106e39] text-[#106e39] whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm transition-colors'
        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm transition-colors';
        
    document.getElementById('tab-roles').className = tab === 'roles' 
        ? 'border-[#106e39] text-[#106e39] whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm transition-colors'
        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm transition-colors';
}

function loadTeamMembers() {
    window.HBM_API.request('/admin/team')
        .then(data => {
            const tbody = document.getElementById('team-tbody');
            if (data.success && data.data.members.length > 0) {
                tbody.innerHTML = data.data.members.map(member => `
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-800">${member.first_name} ${member.last_name}</div>
                            <div class="text-xs text-gray-500">${member.email}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200">
                                ${member.role_name}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-medium ${member.status === 'active' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200'}">
                                <span class="w-1.5 h-1.5 rounded-full ${member.status === 'active' ? 'bg-green-500' : 'bg-red-500'}"></span>
                                ${member.status === 'active' ? 'Active' : 'Inactive'}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-[#106e39] hover:text-[#0c572b] p-1" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </td>
                    </tr>
                `).join('');
            } else {
                tbody.innerHTML = `<tr><td colspan="4" class="px-6 py-12 text-center text-gray-500">No team members found.</td></tr>`;
            }
        });
}

function loadPermissions() {
    window.HBM_API.request('/admin/permissions')
        .then(data => {
            if (data.success) {
                allPermissions = data.data.permissions;
            }
        });
}

function loadRoles(autoSelectId = null) {
    window.HBM_API.request('/admin/roles')
        .then(data => {
            if (data.success) {
                allRoles = data.data.roles;
                renderRolesList();
                
                if (autoSelectId) {
                    selectRole(autoSelectId);
                } else if (currentSelectedRoleId) {
                    // Try to reselect current
                    selectRole(currentSelectedRoleId);
                }
            }
        });
}

function renderRolesList() {
    const list = document.getElementById('roles-list');
    list.innerHTML = allRoles.map(role => {
        const isSelected = currentSelectedRoleId === role.id;
        const activeClasses = isSelected ? 'bg-[#f2fbf5] border-[#106e39] border-l-4' : 'hover:bg-gray-100 border-transparent border-l-4';
        const badge = role.slug === 'superadmin' ? '<span class="text-[10px] bg-gray-200 text-gray-600 px-1.5 py-0.5 rounded font-bold ml-2">SYSTEM</span>' : '';
        
        return `
            <button onclick="selectRole(${role.id})" class="w-full text-left px-4 py-3 rounded-r-lg transition-colors flex items-center justify-between group ${activeClasses}">
                <div class="flex items-center">
                    <div class="font-medium ${isSelected ? 'text-[#106e39]' : 'text-gray-700'}">${role.name}</div>
                    ${badge}
                </div>
                <i class="fa-solid fa-chevron-right text-xs ${isSelected ? 'text-[#106e39]' : 'text-gray-300 group-hover:text-gray-400'}"></i>
            </button>
        `;
    }).join('');
}

function createNewProfile() {
    currentSelectedRoleId = 'new';
    renderRolesList(); // To clear selection visually
    
    document.getElementById('role-empty-state').classList.add('hidden');
    const details = document.getElementById('role-details');
    details.classList.remove('hidden');
    details.classList.add('flex');
    
    document.getElementById('role-id').value = '';
    const nameInput = document.getElementById('role-name');
    nameInput.value = '';
    nameInput.disabled = false;
    nameInput.focus();
    
    const saveBtn = document.getElementById('save-role-btn');
    saveBtn.disabled = false;
    saveBtn.classList.remove('opacity-50', 'cursor-not-allowed');
    saveBtn.innerHTML = `Save Profile`;
    
    renderPermissionCards([]);
}

function selectRole(roleId) {
    const role = allRoles.find(r => r.id === roleId);
    if (!role) return;
    
    currentSelectedRoleId = roleId;
    renderRolesList(); // Update active class
    
    document.getElementById('role-empty-state').classList.add('hidden');
    const details = document.getElementById('role-details');
    details.classList.remove('hidden');
    details.classList.add('flex');
    
    document.getElementById('role-id').value = role.id;
    const nameInput = document.getElementById('role-name');
    nameInput.value = role.name;
    
    const saveBtn = document.getElementById('save-role-btn');
    
    if (role.slug === 'superadmin') {
        nameInput.disabled = true;
        saveBtn.disabled = true;
        saveBtn.classList.add('opacity-50', 'cursor-not-allowed');
        saveBtn.title = "System roles cannot be modified";
    } else {
        nameInput.disabled = false;
        saveBtn.disabled = false;
        saveBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        saveBtn.title = "";
    }
    
    renderPermissionCards(role.permissions || []);
}

function renderPermissionCards(selectedSlugs = []) {
    const grid = document.getElementById('permissions-grid');
    let html = '';
    
    for (const [module, perms] of Object.entries(allPermissions)) {
        const moduleName = module.split('_').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ');
        
        let actionsHtml = perms.map(p => {
            const isChecked = selectedSlugs.includes(p.slug) ? 'checked' : '';
            return `
                <label class="flex items-center justify-between p-2 rounded hover:bg-gray-50 cursor-pointer group transition-colors">
                    <span class="text-sm text-gray-700 capitalize group-hover:text-gray-900">${p.action}</span>
                    <input type="checkbox" name="permissions[]" value="${p.slug}" class="perm-cb w-4 h-4 text-[#e85d04] bg-gray-100 border-gray-300 rounded focus:ring-[#e85d04] focus:ring-2 cursor-pointer transition-colors" ${isChecked}>
                </label>
            `;
        }).join('');
        
        html += `
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <div class="px-4 py-3 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                    <h5 class="font-bold text-gray-800 text-sm">${moduleName}</h5>
                    <input type="checkbox" class="w-4 h-4 text-[#e85d04] bg-white border-gray-300 rounded focus:ring-[#e85d04] focus:ring-2 cursor-pointer transition-colors" onclick="toggleAllInCard(this)">
                </div>
                <div class="p-2 space-y-1">
                    ${actionsHtml}
                </div>
            </div>
        `;
    }
    
    grid.innerHTML = html;
    
    // Initialize master checkboxes
    document.querySelectorAll('.bg-white.rounded-xl').forEach(card => {
        const checkboxes = card.querySelectorAll('.perm-cb');
        const master = card.querySelector('input[type="checkbox"]:not(.perm-cb)');
        
        const updateMaster = () => {
            if (master && checkboxes.length > 0) {
                master.checked = Array.from(checkboxes).every(cb => cb.checked);
            }
        };
        
        updateMaster();
        
        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateMaster);
        });
    });
}

function toggleAllInCard(masterCb) {
    const card = masterCb.closest('.bg-white');
    const checkboxes = card.querySelectorAll('.perm-cb');
    checkboxes.forEach(cb => cb.checked = masterCb.checked);
}

function saveRole() {
    const id = document.getElementById('role-id').value;
    const name = document.getElementById('role-name').value;
    
    if (!name.trim()) {
        alert("Profile name is required.");
        return;
    }
    
    const checkboxes = document.querySelectorAll('.perm-cb:checked');
    const permissions = Array.from(checkboxes).map(cb => cb.value);
    
    const url = id ? `/api/admin/roles/${id}` : '/api/admin/roles';
    const method = id ? 'PUT' : 'POST';
    
    const btn = document.getElementById('save-role-btn');
    const originalText = btn.innerHTML;
    btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> Saving...`;
    btn.disabled = true;
    
    window.HBM_API.request(id ? `/admin/roles/${id}` : '/admin/roles', method, { name, permissions })
    .then(data => {
        if (data.success) {
            // Reload roles and keep selection
            loadRoles(id ? parseInt(id) : null);
            alert(data.message);
        } else {
            alert(data.message || 'Error saving role');
        }
    })
    .catch(err => {
        console.error(err);
        alert('An error occurred.');
    })
    .finally(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
