let currentProfileData = null;

document.addEventListener('hbm:auth-ready', async () => {
    const loadingState = document.createElement('div');
    loadingState.className = 'flex justify-center items-center py-20 w-full';
    loadingState.innerHTML = '<div class="w-10 h-10 border-4 border-[#106e39] border-t-transparent rounded-full animate-spin"></div>';
    
    const mainContainer = document.getElementById('dashboard-main');
    const originalContent = mainContainer.innerHTML;
    mainContainer.innerHTML = '';
    mainContainer.appendChild(loadingState);

    try {
        const response = await HBM_API.user.getProfile();
        if (response.success && response.data) {
            mainContainer.innerHTML = originalContent; // Restore layout
            currentProfileData = response.data;
            populateProfile(response.data);
            setupEditModal();
            setupTabs();
            setupChangePassword();
            setupAddressManagement();
        } else {
            throw new Error('Failed to load profile');
        }
    } catch (error) {
        console.error('Profile loading error:', error);
        mainContainer.innerHTML = `
            <div class="bg-red-50 text-red-600 p-6 rounded-2xl border border-red-100 flex flex-col items-center justify-center text-center">
                <i class="fa-solid fa-triangle-exclamation text-4xl mb-4"></i>
                <h3 class="text-lg font-bold mb-2">Error Loading Profile</h3>
                <p class="text-[14px]">We couldn't load your profile details. Please try again later.</p>
                <button onclick="window.location.reload()" class="mt-4 px-6 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition-colors">Retry</button>
            </div>
        `;
    }
});

function calculateAge(dobStr) {
    if (!dobStr) return '--';
    const dob = new Date(dobStr);
    const diff_ms = Date.now() - dob.getTime();
    const age_dt = new Date(diff_ms); 
    return Math.abs(age_dt.getUTCFullYear() - 1970) + ' Years';
}

function formatDate(dateStr) {
    if (!dateStr) return '--';
    const date = new Date(dateStr);
    return date.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
}

function populateProfile(data) {
    // Top banner
    const greetingEl = document.getElementById('prof-greeting');
    if (greetingEl) greetingEl.textContent = `Hello, ${data.first_name}!`;
    
    // Personal Information Tab
    const fullNameEl = document.getElementById('val-fullname');
    if (fullNameEl) fullNameEl.textContent = `${data.first_name} ${data.last_name}`;
    
    const patientIdEl = document.getElementById('val-patient-id');
    // Using ID to generate something like HBM2609110130652
    // If id=4, pad with zeros: HBM000004
    if (patientIdEl) patientIdEl.textContent = `HBM${String(data.id).padStart(12, '0')}`;
    
    const dobEl = document.getElementById('val-dob');
    if (dobEl) dobEl.textContent = formatDate(data.dob);
    
    const memberSinceEl = document.getElementById('val-member-since');
    if (memberSinceEl) memberSinceEl.textContent = formatDate(data.member_since);
    
    const emailEl = document.getElementById('val-email');
    if (emailEl) emailEl.textContent = data.email || '--';

    const phoneEl = document.getElementById('val-phone');
    if (phoneEl) phoneEl.textContent = data.phone || '--';

    const genderEl = document.getElementById('val-gender');
    if (genderEl) genderEl.textContent = data.gender ? (data.gender.charAt(0).toUpperCase() + data.gender.slice(1)) : '--';
    
    const ageEl = document.getElementById('val-age');
    if (ageEl) ageEl.textContent = calculateAge(data.dob);
    
    const bloodGroupEl = document.getElementById('val-blood-group');
    if (bloodGroupEl) bloodGroupEl.textContent = data.blood_group || '--';
    
    // Hardcoded to Indian for now as requested format, or fetch from address later
    const nationalityEl = document.getElementById('val-nationality');
    if (nationalityEl) nationalityEl.textContent = 'Indian'; 

    // Profile Summary Right Sidebar
    const healthProfileEl = document.getElementById('summary-health-profile');
    if (healthProfileEl) {
        // If gender, dob, and blood group are set, it's complete, else incomplete
        if (data.gender && data.dob && data.blood_group) {
            healthProfileEl.innerHTML = `<span class="bg-[#e2f6e9] text-[#106e39] text-[10px] font-bold px-2 py-0.5 rounded-full">Complete</span>`;
        } else {
            healthProfileEl.innerHTML = `<span class="bg-red-50 text-red-500 text-[10px] font-bold px-2 py-0.5 rounded-full">Incomplete</span>`;
        }
    }
    
    const activeProgramsEl = document.getElementById('summary-active-programs');
    if (activeProgramsEl) activeProgramsEl.textContent = data.active_programs || 0;
    
    const totalOrdersEl = document.getElementById('summary-total-orders');
    if (totalOrdersEl) totalOrdersEl.textContent = data.total_orders || 0;
    
    const appointmentsEl = document.getElementById('summary-appointments');
    if (appointmentsEl) appointmentsEl.textContent = data.appointments || 0;
}

