<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Novo Aluno</div>
          <div class="card-body">
            <a href="/student" class="btn btn-primary mb-3"
              ><i class="fas fa-arrow-left"></i> Voltar</a
            >
            <form v-on:submit.prevent>
              <div class="form-row">
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
                  <label for="date_birth">Data de Nascimento</label>
                  <input
                    type="text"
                    class="form-control"
                    id="date_birth"
                    v-model="date_birth"
                    v-maska="'##/##/####'"
                  />
                </div>
              </div>

              <div class="form-row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                  <label for="gender">Sexo</label>
                  <select class="form-control" id="gender" v-model="gender">
                    <option disabled value="">Selecione uma opção...</option>
                    <option value="0">Masculino</option>
                    <option value="1">Feminino</option>
                    <option value="2">Indefinido</option>
                  </select>
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
</template>

<script>
import { maska } from "maska";
import UserService from '../../domain/user/UserService.js';
import ExameService from '../../domain/exame/ExameService.js';

export default {
  directives: { maska },
  data() {
    return {
      name: "",
      date_birth: "",
      gender: "",
      individual_registration: "",
      alert: "form-control",
      required_message: false,
    };
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
      let store = new Request();
      let url = "/student";
      let data = {
        name: this.name,
        date_birth: moment(this.date_birth, "DD/MM/YYYY").format("YYYY-MM-DD"),
        gender: this.gender,
        individual_registration: this.individual_registration.replace(/\D/g, ""),
      };
      let response = await store.customRquest(
        url,
        data,
        "POST",
        this.$csrf_token
      );
      response.status == "success"
        ? this.clearForm(response.message)
        : this.errorSubmit();
    },
    clearForm: function (message) {
      this.name = "";
      this.date_birth = "";
      this.gender = "";
      this.individual_registration = "";
      this.$swal({
        position: "center",
        icon: "success",
        title: message,
        showConfirmButton: false,
        timer: 3000,
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

        // Or with jQuery
        //M.toast({html: 'I am a toast!'})



        this.user_service  = new UserService(this.$http);
        this.exame_service  = new ExameService(this.$http);
  }
};
</script>