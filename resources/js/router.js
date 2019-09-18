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

        // FRONTEND ROUTES
        {path: '/', component: () => import('./views/front/Home.vue')},
        // {path: '/', component: require('./views/front/Home.vue').default},
        {path: '/representations', component: () => import('./views/front/Representations.vue')},
        {path: '/about', component: () => import('./views/front/About.vue')},
        {path: '/contact', component: () => import('./views/front/Contact.vue')},
        {path: '/product', component: () => import('./views/front/Product.vue')},
        {path: '/news', component: () => import('./views/front/News.vue')},
        {path: '/production', component: () => import('./views/front/Production.vue')},
        {path: '/exports', component: () => import('./views/front/Exports.vue')},


        // BACKEND ROUTES
        // Home, profile, about routes
        {path: '/home', component: () => import('./components/Dashboard.vue')},
        {path: '/dashboard', component: () => import('./components/Dashboard.vue')},
        {path: '/profile', component: () => import('./components/back/Profile.vue')},
        {path: '/abouts', component: () => import('./components/back/Abouts.vue')},
        {path: '*', component: () => import('./components/NotFound.vue')},

        // Lists routes
        {path: '/cities', component: () => import('./components/back/Cities.vue')},
        {path: '/countries', component: () => import('./components/back/Countries.vue')},
        {path: '/contacts', component: () => import('./components/back/Contacts.vue')},

        // Products routes
        {path: '/products', component: () => import('./components/back/Products.vue')},
        {name: 'prod', path: '/productDets/:id', component: () => import('./components/back/ProductDets.vue'), props: true},

        // News routes
        {path: '/newsb', component: () => import('./components/back/News.vue')},

        // Representations routes
        {path: '/reps', component: () => import('./components/back/Reps.vue')},
        //{path: '/repDets', component: () => import('./components/back/RepDets.vue')},
        {name: 'repd', path: '/repDets/:id', component: () => import('./components/back/RepDets.vue'), props: true},


        //WEB APP ROUTES
        // Users management routes
        {path: '/users', component: () => import('./views/back/Users.vue')},
        {path: '/roles', component: () => import('./components/authorization/Roles.vue')},
        {path: '/permissions', component: () => import('./components/authorization/Permissions.vue')},

        // Lists routes
        {path: '/companies', component: () => import('./components/back/Companies.vue'), props: true},

        // Project routes
        {path: '/projects', component: () => import('./components/app/Projects.vue')},
        {name: 'proj', path: '/projectDets/:id', component: () => import('./components/app/ProjectDets.vue'), props: true},

        // Meetings routes
        {path: '/meetings', component: () => import('./components/app/Meetings.vue')},
        {name: 'meet', path: '/meetingDets/:id', component: () => import('./components/app/MeetingDets.vue'), props: true},
    ]
})