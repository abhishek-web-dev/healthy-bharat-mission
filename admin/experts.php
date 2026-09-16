<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Expert Management</h2>
        <p class="text-sm text-gray-500 mt-1">Manage health experts and their profiles.</p>
    </div>
    <div class="bg-white rounded-lg border border-gray-100 px-4 py-2 flex items-center gap-3 text-sm shadow-sm">
        <i class="fa-solid fa-user-md text-[#106e39]"></i>
        <span class="font-medium text-gray-600">Total Experts: <span id="total-count-badge" class="font-bold text-gray-800">...</span></span>
    </div>
</div>

<!-- Filters & Search -->
<div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm mb-6 flex flex-col md:flex-row gap-4 items-end">
    <div class="w-full md:w-1/2">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Search Experts</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-search text-gray-400"></i>
            </div>
            <input type="text" id="search-input" placeholder="Search by name, email, or specialization..." class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
        </div>
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

<!-- Experts Table -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="experts-table">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500">
                    <th class="px-6 py-4 font-bold">Expert Details</th>
                    <th class="px-6 py-4 font-bold">Specialization</th>
                    <th class="px-6 py-4 font-bold">Experience</th>
                    <th class="px-6 py-4 font-bold text-center">Status</th>
                    <th class="px-6 py-4 font-bold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm" id="experts-tbody">
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
                        <p>Loading experts...</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Empty State -->
    <div id="empty-state" class="hidden flex-col items-center justify-center p-12 text-center">
        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 text-2xl mb-4">
            <i class="fa-solid fa-user-md"></i>
        </div>
        <h3 class="font-bold text-gray-800 text-lg mb-1">No experts found</h3>
        <p class="text-sm text-gray-500 max-w-sm">No experts match your criteria or no experts are registered yet.</p>
    </div>
</div>

