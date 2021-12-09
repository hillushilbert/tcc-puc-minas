<?php

namespace App\Http\Repository;

use App\Http\Interfaces\IOrderRepository;
use App\Models\Order;

class OrderRepository implements IOrderRepository
{
    public function persist(Order $order){
        $order->save();
        return $order->id;
    }
    
    public function findById(int $id){
        return Order::find($id);
    }

    public function delete(Order $order){
        $order->delete();
    }

    public function find(int $id = null){
        if($id){
            return Order::where('id',$id)->orderBy('id','desc')->get();
        }else{
            return Order::orderBy('id','desc')->get();
        }
    }

    public function factory(array $data): Order
    {
        $order = new Order();
        $order->fill($data);
        return $order;
    }

}