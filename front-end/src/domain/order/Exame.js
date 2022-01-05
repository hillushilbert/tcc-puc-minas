// alurapic/src/domain/foto/Foto.js

import User from '../user/User.js';
import Quizz from '../quizz/Quizz.js';

export default class Exame {

    constructor(user=new User(), quizz=new Quizz) {

        this.user = user;
        this.quizz = quizz;
        this.respostas = [
            {
                id: '',
                id_exame: 0,
                id_pergunta: 0,
                id_alternativa: 0,
                correta: 'N'
            }
        ];
    }
}