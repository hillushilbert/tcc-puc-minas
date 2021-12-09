<!-- menu de navegacao --> 
<template>
  <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="#">Boa Entrega - Pedidos</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
       <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <!-- <a class="nav-link active" aria-current="page" href="#">Active</a> -->
            <router-link :to="{name:'home'}" class="nav-link active" aria-current="page">
                <i class="material-icons app-secondary-color-text"></i> Início
            </router-link>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Pedidos</a>
            <ul class="dropdown-menu">
              <li><router-link class="dropdown-item" :to="{name:'order-list'}">Meus Pedidos</router-link></li>
              <li><router-link class="dropdown-item" :to="{name:'order-create'}">Novo Pedido</router-link></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" :to="{name:'login'}" tabindex="-1" aria-disabled="true">Sair</router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
<!-- 
  <ul class="sidenav" id="mobile-demo" v-sidenav>
    <li><div class="user-view app-primary-color">
      <div class="background"></div>
      <a href="#user"><img class="circle" :src="(user.foto) ? user.foto : 'images/person-icon-8.png'"></a>
      <a href="#name"><span class="white-text name">{{user.name}}</span></a>
      <a href="#email"><span class="white-text email">{{user.email}}</span></a>
    </div></li>
    <li>
      <router-link :to="{name:'home'}">
        <i class="material-icons app-secondary-color-text">home</i>Início
      </router-link>
    </li>
    <li>
        <router-link :to="{name:'trilhas'}">
          <i class="small material-icons app-secondary-color-text">insert_chart</i> Trilhas 
        </router-link>
    </li>  
    <li>
        <router-link :to="{name:'favoritos'}">
          <i class="small material-icons app-secondary-color-text">favorite_border</i> Favoritos 
        </router-link>
    </li>    
    

    <li >
        <router-link :to="{name:'timeline'}">
          <i class="small material-icons app-secondary-color-text">access_time</i> Timeline 
        </router-link>
    </li>

    <li >
        <router-link :to="{name:'minhaposicao'}">
          <i class="small material-icons app-secondary-color-text">person</i> Ranking 
        </router-link>
    </li>


    
    <li><div class="divider"></div></li>
    <li>
        <router-link :to="{name:'logout'}">
          <i class="small material-icons app-secondary-color-text">exit_to_app</i> Sair 
        </router-link>
    </li>
 
  </ul> -->
</template>
<!-- ./ fim do menu de navegacao -->

<script>
//import 'materialize-css/dist/css/materialize.css'
// import UserService from '../../domain/user/UserService.js';
import User from '../../domain/user/User.js';

export default {
	
	name: 'menu',
	data() {
		return {
        user: new User(),
        titulo: 'Boa Entrega'
		};
	},
	computed: {
		cardsComFiltro() {

		},
    hasAdmin(){
      if(this.user.id_perfil == 1 || this.user.id_perfil == 2) {
        return true;
      }else{
        return false;
      }
    }
	},
    /* metodos */
    methods: {
        async getUsuario(){
          // this.user_service  = new UserService(this.$http);
          // this.user = await this.user_service.get();
          // this.titulo = this.user.empresa.nome;
          console.log("apos getUsuario");
        }
    },
	/* eventos */	
	created() {
		console.log("Menu CREATED");
        // this.getUsuario();
        // console.log("apos getUsuario no created");
              
      	
	  },
    mounted: function() {
      //alert('montou');
    }
}

</script>

<style lang="scss" scoped>

</style>