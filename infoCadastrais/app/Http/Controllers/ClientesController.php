<?php

namespace App\Http\Controllers;

use App\Application\Interfaces\IClientesService;
use App\Http\Requests\StoreClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ClientesController extends Controller
{

    public $clientesService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(IClientesService $clientesService)
    {
        //
        $this->clientesService = $clientesService;
    }

    //
    public function index()
    {
        $data = $this->clientesService->listaClientesAtivos();
        return response()->json(['data'=>$data],200);
    }

    //
    public function show($id)
    {
        $data = $this->clientesService->buscarClientePorCpfOuCnpj($id);
        return response()->json(['data'=>$data],200);
    }

    public function store(StoreClienteRequest $request)
    {

        $cliente = $this->clientesService->salvaCliente($request);

        return response()->json(['data'=>$cliente,'user_id' => Auth::id()],201);
    }

    public function update(StoreClienteRequest $request)
    {

        $cliente = $this->clientesService->salvaCliente($request);

        return response()->json(['data'=>$cliente,'user_id' => Auth::id()],200);
    }
}
