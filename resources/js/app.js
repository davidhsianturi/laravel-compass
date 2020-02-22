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

Vue.component('alert', require('./components/Alert').default);
Vue.component('omnibox', require('./components/Omnibox').default);
Vue.component('site-header', require('./components/SiteHeader').default);
Vue.component('request-tabs', require('./components/RequestTabs').default);
Vue.component('sidebar-menu', require('./components/SidebarMenu').default);
Vue.component('content-space', require('./components/ContentSpace').default);
Vue.component('response-tabs', require('./components/ResponseTabs').default);

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
