<template>
  <div>
    
    <!-- origin_adress  -->
    <h3>{{title}}</h3>
    <div class="row">

        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <label for="origin_adress_number">CEP</label>
        <input
            type="number"
            class="form-control"
            id="origin_adress_zipcode"
            v-model="address.zipcode"
            @blur="handleCep"
        />
        </div>   

        <div class="col-12 col-sm-12 col-md-6 col-lg-7">
        <label for="origin_adress_street">Rua</label>
        <input
            type="text"
            class="form-control"
            id="origin_adress_street"
            v-model="address.street"
            @change="clearAlertRequire"
        />
        </div>

        <div class="col-12 col-sm-12 col-md-6 col-lg-2">
        <label for="origin_adress_number">Numero</label>
        <input
            type="number"
            class="form-control"
            id="origin_adress_number"
            v-model="address.number"
            @change="clearAlertRequire"
        />
        </div>        
        
        <div class="col-12 col-sm-12 col-md-6 col-lg-5">
        <label for="origin_adress_number">Bairro</label>
        <input
            type="text"
            class="form-control"
            id="origin_adress_neighborhood"
            v-model="address.neighborhood"
            @change="clearAlertRequire"
        />
        </div>

        <div class="col-12 col-sm-12 col-md-6 col-lg-5">
        <label for="origin_adress_city">Cidade</label>
        <input
            type="text"
            class="form-control"
            id="origin_adress_city"
            v-model="address.city"
            @change="clearAlertRequire"
        />
        </div>

        <div class="col-12 col-sm-12 col-md-6 col-lg-2">
        <label for="origin_adress_state">Estado</label>
        <input
            type="text"
            class="form-control"
            id="origin_adress_state"
            v-model="address.state"
            @change="clearAlertRequire"
        />
        </div>
    </div>
  </div>
</template>

<script>
import { maska } from "maska";
// import UserService from '../../domain/user/UserService.js';
import OrderService from '../../domain/order/OrderService.js';
import BoaMenu from './../menu/Menu.vue';

export default {
  props: {
    title: { required: true, type: String },
    done: { default: false, type: Boolean }
  },
  directives: { maska },
  data() {
    return {
        address : {
            street:"",
            number:"",
            neighborhood: "",
            city:"",
            state:"",
            zipcode: ""
        }
    };
  },
  methods: {

    clearAlertRequire: function () {
      this.$emit('changed', this.address)
    },

    handleCep: async function () {
    //   this.clearAlertRequire();
      if (this.address.zipcode != "") {
        let url = `${this.$via_cep}/${this.address.zipcode}/json`;
        // let response = await zip.simpleRequest(url);
        let response = await this.$http.get(url).then(res => res.json());
        if (!response.erro) {
          this.address.street = response.logradouro;
        //   this.complement = response.complemento;
          this.address.neighborhood = response.bairro;
          this.address.city = response.localidade;
          this.address.state = response.uf;
          this.clearAlertRequire();
        }
      }
    },
    clearForm: function (message) {
      this.name = "";
      this.birth_date = "";
      this.email = "";
      this.individual_registration = "";

      this.$swal.fire({
        title: 'Pedido Incluido',
        text: "Seu pedido foi incluido e logo será processado",
        icon: 'success',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
      }).then((result) => {
        // if (result.value) {
        //   window.location = '/login';
        // }
      });
    },
    errorSubmit: function () {
      this.$swal({
        position: "center",
        icon: "error",
        title: "O Aluno não pode ser cadastrado!",
        showConfirmButton: false,
        timer: 3000,
      });
    },
  },
  created() {
        this.$via_cep = 'https://viacep.com.br/ws';
		console.log("CREATED");
		console.debug(this.$route.params.id);		
		console.debug(this.$props);	

      // this.user_service  = new UserService(this.$http);
      
  }
};
</script>