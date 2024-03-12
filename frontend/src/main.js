import { createApp } from "vue";
import App from "./App.vue";
import "./style.css";
import { createRouter, createWebHistory } from "vue-router";

import CadastroForm from "./views/CadastroForm.vue";
import CadastroUpadate from "./views/CadastroUpdate.vue";
import CadastroList from "./views/CadastroList.vue";
import login from "./components/auth/login.vue";
import register from "./components/auth/register.vue";
import logout from "./components/auth/logout.vue";

const routes = [
    { path: "/", component: CadastroList, meta: { requiresAuth: true } },
    { path: "/atualizar/Cadastro", component: CadastroUpadate, meta: { requiresAuth: true } },
    { path: "/CadastroForm", component: CadastroForm, meta: { requiresAuth: true } },
    { path: "/register", component: register },
    { path: "/login", component: login },
    { path: "/logout", component: logout, meta: { requiresAuth: true } }];


const router = createRouter({
    history: createWebHistory(),
    routes,
});

createApp(App).use(router).mount("#app");
export default router;