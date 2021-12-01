// alurapic/src/routes.js

import Home from './components/home/Home.vue';
import Login from './components/home/Login.vue';
import OrderCreateComponent from './components/order/OrderCreateComponent.vue';
import OrderEditComponent from './components/order/OrderEditComponent.vue';
import OrderListComponent from './components/order/OrderListComponent.vue';
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
    {path:'/app', component: Home, title: "Home"},
    {path:'/app/login', component: Login, title: "Login"},
    {path:'/app/order/create',  name:'order-create', component: OrderCreateComponent, title: "OrderCreateComponent"},
    {path:'/app/order/list',  name:'order-list', component: OrderListComponent, title: "OrderListComponent"}, /* falta implementar */
    {path:'/app/order/edit/:id',  name:'order-edit', component: OrderEditComponent, title: "OrderEditComponent", props: true}, /* falta implementar */
    // {path:'/app/trilhas', name:'trilhas', component: TrilhaList, title: "Trilhas", props: true}, /* ok */
    // {path:'/app/trilha/:id', name:'trilha', component: Trilha, title: "Trilha", props: true}, /* ok */
    // {path:'/app/colecao/estudo/:id', name:'colecao_estudo', component: ColecaoEstudo, title: "Coleção Estudo", props: true}, /* ok */
    // {path:'/app/colecao/consulta/:id', name:'colecao_consulta', component: ColecaoConsulta, title: "Coleção Consulta", props: true}, /* ok */
    // {path:'/app/quizz/:id', name:'quizz', component: QuizzStart, title: "Quizz Consulta", props: true},
    // {path:'/app/quizz/estudo/:id', name:'quizz_estudo', component: QuizzEstudo, title: "Quizz Estudo", props: true},
    // {path:'/app/quizz/resultado/:id', name:'quizz_resultado', component: QuizzResultado, title: "Quizz Resultado", props: true},
    // {path:'/app/card', component: Card, title: "FixCards"},
    // {path:'/app/favoritos', name:"favoritos", component: Favoritos, title: "Meus Favoritos"},
    // {path:'/app/testes', component: MeusTestes, title: "Meus Testes"} ,
    // {path:'/app/ranking', component: Ranking, title: "Avaliações"} ,
    // {path:'/app/ranking/:id', name:'ranking_colecao', component: Ranking, title: "Avaliações por Coleção",  props: true} ,
    // //{path:'/app/ranking/:id', name:'ranking_colecao', component: QuizzStart, title: "Avaliações por Coleção",  props: true} ,
    // {path:'/app/settings', name:"settings", component: Settings, title: "Settings"},
    // {path:'/app/me/ranking', name:"minhaposicao", component: MinhaPosicao, title: "Meu Ranking"},
    // {path:'/app/timeline', name:"timeline", component: Timeline, title: "timeline"}
];

/*
      <a href="{{route('estudando',['trilha'=>$trilha->id,'colecao'=>$colecao->id])}}">
                            <button class="btn btn-primary"><i class="fas fa-play"></i> Play</button>
                        </a>
                        <a href="{{route('modoconsulta',['trilha'=>$trilha->id,'colecao'=>$colecao->id])}}">
*/