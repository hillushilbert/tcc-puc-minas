<template>
      <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                      <form @submit.prevent="login">
                      <input v-model="username" placeholder="username" />
                      <br />
                      <br />
                      <input v-model="password" placeholder="password" type="password" />
                      <br />
                      <br />
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