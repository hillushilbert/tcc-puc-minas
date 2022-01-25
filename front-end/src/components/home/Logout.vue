<template>
  <div>
    <boa-menu id="menu"/>
    <div class="container-fluid">
      <div class="row justify-content-center  py-4">
          <div class="col-md-8 col-lg-12">
              <div class="card ">
              <div class="card-header">Saindo</div>
              <h1>Aguarde...</h1>
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
        name: 'Guest'
    };
  },
  methods: {
    logout: async function () {
      let user_service  = new UserService(this.$http);
      let data = {
        refresh_token: localStorage.getItem('refresh_token')
      };

      console.log("realizando refresh token");
      try
      {
        let response = await user_service.logout(data);
        console.debug(response);    
        localStorage.removeItem('access_token');
        localStorage.removeItem('refresh_token');
        localStorage.removeItem('expires_in'); 
        this.$router.push({ name: 'login'});    
      }
      catch(e)
      {
        console.debug(e);
        alert('error ao realizar logout');
      }

    },
  },
  created() {
    console.log("CREATED Logout");
    this.logout();
  }
}
</script>