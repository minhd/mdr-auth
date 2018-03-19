export default {

    lsKey: 'mdr-access-token',

    login(email, password) {
        let that = this;
        return axios.post('/auth/login', {email, password})
            .then(({data}) => {
                //console.log("Access token", data['access_token']);
                window.localStorage.setItem(that.lsKey, data['access_token'])
            })
    },

    logout() {
        let that = this;
        return axios.post('/auth/logout')
            .then(() => {
                window.localStorage.removeItem(that.lsKey);
            })
    },

    isLoggedIn() {
        return window.localStorage.getItem(this.lsKey) === null;
    },

    get() {
        return axios.get('/auth/profile');
    }
}