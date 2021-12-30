<?php 

namespace App\Application\Interfaces;

use Illuminate\Http\Request;
use App\Models\Cliente;

interface IClientesService {

    public function listaClientesAtivos();

    public function salvaCliente(Request $cliente, int $id = null) : int;

    public function buscarClientePorCpfOuCnpj(string $cpf) : Cliente;

}