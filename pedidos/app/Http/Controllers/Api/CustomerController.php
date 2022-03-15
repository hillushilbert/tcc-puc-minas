<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CustomerController extends Controller
{
    

    /**
     * @OA\Get(
     *     path="/api/customer",
     *     operationId="indexCustomer",
     *     description="Retorna a lista de usuarios",
     *      tags={"Domain"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Customer")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Missing Data",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorModel")
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = new Customer(); 
        $customer = $query->paginate(25);
        return response()->json($customer);
    }


    /**
     * @OA\Get(
     *     path="/api/customer/{id}",
     *     operationId="showCustomer",
     *     description="Retorna um Cliente por id",
     *     tags={"Domain"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id do cliente",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="successful operation",
     *     @OA\JsonContent(ref="#/components/schemas/Supplier"),
     * ),
     *     @OA\Response(
     *         response=422,
     *         description="Missing Data",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorModel")
     *     )
     * )
     */ 
    public function show(Request $request,$id)
    {
        $customer = Customer::findOrFail($id); 
        return response()->json(['data'=>$customer],200);
    }

    /**
     * @OA\Post(
     *     path="/api/customer",
     *     operationId="storeCustomer",
     *     description="Armazena um novo cliente",
     *     security={{"bearerAuth":{}}},
     *     tags={"Domain"},
     *     @OA\RequestBody(
     *         description="Dados do novo cliente em formato JSON",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Customer"),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Missing Data",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorModel")
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

            
            return response()->json(['data'=>$customer->id], 201);
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


    /**
     * @OA\Patch(
     *     path="/api/customer/{id}",
     *     operationId="updateCustomer",
     *     description="Atualiza um cliente",
     *     security={{"bearerAuth":{}}},
     *     tags={"Domain"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id do cliente",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Objeto Cliente a ser atualizado",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Customer"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Missing Data",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorModel")
     *     )
     * )
     */
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