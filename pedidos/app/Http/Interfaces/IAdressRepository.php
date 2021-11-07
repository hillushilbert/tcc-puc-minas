<?php

namespace App\Http\Interfaces;

use App\Models\Adress;
use App\Models\Customer;

interface IAdressRepository
{
    public function persist(Adress $adress);

    public function findByStreetAndNumber(string $street,int $number);

    public function delete(Adress $adress);

    public function find(int $id);

    public function factory(array $data): Adress;

}