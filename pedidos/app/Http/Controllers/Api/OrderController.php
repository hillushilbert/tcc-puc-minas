<?php

namespace App\Http\Controllers\Api;

use App\Application\Interfaces\IListOrder;
use App\Application\Interfaces\IStoreOrder;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Info(title="API Pedidos", version="0.1")
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
 */
class OrderController extends Controller
{
    
    private $storeOrder;
    
    public function __construct(IStoreOrder $storeOrder, IListOrder $listOrder)
    {
        $this->storeOrder = $storeOrder;
        $this->listOrder = $listOrder;
    }

    /**
     * @OA\Get(
     *     path="/api/orders",
     *     description="Retorna uma lista de pedidos",
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
     *     path="/api/orders/{id}",
     *     description="Retorna um pedido por id",
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
        $order = Order::findOrFail($id);
        return response(['data'=>$order->exportToJson()],200);
    }

    /**
     * @OA\Post(
     *     path="/api/orders",
     *     operationId="storeOrder",
     *     description="Armazena um novo pedido",
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

    public function update()
    {
        return abort(405,'Não implementado');
    } 

    public function delete()
    {
        return abort(405,'Não implementado');
    } 

}