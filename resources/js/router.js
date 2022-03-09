import Vue from 'vue';
import VueRouter from 'vue-router';
import store from './store';
Vue.use(VueRouter);

let router =  new VueRouter({
    mode: 'history',

    routes: [
        {
            path: '/home',
            name: 'home',
            component: () => import('./components/Home'),
            meta: {
                guest: false
            }
        },
        {
            path: '/profile',
            name: 'profile',
            component: () => import('./components/Profile'),
            meta: {
                guest: false
            }
        },
        {
            path: '/',
            name: 'welcome',
            component: () => import('./components/Welcome'),
            meta: {
                guest: true
            }
        },
        {
            path: '/login',
            name: 'login',
            component: () => import('./components/auth/Login'),
            meta: {
                guest: true
            }
        },
        {
            path: '/registration',
            name: 'registration',
            component: () => import('./components/auth/Registration'),
            meta: {
                guest: true
            }
        }
    ]
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.guest)) {
        if (localStorage.getItem('user') !== null) {
            next({
                path: '/home'
            })
        }
    }
    next();
});

export default router;
