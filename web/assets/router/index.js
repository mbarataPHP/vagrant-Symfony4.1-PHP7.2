import Vue from 'vue'
import Router from 'vue-router'
import Index from '../template/Index.vue';
import Login from '../template/Login.vue';
import Page from '../template/Page.vue';


Vue.use(Router);



export default new Router({
    routes: [
        {
            path: '/',
            name: 'Index',
            component: Index
        },
        {
            path: '/login',
            name: 'Login',
            component: Login
        },
        {
            path: '/page/:id',
            name: 'Page',
            component: Page
        }
    ]
});