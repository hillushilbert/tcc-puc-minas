<?php 

namespace App\Application;

use App\Application\Interfaces\IClientesSender;
use App\Application\Interfaces\IClientesService;
use App\Http\Interfaces\IClientesRepository;
use Illuminate\Http\Request;
use App\Models\Cliente;

class ClientesService implements IClientesService {

    protected $clientesRepository;
    protected $clientesSender;

    public function __construct(IClientesRepository $clientesRepository, IClientesSender $clientesSender)
    {
        $this->clientesRepository = $clientesRepository;
        $this->clientesSender = $clientesSender;
    }

    public function listaClientesAtivos()
    {
        return $this->clientesRepository->getAll();
    }

    public function salvaCliente(Request $cliente,int $id = null) : int 
    {
        $newCliente  = $this->clientesRepository->save($cliente->all(),$id);
        $this->clientesSender->createQueue();
        $this->clientesSender->createChannel();
        $this->clientesSender->sendMensage(json_encode($newCliente->toJson()));
        return $newCliente->id;
    }

    public function buscarClientePorCpfOuCnpj(string $cpfOuCnpj) : Cliente
    {
        return $this->clientesRepository->getById($cpfOuCnpj);
    }

}