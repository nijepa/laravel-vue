import axios from 'axios';

const getDefaultState = () => {
    return {
        meetingDet: []
    }
};

const state = {
    meetingDet: getDefaultState()
};

const getters = {
    allMeetingDet: state => state.meetingDet
};

const actions = {
    async fetchMeetingDet ({ commit }, meetingDet) {
        const response = await axios.get(
            `../api/meeting_dets/${meetingDet}`,
            meetingDet
        );
        commit('setMeetingDet', response.data);
    },
    resetMeetingState ({ commit }) {
        commit('resetState')
    }
};

const mutations = {
    setMeetingDet: (state, meetingDet) => (state.meetingDet = meetingDet),
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