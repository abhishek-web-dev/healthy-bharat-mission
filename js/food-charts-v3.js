document.addEventListener('hbm:auth-ready', async () => {
    const container = document.getElementById('tab-content-meal-plan');
    const loading = document.getElementById('food-charts-loading');

    try {
        const response = await HBM_API.request('/user/food-charts');
        loading.classList.add('hidden');
        container.classList.remove('hidden');

        if (response.success && response.data) {
            renderFoodCharts(response.data);
        } else {
            container.innerHTML = `
                <div class="bg-yellow-50 text-yellow-800 p-6 rounded-xl border border-yellow-100 flex items-start gap-4">
                    <i class="fa-solid fa-bell text-2xl mt-1"></i>
                    <div>
                        <h3 class="text-lg font-bold mb-1">No Active Plan</h3>
                        <p class="text-[14px]">You do not have an active diet plan assigned yet. Please consult with your nutritionist.</p>
                    </div>
                </div>
            `;
        }
    } catch (error) {
        console.error('Failed to load food charts:', error);
        loading.classList.add('hidden');
        container.classList.remove('hidden');
        container.innerHTML = `
            <div class="bg-red-50 text-red-600 p-6 rounded-xl border border-red-100 flex items-start gap-4">
                <i class="fa-solid fa-triangle-exclamation text-2xl mt-1"></i>
                <div>
                    <h3 class="text-lg font-bold mb-1">Error Loading Plan</h3>
                    <p class="text-[14px]">There was an error loading your food chart data. Please try again.</p>
                </div>
            </div>
        `;
    }
});

