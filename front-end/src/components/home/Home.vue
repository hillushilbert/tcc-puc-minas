<template>
  <div>
    <boa-menu id="menu"/>
    <div class="container-fluid">
      <div class="row justify-content-center  py-4">
          <div class="col-md-8 col-lg-12">
              <div class="card ">
              <div class="card-header">Editar {{ name }}</div>
              <h1>Olá</h1>
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
	}
}
</script>