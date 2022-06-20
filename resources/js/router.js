import Vue from "vue";
import VueRouter from "vue-router";

import HomePage from './pages/HomePage.vue';
import SettingsPage from './pages/settings/SettingsPage.vue';
import SettingsCouponsPage from './pages/settings/CouponsPage.vue'
import SettingsProductsPage from './pages/settings/ProductsPage.vue'

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    routes: [

        {path: '*', redirect: '/' },
        {name: 'home', path: '/', component: HomePage},
        {name: 'settings', path: '/settings', component: SettingsPage, children: [
            {name: 'settings-products', path: '/products', component: SettingsProductsPage},
            {name: 'settings-coupons', path: '/coupons', component: SettingsCouponsPage},
        ]},

    ]
});

export default router;
