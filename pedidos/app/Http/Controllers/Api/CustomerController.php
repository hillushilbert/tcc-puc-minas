<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Leverempresa;
use App\Models\Leverlote as LeverLote;
use App\Models\Leveroperacao;
use App\Models\Leveroperadora;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Info(title="Sin-ticketing", version="0.1")
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
class CustomerController extends Controller
{
    

    /**
     * @OA\Get(
     *     path="/api/usuario",
     *     description="Retorna a lista de usuarios",
     *      tags={"Usuario"},
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
        $query = new Customer(); 
        $customer = $query->paginate(25);
        return response()->json($customer);
    }

    public function show(Request $request,$id)
    {
        $customer = Customer::findOrFail($id); 
        return response()->json($customer);
    }

    /**
     * @OA\Post(
     *     path="/api/usuario",
     *     operationId="storeUsuario",
     *     description="Armazena um novo usuario",
     *     security={{"bearerAuth":{}}},
     *     tags={"Usuario"},
     *     @OA\RequestBody(
     *      @OA\JsonContent(
     *        type="object",
     *        @OA\Property(property="codigo", type="string"),
     *        @OA\Property(property="nome", type="string"),
     *        @OA\Property(property="email", type="string"),
     *        @OA\Property(property="status", type="string"),
     *        @OA\Property(property="permissao", type="string"),
     *        @OA\Property(property="grupoEconomico", type="string"),
     *        @OA\Property(property="criadoEm", type="string"),
     *        @OA\Property(property="atualizadoEm", type="string"),
     *      )
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
    public function store(Request $request)
    {
        try
		{
			$this->validate($request, [
                'email'       => 'required|max:255',
                'name'       => 'required|max:255',
                'birth_date' => 'required'
            ]);

            
            $find = $request->only(['email']);
            $customer = Customer::firstOrNew($find);

            $requestData = $request->only(['email','name','birth_date']);
            
            $customer->fill($requestData);
            $customer->save();

            
            return response()->json(['data'=>$customer], 201);
		}
        catch(\Illuminate\Database\QueryException $e)
        {
            DB::rollBack();
			return response()->json(['errors'=>$e->getMessage()], 400);
		}
        catch(\Illuminate\Validation\ValidationException $e)
        {
        	return response()->json(['errors'=>$e->errors()], 422);
		}
        catch (\Exception $e)
        {
            DB::rollBack();
		    return response()->json(['errors'=>$e->getMessage()], 400);
        }
    }

    public function update(Request $request,$id)
    {
        try
		{
			$this->validate($request, [
                'email'       => 'required|max:255',
                'name'       => 'required|max:255',
                'birth_date' => 'required'
            ]);

            
            $customer = Customer::findOrFail($id);

            $requestData = $request->only(['email','name','birth_date']);
            
            $customer->update($requestData);
            
            return response()->json(['data'=>$customer], 200);
		}
        catch(\Illuminate\Database\QueryException $e)
        {
            DB::rollBack();
			return response()->json(['errors'=>$e->getMessage()], 400);
		}
        catch(\Illuminate\Validation\ValidationException $e)
        {
        	return response()->json(['errors'=>$e->errors()], 422);
		}
        catch (\Exception $e)
        {
            DB::rollBack();
		    return response()->json(['errors'=>$e->getMessage()], 400);
        }
    } 

    public function destroy(Request $request,$id)
    {
        Customer::destroy($id);
        return response()->json(['data'=>['success'=>true]], 204);

    } 

}