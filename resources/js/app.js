import './bootstrap';

import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js';
import 'admin-lte/dist/js/adminlte.min.js';
import { createPinia } from 'pinia';
import { createApp } from 'vue/dist/vue.esm-bundler.js';
import { createRouter, createWebHistory } from 'vue-router';
import Routes from './routes.js';
import App from './App.vue'
import { useAuthUserStore } from './stores/AuthUserStore';
import { useSettingStore } from './stores/SettingStore';


const app = createApp(App);
const pinia = createPinia();
const router = createRouter({
    routes: Routes,
    history: createWebHistory(),
});
router.beforeEach (async(to,form) =>{
    const authUserStore=useAuthUserStore();
    if (authUserStore.user.name === '' && to.name !== 'admin.login'){
        const settingStore=useSettingStore();
        await Promise.all([
            authUserStore.getAuthUser(),
            settingStore.getSetting(),
        ]);
    }
});
app.use(pinia);
app.use(router);
app.mount('#app');
