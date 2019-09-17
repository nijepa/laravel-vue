import axios from 'axios';

const getDefaultState = () => {
    return {
        meeting: []
    }
};

const state = {
    meetings: {},
    meeting: getDefaultState()
};

const getters = {
    allMeetings: state => state.meetings,
    oneMeeting: state => state.meeting
};

const actions = {
    async fetchMeetings ({ commit }) {
        const response = await axios.get('api/meeting');
        commit('setMeetings', response.data)
    },
    async fetchMeeting ({ commit }, meeting) {
        const response = await axios.get(
            `../api/meeting/${meeting}`,
            meeting
        );
        commit('setMeeting', response.data);
    },
    async addMeeting ({ commit }, form) {
        const response = await axios.post("api/meeting", form);
        commit('add', response.data);
    },
    resetMeetingState ({ commit }) {
        commit('resetState')
    }
};

const mutations = {
    setMeetings: (state, meetings) => (state.meetings = meetings),
    setMeeting: (state, meeting) => (state.meeting = meeting),
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