import Vue from 'vue';
import Vuex from 'vuex';
import VuexPersistence from 'vuex-persist'

Vue.use(Vuex);

const vuexLocal = new VuexPersistence({
    storage: window.localStorage
});

const store = new Vuex.Store({
    state: {
        token: null
    },
    mutations: {
        setToken (state, token) {
            state.token = token
        }
    },
    getters: {
        isLoggedIn: state => {
            return state.token !== null
        }
    },
    actions: {
        login (context, {email, password}) {

            return axios.post('/oauth/token', {
                'grant_type' : 'password',
                'client_id' : '4',
                'client_secret' : 'VOtdzpw5UieE4YVoknz0MIQ73ygDBRhVPqFvZOz3',
                'username' : email,
                'password' : password,
                'scope' : '',
            }).then(({data}) => {
                context.commit("setToken", data);
            });

            // return axios.post('/auth/login', {email, password})
            //     .then(({data}) => {
            //         context.commit("setToken", data['access_token']);
            //     })
        },
        logout(context) {
            context.commit("setToken", null);
        }
    },
    plugins: [vuexLocal.plugin]
});

export default store;