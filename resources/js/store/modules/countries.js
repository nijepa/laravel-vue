import axios from 'axios';

const state = {
    countries: {},
    selCountry: {},
    country: {}
};

const getters = {
    allCountries: state => state.countries,
    selectedCountries: state => state.selCountry
};

const actions = {
    async selCountries ({ commit }) {
        const response = await axios.get("api/countries");
        commit('setCountry', response.data)
    },
    async fetchCountries ({ commit }) {
        const response = await axios.get("api/country");
        commit('setCountries', response.data)
    },
    async fetchCountriesP ({ commit }, id) {
        const response = await axios.get(
            `api/country?page=${id}`
        );
        commit('setCountries', response.data);
    },
    async fetchCountriesS ({ commit }, query) {
        const response = await axios.get(
            `api/findCountry?q=${query}`
        );
        commit('setCountries', response.data);
    },
    async addCountry ({ commit }, form) {
        const response = await axios.post("api/country", form);
        commit('add', response.data);
    },
    renewCountry ({ commit }, form) {
        axios.put(`api/country/${form.id}`, form)
            .then(response => {
                commit('update', response.data);
                console.log(response.data)
            })
            .catch(err => {
                console.log(err);
            });
    },
    removeCountry ({ commit }, country) {
        axios.delete(`api/country/${country.id}`)
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
    setCountries: (state, countries) => (state.countries = countries),
    setCountry: (state, selCountry) => (state.selCountry = selCountry),
    remove (state, country) {
        let index = state.countries.data.findIndex(id => id === country.id);
        state.countries.data.splice(index, 1);
    },
    add (state, country) {
        state.countries.data.unshift(country)
    },
    update (state, country) {
        Vue.set(state.countries, country.index, country)
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};