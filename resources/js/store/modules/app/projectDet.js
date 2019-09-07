import axios from 'axios';

const getDefaultState = () => {
    return {
        projectDet: []
    }
};

const state = {
    projectDet: getDefaultState()
};

const getters = {
    allProjectDet: state => state.projectDet
};

const actions = {
    async fetchProjectDet ({ commit }, projectDet) {
        const response = await axios.get(
            `../api/project_dets/${projectDet}`,
            projectDet
        );
        commit('setProjectDet', response.data);
    },
    resetProjectState ({ commit }) {
        commit('resetState')
    }
};

const mutations = {
    setProjectDet: (state, projectDet) => (state.projectDet = projectDet),
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