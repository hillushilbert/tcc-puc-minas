
export default class Service {

    constructor(resource) {

        this._resource = resource;
                
        this.user = JSON.parse(localStorage.getItem('user'));

        // mata sessão, caso nao tenha o campo api_token
        if(this.user == null || this.user.api_token == undefined){
            console.log("sem api_token");
            this._headers = {
                'Access-Control-Allow-Origin': '*',
            };
        }else{
            this._headers = {
                headers: {
                    'Access-Control-Allow-Origin': '*',
                    'Authorization' :"Bearer "+this.user.api_token
                }
            }            
        } 

    }

}