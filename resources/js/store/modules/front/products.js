import axios from 'axios';

const state = {
    products: {},
    product: {}
};

const getters = {
    allProducts: state => state.products,
    oneProduct: state => state.product
};

const actions = {
    async fetchProductsF ({ commit }) {
        const response = await axios.get('api/productF');
        commit('setProducts', response.data)
    },
    async fetchProducts ({ commit }) {
        const response = await axios.get('api/product');
        commit('setProducts', response.data)
    },
    async fetchProductsP ({ commit }, id) {
        const response = await axios.get(
            `api/product?page=${id}`
        );
        commit('setProducts', response.data);
    },
    async fetchProductsS ({ commit }, query) {
        const response = await axios.get(
            `api/findProduct?q=${query}`
        );
        commit('setProducts', response.data);
    },
    async fetchProduct ({ commit }, product) {
        const response = await axios.get(
            `api/product/${product.id}`,
            product.id
        );
        //console.log(rep);
        commit('setProduct', response.data);
    },
    async addProduct ({ commit }, form) {
        const response = await axios.post("api/product", form);
        commit('add', response.data);
    },
    renewProduct ({ commit }, form) {
        axios.put(`api/product/${form.id}`, form)
            .then(response => {
                commit('update', response.data);
                console.log(response.data)
            })
            .catch(err => {
                console.log(err);
            });
    },
    removeProduct ({ commit }, city) {
        axios.delete(`api/product/${city.id}`)
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
    setProducts: (state, products) => (state.products = products),
    setProduct: (state, product) => (state.product = product),
    remove (state, product) {
        let index = state.products.data.findIndex(id => id === product.id);
        state.products.data.splice(index, 1);
    },
    add (state, product) {
        state.products.data.unshift(product)
    },
    update (state, product) {
        Vue.set(state.products, product.index, product)
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};