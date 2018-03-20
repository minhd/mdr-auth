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
        user: null
    },
    mutations: {
        setToken(state, token) {
            state.token = token
        },
        setUser(state, user) {
            state.user = user;
        }
    },
    getters: {
        isLoggedIn: state => {
            return state.token !== null
        },
        user: state => {
            return state.user;
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

            return axios.post('/oauth/token', {
                'grant_type': 'password',
                'client_id': '4',
                'client_secret': 'VOtdzpw5UieE4YVoknz0MIQ73ygDBRhVPqFvZOz3',
                'username': email,
                'password': password,
                'scope': '',
            }).then(({data}) => {
                context.commit("setToken", data);
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