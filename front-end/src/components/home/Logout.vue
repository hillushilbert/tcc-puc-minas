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
export default {
  components: {
    'boa-menu': BoaMenu
  },
  data() {
    return {
        name: 'Guest'
    };
  },
  created() {
    console.log("CREATED Logout");
    localStorage.removeItem('access_token');
    localStorage.removeItem('refresh_token');
    localStorage.removeItem('expires_in'); 
    this.$router.push({ name: 'login'});    
  }
}
</script>