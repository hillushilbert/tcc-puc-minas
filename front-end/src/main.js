import Vue from 'vue'
import App from './App.vue'
// bootstrap
import { BootstrapVue, IconsPlugin, DropdownPlugin, TablePlugin } from 'bootstrap-vue'

window.moment = require('moment');

import VueSweetalert2 from 'vue-sweetalert2';
// importando o módulo
import VueResource from 'vue-resource';
// importando o router!
import VueRouter from 'vue-router';

// tem que vir entre chaves, porque não é default
import { routes } from './routes';

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';

// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// registrando o módulo/plugin no global view object
Vue.use(VueResource);
Vue.use(VueRouter);
Vue.use(VueSweetalert2);


// import './app.scss'

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)
Vue.use(DropdownPlugin)
Vue.use(TablePlugin)

// http usará sempre o endereço abaixo
Vue.http.options.root = 'http://185.187.169.252:8000';

const router = new VueRouter({
  routes : routes,
  mode: 'history'
});

new Vue({
  el: '#app',
  render: h => h(App),
  router : router
})
