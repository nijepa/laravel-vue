import axios from 'axios';

const state = {
    users: {},
    user: {}
};

const getters = {
    allUsers: state => state.users
};

const actions = {
    async fetchUsers ({ commit }) {
        const response = await axios.get("api/user");
        commit('setUsers', response.data)
    },
    async fetchUsersP ({ commit }, id) {
        const response = await axios.get(
            `api/user?page=${id}`
        );
        commit('setUsers', response.data);
    },
    async fetchUsersS ({ commit }, query) {
        const response = await axios.get(
            `api/findUser?q=${query}`
        );
        commit('setUsers', response.data);
    },
    async addUser ({ commit }, form) {
        const response = await axios.post("api/user", form);
        commit('add', response.data);
    },
    renewUser ({ commit }, form) {
        axios.put(`api/user/${form.id}`, form)
            .then(response => {
                commit('update', response.data);
                console.log(response.data)
            })
            .catch(err => {
                console.log(err);
            });
    },
    removeUser ({ commit }, user) {
        axios.delete(`api/user/${user.id}`)
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
    setUsers: (state, users) => (state.users = users),
    remove (state, user) {
        let index = state.users.data.findIndex(id => id === user.id);
        state.users.data.splice(index, 1);
    },
    add (state, user) {
        state.users.data.unshift(user)
    },
    update (state, user) {
        Vue.set(state.users, user.index, user)
        //state.user = user
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};