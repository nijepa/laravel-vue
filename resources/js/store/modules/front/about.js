import axios from 'axios';

const state = {
    about: []
};

const getters = {
    allAbout: state => state.about
};

const actions = {
    async fetchAbout ({ commit }) {
        const response = await axios.get('api/about');
        commit('setAbout', response.data)
    }
};

const mutations = {
    setAbout: (state, about) => (state.about = about)
};

export default {
    state,
    getters,
    actions,
    mutations
};