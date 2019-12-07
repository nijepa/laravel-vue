import axios from 'axios';

const getDefaultState = () => {
    return {
        repDet: []
    }
};

const state = {
    repDet: getDefaultState(),
    repDetDownload: [],
    repDetAbout: [],
    repDetProduct: []
};

const getters = {
    allRepDet: state => state.repDet,
    allRepDetDownload: state => state.repDetDownload,
    allRepDetAbout: state => state.repDetAbout,
    allRepDetProduct: state => state.repDetProduct
};

const actions = {
    async fetchRepDet ({ commit }, repDet) {
        const response = await axios.get(
            `../api/reps_det/${repDet}`,
            repDet
        );
        commit('setRepDet', response.data);
    },
    async fetchRepDetDownload ({ commit }, repDet) {
        const response = await axios.get(
            `../api/infoType/${repDet.repDet}/${repDet.infoType}`,
            repDet
        );
        commit('setRepDetDownload', response.data);
    },
    async fetchRepDetAbout ({ commit }, repDet) {
        const response = await axios.get(
            `../api/infoType/${repDet.repDet}/${repDet.infoType}`,
            repDet
        );
        commit('setRepDetAbout', response.data);
    },
    async fetchRepDetProduct ({ commit }, repDet) {
        const response = await axios.get(
            `../api/infoType/${repDet.repDet}/${repDet.infoType}`,
            repDet
        );
        commit('setRepDetProduct', response.data);
    },
    resetRepState ({ commit }) {
        commit('resetState')
    }
};

const mutations = {
    setRepDet: (state, repDet) => (state.repDet = repDet),
    setRepDetDownload: (state, repDetDownload) => (state.repDetDownload = repDetDownload),
    setRepDetAbout: (state, repDetAbout) => (state.repDetAbout = repDetAbout),
    setRepDetProduct: (state, repDetProduct) => (state.repDetProduct = repDetProduct),
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
