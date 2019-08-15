import axios from 'axios';

const getDefaultState = () => {
    return {
        productDet: []
    }
}

const state = {
    productDet: getDefaultState()
};

const getters = {
    allProductDet: state => state.productDet
};

const actions = {
    async fetchProductDet ({ commit }, productDet) {
        const response = await axios.get(
            `api/product_dets/${productDet.id}`,
            productDet
        );
        commit('setProductDet', response.data);
    },
    resetProductState ({ commit }) {
        commit('resetState')
    }
};

const mutations = {
    setProductDet: (state, productDet) => (state.productDet = productDet),
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