function renderFoodCharts(data) {
    const container = document.getElementById('tab-content-meal-plan');
    
    // Calculate percentages for chart
    const carbsPct = parseInt(data.target_carbs_pct) || 0;
    const proteinPct = parseInt(data.target_protein_pct) || 0;
    const fatsPct = parseInt(data.target_fats_pct) || 0;
    const fiberPct = parseInt(data.target_fiber_pct) || 0;
    
    const r = 42;
    const c = 2 * Math.PI * r;
    
    const createCircle = (pct, offsetPct, color) => {
        if (pct === 0) return '';
        const gap = 2; // 2% gap
        const drawPct = Math.max(0, pct - gap);
        const dashArray = (drawPct / 100) * c;
        const dashOffset = -((offsetPct / 100) * c);
        return `<circle cx="50" cy="50" r="${r}" fill="transparent" stroke="${color}" stroke-width="8" stroke-dasharray="${dashArray} ${c}" stroke-dashoffset="${dashOffset}" class="transition-all duration-1000 ease-out" />`;
    };

    let currentOffset = 0;
    const carbsCircle = createCircle(carbsPct, currentOffset, '#10b981'); // Emerald 500
    currentOffset += carbsPct;
    const proteinCircle = createCircle(proteinPct, currentOffset, '#3b82f6'); // Blue 500
    currentOffset += proteinPct;
    const fatsCircle = createCircle(fatsPct, currentOffset, '#f59e0b'); // Amber 500
    currentOffset += fatsPct;
    const fiberCircle = createCircle(fiberPct, currentOffset, '#a855f7'); // Purple 500
    
    const donutHtml = `
        <div class="relative w-36 h-36 shrink-0 flex items-center justify-center">
            <svg viewBox="0 0 100 100" class="absolute inset-0 w-full h-full transform -rotate-90">
                <circle cx="50" cy="50" r="42" fill="transparent" stroke="#f3f4f6" stroke-width="8" />
                ${carbsCircle}
                ${proteinCircle}
                ${fatsCircle}
                ${fiberCircle}
            </svg>
            <div class="flex flex-col items-center justify-center text-center z-10 bg-white rounded-full w-24 h-24">
                <span class="font-bold text-gray-800 text-2xl leading-none">${data.total_calories_planned.toLocaleString()}</span>
                <span class="text-xs font-bold text-gray-800 mt-1 leading-none">kcal</span>
                <span class="text-[10px] text-gray-400 mt-1 leading-tight">of ${data.target_calories.toLocaleString()} kcal</span>
            </div>
        </div>
    `;

    let mealsHtml = '';
    if (data.meals && data.meals.length > 0) {
        data.meals.forEach((meal, index) => {
            const hasBorder = index !== data.meals.length - 1;
            mealsHtml += `
                <div class="flex items-center gap-4 py-4 ${hasBorder ? 'border-b border-gray-50' : ''}">
                    <img src="${meal.image_url}" alt="${meal.meal_type}" class="w-16 h-12 object-cover rounded-lg bg-gray-100 shrink-0 p-1" onerror="this.onerror=null; this.src='../assets/logo.webp'">
                    <div class="w-32 shrink-0">
                        <h4 class="font-bold text-gray-800 text-sm truncate">${meal.meal_type}</h4>
                        <p class="text-xs text-gray-500">${meal.time_range}</p>
                    </div>
                    <div class="text-gray-300 text-xs shrink-0 mx-2">:</div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-gray-800 text-sm truncate">${meal.name}</h4>
                        <p class="text-xs text-gray-500 truncate" title="${meal.description}">${meal.description}</p>
                    </div>
                    <div class="bg-green-50 text-[#106e39] font-bold text-xs px-3 py-1 rounded-md shrink-0">
                        ${meal.calories} kcal
                    </div>
                </div>
            `;
        });
    } else {
        mealsHtml = '<p class="text-gray-500 text-sm italic py-4">No meals assigned for today.</p>';
    }

    // Get today's date formatted (e.g., 15 Sep 2025)
    const today = new Date();
    const dateOptions = { day: 'numeric', month: 'short', year: 'numeric' };
    const formattedDate = today.toLocaleDateString('en-GB', dateOptions);

    container.innerHTML = `
        <!-- Banner -->
        <div class="bg-green-50 rounded-xl p-6 border border-green-100 flex items-center gap-4 mb-8">
            <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center border border-green-100 shrink-0 shadow-sm">
                <i class="fa-solid fa-clipboard-list text-[#106e39] text-xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-lg">${data.plan_name}</h3>
                <p class="text-gray-500 text-sm mt-0.5">${data.plan_description}</p>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Column: Meals -->
            <div class="flex-[2] bg-white rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 text-lg">Today's Meal Plan</h3>
                    <div class="flex items-center gap-3">
                        <span class="text-gray-500 text-sm font-medium">${formattedDate}</span>
                        <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                            <button class="px-2 py-1 bg-gray-50 hover:bg-gray-100 transition-colors border-r border-gray-200"><i class="fa-solid fa-chevron-left text-xs text-gray-500"></i></button>
                            <button class="px-2 py-1 bg-gray-50 hover:bg-gray-100 transition-colors"><i class="fa-solid fa-chevron-right text-xs text-gray-500"></i></button>
                        </div>
                    </div>
                </div>
                <div class="p-6 pt-2">
                    ${mealsHtml}
                </div>
            </div>

            <!-- Right Column: Nutrition & Actions -->
            <div class="flex-1 flex flex-col gap-6">
                <!-- Nutrition Summary -->
                <div class="bg-white rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-gray-800 text-lg">Today's Nutrition Summary</h3>
                        <a href="javascript:void(0)" class="text-xs font-bold text-gray-500 hover:text-[#106e39] underline decoration-gray-300 hover:decoration-[#106e39] transition-colors">View Details</a>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <!-- Chart -->
                        ${donutHtml}

                        <!-- Legend -->
                        <div class="flex-1 ml-6 space-y-3 text-sm">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 text-gray-600">
                                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div> Carbohydrates
                                </div>
                                <span class="font-bold text-gray-800">${carbsPct}%</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 text-gray-600">
                                    <div class="w-2.5 h-2.5 rounded-full bg-blue-500"></div> Protein
                                </div>
                                <span class="font-bold text-gray-800">${proteinPct}%</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 text-gray-600">
                                    <div class="w-2.5 h-2.5 rounded-full bg-amber-500"></div> Fats
                                </div>
                                <span class="font-bold text-gray-800">${fatsPct}%</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 text-gray-600">
                                    <div class="w-2.5 h-2.5 rounded-full bg-purple-500"></div> Fiber
                                </div>
                                <span class="font-bold text-gray-800">${fiberPct}%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tip -->
                <div class="bg-green-50 rounded-xl p-4 border border-green-100 flex gap-3 items-start">
                    <i class="fa-regular fa-lightbulb text-[#106e39] text-lg mt-0.5 shrink-0"></i>
                    <p class="text-sm text-green-800 leading-relaxed"><span class="font-bold text-[#106e39]">Tip:</span> ${data.tip_message}</p>
                </div>

                <!-- Quick Actions -->
                <div>
                    <h3 class="font-bold text-gray-800 text-base mb-3">Quick Actions</h3>
                    <div class="bg-white rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-100 overflow-hidden text-sm">
                        <a href="#" class="flex items-center justify-between p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors text-gray-700">
                            <div class="flex items-center gap-3">
                                <i class="fa-regular fa-file-pdf w-4 text-gray-400"></i> Download Meal Plan (PDF)
                            </div>
                            <i class="fa-solid fa-chevron-right text-xs text-gray-400"></i>
                        </a>
                        <a href="#" class="flex items-center justify-between p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors text-gray-700">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-utensils w-4 text-gray-400"></i> Explore Healthy Recipes
                            </div>
                            <i class="fa-solid fa-chevron-right text-xs text-gray-400"></i>
                        </a>
                        <a href="#" class="flex items-center justify-between p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors text-gray-700">
                            <div class="flex items-center gap-3">
                                <i class="fa-regular fa-user w-4 text-gray-400"></i> Talk to a Nutritionist
                            </div>
                            <i class="fa-solid fa-chevron-right text-xs text-gray-400"></i>
                        </a>
                        <a href="#" class="flex items-center justify-between p-4 hover:bg-gray-50 transition-colors text-gray-700">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-gear w-4 text-gray-400"></i> Update My Preferences
                            </div>
                            <i class="fa-solid fa-chevron-right text-xs text-gray-400"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    `;
}

function switchTab(tabId) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });

    // Reset all tab buttons to default state
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('border-[#106e39]', 'text-[#106e39]', 'font-bold');
        btn.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'font-medium');
    });

    // Show the selected tab content
    const selectedContent = document.getElementById(`tab-content-${tabId}`);
    if (selectedContent) {
        selectedContent.classList.remove('hidden');
    }

    // Update the selected tab button state
    const selectedBtn = document.getElementById(`tab-btn-${tabId}`);
    if (selectedBtn) {
        selectedBtn.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'font-medium');
        selectedBtn.classList.add('border-[#106e39]', 'text-[#106e39]', 'font-bold');
    }
}

// Make switchTab available globally since it's called from HTML onclick
window.switchTab = switchTab;
