
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

}