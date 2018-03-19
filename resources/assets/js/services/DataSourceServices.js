export default {
    index() {
        return axios.get('/api/repository/datasources');
    }
}