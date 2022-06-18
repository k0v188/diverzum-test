import Vue from "vue";
import VueRouter from "vue-router";

import HomePage from './pages/HomePage.vue';
import SettingsPage from './pages/SettingsPage.vue';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    routes: [

        {path: '*', redirect: '/' },
        {name: 'home', path: '/', component: HomePage},
        {name: 'settings', path: '/settings', component: SettingsPage},

    ]
});

export default router;
