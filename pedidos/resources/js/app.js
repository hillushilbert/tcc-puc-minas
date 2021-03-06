/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
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

// registrando o módulo/plugin no global view object
Vue.use(VueResource);
Vue.use(VueRouter);
Vue.use(VueSweetalert2);
// Vue.http.headers.common['Access-Control-Allow-Origin'] = true;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */



 const router = new VueRouter({
	routes : routes,
	mode: 'history'
  });

const app = new Vue({
    el: '#app',
    router : router
});
