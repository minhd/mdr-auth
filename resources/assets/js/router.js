import Vue from 'vue'
import Router from 'vue-router'
import UserService from "./services/UserService";

Vue.use(Router);

const router = new Router({
    mode: 'hash',
    routes: [
        {path: '/login', name: 'login', component: require('./pages/Login.vue')},
        {path: '/register', name: 'register', component: require('./pages/Register.vue')},
        {path: '/dashboard', name: 'dashboard', component: require('./pages/Dashboard.vue')}
    ],
});

router.beforeEach((to, from, next) => {
    if (to.fullPath !== "/login") {
        UserService.get().then(response => {
            next();
        }).catch(error => {
            router.push('/login');
        })
    }else{
        next();
    }
});

export default router;

