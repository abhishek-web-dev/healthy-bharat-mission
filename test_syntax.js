// --- Global Styles Injection ---
(function () {
    if (document.getElementById('hbm-global-styles')) return;
    const style = document.createElement('style');
    style.id = 'hbm-global-styles';
    style.textContent = `
        /* Global Theme Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #106e39;
        }
        
        /* Global utility overrides to preserve expected behaviors */
        .hide-scrollbar::-webkit-scrollbar,
        .scrollbar-hide::-webkit-scrollbar {
            display: none !important;
        }
        .hide-scrollbar,
        .scrollbar-hide {
            -ms-overflow-style: none !important;
            scrollbar-width: none !important;
        }
    `;
    document.head.appendChild(style);
})();
// -----------------------------

class HbmHeader extends HTMLElement {
    connectedCallback() {
        const basePath = this.getAttribute('base-path') || '';
        const imgPath = this.getAttribute('base-path') || './';

        this.style.display = 'contents';
        this.innerHTML = `<header class="bg-white/95 backdrop-blur-md shadow-sm border-b border-gray-200 sticky top-0 z-50">
        
        <!-- Top Bar -->
        <div class="w-full bg-primary text-white hidden md:block">
            <div class="container mx-auto max-w-[1500px] px-4 lg:px-8 py-2 flex justify-between items-center text-sm">
                <!-- Left Side -->
                <div class="flex items-center space-x-5">
                    <a href="tel:+919876543210" class="flex items-center space-x-2 font-medium hover:text-gray-200 transition-colors">
                        <i class="fa-solid fa-phone text-xs"></i>
                        <span class="tracking-wide">+91 98765 43210</span>
                    </a>
                    <div class="w-px h-4 bg-white/30"></div>
                    <div class="flex items-center space-x-3">
                        <span class="text-white/90 text-[13px]">Follow Us:</span>
                        <div class="flex space-x-3">
                            <a href="#" class="hover:text-gray-300 transition-colors"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#" class="hover:text-gray-300 transition-colors"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#" class="hover:text-gray-300 transition-colors"><i class="fa-brands fa-youtube"></i></a>
                            <a href="#" class="hover:text-gray-300 transition-colors"><i class="fa-brands fa-discord"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Right Side -->
                <div class="flex items-center space-x-5 font-medium text-[13px]" id="hbm-auth-container">
                    <!-- Auth content injected via JS below -->
                </div>
            </div>
        </div>

        <div class="container mx-auto max-w-[1500px] relative">
            <!-- Main Navigation -->
            <div class="px-2 lg:px-8 py-4 flex justify-between items-center">
                <!-- Logo -->
                <a href="${basePath}index" class="flex items-center space-x-2 xl:space-x-3 -mt-2 group">
                    <img src="${imgPath}assets/images/logo.png" alt="Logo" class="flex-shrink-0 transition-transform group-hover:scale-105" style="height: 60px; width: auto;">
                    <div>
                        <h1
                            class="font-heading font-bold text-[17px] xl:text-[20px] text-slate-800 leading-tight mb-0.5 whitespace-nowrap group-hover:text-primary transition-colors">
                            Healthy Bharat Mission</h1>
                        <p class="text-[9px] xl:text-[11px] text-gray-500 font-medium tracking-wide whitespace-nowrap">
                            Towards a Diabetes Free India</p>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <div
                    class="hidden lg:flex space-x-3 xl:space-x-6 items-center font-medium text-[13px] xl:text-sm text-slate-700">
                    <a href="${basePath}index"
                        class="nav-link hover:text-primary transition-colors whitespace-nowrap">Home</a>
                    <a href="${basePath}mission" class="nav-link hover:text-primary transition-colors whitespace-nowrap">Our Mission</a>
                    <!-- Programs Dropdown -->
                    <div class="relative group">
                        <a href="${basePath}program"
                            class="nav-link hover:text-primary transition-colors flex items-center whitespace-nowrap py-4 -my-4">Programs <i
                                class="fa-solid fa-chevron-down text-[10px] ml-1.5 transition-transform group-hover:rotate-180"></i></a>
                        
                        <div class="absolute top-[calc(100%+1rem)] left-0 w-64 bg-white rounded-xl shadow-[0_10px_40px_rgba(0,0,0,0.1)] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 border border-gray-100 z-50 transform origin-top translate-y-2 group-hover:translate-y-0">
                            <!-- invisible bridge to prevent hover loss -->
                            <div class="absolute -top-4 left-0 w-full h-4"></div>
                            
                            <div class="p-2 space-y-1">
                                <a href="${basePath}program/diabetes-care" class="block px-4 py-2.5 text-[13px] font-medium text-slate-600 hover:bg-[#f2f8f3] hover:text-primary rounded-lg transition-colors flex items-center"><i class="fa-solid fa-droplet w-5 text-center mr-2 opacity-60"></i> Diabetes Reversal</a>
                                <a href="${basePath}program/weight-management" class="block px-4 py-2.5 text-[13px] font-medium text-slate-600 hover:bg-[#f2f8f3] hover:text-primary rounded-lg transition-colors flex items-center"><i class="fa-solid fa-weight-scale w-5 text-center mr-2 opacity-60"></i> Weight Management</a>
                                <a href="${basePath}program/pcos-care" class="block px-4 py-2.5 text-[13px] font-medium text-slate-600 hover:bg-[#f2f8f3] hover:text-primary rounded-lg transition-colors flex items-center"><i class="fa-solid fa-venus w-5 text-center mr-2 opacity-60"></i> PCOS Care</a>
                                <a href="${basePath}program/heart-health" class="block px-4 py-2.5 text-[13px] font-medium text-slate-600 hover:bg-[#f2f8f3] hover:text-primary rounded-lg transition-colors flex items-center"><i class="fa-solid fa-heart w-5 text-center mr-2 opacity-60"></i> Heart Health</a>
                                <a href="${basePath}program/liver-detox" class="block px-4 py-2.5 text-[13px] font-medium text-slate-600 hover:bg-[#f2f8f3] hover:text-primary rounded-lg transition-colors flex items-center"><i class="fa-solid fa-leaf w-5 text-center mr-2 opacity-60"></i> Liver Detox</a>
                                <a href="${basePath}program/senior-wellness" class="block px-4 py-2.5 text-[13px] font-medium text-slate-600 hover:bg-[#f2f8f3] hover:text-primary rounded-lg transition-colors flex items-center"><i class="fa-solid fa-users w-5 text-center mr-2 opacity-60"></i> Senior Wellness</a>
                                <div class="h-px bg-gray-100 my-1 mx-2"></div>
                                <a href="${basePath}program" class="block px-4 py-2.5 text-[13px] font-bold text-primary hover:bg-[#f2f8f3] rounded-lg transition-colors text-center">View All Programs</a>
                            </div>
                        </div>
                    </div>
                    <a href="${basePath}health-condition" class="nav-link hover:text-primary transition-colors whitespace-nowrap">Health Conditions</a>
                    <a href="${basePath}healthlibrary" class="nav-link hover:text-primary transition-colors whitespace-nowrap">Health Library</a>
                    <a href="${basePath}store" class="nav-link hover:text-primary transition-colors whitespace-nowrap">Store</a>
                    <a href="${basePath}successtories" class="nav-link hover:text-primary transition-colors whitespace-nowrap">Success Stories</a>
                    <a href="${basePath}contact" class="nav-link hover:text-primary transition-colors whitespace-nowrap">Contact</a>
                </div>

                <!-- CTA Button -->
                <div class="hidden md:block">
                    <a href="javascript:void(0)" onclick="openContactModal()"
                        class="bg-primary hover:bg-primary-light text-white px-4 xl:px-6 py-2 xl:py-2.5 rounded font-medium transition-colors shadow-sm text-sm whitespace-nowrap">
                        Book Consultation
                    </a>
                </div>

                <!-- Mobile Menu Toggle -->
                <div id="open-mobile-menu" class="lg:hidden text-2xl text-primary mt-2 cursor-pointer p-2 -mr-2">
                    <i class="fa-solid fa-bars"></i>
                </div>
            </div>
        </div>
        </header>`;

        // Append mobile menu directly to body to avoid display: contents hit testing bugs
        if (!document.getElementById('hbm-mobile-menu')) {
            document.body.insertAdjacentHTML('beforeend', `
            <div id="hbm-mobile-menu" class="fixed inset-0 bg-white z-[100] transition-transform duration-300 lg:hidden flex flex-col overflow-hidden" style="height: 100vh; height: 100dvh; transform: translateX(100%);">
                <div class="p-4 px-6 flex justify-between items-center border-b border-gray-100 shadow-sm flex-shrink-0">
                    <img src="${imgPath}assets/images/logo.png" alt="Logo" class="h-12 w-auto">
                    <button id="close-mobile-menu" onclick="if(window.closeMobileMenu) window.closeMobileMenu();" class="text-3xl text-gray-400 hover:text-primary w-12 h-12 flex items-center justify-center rounded-full bg-gray-50 active:bg-gray-100 cursor-pointer" style="pointer-events: auto;">
                        <i class="fa-solid fa-xmark pointer-events-none"></i>
                    </button>
                </div>
                <div class="p-6 px-8 flex flex-col space-y-6 text-[17px] font-semibold text-slate-800 flex-1 overflow-y-auto" style="overflow-y: auto; min-height: 0; overscroll-behavior: contain;">
                    <a href="${basePath}index" class="hover:text-primary block">Home</a>
                    <a href="${basePath}mission" class="hover:text-primary block">Our Mission</a>
                    <div class="flex flex-col space-y-4">
                        <div class="flex justify-between items-center text-primary font-bold">
                            <span>Programs</span>
                        </div>
                        <div class="pl-5 flex flex-col space-y-4 text-[15px] font-medium text-slate-600 border-l-2 border-primary/20">
                            <a href="${basePath}program/diabetes-care" class="hover:text-primary block">Diabetes Reversal</a>
                            <a href="${basePath}program/weight-management" class="hover:text-primary block">Weight Management</a>
                            <a href="${basePath}program/pcos-care" class="hover:text-primary block">PCOS Care</a>
                            <a href="${basePath}program/heart-health" class="hover:text-primary block">Heart Health</a>
                            <a href="${basePath}program/liver-detox" class="hover:text-primary block">Liver Detox</a>
                            <a href="${basePath}program/senior-wellness" class="hover:text-primary block">Senior Wellness</a>
                            <a href="${basePath}program" class="text-primary font-bold mt-2 block">View All Programs <i class="fa-solid fa-arrow-right ml-1 text-xs"></i></a>
                        </div>
                    </div>
                    <a href="${basePath}health-condition" class="hover:text-primary block">Health Conditions</a>
                    <a href="${basePath}healthlibrary" class="hover:text-primary block">Health Library</a>
                    <a href="${basePath}store" class="hover:text-primary block">Store</a>
                    <a href="${basePath}successtories" class="hover:text-primary block">Success Stories</a>
                    <a href="${basePath}contact" class="hover:text-primary block">Contact</a>
                </div>
                <div class="p-6 border-t border-gray-100 bg-gray-50 pb-8 flex-shrink-0">
                    <a href="javascript:void(0)" onclick="openContactModal(); document.getElementById('close-mobile-menu').click();" class="block w-full text-center bg-primary hover:bg-primary-light text-white py-4 rounded-xl font-bold shadow-md text-lg">
                        Book Consultation
                    </a>
                </div>
            </div>`);
        }

        // Render auth state dynamically since scripts inside innerHTML do not execute
        const authContainer = this.querySelector('#hbm-auth-container');
        if (authContainer) {
            const token = localStorage.getItem('hbm_token');
            if (token) {
                authContainer.innerHTML = `
                    <div class="relative group cursor-pointer flex items-center space-x-2 hover:text-gray-200 transition-colors">
                        <i class="fa-solid fa-circle-user text-[17px]"></i>
                        <span>My Account</span>
                        <div class="absolute top-full right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 text-gray-700 overflow-hidden">
                            <a href="${basePath}dashboard/index" class="block px-4 py-2 hover:bg-gray-50 text-[13px]">Dashboard</a>
                            <a href="#" onclick="localStorage.removeItem('hbm_token'); window.location.href='${basePath}auth/login'; return false;" class="block px-4 py-2 hover:bg-gray-50 text-[13px] text-red-600 border-t border-gray-100">Logout</a>
                        </div>
                    </div>
                    <div class="w-px h-4 bg-white/30"></div>
                    <a href="${basePath}store/cart" class="relative inline-block hover:text-gray-200 transition-colors group mr-2 mt-1">
                        <i class="fa-solid fa-cart-shopping text-[18px] group-hover:scale-110 transition-transform"></i>
                        <span class="absolute bg-white text-primary text-[10px] font-extrabold w-[16px] h-[16px] rounded-full flex items-center justify-center shadow-sm" style="top: -8px; right: -10px;">0</span>
                    </a>
                `;
            } else {
                authContainer.innerHTML = `
                    <a href="${basePath}auth/login" class="flex items-center space-x-2 hover:text-gray-200 transition-colors">
                        <i class="fa-solid fa-circle-user text-[17px]"></i>
                        <span>Login / Register</span>
                    </a>
                    <div class="w-px h-4 bg-white/30"></div>
                    <a href="${basePath}store/cart" class="relative inline-block hover:text-gray-200 transition-colors group mr-2 mt-1">
                        <i class="fa-solid fa-cart-shopping text-[18px] group-hover:scale-110 transition-transform"></i>
                        <span class="absolute bg-white text-primary text-[10px] font-extrabold w-[16px] h-[16px] rounded-full flex items-center justify-center shadow-sm" style="top: -8px; right: -10px;">0</span>
                    </a>
                `;
            }
        }

        // Auto-set active link based on current URL
        setTimeout(() => {
            const currentPath = window.location.pathname;
            const navLinks = this.querySelectorAll('.nav-link');

            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href && href !== '#') {
                    // Check if current path ends with href, or if it's the root/index and href is index.php
                    const isActive = currentPath.endsWith(href) ||
                        (href === 'index' && (currentPath.endsWith('/') || currentPath === ''));

                    if (isActive) {
                        link.classList.remove('hover:text-primary', 'transition-colors');
                        link.classList.add('text-primary', 'border-b-[3px]', 'border-primary', 'pb-1', 'font-semibold');
                    }
                }
            });

