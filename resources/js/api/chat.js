import request from '../utils/request'

/**
 * 聊天内容
 */
export function chat(params) {
    return request({
        url: '/chat',
        method: 'get',
        params
    })
}