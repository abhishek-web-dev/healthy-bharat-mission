<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">System Audit Logs</h2>
        <p class="text-sm text-gray-500 mt-1">Track and monitor all administrative actions across the platform.</p>
    </div>
</div>

<!-- Controls -->
<div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm mb-6 flex flex-wrap gap-4 items-center justify-between">
    <div class="flex-1 min-w-[250px]">
        <div class="relative">
            <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            <input type="text" id="search-input" placeholder="Search by admin name, email, or action..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#106e39] focus:border-transparent text-sm">
        </div>
    </div>
    <div class="flex gap-3">
        <select id="action-filter" class="border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#106e39] bg-white">
            <option value="">All Actions</option>
            <option value="created">Created</option>
            <option value="updated">Updated</option>
            <option value="deleted">Deleted</option>
            <option value="updated_settings">Settings Updated</option>
            <option value="updated_role">Role Updated</option>
            <option value="updated_status">Status Updated</option>
        </select>
        <button id="refresh-btn" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-bold transition-colors">
            <i class="fa-solid fa-rotate-right"></i>
        </button>
    </div>
</div>

<div id="logs-error" class="hidden bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl mb-6 text-sm font-medium"></div>

<!-- Table -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mb-6 relative">
    
    <div id="table-loading" class="absolute inset-0 bg-white/80 backdrop-blur-sm z-10 flex flex-col items-center justify-center">
        <i class="fa-solid fa-spinner fa-spin text-3xl text-[#106e39] mb-2"></i>
        <p class="text-gray-500 font-medium text-sm">Loading logs...</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500">
                    <th class="px-6 py-4 font-bold">Timestamp</th>
                    <th class="px-6 py-4 font-bold flex items-center gap-2"><i class="fa-regular fa-user text-gray-400"></i> User ID</th>
                    <th class="px-6 py-4 font-bold">Action</th>
                    <th class="px-6 py-4 font-bold flex items-center gap-2"><i class="fa-regular fa-file-lines text-gray-400"></i> Entity</th>
                    <th class="px-6 py-4 font-bold"># Entity ID</th>
                    <th class="px-6 py-4 font-bold">Details</th>
                </tr>
            </thead>
            <tbody id="logs-tbody" class="divide-y divide-gray-50 text-sm">
                <!-- Populated by JS -->
            </tbody>
        </table>
    </div>
    
    <div id="empty-state" class="hidden p-12 text-center">
        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400 text-2xl">
            <i class="fa-solid fa-shield-halved"></i>
        </div>
        <p class="text-gray-500 font-medium">No audit logs found matching your criteria.</p>
    </div>
</div>

<!-- Pagination -->
<div class="flex items-center justify-between" id="pagination-controls">
    <p class="text-sm text-gray-500 font-medium">Showing <span id="page-info">0 of 0</span> logs</p>
    <div class="flex gap-2">
        <button id="prev-btn" class="px-4 py-2 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors font-medium text-sm">Previous</button>
        <button id="next-btn" class="px-4 py-2 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors font-medium text-sm">Next</button>
    </div>
</div>