            // Mobile Menu Logic
            const openBtn = this.querySelector('#open-mobile-menu');

            window.closeMobileMenu = () => {
                const menu = document.getElementById('hbm-mobile-menu');
                if (menu) {
                    menu.style.transform = 'translateX(100%)';
                }
            };

            if (openBtn) {
                openBtn.addEventListener('click', () => {
                    const mobileMenu = document.getElementById('hbm-mobile-menu');
                    if (mobileMenu) {
                        mobileMenu.style.transform = 'translateX(0%)';

                        // Prevent background scrolling via JS
                        if (!mobileMenu.dataset.touchListenerAdded) {
                            mobileMenu.addEventListener('touchmove', (e) => {
                                // If the touch is not inside the scrollable area, prevent default
                                if (!e.target.closest('.overflow-y-auto')) {
                                    e.preventDefault();
                                }
                            }, { passive: false });
                            mobileMenu.dataset.touchListenerAdded = 'true';
                        }
                    }
                });
            }

            // Close mobile menu when any link inside it is clicked
            const mobileLinks = document.querySelectorAll('#hbm-mobile-menu a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.closeMobileMenu) window.closeMobileMenu();
                });
            });
        }, 0);
    }
}
customElements.define('hbm-header', HbmHeader);

class HbmFooter extends HTMLElement {
    connectedCallback() {
        const basePath = this.getAttribute('base-path') || '';
        const imgPath = this.getAttribute('base-path') || './';

        // Prevents empty inline gaps before the footer wrapper
        this.style.display = 'contents';

        this.innerHTML = `<footer>
        <!-- Top Footer (Community & Newsletter) -->
        <div class="bg-[#14532d] border-b border-[#1b6b3b] py-8 xl:py-10">
            <div class="container mx-auto max-w-[1500px] px-4 lg:px-6">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-8 lg:gap-4">

                    <!-- Left: Community Text -->
                    <div
                        class="w-full lg:w-1/3 border-b lg:border-b-0 lg:border-r border-[#267a48] pb-6 lg:pb-0 pr-0 lg:pr-8 text-center lg:text-left">
                        <h4 class="text-white font-bold text-lg xl:text-xl mb-2">Join Our Healthy Bharat<br>Community
                        </h4>
                        <p class="text-white/80 text-xs xl:text-sm leading-relaxed">Be a part of our mission and get
                            daily health tips, updates and inspiration.</p>
                    </div>

                    <!-- Middle: Social Channels -->
                    <div
                        class="w-full lg:w-1/3 flex justify-center gap-6 xl:gap-10 border-b lg:border-b-0 lg:border-r border-[#267a48] pb-6 lg:pb-0">
                        <a href="#" class="flex flex-col items-center group">
                            <i
                                class="fa-brands fa-whatsapp text-2xl xl:text-3xl text-[#25D366] mb-2 group-hover:scale-110 transition-transform"></i>
                            <span
                                class="text-white text-[10px] xl:text-xs font-medium text-center">WhatsApp<br>Community</span>
                        </a>
                        <a href="#" class="flex flex-col items-center group">
                            <i
                                class="fa-brands fa-telegram text-2xl xl:text-3xl text-[#0088cc] mb-2 group-hover:scale-110 transition-transform"></i>
                            <span
                                class="text-white text-[10px] xl:text-xs font-medium text-center">Telegram<br>Channel</span>
                        </a>
                        <a href="#" class="flex flex-col items-center group">
                            <i
                                class="fa-brands fa-youtube text-2xl xl:text-3xl text-[#FF0000] mb-2 group-hover:scale-110 transition-transform"></i>
                            <span
                                class="text-white text-[10px] xl:text-xs font-medium text-center">YouTube<br>Channel</span>
                        </a>
                        <a href="#" class="flex flex-col items-center group">
                            <i
                                class="fa-brands fa-instagram text-2xl xl:text-3xl text-[#E1306C] mb-2 group-hover:scale-110 transition-transform"></i>
                            <span class="text-white text-[10px] xl:text-xs font-medium text-center">Instagram<br>Follow
                                Us</span>
                        </a>
                    </div>

                    <!-- Right: Newsletter -->
                    <div class="w-full lg:w-1/3 pl-0 lg:pl-8 text-center lg:text-left">
                        <h4 class="text-white font-bold text-base xl:text-lg mb-1">Newsletter</h4>
                        <p class="text-white/80 text-[11px] xl:text-xs mb-4">Get weekly health tips & updates</p>
                        <form id="global-newsletter-form" class="flex w-full max-w-sm mx-auto lg:mx-0 gap-2 xl:gap-3 relative">
                            <input id="global-newsletter-email" type="email" placeholder="Enter your email" required
                                class="flex-grow bg-white px-3 py-2 xl:py-2.5 rounded text-sm border-none focus:ring-2 focus:ring-accent outline-none text-slate-800">
                            <button id="global-newsletter-submit" type="submit"
                                class="bg-accent hover:bg-yellow-500 text-slate-900 font-bold px-4 xl:px-6 py-2 xl:py-2.5 rounded text-sm transition-colors shadow-sm shrink-0">
                                Subscribe
                            </button>
                        </form>
                        <div id="global-newsletter-message" class="w-full max-w-sm mx-auto lg:mx-0 mt-2 text-sm text-center lg:text-left hidden"></div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Main Footer -->
        <div class="bg-[#1e293b] pt-16 pb-10 relative overflow-hidden">
            <!-- Faint Map graphic in background right -->
            <div class="absolute right-0 bottom-10 opacity-[0.02] pointer-events-none pr-10">
                <i class="fa-solid fa-map-location-dot text-[300px] text-white"></i>
            </div>

            <div class="container mx-auto max-w-[1500px] px-4 lg:px-6 relative z-10">

                <div
                    class="flex flex-wrap lg:flex-nowrap justify-between gap-8 xl:gap-12 mb-12 border-b border-slate-700/50 pb-12">

                    <!-- Col 1: Logo & Mission -->
                    <div class="w-full lg:w-3/12 pr-0 xl:pr-4">
                        <a href="${basePath}index" class="flex items-center mb-4 group">
                            <img src="${imgPath}assets/images/logo.png" alt="Logo" class="mr-3 transition-transform group-hover:scale-105" style="height: 50px; width: auto;"
                                onerror="this.src='https://via.placeholder.com/40x40/10b981/ffffff?text=HBM'">
                            <div>
                                <h4 class="text-white font-bold text-base xl:text-lg leading-tight group-hover:text-accent transition-colors">Healthy Bharat
                                    Mission</h4>
                                <span
                                    class="text-accent text-[9px] xl:text-[10px] uppercase tracking-wider block mt-0.5">Towards
                                    a Diabetes-Free India</span>
                            </div>
                        </a>
                        <p class="text-slate-400 text-xs xl:text-sm leading-relaxed mb-6">
                            Our Mission is to build a healthier India by helping people prevent and reverse lifestyle
                            diseases through education, nutrition and lifestyle transformation.
                        </p>
                        <div class="flex space-x-3">
                            <a href="#"
                                class="w-12 h-12 rounded-full bg-slate-800 hover:bg-slate-700 flex items-center justify-center text-white transition-colors">
                                <i class="fa-brands fa-facebook-f text-lg"></i>
                            </a>
                            <a href="#"
                                class="w-12 h-12 rounded-full bg-slate-800 hover:bg-slate-700 flex items-center justify-center text-white transition-colors">
                                <i class="fa-brands fa-instagram text-lg"></i>
                            </a>
                            <a href="#"
                                class="w-12 h-12 rounded-full bg-slate-800 hover:bg-slate-700 flex items-center justify-center text-white transition-colors">
                                <i class="fa-brands fa-youtube text-lg"></i>
                            </a>
                            <a href="#"
                                class="w-12 h-12 rounded-full bg-slate-800 hover:bg-slate-700 flex items-center justify-center text-white transition-colors">
                                <i class="fa-brands fa-linkedin-in text-lg"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Col 2: Quick Links -->
                    <div class="w-[45%] sm:w-1/3 md:w-1/4 lg:w-auto">
                        <h4 class="text-white font-semibold text-sm xl:text-base mb-5">Quick Links</h4>
                        <ul class="space-y-3">
                            <li><a href="${basePath}index"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Home</a>
                            </li>
                            <li><a href="${basePath}mission"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Our
                                    Mission</a></li>
                            <li><a href="${basePath}program"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Programs</a>
                            </li>
                            <li><a href="#"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Health
                                    Conditions</a></li>
                            <li><a href="${basePath}healthlibrary"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Health
                                    Library</a></li>
                        </ul>
                    </div>

                    <!-- Col 3: Resources -->
                    <div class="w-[45%] sm:w-1/3 md:w-1/4 lg:w-auto">
                        <h4 class="text-white font-semibold text-sm xl:text-base mb-5">Resources</h4>
                        <ul class="space-y-3">
                            <li><a href="#"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Diabetes
                                    Calculator</a></li>
                            <li><a href="#"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">BMI
                                    Calculator</a></li>
                            <li><a href="#"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Health
                                    Assessment</a></li>
                            <li><a href="#"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">FAQs</a>
                            </li>
                            <li><a href="#"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Blog</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Col 4: Store -->
                    <div class="w-[45%] sm:w-1/3 md:w-1/4 lg:w-auto">
                        <h4 class="text-white font-semibold text-sm xl:text-base mb-5">Store</h4>
                        <ul class="space-y-3">
                            <li><a href="${basePath}store"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">All
                                    Products</a></li>
                            <li><a href="#"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Super
                                    Foods</a></li>
                            <li><a href="#"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Supplements</a>
                            </li>
                            <li><a href="#"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Herbal
                                    Products</a></li>
                            <li><a href="#"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Combo
                                    Packs</a></li>
                        </ul>
                    </div>

                    <!-- Col 5: Support -->
                    <div class="w-[45%] sm:w-1/3 md:w-1/4 lg:w-auto">
                        <h4 class="text-white font-semibold text-sm xl:text-base mb-5">Support</h4>
                        <ul class="space-y-3">
                            <li><a href="javascript:void(0)" onclick="openContactModal()"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Book
                                    Consultation</a></li>
                            <li><a href="${basePath}contact"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Contact
                                    Us</a></li>
                            <li><a href="${basePath}legal/privacy-policy"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Privacy
                                    Policy</a></li>
                            <li><a href="${basePath}legal/terms-conditions"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Terms
                                    & Conditions</a></li>
                            <li><a href="${basePath}legal/refund-policy"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Refund
                                    Policy</a></li>
                            <li><a href="${basePath}legal/shipping-policy"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Shipping
                                    Policy</a></li>
                        </ul>
                    </div>

                    </div>

                </div>

                <!-- Copyright Bar -->
                <div class="text-center">
                    <p class="text-slate-500 text-[10px] xl:text-[11px] font-medium">
                        &copy; ` + new Date().getFullYear() + ` Healthy Bharat Mission. All Rights Reserved.
                    </p>
                </div>

            </div>
        </div>
    </footer>`;

        // Newsletter Form Logic
        const form = this.querySelector('#global-newsletter-form');
        const emailInput = this.querySelector('#global-newsletter-email');
        const submitBtn = this.querySelector('#global-newsletter-submit');
        const messageDiv = this.querySelector('#global-newsletter-message');

        if (form) {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                const email = emailInput.value.trim();
                if (!email) return;

                // Set loading state
                submitBtn.disabled = true;
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';

                messageDiv.classList.add('hidden');
                messageDiv.className = 'w-full max-w-sm mx-auto lg:mx-0 mt-2 text-sm text-center lg:text-left hidden';

                try {
                    const res = await window.HBM_API.request('/newsletter/subscribe', 'POST', { email });

                    // Success
                    messageDiv.textContent = res.message || 'Thank you for subscribing!';
                    messageDiv.classList.remove('hidden');
                    messageDiv.classList.add('text-green-300', 'font-medium');
                    emailInput.value = '';
                } catch (err) {
                    // Error
                    messageDiv.textContent = err.message || 'Subscription failed. Please try again.';
                    messageDiv.classList.remove('hidden');
                    messageDiv.classList.add('text-red-400', 'font-medium');
                } finally {
                    // Restore button state
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            });
        }
    }
}
customElements.define('hbm-footer', HbmFooter);

