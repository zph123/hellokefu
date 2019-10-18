import router from '../router'
import store from '../store'
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'
import { getToken,destroyToken } from './auth'
import { profile } from '../api/auth'


const noNeedLogin = ['/login','/chat','/register']

router.beforeEach(async(to, from, next) => {

    NProgress.start();

    // set page title
    document.title = to.meta.title

    // determine whether the user has logged in
    const hasToken = getToken()

    if (hasToken) {
        if (to.path === '/login') {
            // if is logged in, redirect to the home page
            next({ path: '/' })
        } else {
            const hasUser = store.getters.name
            if (hasUser) {
                next()
            } else {
                try {
                    // get user profile
                    // await store.dispatch('profile')
                    next()
                } catch (error) {
                    // remove token and go to login page to re-login
                    // await store.dispatch('resetToken')
                    // Message.error(error || 'Has Error')
                    // next(`/login?redirect=${to.path}`)
                }
            }
        }
    } else {
        /* has no token*/

        if (noNeedLogin.indexOf(to.path) !== -1) {
            // in the free login whitelist, go directly
            next()
        } else {
            // other pages that do not have permission to access are redirected to the login page.
            next(`/login?redirect=${to.path}`)
        }
    }
})

router.afterEach(() => {
    // finish progress bar
    NProgress.done()
})
