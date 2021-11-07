<?php 

namespace App\Application\Interfaces;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;

interface IStoreOrder {

    public function execute(StoreOrderRequest $request);
}