// Contact Form Web Component
class HbmContactForm extends HTMLElement {
    connectedCallback() {
        this.innerHTML = `
        <div class="bg-[#f0f9f4] rounded-3xl p-6 md:p-8 shadow-sm border border-[#e2e8f0]">
            <h3 class="font-heading font-extrabold text-2xl lg:text-3xl text-[#1e293b] mb-2 tracking-tight">
                Send Us a <span class="text-primary">Message</span>
            </h3>
            <p class="text-gray-600 text-sm mb-6">
                Fill out the form below and our team will get back to you soon.
            </p>
            <form id="contact-form" class="space-y-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-regular fa-user text-gray-400"></i>
                    </div>
                    <input type="text" id="contact-name" placeholder="Your Name *" required
                        class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-regular fa-envelope text-gray-400"></i>
                    </div>
                    <input type="email" id="contact-email" placeholder="Your Email *" required
                        class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-phone text-gray-400 text-sm"></i>
                    </div>
                    <input type="tel" id="contact-phone" placeholder="Phone Number *" required pattern="[6-9][0-9]{9}" maxlength="10" title="Please enter a valid 10-digit Indian mobile number starting with 6, 7, 8, or 9."
                        class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-list-ul text-gray-400 text-sm"></i>
                    </div>
                    <select id="contact-subject" required class="w-full pl-10 pr-10 py-3 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none text-gray-500">
                        <option value="" disabled selected>Select a Subject *</option>
                        <option value="programs">Programs & Courses</option>
                        <option value="consultation">Book Consultation</option>
                        <option value="partnership">Partnership Inquiry</option>
                        <option value="other">Other</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-chevron-down text-gray-400 text-xs"></i>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute top-4 left-0 pl-4 flex items-start pointer-events-none">
                        <i class="fa-regular fa-comment text-gray-400"></i>
                    </div>
                    <textarea id="contact-message" placeholder="Your Message *" required rows="4"
                        class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all resize-none"></textarea>
                </div>
                <div id="contact-alert" class="hidden text-sm font-semibold rounded-lg px-4 py-3 mb-4"></div>
                <button type="submit" id="contact-submit"
                    class="w-full bg-primary hover:bg-primary-light text-white font-bold py-3.5 rounded-lg text-sm transition-colors shadow-md flex justify-center items-center group disabled:opacity-50">
                    Send Message 
                    <i class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>
        </div>`;

        const form = this.querySelector('#contact-form');
        const alert = this.querySelector('#contact-alert');
        const btn = this.querySelector('#contact-submit');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const data = {
                name: document.getElementById('contact-name').value,
                email: document.getElementById('contact-email').value,
                phone: document.getElementById('contact-phone').value,
                subject: document.getElementById('contact-subject').value,
                message: document.getElementById('contact-message').value
            };

            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sending...';
            alert.classList.add('hidden');

            try {
                let res = null;
                if (window.HBM_API) {
                    res = await window.HBM_API.request('/contact', 'POST', data);
                } else {
                    // Fallback if component is used without api.js
                    console.warn("HBM_API not available. Form simulation.");
                }
                alert.classList.remove('hidden', 'bg-red-50', 'text-red-700', 'border-red-100');
                alert.classList.add('bg-green-50', 'text-green-700', 'border', 'border-green-100');
                alert.innerText = (res && res.message) ? res.message : "Message sent successfully! We will get back to you soon.";
                form.reset();
            } catch (err) {
                alert.classList.remove('hidden', 'bg-green-50', 'text-green-700', 'border-green-100');
                alert.classList.add('bg-red-50', 'text-red-700', 'border', 'border-red-100');
                alert.innerText = err.message || "Failed to send message.";
            } finally {
                btn.disabled = false;
                btn.innerHTML = 'Send Message <i class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>';
            }
        });
    }
}
customElements.define('hbm-contact-form', HbmContactForm);

