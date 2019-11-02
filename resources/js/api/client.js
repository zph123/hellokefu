import request from '../utils/request'

/**
 * 访客咨询
 *
 * @param data
 * @returns {*}
 */
export function chat(data) {
    return request({
        url: '/visit',
        method: 'post',
        data
    })
}

/**
 * 访客聊天内容
 *
 * @param params
 * @returns {*}
 */
export function message(params) {
    return request({
        url: '/visitor/messages',
        method: 'get',
        params
    })
}