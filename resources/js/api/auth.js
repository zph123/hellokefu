import request from '../utils/request'

/**
 * 客服登录
 * @param data
 */
export function login(data) {
    return request({
        url: '/login',
        method: 'post',
        data
    })
}

/**
 * 客服信息
 */
export function profile() {
    return request({
        url: '/profile',
        method: 'get'
    })
}

/**
 * 客服退出
 */
export function logout() {
    return request({
        url: '/logout',
        method: 'delete'
    })
}