// Counter Animation (Migrated to individual pages where needed to prevent duplication)

// --- Cart & Wishlist Logic ---
window.cartState = {
    count: 0,
    items: {} // Map of product_id -> { cart_item_id, quantity }
};

window.fetchCartCount = async function () {
    if (localStorage.getItem('hbm_token')) {
        try {
            const res = await HBM_API.request('/cart/count');
            window.cartState.count = res.data.count || 0;
            window.updateCartBadge();
        } catch (e) {
            console.error("Failed to fetch cart count", e);
        }
    }
};

window.fetchCartData = async function () {
    if (localStorage.getItem('hbm_token')) {
        try {
            const res = await HBM_API.request('/cart');
            const cart = res.data;
            window.cartState.count = cart.total_items || 0;

            // Build the map
            window.cartState.items = {};
            if (cart.items) {
                cart.items.forEach(item => {
                    const prodId = item.product_id || item.id;
                    window.cartState.items[prodId] = {
                        cart_item_id: item.cart_item_id,
                        quantity: item.quantity
                    };
                });
            }

            window.updateCartBadge();

            // Re-render UI if functions exist so the initial load syncs correctly
            if (typeof window.renderStoreGrids === 'function') {
                window.renderStoreGrids();
            }
            if (typeof window.renderProductDetailCartUI === 'function') {
                window.renderProductDetailCartUI();
            }
        } catch (e) {
            console.error("Failed to fetch full cart", e);
        }
    }
};

