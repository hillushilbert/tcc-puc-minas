<template>
      <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                      <form @submit.prevent="login">
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
                      <button type="submit">Login</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
      </div>
</template>
<script>
export default {
    
}
</script>