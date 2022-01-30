// alurapic/src/routes.js

import Home from './components/home/Home.vue';
import Login from './components/home/Login.vue';
import Logout from './components/home/Logout.vue';
import CustomerCreateComponent from './components/customer/CustomerCreateComponent.vue';
import CustomerListComponent from './components/customer/CustomerListComponent.vue';
import CustomerEditComponent from './components/customer/CustomerEditComponent.vue';
import OrderCreateComponent from './components/order/OrderCreateComponent.vue';
import OrderEditComponent from './components/order/OrderEditComponent.vue';
import OrderListComponent from './components/order/OrderListComponent.vue';
import OrderSearchComponent from './components/order/OrderSearchComponent.vue';

// import Login from './components/home/Login.vue';
// import Settings from './components/home/Settings.vue';
// import TrilhaList from './components/trilha/TrilhaList.vue';
// import Trilha from './components/trilha/Trilha.vue';
// import ColecaoEstudo from './components/colecao/ColecaoEstudo.vue';
// import ColecaoConsulta from './components/colecao/ColecaoConsulta.vue';
// import QuizzStart from './components/quizz/QuizzStart.vue';
// import QuizzEstudo from './components/quizz/QuizzEstudo.vue';
// import QuizzResultado from './components/quizz/QuizzResultado.vue';
// import Card from './components/card/Card.vue';
// import Favoritos from './components/card/Favoritos.vue';
// import MeusTestes from './components/quizz/MeusTestes.vue';
// import Ranking from './components/ranking/Ranking.vue';
// import MinhaPosicao from './components/ranking/MinhaPosicao.vue';
// import Timeline from './components/timeline/Timeline.vue';

export const routes = [
    /* rotas aqui */
    {path:'/', component: Home, title: "Home", name:'home'},
    {path:'/app', component: Home, title: "Home", name:'home'},
    {path:'/app/login', component: Login, title: "Login", name:'login'},
    {path:'/app/logout', component: Logout, title: "Logout", name:'logout'},
    {path:'/app/order/create',  name:'order-create', component: OrderCreateComponent, title: "OrderCreateComponent"},
    {path:'/app/customer/create',  name:'customer-create', component: CustomerCreateComponent, title: "CustomerCreateComponent"},
    {path:'/app/customer/edit/:id',  name:'customer-edit', component: CustomerEditComponent, title: "CustomerEditComponent", props: true}, /* falta implementar */
    {path:'/app/customer/list',  name:'customer-list', component: CustomerListComponent, title: "CustomerListComponent"},
    {path:'/app/order/list',  name:'order-list', component: OrderListComponent, title: "OrderListComponent"}, /* falta implementar */
    {path:'/app/order/search',  name:'order-search', component: OrderSearchComponent, title: "OrderSearchComponent"}, /* falta implementar */
    {path:'/app/order/edit/:id',  name:'order-edit', component: OrderEditComponent, title: "OrderEditComponent", props: true}, /* falta implementar */
];

/*
      <a href="{{route('estudando',['trilha'=>$trilha->id,'colecao'=>$colecao->id])}}">
                            <button class="btn btn-primary"><i class="fas fa-play"></i> Play</button>
                        </a>
                        <a href="{{route('modoconsulta',['trilha'=>$trilha->id,'colecao'=>$colecao->id])}}">
*/