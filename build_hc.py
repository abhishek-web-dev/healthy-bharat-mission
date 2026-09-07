import re

file_path = "/media/abhishekn/New Volume/BKM/Healthy_Mission_Bharat/frontend/program.html"
new_file_path = "/media/abhishekn/New Volume/BKM/Healthy_Mission_Bharat/frontend/health-condition.html"

with open(file_path, "r") as f:
    content = f.read()

# Replace title
content = content.replace("<title>Programs - Healthy Bharat Mission</title>", "<title>Health Conditions - Healthy Bharat Mission</title>")

# The main content sits between <!-- Header Area --> ... </hbm-header> and <!-- Footer Area -->
# Let's extract everything up to </hbm-header> and from <!-- Footer Area --> downwards.

header_end = "</hbm-header>\n"
footer_start = "    <!-- Footer Area -->"

header_part = content[:content.find(header_end) + len(header_end)]
footer_part = content[content.find(footer_start):]

hero_banner_html = """
    <main>
        <!-- Health Conditions Hero Banner -->
        <section class="relative w-full h-[600px] flex items-center overflow-hidden bg-white">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img src="./assets/Health-condition-banner.png" alt="Health Conditions Background" class="w-full h-full object-cover object-center">
            </div>
            
            <!-- Gradient Overlay (To ensure text readability on the left) -->
            <div class="absolute inset-0 z-10 bg-gradient-to-r from-white/95 via-white/80 to-transparent w-full md:w-[75%] lg:w-[65%]"></div>

            <div class="container mx-auto px-6 lg:px-12 xl:px-20 relative z-20 h-full flex flex-col justify-center">
                <div class="max-w-[700px] pt-8">
                    <!-- Eyebrow -->
                    <span class="inline-block text-[11px] md:text-[13px] font-extrabold tracking-[0.25em] text-[#0b4d28] uppercase mb-4 md:mb-5">
                        Better Understanding. Brighter Health.
                    </span>
                    
                    <!-- Main Title -->
                    <h1 class="text-4xl md:text-5xl lg:text-[64px] font-extrabold text-[#052b14] leading-[1.1] mb-3 tracking-tight">
                        Health Conditions
                    </h1>
                    
                    <!-- Subtitle -->
                    <h2 class="text-xl md:text-2xl font-bold text-[#0f3057] mb-5">
                        Expert Insights for a Healthier You
                    </h2>
                    
                    <!-- Description -->
                    <p class="text-gray-700 text-base md:text-lg leading-relaxed mb-10 max-w-[600px] font-medium">
                        Learn about common health conditions, their causes, symptoms and natural ways to manage them with the right nutrition, lifestyle and expert guidance.
                    </p>
                    
                    <!-- Search Form -->
                    <div class="relative w-full max-w-[600px] mb-6 shadow-[0_8px_30px_rgb(0,0,0,0.08)] rounded-full">
                        <input type="text" placeholder="Search for a health condition..." 
                            class="w-full h-14 md:h-16 pl-6 md:pl-8 pr-16 md:pr-20 rounded-full border border-gray-200 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500/20 text-gray-700 text-sm md:text-base bg-white transition-all">
                        <button type="submit" class="absolute right-1 top-1 bottom-1 w-12 md:w-16 bg-[#106e39] hover:bg-[#0b4d28] text-white rounded-full flex items-center justify-center transition-colors">
                            <i class="fa-solid fa-magnifying-glass text-lg"></i>
                        </button>
                    </div>
                    
                    <!-- Popular Searches -->
                    <div class="flex flex-wrap items-center gap-2 md:gap-3">
                        <span class="text-sm font-bold text-[#052b14] mr-1">Popular Searches:</span>
                        <a href="#" class="px-4 py-1.5 rounded-full border border-gray-200 bg-white/80 hover:bg-[#f2f8f3] hover:border-green-200 text-gray-600 text-[13px] font-medium transition-colors">Diabetes</a>
                        <a href="#" class="px-4 py-1.5 rounded-full border border-gray-200 bg-white/80 hover:bg-[#f2f8f3] hover:border-green-200 text-gray-600 text-[13px] font-medium transition-colors">PCOS</a>
                        <a href="#" class="px-4 py-1.5 rounded-full border border-gray-200 bg-white/80 hover:bg-[#f2f8f3] hover:border-green-200 text-gray-600 text-[13px] font-medium transition-colors">Thyroid</a>
                        <a href="#" class="px-4 py-1.5 rounded-full border border-gray-200 bg-white/80 hover:bg-[#f2f8f3] hover:border-green-200 text-gray-600 text-[13px] font-medium transition-colors">Blood Pressure</a>
                        <a href="#" class="px-4 py-1.5 rounded-full border border-gray-200 bg-white/80 hover:bg-[#f2f8f3] hover:border-green-200 text-gray-600 text-[13px] font-medium transition-colors">Fatty Liver</a>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Placeholder for future content -->
        <section class="py-20 bg-gray-50 text-center">
            <p class="text-gray-500 font-medium">Additional health condition content will go here.</p>
        </section>
    </main>
"""

new_content = header_part + hero_banner_html + footer_part

with open(new_file_path, "w") as f:
    f.write(new_content)

print("Created health-condition.html")
