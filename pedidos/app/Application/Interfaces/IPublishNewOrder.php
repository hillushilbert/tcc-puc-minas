<?php 

namespace App\Application\Interfaces;

use App\Models\Order;

interface IPublishNewOrder {

    public function send(Order $order);
}
