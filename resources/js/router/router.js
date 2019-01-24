import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Login from '../components/login/Login.vue';


const routes = [
    {
        //name: 'login',
        path: '/login',
        component: Login,
        //props: true,
    },
];

export const router = new VueRouter({
    routes,
    mode: 'history',
    // linkActiveClass: "active",
    // linkExactActiveClass: "exact-active",
});