import store from '../store.js';

export default {
    index() {
        return store.getters.api.get('/api/repository/datasources');
    }
}