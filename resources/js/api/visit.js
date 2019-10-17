import request from '../utils/request'

/**
 * 访客列表
 */
export function indexVisit(params) {
    return request({
        url: '/visitor',
        method: 'get',
        params
    })
}