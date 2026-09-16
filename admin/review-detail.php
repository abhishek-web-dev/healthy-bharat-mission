<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <a href="reviews.php" class="text-gray-400 hover:text-[#106e39] transition-colors"><i class="fa-solid fa-arrow-left"></i></a>
            <h2 class="text-2xl font-bold text-gray-800">Review Detail</h2>
        </div>
        <p class="text-sm text-gray-500 mt-1">View complete details and manage this review.</p>
    </div>
    <div class="flex items-center gap-3">
        <div id="status-badge-container">
            <!-- Badge injected here -->
        </div>
    </div>
</div>

<div id="review-loading" class="py-12 text-center text-gray-400">
    <i class="fa-solid fa-circle-notch fa-spin text-3xl mb-3 text-[#106e39]"></i>
    <p class="font-medium text-gray-500">Loading review details...</p>
</div>

<div id="review-error" class="hidden py-12 text-center">
    <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center mx-auto text-red-500 text-xl mb-3">
        <i class="fa-solid fa-triangle-exclamation"></i>
    </div>
    <h3 class="font-bold text-gray-800 text-lg mb-1">Unable to load review</h3>
    <p class="text-sm text-gray-500 mb-4" id="review-error-msg">The review could not be found.</p>
    <a href="reviews.php" class="text-sm font-bold text-[#106e39] hover:underline">Back to Reviews</a>
</div>

<div id="review-content" class="hidden grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content Column -->
    <div class="lg:col-span-2 flex flex-col gap-6">
        
        <!-- Review Card -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm flex flex-col">
            <div class="p-4 sm:p-6 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center shrink-0">
                <h3 class="font-bold text-gray-800 uppercase tracking-wider text-sm">Customer Review</h3>
            </div>
            <div class="p-6">
                <!-- Rating -->
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex text-xl tracking-wider" id="detail-stars">
                        <!-- Stars -->
                    </div>
                    <span class="text-gray-500 font-medium text-sm" id="detail-rating-text">5 out of 5</span>
                </div>
                
                <!-- Title -->
                <h4 class="text-xl font-bold text-gray-900 mb-3" id="detail-title">Review Title</h4>
                
                <!-- Content -->
                <div class="prose max-w-none text-gray-700 mb-6 whitespace-pre-wrap leading-relaxed" id="detail-content">
                    Full review content goes here...
                </div>
                
                <!-- Date -->
                <div class="text-sm text-gray-400 mt-auto pt-4 border-t border-gray-50">
                    Submitted on: <span class="font-medium text-gray-600" id="detail-date">Date</span>
                </div>
            </div>
            
            <!-- Actions -->
            <div id="action-area" class="p-6 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row flex-wrap gap-3 hidden">
                <button onclick="approveReview()" id="btn-approve" class="bg-[#106e39] text-white px-5 py-2.5 rounded-lg font-bold hover:bg-[#0c572b] transition-colors shadow-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-check"></i> Approve & Publish
                </button>
                <button onclick="openRejectModal()" id="btn-reject" class="bg-white border border-red-200 text-red-600 px-5 py-2.5 rounded-lg font-bold hover:bg-red-50 transition-colors shadow-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-times"></i> Reject Review
                </button>
            </div>
        </div>
        
    </div>
    
    <!-- Right Sidebar Column -->
    <div class="lg:col-span-1 flex flex-col gap-6">
        
        <!-- Customer Info -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="font-bold text-gray-800 uppercase tracking-wider text-xs">Customer Information</h3>
            </div>
            <div class="p-4 space-y-4">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Customer Name</p>
                    <p class="font-medium text-gray-800" id="customer-name">Name</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Email</p>
                    <a href="mailto:" id="customer-email" class="font-medium text-[#106e39] hover:underline break-all">Email</a>
                </div>
            </div>
        </div>
        
        <!-- Product Info -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="font-bold text-gray-800 uppercase tracking-wider text-xs">Product Information</h3>
            </div>
            <div class="p-4">
                <div class="aspect-square w-full max-w-[250px] mx-auto bg-gray-100 rounded-lg mb-4 flex items-center justify-center overflow-hidden" id="product-img-container">
                    <i class="fa-solid fa-box text-gray-300 text-4xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Product Name</p>
                    <p class="font-medium text-gray-800 mb-3" id="product-name">Product Name</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">SKU</p>
                    <p class="font-medium text-gray-600" id="product-sku">SKU</p>
                </div>
                <div id="product-variant-container" class="mt-3 hidden">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Variant</p>
                    <p class="font-medium text-gray-600 inline-block px-2 py-1 bg-gray-100 rounded text-xs" id="product-variant">Variant</p>
                </div>
            </div>
        </div>
        
    </div>
</div>

<!-- Reject Confirmation Modal -->
<div id="reject-modal" class="fixed inset-0 bg-gray-900/50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 overflow-hidden transform scale-95 opacity-0 transition-all duration-200" id="reject-modal-content">
        <div class="p-6">
            <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center text-red-500 text-xl mb-4">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Reject Review?</h3>
            <p class="text-gray-500">Are you sure you want to reject this customer review? It will be permanently hidden from the public store.</p>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex gap-3 justify-end">
            <button onclick="closeRejectModal()" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                Cancel
            </button>
            <button onclick="rejectReview()" id="btn-confirm-reject" class="px-4 py-2 bg-red-600 text-white rounded-lg font-bold hover:bg-red-700 transition-colors flex items-center gap-2">
                Reject Review
            </button>
        </div>
    </div>
