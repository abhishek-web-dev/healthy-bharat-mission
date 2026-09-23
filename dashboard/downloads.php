<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Downloads - Healthy Bharat Mission</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="../dist/output.css" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../assets/images/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="../assets/images/favicon/favicon.svg" />
    <link rel="shortcut icon" href="../assets/images/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="../assets/images/favicon/site.webmanifest" />
</head>
<body class="font-body text-gray-800 bg-gray-50/50 antialiased min-h-screen flex flex-col">

    <hbm-header base-path="../"></hbm-header>

    <div class="flex-grow py-8 px-4 lg:px-8 max-w-[1500px] mx-auto w-full">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar -->
            <hbm-dashboard-sidebar active-page="downloads"></hbm-dashboard-sidebar>

            <!-- Main Content -->
            <div id="dashboard-main" class="flex-1 transition-opacity duration-300">
                
                <!-- Top Header Row -->
                <div class="flex flex-col lg:flex-row justify-between items-start gap-6 mb-8">
                    <!-- Title -->
                    <div class="flex items-start gap-4">
                        <div class="mt-1">
                            <i class="fa-solid fa-download text-3xl text-[#106e39]"></i>
                        </div>
                        <div>
                            <h2 class="text-3xl font-heading font-extrabold text-[#052b14]">Downloads</h2>
                            <p class="text-gray-500 font-medium text-[15px] mt-1">Access and download useful resources, guides, reports and educational materials.</p>
                        </div>
                    </div>
                    
                    <!-- Quote Box -->
                    <div class="bg-[#f2faf5] rounded-xl p-4 flex items-start gap-4 shrink-0" style="max-width: 384px;">
                        <div class="text-[#106e39] text-2xl mt-1">
                            <i class="fa-solid fa-leaf"></i>
                        </div>
                        <div>
                            <p class="font-bold text-[#106e39] text-[14px] leading-snug">"Knowledge today, a healthier tomorrow."</p>
                            <p class="text-[12px] text-[#106e39] opacity-80 mt-1">— Healthy Bharat Mission</p>
                        </div>
                    </div>
                </div>

                <!-- Main Grid Layout -->
                <div class="flex flex-col xl:flex-row gap-6">
                    
                    <!-- Left Column: Tabs & Table -->
                    <div class="w-full flex flex-col gap-6" style="width: 100%; max-width: 70%;">
                        <!-- Tabs -->
                        <div class="flex items-center gap-6 border-b border-gray-200 overflow-x-auto hide-scrollbar pb-px" id="download-tabs">
                            <button class="tab-btn active font-bold text-[#106e39] border-b-2 border-[#106e39] pb-3 whitespace-nowrap text-[15px]" data-tab="All">All Downloads</button>
                            <button class="tab-btn font-semibold text-gray-500 hover:text-gray-800 pb-3 whitespace-nowrap text-[15px] border-b-2 border-transparent" data-tab="Educational Guide">Educational Guides</button>
                            <button class="tab-btn font-semibold text-gray-500 hover:text-gray-800 pb-3 whitespace-nowrap text-[15px] border-b-2 border-transparent" data-tab="Meal Plan">Meal Plans</button>
                            <button class="tab-btn font-semibold text-gray-500 hover:text-gray-800 pb-3 whitespace-nowrap text-[15px] border-b-2 border-transparent" data-tab="Reports">Reports</button>
                            <button class="tab-btn font-semibold text-gray-500 hover:text-gray-800 pb-3 whitespace-nowrap text-[15px] border-b-2 border-transparent" data-tab="Forms">Forms</button>
                            <button class="tab-btn font-semibold text-gray-500 hover:text-gray-800 pb-3 whitespace-nowrap text-[15px] border-b-2 border-transparent" data-tab="Others">Others</button>
                        </div>

                        <!-- Table -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <!-- Table Header -->
                            <div class="bg-gray-50/80 px-6 py-4 flex items-center text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                                <div class="flex-1">File Name</div>
                                <div style="width: 140px;">Category</div>
                                <div style="width: 100px;">File Size</div>
                                <div style="width: 140px;" class="text-center">Action</div>
                            </div>
                            
                            <!-- Table Body -->
                            <div class="divide-y divide-gray-50" id="downloads-list">
                                <!-- JS injected downloads -->
                                <div class="px-6 py-8 text-center text-gray-500 text-sm" id="downloads-loading">
                                    <i class="fa-solid fa-spinner fa-spin text-xl mb-2 text-[#106e39]"></i><br>
                                    Loading your downloads...
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Sidebar -->
                    <div class="w-full flex flex-col gap-6" style="width: 100%; max-width: 30%; min-width: 300px;">
                        
                        <!-- Quick Access -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-lg bg-[#f2faf5] text-[#106e39] flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-file-invoice text-[15px]"></i>
                                </div>
                                <h3 class="font-bold text-gray-800 text-[16px]">Quick Access</h3>
                            </div>
                            <p class="text-[13px] text-gray-500 mb-5 ml-11">Frequently downloaded resources.</p>
                            
                            <div class="space-y-1">
                                <a href="#" class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 group transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-7 h-7 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                            <i class="fa-solid fa-file-pdf text-[12px]"></i>
                                        </div>
                                        <span class="text-[14px] font-medium text-gray-700 group-hover:text-gray-900 transition-colors">Diabetes Care Guide</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right text-[10px] text-gray-400 group-hover:text-gray-600"></i>
                                </a>
                                <a href="#" class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 group transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-7 h-7 rounded-full bg-green-50 text-[#106e39] flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                            <i class="fa-solid fa-file-pdf text-[12px]"></i>
                                        </div>
                                        <span class="text-[14px] font-medium text-gray-700 group-hover:text-gray-900 transition-colors">Healthy Eating Meal Plan</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right text-[10px] text-gray-400 group-hover:text-gray-600"></i>
                                </a>
                                <a href="#" class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 group transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-7 h-7 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                            <i class="fa-solid fa-file-pdf text-[12px]"></i>
                                        </div>
                                        <span class="text-[14px] font-medium text-gray-700 group-hover:text-gray-900 transition-colors">Exercise Guide</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right text-[10px] text-gray-400 group-hover:text-gray-600"></i>
                                </a>
                                <a href="#" class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 group transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-7 h-7 rounded-full bg-purple-50 text-purple-500 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                            <i class="fa-solid fa-file-excel text-[12px]"></i>
                                        </div>
                                        <span class="text-[14px] font-medium text-gray-700 group-hover:text-gray-900 transition-colors">Health Tracking Sheet</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right text-[10px] text-gray-400 group-hover:text-gray-600"></i>
                                </a>
                                <a href="#" class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 group transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-7 h-7 rounded-full bg-red-50 text-red-500 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                            <i class="fa-solid fa-file-pdf text-[12px]"></i>
                                        </div>
                                        <span class="text-[14px] font-medium text-gray-700 group-hover:text-gray-900 transition-colors">Consultation Report Template</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-right text-[10px] text-gray-400 group-hover:text-gray-600"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Your Downloads Progress -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-cloud-arrow-down text-[15px]"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800 text-[16px]">Your Downloads</h3>
                                    <p class="text-[12px] text-gray-500" id="stats-file-count">0 files downloaded</p>
                                </div>
                            </div>
                            
                            <div class="mt-5 mb-2">
                                <div class="w-full bg-gray-100 rounded-full h-2">
                                    <div id="stats-progress-bar" class="bg-[#106e39] h-2 rounded-full transition-all duration-500" style="width: 0%"></div>
                                </div>
                            </div>
                            <p class="text-[12px] font-medium text-gray-600 mb-5" id="stats-usage-text">0 MB of 100 MB used</p>
                            
                            <button class="w-full py-2.5 border border-[#106e39] text-[#106e39] font-bold text-[13px] rounded-lg hover:bg-[#106e39] hover:text-white transition-colors">
                                Manage Storage
                            </button>
                        </div>
                        
                        <!-- Need Help -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-headset text-[15px]"></i>
                                </div>
                                <h3 class="font-bold text-gray-800 text-[16px]">Need Help?</h3>
                            </div>
                            <p class="text-[13px] text-gray-500 mb-5 ml-11">Can't find what you're looking for?</p>
                            
                            <button class="w-full py-2.5 border border-green-200 text-[#106e39] font-bold text-[13px] rounded-lg hover:bg-[#106e39] hover:text-white transition-colors flex items-center justify-center gap-2">
                                Contact Support
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../js/api.js"></script>
    <script src="../js/components_v15.js"></script>
    <script src="../js/dashboard.js"></script>
    
        <script>
        // Global function to trigger safe download
        window.triggerSafeDownload = async function(url, filename) {
            try {
                // Ensure URL points to api baseUrl for absolute resolution if it's relative
                const absoluteUrl = url.startsWith('/') ? HBM_API.baseUrl.replace('/api', '') + url : url;
                
                const response = await fetch(absoluteUrl, { method: 'HEAD' });
                if (!response.ok) {
                    window.showNotification('File unavailable. It may have been deleted or moved.', 'error');
                    return;
                }
                
                const a = document.createElement('a');
                a.href = absoluteUrl;
                a.download = filename || 'download';
                // Some browsers require target blank for cross-origin downloads
                a.target = '_blank';
                document.body.appendChild(a);
                a.click();
                a.remove();
            } catch (err) {
                window.showNotification('File unavailable. It may have been deleted or moved.', 'error');
            }
        };

        document.addEventListener('DOMContentLoaded', async () => {
            const tabs = document.querySelectorAll('.tab-btn');
            const listContainer = document.getElementById('downloads-list');
            let allDocuments = [];

            // Helper to format bytes
            function formatBytes(bytes, decimals = 2) {
                if (!+bytes) return '0 Bytes';
                const k = 1024;
                const dm = decimals < 0 ? 0 : decimals;
                const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return \`${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}\`;
            }
            
            // Map db types to UI categories
            function getCategory(doc) {
                const type = (doc.document_type || 'other').toLowerCase();
                if (type.includes('guide')) return 'Educational Guide';
                if (type.includes('meal')) return 'Meal Plan';
                if (type.includes('report') || type.includes('invoice')) return 'Reports';
                if (type.includes('form')) return 'Forms';
                return 'Others';
            }

            function getIcon(category) {
                switch(category) {
                    case 'Educational Guide': return '<div class="w-10 h-10 rounded-lg bg-red-50 text-red-500 flex items-center justify-center shrink-0"><i class="fa-solid fa-file-pdf text-xl"></i></div>';
                    case 'Meal Plan': return '<div class="w-10 h-10 rounded-lg bg-green-50 text-[#106e39] flex items-center justify-center shrink-0"><i class="fa-solid fa-file-pdf text-xl"></i></div>';
                    case 'Reports': return '<div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center shrink-0"><i class="fa-solid fa-file-invoice text-xl"></i></div>';
                    case 'Forms': return '<div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-500 flex items-center justify-center shrink-0"><i class="fa-solid fa-file-lines text-xl"></i></div>';
                    default: return '<div class="w-10 h-10 rounded-lg bg-gray-100 text-gray-500 flex items-center justify-center shrink-0"><i class="fa-solid fa-file text-xl"></i></div>';
                }
            }

            function getBadgeStyle(category) {
                switch(category) {
                    case 'Educational Guide': return 'bg-red-50 text-red-600';
                    case 'Meal Plan': return 'bg-green-50 text-[#106e39]';
                    case 'Reports': return 'bg-blue-50 text-blue-600';
                    case 'Forms': return 'bg-purple-50 text-purple-600';
                    default: return 'bg-gray-100 text-gray-600';
                }
            }

            function renderRows(documents, filterCategory = 'All') {
                listContainer.innerHTML = '';
                let renderedCount = 0;
                
                documents.forEach(doc => {
                    const category = getCategory(doc);
                    if (filterCategory !== 'All' && category !== filterCategory) return;
                    
                    renderedCount++;
                    const sizeStr = formatBytes(doc.file_size || 0);
                    const safeUrl = doc.file_path ? doc.file_path.replace(/"/g, '&quot;') : '#';
                    const safeTitle = doc.title ? doc.title.replace(/"/g, '&quot;') : 'Document';
                    
                    const row = document.createElement('div');
                    row.className = 'download-row px-6 py-5 flex items-center hover:bg-slate-50/50 transition-colors';
                    row.innerHTML = \`
                        <div class="flex-1 flex items-start gap-4">
                            ${getIcon(category)}
                            <div>
                                <h4 class="font-bold text-gray-800 text-[14px]">${safeTitle}</h4>
                                <p class="text-[12px] text-gray-500 mt-0.5">Added on ${new Date(doc.created_at).toLocaleDateString()}</p>
                            </div>
                        </div>
                        <div style="width: 140px;">
                            <span class="${getBadgeStyle(category)} text-[11px] font-bold px-3 py-1.5 rounded-lg whitespace-nowrap">${category}</span>
                        </div>
                        <div style="width: 100px;">
                            <span class="text-[13px] font-medium text-gray-600">${sizeStr}</span>
                        </div>
                        <div style="width: 140px;" class="flex items-center justify-end gap-3">
                            <button onclick="triggerSafeDownload('${safeUrl}', '${safeTitle}')" class="flex items-center gap-2 px-4 py-2 border border-green-200 text-[#106e39] bg-white rounded-lg hover:bg-[#106e39] hover:text-white transition-colors text-[13px] font-bold shadow-sm">
                                <i class="fa-solid fa-download"></i> Download
                            </button>
                        </div>
                    \`;
                    listContainer.appendChild(row);
                });
                
                if (renderedCount === 0) {
                    listContainer.innerHTML = \`
                        <div class="px-6 py-12 text-center text-gray-500">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                                <i class="fa-solid fa-folder-open text-2xl"></i>
                            </div>
                            <h3 class="font-bold text-gray-700 text-base mb-1">No downloads found</h3>
                            <p class="text-sm">You haven't downloaded any ${filterCategory !== 'All' ? filterCategory.toLowerCase() + ' ' : ''}files yet.</p>
                        </div>
                    \`;
                }
            }

            function updateSidebarStats(documents) {
                const count = documents.length;
                const totalBytes = documents.reduce((sum, doc) => sum + (parseInt(doc.file_size) || 0), 0);
                const maxBytes = 100 * 1024 * 1024; // 100 MB quota
                const percent = Math.min(100, Math.round((totalBytes / maxBytes) * 100));
                
                document.getElementById('stats-file-count').textContent = count + ' files downloaded';
                document.getElementById('stats-progress-bar').style.width = percent + '%';
                
                const mbUsed = (totalBytes / (1024 * 1024)).toFixed(1);
                document.getElementById('stats-usage-text').textContent = mbUsed + ' MB of 100 MB used';
            }

            // Fetch real data
            try {
                const res = await HBM_API.request('/user/documents');
                if (res && res.success && res.data) {
                    allDocuments = res.data;
                    updateSidebarStats(allDocuments);
                    renderRows(allDocuments, 'All');
                } else {
                    throw new Error('Failed to load documents');
                }
            } catch (err) {
                console.error(err);
                listContainer.innerHTML = '<div class="px-6 py-8 text-center text-red-500">Failed to load downloads. Please try again.</div>';
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    // Update active tab styles
                    tabs.forEach(t => {
                        t.classList.remove('active', 'text-[#106e39]', 'border-[#106e39]');
                        t.classList.add('text-gray-500', 'border-transparent');
                    });
                    tab.classList.remove('text-gray-500', 'border-transparent');
                    tab.classList.add('active', 'text-[#106e39]', 'border-[#106e39]');
                    
                    // Filter rows
                    const category = tab.getAttribute('data-tab');
                    renderRows(allDocuments, category);
                });
            });
        });
    </script>
</body>
</html>