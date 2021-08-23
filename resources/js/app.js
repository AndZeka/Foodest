require('./bootstrap');
require('alpinejs');
import moment from 'moment'
import Vue from 'vue'
window.Vue = Vue;

import { HasError, AlertError } from 'vform/src/components/bootstrap5';
import Form from 'vform';

import Gate from "./Gate";
Vue.prototype.$gate = new Gate(window.user);

import swal from 'sweetalert2'
window.swal = swal;


const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', swal.stopTimer)
    toast.addEventListener('mouseleave', swal.resumeTimer)
  }
})

window.toast = toast;

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import VueProgressBar from 'vue-progressbar'
import _ from 'lodash';
Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '5px'
})

let routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default }
]

Vue.filter('upText', function(text){
  return text.charAt(0).toUpperCase() + text.slice(1);
});

Vue.filter('myDate',function(created){
  return moment(created).format('MMMM Do YYYY, h:mm:ss A');
});

Vue.component(
  'not-found',
  require('./components/NotFound.vue')
);

Vue.component(
  'pagination',
  require('laravel-vue-pagination')
);

Vue.component('search-text-field', require('./components/SearchTextField.vue').default);
Vue.component('badge-icon', require('./components/BadgeIcon.vue').default);
Vue.component('add-to-cart-button', require('./components/AddToCartButton.vue').default);
Vue.component('stripe-payment-form', require('./components/StripePaymentForm.vue').default);

let Fire = new Vue();
window.Fire = Fire;

const router = new VueRouter({routes, mode: 'history'});

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
const app = new Vue({
  el: '#app',
  router
});