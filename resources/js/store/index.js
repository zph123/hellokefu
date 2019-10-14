import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const state = {
    name: ""
};

const getters = {   // 实时监听state值的变化(最新状态)
    isLogined() {
        return state.name !== "";
    },
};

const mutations = {
    setUsername(state, username) {
        state.name = username;
    }
};

const store = new Vuex.Store({
    state,
    getters,
    mutations
});

export default store;