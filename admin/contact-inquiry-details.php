<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <a href="contact-inquiries.php" class="text-gray-400 hover:text-[#106e39] transition-colors"><i class="fa-solid fa-arrow-left"></i></a>
            <h2 class="text-2xl font-bold text-gray-800">Inquiry Details</h2>
        </div>
        <p class="text-sm text-gray-500 mt-1 font-mono" id="page-inquiry-id">Loading...</p>
    </div>
    <div id="header-status-badge"></div>
</div>

<!-- Loading Overlay -->
<div id="page-loading" class="py-12 text-center text-gray-400">
    <i class="fa-solid fa-circle-notch fa-spin text-3xl mb-3 text-[#106e39]"></i>
    <p class="font-medium text-gray-500">Fetching inquiry details...</p>
</div>

<div id="page-error" class="hidden py-12 text-center">
    <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center mx-auto text-red-500 text-xl mb-3">
        <i class="fa-solid fa-triangle-exclamation"></i>
    </div>
    <h3 class="font-bold text-gray-800 text-lg mb-1">Unable to load inquiry</h3>
    <p class="text-sm text-gray-500 mb-4" id="page-error-msg">The inquiry could not be found.</p>
    <a href="contact-inquiries.php" class="text-sm font-bold text-[#106e39] hover:underline">Back to Inquiries</a>
</div>

<div id="page-content" class="hidden grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Message -->
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
            <h3 class="text-lg font-bold text-gray-800 mb-4 pb-4 border-b border-gray-100 flex items-center gap-2">
                <i class="fa-regular fa-message text-[#106e39]"></i> Message Subject: <span id="detail-subject" class="font-normal text-gray-600"></span>
            </h3>
            <div id="detail-message" class="bg-gray-50 p-4 rounded-lg border border-gray-100 whitespace-pre-wrap text-sm text-gray-700 font-serif leading-relaxed"></div>
        </div>

        <!-- Sender Details -->
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
            <h3 class="text-lg font-bold text-gray-800 mb-4 pb-4 border-b border-gray-100 flex items-center gap-2">
                <i class="fa-regular fa-address-card text-[#106e39]"></i> Sender Information
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Full Name</h4>
                    <p class="text-base font-medium text-gray-800" id="detail-name">-</p>
                </div>
                <div>
                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Email Address</h4>
                    <a href="#" id="detail-email" class="text-base font-medium text-[#106e39] hover:underline">-</a>
                </div>
                <div>
                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Phone Number</h4>
                    <p class="text-base font-medium text-gray-800" id="detail-phone">-</p>
                </div>
                <div>
                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Date Submitted</h4>
                    <p class="text-base text-gray-800" id="detail-date">-</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Actions & Status -->
    <div class="space-y-6">
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-bars-progress text-gray-400"></i> Manage Status
            </h3>
            <form id="status-form" class="space-y-4">
                <div id="status-error" class="hidden p-3 rounded-lg bg-red-50 text-red-600 text-sm font-medium border border-red-100"></div>
                <div id="status-success" class="hidden p-3 rounded-lg bg-green-50 text-green-700 text-sm font-medium border border-green-100"></div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Current Status</label>
                    <select id="detail-status" class="block w-full pl-3 pr-10 py-2.5 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm bg-gray-50 focus:bg-white transition-colors">
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="resolved">Resolved</option>
                        <option value="spam">Spam</option>
                    </select>
                </div>
                <button type="submit" id="save-status-btn" class="w-full py-2.5 bg-[#106e39] border border-transparent rounded-lg text-sm font-bold text-white hover:bg-[#0b5028] transition-colors flex justify-center items-center gap-2">
                    <i class="fa-solid fa-save"></i> Update Status
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const inquiryId = urlParams.get('id');

    const loadingEl = document.getElementById('page-loading');
    const contentEl = document.getElementById('page-content');
    const errorEl = document.getElementById('page-error');
    const errorMsgEl = document.getElementById('page-error-msg');
    const form = document.getElementById('status-form');
    const submitBtn = document.getElementById('save-status-btn');
    const statusError = document.getElementById('status-error');
    const statusSuccess = document.getElementById('status-success');

    if (!inquiryId) {
        showError("Invalid inquiry ID.");
        return;
    }

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

    async function loadInquiry() {
        try {
            const res = await window.HBM_API.request(`/admin/contact-inquiries/${inquiryId}`);
            if (res && res.data) {
                // API single item response places the object directly in res.data
                renderInquiry(res.data);
                loadingEl.classList.add('hidden');
                contentEl.classList.remove('hidden');
                contentEl.classList.add('grid');
            } else {
                throw new Error("Invalid response from server");
            }
        } catch (err) {
            showError(err.message || 'Failed to load inquiry details.');
        }
    }

    function renderInquiry(i) {
        document.getElementById('page-inquiry-id').textContent = `Inquiry #${i.id}`;
        document.getElementById('detail-name').textContent = i.name;
        document.getElementById('detail-email').textContent = i.email;
        document.getElementById('detail-email').href = `mailto:${i.email}`;
        document.getElementById('detail-phone').textContent = i.phone || 'N/A';
        document.getElementById('detail-subject').textContent = i.subject;
        document.getElementById('detail-message').textContent = i.message;
        document.getElementById('detail-date').textContent = new Date(i.created_at).toLocaleString();
        
        document.getElementById('detail-status').value = i.status;

        const badgeClass = statusStyles[i.status] || statusStyles['pending'];
        const badgeLabel = statusLabels[i.status] || i.status;
        document.getElementById('header-status-badge').innerHTML = `<span class="px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider border ${badgeClass}">${badgeLabel}</span>`;
    }

    function showError(msg) {
        loadingEl.classList.add('hidden');
        contentEl.classList.add('hidden');
        contentEl.classList.remove('grid');
        errorEl.classList.remove('hidden');
        errorMsgEl.textContent = msg;
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const newStatus = document.getElementById('detail-status').value;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
        statusError.classList.add('hidden');
        statusSuccess.classList.add('hidden');

        try {
            await window.HBM_API.request(`/admin/contact-inquiries/${inquiryId}`, 'PUT', { status: newStatus });
            
            statusSuccess.textContent = "Status updated successfully!";
            statusSuccess.classList.remove('hidden');
            
            // Re-render badge immediately
            const badgeClass = statusStyles[newStatus] || statusStyles['pending'];
            const badgeLabel = statusLabels[newStatus] || newStatus;
            document.getElementById('header-status-badge').innerHTML = `<span class="px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider border ${badgeClass}">${badgeLabel}</span>`;
            
            setTimeout(() => {
                statusSuccess.classList.add('hidden');
            }, 3000);
        } catch (err) {
            statusError.textContent = err.message || 'An error occurred while updating the status.';
            statusError.classList.remove('hidden');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fa-solid fa-save"></i> Update Status';
        }
    });

    loadInquiry();
});
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
