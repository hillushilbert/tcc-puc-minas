<?php

namespace App\Http\Repository;

use App\Http\Interfaces\ICustomerRepository;
use App\Models\Customer;
use stdClass;

class CustomerRepository implements ICustomerRepository
{
    public function persist(Customer $customer){
        $customer->save();
        return $customer->id;
    }
    
    public function findByEmail(string $email){
        return Customer::where('email',$email)
                    ->first();
    }

    public function findById(int $id){
        return Customer::find($id);
    }

    public function delete(Customer $customer){
        $customer->delete();
    }

    public function find(int $id = null){
        if($id){
            return Customer::where('id',$id)->get();
        }else{
            return Customer::get();
        }
    }

    public function factory(array $cust): Customer
    {
        $ad = new Customer();
        $ad->fill([
            "name" => $cust['name'] ?? null,
            "email" => $cust['email'] ?? null,
            "birth_date" => $cust['birth_date'] ?? null,
        ]);
        
        return $ad;
    }

}