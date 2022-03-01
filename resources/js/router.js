import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',

    routes: [
        {
            path: '/home',
            name: 'home',
            component: () => import('./components/Home'),
        },
        {
            path: '/login',
            name: 'login',
            component: () => import('./components/auth/Login'),
        },
        {
            path: '/registration',
            name: 'registration',
            component: () => import('./components/auth/Registration'),
        }
    ]
})