<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SupplierController extends Controller
{
    

    /**
     * @OA\Get(
     *     path="/api/suppliers",
     *     description="Retorna a lista de usuarios",
     *      tags={"Domain"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Supplier")
     *         ),
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
        $query = new Supplier(); 
        $customer = $query->paginate(25);
        return response()->json($customer);
    }


    /**
     * @OA\Get(
     *     path="/api/suppliers/{id}",
     *     description="Retorna um Fornecedor por id",
     *     tags={"Domain"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id do fornecedor",
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
     *         @OA\JsonContent()
     *     )
     * )
     */ 
    public function show(Request $request,$id)
    {
        $supplier = Supplier::findOrFail($id); 
        return response()->json(['data'=>$supplier],200);
    }

    /**
     * @OA\Post(
     *     path="/api/suppliers",
     *     operationId="storeSupplier",
     *     description="Armazena um novo fornecedor",
     *     security={{"bearerAuth":{}}},
     *     tags={"Domain"},
     *     @OA\RequestBody(
     *         description="Pet object that needs to be added to the store",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Supplier"),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/Supplier")
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
            ]);

            
            $find = $request->only(['email']);
            $customer = Supplier::firstOrNew($find);

            $requestData = $request->only(['email','name']);
            
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
     *     path="/api/suppliers/{id}",
     *     operationId="updateSupplier",
     *     description="Atualiza um fornecedor",
     *     security={{"bearerAuth":{}}},
     *     tags={"Domain"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id do fornecedor",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Objeto Forncedor a ser atualizado",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Supplier"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/Supplier")
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

            
            $customer = Supplier::findOrFail($id);

            $requestData = $request->only(['email','name']);
            
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



/**
     * @OA\Delete(
     *     path="/api/suppliers/{id}",
     *     operationId="deleteSupplier",
     *     description="Exclui um fornecedor",
     *     security={{"bearerAuth":{}}},
     *     tags={"Domain"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id do fornecedor",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="OK",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Missing Data",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function destroy(Request $request,$id)
    {
        Supplier::destroy($id);
        return response()->json(['data'=>['success'=>true]], 204);
    } 

}