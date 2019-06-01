import axios from 'axios';

const getDefaultState = () => {
    return {
        newsD: []
    }
}

const state = {
    news: [],
    newsD: getDefaultState()
};

const getters = {
    allNews: state => state.news,
    oneNews: state => state.newsD
};

const actions = {
    async fetchNews ({ commit }) {
        const response = await axios.get('http://localhost/don/donau/public/backend/api/news/read.php');
        commit('setNews', response.data.data)
    },
    async fetchNewsD ({ commit }, newsD) {
        const response = await axios.get(
            `http://localhost/don/donau/public/backend/api/news/read_single.php/?id=${newsD.id}`,
            newsD
        );
        commit('setNewsD', response.data);
    },
    resetNewsState ({ commit }) {
        commit('resetState')
    }
};

const mutations = {
    setNews: (state, news) => (state.news = news),
    setNewsD: (state, newsD) => (state.newsD = newsD),
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