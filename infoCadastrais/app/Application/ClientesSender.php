<?php 

namespace App\Application;

use App\Application\Interfaces\IClientesSender;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class ClientesSender implements IClientesSender {

    protected $connection;

    protected $channel;
    
    public function createQueue(){

        $connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST','rabbit'), 
            env('RABBITMQ_PORT',5672), 
            env('RABBITMQ_USER','app_pedido'), 
            env('RABBITMQ_PASSWORD','app_pedido'),
            env('RABBITMQ_VHOST','boaentrega.pedidos')
        );

        $this->connection = $connection;
    }

    public function createChannel()
    {
        $queue_clientes = env('RABBITMQ_QUEUE_CLIENTES','boaentrega.clientes.novo');
        $exchange = env('RABBITMQ_EXCHANGE');

        $channel = $this->connection->channel();
        $channel->exchange_declare($exchange, 'direct', false, true, false);

        $channel->queue_declare($queue_clientes, false, true, false, false, false);

        $channel->queue_bind($queue_clientes, $exchange, $queue_clientes);

        $this->channel = $channel;
    }

    public function sendMensage(string $message)
    {
        if(!$this->connection)
        throw new \Exception("Conexão com MessageBroker ainda não foi estabelecida");

        if(!$this->channel)
        throw new \Exception("Fila do MessageBroker ainda não foi criada");
    
        $exchange = env('RABBITMQ_EXCHANGE');
        $queue_clientes = env('RABBITMQ_QUEUE_CLIENTES','boaentrega.clientes.novo');

        $msg = new AMQPMessage($message,['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
        $this->channel->basic_publish($msg, $exchange,$queue_clientes);
        
        $this->channel->close();
        
        $this->connection->close();
        
    }

}