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

    protected $clientesService;

    protected $rules;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(IClientesService $clientesService)
    {
        //
        $this->clientesService = $clientesService;

        $this->rules = [
            'nome' => 'required',
            'email' => 'required|email|unique:clientes,email',
            'cpfOuCnpj' => 'required|unique:clientes,cpfOuCnpj',
            'tp_pessoa' => ['nullable',Rule::in(['F', 'J']),],
        ];
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

    public function store(Request $request)
    {
        $this->validate($request,$this->rules);

        $cliente = $this->clientesService->salvaCliente($request);

        return response()->json(['data'=>$cliente,'user_id' => Auth::id()],201);
    }

    public function update(Request $request,$id)
    {
        $rules = $this->rules;
        $rules['email'] .= ",".$id;
        $rules['cpfOuCnpj'] .= ",".$id;
        $this->validate($request,$rules);

        $cliente = $this->clientesService->salvaCliente($request,$id);

        return response()->json(['data'=>$cliente,'user_id' => Auth::id()],200);
    }
}
