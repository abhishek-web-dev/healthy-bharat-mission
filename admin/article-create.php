<?php require_once __DIR__ . '/components/admin-header.php'; ?>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <a href="articles.php" class="text-sm text-[#106e39] font-bold hover:underline mb-2 inline-block"><i class="fa-solid fa-arrow-left mr-1"></i> Back to Articles</a>
        <h2 class="text-2xl font-bold text-gray-800">Write New Article</h2>
        <p class="text-sm text-gray-500 mt-1">Create a new article for the Health Library.</p>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 relative">
    <div id="page-error" class="hidden mb-6 p-4 rounded-lg bg-red-50 text-red-600 text-sm font-medium border border-red-100"></div>
    
    <form id="article-form" class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content Column -->
            <div class="lg:col-span-2 space-y-6">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Article Title *</label>
                    <input type="text" id="article-title" required class="block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-lg font-bold transition-colors">
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Excerpt (Short Description)</label>
                    <textarea id="article-excerpt" rows="3" class="block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors custom-scrollbar" placeholder="A brief summary of the article..."></textarea>
                </div>
                
                <div class="mt-8">
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider">HTML Content <span class="text-red-500">*</span></label>
                        <span class="text-[10px] bg-green-100 text-green-700 px-2 py-1 rounded font-bold border border-green-200">Visual Editor</span>
                    </div>
                    <textarea id="article-content" rows="18" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-[#106e39] focus:ring-1 focus:ring-[#106e39] bg-gray-50 focus:bg-white transition-colors text-sm font-mono leading-relaxed resize-y"><h2>Introduction</h2>
<p>Write an engaging introduction here. It develops when your body becomes resistant... With the right knowledge and lifestyle changes, it can be effectively managed.</p>

<img src="assets/article_diabetes.png" alt="Healthy Diet" class="w-full rounded-xl my-8 shadow-sm border border-gray-100">

<h2>What is [Topic]?</h2>
<p>Explain the core concept here. Unlike type 1 diabetes, the body still produces insulin...</p>

<h2>Common Symptoms</h2>
<p>The symptoms can be mild at first. Some common signs include:</p>
<ul>
    <li>Increased thirst</li>
    <li>Frequent urination</li>
    <li>Unexplained weight loss</li>
</ul>

<h2>Causes and Risk Factors</h2>
<p>Several factors can increase the risk, including:</p>
<ul>
    <li>Being overweight or obese</li>
    <li>Physical inactivity</li>
    <li>Unhealthy diet</li>
</ul>

<h2>How to Manage It</h2>
<p>While there is no permanent cure, it can be managed with:</p>
<ul>
    <li>A balanced and nutritious diet</li>
    <li>Regular physical activity</li>
    <li>Stress management and adequate sleep</li>
</ul>

<div class="article-quote">
    <i class="fa-solid fa-leaf"></i>
    <p>"Small, consistent changes in your lifestyle can make a big difference in managing your health and living a happier life."</p>
</div>

<h2>Conclusion</h2>
<p>Early detection, a healthy lifestyle, and regular check-ups can help prevent complications and improve your quality of life.</p></textarea>
                </div>
            </div>
            
            <!-- Sidebar Column -->
            <div class="space-y-6">
                <div class="bg-gray-50 p-5 rounded-xl border border-gray-100 space-y-5">
                    <h4 class="font-bold text-gray-800 uppercase tracking-wider text-xs border-b border-gray-200 pb-2">Publishing Details</h4>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Status *</label>
                        <select id="article-status" required class="block w-full px-3 py-2.5 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm font-bold transition-colors bg-white">
                            <option value="draft">Draft (Hidden)</option>
                            <option value="published">Published (Visible)</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Category</label>
                        <select id="article-category" class="block w-full px-3 py-2.5 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors bg-white">
                            <option value="">Select a category</option>
                            <!-- Populated by JS -->
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">URL Slug *</label>
                        <input type="text" id="article-slug" required class="block w-full px-3 py-2.5 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm transition-colors bg-white" placeholder="e.g. healthy-eating-tips">
                        <p class="text-[10px] text-gray-500 mt-1">This will be the URL: /article.php?slug=<strong>your-slug</strong></p>
                    </div>
                    
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Reading Time (Minutes) <span class="text-red-500">*</span></label>
                        <input type="number" id="article-read-time" value="5" min="1" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-[#106e39] focus:ring-1 focus:ring-[#106e39] bg-gray-50 focus:bg-white transition-colors text-sm font-medium">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Featured Image URL</label>
                        <input type="text" id="article-image-url" placeholder="e.g. assets/cond_diabetes.png or https://..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-[#106e39] focus:ring-1 focus:ring-[#106e39] bg-gray-50 focus:bg-white transition-colors text-sm font-medium">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3 sticky bottom-0 bg-white pb-4 z-10">
            <a href="articles.php" class="px-6 py-2.5 bg-white border border-gray-200 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors">Cancel</a>
            <button type="submit" id="save-article-btn" class="px-8 py-2.5 bg-[#106e39] border border-transparent rounded-lg text-sm font-bold text-white hover:bg-[#0b5028] transition-colors flex items-center gap-2 shadow-sm">
                <span id="save-btn-text">Save Draft</span>
                <i id="save-btn-spinner" class="fa-solid fa-spinner fa-spin hidden"></i>
            </button>
        </div>
    </form>
</div>

<!-- TinyMCE CDN (Open Source via cdnjs) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    // Initialize TinyMCE
    tinymce.init({
        selector: '#article-content',
        plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
        menubar: 'file edit view insert format tools table help',
        toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
        toolbar_sticky: true,
        autosave_ask_before_unload: true,
        autosave_interval: '30s',
        autosave_prefix: '{path}{query}-{id}-',
        autosave_restore_when_empty: false,
        autosave_retention: '2m',
        image_advtab: true,
        height: 600,
        image_caption: true,
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        noneditable_class: 'mceNonEditable',
        toolbar_mode: 'sliding',
        contextmenu: 'link image table',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
        promotion: false
    });

    const form = document.getElementById('article-form');
    const errorMsg = document.getElementById('page-error');
    const categorySelect = document.getElementById('article-category');
    const statusSelect = document.getElementById('article-status');
    const titleInput = document.getElementById('article-title');
    const slugInput = document.getElementById('article-slug');
    const btnText = document.getElementById('save-btn-text');
    
    // Auto-generate slug
    titleInput.addEventListener('input', function(e) {
        const slug = e.target.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
        slugInput.value = slug;
    });
    
    // Dynamic button text
    statusSelect.addEventListener('change', function(e) {
        btnText.textContent = e.target.value === 'published' ? 'Publish Article' : 'Save ' + e.target.value.charAt(0).toUpperCase() + e.target.value.slice(1);
    });

    async function loadCategories() {
        try {
            const res = await window.HBM_API.request('/article-categories');
            if (res.data) {
                categorySelect.innerHTML = '<option value="">Select a category</option>' + 
                    res.data.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
            }
        } catch (err) {
            console.warn("Could not load categories", err);
            // Fallback: try loading from articles list if no direct endpoint exists
            try {
                const aRes = await window.HBM_API.request('/admin/articles');
                if (aRes.data && aRes.data.data) {
                    const uniqueCats = [...new Set(aRes.data.data.filter(a => a.category_name && a.category_id).map(a => JSON.stringify({id: a.category_id, name: a.category_name})))];
                    categorySelect.innerHTML = '<option value="">Select a category</option>' + 
                        uniqueCats.map(c => JSON.parse(c)).map(c => `<option value="${c.id}">${c.name}</option>`).join('');
                }
            } catch(e) {}
        }
    }
    
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const payload = {
            title: titleInput.value.trim(),
            slug: slugInput.value.trim(),
            excerpt: document.getElementById('article-excerpt').value.trim(),
            content: tinymce.get('article-content').getContent(),
            category_id: categorySelect.value || null,
            image_url: document.getElementById('article-image-url').value || null,
            status: statusSelect.value,
            read_time_minutes: parseInt(document.getElementById('article-read-time').value) || 5
        };
        
        const submitBtn = document.getElementById('save-article-btn');
        const btnSpinner = document.getElementById('save-btn-spinner');
        
        submitBtn.disabled = true;
        const originalText = btnText.textContent;
        btnText.textContent = 'Saving...';
        btnSpinner.classList.remove('hidden');
        errorMsg.classList.add('hidden');
        
        try {
            await window.HBM_API.request('/admin/articles', 'POST', payload);
            window.location.href = 'articles.php'; // redirect back on success
        } catch (err) {
            errorMsg.textContent = err.message || 'An error occurred while creating the article.';
            errorMsg.classList.remove('hidden');
            
            submitBtn.disabled = false;
            btnText.textContent = originalText;
            btnSpinner.classList.add('hidden');
            window.scrollTo(0,0);
        }
    });

    loadCategories();
});
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
