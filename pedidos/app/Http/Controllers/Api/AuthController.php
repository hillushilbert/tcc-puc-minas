<?php

namespace App\Http\Controllers\Api;

use App\Application\Interfaces\IAuthToken;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthTokenRequest;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    
    public $authToken;

    public function __construct(IAuthToken $authToken)
    {
        $this->authToken = $authToken;
    }

    /**
     * @OA\Post(
     *     path="/api/auth/token",
     *     description="Retorna JWT Acess Token",
     *      tags={"Auth"},
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
    public function token(AuthTokenRequest $request)
    {
        $response = $this->authToken->execute($request);
        // dump($response); 
        return response($response->json(),200);  
    }


}