</div>

<script>
let currentReviewId = null;

document.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    currentReviewId = params.get('id');
    
    if (!currentReviewId) {
        showError("No review ID provided.");
        return;
    }
    
    loadReviewDetails();
});

function loadReviewDetails() {
    window.HBM_API.request(`/admin/reviews/${currentReviewId}`)
        .then(res => {
            document.getElementById('review-loading').classList.add('hidden');
            if (res.success && res.data.review) {
                renderDetails(res.data.review);
            } else {
                showError(res.message || "Review not found.");
            }
        })
        .catch(err => {
            console.error(err);
            document.getElementById('review-loading').classList.add('hidden');
            showError("Failed to connect to the server.");
        });
}

function renderDetails(r) {
    document.getElementById('review-content').classList.remove('hidden');
    
    // Status Badge
    const badgeContainer = document.getElementById('status-badge-container');
    if (r.status === 'approved') {
        badgeContainer.innerHTML = `<span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-bold bg-green-50 text-green-700 border border-green-200 shadow-sm"><span class="w-2 h-2 rounded-full bg-green-500"></span> Approved</span>`;
    } else if (r.status === 'rejected') {
        badgeContainer.innerHTML = `<span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-bold bg-red-50 text-red-700 border border-red-200 shadow-sm"><span class="w-2 h-2 rounded-full bg-red-500"></span> Rejected</span>`;
    } else {
        badgeContainer.innerHTML = `<span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-bold bg-orange-50 text-orange-700 border border-orange-200 shadow-sm"><span class="w-2 h-2 rounded-full bg-orange-500"></span> Pending</span>`;
    }
    
    // Stars
    let stars = '';
    for (let i = 1; i <= 5; i++) {
        if (i <= r.rating) stars += '<i class="fa-solid fa-star text-yellow-400"></i>';
        else stars += '<i class="fa-regular fa-star text-gray-300"></i>';
    }
    document.getElementById('detail-stars').innerHTML = stars;
    document.getElementById('detail-rating-text').textContent = `${r.rating} out of 5`;
    
    // Content
    document.getElementById('detail-title').textContent = r.title;
    document.getElementById('detail-content').textContent = r.content; // textContent for safety against XSS
    
    const dateObj = new Date(r.created_at);
    document.getElementById('detail-date').textContent = dateObj.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
    
    // Customer
    document.getElementById('customer-name').textContent = r.reviewer_name;
    const emailEl = document.getElementById('customer-email');
    emailEl.textContent = r.reviewer_email;
    emailEl.href = `mailto:${r.reviewer_email}`;
    
    // Product
    document.getElementById('product-name').textContent = r.product_name;
    document.getElementById('product-sku').textContent = r.product_sku || 'N/A';
    
    if (r.variant) {
        document.getElementById('product-variant-container').classList.remove('hidden');
        document.getElementById('product-variant').textContent = r.variant;
    }
    
    if (r.product_image) {
        document.getElementById('product-img-container').innerHTML = `<img src="${r.product_image}" class="w-full h-full object-cover">`;
    }
    
    // Actions
    const actionArea = document.getElementById('action-area');
    if (r.status === 'pending') {
        actionArea.classList.remove('hidden');
    } else {
        actionArea.classList.add('hidden');
    }
}

function showError(msg) {
    document.getElementById('review-error').classList.remove('hidden');
    document.getElementById('review-error-msg').textContent = msg;
}

function updateStatus(status, btnId, originalText) {
    const btn = document.getElementById(btnId);
    btn.disabled = true;
    btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> Processing...`;
    
    window.HBM_API.request(`/admin/reviews/${currentReviewId}/status`, 'PUT', { status: status })
        .then(res => {
            if (res.success) {
                // Refresh data
                loadReviewDetails();
                if (status === 'rejected') closeRejectModal();
                
                // Show success feedback
                const notification = document.createElement('div');
                notification.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg font-bold z-50 flex items-center gap-3 animate-fade-in-up';
                notification.innerHTML = `<i class="fa-solid fa-check-circle"></i> Review ${status} successfully.`;
                document.body.appendChild(notification);
                setTimeout(() => {
                    notification.classList.add('opacity-0', 'translate-y-2', 'transition-all');
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            } else {
                alert(res.message || "Failed to update review status.");
            }
        })
        .catch(err => {
            console.error(err);
            alert("An error occurred while updating the status.");
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
}

function approveReview() {
    updateStatus('approved', 'btn-approve', '<i class="fa-solid fa-check"></i> Approve & Publish');
}

function rejectReview() {
    updateStatus('rejected', 'btn-confirm-reject', 'Reject Review');
}

function openRejectModal() {
    const modal = document.getElementById('reject-modal');
    const content = document.getElementById('reject-modal-content');
    modal.classList.remove('hidden');
    // small delay for transition
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeRejectModal() {
    const modal = document.getElementById('reject-modal');
    const content = document.getElementById('reject-modal-content');
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 200);
}
</script>

<style>
@keyframes fade-in-up {
    from { opacity: 0; transform: translateY(1rem); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-up {
    animation: fade-in-up 0.3s ease-out forwards;
}
</style>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
