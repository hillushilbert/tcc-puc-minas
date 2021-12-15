<?php 

namespace App\Application;

use App\Application\Interfaces\IAuthToken;
use App\Http\Requests\AuthTokenRequest;
use Illuminate\Support\Facades\Http;

class AuthToken implements IAuthToken {


    public function execute(AuthTokenRequest $request) : \Illuminate\Http\Client\Response
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];

        $url = 'http://keycloak:8080/auth/realms/experimental/protocol/openid-connect/token';

        $data = [
            "username"=>$request->email,
            "password"=>$request->password,
            'grant_type'=>'password',
            "client_id"=>"app",
        ];

        // $access_token = '';
        $response = Http::withHeaders($headers)
                        ->asForm()
                        ->post($url,$data);

        return $response;
    }

}