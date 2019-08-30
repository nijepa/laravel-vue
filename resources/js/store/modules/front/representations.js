import axios from 'axios'

const getDefaultState = () => {
    return {
        rep: []
    }
};

const state = {
    reps: [],
    rep: getDefaultState()
};

const getters = {
    allReps: state => state.reps,
    oneRep: state => state.rep
};

const actions = {
    async fetchReps ({ commit }) {
        const response = await axios.get('api/representation');
        commit('setReps', response.data)
    },
    async fetchRep ({ commit }, rep) {
        const response = await axios.get(
            `../api/representation/${rep}`,
            rep
        );
        //console.log(rep);
        commit('setRep', response.data);
    },
    resetRepState ({ commit }) {
        commit('resetState')
    }
};

const mutations = {
    setReps: (state, reps) => (state.reps = reps),
    setRep: (state, rep) => (state.rep = rep),
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