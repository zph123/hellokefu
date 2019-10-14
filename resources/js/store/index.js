import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const state = {
    token: null,
    name: "",
    avatar: ""
};

const getters = {   // 实时监听state值的变化(最新状态)
    isLogined() {
        return state.token !== null;
    },
    token() {
        return state.token;
    },
    // avatar: state => state.user.avatar,
};

const mutations = {
    setToken(state, token) {
        state.token = token;
    },
    setName(state, name) {
        state.name = name;
    }
};

const store = new Vuex.Store({
    state,
    getters,
    mutations
});

export default store;