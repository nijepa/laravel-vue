import axios from 'axios';

const state = {
    roles: {},
    selRole: {},
    role: {}
};

const getters = {
    allRoles: state => state.roles,
    selRole: state => state.selRole
};

const actions = {
    async selRoles ({ commit }) {
        const response = await axios.get("../api/roles");
        commit('setRole', response.data)
    },
    async fetchRoles ({ commit }) {
        const response = await axios.get("../api/roles");
        commit('setRoles', response.data)
    },
};

const mutations = {
    setRoles: (state, roles) => (state.roles = roles),
    setRole: (state, selRole) => (state.selRole = selRole),
};

export default {
    state,
    getters,
    actions,
    mutations
};