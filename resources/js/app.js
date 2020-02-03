import Vue from 'vue';
import Base from './base';
import Routes from './routes';
import VueRouter from 'vue-router';
import axios from './axios-instance';

Vue.prototype.http = axios;
Vue.use(VueRouter);

const router = new VueRouter({
    routes: Routes,
    mode: 'history',
    base: '/' + Compass.path,
});

Vue.component('site-header', require('./components/SiteHeader').default);
Vue.component('sidebar-menu', require('./components/SidebarMenu').default);
Vue.component('alert', require('./components/Alert').default);

Vue.mixin(Base);

new Vue({
    el: '#compass',

    router,

    data() {
        return {
            requestTitle: null,
            requestIsExample: false,
            alert: {
                mode: null,
                type: null,
                message: '',
                autoClose: 0,
            },
        };
    },
});
