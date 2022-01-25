<?php

namespace App\Http\Controllers;

use App\Application\Interfaces\IAuthToken;
use App\Application\Interfaces\ILogout;
use App\Application\Interfaces\IRefreshToken;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    
    protected $authToken;
    protected $refreshToken;
    protected $logout;

    public function __construct(IAuthToken $authToken, IRefreshToken $refreshToken, ILogout $logout)
    {
        $this->authToken = $authToken;
        $this->refreshToken = $refreshToken;
        $this->logout = $logout;
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
    public function token(Request $request)
    {
        $this->validate($request,[
            'email' => 'required',
            'password' => 'required',
        ]);

        $response = $this->authToken->execute($request);
        return response($response->json(),$response->status());  
    }

    public function refresh_token(Request $request)
    {
        $this->validate($request,[
            'refresh_token' => 'required',
        ]);


        $response = $this->refreshToken->execute($request);
        return response($response->json(),$response->status());  
    }

    public function logout(Request $request)
    {
        $this->validate($request,[
            'refresh_token' => 'required',
        ]);


        $response = $this->logout->execute($request);
        return response($response->json(),$response->status());  
    }


}