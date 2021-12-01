import Empresa from './Empresa.js';

export default class User {

    constructor(id=0, name='', email = '') {

        this.id = id;
        this.name = name;
        this.email = email;
        this.favorite = false;
        this.foto = null;
        this.id_nivel_pontuacao = 1;
        this.perfil = {
            nome : 'Perfil',
            id: 1
        };

        this.empresa = new Empresa();
    }
}