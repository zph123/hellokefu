
/**
 * 验证邮箱
 *
 * @param email
 * @returns {boolean}
 */
export function checkEmail(email) {
    return /^[a-z]([a-zA-Z0-9_]{5,20})@([a-z0-9]{1,10})([.]{1})([a-z]{2,4})$/.test(email)
}