function setupEditModal() {
    const btnEdit = document.getElementById('btn-edit-profile');
    const modal = document.getElementById('edit-profile-modal');
    const btnClose = document.getElementById('close-edit-modal');
    const btnCancel = document.getElementById('btn-cancel-edit');
    const form = document.getElementById('edit-profile-form');

    if (!btnEdit || !modal) return;

    const openModal = () => {
        // Populate form
        if (currentProfileData) {
            document.getElementById('edit-fname').value = currentProfileData.first_name || '';
            document.getElementById('edit-lname').value = currentProfileData.last_name || '';
            document.getElementById('edit-phone').value = currentProfileData.phone || '';
            document.getElementById('edit-dob').value = currentProfileData.dob || '';
            document.getElementById('edit-gender').value = currentProfileData.gender || '';
            document.getElementById('edit-blood-group').value = currentProfileData.blood_group || '';
        }

        modal.classList.remove('hidden');
        // trigger reflow
        void modal.offsetWidth;
        modal.classList.remove('opacity-0');
        modal.querySelector('div').classList.remove('scale-95');
    };

    const closeModal = () => {
        modal.classList.add('opacity-0');
        modal.querySelector('div').classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 300);
    };

    btnEdit.addEventListener('click', openModal);
    btnClose.addEventListener('click', closeModal);
    btnCancel.addEventListener('click', closeModal);

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const btnSave = document.getElementById('btn-save-profile');
        const originalText = btnSave.innerHTML;
        btnSave.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
        btnSave.disabled = true;

        const data = {
            first_name: document.getElementById('edit-fname').value,
            last_name: document.getElementById('edit-lname').value,
            phone: document.getElementById('edit-phone').value,
            dob: document.getElementById('edit-dob').value,
            gender: document.getElementById('edit-gender').value,
            blood_group: document.getElementById('edit-blood-group').value
        };

        try {
            const res = await HBM_API.user.updateProfile(data);
            if (res.success && res.data) {
                currentProfileData = res.data;
                populateProfile(res.data);
                closeModal();
                
                // Optional: Show success toast
            }
        } catch (error) {
            alert(error.message || 'Failed to update profile');
        } finally {
            btnSave.innerHTML = originalText;
            btnSave.disabled = false;
        }
    });
}

function setupTabs() {
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const tabId = btn.getAttribute('data-tab');

            // Reset all buttons
            tabBtns.forEach(b => {
                b.classList.remove('border-[#106e39]', 'text-[#106e39]');
                b.classList.add('border-transparent', 'text-gray-500');
                const icon = b.querySelector('i');
                if (icon) {
                    // Just removing potential active classes
                }
            });

            // Activate clicked button
            btn.classList.add('border-[#106e39]', 'text-[#106e39]');
            btn.classList.remove('border-transparent', 'text-gray-500');

            // Hide all content
            tabContents.forEach(c => {
                c.classList.add('hidden');
                c.classList.remove('block');
            });

            // Show selected content
            const content = document.getElementById(`tab-${tabId}`);
            if (content) {
                content.classList.remove('hidden');
                content.classList.add('block');
                
                // If address tab, load addresses
                if (tabId === 'address') {
                    loadAddresses();
                }
            }
        });
    });
}

