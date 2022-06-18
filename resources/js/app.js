require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import vuetify from './plugins/vuetify'

import HomeComponent from './pages/HomeComponent.vue';

Vue.use(VueRouter);
Vue.use(VueAxios, axios);

const routes = [
    {
        name: 'home',
        path: '/',
        component: HomeComponent
    },
  ];

const router = new VueRouter({ mode: 'history', routes: routes});

const app = new Vue({
    el: "#app",
    mode: "history",
    router,
    vuetify,
    render: h => h(HomeComponent)
});


