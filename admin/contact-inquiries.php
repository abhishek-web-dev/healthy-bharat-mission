<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Contact Inquiries</h2>
        <p class="text-sm text-gray-500 mt-1">Review and manage support requests from the public contact form.</p>
    </div>
    <div class="bg-white rounded-lg border border-gray-100 px-4 py-2 flex items-center gap-3 text-sm shadow-sm">
        <i class="fa-solid fa-headset text-[#106e39]"></i>
        <span class="font-medium text-gray-600">Total Inquiries: <span id="total-count-badge" class="font-bold text-gray-800">...</span></span>
    </div>
</div>

<!-- Filters & Search -->
<div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm mb-6 flex flex-col md:flex-row gap-4 items-end">
    <div class="w-full md:w-1/2">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Search Inquiries</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-search text-gray-400"></i>
            </div>
            <input type="text" id="search-input" placeholder="Search name, email, or subject..." class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
        </div>
    </div>
    
    <div class="w-full md:w-1/4">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Filter by Status</label>
        <select id="status-filter" class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
            <option value="">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="in_progress">In Progress</option>
            <option value="resolved">Resolved</option>
            <option value="spam">Spam</option>
        </select>
    </div>
</div>

<!-- Inquiries Table -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="inquiries-table">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500">
                    <th class="px-6 py-4 font-bold">Details</th>
                    <th class="px-6 py-4 font-bold">Subject</th>
                    <th class="px-6 py-4 font-bold">Date</th>
                    <th class="px-6 py-4 font-bold text-center">Status</th>
                    <th class="px-6 py-4 font-bold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm" id="inquiries-tbody">
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
                        <p>Loading inquiries...</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Empty State -->
    <div id="empty-state" class="hidden flex-col items-center justify-center p-12 text-center">
        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 text-2xl mb-4">
            <i class="fa-solid fa-inbox"></i>
        </div>
        <h3 class="font-bold text-gray-800 text-lg mb-1">No inquiries found</h3>
        <p class="text-sm text-gray-500 max-w-sm">You're all caught up! No inquiries match your criteria.</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let allInquiries = [];
    
    const tbody = document.getElementById('inquiries-tbody');
    const emptyState = document.getElementById('empty-state');
    const tableHeader = document.querySelector('thead');
    const searchInput = document.getElementById('search-input');
    const statusFilter = document.getElementById('status-filter');
    const totalCountBadge = document.getElementById('total-count-badge');
    
    const statusStyles = {
        'pending': 'bg-orange-100 text-orange-700 border-orange-200',
        'in_progress': 'bg-blue-100 text-blue-700 border-blue-200',
        'resolved': 'bg-green-100 text-green-700 border-green-200',
        'spam': 'bg-gray-100 text-gray-500 border-gray-200'
    };

    const statusLabels = {
        'pending': 'Pending',
        'in_progress': 'In Progress',
        'resolved': 'Resolved',
        'spam': 'Spam'
    };

    async function fetchInquiries() {
        try {
            const res = await window.HBM_API.request('/admin/contact-inquiries');
            if (res.data && res.data.data) {
                allInquiries = res.data.data;
                totalCountBadge.textContent = res.data.meta?.total || allInquiries.length;
                renderInquiries();
            }
        } catch (error) {
            console.error("Failed to fetch inquiries", error);
            tbody.innerHTML = `<tr><td colspan="5" class="px-6 py-8 text-center text-red-500 font-medium">Failed to load inquiries.</td></tr>`;
        }
    }
    
    function renderInquiries() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusTerm = statusFilter.value;
        
        const filtered = allInquiries.filter(i => {
            const matchesSearch = i.name.toLowerCase().includes(searchTerm) || 
                                  i.email.toLowerCase().includes(searchTerm) || 
                                  i.subject.toLowerCase().includes(searchTerm);
            const matchesStatus = statusTerm === '' || i.status === statusTerm;
            
            return matchesSearch && matchesStatus;
        });
        
        if (filtered.length === 0) {
            tbody.innerHTML = '';
            tableHeader.style.display = allInquiries.length === 0 ? 'none' : 'table-header-group';
            emptyState.classList.remove('hidden');
            emptyState.classList.add('flex');
            return;
        }
        
        emptyState.classList.add('hidden');
        emptyState.classList.remove('flex');
        tableHeader.style.display = 'table-header-group';
        
        tbody.innerHTML = filtered.map(i => {
            const sStyle = statusStyles[i.status] || statusStyles['pending'];
            const sLabel = statusLabels[i.status] || i.status;
            const statusBadge = `<span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider border ${sStyle}">${sLabel}</span>`;
            
            const date = new Date(i.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
            
            return `
                <tr id="inquiry-row-${i.id}" class="hover:bg-gray-50/50 transition-colors ${i.status === 'pending' ? 'bg-orange-50/20' : ''}">
                    <td class="px-6 py-4">
                        <p class="font-bold text-gray-800 text-sm truncate max-w-[200px]" title="${i.name}">${i.name}</p>
                        <p class="text-[11px] text-gray-500 truncate max-w-[200px]">${i.email}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-800 text-sm truncate max-w-[250px]" title="${i.subject}">${i.subject}</p>
                    </td>
                    <td class="px-6 py-4 text-xs text-gray-500">${date}</td>
                    <td class="px-6 py-4 text-center">${statusBadge}</td>
                    <td class="px-6 py-4 text-right">
                        <button onclick="viewInquiry(${i.id})" class="px-3 py-1.5 text-xs font-bold text-[#106e39] bg-[#f2fbf5] hover:bg-[#e6f7eb] rounded-lg transition-colors border border-[#106e39]/20" title="View Details">
                            View
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
    }
    
    window.viewInquiry = function(id) {
        window.location.href = `/admin/contact-inquiry-details.php?id=${id}`;
    };

    // Search & Filter Listeners
    searchInput.addEventListener('input', renderInquiries);
    statusFilter.addEventListener('change', renderInquiries);

    fetchInquiries();
});
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
