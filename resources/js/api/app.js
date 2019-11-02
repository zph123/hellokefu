import request from '../utils/request'

/**
 * 应用信息
 * @returns {*}
 */
export function appInfo() {
    return request({
        url: '/application',
        method: 'get'
    })
}