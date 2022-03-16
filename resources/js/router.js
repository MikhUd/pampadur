import Vue from 'vue';
import VueRouter from 'vue-router';
import store from './store';
Vue.use(VueRouter);


let authGuard = function (to, from, next) {
    if (!store.getters.isLoggedIn) next({name: 'login'});
    else next();
}

let guestGuard = function (to, from, next) {
    if (store.getters.isLoggedIn) next({name: 'home'});
    else next();
}

const router =  new VueRouter({
    mode: 'history',

    routes: [
        {
            path: '/home',
            name: 'home',
            component: () => import('./components/Home'),
        },
        {
            path: '/profile',
            name: 'profile',
            component: () => import('./components/datingCard/Profile'),
            beforeEnter: authGuard
        },
        {
            path: '/',
            name: 'welcome',
            component: () => import('./components/Welcome'),
        },
        {
            path: '/login',
            name: 'login',
            component: () => import('./components/auth/Login'),
            beforeEnter: guestGuard
        },
        {
            path: '/registration',
            name: 'registration',
            component: () => import('./components/auth/Registration'),
            beforeEnter: guestGuard
        }
    ]
});

export default router;
