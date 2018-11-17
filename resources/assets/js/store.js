import Vue from 'vue';
import Vuex from 'vuex';
import VuexPersistence from 'vuex-persist'

Vue.use(Vuex);

const vuexLocal = new VuexPersistence({
    storage: window.localStorage,
    key: "minhd.mdr"
});

const store = new Vuex.Store({
    state: {
        token: null,
        user: null,
        loading: false
    },
    mutations: {
        setToken(state, token) {
            state.token = token
        },
        setUser(state, user) {
            state.user = user;
        },
        setLoading(state, x) {
            state.loading = x;
        }
    },
    getters: {
        isLoggedIn: state => {
            return state.token !== null
        },
        user: state => {
            return state.user;
        },
        loading: state => {
            return state.loading
        },
        api: state => {
            if (!state.token) {
                return null;
            }

            return axios.create({
                headers: {
                    'Content-type': 'application/json',
                    'Authorization': 'Bearer ' + state.token.access_token
                }
            });
        }
    },
    actions: {
        login(context, {email, password}) {
            context.commit("setLoading", true);
            let pwg = JSON.parse(atob(window.pwg));
            return axios.post('/oauth/token', {
                'grant_type': 'password',
                'client_id': pwg.client_id,
                'client_secret': pwg.client_secret,
                'username': email,
                'password': password,
                'scope': '',
            }).then(({data}) => {
                context.commit("setToken", data);
                context.commit("setLoading", false);
                context.getters.api.get('/api/user')
                    .then(({data}) => context.commit("setUser", data));
            });
        },
        logout(context) {
            context.commit("setToken", null);
        }
    },
    plugins: [vuexLocal.plugin]
});

export default store;