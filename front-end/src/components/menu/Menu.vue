<!-- menu de navegacao --> 
<template>
  <div>
  <b-navbar toggleable="lg"  type="dark" variant="dark">
      <b-navbar-brand href="#">{{titulo}}</b-navbar-brand>

      <b-navbar-toggle target="navbar-toggle-collapse"></b-navbar-toggle>

      <b-collapse id="navbar-toggle-collapse" is-nav>
       <!-- Right Side Of Navbar -->
        <b-navbar class="ml-auto">
        <!-- <b-nav> -->
          <b-nav-item>
            <!-- <a class="nav-link active" aria-current="page" href="#">Active</a> -->
            <router-link :to="{name:'home'}" class="nav-link active" aria-current="page">
                <i class="material-icons app-secondary-color-text"></i> Início
            </router-link>
          </b-nav-item>
          <b-nav-item>
            <!-- <a class="nav-link active" aria-current="page" href="#">Active</a> -->
            <router-link :to="{name:'customer-create'}" class="nav-link active" aria-current="page">
                <i class="material-icons app-secondary-color-text"></i> Novo Cliente
            </router-link>
          </b-nav-item>
          <b-nav-item-dropdown
            id="my-nav-pedidos"
            text="Pedidos"
            toggle-class="nav-link-custom"
            right>
            <b-dropdown-item><router-link class="dropdown-item" :to="{name:'order-list'}">Meus Pedidos</router-link></b-dropdown-item>
            <b-dropdown-item><router-link class="dropdown-item" :to="{name:'order-create'}">Novo Pedido</router-link></b-dropdown-item>
            <b-dropdown-divider></b-dropdown-divider>
            <!-- <b-dropdown-item>Three</b-dropdown-item> -->
          </b-nav-item-dropdown>
          <!-- <b-nav-item>
            <a class="nav-link" href="#">Link</a>
          </b-nav-item> -->
          <b-nav-item>
            <router-link class="nav-link" :to="{name:'login'}" tabindex="-1" aria-disabled="true">Sair</router-link>
          </b-nav-item>
        <!-- </b-nav> -->
        </b-navbar>
      </b-collapse>
  </b-navbar>
  </div>
</template>
<!-- ./ fim do menu de navegacao -->

<script>
//import 'materialize-css/dist/css/materialize.css'
import UserService from '../../domain/user/UserService.js';
import User from '../../domain/user/User.js';

export default {
	
	name: 'menu',
	data() {
		return {
        user: new User(),
        titulo: 'Boa Entrega',
        intervalid1: "",
        service: ""
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
  beforeDestroy () {
    clearInterval(this.intervalid1)
  },
  /* metodos */
  methods: {
      async getUsuario(){
        // this.user_service  = new UserService(this.$http);
        // this.user = await this.user_service.get();
        // this.titulo = this.user.empresa.nome;
        console.log("apos getUsuario");
      },
      async refresh(){          
        const self = this;          
        let expires = 30;
        this.intervalid1 = setInterval(async function(){
          console.log("intervalid1");
          let service  = new UserService(self.$http);
          let data = {
            refresh_token: localStorage.getItem('refresh_token')
          };
          try
          {
            let response = await service.refresh_token(data);
            localStorage.setItem('access_token', response.access_token);
            localStorage.setItem('refresh_token', response.refresh_token);
            localStorage.setItem('expires_in', response.expires_in);
            console.debug(response);
          }
          catch(e)
          {
            console.log("erro ao realizar refresh");
            if(e.status == 400 || e.status == 0){
              self.$router.push({ name: 'logout'});
            }
            console.debug(e);
          }   
        }, 1000 * expires);
      }
  },
	/* eventos */	
	created() {
		console.log("Menu CREATED");
    this.refresh();  	
	},
  mounted: function() {
    //alert('montou');
  }
}

</script>

<style lang="scss" scoped>

</style>