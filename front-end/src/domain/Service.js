
export default class Service {

    constructor(resource) {

        this._resource = resource;
                
        this.access_token = localStorage.getItem('access_token');

        // mata sessão, caso nao tenha o campo api_token
        if(this.access_token == null || this.access_token == undefined){
            console.log("sem api_token");
            this._headers = {};
        }else{
            this._headers = {
                headers: {
                    'Authorization' :"Bearer "+this.access_token
                }
            }            
        } 

    }

    getBaseHeaders()
    {
        let access_token = localStorage.getItem('access_token');

        let _headers = {
            headers: {
                'Authorization' :"Bearer "+access_token,
                'Content-Type' : "application/json; charset=utf-8"
            }
        };

        return _headers;
    }

    /**
     * index
     * 
     * retorn promisse com comunicação para retorno de uma colecao
     * @param {*} id_colecao 
     */
    async get(url) {

        return await this._resource.get(url,this.getBaseHeaders())
        .then(res => res.json());

    }

    /**
     * post
     * 
     * realiza autenticacao e retorno de token
     * 
     * @param Object dataPost 
     */
     async post(url,data){
        
        return await this._resource.post(url,data,this.getBaseHeaders())
        .then(
            res => {
                console.log("service::post - iniciar success");
                return res.json();
            },
            err => {
                console.log("service::post - iniciar error");
                console.debug(err);
                throw Error("Erro ao inserir : " + err.bodyText);
            }
        );	
	}

    /**
     * auth
     * 
     * realiza autenticacao e retorno de token
     * 
     * @param Object dataPost 
     */
     async patch(url,data){

        return await this._resource.patch(url,data,this.getBaseHeaders())
        .then(
            res => {
                console.log("service::patch - iniciar success");
                return res.json();
            },
            err => {
                console.log("service::patch - iniciar error");
                console.debug(err);
                throw Error("Erro ao atualizar : " + err.bodyText);
            }
        );	
	}

}