<?php 

namespace App\Application;

use App\Application\Interfaces\IAuthToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthToken implements IAuthToken {


    public function execute(Request $request) : \Illuminate\Http\Client\Response
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
            'client_secret'=>'335fe75e-19cd-4d52-8c24-7972f8f78b9b'
        ];

        // $access_token = '';
        $response = Http::withHeaders($headers)
                        ->asForm()
                        ->post($url,$data);

        return $response;
    }

}