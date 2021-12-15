<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class AuthTokenKeycloakCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:auth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $access_token = $this->getAccessToken();
        $this->info("access_token : ".$access_token);

        $orders = $this->getOrders($access_token);
        dump($orders);
        return Command::SUCCESS;
    }

    public function getOrders($access_token){
        $headers = [
            "Accept"=>"application/json",
            // "Authorization" => "Bearer ".$access_token
        ];

        $url = 'http://kong:8000/pedidos/orders';

        $access_token = '';
        $response = Http::withHeaders($headers)
                        ->get($url);

        // dump($response->dump());
        $access_token = $response->json()?? [];
        return $access_token;        
    }

    public function getAccessToken() : string {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];

        $url = 'http://keycloak:8080/auth/realms/experimental/protocol/openid-connect/token';

        $data = [
            "username"=>"test",
            "password"=>"test123",
            'grant_type'=>'password',
            "client_id"=>"app",
        ];

        $access_token = '';
        $response = Http::withHeaders($headers)
                        ->asForm()
                        ->post($url,$data);

        // dump($response->dump());
        $access_token = $response->json()['access_token'] ?? '';
        return $access_token;
    }
}
