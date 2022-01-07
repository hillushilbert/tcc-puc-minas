<?php 

namespace App\Application;

use App\Application\Interfaces\IAuthToken;
use App\Application\Interfaces\IRefreshToken;
use App\Http\Requests\AuthTokenRequest;
use App\Http\Requests\RefreshTokenRequest;
use Illuminate\Support\Facades\Http;

class RefreshToken implements IRefreshToken {


    public function execute(RefreshTokenRequest $request) : \Illuminate\Http\Client\Response
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];

        $url = 'http://keycloak:8080/auth/realms/experimental/protocol/openid-connect/token';

        $data = [
            "refresh_token"=>$request->refresh_token,
            'grant_type'=>'refresh_token',
            "client_id"=>"app",
            'client_secret'=>'335fe75e-19cd-4d52-8c24-7972f8f78b9b'
        ];

        // $access_token = '';
        $response = Http::withHeaders($headers)
                        ->asForm()
                        ->post($url,$data);

        return $response;
    }

}