
require('./bootstrap');

require('alpinejs');
import Vue from 'vue'
window.Vue = Vue;

import VueRouter from 'vue-router'
Vue.use(VueRouter)

let routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default }
]

const router = new VueRouter({routes, mode: 'history'});

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
const app = new Vue({
  el: '#app',
  router
});