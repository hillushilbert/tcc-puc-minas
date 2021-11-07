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


class CustomerController extends Controller
{
    

    /**
     * @OA\Get(
     *     path="/api/customer",
     *     description="Retorna a lista de usuarios",
     *      tags={"Usuario"},
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
     *     path="/api/customer",
     *     operationId="storeCustomer",
     *     description="Armazena um novo usuario",
     *     security={{"bearerAuth":{}}},
     *     tags={"Usuario"},
     *     @OA\RequestBody(
     *         description="Pet object that needs to be added to the store",
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