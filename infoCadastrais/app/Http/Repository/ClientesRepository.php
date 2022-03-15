<?php 

namespace App\Http\Repository;

use App\Http\Interfaces\IClientesRepository;
use App\Models\Cliente;

class ClientesRepository implements IClientesRepository {

    
    public function getAll(){
        $clientes = Cliente::OrderBy('id','desc')->get();
        return $clientes;
    }

    public function getById(string $id) : ?Cliente
    {
        $cliente = Cliente::where('cpfOuCnpj',$id)->first();
        return $cliente;
    }

    public function save(array $resquestData, int $id = null) : Cliente
    {
        if($id){
            $cliente = Cliente::findOrFail($id);
        }else{
            $cliente = Cliente::firstOrNew(['cpfOuCnpj'=>$resquestData['cpfOuCnpj']]);
        }
        
        $cliente->fill($resquestData);
        $cliente->save();
        return $cliente;
    }

}