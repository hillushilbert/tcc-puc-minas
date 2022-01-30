import Service from '../Service.js';

export default class CustomerService extends Service {

    constructor(resource) {
        super(resource); 

    }

	async store(record){
        let url = 'mic/clientes';
        
        return await this.post(url,record);
        
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
                    // console.debug(err);
                    return { status : err.status, message : JSON.parse(err.bodyText) };
                }
            ); 
    }

    /**
     * index
     * 
     * retorn promisse com comunicação para retorno de uma colecao
     */
    async index(){
        let url = 'mic/clientes';
        
        return await this.get(url);
        
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
                    console.debug(err);
                    return { status : err.status, message : JSON.parse(err.bodyText) };
                }
            );
    }	

    destroy(id) {
		// este metodo realiza um delete
        return this._resource.delete({ id });
    }
}
