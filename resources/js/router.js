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
        {path: '/dashboard', component: require('./components/Dashboard.vue').default},
        {path: '/profile', component: require('./components/Profile.vue').default},
        {path: '/users', component: require('./components/Users.vue').default},
        {path: '/cities', component: require('./components/Cities.vue').default},
        {path: '/countries', component: require('./components/Countries.vue').default},
        {path: '*', component: require('./components/NotFound.vue').default}
        
    ]
})