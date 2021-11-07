<?php 

namespace App\Application\Interfaces;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;

interface IListOrder {

    public function execute();
}
