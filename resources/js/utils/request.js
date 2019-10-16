import axios from 'axios'
import store from '../store'
import router from '../router'
import { getToken, destroyToken } from './auth'
import { MessageBox, Message } from 'element-ui'

const instance = axios.create({
    baseURL: 'http://dev.hellokefu.com/api/',
    timeout: 3000,
});

// Add a request interceptor
instance.interceptors.request.use(config => {
    // Do something before request is sent
    if (store.getters.token) {
        config.headers['Authorization'] = 'Bearer ' + getToken()
    }
    return config;
}, error => {
    // Do something with request error
    return Promise.reject(error);
});

// Add a response interceptor
instance.interceptors.response.use(response => {

    const data = response.data
    console.log('response',response)
    return data;
}, error => {
    // Do something with response error
    Message({
        message: error.message,
        type: 'error',
        duration: 5 * 1000
    })
    destroyToken()
    router.push({ name: 'Login'})
    return Promise.reject(error);
});


export default instance
