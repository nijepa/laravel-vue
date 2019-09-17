import Vue from 'vue'
import Vuex from 'vuex'
import representations from './modules/front/representations';
import products from './modules/front/products';
import productDet from './modules/front/productDet';
import abouts from './modules/front/about';
import aboutDet from './modules/front/aboutDet';
import contacts from './modules/front/contacts';
import owner from './modules/front/owner';
import repDet from './modules/front/repDet';
import news from './modules/front/news';
import countries from './modules/countries';
import cities from './modules/cities';
import users from './modules/users';
import projects from './modules/app/projects';
import projectDet from './modules/app/projectDet';
import meetings from './modules/app/meetings';
import meetingDet from './modules/app/meetingDet';

/**
 * Load vuex store and add modules
 */
Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        representations,
        products,
        productDet,
        abouts,
        aboutDet,
        contacts,
        owner,
        repDet,
        news,
        cities,
        countries,
        users,
        projects,
        projectDet,
        meetings,
        meetingDet
    }
})
