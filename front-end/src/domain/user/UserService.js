import Service from '../Service.js';

export default class UserService extends Service {

    constructor(resource) {
        super(resource);
    }

    /**
     * auth
     * 
     * realiza autenticacao e retorno de token
     * 
     * @param Object dataPost 
     */
     async auth(dataPost){

		let url = 'auth/token';
        
        return await this._resource.post(url,dataPost)
        .then(res => {
            return res.json();
        },
        err => {
            console.log("UserService:: auth error");
            console.debug(err.json());
            return err.json();
        })
        ; 
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
