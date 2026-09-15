<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Welcome, <?php echo htmlspecialchars($GLOBALS['adminUser']['first_name']); ?>!</h2>
        <p class="text-sm text-gray-500 mt-1">Here is the overview of the Healthy Bharat Mission platform.</p>
    </div>

    <div class="bg-white rounded-lg border border-gray-100 px-4 py-2 flex items-center gap-3 text-sm shadow-sm">
        <i class="fa-regular fa-calendar text-gray-400"></i>
        <span class="font-medium text-gray-600 font-mono"><?php echo date('d M Y, h:i A'); ?></span>
    </div>
</div>

<div id="dashboard-loading" class="flex flex-col items-center justify-center p-12">
    <i class="fa-solid fa-spinner fa-spin text-4xl text-[#106e39] mb-4"></i>
    <p class="text-gray-500 font-medium">Compiling dashboard statistics...</p>
</div>

<div id="dashboard-error" class="hidden bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl mb-6">
    <p class="font-bold"><i class="fa-solid fa-triangle-exclamation mr-2"></i> Error loading dashboard</p>
    <p class="text-sm mt-1" id="dashboard-error-msg">Please check your connection and try again.</p>
</div>

<div id="dashboard-content" class="hidden">
    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        
        <!-- Users -->
        <a href="users.php" class="block bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md hover:border-blue-200 transition-all group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Users</p>
                    <h3 class="text-2xl font-bold text-gray-800" id="stat-total-users">-</h3>
                    <p class="text-xs font-medium text-green-600 mt-1"><span id="stat-active-users">-</span> active</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
        </a>

        <!-- Appointments -->
        <a href="appointments.php" class="block bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md hover:border-orange-200 transition-all group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Pending Appointments</p>
                    <h3 class="text-2xl font-bold text-gray-800" id="stat-pending-apts">-</h3>
                    <p class="text-xs font-medium text-gray-500 mt-1">out of <span id="stat-total-apts">-</span> total</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fa-regular fa-calendar-check"></i>
                </div>
            </div>
        </a>

        <!-- Orders -->
        <a href="orders.php" class="block bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md hover:border-purple-200 transition-all group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Pending Orders</p>
                    <h3 class="text-2xl font-bold text-gray-800" id="stat-pending-orders">-</h3>
                    <p class="text-xs font-medium text-gray-500 mt-1">out of <span id="stat-total-orders">-</span> total</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-shopping-cart"></i>
                </div>
            </div>
        </a>

        <!-- Contact Inquiries -->
        <a href="contact-inquiries.php" class="block bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md hover:border-red-200 transition-all group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Pending Inquiries</p>
                    <h3 class="text-2xl font-bold text-gray-800 text-red-600" id="stat-pending-inquiries">-</h3>
                    <p class="text-xs font-medium text-gray-500 mt-1">Needs attention</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-red-50 text-red-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-headset"></i>
                </div>
            </div>
        </a>

        <!-- Experts -->
        <a href="experts.php" class="block bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md hover:border-teal-200 transition-all group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Experts</p>
                    <h3 class="text-2xl font-bold text-gray-800" id="stat-experts">-</h3>
                    <p class="text-xs font-medium text-teal-600 mt-1"><span id="stat-active-experts">-</span> active</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-user-md"></i>
                </div>
            </div>
        </a>

        <!-- Products -->
        <a href="products.php" class="block bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md hover:border-green-200 transition-all group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Active Products</p>
                    <h3 class="text-2xl font-bold text-gray-800" id="stat-products">-</h3>
                    <p class="text-xs font-medium text-gray-500 mt-1">In store</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-box-open"></i>
                </div>
            </div>
        </a>

        <!-- Programs -->
        <a href="programs.php" class="block bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Programs</p>
                    <h3 class="text-2xl font-bold text-gray-800" id="stat-programs">-</h3>
                    <p class="text-xs font-medium text-gray-500 mt-1">Available</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-dumbbell"></i>
                </div>
            </div>
        </a>

        <!-- Newsletter -->
        <a href="newsletter-subscribers.php" class="block bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md hover:border-yellow-200 transition-all group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Subscribers</p>
                    <h3 class="text-2xl font-bold text-gray-800" id="stat-subscribers">-</h3>
                    <p class="text-xs font-medium text-green-600 mt-1">Active list</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-yellow-50 text-yellow-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Additional Data: Content row -->
    <div class="bg-gray-800 text-white rounded-xl p-4 mb-8 shadow-sm flex flex-wrap gap-6 items-center justify-center text-sm font-medium">
        <p><i class="fa-solid fa-book-medical text-gray-400 mr-2"></i> Published Articles: <span class="font-bold text-[#106e39] ml-1" id="stat-articles">-</span></p>
        <span class="w-1 h-1 rounded-full bg-gray-500"></span>
        <p><i class="fa-solid fa-notes-medical text-gray-400 mr-2"></i> Health Conditions: <span class="font-bold text-[#106e39] ml-1" id="stat-conditions">-</span></p>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Left Col -->
        <div class="space-y-6">
            <!-- Recent Appointments -->
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-800"><i class="fa-regular fa-calendar-check mr-2 text-gray-400"></i> Recent Appointments</h3>
                    <a href="appointments.php" class="text-xs font-bold text-[#106e39] hover:underline">View All</a>
                </div>
                <ul class="divide-y divide-gray-100" id="recent-appointments-list">
                    <!-- Populated by JS -->
                </ul>
            </div>

            <!-- Recent Inquiries -->
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-800"><i class="fa-regular fa-envelope mr-2 text-gray-400"></i> Recent Inquiries</h3>
                    <a href="contact-inquiries.php" class="text-xs font-bold text-[#106e39] hover:underline">View All</a>
                </div>
                <ul class="divide-y divide-gray-100" id="recent-inquiries-list">
                    <!-- Populated by JS -->
                </ul>
            </div>
        </div>

        <!-- Right Col -->
        <div class="space-y-6">
            <!-- Recent Orders -->
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden h-full">
                <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-800"><i class="fa-solid fa-shopping-bag mr-2 text-gray-400"></i> Recent Orders</h3>
                    <a href="orders.php" class="text-xs font-bold text-[#106e39] hover:underline">View All</a>
                </div>
                <ul class="divide-y divide-gray-100" id="recent-orders-list">
                    <!-- Populated by JS -->
                </ul>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    const loading = document.getElementById('dashboard-loading');
    const content = document.getElementById('dashboard-content');
    const errorBlock = document.getElementById('dashboard-error');
    const errorMsg = document.getElementById('dashboard-error-msg');

    try {
        const res = await window.HBM_API.request('/admin/dashboard-stats');
        
        if (!res.data || !res.data.stats) {
            throw new Error('Invalid dashboard data structure received.');
        }

        const stats = res.data.stats;
        const activity = res.data.recent_activity;

        // Populate Stats
        document.getElementById('stat-total-users').textContent = stats.total_users || 0;
        document.getElementById('stat-active-users').textContent = stats.active_users || 0;
        document.getElementById('stat-experts').textContent = stats.total_experts || 0;
        document.getElementById('stat-active-experts').textContent = stats.active_experts || 0;
        document.getElementById('stat-programs').textContent = stats.total_programs || 0;
        document.getElementById('stat-products').textContent = stats.active_products || 0;
        document.getElementById('stat-total-orders').textContent = stats.total_orders || 0;
        document.getElementById('stat-pending-orders').textContent = stats.pending_orders || 0;
        document.getElementById('stat-total-apts').textContent = stats.total_appointments || 0;
        document.getElementById('stat-pending-apts').textContent = stats.pending_appointments || 0;
        document.getElementById('stat-pending-inquiries').textContent = stats.pending_inquiries || 0;
        document.getElementById('stat-subscribers').textContent = stats.active_subscribers || 0;
        document.getElementById('stat-articles').textContent = stats.published_articles || 0;
        document.getElementById('stat-conditions').textContent = stats.active_health_conditions || 0;

        // Status badge helper
        const getStatusBadge = (status) => {
            const styles = {
                'pending': 'bg-orange-100 text-orange-700',
                'confirmed': 'bg-blue-100 text-blue-700',
                'completed': 'bg-green-100 text-green-700',
                'cancelled': 'bg-gray-100 text-gray-500',
                'delivered': 'bg-green-100 text-green-700',
                'shipped': 'bg-blue-100 text-blue-700',
                'in_progress': 'bg-blue-100 text-blue-700',
                'resolved': 'bg-green-100 text-green-700',
                'spam': 'bg-gray-100 text-gray-500'
            };
            const s = styles[status] || 'bg-gray-100 text-gray-700';
            return `<span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider ${s}">${status}</span>`;
        };

        const formatDate = (dateStr) => {
            const d = new Date(dateStr);
            return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) + ' ' + d.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        };

        // Populate Recent Orders
        const ordersList = document.getElementById('recent-orders-list');
        if (activity.orders && activity.orders.length > 0) {
            ordersList.innerHTML = activity.orders.map(o => `
                <li class="p-4 hover:bg-gray-50 transition-colors flex items-center justify-between gap-4">
                    <div class="overflow-hidden">
                        <p class="font-bold text-gray-800 text-sm truncate">${o.first_name} ${o.last_name}</p>
                        <p class="text-xs text-gray-500 truncate mt-0.5">Order #${o.id} • ₹${parseFloat(o.total_amount).toFixed(2)}</p>
                    </div>
                    <div class="text-right shrink-0">
                        <div class="mb-1">${getStatusBadge(o.status)}</div>
                        <p class="text-[10px] text-gray-400 font-mono">${formatDate(o.created_at)}</p>
                    </div>
                </li>
            `).join('');
        } else {
            ordersList.innerHTML = '<li class="p-8 text-center text-sm text-gray-400">No recent orders</li>';
        }

        // Populate Recent Appointments
        const aptsList = document.getElementById('recent-appointments-list');
        if (activity.appointments && activity.appointments.length > 0) {
            aptsList.innerHTML = activity.appointments.map(a => `
                <li class="p-4 hover:bg-gray-50 transition-colors flex items-center justify-between gap-4">
                    <div class="overflow-hidden">
                        <p class="font-bold text-gray-800 text-sm truncate">${a.patient_first_name} ${a.patient_last_name}</p>
                        <p class="text-xs text-gray-500 truncate mt-0.5">with Dr. ${a.expert_first_name} ${a.expert_last_name}</p>
                    </div>
                    <div class="text-right shrink-0">
                        <div class="mb-1">${getStatusBadge(a.status)}</div>
                        <p class="text-[10px] text-gray-400 font-mono">${new Date(a.appointment_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' })} ${a.appointment_time}</p>
                    </div>
                </li>
            `).join('');
        } else {
            aptsList.innerHTML = '<li class="p-8 text-center text-sm text-gray-400">No recent appointments</li>';
        }

        // Populate Recent Inquiries
        const inqList = document.getElementById('recent-inquiries-list');
        if (activity.inquiries && activity.inquiries.length > 0) {
            inqList.innerHTML = activity.inquiries.map(i => `
                <li class="p-4 hover:bg-gray-50 transition-colors flex items-center justify-between gap-4">
                    <div class="overflow-hidden">
                        <p class="font-bold text-gray-800 text-sm truncate">${i.name}</p>
                        <p class="text-xs text-gray-500 truncate mt-0.5">${i.subject}</p>
                    </div>
                    <div class="text-right shrink-0">
                        <div class="mb-1">${getStatusBadge(i.status)}</div>
                        <p class="text-[10px] text-gray-400 font-mono">${formatDate(i.created_at)}</p>
                    </div>
                </li>
            `).join('');
        } else {
            inqList.innerHTML = '<li class="p-8 text-center text-sm text-gray-400">No recent inquiries</li>';
        }

        // Show content
        loading.classList.add('hidden');
        content.classList.remove('hidden');

    } catch (e) {
        console.error(e);
        loading.classList.add('hidden');
        errorMsg.textContent = e.message || 'An unknown error occurred.';
        errorBlock.classList.remove('hidden');
    }
});
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