function setupChangePassword() {
    const form = document.getElementById('change-password-form');
    const errorEl = document.getElementById('change-pwd-error');
    const successEl = document.getElementById('change-pwd-success');

    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        errorEl.classList.add('hidden');
        successEl.classList.add('hidden');

        const btnSave = document.getElementById('btn-change-pwd');
        const originalText = btnSave.innerHTML;
        btnSave.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Updating...';
        btnSave.disabled = true;

        const data = {
            current_password: document.getElementById('pwd-current').value,
            new_password: document.getElementById('pwd-new').value,
            confirm_password: document.getElementById('pwd-confirm').value
        };

        try {
            const res = await HBM_API.auth.changePassword(data);
            if (res.success) {
                successEl.classList.remove('hidden');
                form.reset();
            }
        } catch (error) {
            errorEl.querySelector('span').textContent = error.message || 'Failed to update password';
            errorEl.classList.remove('hidden');
        } finally {
            btnSave.innerHTML = originalText;
            btnSave.disabled = false;
        }
    });
}

let userAddresses = [];

async function loadAddresses() {
    const container = document.getElementById('address-list');
    if (!container) return;

    try {
        const res = await HBM_API.checkout.getAddresses();
        if (res.success) {
            userAddresses = res.data || [];
            renderAddresses();
        }
    } catch (error) {
        container.innerHTML = `<div class="col-span-full py-8 text-center text-red-500">Failed to load addresses: ${error.message}</div>`;
    }
}

function renderAddresses() {
    const container = document.getElementById('address-list');
    if (!container) return;

    if (userAddresses.length === 0) {
        container.innerHTML = `
            <div class="col-span-full py-8 text-center bg-gray-50 rounded-2xl border border-gray-100">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-gray-400 mx-auto mb-3 shadow-sm">
                    <i class="fa-solid fa-location-dot text-xl"></i>
                </div>
                <h4 class="text-[14px] font-bold text-gray-800 mb-1">No Addresses Saved</h4>
                <p class="text-[12px] text-gray-500">You haven't added any delivery addresses yet.</p>
            </div>
        `;
        return;
    }

    container.innerHTML = userAddresses.map(addr => `
        <div class="bg-gray-50 p-6 rounded-2xl border ${addr.is_default ? 'border-[#106e39] ring-1 ring-[#106e39]' : 'border-gray-100'} relative group">
            ${addr.is_default ? '<div class="absolute -top-3 -right-3 bg-[#106e39] text-white text-[10px] font-bold px-2 py-1 rounded-full shadow-sm"><i class="fa-solid fa-star text-[8px] mr-1"></i>Default</div>' : ''}
            
            <div class="flex justify-between items-start mb-3">
                <div class="flex items-center gap-2">
                    <span class="font-bold text-gray-800">${addr.first_name || ''} ${addr.last_name || ''}</span>
                    <span class="bg-white px-2.5 py-1 rounded-md text-[11px] font-bold text-gray-500 shadow-sm border border-gray-200 uppercase tracking-wide ml-2">${addr.type || 'Home'}</span>
                </div>
                <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button onclick="editAddress(${addr.id})" class="w-7 h-7 rounded bg-white text-gray-500 hover:text-[#106e39] shadow-sm flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-pen text-[12px]"></i>
                    </button>
                    <button onclick="deleteAddress(${addr.id})" class="w-7 h-7 rounded bg-white text-gray-500 hover:text-red-500 shadow-sm flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-trash-can text-[12px]"></i>
                    </button>
                </div>
            </div>
            <p class="text-[14px] text-gray-800 font-medium leading-relaxed mt-2">
                ${addr.address_line_1 || ''}${addr.address_line_2 ? ', ' + addr.address_line_2 : ''}<br>
                ${addr.city || ''}, ${addr.state || ''} ${addr.pincode || ''}<br>
                <i class="fa-solid fa-phone text-[12px] text-gray-500 mr-1 mt-1"></i> +91 ${addr.phone || ''}
            </p>
        </div>
    `).join('');
}

