import Vue from 'vue'
import Vuex from 'vuex'
import representations from './modules/front/representations';
import products from './modules/front/products';
import about from './modules/front/about';
import contacts from './modules/front/contacts';
import owner from './modules/front/owner';
import repDet from './modules/front/repDet';
import news from './modules/front/news';
import countries from './modules/countries';
import cities from './modules/cities';
import users from './modules/users';

/**
 * Load vuex store and add modules
 */
Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        representations,
        products,
        about,
        contacts,
        owner,
        repDet,
        news,
        cities,
        countries,
        users
    }
})
