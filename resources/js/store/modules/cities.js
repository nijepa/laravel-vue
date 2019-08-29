import axios from 'axios';

const state = {
    cities: {},
    city: {}
};

const getters = {
    allCities: state => state.cities
};

const actions = {
    async fetchCities ({ commit }) {
        const response = await axios.get(`../api/city`);
        commit('setCities', response.data)
    },
    async fetchCitiesP ({ commit }, id) {
        const response = await axios.get(
            `api/city?page=${id}`
        );
        commit('setCities', response.data);
    },
    async fetchCitiesS ({ commit }, query) {
        const response = await axios.get(
            `api/findCity?q=${query}`
        );
        commit('setCities', response.data);
    },
    async addCity ({ commit }, form) {
        const response = await axios.post("api/city", form);
        commit('add', response.data);
    },
    renewCity ({ commit }, form) {
        axios.put(`api/city/${form.id}`, form)
            .then(response => {
                commit('update', response.data);
                console.log(response.data)
            })
            .catch(err => {
                console.log(err);
            });
    },
    removeCity ({ commit }, city) {
        axios.delete(`api/city/${city.id}`)
            .then(response => {
                commit('remove', response.data);
                console.log(user);
            })
            .catch(err => {
                console.log(err)
            });
    }
};

const mutations = {
    setCities: (state, cities) => (state.cities = cities),
    remove (state, city) {
        let index = state.cities.data.findIndex(id => id === city.id);
        state.cities.data.splice(index, 1);
    },
    add (state, city) {
        state.cities.data.unshift(city)
    },
    update (state, city) {
        Vue.set(state.cities, city.index, city)
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};