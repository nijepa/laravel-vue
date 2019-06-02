import Vue from 'vue'
import Router from 'vue-router'
//import Home from './views/Home.vue'

/**
 * Load router and add routes
 */
Vue.use(Router);

export default new Router({
    mode: 'history',

    base: process.env.BASE_URL,
    routes: [
        {path: '/', component: require('./views/front/Home.vue').default},
        {path: '/representations', component: require('./views/front/Representations.vue').default},
        {path: '/about', component: require('./views/front/About.vue').default},
        {path: '/contact', component: require('./views/front/Contact.vue').default},

        {path: '/home', component: require('./components/Dashboard.vue').default},
        {path: '/dashboard', component: require('./components/Dashboard.vue').default},
        {path: '/profile', component: require('./components/Profile.vue').default},
        {path: '/users', component: require('./components/Users.vue').default},
        {path: '/cities', component: require('./components/Cities.vue').default},
        {path: '/countries', component: require('./components/Countries.vue').default},
        {path: '*', component: require('./components/NotFound.vue').default}
        
    ]
})