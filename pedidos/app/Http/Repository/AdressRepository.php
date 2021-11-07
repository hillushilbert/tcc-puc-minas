<?php

namespace App\Http\Repository;

use App\Http\Interfaces\IAdressRepository;
use App\Models\Adress;

class AdressRepository implements IAdressRepository
{
    public function persist(Adress $adress){
        $adress->save();
        return $adress->id;
    }
    
    public function findByStreetAndNumber(string $street,int $number){
        return Adress::where('street',$street)
                    ->where('number',$number)
                    ->first();
    }

    public function delete(Adress $adress){
        $adress->delete();
    }

    public function find(int $id = null){
        if($id){
            return Adress::where('id',$id)->get();
        }else{
            return Adress::get();
        }
    }

    public function factory(array $addr): Adress
    {
        $ad = new Adress();
        $ad->fill([
            "street" => $addr['street'] ?? '',
            "number" => $addr['number'] ?? '',
            "city" => $addr['city'] ?? 'São Paulo',
            "state" => $addr['state'] ?? 'SP',
            "country" => $addr['country'] ?? 'BR',
            "active" => $addr['active'] ?? false
        ]);
        return $ad;
    }

}