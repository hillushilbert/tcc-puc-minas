<template>
  <div>
    <boa-menu id="menu"/>
    <div class="container-fluid">
      <div class="row justify-content-center  py-4">
        <div class="col-md-10">
          <div class="card ">
            <div class="card-header">Lista de Clientes</div>
            <div class="card-body">
            <router-link :to="{name:'customer-create'}"class="btn btn-primary mb-5">
                <i class="fas fa-plus"></i> Novo Cliente</a>
            </router-link>
              <div class="container" id="">
                <div class="filter input-group mb-3">
                  <input
                    class="form-control"
                    type="text"
                    placeholder="Filtrar pelo nome..."
                    v-model="filter_name"
                  />
                </div>
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Data Nascimento</th>
                        <!-- <th>E-Mail</th> -->
                        <th>Email</th>
                        <th>Editar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="(r, index) in filteredRows.slice(
                          pageStart,
                          pageStart + countOfPage
                        )"
                      >
                        <th>{{ r.id }}</th>
                        <td>{{ r.nome }}<br>
                        <td>{{ changeDate(r.data_nascimento) }}</td>
                        <td>{{ r.email }}</td>
                        <td>
                            <router-link :to="{ name: 'customer-edit', params: {id: r.id } }" class="pointer">
                                <i class="fas fa-pencil-alt"></i>
                            </router-link> 
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <nav aria-label="Page navigation example">
                  <ul class="pagination justify-content-center">
                    <li
                      class="page-item"
                      v-bind:class="{ disabled: currPage === 1 }"
                      @click.prevent="setPage(currPage - 1)"
                    >
                      <a class="page-link" href="">Anterior</a>
                    </li>
                    <li
                      class="page-item"
                      v-for="n in totalPage"
                      v-bind:class="{ active: currPage === n }"
                      @click.prevent="setPage(n)"
                    >
                      <a class="page-link" href="">{{ n }}</a>
                    </li>
                    <li
                      class="page-item"
                      v-bind:class="{ disabled: currPage === totalPage }"
                      @click.prevent="setPage(currPage + 1)"
                    >
                      <a class="page-link" href="">Próxima</a>
                    </li>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-8"></div>
      </div>
    </div>
  </div>
</template>

<script>
import BoaMenu from './../menu/Menu.vue';
import { maska } from "maska";
import CustomerService from '../../domain/customer/CustomerService.js';
export default {
  directives: { maska },
  data() {
    return {
      rows: [],
      countOfPage: 5,
      currPage: 1,
      filter_name: "",
      report: null,
    };
  },
  components: {
		'boa-menu': BoaMenu
	},
  computed: {
    filteredRows: function () {
      var filter_name = this.filter_name.toLowerCase();
      return this.filter_name.trim() !== ""
        ? this.rows.filter(function (d) {
            return (d.nome.toLowerCase().indexOf(filter_name) > -1
              || d.email.toLowerCase().indexOf(filter_name) > -1
              || d.cpfOuCnpj.toLowerCase().indexOf(filter_name) > -1
            );
          })
        : this.rows;
    },
    pageStart: function () {
      return (this.currPage - 1) * this.countOfPage;
    },
    totalPage: function () {
      return Math.ceil(this.filteredRows.length / this.countOfPage);
    },
  },
  methods: {
    setPage: function (idx) {
      if (idx <= 0 || idx > this.totalPage) {
        return;
      }
      this.currPage = idx;
    },
    changeDate: function (date_birth) {
      return moment(date_birth, "YYYY-MM-DD").format("DD/MM/YYYY");
    },
    list: async function () {
      let order_service  = new CustomerService(this.$http);
      
      console.log("enviando dados de order");
      let response = await order_service.index();
      console.debug(response);
      this.rows = response.data;
    },
  },
  created() {
    console.log("created");
    this.list();
  }
};
</script>

<style scoped>
.pointer {
  cursor: pointer !important;
}
</style>