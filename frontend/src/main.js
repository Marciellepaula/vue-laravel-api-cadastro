import { createApp } from "vue";
import App from "./App.vue";
import { createPinia } from 'pinia'
import "./style.css";
import { createRouter, createWebHistory } from "vue-router";
const pinia = createPinia()

import Detalhes from "./views/Detalhes.vue";
import CadastroForm from "./views/CadastroForm.vue";
import CadastroUpdate from "./views/CadastroUpdate.vue";
import CadastroList from "./views/CadastroList.vue";
import login from "./components/auth/login.vue";
import register from "./components/auth/register.vue";
import logout from "./components/auth/logout.vue";


const routes = [
    { path: "/", component: CadastroList, meta: { requiresAuth: true } },
    { path: "/atualizar/Cadastro/:id", name: "CadastroUpdate", component: CadastroUpdate, meta: { requiresAuth: true }, props: true },
    { path: "/CadastroForm", component: CadastroForm, meta: { requiresAuth: true } },
    { path: "/register", component: register },
    { path: "/login", component: login },
    { path: "/logout", component: logout, meta: { requiresAuth: true } },
    { path: "/detalhes/:id", name: "detalhes", component: Detalhes }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

createApp(App).use(router).use(pinia).mount("#app");

export default router;



