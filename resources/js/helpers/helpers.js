import swal from 'sweetalert2'
window.swal = swal;

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

window.toast = toast;


window.Vue = require('vue');
/**
 * Load vForm
 */
import { Form, HasError, AlertError } from 'vform'
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

/**
 * Load Vue-Progress bar
 */
import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar, {
    color: 'blue',
    failedColor: 'red',
    height: '5px'
});



/**
 * Load smooth scrolling plugin
 */
import vueSmoothScroll from 'vue2-smooth-scroll'
Vue.use(vueSmoothScroll);
Vue.config.productionTip = false;

/**
 * Load Laravel-Vue-Pagination
 */
Vue.component('pagination', require('laravel-vue-pagination'));