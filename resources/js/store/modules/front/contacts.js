import axios from 'axios';

const state = {
    contacts: {}
};

const getters = {
    allContacts: state => state.contacts
};

const actions = {
    async fetchContactsF ({ commit }) {
        const response = await axios.get('api/contactF');
        commit('setContacts', response.data)
    },
    async fetchContacts ({ commit }) {
        const response = await axios.get('api/contact');
        console.log(response.data);
        commit('setContacts', response.data)
    },
    async fetchContactsP ({ commit }, id) {
        const response = await axios.get(
            `api/contact?page=${id}`
        );
        commit('setContacts', response.data);
    },
};

const mutations = {
    setContacts: (state, contacts) => (state.contacts = contacts)
};

export default {
    state,
    getters,
    actions,
    mutations
};