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
        },
        {
            path: '/profile',
            name: 'profile',
            component: () => import('./components/Profile'),
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
        // На територию guest'ov)) не может зайти любой....
        // История тащемто простая, но довольно муторная, как бы это oxxюмиронно не звучало)))))
        // Тип не каждый авторизованный может зайти, даже не то что бы не каждый, вааще не какой!!!
        if (localStorage.getItem('user') !== null) {

            next({
                path: '/home'
            })
        }
    }
    next();
});

export default router;
