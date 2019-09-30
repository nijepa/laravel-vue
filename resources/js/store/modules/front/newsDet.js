import axios from 'axios';

const getDefaultState = () => {
    return {
        newsDet: []
    }
};

const state = {
    newsDet: getDefaultState()
};

const getters = {
    allNewsDet: state => state.newsDet
};

const actions = {
    async fetchNewsDet ({ commit }, newsDet) {
        const response = await axios.get(
            `../api/news_dets/${newsDet}`,
            newsDet
        );
        commit('setNewsDet', response.data);
    },
    resetNewsState ({ commit }) {
        commit('resetState')
    }
};

const mutations = {
    setNewsDet: (state, newsDet) => (state.newsDet = newsDet),
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