function setupAddressManagement() {
    const modal = document.getElementById('address-modal');
    const btnAdd = document.getElementById('btn-add-address');
    const btnClose = document.getElementById('close-address-modal');
    const btnCancel = document.getElementById('btn-cancel-address');
    const form = document.getElementById('address-form');

    if (!modal) return;

    const openModal = () => {
        modal.classList.remove('hidden');
        void modal.offsetWidth; // force reflow
        modal.classList.remove('opacity-0');
        modal.querySelector('div').classList.remove('scale-95');
    };

    const closeModal = () => {
        modal.classList.add('opacity-0');
        modal.querySelector('div').classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            form.reset();
            document.getElementById('addr-id').value = '';
            document.getElementById('address-modal-title').textContent = 'Add New Address';
            
            // Auto-fill user details if adding a new address
            if (currentProfileData) {
                document.getElementById('addr-fname').value = currentProfileData.first_name || '';
                document.getElementById('addr-lname').value = currentProfileData.last_name || '';
                document.getElementById('addr-phone').value = currentProfileData.phone || '';
            }
        }, 300);
    };

    btnAdd?.addEventListener('click', () => {
        document.getElementById('address-modal-title').textContent = 'Add New Address';
        openModal();
    });
    btnClose?.addEventListener('click', closeModal);
    btnCancel?.addEventListener('click', closeModal);

    form?.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const btnSave = document.getElementById('btn-save-address');
        const originalText = btnSave.innerHTML;
        btnSave.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
        btnSave.disabled = true;

        const id = document.getElementById('addr-id').value;
        const data = {
            type: document.getElementById('addr-type').value,
            first_name: document.getElementById('addr-fname').value,
            last_name: document.getElementById('addr-lname').value,
            phone: document.getElementById('addr-phone').value,
            address_line_1: document.getElementById('addr-line1').value,
            address_line_2: document.getElementById('addr-line2').value,
            city: document.getElementById('addr-city').value,
            state: document.getElementById('addr-state').value,
            pincode: document.getElementById('addr-pincode').value,
            landmark: document.getElementById('addr-landmark').value,
            is_default: document.getElementById('addr-default').checked ? 1 : 0
        };

        try {
            if (id) {
                await HBM_API.checkout.updateAddress(id, data);
            } else {
                await HBM_API.checkout.saveAddress(data);
            }
            closeModal();
            loadAddresses(); // reload list
        } catch (error) {
            alert(error.message || 'Failed to save address');
        } finally {
            btnSave.innerHTML = originalText;
            btnSave.disabled = false;
        }
    });

    // Expose edit and delete to window so inline onclick handlers work
    window.editAddress = (id) => {
        const addr = userAddresses.find(a => a.id === id);
        if (!addr) return;
        
        document.getElementById('addr-id').value = addr.id;
        document.getElementById('addr-type').value = addr.type || 'home';
        document.getElementById('addr-fname').value = addr.first_name || '';
        document.getElementById('addr-lname').value = addr.last_name || '';
        document.getElementById('addr-phone').value = addr.phone || '';
        document.getElementById('addr-line1').value = addr.address_line_1 || '';
        document.getElementById('addr-line2').value = addr.address_line_2 || '';
        document.getElementById('addr-city').value = addr.city || '';
        document.getElementById('addr-state').value = addr.state || '';
        document.getElementById('addr-pincode').value = addr.pincode || '';
        document.getElementById('addr-landmark').value = addr.landmark || '';
        document.getElementById('addr-default').checked = addr.is_default == 1;
        
        document.getElementById('address-modal-title').textContent = 'Edit Address';
        openModal();
    };

    window.deleteAddress = async (id) => {
        if (!confirm('Are you sure you want to delete this address?')) return;
        
        try {
            await HBM_API.checkout.deleteAddress(id);
            loadAddresses();
        } catch (error) {
            alert(error.message || 'Failed to delete address');
        }
    };
}
