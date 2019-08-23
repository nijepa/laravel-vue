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
        // frontend routes
        {path: '/', component: () => import('./views/front/Home.vue')},
        // {path: '/', component: require('./views/front/Home.vue').default},
        {path: '/representations', component: () => import('./views/front/Representations.vue')},
        {path: '/about', component: () => import('./views/front/About.vue')},
        {path: '/contact', component: () => import('./views/front/Contact.vue')},
        {path: '/products', component: () => import('./views/front/Product.vue')},
        {path: '/news', component: () => import('./views/front/News.vue')},
        {path: '/production', component: () => import('./views/front/Production.vue')},
        {path: '/exports', component: () => import('./views/front/Exports.vue')},

        //backend routes
        {path: '/home', component: () => import('./components/Dashboard.vue')},
        {path: '/dashboard', component: () => import('./components/Dashboard.vue')},
        {path: '/profile', component: () => import('./components/Profile.vue')},
        {path: '/users', component: () => import('./views/back/Users.vue')},
        {path: '/cities', component: () => import('./components/Cities.vue')},
        {path: '/countries', component: () => import('./components/Countries.vue')},
        {path: '/products', component: () => import('./components/Products.vue')},
        {path: '/contacts', component: () => import('./components/Contacts.vue')},
        {path: '/abouts', component: () => import('./components/Abouts.vue')},
        {path: '*', component: () => import('./components/NotFound.vue')}
    ]
})