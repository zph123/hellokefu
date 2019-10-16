import Vue from 'vue'
import VueRouter from 'vue-router'
import Chat from '../pages/chat/chat.vue'
import Layout from '../layout/index.vue'
import Login from '../pages/login/index.vue'

Vue.use(VueRouter);

const routes = [
    {
        path: '/login',
        name: 'Login',
        component: Login,
        meta: { title: '登录', icon: '' }
    },
    {
        path: '/chat',
        name: 'Chat',
        component: Chat,
        meta: { title: '咨询', icon: '' }
    },
    {
        path: '/',
        name: 'home',
        redirect: {name: 'conversation'},
        component: Layout,
        children: [{
            path: 'panel',
            name: 'panel',
            meta: { title: '面板', icon: '' },
            // component: () => import('../pages/home/Home.vue')
            component: Vue.component('panel', require('../pages/home/home.vue').default),
        },{
            path: 'conversation',
            name: 'conversation',
            meta: { title: '会话', icon: '' },
            component: Vue.component('conversation', require('../pages/conversation/conversation.vue').default),
        },{

            path: 'visit',
            name: 'visit',
            meta: { title: '访客', icon: '' },
            component: Vue.component('visit', require('../pages/visit/index.vue').default),

        }]
    },
    {
        path: '/404',
        component: Vue.component('notFound', require('../pages/404.vue').default)
    },
    // 404 page must be placed at the end !!!
    { path: '*', redirect: '/404', hidden: true }

];

const router = new VueRouter({
    routes
});
export default router;