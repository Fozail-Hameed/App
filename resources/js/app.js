/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('admin-lte');

import Vue from 'vue';
import moment from 'moment';
window.Form = Form;
import VueRouter from 'vue-router';
import Dashboard from './components/DashboardComponent.vue';
import Profile from './components/ProfileComponent.vue';
import Users from './components/Users.vue';
import Developer from './components/Developer.vue';
import Popper from 'popper.js';
import { Form, HasError, AlertError } from 'vform'
import VueProgressBar from 'vue-progressbar'
//sweet alert start here
import Swal from 'sweetalert2'
window.Swal = Swal;

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  onOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
});

window.Toast = Toast;
// sweet alert end here
Vue.use(VueRouter);

let  routes = [
  {
    path: '/admin/dashboard',
    component: require('./components/DashboardComponent.vue').default,
    name: 'Dashboard'
     },
      {
    path: '/admin/developer',
    component: require('./components/Developer.vue').default,
    name: 'Developer'
     },
     {
    path: '/admin/profile',
    component: require('./components/ProfileComponent.vue').default,
    name: 'Profile'
     },
      {
    path: '/admin/user',
    component: require('./components/Users.vue').default,
    name: 'Users'
     },
]


const router = new VueRouter({
  routes,  // short for `routes: routes`
        history: true,
})

//ProgressBar
Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '200px'
})

 // yeh filter first letter capital k liy hai
Vue.filter('upText',function(text){
    return text.toString();
});


//yeh filter Date k formate k liya hai jo Moment.js k through add kiya
Vue.filter('myDate', function(date){
    return moment(date).format("MMM Do YY");
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component(
    'passport-clients',
    require('../assets/js/components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('../assets/js/components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('../assets/js/components/passport/PersonalAccessTokens.vue').default
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    components: {Dashboard, Profile, Users,Developer}
});
export default routes;