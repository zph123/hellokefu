import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../pages/home/Home.vue'
import Chat from '../pages/chat/Chat.vue'
import Zphadmin from '../pages/zphadmin/Zphadmin.vue'
import Zphachat from '../pages/zphchat/Zphchat.vue'
Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home,
    },
    {
        path: '/chat',
        name: 'Chat',
        component: Chat,
    },
    {
        path: '/zphadmin',
        name: 'Zphadmin',
        component: Zphadmin,
    },
    {
        path: '/zphchat',
        name: 'Zphachat',
        component: Zphachat,
    }

];

const router = new VueRouter({
    routes
});
export default router;