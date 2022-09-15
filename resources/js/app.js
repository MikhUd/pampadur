require('./bootstrap');
const UNAUTHORIZED = 401;
import Vue from 'vue';
import router from './router';
import store from './store';
import axios from 'axios';
import Client from '../js/api-client/client';

axios.interceptors.request.use(config => {
    if (localStorage.getItem('token')) {
        config.headers.common['Authorization'] = 'Bearer ' + store.getters.getToken;
    }
    return config;
});

axios.interceptors.response.use(
    response => response,
    error => {
        const {status} = error.response;
        if (status === UNAUTHORIZED) {
            store.dispatch('onLogout', false);
            router.push('/home').catch(()=>{});
        }
        return Promise.reject(error);
    }
);

//Vue.prototype.$client = new Client(axios);
Vue.component('index', require('./components/Index.vue').default);

const app = new Vue({
    el: '#app',
    router,
    store,
});



