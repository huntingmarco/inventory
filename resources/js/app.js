

require('./bootstrap');

//window.Vue = require('vue').default;
import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

// Import Router
import {routes} from './routes';


const router = new VueRouter({
    routes, 
    mode: 'history'
  })

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);



const app = new Vue({
    el: '#app',
    router
});
