<template>
  <div>
    <boa-menu id="menu"/>
    <div class="container-fluid">
      <div class="row justify-content-center  py-4">
        <div class="col-md-8 col-lg-12">
          <div class="card ">
            <div class="card-header">Lista de Pedidos</div>
            <div class="card-body">
            <router-link :to="{name:'order-create'}"class="btn btn-primary mb-5">
                <i class="fas fa-plus"></i> Novo Pedido</a>
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
                        <th>Data Criação</th>
                        <!-- <th>E-Mail</th> -->
                        <th>De</th>
                        <th>Para</th>
                        <th>CPF</th>
                        <th>Relatório</th>
                        <th>Editar</th>
                        <th>Excluir</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="(r, index) in filteredRows.slice(
                          pageStart,
                          pageStart + countOfPage
                        )"
                      >
                        <th>{{ (currPage - 1) * countOfPage + index + 1 }}</th>
                        <td>{{ r.customer.name }}<br>
                            <span class="font-italic">{{ r.customer.email }}</span></td>
                        <td>{{ changeDate(r.created_at) }}</td>
                        <!-- <td>{{ r.customer.email }}</td> -->
                        <td>{{ changeAddress(r.origin) }}</td>
                        <td>{{ changeAddress(r.destiny) }}</td>
                        <td>--</td>
                        <td>
                          <a class="pointer" v-on:click="exportPDF(r.id,r.name)"
                            ><i class="fas fa-eye"></i
                          ></a>
                        </td>
                        <td>
                          <a class="pointer" :href="'/student/edit/' + r.id"
                            ><i class="fas fa-pencil-alt"></i
                          ></a>
                        </td>
                        <td>
                          <a class="pointer" v-on:click="deleteStudent(r.id)"
                            ><i class="fas fa-trash-alt"></i
                          ></a>
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
import OrderService from '../../domain/order/OrderService.js';
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
            return (d.customer.name.toLowerCase().indexOf(filter_name) > -1
              || d.destiny.city.toLowerCase().indexOf(filter_name) > -1
              || d.origin.city.toLowerCase().indexOf(filter_name) > -1
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
    exportPDF: async function (id,name) {
      let vm = this;
    },
    setPage: function (idx) {
      if (idx <= 0 || idx > this.totalPage) {
        return;
      }
      this.currPage = idx;
    },
    changeDate: function (date_birth) {
      return moment(date_birth, "YYYY-MM-DD").format("DD/MM/YYYY");
    },
    changeCpf: function (cpf) {
      return `${cpf.substring(0, 3)}.${cpf.substring(3, 6)}.${cpf.substring(
        6,
        9
      )}-${cpf.substring(9, 12)}`;
    },
    changeAddress: function(address){
      return `${address.street}, ${address.number} - ${address.city} / ${address.state}`;
    },
    deleteStudent: async function (id) {
      let del = new Request();
      let url = "/student";
      let data = {
        id: id,
      };
      const { value: remove } = await this.$swal({
        title: "Você tem certeza?",
        text: `O Aluno será removido do sistema!`,
        icon: "warning",
        showCancelButton: true,
        focusCancel: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, remover!",
        cancelButtonText: "Cancelar",
      });
      if (remove) {
        let response = await del.customRquest(
          url,
          data,
          "DELETE",
          this.$csrf_token
        );
        this.rows = response;
        this.$swal({
          position: "center",
          icon: "success",
          title: `Aluno removido com sucesso.`,
          showConfirmButton: false,
          timer: 3000,
        });
      }
    },
    list: async function () {
      let order_service  = new OrderService(this.$http);
      
      console.log("enviando dados de order");
      let response = await order_service.index();
      console.debug(response);
      this.rows = response;
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