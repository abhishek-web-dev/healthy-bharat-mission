
class HbmHeader extends HTMLElement {
    connectedCallback() {
        const basePath = this.getAttribute('base-path') || '';
        const imgPath = this.getAttribute('base-path') || './';
        
        this.style.display = 'contents';
        this.innerHTML = `<header class="bg-white/95 backdrop-blur-md shadow-sm sticky top-0 z-50">
        <div class="container mx-auto max-w-[1500px] relative">

            <!-- Top Bar Banner (Right side) -->
            <div class="absolute top-0 right-4 lg:right-8 hidden md:flex z-10">
                <div class="bg-primary text-white px-6 py-1.5 rounded-b-xl flex items-center space-x-6 shadow-sm">
                    <div class="flex items-center space-x-2 text-sm font-medium">
                        <i class="fa-solid fa-phone text-xs"></i>
                        <span class="whitespace-nowrap">+91 98765 43210</span>
                    </div>
                    <div class="w-px h-4 bg-white/30"></div>
                    <div class="flex space-x-4 text-[15px]">
                        <a href="#" class="hover:text-gray-300 transition-colors"><i
                                class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="hover:text-gray-300 transition-colors"><i
                                class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="hover:text-gray-300 transition-colors"><i
                                class="fa-brands fa-youtube"></i></a>
                        <a href="#" class="hover:text-gray-300 transition-colors"><i
                                class="fa-brands fa-discord"></i></a>
                    </div>
                </div>
            </div>

            <!-- Main Navigation -->
            <div class="px-2 lg:px-8 pt-4 md:pt-10 pb-4 flex justify-between items-center">
                <!-- Logo -->
                <a href="${basePath}index.html" class="flex items-center space-x-2 xl:space-x-3 -mt-2 group">
                    <img src="${imgPath}assets/logo.webp" alt="Logo" class="h-14 xl:h-16 flex-shrink-0 transition-transform group-hover:scale-105">
                    <div>
                        <h1
                            class="font-heading font-bold text-lg xl:text-2xl text-slate-800 leading-tight mb-1 whitespace-nowrap group-hover:text-primary transition-colors">
                            Healthy<br>Bharat Mission</h1>
                        <p class="text-[9px] xl:text-[11px] text-gray-500 font-medium tracking-wide whitespace-nowrap">
                            Towards a Diabetes Free India</p>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <div
                    class="hidden lg:flex space-x-3 xl:space-x-6 items-center font-medium text-[13px] xl:text-sm text-slate-700">
                    <a href="${basePath}index.html"
                        class="nav-link hover:text-primary transition-colors whitespace-nowrap">Home</a>
                    <a href="${basePath}mission.html" class="nav-link hover:text-primary transition-colors whitespace-nowrap">Our Mission</a>
                    <!-- Programs Dropdown -->
                    <div class="relative group">
                        <a href="${basePath}program.html"
                            class="nav-link hover:text-primary transition-colors flex items-center whitespace-nowrap py-4 -my-4">Programs <i
                                class="fa-solid fa-chevron-down text-[10px] ml-1.5 transition-transform group-hover:rotate-180"></i></a>
                        
                        <div class="absolute top-[calc(100%+1rem)] left-0 w-64 bg-white rounded-xl shadow-[0_10px_40px_rgba(0,0,0,0.1)] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 border border-gray-100 z-50 transform origin-top translate-y-2 group-hover:translate-y-0">
                            <!-- invisible bridge to prevent hover loss -->
                            <div class="absolute -top-4 left-0 w-full h-4"></div>
                            
                            <div class="p-2 space-y-1">
                                <a href="${basePath}program/diabetes-care.html" class="block px-4 py-2.5 text-[13px] font-medium text-slate-600 hover:bg-[#f2f8f3] hover:text-primary rounded-lg transition-colors flex items-center"><i class="fa-solid fa-droplet w-5 text-center mr-2 opacity-60"></i> Diabetes Reversal</a>
                                <a href="${basePath}program/weight-management.html" class="block px-4 py-2.5 text-[13px] font-medium text-slate-600 hover:bg-[#f2f8f3] hover:text-primary rounded-lg transition-colors flex items-center"><i class="fa-solid fa-weight-scale w-5 text-center mr-2 opacity-60"></i> Weight Management</a>
                                <a href="${basePath}program/pcos-care.html" class="block px-4 py-2.5 text-[13px] font-medium text-slate-600 hover:bg-[#f2f8f3] hover:text-primary rounded-lg transition-colors flex items-center"><i class="fa-solid fa-venus w-5 text-center mr-2 opacity-60"></i> PCOS Care</a>
                                <a href="${basePath}program/heart-health.html" class="block px-4 py-2.5 text-[13px] font-medium text-slate-600 hover:bg-[#f2f8f3] hover:text-primary rounded-lg transition-colors flex items-center"><i class="fa-solid fa-heart w-5 text-center mr-2 opacity-60"></i> Heart Health</a>
                                <a href="${basePath}program/liver-detox.html" class="block px-4 py-2.5 text-[13px] font-medium text-slate-600 hover:bg-[#f2f8f3] hover:text-primary rounded-lg transition-colors flex items-center"><i class="fa-solid fa-leaf w-5 text-center mr-2 opacity-60"></i> Liver Detox</a>
                                <a href="${basePath}program/senior-wellness.html" class="block px-4 py-2.5 text-[13px] font-medium text-slate-600 hover:bg-[#f2f8f3] hover:text-primary rounded-lg transition-colors flex items-center"><i class="fa-solid fa-users w-5 text-center mr-2 opacity-60"></i> Senior Wellness</a>
                                <div class="h-px bg-gray-100 my-1 mx-2"></div>
                                <a href="${basePath}program.html" class="block px-4 py-2.5 text-[13px] font-bold text-primary hover:bg-[#f2f8f3] rounded-lg transition-colors text-center">View All Programs</a>
                            </div>
                        </div>
                    </div>
                    <a href="${basePath}health-condition.html" class="nav-link hover:text-primary transition-colors whitespace-nowrap">Health Conditions</a>
                    <a href="${basePath}healthlibrary.html" class="nav-link hover:text-primary transition-colors whitespace-nowrap">Health Library</a>
                    <a href="${basePath}store.html" class="nav-link hover:text-primary transition-colors whitespace-nowrap">Store</a>
                    <a href="${basePath}successtories.html" class="nav-link hover:text-primary transition-colors whitespace-nowrap">Success Stories</a>
                    <a href="${basePath}contact.html" class="nav-link hover:text-primary transition-colors whitespace-nowrap">Contact</a>
                </div>

                <!-- CTA Button -->
                <div class="hidden md:block">
                    <a href="#"
                        class="bg-primary hover:bg-primary-light text-white px-4 xl:px-6 py-2 xl:py-2.5 rounded font-medium transition-colors shadow-sm text-sm whitespace-nowrap">
                        Book Consultation
                    </a>
                </div>

                <!-- Mobile Menu Toggle -->
                <div class="lg:hidden text-2xl text-primary mt-2 cursor-pointer">
                    <i class="fa-solid fa-bars"></i>
                </div>
            </div>
        </div>
    </header>`;

        // Auto-set active link based on current URL
        setTimeout(() => {
            const currentPath = window.location.pathname;
            const navLinks = this.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href && href !== '#') {
                    // Check if current path ends with href, or if it's the root/index and href is index.html
                    const isActive = currentPath.endsWith(href) || 
                                     (href === 'index.html' && (currentPath.endsWith('/') || currentPath === ''));
                    
                    if (isActive) {
                        link.classList.remove('hover:text-primary', 'transition-colors');
                        link.classList.add('text-primary', 'border-b-[3px]', 'border-primary', 'pb-1', 'font-semibold');
                    }
                }
            });
        }, 0);
    }
}
customElements.define('hbm-header', HbmHeader);

