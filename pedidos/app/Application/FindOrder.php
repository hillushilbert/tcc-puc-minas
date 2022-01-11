<?php 

namespace App\Application;

use App\Application\Interfaces\IFindOrder;
use App\Models\Order;
use Illuminate\Support\Facades\Http;

class FindOrder implements IFindOrder {


    public function execute($id) : Order
    {
        $order = Order::findOrFail($id);
        
        if($order->codigo_rastreamento)
        {
            // trocar logica para solicitar atualizacao do pedido via fila
            
            /*
            $headers = [
                'content-Type' => 'application/json',
                'accept' => 'application/json',
            ];

            $url = env('API_SGE').'/api/entrega/'.$order->codigo_rastreamento;

            $response = Http::withHeaders($headers)
                            ->get($url);

            $roteamento = $response->json() ?? null;
            if($roteamento){
                unset($roteamento['dados_pedido']);
            }
            $order->roteamento = $roteamento;
            */      
        }
        
        return $order;
    }
}