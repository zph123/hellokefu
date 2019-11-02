
/**
 * Token key
 * @type {string}
 */
const tokenKey = 'hello_token'

export function getToken() {
    return window.localStorage.getItem(tokenKey)
}

export function setToken(token) {
    return window.localStorage.setItem(tokenKey,token)
}

export function destroyToken() {
    return window.localStorage.removeItem(tokenKey)
}

/**
 * visitor uuid
 * @type {string}
 */
const visitorUid = 'hello_visitor_uuid'

/**
 * Get or set visitor uuid
 * @param uuid
 */
export function visitor(uuid = '') {
    if (uuid){
        return window.localStorage.setItem(visitorUid,uuid)
    }else{
        return window.localStorage.getItem(visitorUid) || ''
    }
}