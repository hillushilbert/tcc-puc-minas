<?php 

namespace App\DTO;

use App\Models\Customer;
use App\Models\Order;

class OrderDTO {

    private $payload;
    private $data;

    public function __construct(string $data)
    {
        $this->payload = $data;
        $this->data = json_decode($data);
         
    }

    public function transformDataToOrder() : Order
    {
        $order = new Order();
        $order->fill([
            'id' => $this->data->id,
            'unity'	=> $this->data->unity,
            'weight'	=> $this->data->weight,
            'height'	=> $this->data->height,
            'width'	=> $this->data->width,
            'length'	=> $this->data->length,
        ]);
        
        $order->customer = $this->transformDataToCustomer();

        return $order;
    }

    public function transformDataToCustomer() : Customer 
    {
        $customer = new Customer();
        
        $customer->fill([
            'id' => $this->data->customer->id,
            'name' => $this->data->customer->name,
            'birth_date' => $this->data->customer->birth_date,
            'email' => $this->data->customer->email,
        ]);

        return $customer;
    }

    public function toArray() : array
    {
        return json_decode($this->payload,true);
    }
}

