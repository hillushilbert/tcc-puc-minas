<?php 

namespace App\Application\Interfaces;

use App\Http\Requests\StoreClienteRequest;
use App\Models\Cliente;

interface IClientesService {

    public function listaClientesAtivos();

    public function salvaCliente(StoreClienteRequest $cliente) : int;

    public function buscarClientePorCpfOuCnpj(string $cpf) : Cliente;

}