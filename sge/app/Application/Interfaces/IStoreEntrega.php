<?php 

namespace App\Application\Interfaces;

use App\Http\Requests\NewOrderRequest;
use App\Models\Entrega;

interface IStoreEntrega {

    public function execute(NewOrderRequest $request) : Entrega;
}