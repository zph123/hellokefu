import Vue from 'vue';
import Vuex from 'vuex';
import { getToken,destroyToken } from '../utils/auth'
import { profile } from "../api/auth"

Vue.use(Vuex);

const state = {
    token: getToken(),
    name: "",
    avatar: ""
};

const getters = {   // 实时监听state值的变化(最新状态)
    token() {
        return state.token;
    },
    // avatar: state => state.user.avatar,
};

const mutations = {
    SET_TOKEN: (state, token) => {
        state.token = token
    },
    SET_NAME: (state, name) => {
        console.log('----')
        console.log(name)
        console.log('====')
        state.name = name
    },
    SET_AVATAR: (state, avatar) => {
        state.avatar = avatar
    }
};

const actions = {

    // get user profile
    profile({ commit, state }) {
        return new Promise((resolve, reject) => {
            console.log(state.token)
            profile().then(response => {
                const { data } = response
                if (!data) {
                    reject('Verification failed, please Login again.')
                }
                const { name, avatar } = data
                console.log(data)
                console.log(data.name)
                commit('SET_NAME', name)
                commit('SET_AVATAR', avatar)
                resolve(data)
            }).catch(error => {
                reject(error)
            })
        })
    },

    // destroy token
    resetToken({ commit }) {
        return new Promise(resolve => {
            commit('SET_TOKEN', null)
            destroyToken()
            resolve()
        })
    }
}

const store = new Vuex.Store({
    state,
    getters,
    mutations,
    actions
});

export default store;