<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clientes';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
        'razao_social',
        'sexo',
        'data_nascimento',
        'tp_pessoa',
        'cpfOuCnpj',
        'email',
        'telefone',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'uf',
        'cep',
    ];

    public function isPessoaFisica(){
        return ($this->tp_pessoa == 'F') ? true : false;
    }

    public function isPessoaJuridica(){
        return ($this->tp_pessoa == 'J') ? true : false;
    }


}
