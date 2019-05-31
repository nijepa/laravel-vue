/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Load Sweet Alert
 */
/*import swal from 'sweetalert2'
window.swal = swal;

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

window.toast = toast;*/

/*/!**
 * Load vForm
 *!/
import { Form, HasError, AlertError } from 'vform'
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);*/

/**
 * Load authorization
 */
import Gate from './Gate';
Vue.prototype.$gate = new Gate(window.user);

/*/!**
 * Load Vue-Progress bar
 *!/
import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar, {
   color: 'blue',
   failedColor: 'red',
   height: '5px'
});*/

/**
 * Load Moment
 */
//import moment from 'moment';

/**
 * Load Laravel-Vue-Pagination
 */
//Vue.component('pagination', require('laravel-vue-pagination'));

/**
 * Create events listener
 */
window.Fire = new Vue();

/**
 * Load Vue Router
 */
/*import VueRouter from 'vue-router';

Vue.use(VueRouter);

/!**
 * Create Vue routes
 * @type {*[]}
 *!/
let routes = [
    {path: '/dashboard', component: require('./components/Dashboard.vue').default},
    {path: '/profile', component: require('./components/Profile.vue').default},
    {path: '/users', component: require('./components/Users.vue').default},
    {path: '*', component: require('./components/NotFound.vue').default}
];

/!**
 * Create Vue router
 * @type {VueRouter}
 *!/
const router = new VueRouter({
    mode: 'history',
    routes
});*/

/*Vue.filter('upText', (text) => {
    return text.charAt(0).toUpperCase() + text.slice(1);
});

Vue.filter('customDate', (fromDate) => {
    return moment(fromDate).format("MMM Do YYYY");
});*/

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.component(
    'unauthorized',
    require('./components/Unauthorized.vue').default
);

import helpers from './helpers/helpers';
import filters from './helpers/filters';
import router from './router';
import store from './store/store'
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app',
    router,
    store,
    data: {
        search: ''
    },
    methods: {
        searchIt: _.debounce(() => {
            Fire.$emit('searching');
        }, 2000)

            //console.log('Searching...')

    }

});
