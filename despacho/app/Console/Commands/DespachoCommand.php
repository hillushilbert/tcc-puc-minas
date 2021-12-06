<?php

namespace App\Console\Commands;

use App\Factory\AMQPFactory;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Wire\AMQPTable;

class DespachoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:despacho';

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
        $connection = AMQPFactory::getConnection();

        $channel = $connection->channel();
        $channel->exchange_declare(env('RABBITMQ_EXCHANGE'), 'direct', false, true, false);
        
        $task_queue = env('RABBITMQ_QUEUE_NOVOS_PEDIDOS');

        $channel->queue_declare($task_queue, false, true, false, false, false);

        // $channel->queue_bind($task_queue, env('RABBITMQ_EXCHANGE'));
        $channel->queue_bind($task_queue, env('RABBITMQ_EXCHANGE'), $task_queue);
        
        Log::info(" [*] Queue : ".$task_queue);
        Log::info(" [*] Waiting for messages. To exit press CTRL+C");
        
        $callback2 = function ($msg) use ($task_queue)
        {                
            try
            {
                Log::info(' [x] Received '. $msg->body);
                // $payload->execute_selenium = false;
                $response = Http::post('http://sge.boaentrega.com.br/api/entrega', $msg->body);
                if($response->status() == 201){
                    $msg->ack();
                    $codigo_rastreamento = $response()->json()->data->codigo_rastreamento;
                                      
                }else{
                    throw new Exception($response->body());
                }
                Log::info(" [x] Done");
            }
            catch(\Exception $e)
            {
                $msg->nack();
                Log::error($task_queue."|".$msg->body."|".$e->getMessage()."|".$e->getFile().":".$e->getLine());
            }
        };
        
        $channel->basic_qos(null, 1, null); // avisa ao rabbitmq que nao envie uma nova mensagem a este worker 
        // até ele ter processando, fazendo com que uma nova mensagem seja entregue a um outro worker

        // no_act = false, para dizer que a mensagem só pode ser removida apos configuracao de leitura
        $channel->basic_consume($task_queue, '', false, false, false, false, $callback2);

        while ($channel->is_open()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();

        return Command::SUCCESS;
    }
}
