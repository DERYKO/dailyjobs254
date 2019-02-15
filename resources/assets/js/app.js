import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
import App from  './components/App'
import Home from './components/Home'
import  Login from './components/Login'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});