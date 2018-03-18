import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);

export default new Router({
    mode: 'hash',
    routes: [
        {
            path: '/login',
            name: 'login',
            component: require('./pages/Login.vue')
        },
        {
            path: '/register',
            name: 'register',
            component: require('./pages/Register.vue')
        }
    ],
});