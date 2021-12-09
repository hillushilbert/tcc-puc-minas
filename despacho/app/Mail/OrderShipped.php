<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $codigo_rastreamento;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order,string $codigo_rastreamento)
    {
        //
        $this->order = $order;
        $this->codigo_rastreamento = $codigo_rastreamento;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                ->from('contato@boaentrega.com.br','Atendimento Boa Entrega')
                ->subject('Novo pedido enviado')
                ->markdown('emails.orders.shipped');
    }
}
