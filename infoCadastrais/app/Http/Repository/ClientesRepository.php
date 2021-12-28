<?php 

namespace App\Http\Repository;

use App\Http\Interfaces\IClientesRepository;
use App\Models\Cliente;

class ClientesRepository implements IClientesRepository {

    
    public function getAll(){
        $clientes = Cliente::get();
        return $clientes;
    }

    public function getById(string $id) : ?Cliente
    {
        $cliente = Cliente::where('cpfOuCnpj',$id)->first();
        return $cliente;
    }

    public function save(array $resquestData) : Cliente
    {
        $cliente = Cliente::firstOrNew(['cpfOuCnpj',$resquestData['cpfOuCnpj']]);
        $cliente->fill($resquestData);
        $cliente->save();
        return $cliente;
    }

}