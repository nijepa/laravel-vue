import axios from 'axios'

const getDefaultState = () => {
    return {
        rep: []
    }
};

const state = {
    reps: [],
    rep: getDefaultState(),
    companies: [],
};

const getters = {
    allReps: state => state.reps,
    allCompanies: state => state.companies,
    oneRep: state => state.rep
};

const actions = {
    async fetchReps ({ commit }) {
        const response = await axios.get('../api/representation');
        commit('setReps', response.data)
    },
    async fetchRep ({ commit }, rep) {
        const response = await axios.get(
            `../api/representation/${rep}`,
            rep
        );
        commit('setRep', response.data);
    },
    async fetchCompanies ({ commit }) {
        const response = await axios.get('../api/companies');
        commit('setCompanies', response.data)
    },
    resetRepState ({ commit }) {
        commit('resetState')
    }
};

const mutations = {
    setReps: (state, reps) => (state.reps = reps),
    setRep: (state, rep) => (state.rep = rep),
    setCompanies: (state, companies) => (state.companies = companies),
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