window.updateCartBadge = function () {
    // Support multiple headers if any
    const headers = document.querySelectorAll('hbm-header');
    headers.forEach(header => {
        const badge = header.querySelector('#header-cart-badge') || header.querySelector('span.bg-white.text-primary.rounded-full');
        if (badge) {
            badge.innerText = window.cartState.count;
            if (window.cartState.count > 0) {
                badge.classList.add('scale-125');
                setTimeout(() => badge.classList.remove('scale-125'), 200);
            }
        }
    });
};

window.logout = function () {
    localStorage.removeItem('hbm_token');
    localStorage.removeItem('hbm_user');
    window.location.href = document.querySelector('hbm-header')?.getAttribute('base-path') + 'index' || '/';
};

window.showNotification = function (message, type = 'success') {
    let container = document.getElementById('hbm-notification-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'hbm-notification-container';
        container.style.position = 'fixed';
        container.style.top = '20px';
        container.style.left = '50%';
        container.style.transform = 'translateX(-50%)';
        container.style.zIndex = '99999';
        container.style.display = 'flex';
        container.style.flexDirection = 'column';
        container.style.gap = '12px';
        container.style.width = '100%';
        container.style.maxWidth = '400px';
        container.style.padding = '0 16px';
        container.style.pointerEvents = 'none';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    const bgColor = type === 'success' ? '#ebf8f0' : (type === 'error' ? '#fdf2f2' : '#ffffff');
    const borderColor = type === 'success' ? '#a3e4be' : (type === 'error' ? '#f8b4b4' : '#e5e7eb');
    const textColor = type === 'success' ? '#064e3b' : (type === 'error' ? '#991b1b' : '#1f2937');
    const icon = type === 'success' ? '<i class="fa-regular fa-circle-check" style="font-size:20px;"></i>' : '<i class="fa-solid fa-circle-exclamation" style="font-size:20px;"></i>';

    toast.style.backgroundColor = bgColor;
    toast.style.borderColor = borderColor;
    toast.style.color = textColor;
    toast.style.borderWidth = '1px';
    toast.style.borderStyle = 'solid';
    toast.style.padding = '16px 20px';
    toast.style.borderRadius = '12px';
    toast.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)';
    toast.style.display = 'flex';
    toast.style.alignItems = 'center';
    toast.style.justifyContent = 'space-between';
    toast.style.gap = '12px';
    toast.style.transform = 'translateY(-40px)';
    toast.style.opacity = '0';
    toast.style.transition = 'all 0.4s cubic-bezier(0.16, 1, 0.3, 1)';
    toast.style.pointerEvents = 'auto';

    toast.innerHTML = `
        <div style="display:flex; align-items:center; gap:12px;">
            ${icon}
            <span style="font-weight:700; font-size:15px;">${message}</span>
        </div>
        <button class="close-toast" style="color:#9ca3af; background:none; border:none; cursor:pointer; padding:4px; margin-left:16px;">
            <i class="fa-solid fa-xmark" style="font-size:18px;"></i>
        </button>
    `;

    container.appendChild(toast);
    const closeBtn = toast.querySelector('.close-toast');

    // Force reflow
    void toast.offsetWidth;

    // Animate in
    toast.style.transform = 'translateY(0)';
    toast.style.opacity = '1';

    const removeToast = () => {
        toast.style.transform = 'translateY(-40px)';
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 400);
    };

    closeBtn.onclick = removeToast;
    setTimeout(removeToast, 3000);
};

