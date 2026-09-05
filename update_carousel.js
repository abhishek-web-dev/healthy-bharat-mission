const fs = require('fs');

let html = fs.readFileSync('index.html', 'utf8');

// 1. Update the container to have an id and proper flex classes for a scrolling carousel
html = html.replace(
    /class="max-w-\[1150px\] mx-auto flex overflow-x-auto pb-8 -mx-4 px-4 lg:mx-0 lg:px-0 lg:justify-center lg:items-stretch gap-4 xl:gap-6 snap-x hide-scrollbar"/,
    'id="success-carousel" class="flex overflow-x-auto pb-8 -mx-4 px-4 lg:mx-0 lg:px-0 gap-4 xl:gap-6 snap-x hide-scrollbar scroll-smooth w-full"'
);

// 2. Remove the lg:hidden class from story 4 and add w-max
html = html.replace(
    /class="min-w-\[320px\] lg:hidden bg-white rounded-2xl shadow-\[0_2px_12px_rgba\(0,0,0,0.05\)\] border border-gray-100 p-5 xl:p-6 flex flex-row items-center space-x-5 xl:space-x-6 snap-center text-left relative"/g,
    'class="min-w-[320px] lg:min-w-0 w-max bg-white rounded-2xl shadow-[0_2px_12px_rgba(0,0,0,0.05)] border border-gray-100 p-6 flex flex-row items-center space-x-5 xl:space-x-6 snap-center text-left relative"'
);

// 3. Extract the 4 stories
const story1Match = html.match(/<!-- Story 1 -->[\s\S]*?<!-- Story 2 -->/);
const story2Match = html.match(/<!-- Story 2 -->[\s\S]*?<!-- Story 3 -->/);
const story3Match = html.match(/<!-- Story 3 -->[\s\S]*?<!-- Story 4 .*?-->/);
const story4Match = html.match(/<!-- Story 4 .*?-->[\s\S]*?(?=<\/div>\s*<!-- Arrow button for carousel -->)/);

if (story1Match && story2Match && story3Match && story4Match) {
    const storiesToAppend = `
                <!-- Story 5 -->
${story1Match[0].replace('<!-- Story 1 -->', '').replace('<!-- Story 2 -->', '')}
                <!-- Story 6 -->
${story2Match[0].replace('<!-- Story 2 -->', '').replace('<!-- Story 3 -->', '')}
                <!-- Story 7 -->
${story3Match[0].replace('<!-- Story 3 -->', '').replace(/<!-- Story 4 .*?-->/, '')}
                <!-- Story 8 -->
${story4Match[0].replace(/<!-- Story 4 .*?-->/, '')}
`;
    // Insert after Story 4
    html = html.replace(/(<!-- Story 4 .*?-->[\s\S]*?)(?=<\/div>\s*<!-- Arrow button for carousel -->)/, `$1${storiesToAppend}`);
}

// 4. Remove the Arrow Button
html = html.replace(/<!-- Arrow button for carousel -->\s*<button[\s\S]*?<\/button>/, '');

// 5. Add Auto-slide script right before the closing body tag
const script = `
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const carousel = document.getElementById('success-carousel');
            if (!carousel) return;
            
            let isDown = false;
            let startX;
            let scrollLeft;
            
            // Auto slide functionality
            let autoSlideInterval;
            
            const startAutoSlide = () => {
                autoSlideInterval = setInterval(() => {
                    if (!carousel) return;
                    const maxScroll = carousel.scrollWidth - carousel.clientWidth;
                    if (carousel.scrollLeft >= maxScroll - 10) {
                        carousel.scrollTo({ left: 0, behavior: 'smooth' });
                    } else {
                        // Find the width of one card + gap (approx 340 + 24 = 364)
                        carousel.scrollBy({ left: 350, behavior: 'smooth' });
                    }
                }, 3000);
            };
            
            const stopAutoSlide = () => {
                clearInterval(autoSlideInterval);
            };
            
            // Start it initially
            startAutoSlide();
            
            // Pause on hover or touch
            carousel.addEventListener('mouseenter', stopAutoSlide);
            carousel.addEventListener('mouseleave', startAutoSlide);
            carousel.addEventListener('touchstart', stopAutoSlide, {passive: true});
            carousel.addEventListener('touchend', startAutoSlide, {passive: true});
        });
    </script>
</body>`;

html = html.replace(/<\/body>/, script);

fs.writeFileSync('index.html', html);
console.log("Updated index.html");
