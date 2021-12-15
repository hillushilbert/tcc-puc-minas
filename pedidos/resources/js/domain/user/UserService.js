import { readyException } from "jquery";

export default class UserService {

    constructor(resource) {

        this._resource = resource;
        this.user = null;

        if(localStorage.getItem('user') !== null && localStorage.getItem('user').length > 0)
        {
            this.user = JSON.parse(localStorage.getItem('user'));

            // mata sessão, caso nao tenha o campo api_token
            if(this.user.access_token){
                this._headers = {
                    headers: {
                        'Authorization' :"Bearer "+this.user.access_token
                    }
                }        
            }
        }
        

    }

    /**
     * reposta
     * 
     * realiza post para salvar a resposta de um estudo
     * 
     * @param Object dataPost 
     */
    login(dataPost){

		let url = '/auth/token';
        
        if(!dataPost._token){
            dataPost._token = $('meta[name="csrf-token"]').attr('content'); 
        }

        return this._resource.post(url,dataPost)
        .then(res => {
            //console.debug(res.body);  
            //card.favorito = res.body;            
            return res.json();
        }); 
    }

    refresh_token(){

        console.log("UserService.refresh_token");
       
        return this._resource.get('/refresh_token')
                .then(res => res.json()).
                then(res=>{
                    $('meta[name="csrf-token"]').attr('content', res.token);
                    console.log("novo tolen csrf-token");
                    console.debug( res.token);
                });                    
    }


    /**
     * reposta
     * 
     * realiza post para salvar a resposta de um estudo
     * 
     * @param Object dataPost 
     */
    logout(dataPost){

		let url = '/logout';
        
        if(!dataPost._token){
            dataPost._token = $('meta[name="csrf-token"]').attr('content'); 
        }

        localStorage.removeItem('user');

        return this._resource.post(url,dataPost);
        
    }

    

    async get(){
        
        console.log("UserService.get");

        var usuario  = null;
        console.log("localStorage::user");
        

        if(localStorage.getItem('user') === null || localStorage.getItem('user').length == 0)
        {   

            let response = await this._resource.get('/app/usuario');
            let json = await response.json();
            usuario = await Promise.resolve(json).then(user => user);
            localStorage.setItem('user', JSON.stringify(usuario));
            localStorage.setItem('logo', usuario.empresa.logo);
            localStorage.setItem('login_with_google', usuario.empresa.login_with_google);
            
                console.log("Usuário online:");
        }
        else
        {
            console.log("Usuário cache:");
            usuario = JSON.parse(localStorage.getItem('user'));
        }
        console.debug(usuario);
        
        return usuario;
    }

}
