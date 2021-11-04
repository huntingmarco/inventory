

require('./bootstrap');



// vue pagination
Vue.component('pagination', require('./components/PaginationComponent.vue').default);

//window.Vue = require('vue').default;
import Vue from 'vue'
import VueRouter from 'vue-router'
//import Dropdown from 'vue-simple-search-dropdown';
Vue.use(VueRouter)
//Vue.use(Dropdown)

// Vue.component('search-dropdown', require('./components/SearchDropdown.vue').default);



// Import Router
import {routes} from './routes';

// Import User class
import User from './Helpers/User';
window.User = User

// Import Notification class
import Notification from './Helpers/Notification';
window.Notification = Notification

// Import Sweet Alert start
import Swal from 'sweetalert2';
window.Swal = Swal;

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
});

window.Toast = Toast;

// Import Sweet alert end

window.Reload = new Vue();



const router = new VueRouter({
    routes, 
    mode: 'history'
  })

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);



const app = new Vue({
    el: '#app',
    router
});
