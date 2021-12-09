<?php 

namespace App\Factory;

use PhpAmqpLib\Connection\AMQPStreamConnection;

abstract class AMQPFactory 
{
    public static function getConnection() : AMQPStreamConnection
    {
        $connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST','rabbit'), 
            env('RABBITMQ_PORT',5672), 
            env('RABBITMQ_USER','guest'), 
            env('RABBITMQ_PASSWORD','guest'),
            env('RABBITMQ_VHOST','AppHubb')
        );

        return $connection;
    }

}