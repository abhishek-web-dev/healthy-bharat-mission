// content.js - Handles dynamic content fetching for health library, programs, etc.

document.addEventListener('DOMContentLoaded', async () => {
    const path = window.location.pathname;

    if (path.includes('healthlibrary.html')) {
        await initArticles();
    } else if (path.includes('program.html')) {
        await initPrograms();
    } else if (path.includes('health-condition.html')) {
        await initHealthConditions();
    } else if (path.includes('successtories.html')) {
        await initSuccessStories();
    }
});

async function initArticles() {
    try {
        const res = await window.HBM_API.request('/articles');
        const articles = res.data;
        const grid = document.querySelector('.grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3');
        if (grid && articles.length > 0) {
            grid.innerHTML = articles.map(a => `
                <article class="bg-white rounded-3xl overflow-hidden shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] flex flex-col group hover:shadow-[0_12px_40px_-5px_rgba(0,0,0,0.1)] transition-all duration-300 transform hover:-translate-y-1">
                    <div class="relative h-[220px] lg:h-[240px] overflow-hidden">
                        <img src="${a.image_url || 'https://via.placeholder.com/400'}" alt="${a.title}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-6 lg:p-8 flex flex-col flex-grow relative">
                        <h3 class="font-heading font-bold text-[19px] lg:text-[21px] text-[#0f3057] leading-tight mb-4 group-hover:text-primary transition-colors line-clamp-2">
                            ${a.title}
                        </h3>
                        <p class="text-gray-500 text-sm leading-relaxed mb-6 flex-grow line-clamp-3">
                            ${a.excerpt || ''}
                        </p>
                    </div>
                </article>
            `).join('');
        }
    } catch (err) {
        console.error("Failed to load articles", err);
    }
}

async function initPrograms() {
    try {
        const res = await window.HBM_API.request('/programs');
        const programs = res.data;
        const grids = document.querySelectorAll('.grid');
        let programGrid = null;
        grids.forEach(g => {
            if (g.children.length > 0 && g.children[0].tagName === 'DIV' && g.innerHTML.includes('bg-white')) {
                programGrid = g;
            }
        });
        
        if (programGrid && programs.length > 0) {
            programGrid.innerHTML = programs.map(p => `
                <div class="bg-white rounded-3xl p-6 lg:p-8 border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.08)] transition-all duration-300 flex flex-col">
                    <h3 class="font-heading font-bold text-xl lg:text-2xl text-gray-900 mb-3">${p.title}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed flex-grow mb-6">${p.description || ''}</p>
                    <div class="text-2xl font-black text-primary mb-6">₹${p.price}</div>
                    <button class="w-full py-3.5 bg-primary hover:bg-primary-light text-white font-bold rounded-xl text-[15px] transition-colors shadow-md">
                        Enroll Now
                    </button>
                </div>
            `).join('');
        }
    } catch (err) {
        console.error("Failed to load programs", err);
    }
}

async function initHealthConditions() {
    try {
        const res = await window.HBM_API.request('/health-conditions');
        const conditions = res.data;
        const grid = document.querySelector('.grid');
        if (grid && conditions.length > 0) {
            grid.innerHTML = conditions.map(c => `
                <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.04)] border border-gray-50 flex flex-col">
                    <h3 class="font-heading font-bold text-xl text-gray-900 mb-3">${c.name}</h3>
                    <p class="text-gray-600 text-[15px] leading-relaxed mb-5 flex-grow line-clamp-4">${c.description}</p>
                </div>
            `).join('');
        }
    } catch (err) {
        console.error("Failed to load conditions", err);
    }
}

async function initSuccessStories() {
    try {
        const res = await window.HBM_API.request('/success-stories');
        const stories = res.data;
        const grid = document.querySelector('.grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3');
        if (grid && stories.length > 0) {
            grid.innerHTML = stories.map(s => `
                <div class="bg-white rounded-[2rem] p-8 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] border border-gray-50 relative">
                    <i class="fa-solid fa-quote-left text-5xl text-primary/10 absolute top-6 right-8"></i>
                    <p class="text-gray-600 italic text-[15px] leading-relaxed mb-8 relative z-10">"${s.story}"</p>
                    <div class="flex items-center gap-4">
                        <div>
                            <h4 class="font-bold text-gray-900 text-base">${s.name || 'Anonymous'}</h4>
                        </div>
                    </div>
                </div>
            `).join('');
        }
    } catch (err) {
        console.error("Failed to load success stories", err);
    }
}


