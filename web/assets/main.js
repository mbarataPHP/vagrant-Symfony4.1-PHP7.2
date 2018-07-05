import Vue from 'vue'
import App from './App.vue'
import router from './router'
import VueResource from 'vue-resource'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import VueSession from 'vue-session'


Vue.config.productionTip = false;

Vue.use(BootstrapVue);
Vue.use(VueResource);
Vue.use(VueSession);

Vue.http.options.emulateJSON = true;
Vue.http.options.emulateHTTP = true;

/* eslint-disable no-new */
new Vue({
    el: '#app',
    router,
    template: '<App/>',
    components: { App }
});