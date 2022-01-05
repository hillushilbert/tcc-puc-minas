<template>
  <div>
    <boa-menu id="menu"/>
    <div class="container-fluid">
      <div class="row justify-content-center  py-4">
        <div class="col-md-10">
          <div class="card">
            <div class="card-header">Novo Cliente</div>
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
                    <label for="data_nascimento">Data de Nascimento</label>
                    <input
                      type="text"
                      class="form-control"
                      id="data_nascimento"
                      v-model="data_nascimento"
                      v-maska="'##/##/####'"
                    />
                    <small v-if="required_message" class="text-danger"
                      >Este campo é obrigatório.</small
                    >
                  </div>
                </div>

                <div class="row">
                  <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <label for="email">E-Mail</label>
                    <input
                      type="email"
                      :class="alert"
                      id="email"
                      v-model="email"
                      v-on:keyup="clearAlertRequire"
                    />
                    <small v-if="required_message" class="text-danger"
                      >Este campo é obrigatório.</small
                    >
                  </div>

                  <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <label for="cpfOuCnpj">CPF</label>
                    <input
                      type="text"
                      :class="alert"
                      id="cpfOuCnpj"
                      v-model="cpfOuCnpj"
                      v-maska="'###.###.###-##'"
                      v-on:keyup="clearAlertRequire"
                    />
                    <small v-if="required_message" class="text-danger"
                      >Este campo é obrigatório.</small
                    >
                  </div>

                  <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <label for="data_nascimento">Telefone</label>
                    <input
                      type="text"
                      :class="alert"
                      id="telefone"
                      v-model="telefone"
                      v-maska="'(##) ####.####'"
                      v-on:keyup="clearAlertRequire"
                    />
                    <small v-if="required_message" class="text-danger"
                      >Este campo é obrigatório.</small
                    >
                  </div>

                  <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <label for="sexo">Sexo</label>
                    <select name="sexo" :class="alert" id="sexo" v-model="sexo"  v-on:keyup="clearAlertRequire">
                      <option value=""></option>
                      <option value="M">Masculino</option>
                      <option value="F">Feminino</option>
                    </select>
                    <small v-if="required_message" class="text-danger"
                      >Este campo é obrigatório.</small
                    >
                  </div>
                </div>
                <hr>
                <!-- origin_adress  -->
                <address-component title="Endereço" @changed="onChangeOrigin"/>
                <hr>
                
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
import CustomerService from '../../domain/customer/CustomerService.js';
import BoaMenu from './../menu/Menu.vue';
import AddressComponent from './../share/AddressComponent.vue';

export default {
  directives: { maska },
  data() {
    return {
      name: "",
      data_nascimento: "",
      email: "",
      cpfOuCnpj: "",
      alert: "form-control",
      required_message: false,
      telefone:"",
      sexo:"",
      cep:"",
      logradouro:"",
      numero:"",
      bairro:"",
      cidade:"",
      uf:""
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
      this.cep = address.zipcode;
      this.logradouro = address.street;
      this.numero = address.number;
      this.bairro = address.neighborhood;
      this.cidade = address.city;
      this.uf = address.state;
      console.log("end onChangeOrigin");
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
        let order_service  = new CustomerService(this.$http);
        let data = {
            nome: this.name,
            data_nascimento: moment(this.data_nascimento, "DD/MM/YYYY").format("YYYY-MM-DD"),
            email: this.email,
            // cpfOuCnpj: this.cpfOuCnpj.replace(/\D/g, ""),
            cpfOuCnpj: this.cpfOuCnpj,
            // telefone : this.telefone.replace(/\D/g, ""),
            telefone : this.telefone,
            razao_social: '',
            tp_pessoa: 'F',
            sexo: this.sexo,
            cep: this.cep,
            logradouro: this.logradouro,
            numero: this.numero,
            bairro: this.bairro,
            cidade: this.cidade,
            uf: this.uf
        };

        console.log("enviando dados de order");
        try
        {
          let response = await order_service.store(data);
          console.debug(response);
          response.success == true
                         ? this.clearForm(response.message)
                         : this.errorSubmit();
        }
        catch(e)
        {
          console.debug(e);
          this.errorSubmit()
        }
    },
    clearForm: function (message) {
      this.name = "";
      this.data_nascimento = "";
      this.email = "";
      this.cpfOuCnpj = "";

      this.$swal.fire({
        title: 'Cliente Incluido',
        text: "Seu Cliente foi incluido e logo será processado",
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
        title: "O Cliente não pode ser cadastrado!",
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