window.addToCart = async function (productId, qty = 1) {
    if (!localStorage.getItem('hbm_token')) {
        const basePath = document.querySelector('hbm-header')?.getAttribute('base-path') || '';
        window.location.href = basePath + 'auth/login?redirect=' + encodeURIComponent(window.location.pathname);
        return;
    }

    try {
        const res = await HBM_API.request('/cart', 'POST', { product_id: productId, quantity: qty });
        window.cartState.count = res.data.total_items;
        window.updateCartBadge();

        // Also refresh full cart data so state is synced immediately
        await window.fetchCartData();

        // Show global notification
        if (typeof window.showNotification === 'function') {
            window.showNotification('Item added to cart successfully!', 'success');
        }

        // Re-render UI if on store page
        if (typeof window.renderStoreGrids === 'function') {
            window.renderStoreGrids();
        }

        // Re-render Product Details UI if on product page
        if (typeof window.renderProductDetailCartUI === 'function') {
            window.renderProductDetailCartUI();
        }

        // Re-render Cart page if on cart page
        if (window.location.pathname.includes('cart') && typeof window.initCart === 'function') {
            window.initCart();
        }
    } catch (e) {
        alert(e.message || "Failed to add to cart");
    }
};

window.updateStoreCart = async function (productId, newQty) {
    if (!localStorage.getItem('hbm_token')) {
        const basePath = document.querySelector('hbm-header')?.getAttribute('base-path') || '';
        window.location.href = basePath + 'auth/login?redirect=' + encodeURIComponent(window.location.pathname);
        return;
    }

    try {
        const item = window.cartState.items[productId];
        if (item && item.cart_item_id) {
            if (newQty <= 0) {
                await HBM_API.request(`/cart/${item.cart_item_id}`, 'DELETE');
            } else {
                await HBM_API.request(`/cart/${item.cart_item_id}`, 'PUT', { quantity: newQty });
            }
        } else if (newQty > 0) {
            // If it wasn't in the cart, but we somehow hit +, we just add it (this is a fallback, usually addToCart is used for the first add)
            await HBM_API.request('/cart', 'POST', { product_id: productId, quantity: newQty });
        }

        await window.fetchCartData();

        if (typeof window.renderStoreGrids === 'function') {
            window.renderStoreGrids();
        }

        // Re-render Product Details UI if on product page
        if (typeof window.renderProductDetailCartUI === 'function') {
            window.renderProductDetailCartUI();
        }

        // Re-render Cart page if on cart page
        if (window.location.pathname.includes('cart') && typeof window.initCart === 'function') {
            window.initCart();
        }
    } catch (e) {
        alert(e.message || "Failed to update cart");
    }
};

window.addToWishlist = async function (productId, btnElement) {
    if (!localStorage.getItem('hbm_token')) {
        const basePath = document.querySelector('hbm-header')?.getAttribute('base-path') || '';
        window.location.href = basePath + 'auth/login?redirect=' + encodeURIComponent(window.location.pathname);
        return;
    }

    try {
        const res = await HBM_API.request('/wishlist', 'POST', { product_id: productId });
        const icon = btnElement ? btnElement.querySelector('i') : null;

        if (res.data.action === 'added') {
            if (icon) {
                icon.classList.remove('fa-regular');
                icon.classList.add('fa-solid', 'text-red-500');
            }
            window.showNotification("Added to wishlist");
        } else {
            if (icon) {
                icon.classList.remove('fa-solid', 'text-red-500');
                icon.classList.add('fa-regular');
            }
            window.showNotification("Removed from wishlist");
        }
    } catch (e) {
        window.showNotification(e.message || "Failed to update wishlist", 'error');
    }
};

// Initialize cart on page load
document.addEventListener('DOMContentLoaded', () => {
    // Delay slightly to let Web Components render
    setTimeout(() => {
        window.fetchCartCount();
    }, 150);
});


class HbmDashboardSidebar extends HTMLElement {
    connectedCallback() {
        this.style.display = 'contents';
        const active = this.getAttribute('active-page') || 'overview';

        const links = [
            { id: 'overview', name: 'Overview', icon: 'fa-chart-pie', url: 'index' },
            { id: 'profile', name: 'My Profile', icon: 'fa-user', url: 'profile' },
            { id: 'health-profile', name: 'Health Profile', icon: 'fa-notes-medical', url: 'health-profile' },
            { id: 'programs', name: 'My Programs', icon: 'fa-dumbbell', url: 'programs' },
            { id: 'documents', name: 'Documents', icon: 'fa-file-medical', url: 'documents' },
            { id: 'food-charts', name: 'Food Charts', icon: 'fa-apple-whole', url: 'food-charts' },
            { id: 'orders', name: 'My Orders', icon: 'fa-box', url: 'orders' },
            { id: 'downloads', name: 'Downloads', icon: 'fa-download', url: 'downloads' },
            { id: 'wishlist', name: 'Wishlist', icon: 'fa-heart', url: 'wishlist' },
            { id: 'appointments', name: 'Appointments', icon: 'fa-calendar-check', url: 'appointments' },
            { id: 'settings', name: 'Settings', icon: 'fa-gear', url: 'settings' },
        ];

        let linksHtml = '';
        links.forEach(l => {
            const isActive = l.id === active;
            const classes = isActive
                ? 'bg-primary/10 text-primary font-bold border-r-4 border-primary'
                : 'text-gray-600 hover:bg-gray-50 hover:text-primary font-medium';

            linksHtml += `
                <a href="${l.url}" class="flex items-center space-x-3 px-5 py-3.5 transition-colors ${classes}">
                    <i class="fa-solid ${l.icon} w-5 text-center ${isActive ? 'text-primary' : 'text-gray-400'}"></i>
                    <span class="text-[13.5px]">${l.name}</span>
                </a>
            `;
        });

        this.innerHTML = `
            <style>
                .hbm-sidebar-scroll::-webkit-scrollbar { display: none; }
                .hbm-sidebar-scroll { -ms-overflow-style: none; scrollbar-width: none; }
            </style>
            <div class="w-full lg:w-[260px] bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-gray-100 flex-shrink-0 hbm-sidebar-scroll" style="position: sticky; top: 120px; align-self: flex-start; max-height: calc(100vh - 140px); overflow-y: auto; overflow-x: hidden;">
                <div class="p-5 border-b border-gray-100 flex items-center space-x-3 bg-gray-50/50">
                    <div>
                        <div class="text-[14px] font-bold text-gray-800" id="sidebar-user-name">Loading...</div>
                        <div class="text-[11px] text-gray-500 font-medium">Patient Member</div>
                    </div>
                </div>
                <div class="py-2">
                    ${linksHtml}
                    <div class="h-px bg-gray-100 my-2 mx-5"></div>
                    <a href="#" onclick="HBM_API.setToken(null); window.location.href='../auth/login'; return false;" class="flex items-center space-x-3 px-5 py-3.5 text-red-600 hover:bg-red-50 font-medium transition-colors">
                        <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center opacity-70"></i>
                        <span class="text-[13.5px]">Logout</span>
                    </a>
                </div>
            </div>
        `;

        document.addEventListener('hbm:auth-ready', () => {
            if (window.HBM_USER) {
                const nameEl = this.querySelector('#sidebar-user-name');
                if (nameEl) nameEl.textContent = `${window.HBM_USER.first_name} ${window.HBM_USER.last_name}`;
            }
        });
    }
}
customElements.define('hbm-dashboard-sidebar', HbmDashboardSidebar);

