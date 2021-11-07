<?php

namespace App\Http\Interfaces;

use App\Models\Order;

interface IOrderRepository
{
    public function persist(Order $order);
    
    public function findById(int $id);

    public function delete(Order $order);

    public function find(int $id);

    public function factory(array $data): Order;

}