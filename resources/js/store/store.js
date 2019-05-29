import Vue from 'vue'
import Vuex from 'vuex'
/*import representations from './modules/representations';
import products from './modules/products';
import about from './modules/about';
import contacts from './modules/contacts';
import owner from './modules/owner';
import repDet from './modules/repDet';
import news from './modules/news';*/
import countries from './modules/countries';
import cities from './modules/cities';
import users from './modules/users';

/**
 * Load vuex store and add modules
 */
Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
/*        representations,
        products,
        about,
        contacts,
        owner,
        repDet,
        news,*/
        cities,
        countries,
        users
    }
})
