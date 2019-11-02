import request from '../utils/request'


/**
 * 客服端聊天记录
 *
 * @param params
 * @returns {*}
 */
export function messages(params) {
    return request({
        'url': '/service/messages',
        'method': 'get',
        params
    })
}
