import Vue from 'vue'
import VueRouter from 'vue-router'
import * as VueGoogleMaps from 'vue2-google-maps'
Vue.use(VueRouter)
import DateRangePicker from "@gravitano/vue-date-range-picker";
Vue.use(DateRangePicker);
import vuetify from 'vuetify'
Vue.use(vuetify);
import Toasted from 'vue-toasted';
Vue.use(Toasted)
import VuePaginate from 'vue-paginate'
Vue.use(VuePaginate)
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


import App from  './components/App.vue'
import Home from './components/Home.vue'
import  Login from './components/Login.vue'
import Register from './components/Register.vue'
import  jobs from  './components/view-jobs.vue'
import Details from './components/Details.vue'
import Account from './components/Account.vue'
import Profile from  './components/Profile.vue'
import post_job from './components/post-job.vue'
import apply from './components/Apply.vue'

Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyAzumqjvGIRCtXPyw-5GnYVZWdKcwGP5hg',
        libraries: 'places', // This is required if you use the Autocomplete plugin
    },

})


const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
            children:[
                {
                    path: '/view-jobs',
                    name: 'jobs',
                    component: jobs
                },
                {
                    path: '/job-details/:job_id',
                    name: 'job-details',
                    component: Details,
                    props: true
                },
                {
                    path: '/account',
                    name: 'Account',
                    component: Account
                },
                {
                    path: '/profile',
                    name: 'profile',
                    component: Profile
                },
                {
                    path: '/post-job',
                    name: 'post job',
                    component: post_job

                },
                {
                    path: '/apply/:job_id',
                    name: 'apply',
                    component: apply,
                    props: true

                }

            ]
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
        },

    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});