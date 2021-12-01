
export default class ExameService {

    constructor(resource) {

        this._resource = resource;


        if(localStorage.getItem('user') === null || localStorage.getItem('user').length == 0)
        {
            window.location = '/app/login';  
        }
                
        this.user = JSON.parse(localStorage.getItem('user'));

        // mata sessão, caso nao tenha o campo api_token
        if(this.user.api_token == undefined){
            window.location = '/app/logout';
        }

        this._headers = {
            headers: {
                'Authorization' :"Bearer "+this.user.api_token
            }
        }        
    }

	iniciar(record){
        //let url = this.$props.save_url;
        let url = '/api/exame';
        //var csrf_token = $('meta[name="csrf-token"]').attr('content');

        return this._resource.post(url,{
            //_token: csrf_token,
            // _method: 'PATCH',
            id_teste: record.id_teste,
            id_user: record.id_user,
            tipo_exame: record.tipo_exame
        },
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
        let url = '/api/exame/'+id;
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
    index(id_colecao) {
        // return this._resource.get('/api/colecao/'+id_colecao+'/estudo')
        // .then(res => res.json());
    }

    /**
     * index
     * 
     * retorn promisse com comunicação para retorno de uma colecao
     * @param {*} id_colecao 
     */
    async quizz(id_quizz) {
        return await this._resource.get('/api/exame?quizz='+id_quizz,this._headers)
        .then(res => res.json());
    }

    /**
     * index
     * 
     * retorn promisse com comunicação para retorno de uma colecao
     * @param {*} id_colecao 
     */
     async treinando(id_quizz) {
        return await this._resource.get('/api/exame?treinando='+id_quizz,this._headers)
        .then(res => res.json());
    }    


    /**
     * show
     * 
     * retorn promisse com comunicação para retorno de uma colecao
     * @param {*} id_colecao 
     */    
    show(id) {

        let url = '/api/exame/'+id;
        
        return this._resource.get(url,this._headers)
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
