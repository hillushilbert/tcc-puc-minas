<template>
      <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form v-on:submit.prevent>
                      <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                          <label for="name">Nome</label>
                          <input
                            type="text"
                            class="form-control"
                            id="username"
                            v-model="username"
                          />
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                          <label for="name">Senha</label>
                          <input
                            type="password"
                            class="form-control"
                            id="password"
                            v-model="password"
                          />
                        </div>
                      </div>
                      <button class="btn btn-primary" type="submit"
                       v-on:click="authForm">Entrar</button>
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

export default {
  directives: { maska },
  data() {
    return {
      username: "",
      password: ""
    };
  },
  methods: {

    authForm: async function () {
        let user_service  = new UserService(this.$http);
        let data = {
          email: this.username,
          password: this.password
        };

        console.log("realizando login");
        try
        {
          let response = await user_service.auth(data);
          console.debug(response);

          response.access_token != undefined
                         ? this.saveData(response)
                         : this.errorSubmit(response);
        }
        catch(e)
        {
          console.debug(e);
          this.errorSubmit()
        }
    },
    saveData: function (response) {
      this.username = "";
      this.password = "";
      // redirect to menu home
      localStorage.setItem('access_token', response.access_token);
      localStorage.setItem('refresh_token', response.refresh_token);
      localStorage.setItem('expires_in', response.expires_in);
      this.$router.push({ name: 'home'});
    },
    errorSubmit: function (message) {
      this.$swal({
        position: "center",
        icon: "error",
        title: "Erro ao realizar login!",
        text: (message.error_description != undefined) ? message.error_description: "Erro padrao",
        showConfirmButton: false,
        timer: 3000,
      });
    },
  },
  created() {
		console.log("CREATED Login");      
  }
};
</script>