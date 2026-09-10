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
    checkout: {
        getAddresses: () => request('/api/user/addresses'),
        saveAddress: (data) => request('/api/user/addresses', { method: 'POST', body: JSON.stringify(data) }),
        createOrder: (data) => request('/api/orders', { method: 'POST', body: JSON.stringify(data) }),
        verifyPayment: (data) => request('/api/payments/verify', { method: 'POST', body: JSON.stringify(data) })
    },
    orders: {
        getAll: () => request('/api/orders'),
        getDetails: (id) => request(`/api/orders/${id}`)
    }
};

window.HBM_API = HBM_API;
