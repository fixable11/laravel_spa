import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Login from '../components/login/Login.vue';
import Signup from '../components/login/Signup.vue';
import Logout from '../components/login/Logout.vue';
import Forum from '../components/forum/Forum.vue';
import Question from '../components/forum/pages/Question.vue';
import Ask from '../components/forum/pages/Ask.vue';
import CreateCategory from '../components/forum/pages/CreateCategory.vue';
import NotFoundComponent from '../components/NotFoundComponent.vue';


const routes = [
    {
        name: 'login',
        path: '/login',
        component: Login,
    },
    {
        name: 'signup',
        path: '/signup',
        component: Signup,
    },
    {
        name: 'forum',
        path: '/forum',
        component: Forum,
    },
    {
        name: 'logout',
        path: '/logout',
        component: Logout,
    },
    {
        name: 'questions',
        path: '/questions/:slug',
        component: Question,
    },
    {
        name: 'ask',
        path: '/ask',
        component: Ask,
    },
    {
        name: 'categories.create',
        path: '/categories/create',
        component: CreateCategory,
    },

    { path: '*', component: NotFoundComponent }
    
];

export const router = new VueRouter({
    routes,
    mode: 'history',
    // linkActiveClass: "active",
    // linkExactActiveClass: "exact-active",
});