<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Appointments Management</h2>
        <p class="text-sm text-gray-500 mt-1">Review and update consultation appointments.</p>
    </div>
    <div class="bg-white rounded-lg border border-gray-100 px-4 py-2 flex items-center gap-3 text-sm shadow-sm">
        <i class="fa-solid fa-calendar-check text-[#106e39]"></i>
        <span class="font-medium text-gray-600">Total Appointments: <span id="total-count-badge" class="font-bold text-gray-800">...</span></span>
    </div>
</div>

<!-- Filters & Search -->
<div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm mb-6 flex flex-col md:flex-row gap-4 items-end">
    <div class="w-full md:w-1/2">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Search Appointments</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-search text-gray-400"></i>
            </div>
            <input type="text" id="search-input" placeholder="Search by patient or expert name..." class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
        </div>
    </div>
    
    <div class="w-full md:w-1/4">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Filter by Status</label>
        <select id="status-filter" class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
            <option value="">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="confirmed">Confirmed</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>
</div>

<!-- Appointments Table -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="appointments-table">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500">
                    <th class="px-6 py-4 font-bold">Appointment Info</th>
                    <th class="px-6 py-4 font-bold">Patient</th>
                    <th class="px-6 py-4 font-bold">Expert</th>
                    <th class="px-6 py-4 font-bold text-center">Status</th>
                    <th class="px-6 py-4 font-bold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm" id="appointments-tbody">
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
                        <p>Loading appointments...</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Empty State -->
    <div id="empty-state" class="hidden flex-col items-center justify-center p-12 text-center">
        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 text-2xl mb-4">
            <i class="fa-solid fa-calendar-xmark"></i>
        </div>
        <h3 class="font-bold text-gray-800 text-lg mb-1">No appointments found</h3>
        <p class="text-sm text-gray-500 max-w-sm">No consultation appointments match your criteria.</p>
    </div>
</div>

