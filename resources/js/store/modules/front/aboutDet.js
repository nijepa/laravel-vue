import axios from 'axios';

const getDefaultState = () => {
    return {
        aboutDet: []
    }
}

const state = {
    aboutDet: getDefaultState()
};

const getters = {
    allAboutDet: state => state.aboutDet
};

const actions = {
    async fetchAboutDet ({ commit }, aboutDet) {
        const response = await axios.get(
            `api/about_dets/`,
            aboutDet
        );
        //console.log(repDet);
        commit('setAboutDet', response.data);
    },
    resetAboutState ({ commit }) {
        commit('resetState')
    }
};

const mutations = {
    setAboutDet: (state, aboutDet) => (state.aboutDet = aboutDet),
    resetState (state) {
        Object.assign(state, getDefaultState())
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};