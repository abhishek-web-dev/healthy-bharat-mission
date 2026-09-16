<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div class="flex items-center gap-3">
        <a href="team.php" class="text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fa-solid fa-arrow-left text-xl"></i>
        </a>
        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-user-plus text-[#106e39]"></i> Add Team Member
        </h2>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 md:p-8 max-w-4xl mx-auto">
    <form id="add-member-form" class="space-y-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">First Name</label>
                <input type="text" id="first-name" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] bg-gray-50 focus:bg-white transition-colors" placeholder="Enter first name">
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Last Name</label>
                <input type="text" id="last-name" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] bg-gray-50 focus:bg-white transition-colors" placeholder="Enter last name">
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                <input type="email" id="email" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] bg-gray-50 focus:bg-white transition-colors" placeholder="user@example.com">
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                <input type="password" id="password" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] bg-gray-50 focus:bg-white transition-colors" placeholder="••••••••">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Secret Code (Admin Code)</label>
                <input type="text" id="secret-code" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] bg-gray-50 focus:bg-white transition-colors" placeholder="Leave blank to auto-generate">
                <p class="text-xs text-gray-400 mt-1">Stored securely, used for secondary verification if enabled.</p>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Access & Permissions</h3>
            
            <div class="mb-6 max-w-md">
                <label class="block text-sm font-bold text-gray-700 mb-2">Access Profile</label>
                <select id="role-id" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] bg-gray-50 focus:bg-white transition-colors">
                    <option value="">Select a role...</option>
                    <!-- Loaded dynamically -->
                </select>
                <p class="text-xs text-gray-400 mt-2">Select a predefined access profile to determine which modules this employee can access.</p>
            </div>

            <div class="space-y-4">
                <label class="flex items-start p-4 border border-gray-100 rounded-lg bg-gray-50/50 cursor-pointer hover:bg-gray-50 transition-colors">
                    <div class="flex items-center h-5">
                        <input id="status-active" type="checkbox" checked class="w-5 h-5 text-[#106e39] bg-white border-gray-300 rounded focus:ring-[#106e39]">
                    </div>
                    <div class="ml-3 text-sm">
                        <span class="font-bold text-gray-800 block">Account is Active</span>
                        <span class="text-gray-500">If unchecked, the user will not be able to log in.</span>
                    </div>
                </label>

                <label class="flex items-start p-4 border border-gray-100 rounded-lg bg-gray-50/50 cursor-pointer hover:bg-gray-50 transition-colors">
                    <div class="flex items-center h-5">
                        <input id="send-email" type="checkbox" checked class="w-5 h-5 text-[#106e39] bg-white border-gray-300 rounded focus:ring-[#106e39]">
                    </div>
                    <div class="ml-3 text-sm">
                        <span class="font-bold text-gray-800 block">Send Onboarding Email</span>
                        <span class="text-gray-500">Send an email to the user with their password and secret code.</span>
                    </div>
                </label>
            </div>
        </div>

        <div class="flex justify-end gap-4 pt-6 border-t border-gray-100">
            <a href="team.php" class="px-6 py-2.5 border border-gray-200 rounded-lg text-gray-600 font-medium hover:bg-gray-50 transition-colors">Cancel</a>
            <button type="submit" id="submit-btn" class="bg-[#e85d04] text-white px-8 py-2.5 rounded-lg font-bold hover:bg-[#d05303] transition-colors shadow-sm flex items-center gap-2">
                Save Member
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Load roles for dropdown
    fetch('/api/admin/roles')
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const select = document.getElementById('role-id');
                data.data.roles.forEach(role => {
                    const option = document.createElement('option');
                    option.value = role.id;
                    option.textContent = role.name + (role.slug === 'superadmin' ? ' (System)' : '');
                    select.appendChild(option);
                });
            }
        });

    document.getElementById('add-member-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const btn = document.getElementById('submit-btn');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
        btn.disabled = true;

        const payload = {
            first_name: document.getElementById('first-name').value,
            last_name: document.getElementById('last-name').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            role_id: document.getElementById('role-id').value,
            status: document.getElementById('status-active').checked ? 'active' : 'inactive',
            secret_code: document.getElementById('secret-code').value // We send it, backend ignores if not implemented
        };

        fetch('/api/admin/team', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Team member created successfully!');
                window.location.href = 'team.php';
            } else {
                alert(data.message || 'An error occurred.');
                btn.innerHTML = 'Save Member';
                btn.disabled = false;
            }
        })
        .catch(err => {
            console.error(err);
            alert('A network error occurred.');
            btn.innerHTML = 'Save Member';
            btn.disabled = false;
        });
    });
});
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
