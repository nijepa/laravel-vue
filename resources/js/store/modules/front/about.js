import axios from 'axios';

const state = {
    abouts: []
};

const getters = {
    allAbouts: state => state.abouts
};

const actions = {
    async fetchAboutF ({ commit }) {
        const response = await axios.get('api/aboutF');
        commit('setAbouts', response.data)
    },
    async fetchAbouts ({ commit }) {
        const response = await axios.get('api/about');
        commit('setAbouts', response.data)
    },
    async fetchAboutsP ({ commit }, id) {
        const response = await axios.get(
            `api/about?page=${id}`
        );
        commit('setAbouts', response.data);
    },
    async addAbout ({ commit }, form) {
        const response = await axios.post("api/about", form);
        commit('add', response.data);
    },
    renewAbout ({ commit }, form) {
        axios.put(`api/about/${form.id}`, form)
            .then(response => {
                commit('update', response.data);
                console.log(response.data)
            })
            .catch(err => {
                console.log(err);
            });
    },
    removeAbout ({ commit }, about) {
        axios.delete(`api/about/${about.id}`)
            .then(response => {
                commit('remove', response.data);
                //console.log(user);
            })
            .catch(err => {
                console.log(err)
            });
    }
};

const mutations = {
    setAbouts: (state, abouts) => (state.abouts = abouts),
    remove (state, about) {
        let index = state.abouts.data.findIndex(id => id === about.id);
        state.abouts.data.splice(index, 1);
    },
    add (state, about) {
        state.abouts.data.unshift(about)
    },
    update (state, about) {
        Vue.set(state.abouts, about.index, about)
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};