
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('../js/print/jquery.min.js'); 
require('../js/print/jquery.printPage.js'); 

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('home', require('./components/Home.vue'));
Vue.component('admin-dashboard', require('./components/Dashboard.vue'));
Vue.component('lender-registration', require('./components/Registration.vue'));
Vue.component('registered-users', require('./components/RegisteredUsers.vue'));
Vue.component('areas', require('./components/Area.vue'));
Vue.component('area-list', require('./components/AreaList.vue'));
Vue.component('payment-list', require('./components/Payment.vue'));
Vue.component('quota', require('./components/Quota.vue'));
Vue.component('collector-view-only', require('./components/PaymentViewOnly.vue')); 
Vue.component('quota-view-only', require('./components/QuotaViewOnly.vue'));

Vue.component('autocomplete', require('./components/Autocomplete.vue'));

import moment from 'moment'

Vue.config.productionTip = false

Vue.filter('setupDate', function(value) {
  if (value) {
    return moment(String(value)).format('MM/DD/YYYY')
  }
});

Vue.filter('capitalize', function (value) {
  if (!value) return ''
  value = value.toString()
  return value.charAt(0).toUpperCase() + value.slice(1)
});


const app = new Vue({
    el: '#app'
});
