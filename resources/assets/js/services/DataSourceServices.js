import store from '../store.js';

export default {
    index() {
        axios.interceptors.request.use(function(config) {
            const token = store.getters.isLoggedIn ? store.state.token.access_token : null;

            if ( token !== null ) {
                config.headers.Authorization = `Bearer ${token}`;
            }

            return config;
        }, function(err) {
            return Promise.reject(err);
        });

        return axios.get('/api/repository/datasources');
    }
}