class HbmFooter extends HTMLElement {
    connectedCallback() {
        const basePath = this.getAttribute('base-path') || '';
        const imgPath = this.getAttribute('base-path') || './';
        
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
                        <form class="flex w-full max-w-sm mx-auto lg:mx-0 gap-2 xl:gap-3">
                            <input type="email" placeholder="Enter your email"
                                class="flex-grow bg-white px-3 py-2 xl:py-2.5 rounded text-sm border-none focus:ring-2 focus:ring-accent outline-none text-slate-800">
                            <button type="submit"
                                class="bg-accent hover:bg-yellow-500 text-slate-900 font-bold px-4 xl:px-6 py-2 xl:py-2.5 rounded text-sm transition-colors shadow-sm shrink-0">
                                Subscribe
                            </button>
                        </form>
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
                        <a href="${basePath}index.html" class="flex items-center mb-4 group">
                            <img src="${imgPath}assets/logo.webp" alt="Logo" class="h-[50px] mr-3 transition-transform group-hover:scale-105"
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
                            <li><a href="${basePath}index.html"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Home</a>
                            </li>
                            <li><a href="${basePath}mission.html"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Our
                                    Mission</a></li>
                            <li><a href="${basePath}program.html"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Programs</a>
                            </li>
                            <li><a href="#"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Health
                                    Conditions</a></li>
                            <li><a href="${basePath}healthlibrary.html"
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
                            <li><a href="${basePath}store.html"
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
                            <li><a href="#"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Book
                                    Consultation</a></li>
                            <li><a href="${basePath}contact.html"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Contact
                                    Us</a></li>
                            <li><a href="${basePath}legal/privacy-policy.html"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Privacy
                                    Policy</a></li>
                            <li><a href="${basePath}legal/terms-conditions.html"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Terms
                                    & Conditions</a></li>
                            <li><a href="${basePath}legal/refund-policy.html"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Refund
                                    Policy</a></li>
                            <li><a href="${basePath}legal/shipping-policy.html"
                                    class="text-slate-400 hover:text-accent text-xs xl:text-sm transition-colors">Shipping
                                    Policy</a></li>
                        </ul>
                    </div>

                    <!-- Col 6: Connect With Us -->
                    <div class="w-full md:w-1/2 lg:w-auto">
                        <h4 class="text-white font-semibold text-sm xl:text-base mb-5">Connect With Us</h4>
                        <div class="flex gap-3">
                            <a href="https://www.instagram.com/germanwithdeep?igsh=MWoxcTdnMjJjYzBhMg%3D%3D&amp;utm_source=qr" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:text-white hover:bg-gradient-to-tr hover:from-yellow-400 hover:via-pink-500 hover:to-purple-600 transition-all shadow-sm" aria-label="Instagram">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"></path></svg>
                            </a>
                            <a href="https://wa.me/917011233319" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:text-white hover:bg-[#25D366] transition-all shadow-sm" aria-label="WhatsApp">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"></path></svg>
                            </a>
                            <a href="https://www.youtube.com/@DeutschmitDeep" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:text-white hover:bg-[#FF0000] transition-all shadow-sm" aria-label="YouTube">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M23.5 6.2a2.99 2.99 0 0 0-2.1-2.1C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.4.6a2.99 2.99 0 0 0-2.1 2.1C0 8.1 0 12 0 12s0 3.9.5 5.8a2.99 2.99 0 0 0 2.1 2.1c1.9.6 9.4.6 9.4.6s7.5 0 9.4-.6a2.99 2.99 0 0 0 2.1-2.1C24 15.9 24 12 24 12s0-3.9-.5-5.8zM9.75 15.02V8.98L15.5 12l-5.75 3.02z"></path></svg>
                            </a>
                            <a href="mailto:deep03dey@gmail.com" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:text-white hover:bg-[#106e39] transition-all shadow-sm" aria-label="Email">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"></path></svg>
                            </a>
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
            <form class="space-y-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-regular fa-user text-gray-400"></i>
                    </div>
                    <input type="text" placeholder="Your Name *" required
                        class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-regular fa-envelope text-gray-400"></i>
                    </div>
                    <input type="email" placeholder="Your Email *" required
                        class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-phone text-gray-400 text-sm"></i>
                    </div>
                    <input type="tel" placeholder="Phone Number"
                        class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-list-ul text-gray-400 text-sm"></i>
                    </div>
                    <select required class="w-full pl-10 pr-10 py-3 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none text-gray-500">
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
                    <textarea placeholder="Your Message *" required rows="4"
                        class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all resize-none"></textarea>
                </div>
                <button type="submit"
                    class="w-full bg-primary hover:bg-primary-light text-white font-bold py-3.5 rounded-lg text-sm transition-colors shadow-md flex justify-center items-center group">
                    Send Message 
                    <i class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>
        </div>`;
    }
}
customElements.define('hbm-contact-form', HbmContactForm);

// Counter Animation
document.addEventListener('DOMContentLoaded', () => {
    const counters = document.querySelectorAll('.counter');
    const speed = 100; // Adjust for faster/slower counting

    const animateCounter = (counter) => {
        const updateCount = () => {
            const target = +counter.getAttribute('data-target');
            let count = +counter.innerText;
            if (count === 0) count = 1;

            const inc = Math.max(1, Math.ceil(target / speed));

            if (count < target) {
                counter.innerText = count + inc;
                setTimeout(updateCount, 20);
            } else {
                counter.innerText = target;
            }
        };
        updateCount();
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1
    });

    counters.forEach(counter => {
        observer.observe(counter);
    });
});

