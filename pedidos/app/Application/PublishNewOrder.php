<?php

namespace App\Application;

use App\Application\Interfaces\IPublishNewOrder;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use App\Models\Order;
use PhpAmqpLib\Wire\AMQPTable;

class PublishNewOrder implements IPublishNewOrder 
{

    public function send(Order $order)
    {
 
        $exchange = env('RABBITMQ_EXCHANGE');
              
        $connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST','rabbit'), 
            env('RABBITMQ_PORT',5672), 
            env('RABBITMQ_USER','guest'), 
            env('RABBITMQ_PASSWORD','guest'),
            env('RABBITMQ_VHOST','boaentrega.pedidos')
        );

        $queue_pedido_novo = env('RABBITMQ_QUEUE_PEDIDOS','boaentrega.pedidos.novo');

        $channel = $connection->channel();
        $channel->exchange_declare($exchange, 'direct', false, true, false);

        // $channel->queue_declare($op->operadora->fila, false, true, false, false);
        $channel->queue_declare($queue_pedido_novo, false, true, false, false, false);

        $channel->queue_bind($queue_pedido_novo, $exchange, $queue_pedido_novo);

        $message = json_encode($order->exportToJson());

        $msg = new AMQPMessage($message,['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
        // $channel->basic_publish($msg, '', $op->operadora->fila);
        $channel->basic_publish($msg, $exchange,$queue_pedido_novo);
        
        $channel->close();
        
        $connection->close();

    }
}