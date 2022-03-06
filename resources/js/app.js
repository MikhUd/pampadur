require('./bootstrap');
import Vue from 'vue';
import router from './router';
import store from './store';

Vue.component('index', require('./components/index.vue').default);

const app = new Vue({
    el: '#app',
    router,
    store,
});
