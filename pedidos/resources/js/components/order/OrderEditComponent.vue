<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Editar {{ name }}</div>
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
                :disabled="name == undefined ? true : false"
              >
                Atualizar
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
export default {
  directives: { maska },
  props: ["student"],
  data() {
    return {
      user_id: "",
      name: "",
      date_birth: "",
      gender: "",
      individual_registration: "",
      alert: "form-control",
      required_message: false,
    };
  },
  mounted() {
   
     this.user_id = this.student.id;
      this.name = this.student.name;
      this.gender = this.student.gender;
      this.date_birth = moment(this.student.date_birth, "YYYY-MM-DD").format(
        "DD/MM/YYYY"
      );
      let cpf = this.student.individual_registration
      this.individual_registration = `${cpf.substring(0, 3)}.${cpf.substring(3, 6)}.${cpf.substring(6,9)}-${cpf.substring(9, 12)}`
      
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
      let url = `/student`;
      let data = {
        id: this.user_id,
        name: this.name,
        date_birth: moment(this.date_birth, "DD/MM/YYYY").format("YYYY-MM-DD"),
        gender: this.gender,
        individual_registration: this.individual_registration.replace(/\D/g, ""),
      };
      let response = await store.customRquest(
        url,
        data,
        "PUT",
        this.$csrf_token
      );
      response.status == "success"
        ? this.successUpdate(response.message)
        : this.errorUpdate();
    },
    successUpdate: function (message) {
      this.$swal({
        position: "center",
        icon: "success",
        title: message,
        showConfirmButton: false,
        timer: 3000,
      });
    },
    errorUpdate: function () {
      this.$swal({
        position: "center",
        icon: "error",
        title: "O Aluno não pode ser cadastrado!",
        showConfirmButton: false,
        timer: 3000,
      });
    },
  },
};
</script>