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

    refresh_token(dataPost){

        console.log("UserService.refresh_token");
       
        return this._resource.post('auth/refresh_token',dataPost)
                             .then(res => res.json());                    
    }


    async logout(dataPost){

        console.log("UserService.logout");
       
        return await this._resource.post('auth/logout',dataPost);                    
    }


    parseJwt () 
    {
        let token = localStorage.getItem('access_token');
        
        if(token == null || token == undefined) return null;

        var base64Url = token.split('.')[1];
        var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
        var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
            return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        }).join(''));
    
        return JSON.parse(jsonPayload);
    };


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
            
                console.log("Usu??rio online:");
        }
        else
        {
            console.log("Usu??rio cache:");
            usuario = JSON.parse(localStorage.getItem('user'));
        }
        console.debug(usuario);
        
        return usuario;
    }

}
