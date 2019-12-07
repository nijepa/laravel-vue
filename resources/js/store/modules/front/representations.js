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
    firms: []
};

const getters = {
    allReps: state => state.reps,
    allCompanies: state => state.companies,
    allFirms: state => state.firms,
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
    async fetchFirms ({ commit }) {
        const response = await axios.get('../api/allCompanies');
        commit('setFirms', response.data)
    },
    resetRepState ({ commit }) {
        commit('resetState')
    }
};

const mutations = {
    setReps: (state, reps) => (state.reps = reps),
    setRep: (state, rep) => (state.rep = rep),
    setCompanies: (state, companies) => (state.companies = companies),
    setFirms: (state, firms) => (state.firms = firms),
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
