import axios from 'axios';

const getDefaultState = () => {
    return {
        repDet: []
    }
};

const state = {
    repDet: getDefaultState()
};

const getters = {
    allRepDet: state => state.repDet
};

const actions = {
    async fetchRepDet ({ commit }, repDet) {
        const response = await axios.get(
            `../api/reps_det/${repDet}`,
            repDet
        );
        commit('setRepDet', response.data);
    },
    resetRepState ({ commit }) {
        commit('resetState')
    }
};

const mutations = {
    setRepDet: (state, repDet) => (state.repDet = repDet),
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