<!-- Detail Modal -->
<div id="detail-modal" class="hidden fixed inset-0 z-50 bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden transform scale-95 transition-transform duration-200" id="detail-modal-inner">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 class="font-bold text-gray-800 text-lg"><i class="fa-solid fa-file-code mr-2 text-gray-400"></i> Log Details</h3>
            <button id="close-modal" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <div class="p-6 overflow-y-auto max-h-[70vh]">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-bold mb-1">Actor</p>
                    <p class="font-medium text-gray-800" id="modal-actor">-</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-bold mb-1">IP Address</p>
                    <p class="font-medium text-gray-800 font-mono" id="modal-ip">-</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-bold mb-1">Action</p>
                    <p class="font-medium text-gray-800" id="modal-action">-</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-bold mb-1">Entity Reference</p>
                    <p class="font-medium text-gray-800" id="modal-entity">-</p>
                </div>
            </div>
            
            <p class="text-xs text-gray-500 uppercase font-bold mb-2">JSON Metadata</p>
            <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                <pre id="modal-json" class="text-green-400 font-mono text-sm leading-relaxed"></pre>
            </div>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end">
            <button id="close-modal-btn" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-bold transition-colors">Close</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    
    let currentPage = 1;
    let totalPages = 1;
    const perPage = 20;

    const tbody = document.getElementById('logs-tbody');
    const loading = document.getElementById('table-loading');
    const emptyState = document.getElementById('empty-state');
    const errorBlock = document.getElementById('logs-error');
    const pageInfo = document.getElementById('page-info');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');

    const searchInput = document.getElementById('search-input');
    const actionFilter = document.getElementById('action-filter');
    const refreshBtn = document.getElementById('refresh-btn');

    const detailModal = document.getElementById('detail-modal');
    const detailModalInner = document.getElementById('detail-modal-inner');
    
    let logsCache = [];

    const getActionBadge = (action) => {
        const styles = {
            'created': 'bg-green-100 text-green-700 border border-green-200',
            'updated': 'bg-blue-100 text-blue-700 border border-blue-200',
            'deleted': 'bg-red-100 text-red-700 border border-red-200',
            'updated_settings': 'bg-purple-100 text-purple-700 border border-purple-200',
            'updated_role': 'bg-orange-100 text-orange-700 border border-orange-200',
            'updated_status': 'bg-yellow-100 text-yellow-700 border border-yellow-200',
        };
        const style = styles[action] || 'bg-gray-100 text-gray-700 border border-gray-200';
        return `<span class="px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wider shadow-sm ${style}">${action.replace('_', ' ')}</span>`;
    };

    const formatDate = (dateStr) => {
        const d = new Date(dateStr);
        return {
            date: d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }),
            time: d.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })
        };
    };

    async function loadLogs() {
        try {
            loading.classList.remove('hidden');
            errorBlock.classList.add('hidden');
            tbody.innerHTML = '';
            emptyState.classList.add('hidden');

            const search = encodeURIComponent(searchInput.value.trim());
            const action = encodeURIComponent(actionFilter.value);
            
            const res = await window.HBM_API.request(`/admin/audit-logs?page=${currentPage}&per_page=${perPage}&search=${search}&action=${action}`);
            
            logsCache = res.data.data;
            const pagination = res.data.pagination;
            totalPages = pagination.total_pages || 1;

            if (logsCache.length === 0) {
                emptyState.classList.remove('hidden');
            } else {
                tbody.innerHTML = logsCache.map((log, index) => {
                    const dtStr = new Date(log.created_at).toLocaleString('en-US', { month: 'short', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' });
                    // Extract a CUID or generic User ID from email/name to mimic screenshot, or just use name+ID
                    const userId = log.user_id ? `${(log.first_name || 'admin').toLowerCase()}${(log.last_name || '').toLowerCase()}${String(log.user_id).padStart(3, '0')}` : 'system001';
                    
                    const entity = log.entity_type ? `<span class="text-gray-700 font-medium capitalize">${log.entity_type}</span>` : '-';
                    const entityId = log.entity_id ? `<span class="text-gray-500 font-mono text-[11px]">${log.entity_id}</span>` : '-';
                    const detailsStr = (log.details && Object.keys(log.details).length > 0) ? JSON.stringify(log.details) : '';
                    
                    return `
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 align-middle text-sm text-gray-600">${dtStr}</td>
                            <td class="px-6 py-4 align-middle text-sm text-gray-600 font-mono">${userId}</td>
                            <td class="px-6 py-4 align-middle">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-orange-100 text-orange-700 border border-orange-200">
                                    ${log.action === 'updated_settings' ? 'UPDATE' : log.action.replace('_', ' ')}
                                </span>
                            </td>
                            <td class="px-6 py-4 align-middle">${entity}</td>
                            <td class="px-6 py-4 align-middle">${entityId}</td>
                            <td class="px-6 py-4 align-middle">
                                <span class="text-gray-500 font-mono text-[11px] truncate max-w-[200px] block" title='${detailsStr}'>${detailsStr}</span>
                            </td>
                        </tr>
                    `;
                }).join('');
            }

            pageInfo.textContent = `${pagination.total > 0 ? ((currentPage - 1) * perPage) + 1 : 0} - ${Math.min(currentPage * perPage, pagination.total)} of ${pagination.total}`;
            prevBtn.disabled = currentPage <= 1;
            nextBtn.disabled = currentPage >= totalPages;

        } catch (err) {
            console.error(err);
            errorBlock.textContent = err.message || 'Failed to load audit logs.';
            errorBlock.classList.remove('hidden');
        } finally {
            loading.classList.add('hidden');
        }
    }

    // Modal logic
    window.viewDetails = (index) => {
        const log = logsCache[index];
        if(!log) return;
        
        document.getElementById('modal-actor').textContent = log.first_name ? `${log.first_name} ${log.last_name || ''} (${log.email})` : 'System';
        document.getElementById('modal-ip').textContent = log.ip_address || '-';
        document.getElementById('modal-action').textContent = log.action;
        document.getElementById('modal-entity').textContent = log.entity_type ? `${log.entity_type} #${log.entity_id || ''}` : '-';
        
        document.getElementById('modal-json').textContent = JSON.stringify(log.details, null, 2);

        detailModal.classList.remove('hidden');
        setTimeout(() => detailModalInner.classList.replace('scale-95', 'scale-100'), 10);
    };

    const closeModal = () => {
        detailModalInner.classList.replace('scale-100', 'scale-95');
        setTimeout(() => detailModal.classList.add('hidden'), 200);
    };

    document.getElementById('close-modal').addEventListener('click', closeModal);
    document.getElementById('close-modal-btn').addEventListener('click', closeModal);
    detailModal.addEventListener('click', (e) => {
        if(e.target === detailModal) closeModal();
    });

    // Event Listeners
    let debounceTimer;
    searchInput.addEventListener('input', () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            currentPage = 1;
            loadLogs();
        }, 500);
    });

    actionFilter.addEventListener('change', () => {
        currentPage = 1;
        loadLogs();
    });

    refreshBtn.addEventListener('click', () => {
        loadLogs();
    });

    prevBtn.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            loadLogs();
        }
    });

    nextBtn.addEventListener('click', () => {
        if (currentPage < totalPages) {
            currentPage++;
            loadLogs();
        }
    });

    // Initial load
    loadLogs();
});
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
