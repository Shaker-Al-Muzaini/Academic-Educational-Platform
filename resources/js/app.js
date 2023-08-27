import './bootstrap';

import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js';
import 'admin-lte/dist/js/adminlte.min.js';
import { createPinia } from 'pinia';
import { createApp } from 'vue/dist/vue.esm-bundler.js';
import { createRouter, createWebHistory } from 'vue-router';
import Login from './pages/auth/Login.vue'
import Routes from './routes.js';
import App from './App.vue'


const app = createApp(App);
const pinia = createPinia();
const router = createRouter({
    routes: Routes,
    history: createWebHistory(),
});
app.use(pinia);
app.use(router);
if (window.location.pathname === '/login') {
    const currentApp = createApp({});
    currentApp.component('Login', Login);
    currentApp.mount('#login');
} else {
    app.mount('#app');
}
