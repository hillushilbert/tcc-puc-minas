import Service from '../Service.js';

export default class CustomerService extends Service {

    constructor(resource) {
        super(resource); 

    }

	async store(record){
        //let url = this.$props.save_url;
        let url = 'mic/clientes';
        //var csrf_token = $('meta[name="csrf-token"]').attr('content');

        return await this._resource.post(url,record,
        this._headers)
        .then(
            res => {
                console.log("CustomerService::iniciar success");
                return res.json();
            },
            err => {
                console.log("CustomerService:: iniciar error");
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
    update(id,dataPost){

        //let url = this.$props.save_url;
        let url = 'mic/clientes/'+id;
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
                    console.log("CustomerService:: resposta error");
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
        return this._resource.get('mic/clientes')
        .then(res => res.json());
    }


    /**
     * show
     * 
     * retorn promisse com comunicação para retorno de uma colecao
     * @param {*} id_colecao 
     */    
     async show(id) {

        let url = 'mic/clientes/'+id;
        
        return await this._resource.get(url,this._headers)
            .then(
                res => res.json(),
                err => {
                    console.log("CustomerService:: iniciar error");
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
