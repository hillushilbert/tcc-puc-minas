<?php

namespace App\Http\Controllers\Api;

use App\Application\Interfaces\IStoreEntrega;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewOrderRequest;
use App\Models\Entrega;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntregaController extends Controller
{

    public $storeEntrega;

    public function __construct(IStoreEntrega $storeEntrega)
    {
        $this->storeEntrega = $storeEntrega;
    }

    //
    public function index(Request $request)
    {
        $entregas = Entrega::paginate(25);
        return response()->json($entregas);
    }

    //
    public function show(Request $request,$id)
    {
        $entrega = Entrega::where('codigo_rastreamento',$id)->firstOrFail();
        $entrega->status;
        $entrega->roteiro;
        return response()->json($entrega);
    }

    public function store(NewOrderRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $entrega = $this->storeEntrega->execute($request);
            DB::commit();
            
            return response()->json(['data'=>['codigo_rastreamento'=>$entrega->codigo_rastreamento]],201);
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return response()->json(['error'=>$e->getMessage()],400);
        }
    }
}
