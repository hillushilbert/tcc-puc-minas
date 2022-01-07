<?php

namespace App\Http\Controllers\Api;

use App\Application\Interfaces\IAuthToken;
use App\Application\Interfaces\IRefreshToken;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthTokenRequest;
use App\Http\Requests\RefreshTokenRequest;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    
    protected $authToken;
    protected $refreshToken;

    public function __construct(IAuthToken $authToken, IRefreshToken $refreshToken)
    {
        $this->authToken = $authToken;
        $this->refreshToken = $refreshToken;
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
        return response($response->json(),$response->status());  
    }

    public function refresh_token(RefreshTokenRequest $request)
    {
        $response = $this->refreshToken->execute($request);
        return response($response->json(),$response->status());  
    }


}