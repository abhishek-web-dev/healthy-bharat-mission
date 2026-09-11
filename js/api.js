const HBM_API = {
    baseUrl: 'http://localhost:8000/api',

    getToken: function() {
        return localStorage.getItem('hbm_token');
    },

    setToken: function(token) {
        if (token) {
            localStorage.setItem('hbm_token', token);
        } else {
            localStorage.removeItem('hbm_token');
        }
    },

    request: async function(endpoint, method = 'GET', data = null) {
        const headers = {
            'Accept': 'application/json'
        };

        if (data instanceof FormData) {
            // Let fetch set Content-Type automatically for FormData
        } else if (data) {
            headers['Content-Type'] = 'application/json';
            data = JSON.stringify(data);
        }

        const token = this.getToken();
        if (token) {
            headers['Authorization'] = `Bearer ${token}`;
        }

        const config = {
            method: method,
            headers: headers
        };

        if (data) {
            config.body = data;
        }

        try {
            const response = await fetch(`${this.baseUrl}${endpoint}`, config);
            const responseData = await response.json();
            
            if (!response.ok) {
                let errorMsg = responseData.message || 'An error occurred';
                if (responseData.errors) {
                    const firstError = Object.values(responseData.errors)[0];
                    if (Array.isArray(firstError)) {
                        errorMsg = firstError[0];
                    } else if (typeof firstError === 'string') {
                        errorMsg = firstError;
                    }
                }
                const error = new Error(errorMsg);
                error.status = response.status;
                throw error;
            }

            return responseData;
        } catch (error) {
            // Also handle network errors that don't have a status
            throw error;
        }
    },
    auth: {
        login: (data) => HBM_API.request('/auth/login', 'POST', data),
        register: (data) => HBM_API.request('/auth/register', 'POST', data),
        verifyOtp: (data) => HBM_API.request('/auth/verify-otp', 'POST', data),
        forgotPassword: (data) => HBM_API.request('/auth/forgot-password', 'POST', data),
        resetPassword: (data) => HBM_API.request('/auth/reset-password', 'POST', data),
        changePassword: (data) => HBM_API.request('/auth/change-password', 'POST', data),
        deleteAccount: (data) => HBM_API.request('/auth/delete-account', 'POST', data),
        logout: () => HBM_API.request('/auth/logout', 'POST'),
        getMe: () => HBM_API.request('/auth/me')
    },
    user: {
        getProfile: () => HBM_API.request('/user/profile'),
        updateProfile: (data) => HBM_API.request('/user/profile', 'PUT', data),
    },
    checkout: {
        getAddresses: () => HBM_API.request('/user/addresses'),
        saveAddress: (data) => HBM_API.request('/user/addresses', 'POST', data),
        updateAddress: (id, data) => HBM_API.request(`/user/addresses/${id}`, 'PUT', data),
        deleteAddress: (id) => HBM_API.request(`/user/addresses/${id}`, 'DELETE'),
        createOrder: (data) => HBM_API.request('/orders', 'POST', data),
        verifyPayment: (data) => HBM_API.request('/payments/verify', 'POST', data)
    },
    orders: {
        getAll: () => HBM_API.request('/orders'),
        getDetails: (id) => HBM_API.request(`/orders/${id}`)
    }
};

window.HBM_API = HBM_API;
