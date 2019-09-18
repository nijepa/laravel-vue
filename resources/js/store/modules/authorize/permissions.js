import axios from 'axios';

const state = {
    permissions: {},
    selPermission: {},
    permission: {}
};

const getters = {
    allPermissions: state => state.permissions,
    selPermission: state => state.selPermission
};

const actions = {
    async selPermissions ({ commit }) {
        const response = await axios.get("../api/permissions");
        commit('setPermission', response.data)
    },
    async fetchPermissions ({ commit }) {
        const response = await axios.get("../api/permissions");
        commit('setPermissions', response.data)
    },
};

const mutations = {
    setPermissions: (state, permissions) => (state.permissions = permissions),
    setPermission: (state, selPermission) => (state.selPermission = selPermission),
};

export default {
    state,
    getters,
    actions,
    mutations
};