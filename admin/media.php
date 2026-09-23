<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Media Library</h2>
        <p class="text-sm text-gray-500 mt-1">Manage images, documents, and other uploaded assets.</p>
    </div>
    <div class="flex items-center gap-3">
        <button class="bg-[#106e39] text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-[#0b5028] transition-colors flex items-center gap-2 opacity-50 cursor-not-allowed">
            <i class="fa-solid fa-cloud-arrow-up"></i> Upload Media
        </button>
    </div>
</div>

<!-- Placeholder State -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden p-12 text-center">
    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 text-3xl mx-auto mb-4">
        <i class="fa-solid fa-images"></i>
    </div>
    <h3 class="font-bold text-gray-800 text-xl mb-2">Media Module Under Construction</h3>
    <p class="text-gray-500 max-w-md mx-auto text-sm leading-relaxed mb-6">
        The centralized media management library is currently being integrated. 
        In the meantime, media can be uploaded directly within specific modules (like Products and Articles) during their creation or editing flow.
    </p>
    <a href="dashboard.php" class="inline-block px-5 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-lg text-sm hover:bg-gray-200 transition-colors">
        Return to Dashboard
    </a>
</div>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
