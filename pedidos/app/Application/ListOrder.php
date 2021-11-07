<?php

namespace App\Application;

use App\Application\Interfaces\IListOrder;
use App\Application\Interfaces\IStoreOrder;
use App\Http\Interfaces\IAdressRepository;
use App\Http\Interfaces\ICustomerRepository;
use App\Http\Interfaces\IOrderRepository;
use App\Http\Interfaces\ISupplierRepository;
use App\Http\Requests\StoreOrderRequest;

class ListOrder implements IListOrder
{
    private $orderRepository;

    public function __construct(IOrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function execute()
    {
        $return = [];
        $orders = $this->orderRepository->find(0);
        foreach($orders as $order)
        {
            $order->customer;
            $order->supplier;
            $order->origin;
            $order->destiny;
            $record = json_decode($order->toJson());
            unset($record->customer_id);
            unset($record->origin_adress_id);
            unset($record->destination_adress_id);
            unset($record->supplier_id);
            $return[] = $record;
        }
        return $return;
    }
}