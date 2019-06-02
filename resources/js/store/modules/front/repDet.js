import axios from 'axios';

const getDefaultState = () => {
    return {
        repDet: []
    }
}

const state = {
    repDet: getDefaultState()
};

const getters = {
    allRepDet: state => state.repDet
};

const actions = {
    async fetchRepDet ({ commit }, repDet) {
        const response = await axios.get(
            `api/reps_det?id=${repDet.id}`,
            repDet
        );
        //console.log(response.data);
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
    //   const index = state.reps.findIndex(rep => reps.id === rep.id);
    //   if (index !== -1) {
    //     state.reps.splice(index, 1, rep);
    //   }
    // }
};

export default {
    state,
    getters,
    actions,
    mutations
};