import Vue from 'vue'
import VueRouter from 'vue-router'
import VueGoogleAutocomplete from 'vue-google-autocomplete'
Vue.use(VueRouter)
window.axios = require('axios');
import DateRangePicker from "@gravitano/vue-date-range-picker";
Vue.use(DateRangePicker);
import App from  './components/App.vue'
import Home from './components/Home.vue'
import  Login from './components/Login.vue'
import Register from './components/Register.vue'
import  jobs from  './components/view-jobs.vue'
import Details from './components/Details.vue'
import Account from './components/Account.vue'
import Profile from  './components/Profile.vue'
import post_job from './components/post-job.vue'

Vue.use(VueGoogleAutocomplete, {
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
                    path: '/job-details',
                    name: 'Details',
                    component: Details
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