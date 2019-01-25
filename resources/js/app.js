
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vuetify from 'vuetify';
import {router} from './router/router.js';
import VueIziToast from 'vue-izitoast';
import VueSimplemde from 'vue-simplemde'
import md from 'marked';

window.md = md;

Vue.use(Vuetify);
Vue.use(VueIziToast);
Vue.use(VueSimplemde);


import User from "./helpers/User";
//import AppStorage from "./helpers/AppStorage";

window.User = User;
//window.AppStorage = AppStorage;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('flash', require('./components/Flash.vue').default);

Vue.component('toolbar', require('./components/Toolbar.vue').default);
Vue.component('app-main', require('./components/AppMain.vue').default);
Vue.component('app-footer', require('./components/AppFooter.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
