<template>
  <div>
    <boa-menu id="menu"/>
    <div class="container-fluid">
      <div class="row justify-content-center  py-4">
        <div class="col-md-10">
          <div class="card">
            <div class="card-header">Novo Pedido</div>
            <div class="card-body">
              <a href="/home" class="btn btn-primary mb-3"
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
                <address-component title="Endereço de retirada" @changed="onChangeOrigin"/>
                <hr>
                <!-- destination_adress  -->
                <address-component title="Endereço de entrega" @changed="onChangeDestiny"/>
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
import AddressComponent from './../share/AddressComponent.vue';

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
      destination_adress_zipcode:"",
      destination_adress_street:"",
      destination_adress_number:"",
      destination_adress_neighborhood:"",
      destination_adress_city:"",
      destination_adress_state:"",
      origin_adress_zipcode:"",
      origin_adress_street:"",
      origin_adress_number:"",
      origin_adress_neighborhood:"",
      origin_adress_city:"",
      origin_adress_state:""
    };
  },
  components: {
		'boa-menu': BoaMenu,
		'address-component': AddressComponent
	},
  methods: {
    onChangeOrigin(address){
      console.log("start onChangeOrigin");
      console.debug(address);
      this.origin_adress_zipcode = address.zipcode;
      this.origin_adress_street = address.street;
      this.origin_adress_number = address.number;
      this.origin_adress_neighborhood = address.neighborhood;
      this.origin_adress_city = address.city;
      this.origin_adress_state = address.state;
      console.log("end onChangeOrigin");
    },
    onChangeDestiny(address){
      console.log("start onChangeDestiny");
      console.debug(address);
      this.destination_adress_zipcode = address.zipcode;
      this.destination_adress_street = address.street;
      this.destination_adress_number = address.number;
      this.destination_adress_neighborhood = address.neighborhood;
      this.destination_adress_city = address.city;
      this.destination_adress_state = address.state;
      console.log("end onChangeDestiny");
    },
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
          cpf: this.individual_registration.replace(/\D/g, ""),
        },
        origin_adress: {
            zipcode: this.origin_adress_zipcode,
            street: this.origin_adress_street,
            number: this.origin_adress_number,
            neighborhood: this.origin_adress_neighborhood,
            city: this.origin_adress_city,
            state: this.origin_adress_state,
            country: "BR",
            active: true
        },
        destination_adress: {
            zipcode: this.destination_adress_zipcode,
            street: this.destination_adress_street,
            number: this.destination_adress_number,
            neighborhood: this.destination_adress_neighborhood,
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