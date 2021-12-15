
export default class OrderService {

    constructor(resource) {

        this._resource = resource;
                
        this.user = JSON.parse(localStorage.getItem('user'));

        // mata sessão, caso nao tenha o campo api_token
        if(this.user == null || this.user.api_token == undefined){
            console.log("sem api_token");
            this._headers = {};
        }else{
            this._headers = {
                headers: {
                    'Authorization' :"Bearer "+this.user.api_token
                }
            }            
        } 

    }

	async store(record){
        //let url = this.$props.save_url;
        let url = '/pedidos/orders';
        //var csrf_token = $('meta[name="csrf-token"]').attr('content');

        return await this._resource.post(url,record,
        this._headers)
        .then(
            res => {
                console.log("ExameService::iniciar success");
                return res.json();
            },
            err => {
                console.log("ExameService:: iniciar error");
                console.debug(err);
                if(err.status == 419){
                    Swal.fire({
                        title: 'Sessão Expirada',
                        text: "Sua sessão foi expirada e você será redirecionado para novo login",
                        icon: 'warning',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'OK'
                      }).then((result) => {
                        if (result.value) {
                          window.location = '/login';
                        }
                      });
                }else{
                    throw err.body.message;
                }
            }
        );	
	}
	
	update(record,id){
		// // metodo save realiza um patch ou put	
        // return this._resource.update({ id: id }, record);
    }
    
    /**
     * reposta
     * 
     * realiza post para salvar a resposta de um estudo
     * 
     * @param Object dataPost 
     */
    resposta(id,dataPost){

        //let url = this.$props.save_url;
        let url = '/pedidos/exame/'+id;
       // var csrf_token = $('meta[name="csrf-token"]').attr('content');

        return this._resource.post(url,{
                //_token: csrf_token,
                _method: 'PATCH',
                id_pergunta: dataPost.id_pergunta,
                id_alternativa : dataPost.id_alternativa
            },
            this._headers)
            .then(
                res => res.json(),
                err => {
                    console.log("ExameService:: resposta error");
                    console.debug(err);
                    if(err.status == 419){
                        Swal.fire({
                            title: 'Sessão Expirada',
                            text: "Sua sessão foi expirada e você será redirecionado para novo login",
                            icon: 'warning',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'OK'
                          }).then((result) => {
                            if (result.value) {
                              window.location = '/login';
                            }
                          });
                    }else{
                        throw Error("Erro ao salvar questão");
                    }
                }
            ); 
    }

    /**
     * index
     * 
     * retorn promisse com comunicação para retorno de uma colecao
     * @param {*} id_colecao 
     */
    index() {
        return this._resource.get('/pedidos/orders')
        .then(res => res.json());
    }


    /**
     * show
     * 
     * retorn promisse com comunicação para retorno de uma colecao
     * @param {*} id_colecao 
     */    
     async show(id) {

        let url = '/pedidos/orders/'+id;
        
        return await this._resource.get(url,this._headers)
            .then(
                res => res.json(),
                err => {
                    console.log("ExameService:: iniciar error");
                    console.debug(err);
                    if(err.status == 419){
                        Swal.fire({
                            title: 'Sessão Expirada',
                            text: "Sua sessão foi expirada e você será redirecionado para novo login",
                            icon: 'warning',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'OK'
                          }).then((result) => {
                            if (result.value) {
                              window.location = '/login';
                            }
                          });
                    }                  
                }
            );
    }	

    destroy(id) {
		// este metodo realiza um delete
        return this._resource.delete({ id });
    }
}
