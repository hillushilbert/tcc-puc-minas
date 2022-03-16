<?php

namespace App\Http\Controllers\Api;

use App\Application\Interfaces\IFindOrder;
use App\Application\Interfaces\IListOrder;
use App\Application\Interfaces\IStoreOrder;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Info(title="API GSL", version="0.1")
 * 
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      in="header",
 *      name="Authorization",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 * ),
 * 
 * @OA\Server(
 *      url="http://localhost:8000",
 *      description="Homologacao"
 * ),
 * @OA\Server(
 *      url="http://185.187.169.252:8000",
 *      description="Apresentacao"
 * ),
 * 
 */
class OrderController extends Controller
{
    
    private $storeOrder;
    private $listOrder;
    private $findOrder;
    
    public function __construct(IStoreOrder $storeOrder, IListOrder $listOrder, IFindOrder $findOrder)
    {
        $this->storeOrder = $storeOrder;
        $this->listOrder = $listOrder;
        $this->findOrder = $findOrder;
    }

    /**
     * @OA\Get(
     *     path="/pedidos/orders",
     *     description="Retorna uma lista de solicitações de entrega",
     *      tags={"Order"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Missing Data",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function index(Request $request)
    {
        $order = $this->listOrder->execute();
        return response()->json($order);
    }


    /**
     * @OA\Get(
     *     path="/pedidos/orders/{id}",
     *     description="Retorna uma solicitação de entrega por id",
     *     tags={"Order"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id do pedido",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="successful operation",
     *     @OA\JsonContent(ref="#/components/schemas/Order"),
     * ),
     *     @OA\Response(
     *         response=422,
     *         description="Missing Data",
     *         @OA\JsonContent()
     *     )
     * )
     */    
    public function show($id)
    {
        $order = $this->findOrder->execute($id);
        return response(['data'=>$order->exportToJson()],200);
    }    
    
    /**
     * @OA\Get(
     *     path="/pedidos/orders/{codigo}/codigo_rastreamento",
     *     description="Retorna uma solicitação de entrega pelo codigo de rastreamento",
     *     tags={"Order"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="codigo",
     *         in="path",
     *         description="Código de rastreamento",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="successful operation",
     *     @OA\JsonContent(ref="#/components/schemas/Order"),
     * ),
     *     @OA\Response(
     *         response=422,
     *         description="Missing Data",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function showCodigoRastreamento($id)
    {
        $order = $this->findOrder->byCodigoRastreamento($id);
        
        if(!$order){
            return response(['message'=>'Código Rastreamento não encontrado'],404);
        }

        return response(['data'=>$order->exportToJson()],200);
    }

    /**
     * @OA\Post(
     *     path="/pedidos/orders",
     *     operationId="storeOrder",
     *     description="Armazena uma solicitação de entrega",
     *     security={{"bearerAuth":{}}},
     *     tags={"Order"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Order"),
     *    ),
     *     @OA\Response(
     *         response=201,
     *         description="OK",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Missing Data",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function store(StoreOrderRequest $request)
    {
        try
		{
            DB::beginTransaction();
            $order = $this->storeOrder->execute($request);
            DB::commit();
            
            return response()
                ->json([
                    'success' => true,
                    'id' => $order->id
                ]);
		}
        catch(\Illuminate\Database\QueryException $e)
        {
            DB::rollBack();
			return response()->json(['errors'=>$e->getMessage(),'file'=>$e->getFile(),'line'=>$e->getLine()], 400);
		}
        catch(\Illuminate\Validation\ValidationException $e)
        {
        	return response()->json(['errors'=>$e->errors()], 422);
		}
        catch (\Exception $e)
        {
            DB::rollBack();
		    return response()->json(['errors'=>$e->getMessage(),'file'=>$e->getFile(),'line'=>$e->getLine()], 400);
        }
    }


}