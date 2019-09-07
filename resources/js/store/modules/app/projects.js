import axios from 'axios';

const getDefaultState = () => {
    return {
        project: []
    }
};

const state = {
    projects: {},
    project: getDefaultState()
};

const getters = {
    allProjects: state => state.projects,
    oneProject: state => state.project
};

const actions = {
    async fetchProjects ({ commit }) {
        const response = await axios.get('api/project');
        commit('setProjects', response.data)
    },
    async fetchProject ({ commit }, project) {
        const response = await axios.get(
            `../api/project/${project}`,
            project
        );
        commit('setProject', response.data);
    },
    async addProject ({ commit }, form) {
        const response = await axios.post("api/project", form);
        commit('add', response.data);
    },
    resetProjectState ({ commit }) {
        commit('resetState')
    }
};

const mutations = {
    setProjects: (state, projects) => (state.projects = projects),
    setProject: (state, project) => (state.project = project),
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