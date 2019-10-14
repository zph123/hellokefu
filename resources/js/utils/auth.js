
/**
 * Token key
 * @type {string}
 */
const TokenKey = 'hello_token'

export function getToken() {
    return window.localStorage.getItem(TokenKey)
}

export function setToken(token) {
    return window.localStorage.setItem(TokenKey,token)
}

export function destroyToken() {
    return window.localStorage.removeItem(TokenKey)
}
