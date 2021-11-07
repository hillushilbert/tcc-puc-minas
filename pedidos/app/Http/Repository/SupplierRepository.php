<?php

namespace App\Http\Repository;

use App\Http\Interfaces\ISupplierRepository;
use App\Models\Supplier;
use stdClass;

class SupplierRepository implements ISupplierRepository
{
    public function persist(Supplier $supplier){
        $supplier->save();
        return $supplier->id;
    }
    
    public function findByEmail(string $email){
        return Supplier::where('email',$email)
                    ->first();
    }

    public function findById(int $id){
        return Supplier::find($id);
    }

    public function delete(Supplier $supplier){
        $supplier->delete();
    }

    public function find(int $id = null){
        if($id){
            return Supplier::where('id',$id)->get();
        }else{
            return Supplier::get();
        }
    }

    public function factory(array $cust): Supplier
    {
        $ad = new Supplier();
        $ad->fill([
            "name" => $cust['name'] ?? null,
            "email" => $cust['email'] ?? null,
        ]);
        return $ad;
    }

}