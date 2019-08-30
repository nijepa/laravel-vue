import axios from 'axios';

const getDefaultState = () => {
    return {
        product: []
    }
};

const state = {
    products: {},
    product: getDefaultState()
};

const getters = {
    allProducts: state => state.products,
    oneProduct: state => state.product
};

const actions = {
    async fetchProducts ({ commit }) {
        const response = await axios.get('api/product');
        commit('setProducts', response.data)
    },
    async fetchProduct ({ commit }, product) {
        const response = await axios.get(
            `../api/product/${product}`,
            product
        );
        commit('setProduct', response.data);
    },
    async addProduct ({ commit }, form) {
        const response = await axios.post("api/product", form);
        commit('add', response.data);
    },
    resetProductState ({ commit }) {
        commit('resetState')
    }
};

const mutations = {
    setProducts: (state, products) => (state.products = products),
    setProduct: (state, product) => (state.product = product),
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