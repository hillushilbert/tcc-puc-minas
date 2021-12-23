<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ClientesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //
    public function index()
    {
        $clientes = Cliente::get();
        return response()->json(['data'=>$clientes],200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nome' => 'required',
            'email' => 'required|email|unique:clientes',
            'cpfOuCnpj' => 'required|unique:clientes',
            'tp_pessoa' => ['nullable',Rule::in(['F', 'J']),],
        ]);

        $requestData = $request->all();

        $id = Cliente::create($requestData);

        return response()->json(['data'=>$id,'user_id' => Auth::id()],201);
    }
}
