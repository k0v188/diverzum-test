require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import vuetify from './plugins/vuetify';
import router from './router';

import MainLayout from './layouts/MainLayout.vue';

Vue.use(VueRouter);
Vue.use(VueAxios, axios);

const app = new Vue({
    el: "#app",
    mode: "history",
    router,
    vuetify,
    render: h => h(MainLayout)
});


