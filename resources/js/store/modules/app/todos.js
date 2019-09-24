import axios from 'axios';

const getDefaultState = () => {
    return {
        todo: []
    }
};

const state = {
    todos: {},
    todo: getDefaultState()
};

const getters = {
    allTodos: state => state.todos,
    oneTodo: state => state.todo
};

const actions = {
    async fetchTodos ({ commit }) {
        const response = await axios.get('api/todo');
        commit('setTodos', response.data)
    },
    async fetchTodo ({ commit }, todo) {
        const response = await axios.get(
            `../api/todo/${todo}`,
            todo
        );
        commit('setTodo', response.data);
    },
    async addTodo ({ commit }, form) {
        const response = await axios.post("api/todo", form);
        commit('add', response.data);
    },
    resetTodoState ({ commit }) {
        commit('resetState')
    }
};

const mutations = {
    setTodos: (state, todos) => (state.todos = todos),
    setTodo: (state, todo) => (state.todo = todo),
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