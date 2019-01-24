import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Login from '../components/login/Login.vue';
import Signup from '../components/login/Signup.vue';
import Logout from '../components/login/Logout.vue';
import Forum from '../components/forum/Forum.vue';


const routes = [
    {
        name: 'login',
        path: '/login',
        component: Login,
        //props: true,
    },
    {
        name: 'signup',
        path: '/signup',
        component: Signup,
        //props: true,
    },
    {
        name: 'forum',
        path: '/forum',
        component: Forum,
        //props: true,
    },
    {
        name: 'logout',
        path: '/logout',
        component: Logout,
        //props: true,
    },
];

export const router = new VueRouter({
    routes,
    mode: 'history',
    // linkActiveClass: "active",
    // linkExactActiveClass: "exact-active",
});