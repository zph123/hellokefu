import axios from 'axios'
import store from '../store'
import { getToken } from './auth'

const instance = axios.create({
    baseURL: 'http://dev.hellokefu.com/api/',
    timeout: 3000,
    headers: {'X-Custom-Header': 'foobar'}
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
    // Do something with response data
    return response;
}, error => {
    // Do something with response error
    return Promise.reject(error);
});


export default instance