<!-- Edit Expert Modal -->
<div id="expert-modal" class="fixed inset-0 bg-gray-900/50 z-50 hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-300 overflow-y-auto pt-16 pb-16">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden transform scale-95 transition-transform duration-300" id="expert-modal-content">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50 sticky top-0 z-10">
            <h3 class="text-lg font-bold text-gray-800">Edit Expert Profile</h3>
            <button id="close-modal-btn" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
        
        <div class="p-6 max-h-[70vh] overflow-y-auto custom-scrollbar">
            <div id="modal-error" class="hidden mb-4 p-3 rounded-lg bg-red-50 text-red-600 text-sm font-medium border border-red-100"></div>
            
            <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
                <div class="w-16 h-16 rounded-full bg-gray-100 border border-gray-200 overflow-hidden">
                    <img id="detail-image" src="" alt="Expert" class="w-full h-full object-cover hidden" onerror="this.onerror=null; this.src='../assets/images/default-avatar.png'">
                    <i class="fa-solid fa-user text-gray-400 text-3xl flex justify-center items-center h-full w-full" id="detail-image-fallback"></i>
                </div>
                <div>
                    <h4 class="font-bold text-lg text-gray-800" id="detail-name">-</h4>
                    <p class="text-sm text-gray-500" id="detail-email">-</p>
                    <p class="text-xs text-gray-400 mt-1 font-mono">User ID: #<span id="detail-user-id">-</span></p>
                </div>
            </div>
            
            <form id="expert-form" class="space-y-5">
                <input type="hidden" id="expert-user-id" value="">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Specialization *</label>
                        <input type="text" id="expert-specialization" required class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors" placeholder="e.g. Nutritionist">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Years of Experience</label>
                        <input type="number" id="expert-experience" min="0" class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors">
                    </div>
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Profile Image URL</label>
                    <input type="text" id="expert-image-url" class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors" placeholder="e.g. /assets/images/experts/expert1.jpg">
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Biography</label>
                    <textarea id="expert-bio" rows="5" class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors custom-scrollbar" placeholder="Expert's bio..."></textarea>
                </div>
                
                <hr class="border-gray-100">
                
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">User Account Status</label>
                    <select id="expert-status" class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="banned">Banned</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Changes here reflect on their core user account.</p>
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-100 flex justify-end gap-3 sticky bottom-0 bg-white">
                    <button type="button" id="cancel-modal-btn" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors">Cancel</button>
                    <button type="submit" id="save-expert-btn" class="px-6 py-2 bg-[#106e39] border border-transparent rounded-lg text-sm font-bold text-white hover:bg-[#0b5028] transition-colors flex items-center gap-2">
                        <span id="save-btn-text">Save Profile</span>
                        <i id="save-btn-spinner" class="fa-solid fa-spinner fa-spin hidden"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let allExperts = [];
    
    const tbody = document.getElementById('experts-tbody');
    const emptyState = document.getElementById('empty-state');
    const tableHeader = document.querySelector('thead');
    const searchInput = document.getElementById('search-input');
    const statusFilter = document.getElementById('status-filter');
    const totalCountBadge = document.getElementById('total-count-badge');
    
    const modal = document.getElementById('expert-modal');
    const modalContent = document.getElementById('expert-modal-content');
    const closeBtn = document.getElementById('close-modal-btn');
    const cancelBtn = document.getElementById('cancel-modal-btn');
    const form = document.getElementById('expert-form');
    const errorMsg = document.getElementById('modal-error');

    async function fetchExperts() {
        try {
            const res = await window.HBM_API.request('/admin/experts');
            if (res.data && res.data.data) {
                allExperts = res.data.data;
                totalCountBadge.textContent = res.data.meta?.total || allExperts.length;
                renderExperts();
            }
        } catch (error) {
            console.error("Failed to fetch experts", error);
            tbody.innerHTML = `<tr><td colspan="5" class="px-6 py-8 text-center text-red-500 font-medium">Failed to load experts.</td></tr>`;
        }
    }
    
    function renderExperts() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusTerm = statusFilter.value;
        
        const filtered = allExperts.filter(e => {
            const name = `${e.first_name} ${e.last_name}`.toLowerCase();
            const spec = (e.specialization || '').toLowerCase();
            
            const matchesSearch = name.includes(searchTerm) || e.email.toLowerCase().includes(searchTerm) || spec.includes(searchTerm);
            const matchesStatus = statusTerm === '' || e.user_status === statusTerm;
            
            return matchesSearch && matchesStatus;
        });
        
        if (filtered.length === 0) {
            tbody.innerHTML = '';
            tableHeader.style.display = allExperts.length === 0 ? 'none' : 'table-header-group';
            emptyState.classList.remove('hidden');
            emptyState.classList.add('flex');
            return;
        }
        
        emptyState.classList.add('hidden');
        emptyState.classList.remove('flex');
        tableHeader.style.display = 'table-header-group';
        
        tbody.innerHTML = filtered.map(e => {
            const isProfileComplete = e.profile_id !== null;
            
            let sStyle = 'bg-gray-100 text-gray-600 border-gray-200';
            if (e.user_status === 'active') sStyle = 'bg-green-100 text-green-700 border-green-200';
            if (e.user_status === 'banned') sStyle = 'bg-red-100 text-red-700 border-red-200';
            
            const statusBadge = `<span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider border ${sStyle}">${e.user_status}</span>`;
            
            const imgHtml = e.profile_image_url 
                ? `<img src="${e.profile_image_url}" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='../assets/images/default-avatar.png'">`
                : `<i class="fa-solid fa-user text-gray-400"></i>`;
            
            return `
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gray-100 border border-gray-200 overflow-hidden flex items-center justify-center shrink-0">
                                ${imgHtml}
                            </div>
                            <div>
                                <p class="font-bold text-gray-800 text-sm">Dr. ${e.first_name} ${e.last_name}</p>
                                <p class="text-[11px] text-gray-500">${e.email}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        ${e.specialization ? `<span class="font-medium text-gray-800 text-sm">${e.specialization}</span>` : `<span class="text-xs text-gray-400 italic">No profile</span>`}
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm text-gray-600">${e.experience_years ? e.experience_years + ' Yrs' : '-'}</span>
                    </td>
                    <td class="px-6 py-4 text-center">${statusBadge}</td>
                    <td class="px-6 py-4 text-right">
                        <button onclick="editExpert(${e.user_id})" class="p-2 text-gray-400 hover:text-[#106e39] hover:bg-[#f2fbf5] rounded-lg transition-colors" title="Edit Profile">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
    }
    
    window.editExpert = function(userId) {
        errorMsg.classList.add('hidden');
        
        const e = allExperts.find(x => x.user_id === userId);
        if (!e) return;
        
        document.getElementById('expert-user-id').value = e.user_id;
        document.getElementById('detail-name').textContent = `Dr. ${e.first_name} ${e.last_name}`;
        document.getElementById('detail-email').textContent = e.email;
        document.getElementById('detail-user-id').textContent = e.user_id;
        
        const img = document.getElementById('detail-image');
        const fallback = document.getElementById('detail-image-fallback');
        if (e.profile_image_url) {
            img.src = e.profile_image_url;
            img.classList.remove('hidden');
            fallback.classList.add('hidden');
        } else {
            img.classList.add('hidden');
            fallback.classList.remove('hidden');
        }
        
        document.getElementById('expert-specialization').value = e.specialization || '';
        document.getElementById('expert-experience').value = e.experience_years || 0;
        document.getElementById('expert-bio').value = e.bio || '';
        document.getElementById('expert-image-url').value = e.profile_image_url || '';
        document.getElementById('expert-status').value = e.user_status;
        
        modal.classList.remove('hidden');
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
    
    searchInput.addEventListener('input', renderExperts);
    statusFilter.addEventListener('change', renderExperts);
    
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const userId = document.getElementById('expert-user-id').value;
        const payload = {
            specialization: document.getElementById('expert-specialization').value.trim(),
            experience_years: parseInt(document.getElementById('expert-experience').value) || 0,
            bio: document.getElementById('expert-bio').value.trim(),
            profile_image_url: document.getElementById('expert-image-url').value.trim(),
            status: document.getElementById('expert-status').value
        };
        
        const btnText = document.getElementById('save-btn-text');
        const btnSpinner = document.getElementById('save-btn-spinner');
        const submitBtn = document.getElementById('save-expert-btn');
        
        submitBtn.disabled = true;
        btnText.textContent = 'Saving...';
        btnSpinner.classList.remove('hidden');
        errorMsg.classList.add('hidden');
        
        try {
            await window.HBM_API.request(`/admin/experts/${userId}`, 'PUT', payload);
            closeModal();
            fetchExperts();
        } catch (err) {
            errorMsg.textContent = err.message || 'An error occurred while saving.';
            errorMsg.classList.remove('hidden');
        } finally {
            submitBtn.disabled = false;
            btnText.textContent = 'Save Profile';
            btnSpinner.classList.add('hidden');
        }
    });

    fetchExperts();
});
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
