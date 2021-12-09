<template>
  <div>
    <boa-menu id="menu"/>
    <div class="container-fluid">
      <div class="row justify-content-center  py-4">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">Novo Pedido</div>
            <div class="card-body">
              <a href="/student" class="btn btn-primary mb-3"
                ><i class="fas fa-arrow-left"></i> Voltar</a
              >
              <form v-on:submit.prevent>
                <div class="row">
                  <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <label for="name">Nome</label>
                    <input
                      type="text"
                      :class="alert"
                      id="name"
                      v-model="name"
                      v-on:keyup="clearAlertRequire"
                    />
                    <small v-if="required_message" class="text-danger"
                      >Este campo é obrigatório.</small
                    >
                  </div>

                  <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <label for="birth_date">Data de Nascimento</label>
                    <input
                      type="text"
                      class="form-control"
                      id="birth_date"
                      v-model="birth_date"
                      v-maska="'##/##/####'"
                    />
                  </div>
                </div>

                <div class="row">
                  <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <label for="email">E-Mail</label>
                    <input
                      type="email"
                      class="form-control"
                      id="email"
                      v-model="email"
                    />
                  </div>

                  <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <label for="individual_registration">CPF</label>
                    <input
                      type="text"
                      class="form-control"
                      id="individual_registration"
                      v-model="individual_registration"
                      v-maska="'###.###.###-##'"
                    />
                  </div>
                </div>
                <hr>
                <!-- origin_adress  -->
                <h3>Endereço de retirada</h3>
                <div class="row">
                  <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <label for="origin_adress_street">Rua</label>
                    <input
                      type="text"
                      class="form-control"
                      id="origin_adress_street"
                      v-model="origin_adress_street"
                    />
                  </div>

                  <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <label for="origin_adress_number">Numero</label>
                    <input
                      type="text"
                      class="form-control"
                      id="origin_adress_number"
                      v-model="origin_adress_number"
                    />
                  </div>

                  <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <label for="origin_adress_city">Cidade</label>
                    <input
                      type="text"
                      class="form-control"
                      id="origin_adress_city"
                      v-model="origin_adress_city"
                    />
                  </div>

                  <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <label for="origin_adress_state">Estado</label>
                    <input
                      type="text"
                      class="form-control"
                      id="origin_adress_state"
                      v-model="origin_adress_state"
                    />
                  </div>
                </div>
                <hr>
                <!-- destination_adress  -->
                <h3>Endereço de entrega</h3>
                <div class="row">
                  <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <label for="destination_adress_street">Rua</label>
                    <input
                      type="text"
                      class="form-control"
                      id="destination_adress_street"
                      v-model="destination_adress_street"
                    />
                  </div>

                  <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <label for="destination_adress_number">Numero</label>
                    <input
                      type="text"
                      class="form-control"
                      id="destination_adress_number"
                      v-model="destination_adress_number"
                    />
                  </div>

                  <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <label for="destination_adress_city">Cidade</label>
                    <input
                      type="text"
                      class="form-control"
                      id="destination_adress_city"
                      v-model="destination_adress_city"
                    />
                  </div>

                  <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <label for="destination_adress_state">Estado</label>
                    <input
                      type="text"
                      class="form-control"
                      id="destination_adress_state"
                      v-model="destination_adress_state"
                    />
                  </div>
                </div>
                <button
                  type="submit"
                  v-on:click="validateForm"
                  class="btn btn-primary mt-3"
                >
                  Enviar
                </button>
              </form>
            </div>
          </div>
        </div>
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
  directives: { maska },
  data() {
    return {
      name: "",
      birth_date: "",
      email: "",
      individual_registration: "",
      alert: "form-control",
      required_message: false,
      destination_adress_street:"",
      destination_adress_number:"",
      destination_adress_city:"",
      destination_adress_state:"",
      origin_adress_street:"",
      origin_adress_number:"",
      origin_adress_city:"",
      origin_adress_state:""
    };
  },
  components: {
		'boa-menu': BoaMenu
	},
  methods: {
    validateForm: function () {
      this.name == "" ? this.alertRequire() : this.store();
    },
    alertRequire: function () {
      this.alert = "form-control is-invalid";
      this.required_message = true;
    },
    clearAlertRequire: function () {
      this.alert = "form-control";
      this.required_message = false;
    },
    store: async function () {
      let order_service  = new OrderService(this.$http);
      let data = {
        customer: {
          name: this.name,
          birth_date: moment(this.birth_date, "DD/MM/YYYY").format("YYYY-MM-DD"),
          email: this.email,
          individual_registration: this.individual_registration.replace(/\D/g, ""),
        },
        origin_adress: {
            street: this.origin_adress_street,
            number: this.origin_adress_number,
            city: this.origin_adress_city,
            state: this.origin_adress_state,
            country: "BR",
            active: true
        },
        destination_adress: {
            street: this.destination_adress_street,
            number: this.destination_adress_number,
            city: this.destination_adress_city,
            state: this.destination_adress_state,
            country: "BR",
            active: true
        },
        supplier: {
            name: "Boa Entrega",
            email: "contato@boaentrega.com.br"
        },
        unity: "UND",
        weight: 10,
        height: 20,
        width: 30,
        length: 10
      };
      console.log("enviando dados de order");
      let response = await order_service.store(data);
      console.debug(response);
      response.success == true
        ? this.clearForm(response.message)
        : this.errorSubmit();
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
		console.log("CREATED");
		console.debug(this.$route.params.id);		
		console.debug(this.$props);	

      // this.user_service  = new UserService(this.$http);
      
  }
};
</script>