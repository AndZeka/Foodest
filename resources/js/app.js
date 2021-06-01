require('./bootstrap');
require('alpinejs');
import moment from 'moment'
import Vue from 'vue'
window.Vue = Vue;

import { HasError, AlertError } from 'vform/src/components/bootstrap5';
import Form from 'vform';

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '5px'
})

let routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/users', component: require('./components/Users.vue').default }
]

Vue.filter('upText', function(text){
  return text.charAt(0).toUpperCase() + text.slice(1);
});

Vue.filter('myDate',function(created){
  return moment(created).format('MMMM Do YYYY, h:mm:ss A');
});

const router = new VueRouter({routes, mode: 'history'});

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
const app = new Vue({
  el: '#app',
  router
});