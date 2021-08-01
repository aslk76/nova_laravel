/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import Vue from 'vue'
import vuetify from 'vuetify'
import Vuetify from 'vuetify/lib';
import axios from 'axios';
Vue.use(vuetify);
window.vuetify = vuetify;
window.Vue = require('vue')
window.axios = axios;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('nova-mplus', require('./components/novamplus.vue').default);
Vue.component('nova-various', require('./components/novavarious.vue').default);
Vue.component('nova-archives-mplus', require('./components/archives/novamplus.vue').default);
Vue.component('nova-archives-various', require('./components/archives/novavarious.vue').default);
Vue.component('nova-missing-mplus', require('./components/missing/novamplus.vue').default);
Vue.component('nova-missing-various', require('./components/missing/novavarious.vue').default);
Vue.component('nova-balanceops', require('./components/novabalanceops.vue').default);
Vue.component('nova-topboosters', require('./components/novatopboosters.vue').default);
Vue.component('nova-statistics', require('./components/novastatistics.vue').default);
Vue.component('nova-payments', require('./components/novapayments.vue').default);
Vue.component('nova-missingpayments', require('./components/novamissingpayments.vue').default);
Vue.component('nova-balance', require('./components/novabalance.vue').default);
Vue.component('nova-collections', require('./components/novacollections.vue').default);
Vue.component('nova-raids', require('./components/novaraids.vue').default);
Vue.component('nova-archives-raids', require('./components/archives/novaraids.vue').default);
Vue.component('nova-missing-raids', require('./components/missing/novaraids.vue').default);
Vue.config.silent = true
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 export default new Vuetify({
    theme: {
        options: {
            customProperties: true,
        },
    }
})

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    axios,
});
