<template>
  <div>
    <boa-menu id="menu"/>
    <div class="container-fluid">
      <div class="row justify-content-center  py-4">
          <div class="col-md-8 col-lg-12">
              <div class="card ">
              <div class="card-header">Bem-vindo ao Boa Entrega</div>
              <div class="card-body" v-if="user">
                <h1> {{ user.name }} </h1>
                <!-- realm_access.roles -->
                <p>realm_access roles </p>
                <ul v-if="user.realm_access.roles"> 
                  <li v-for="(r, index) in user.realm_access.roles">{{r }}</li>
                </ul> 
              </div>
              </div>
          </div>
      </div>
    </div>
  </div>
</template>
<script>
import BoaMenu from './../menu/Menu.vue';
import UserService from '../../domain/user/UserService.js';

export default {
  components: {
		'boa-menu': BoaMenu
	},
  data() {
		return {
        name: 'Guest',
        user: null
		};
	},
  created() {
		console.log("CREATED Login");
    let service = new UserService(this.$http);
    this.user = service.parseJwt();
    console.debug(this.user);
  }
}
</script>