<!-- Edit Appointment Modal -->
<div id="appointment-modal" class="fixed inset-0 bg-gray-900/50 z-50 hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-300 overflow-y-auto pt-16 pb-16">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden transform scale-95 transition-transform duration-300" id="appointment-modal-content">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50 sticky top-0 z-10">
            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <i class="fa-regular fa-calendar-check text-gray-400"></i> Manage Appointment #<span id="modal-apt-id">-</span>
            </h3>
            <button id="close-modal-btn" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
        
        <div class="p-6 max-h-[70vh] overflow-y-auto custom-scrollbar">
            <div id="modal-error" class="hidden mb-4 p-3 rounded-lg bg-red-50 text-red-600 text-sm font-medium border border-red-100"></div>
            
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-blue-50/50 p-4 rounded-xl border border-blue-100">
                    <p class="text-[10px] uppercase font-bold text-blue-400 tracking-wider mb-2">Patient Details</p>
                    <p class="font-bold text-gray-800" id="detail-patient-name">-</p>
                    <a href="#" id="detail-patient-email" class="text-sm text-blue-600 hover:underline">-</a>
                    <p class="text-xs text-gray-400 mt-1 font-mono">ID: #<span id="detail-patient-id">-</span></p>
                </div>
                <div class="bg-green-50/50 p-4 rounded-xl border border-green-100">
                    <p class="text-[10px] uppercase font-bold text-green-500 tracking-wider mb-2">Expert Details</p>
                    <p class="font-bold text-gray-800" id="detail-expert-name">-</p>
                    <p class="text-xs text-gray-400 mt-1 font-mono">ID: #<span id="detail-expert-id">-</span></p>
                </div>
            </div>
            
            <form id="appointment-form" class="space-y-5">
                <input type="hidden" id="appointment-id" value="">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Date</label>
                        <input type="date" id="apt-date" required class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Time</label>
                        <input type="time" id="apt-time" required class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Mode</label>
                        <select id="apt-mode" class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 transition-colors">
                            <option value="online">Online (Zoom)</option>
                            <option value="offline">Offline (In-Person)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Status</label>
                        <select id="apt-status" class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 transition-colors">
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Zoom Meeting Link (if online)</label>
                    <input type="url" id="apt-zoom" class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors" placeholder="https://zoom.us/j/...">
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Admin/Internal Notes</label>
                    <textarea id="apt-notes" rows="4" class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors custom-scrollbar" placeholder="Any private notes regarding this consultation..."></textarea>
                </div>
                
                <div class="bg-orange-50 p-3 rounded-lg border border-orange-100 flex gap-3 text-sm text-orange-800">
                    <i class="fa-solid fa-circle-info mt-0.5"></i>
                    <p>Appointments cannot be hard-deleted as they represent vital historical user data. Cancel them instead.</p>
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-100 flex justify-end gap-3 sticky bottom-0 bg-white">
                    <button type="button" id="cancel-modal-btn" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors">Cancel</button>
                    <button type="submit" id="save-apt-btn" class="px-6 py-2 bg-[#106e39] border border-transparent rounded-lg text-sm font-bold text-white hover:bg-[#0b5028] transition-colors flex items-center gap-2">
                        <span id="save-btn-text">Update Appointment</span>
                        <i id="save-btn-spinner" class="fa-solid fa-spinner fa-spin hidden"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let allApts = [];
    
    const tbody = document.getElementById('appointments-tbody');
    const emptyState = document.getElementById('empty-state');
    const tableHeader = document.querySelector('thead');
    const searchInput = document.getElementById('search-input');
    const statusFilter = document.getElementById('status-filter');
    const totalCountBadge = document.getElementById('total-count-badge');
    
    const modal = document.getElementById('appointment-modal');
    const modalContent = document.getElementById('appointment-modal-content');
    const closeBtn = document.getElementById('close-modal-btn');
    const cancelBtn = document.getElementById('cancel-modal-btn');
    const form = document.getElementById('appointment-form');
    const errorMsg = document.getElementById('modal-error');
    
    const statusStyles = {
        'pending': 'bg-orange-100 text-orange-700 border-orange-200',
        'confirmed': 'bg-blue-100 text-blue-700 border-blue-200',
        'completed': 'bg-green-100 text-green-700 border-green-200',
        'cancelled': 'bg-gray-100 text-gray-500 border-gray-200'
    };

    async function fetchApts() {
        try {
            const res = await window.HBM_API.request('/admin/appointments');
            if (res.data && res.data.data) {
                allApts = res.data.data;
                totalCountBadge.textContent = res.data.meta?.total || allApts.length;
                renderApts();
            }
        } catch (error) {
            console.error("Failed to fetch appointments", error);
            tbody.innerHTML = `<tr><td colspan="5" class="px-6 py-8 text-center text-red-500 font-medium">Failed to load appointments.</td></tr>`;
        }
    }
    
    function formatTime(timeStr) {
        if (!timeStr) return '';
        const [h, m] = timeStr.split(':');
        const hour = parseInt(h);
        const ampm = hour >= 12 ? 'PM' : 'AM';
        const formattedHour = hour % 12 || 12;
        return `${formattedHour}:${m} ${ampm}`;
    }
    
    function renderApts() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusTerm = statusFilter.value;
        
        const filtered = allApts.filter(a => {
            const patient = `${a.user_first_name} ${a.user_last_name}`.toLowerCase();
            const expert = `${a.expert_first_name} ${a.expert_last_name}`.toLowerCase();
            
            const matchesSearch = patient.includes(searchTerm) || expert.includes(searchTerm);
            const matchesStatus = statusTerm === '' || a.status === statusTerm;
            
            return matchesSearch && matchesStatus;
        });
        
        if (filtered.length === 0) {
            tbody.innerHTML = '';
            tableHeader.style.display = allApts.length === 0 ? 'none' : 'table-header-group';
            emptyState.classList.remove('hidden');
            emptyState.classList.add('flex');
            return;
        }
        
        emptyState.classList.add('hidden');
        emptyState.classList.remove('flex');
        tableHeader.style.display = 'table-header-group';
        
        tbody.innerHTML = filtered.map(a => {
            const sStyle = statusStyles[a.status] || statusStyles['pending'];
            const statusBadge = `<span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider border ${sStyle}">${a.status}</span>`;
            
            const dateObj = new Date(a.appointment_date);
            const dateStr = dateObj.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
            
            const modeIcon = a.mode === 'online' ? '<i class="fa-solid fa-video text-blue-500"></i>' : '<i class="fa-solid fa-hospital text-gray-500"></i>';
            
            return `
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-start gap-2 flex-col">
                            <p class="font-bold text-gray-800 text-sm"><i class="fa-regular fa-calendar text-gray-400 mr-1"></i> ${dateStr}</p>
                            <p class="text-xs font-bold text-gray-500"><i class="fa-regular fa-clock text-gray-400 mr-1"></i> ${formatTime(a.appointment_time)}</p>
                            <p class="text-[10px] font-bold uppercase tracking-wider bg-gray-100 px-1.5 py-0.5 rounded mt-1 text-gray-500 flex items-center gap-1">${modeIcon} ${a.mode}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-gray-800 text-sm truncate max-w-[150px]">${a.user_first_name} ${a.user_last_name}</p>
                        <p class="text-[11px] text-gray-500 truncate max-w-[150px]">${a.user_email}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-800 text-sm truncate max-w-[150px]">Dr. ${a.expert_first_name} ${a.expert_last_name}</p>
                    </td>
                    <td class="px-6 py-4 text-center">${statusBadge}</td>
                    <td class="px-6 py-4 text-right">
                        <button onclick="editApt(${a.id})" class="px-3 py-1.5 text-xs font-bold text-[#106e39] bg-[#f2fbf5] hover:bg-[#e6f7eb] rounded-lg transition-colors border border-[#106e39]/20" title="Manage Appointment">
                            Manage
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
    }
    
    window.editApt = function(id) {
        errorMsg.classList.add('hidden');
        
        const a = allApts.find(x => x.id === id);
        if (!a) return;
        
        document.getElementById('appointment-id').value = a.id;
        document.getElementById('modal-apt-id').textContent = a.id;
        
        document.getElementById('detail-patient-name').textContent = `${a.user_first_name} ${a.user_last_name}`;
        document.getElementById('detail-patient-email').textContent = a.user_email;
        document.getElementById('detail-patient-email').href = 'mailto:' + a.user_email;
        document.getElementById('detail-patient-id').textContent = a.user_id;
        
        document.getElementById('detail-expert-name').textContent = `Dr. ${a.expert_first_name} ${a.expert_last_name}`;
        document.getElementById('detail-expert-id').textContent = a.expert_id;
        
        document.getElementById('apt-date').value = a.appointment_date;
        document.getElementById('apt-time').value = a.appointment_time;
        document.getElementById('apt-mode').value = a.mode;
        document.getElementById('apt-status').value = a.status;
        document.getElementById('apt-zoom').value = a.zoom_link || '';
        document.getElementById('apt-notes').value = a.notes || '';
        
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
    
    searchInput.addEventListener('input', renderApts);
    statusFilter.addEventListener('change', renderApts);
    
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const id = document.getElementById('appointment-id').value;
        const payload = {
            appointment_date: document.getElementById('apt-date').value,
            appointment_time: document.getElementById('apt-time').value,
            status: document.getElementById('apt-status').value,
            zoom_link: document.getElementById('apt-zoom').value.trim(),
            notes: document.getElementById('apt-notes').value.trim()
        };
        
        const btnText = document.getElementById('save-btn-text');
        const btnSpinner = document.getElementById('save-btn-spinner');
        const submitBtn = document.getElementById('save-apt-btn');
        
        submitBtn.disabled = true;
        btnText.textContent = 'Updating...';
        btnSpinner.classList.remove('hidden');
        errorMsg.classList.add('hidden');
        
        try {
            await window.HBM_API.request(`/admin/appointments/${id}`, 'PUT', payload);
            closeModal();
            fetchApts();
        } catch (err) {
            errorMsg.textContent = err.message || 'An error occurred while saving.';
            errorMsg.classList.remove('hidden');
        } finally {
            submitBtn.disabled = false;
            btnText.textContent = 'Update Appointment';
            btnSpinner.classList.add('hidden');
        }
    });

    fetchApts();
});
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
