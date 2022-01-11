<?php 

namespace App\Application;

use App\Factory\AMQPFactory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use stdClass;

class InformarRoteamentoPedido {


    public function __construct()
    {
        
    }

    public function send(int $orderId, string $codigo_rastreamento)
    {
        $payload = new stdClass;
        $payload->orderId = $orderId;
        $payload->codigo_rastreamento = $codigo_rastreamento;
        $payload->roteamento = $this->getRoteamento($codigo_rastreamento);


        Log::info("enviando mensagem para o rabbit");

        $exchange = env('RABBITMQ_EXCHANGE');
              
        $connection = AMQPFactory::getConnection();

        $queue_pedido_novo = env('RABBITMQ_QUEUE_ROTEAMENTO','boaentrega.pedidos.roteamento');

        $channel = $connection->channel();
        $channel->exchange_declare($exchange, 'direct', false, true, false);

        // $channel->queue_declare($op->operadora->fila, false, true, false, false);
        $channel->queue_declare($queue_pedido_novo, false, true, false, false, false);

        $channel->queue_bind($queue_pedido_novo, $exchange, $queue_pedido_novo);

        $message = json_encode($payload);

        $msg = new AMQPMessage($message,['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
        // $channel->basic_publish($msg, '', $op->operadora->fila);
        $channel->basic_publish($msg, $exchange,$queue_pedido_novo);
        
        $channel->close();
        
        $connection->close();
    }


    private function getRoteamento($codigo_rastreamento)
    {
        $headers = [
            'content-Type' => 'application/json',
            'accept' => 'application/json',
        ];

        $url = env('API_SGE').'/api/entrega/'.$codigo_rastreamento;

        $response = Http::withHeaders($headers)
                        ->get($url);

        $roteamento = $response->json() ?? null;
        
        if($roteamento){
            unset($roteamento['dados_pedido']);
        }

        return $roteamento;
    }
}