class HbmContactModal extends HTMLElement {
    connectedCallback() {
        this.innerHTML = `
        <div id="hbm-contact-modal-overlay" class="fixed inset-0 bg-black/60 z-50 hidden opacity-0 transition-opacity duration-300 backdrop-blur-sm flex justify-center items-center p-4" style="z-index: 9999;">
            <div id="hbm-contact-modal-content" class="bg-white rounded-3xl w-full max-w-lg shadow-2xl transform scale-95 transition-transform duration-300 relative overflow-hidden flex flex-col" style="max-height: 90vh;">
                <!-- Header -->
                <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-[#f0f9f4]">
                    <div>
                        <h3 class="font-heading font-extrabold text-2xl text-[#1e293b] tracking-tight">
                            Book <span class="text-primary">Consultation</span>
                        </h3>
                        <p class="text-gray-500 text-xs mt-1">Take the first step towards a healthier you.</p>
                    </div>
                    <button id="close-modal-btn" class="text-gray-400 hover:text-red-500 transition-colors w-8 h-8 rounded-full flex items-center justify-center bg-white shadow-sm border border-gray-100 hover:rotate-90 duration-300">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
                <!-- Body -->
                <div class="p-6 overflow-y-auto custom-scrollbar">
                    <form id="modal-contact-form" class="space-y-4">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-regular fa-user text-gray-400"></i>
                            </div>
                            <input type="text" id="modal-contact-name" placeholder="Your Full Name *" required
                                class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white outline-none transition-all">
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-regular fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" id="modal-contact-email" placeholder="Your Email Address *" required
                                class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white outline-none transition-all">
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-phone text-gray-400 text-sm"></i>
                            </div>
                            <input type="tel" id="modal-contact-phone" placeholder="Phone Number (10 Digits) *" required pattern="[6-9][0-9]{9}" maxlength="10" title="Please enter a valid 10-digit Indian mobile number starting with 6, 7, 8, or 9."
                                class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white outline-none transition-all"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                        </div>
                        <div class="relative" id="custom-subject-dropdown">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                                <i class="fa-solid fa-list-ul text-gray-400 text-sm"></i>
                            </div>
                            <input type="hidden" id="modal-contact-subject" value="consultation" required>
                            
                            <div id="custom-subject-trigger" class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white outline-none transition-all text-gray-600 cursor-pointer flex items-center justify-between select-none">
                                <span id="custom-subject-label">Book Consultation</span>
                                <i class="fa-solid fa-chevron-down text-gray-400 text-xs transition-transform duration-200" id="custom-subject-icon"></i>
                            </div>
                            
                            <div id="custom-subject-options" class="absolute z-[100] w-full mt-1 bg-white border border-gray-100 rounded-xl shadow-lg opacity-0 invisible transition-all duration-200 origin-top transform scale-95">
                                <div class="py-1">
                                    <div class="custom-option px-4 py-2.5 text-sm text-gray-600 hover:bg-[#f0f9f4] hover:text-primary cursor-pointer transition-colors" data-value="programs">Programs & Courses</div>
                                    <div class="custom-option px-4 py-2.5 text-sm text-primary bg-[#f0f9f4] font-medium cursor-pointer transition-colors" data-value="consultation">Book Consultation</div>
                                    <div class="custom-option px-4 py-2.5 text-sm text-gray-600 hover:bg-[#f0f9f4] hover:text-primary cursor-pointer transition-colors" data-value="partnership">Partnership Inquiry</div>
                                    <div class="custom-option px-4 py-2.5 text-sm text-gray-600 hover:bg-[#f0f9f4] hover:text-primary cursor-pointer transition-colors" data-value="other">Other</div>
                                </div>
                            </div>
                        </div>
                        <div class="relative">
                            <div class="absolute top-4 left-0 pl-4 flex items-start pointer-events-none">
                                <i class="fa-regular fa-comment text-gray-400"></i>
                            </div>
                            <textarea id="modal-contact-message" placeholder="How can we help you? *" required rows="3"
                                class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white outline-none transition-all resize-none"></textarea>
                        </div>
                        <div id="modal-contact-alert" class="hidden text-sm font-semibold rounded-lg px-4 py-3 mb-4"></div>
                        <button type="submit" id="modal-contact-submit"
                            class="w-full bg-primary hover:bg-primary-light text-white font-bold py-3.5 rounded-xl text-sm transition-all shadow-lg hover:shadow-xl flex justify-center items-center group disabled:opacity-50">
                            Submit Request
                            <i class="fa-solid fa-paper-plane ml-2 group-hover:-translate-y-1 group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        `;

        const overlay = this.querySelector('#hbm-contact-modal-overlay');
        const content = this.querySelector('#hbm-contact-modal-content');
        const closeBtn = this.querySelector('#close-modal-btn');
        const form = this.querySelector('#modal-contact-form');
        const alert = this.querySelector('#modal-contact-alert');
        const btn = this.querySelector('#modal-contact-submit');

        window.openContactModal = (subject = 'consultation') => {
            // Reset form and state completely
            if (form) form.reset();
            if (alert) {
                alert.classList.add('hidden');
                alert.innerText = '';
            }
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = 'Submit Request <i class="fa-solid fa-paper-plane ml-2 group-hover:-translate-y-1 group-hover:translate-x-1 transition-transform"></i>';
            }

            const hiddenSubjectInput = document.querySelector('#modal-contact-subject');
            const customSubjectLabel = document.querySelector('#custom-subject-label');
            const optionEls = document.querySelectorAll('.custom-option');

            if (hiddenSubjectInput && customSubjectLabel) {
                hiddenSubjectInput.value = subject;
                optionEls.forEach(opt => {
                    if (opt.dataset.value === subject) {
                        customSubjectLabel.innerText = opt.innerText;
                        opt.classList.remove('text-gray-600');
                        opt.classList.add('text-primary', 'bg-[#f0f9f4]', 'font-medium');
                    } else {
                        opt.classList.remove('text-primary', 'bg-[#f0f9f4]', 'font-medium');
                        opt.classList.add('text-gray-600');
                    }
                });
            }

            overlay.classList.remove('hidden');
            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                content.classList.remove('scale-95');
                content.classList.add('scale-100');
            }, 10);
            document.body.style.overflow = 'hidden';
        };

        // Custom Dropdown Initialization
        const dropdownTrigger = this.querySelector('#custom-subject-trigger');
        const dropdownOptions = this.querySelector('#custom-subject-options');
        const dropdownIcon = this.querySelector('#custom-subject-icon');
        const customSubjectInput = this.querySelector('#modal-contact-subject');
        const customSubjectLabel = this.querySelector('#custom-subject-label');

        (async () => {
            try {
                const res = await window.HBM_API.request('/contact-options');
                if (res && res.data && dropdownOptions) {
                    const optionsContainer = dropdownOptions.querySelector('div');
                    let html = '';
                    res.data.forEach((opt, idx) => {
                        const activeClass = idx === 0 ? 'text-primary bg-[#f0f9f4] font-medium' : 'text-gray-600 hover:bg-[#f0f9f4] hover:text-primary';
                        if (idx === 0) {
                            customSubjectInput.value = opt.value;
                            customSubjectLabel.innerText = opt.label;
                        }
                        html += `<div class="custom-option px-4 py-2.5 text-sm cursor-pointer transition-colors ${activeClass}" data-value="${opt.value}">${opt.label}</div>`;
                    });
                    optionsContainer.innerHTML = html;

                    // Re-bind option click events for dynamic options
                    const options = dropdownOptions.querySelectorAll('.custom-option');
                    options.forEach(opt => {
                        opt.addEventListener('click', (e) => {
                            e.stopPropagation();
                            options.forEach(o => {
                                o.classList.remove('text-primary', 'bg-[#f0f9f4]', 'font-medium');
                                o.classList.add('text-gray-600', 'hover:bg-[#f0f9f4]', 'hover:text-primary');
                            });
                            opt.classList.remove('text-gray-600', 'hover:bg-[#f0f9f4]', 'hover:text-primary');
                            opt.classList.add('text-primary', 'bg-[#f0f9f4]', 'font-medium');
                            customSubjectInput.value = opt.getAttribute('data-value');
                            customSubjectLabel.innerText = opt.innerText;
                            dropdownOptions.classList.add('opacity-0', 'invisible', 'scale-95');
                            dropdownOptions.classList.remove('opacity-100', 'visible', 'scale-100');
                            dropdownIcon.classList.remove('rotate-180');
                        });
                    });
                }
            } catch (e) {
                console.error("Failed to load modal contact options", e);
            }
        })();
        const hiddenSubjectInput = this.querySelector('#modal-contact-subject');
        const customSubjectLabel = this.querySelector('#custom-subject-label');
        const optionEls = this.querySelectorAll('.custom-option');

        if (dropdownTrigger && dropdownOptions) {
            const openDropdown = () => {
                dropdownOptions.classList.remove('opacity-0', 'invisible', 'scale-95');
                dropdownOptions.classList.add('opacity-100', 'visible', 'scale-100');
                dropdownIcon.classList.add('rotate-180');
            };
            const closeDropdown = () => {
                dropdownOptions.classList.add('opacity-0', 'invisible', 'scale-95');
                dropdownOptions.classList.remove('opacity-100', 'visible', 'scale-100');
                dropdownIcon.classList.remove('rotate-180');
            };

            dropdownTrigger.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdownOptions.classList.contains('opacity-100') ? closeDropdown() : openDropdown();
            });

            optionEls.forEach(opt => {
                opt.addEventListener('click', (e) => {
                    e.stopPropagation();
                    hiddenSubjectInput.value = opt.dataset.value;
                    customSubjectLabel.innerText = opt.innerText;

                    optionEls.forEach(o => {
                        o.classList.remove('text-primary', 'bg-[#f0f9f4]', 'font-medium');
                        o.classList.add('text-gray-600');
                    });
                    opt.classList.remove('text-gray-600');
//                     opt.classList.add('text-primary', 'bg-[#f0f9f4]', 'font-medium');
// 
//                     closeDropdown();
//                 });
//             });
// 
//             document.addEventListener('click', (e) => {
//                 if (!dropdownTrigger.contains(e.target) && !dropdownOptions.contains(e.target)) {
//                     closeDropdown();
//                 }
//             });
//         }
// 
//         const closeModal = () => {
//             overlay.classList.add('opacity-0');
//             content.classList.remove('scale-100');
//             content.classList.add('scale-95');
//             setTimeout(() => {
//                 overlay.classList.add('hidden');
//                 document.body.style.overflow = '';
//             }, 300);
//         };
// 
//         closeBtn.addEventListener('click', closeModal);
//         overlay.addEventListener('click', (e) => {
//             if (e.target === overlay) closeModal();
//         });
// 
//         form.addEventListener('submit', async (e) => {
//             e.preventDefault();
//             const phoneVal = document.getElementById('modal-contact-phone').value;
// 
//             // Strict Frontend Validation
//             if (phoneVal && !/^[6-9]\d{9}$/.test(phoneVal)) {
//                 alert.classList.remove('hidden', 'bg-green-50', 'text-green-700', 'border-green-100');
//                 alert.classList.add('bg-red-50', 'text-red-700', 'border', 'border-red-100');
//                 alert.innerText = "Please enter a valid 10-digit Indian mobile number starting with 6-9.";
//                 return;
//             }
// 
//             const data = {
//                 name: document.getElementById('modal-contact-name').value,
//                 email: document.getElementById('modal-contact-email').value,
//                 phone: phoneVal,
//                 subject: document.getElementById('modal-contact-subject').value,
//                 message: document.getElementById('modal-contact-message').value
//             };
// 
//             btn.disabled = true;
//             btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Submitting...';
//             alert.classList.add('hidden');
// 
//             try {
//                 let res = null;
//                 if (window.HBM_API) {
//                     res = await window.HBM_API.request('/contact', 'POST', data);
//                 }
//                 alert.classList.remove('hidden', 'bg-red-50', 'text-red-700', 'border-red-100');
//                 alert.classList.add('bg-green-50', 'text-green-700', 'border', 'border-green-100');
//                 alert.innerText = (res && res.message) ? res.message : "Request submitted successfully! We will contact you shortly.";
//                 form.reset();
// 
//                 // Do not re-enable button on success to prevent double submission before modal closes
//                 setTimeout(() => {
//                     closeModal();
//                     // Reset button state AFTER modal is completely hidden
//                     setTimeout(() => {
//                         btn.disabled = false;
//                         btn.innerHTML = 'Submit Request <i class="fa-solid fa-paper-plane ml-2 group-hover:-translate-y-1 group-hover:translate-x-1 transition-transform"></i>';
//                         alert.classList.add('hidden');
//                     }, 300);
//                 }, 2000);
//             } catch (err) {
//                 alert.classList.remove('hidden', 'bg-green-50', 'text-green-700', 'border-green-100');
//                 alert.classList.add('bg-red-50', 'text-red-700', 'border', 'border-red-100');
//                 alert.innerText = err.message || "Failed to submit request.";
// 
//                 // Only re-enable button on failure
//                 btn.disabled = false;
//                 btn.innerHTML = 'Submit Request <i class="fa-solid fa-paper-plane ml-2 group-hover:-translate-y-1 group-hover:translate-x-1 transition-transform"></i>';
//             }
//         });
    }
}
customElements.define('hbm-contact-modal', HbmContactModal);

document.addEventListener('DOMContentLoaded', () => {
    document.body.insertAdjacentHTML('beforeend', '<hbm-contact-modal></hbm-contact-modal>');
});

window.testMarker = true;
