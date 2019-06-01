import axios from 'axios';

const state = {
    owner: []
};

const getters = {
    allOwner: state => state.owner
};

const actions = {
    async fetchOwner ({ commit }) {
        const response = await axios.get('api/owner');
        commit('setOwner', response.data)
    }
};

const mutations = {
    setOwner: (state, owner) => (state.owner = owner)
};

export default {
    state,
    getters,
    actions,
    mutations
};