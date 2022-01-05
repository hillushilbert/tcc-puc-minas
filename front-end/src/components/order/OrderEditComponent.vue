<template>
  <div>
    <boa-menu id="menu"/>
    <div class="container-fluid">
      <div class="row justify-content-center  py-4">
        <div class="col-md-10">
          <div class="card">
            <div class="card-header">Rastreamento {{ order.codigo_rastreamento }}</div>
            <div class="card-body">
              <router-link :to="{ name: 'order-list' }" class="btn btn-primary mb-3">
              
                <i class="fas fa-arrow-left"></i> Voltar
              </router-link> 
              <div class="row">
                <div class="col-md-3">
                    <label for="cliente"><strong>Cliente:</strong> </label><br>
                    <span id="cliente" >{{ order.customer.name }}</span>
                </div>
                <div class="col-md-3">
                  <label for="Origem"><strong>Origem:</strong> </label><br>
                  <span id="Origem" >{{ order.origin.city }} / {{ order.origin.state }}</span>
                </div>
                <div class="col-md-3">
                  <label for="Destino"><strong>Destino:</strong> </label><br>
                  <span id="Destino" >{{ order.destiny.city }} / {{ order.destiny.state }}</span>
                </div>
                <div class="col-md-3">
                  <label for="Status"><strong>Status:</strong> </label><br>
                  <span id="Status" >{{ order.roteamento.status.name }}</span>
                </div>
              </div>
              <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>De</th>
                        <th>Para</th>
                        <th>Iniciado</th>
                        <th>Concluido</th>
                        <th>Atual</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(r, index) in order.roteamento.roteiro">
                        <th>{{ r.id }}</th>
                        <td>{{ r.de }}</td>
                        <td>{{ r.para}}</td>
                        <td>{{ r.iniciado ? 'Sim':"Não"}}</td>
                        <td>{{ r.concluido ? 'Sim':"Não"}}</td>
                        <td>{{ r.id == order.roteamento.rota_atual_id ? 'Sim':"Não"}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import BoaMenu from './../menu/Menu.vue';
import OrderService from '../../domain/order/OrderService.js';

export default {
  props: {
      id: { default: 0, type: Number }
  },
  components: {
		'boa-menu': BoaMenu
	},
  data() {
    return {
      user_id: "",
      name: "",
      order : {
        codigo_rastreamento: "",
        customer: {
          name: ""
        },
        origin: {
          city:"",
          state:""
        },
        destiny: {
          city:"",
          state:""
        },
        roteamento: {
          rota_atual_id: 0,
          status: {
            name: ""
          },
          roteiro:[]
        }
      }
    };
  },
  mounted() {
   

  },
  created() {
		console.log("CREATED");
		console.debug(this.$route.params.id);		
		console.debug(this.$props);	
    this.id = this.$route.params.id;
    this.getOrder();
  },
  methods: {
    validateForm: function () {
      this.name == "";
    },
    getOrder: async function(){
       console.log("getOrder");
       let order_service  = new OrderService(this.$http);
       let response = await order_service.show(this.id);
       this.order = response.data;
       console.debug(this.order);
    }
  },
};
</script>