window.$ = window.jQuery = require('jquery');
window.Laravel = {csrfToken: $('meta[name=csrf-token]').attr("content")};

window.Vue = require('vue');
import Lightbox from 'vue-easy-lightbox';

Vue.use(Lightbox);

window.swal = require('sweetalert2');




import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);

import VueRouter from 'vue-router';

Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';



//axios.defaults.baseURL = '/';
//axios.defaults.baseURL = '/atm/';

/**
 * Dominique DAMBA
 */


Vue.component('contribuable', require('./components/contribuable/Index.vue'));
Vue.component('list-contribuable', require('./components/contribuable/List'));
Vue.component('create-contribuable', require('./components/contribuable/Create.vue'));
Vue.component('detail-contribuable', require('./components/contribuable/Detail.vue'));
Vue.component('update-contribuable', require('./components/contribuable/Update.vue'));


Vue.component('contribuablecat', require('./components/contribuablecat/Index.vue'));
Vue.component('list-contribuablecat', require('./components/contribuablecat/List'));
Vue.component('create-contribuablecat', require('./components/contribuablecat/Create.vue'));
Vue.component('detail-contribuablecat', require('./components/contribuablecat/Detail.vue'));
Vue.component('update-contribuablecat', require('./components/contribuablecat/Update.vue'));


Vue.component('taxe', require('./components/taxe/Index.vue'));
Vue.component('list-taxe', require('./components/taxe/List'));
Vue.component('create-taxe', require('./components/taxe/Create.vue'));
Vue.component('detail-taxe', require('./components/taxe/Detail.vue'));
Vue.component('update-taxe', require('./components/taxe/Update.vue'));


Vue.component('taxecat', require('./components/taxecat/Index.vue'));
Vue.component('list-taxecat', require('./components/taxecat/List'));
Vue.component('create-taxecat', require('./components/taxecat/Create.vue'));
Vue.component('detail-taxecat', require('./components/taxecat/Detail.vue'));
Vue.component('update-taxecat', require('./components/taxecat/Update.vue'));


Vue.component('commune', require('./components/commune/Index.vue'));
Vue.component('list-commune', require('./components/commune/List'));
Vue.component('create-commune', require('./components/commune/Create.vue'));
Vue.component('detail-commune', require('./components/commune/Detail.vue'));
Vue.component('update-commune', require('./components/commune/Update.vue'));


Vue.component('hotel', require('./components/hotel/Index.vue'));
Vue.component('list-hotel', require('./components/hotel/List'));
Vue.component('create-hotel', require('./components/hotel/Create.vue'));
Vue.component('detail-hotel', require('./components/hotel/Detail.vue'));
Vue.component('update-hotel', require('./components/hotel/Update.vue'));



const router = new VueRouter({mode: 'history'});
const app = new Vue(Vue.util.extend({router})).$mount('#app');

