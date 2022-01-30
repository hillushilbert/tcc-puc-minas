<template>
  <div>
    <boa-menu id="menu"/>
    <div class="container-fluid">
      <div class="row justify-content-center  py-4">
        <div class="col-md-10">
          <div class="card">
            <div class="card-header">Rastreamento</div>
            <div class="card-body">
              <router-link :to="{ name: 'order-list' }" class="btn btn-primary mb-3">
                <i class="fas fa-arrow-left"></i> Voltar
              </router-link> 

              <!-- dados do localizador -->
              <div class="row">
                <form v-on:submit.prevent>
                <div class="row">
                  <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <label for="name">Código Rastreamento</label>
                    <input type="text" class="form-control" id="codigo_rastreamento" v-model="codigo_rastreamento" />
                  </div>
                </div>
                <hr>
                <button
                  type="submit"
                  v-on:click="getOrder"
                  class="btn btn-primary mt-3"
                >
                  Enviar
                </button>
              </form>

              </div>
              
              <!-- detalhe dos dados da order  -->
              <div class="row" v-if="order.codigo_rastreamento != ''">
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
                  <span id="Status" v-if="order.roteamento">{{ order.roteamento.status.name }}</span>
                </div>
              </div>
              <div class="table-responsive" v-if="order.codigo_rastreamento != ''">
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
                      <tr v-if="order.roteamento" v-for="(r, index) in order.roteamento.roteiro">
                        <th>{{ r.id }}</th>
                        <td>{{ r.de }}</td>
                        <td>{{ r.para}}</td>
                        <td>{{ r.iniciado ? 'Sim':"Não"}}</td>
                        <td>{{ r.concluido ? 'Sim':"Não"}}</td>
                        <td>{{ r.id == order.roteamento.rota_atual_id ? 'Sim':"Não"}}</td>
                      </tr>
                      <tr v-else>
                          <th colspan="6">Sem dados de roteamento no momento.</th>
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
      codigo_rastreamento: "",
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
  },
  methods: {
    getOrder: async function(){
        console.log("getOrder");
        if(codigo_rastreamento != ""){
            let order_service  = new OrderService(this.$http);
            let response = await order_service.showByCodigoRastreamento(this.codigo_rastreamento);
            console.debug(response);
            if(response.data != undefined){
              this.order = response.data;
              console.debug(this.order);
            }else{
              this.$swal({
                position: "center",
                icon: "error",
                title: "Erro ao realizar pesquisa!",
                text: response.status + " - " + response.message.message,
                showConfirmButton: false,
                timer: 3000,
              });
            }
        }else{
            this.order = null;
        }
    }
  },
};
</script>