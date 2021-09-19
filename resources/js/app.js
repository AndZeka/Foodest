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
    { path: '/my-restaurants', component: require('./components/MyRestaurants.vue').default },
    { path: '/my-products', component: require('./components/MyProducts.vue').default },
    { path: '/track-order-map', component: require('./components/TrackOrderMap.vue').default },
    { path: '/my-orders', component: require('./components/MyOrders.vue').default },
    { path: '/restaurant-orders', component: require('./components/RestaurantOrders.vue').default },
    { path: '/add', component: require('./components/Contact.vue').default },
    { path: '/emails', component: require('./components/EmailsList.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default },
]

import * as VueGoogleMaps from 'vue2-google-maps'

//Google Maps
Vue.use(VueGoogleMaps, {
  load: { libraries: 'geometry', key: 'AIzaSyB7qGSRtd_du7Yd2YCtrYMhd7o1Xrv0H6Y' }
})

import MapsUtils from './utils/maps-utils.js'
Vue.use(MapsUtils)

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
Vue.component('contact-form', require('./components/Contact.vue').default);

let Fire = new Vue();
window.Fire = Fire;

const router = new VueRouter({routes, mode: 'history'});

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
const app = new Vue({
  el: '#app',
  router
});