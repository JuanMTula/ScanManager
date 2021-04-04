
window.$ = window.jQuery = require('jquery');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.Swal  = require('sweetalert2');
window.Vue = require('vue');

require('./rutas.js');
require('./funciones.js');

import Vue from 'vue';
import home from './vue/views/home.vue';

Vue.component('home',home);
const app = new Vue({
    el: '#app',
    component:{
        home
    },
    template: '<div><home></home></div>'
});
