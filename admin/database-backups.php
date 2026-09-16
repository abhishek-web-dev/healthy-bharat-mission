<?php 
require_once __DIR__ . '/components/admin-auth.php';

$pageTitle = 'Database Backups';
require_once __DIR__ . '/components/admin-header.php'; 
?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Database Backups</h2>
        <p class="text-sm text-gray-500 mt-1">Create, manage and securely download database backups.</p>
    </div>
    
    <?php if (isset($GLOBALS['adminUser']['permissions']) && in_array('create_backups', $GLOBALS['adminUser']['permissions'])): ?>
    <button id="btn-take-backup" class="bg-[#106e39] hover:bg-[#0c592c] text-white px-5 py-2.5 rounded-lg text-sm font-bold transition-all shadow-sm hover:shadow-md flex items-center gap-2">
        <i class="fa-solid fa-cloud-arrow-up"></i> 
        <span id="btn-backup-text">Take Backup Now</span>
    </button>
    <?php endif; ?>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Automation Settings Card -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden h-full">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-[#106e39]"></i> Automation Settings
                </h3>
            </div>
            <div class="p-6">
                <form id="automation-form" class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Enable Automated Backups</label>
                            <p class="text-xs text-gray-500">Requires server cron job configuration</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="auto-backup-enabled" class="sr-only">
                            <div id="toggle-bg" class="w-11 h-6 bg-gray-200 rounded-full transition-colors"></div>
                            <span id="toggle-dot" class="absolute left-[2px] top-[2px] bg-white border border-gray-300 w-5 h-5 rounded-full transition-transform shadow-sm pointer-events-none"></span>
                        </label>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Daily Backup Time</label>
                        <input type="time" id="auto-backup-time" class="block w-full pl-3 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
                        <p class="text-xs text-gray-500 mt-1">Server timezone: <?php echo date_default_timezone_get(); ?></p>
                    </div>
                    
                    <?php if (isset($GLOBALS['adminUser']['permissions']) && in_array('create_backups', $GLOBALS['adminUser']['permissions'])): ?>
                    <button type="submit" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-sm font-bold transition-all mt-4">
                        Save Settings
                    </button>
                    <?php endif; ?>
                </form>

                <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
                    <h4 class="text-xs font-bold text-blue-800 uppercase tracking-wider mb-2">Notice</h4>
                    <p class="text-xs text-blue-600 leading-relaxed">
                        Database restore is intentionally not exposed through the Admin UI yet as a security precaution. 
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Backup History Card -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden h-full flex flex-col">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-list text-gray-500"></i> Backup History
                </h3>
            </div>
            <div class="flex-1 overflow-x-auto">
                <table class="w-full text-left border-collapse" id="backups-table">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500">
                            <th class="px-6 py-4 font-bold">Date / Time</th>
                            <th class="px-6 py-4 font-bold">File</th>
                            <th class="px-6 py-4 font-bold">Size</th>
                            <th class="px-6 py-4 font-bold">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 tracking-wider text-right">Download</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm" id="backups-tbody">
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                <i class="fa-solid fa-spinner fa-spin text-2xl mb-2"></i>
                                <p>Loading backups...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <!-- Empty State -->
                <div id="empty-state" class="hidden flex-col items-center justify-center p-12 text-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                        <i class="fa-solid fa-database text-3xl text-gray-300"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">No backups yet</h3>
                    <p class="text-gray-500 text-sm max-w-md mx-auto mb-6">Your database backups will appear here.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tbody = document.getElementById('backups-tbody');
    const emptyState = document.getElementById('empty-state');
    const tableHeader = document.querySelector('#backups-table thead');
    const btnBackup = document.getElementById('btn-take-backup');
    const btnBackupText = document.getElementById('btn-backup-text');
    const automationForm = document.getElementById('automation-form');
    
    const autoBackupCheckbox = document.getElementById('auto-backup-enabled');
    const toggleBg = document.getElementById('toggle-bg');
    const toggleDot = document.getElementById('toggle-dot');

    function updateToggleUI() {
        if (autoBackupCheckbox.checked) {
            toggleBg.classList.remove('bg-gray-200');
            toggleBg.classList.add('bg-[#106e39]');
            toggleDot.style.transform = 'translateX(20px)';
            toggleDot.classList.add('border-white');
            toggleDot.classList.remove('border-gray-300');
        } else {
            toggleBg.classList.add('bg-gray-200');
            toggleBg.classList.remove('bg-[#106e39]');
            toggleDot.style.transform = 'translateX(0)';
            toggleDot.classList.remove('border-white');
            toggleDot.classList.add('border-gray-300');
        }
    }

    autoBackupCheckbox.addEventListener('change', updateToggleUI);

    function formatBytes(bytes, decimals = 2) {
        if (!+bytes) return '0 Bytes';
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`;
    }

    function getStatusBadge(status) {
        switch(status) {
            case 'SUCCESS': return '<span class="px-2.5 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider border bg-green-100 text-green-700 border-green-200">Success</span>';
            case 'IN_PROGRESS': return '<span class="px-2.5 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider border bg-blue-100 text-blue-700 border-blue-200">In Progress <i class="fa-solid fa-spinner fa-spin ml-1"></i></span>';
            case 'FAILED': return '<span class="px-2.5 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider border bg-red-100 text-red-700 border-red-200">Failed</span>';
            default: return `<span class="px-2.5 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider border bg-gray-100 text-gray-700 border-gray-200">${status}</span>`;
        }
    }

    async function fetchBackups() {
        try {
            const res = await window.HBM_API.request('/admin/backups');
            if (res.data) {
                // Populate settings
                document.getElementById('auto-backup-enabled').checked = (res.data.settings.backup_automated_enabled === 'true');
                document.getElementById('auto-backup-time').value = res.data.settings.backup_daily_time || '02:00';
                updateToggleUI(); // Sync UI with fetched state
                
                // Populate table
                const backups = res.data.backups || [];
                if (backups.length === 0) {
                    tbody.innerHTML = '';
                    tableHeader.style.display = 'none';
                    emptyState.classList.remove('hidden');
                    emptyState.classList.add('flex');
                    return;
                }
                
                emptyState.classList.add('hidden');
                emptyState.classList.remove('flex');
                tableHeader.style.display = 'table-header-group';
                
                tbody.innerHTML = backups.map(b => {
                    const dateObj = new Date(b.created_at);
                    const date = dateObj.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
                    const time = dateObj.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
                    
                    const canDownload = b.status === 'SUCCESS';
                    
                    return `
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-800 text-sm">${date}</p>
                                <p class="text-xs text-gray-500">${time}</p>
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-gray-600 truncate max-w-[200px]" title="${b.filename}">
                                ${b.filename}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                ${formatBytes(b.file_size)}
                            </td>
                            <td class="px-6 py-4">
                                ${getStatusBadge(b.status)}
                                ${b.error_message ? `<p class="text-[10px] text-red-500 mt-1 truncate max-w-[150px]" title="${b.error_message}">${b.error_message}</p>` : ''}
                            </td>
                            <td class="px-6 py-4 text-right">
                                ${canDownload ? `
                                <a href="/api/admin/backups/${b.id}/download" target="_blank" class="px-3 py-1.5 text-xs font-bold rounded-lg bg-[#106e39]/10 text-[#106e39] border border-[#106e39]/20 hover:bg-[#106e39] hover:text-white transition-colors inline-flex items-center gap-1" title="Download Backup">
                                    <i class="fa-solid fa-download"></i> Download
                                </a>
                                ` : '<span class="text-xs text-gray-400 italic">Unavailable</span>'}
                            </td>
                        </tr>
                    `;
                }).join('');
            }
        } catch (error) {
            console.error("Failed to fetch backups", error);
            tbody.innerHTML = `<tr><td colspan="5" class="px-6 py-8 text-center text-red-500 font-medium">Failed to load backups. Please try again.</td></tr>`;
        }
    }
    
    if (btnBackup) {
        btnBackup.addEventListener('click', async () => {
            if (!confirm("Are you sure you want to take a database backup now? This might take a few moments.")) return;
            
            const originalHtml = btnBackup.innerHTML;
            btnBackup.disabled = true;
            btnBackup.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Creating backup...';
            btnBackup.classList.add('opacity-75', 'cursor-not-allowed');
            
            try {
                const res = await window.HBM_API.request('/admin/backups', 'POST');
                alert('Backup created successfully.');
                fetchBackups();
            } catch (error) {
                alert('Backup failed: ' + (error.message || 'Check server configuration.'));
            } finally {
                btnBackup.disabled = false;
                btnBackup.innerHTML = originalHtml;
                btnBackup.classList.remove('opacity-75', 'cursor-not-allowed');
            }
        });
    }

    if (automationForm) {
        automationForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = automationForm.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.textContent = 'Saving...';
            
            try {
                await window.HBM_API.request('/admin/backups/settings', 'PUT', {
                    backup_automated_enabled: document.getElementById('auto-backup-enabled').checked,
                    backup_daily_time: document.getElementById('auto-backup-time').value
                });
                // Temporarily show success
                btn.textContent = 'Saved!';
                btn.classList.replace('bg-gray-100', 'bg-green-100');
                btn.classList.replace('text-gray-800', 'text-green-800');
                
                setTimeout(() => {
                    btn.textContent = 'Save Settings';
                    btn.classList.replace('bg-green-100', 'bg-gray-100');
                    btn.classList.replace('text-green-800', 'text-gray-800');
                    btn.disabled = false;
                }, 2000);
            } catch (error) {
                alert('Failed to save settings: ' + (error.message || 'Unknown error'));
                btn.disabled = false;
                btn.textContent = 'Save Settings';
            }
        });
    }

    // Init
    fetchBackups();
});
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
