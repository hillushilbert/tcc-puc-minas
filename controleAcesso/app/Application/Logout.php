<?php 

namespace App\Application;

use App\Application\Interfaces\ILogout;
use App\Application\Interfaces\IRefreshToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Logout implements ILogout {


    public function execute(Request $request) : \Illuminate\Http\Client\Response
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];

        $url = 'http://keycloak:8080/auth/realms/experimental/protocol/openid-connect/logout';

        $data = [
            "refresh_token"=>$request->refresh_token,
            // 'grant_type'=>'refresh_token',
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