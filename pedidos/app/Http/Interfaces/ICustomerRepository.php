<?php

namespace App\Http\Interfaces;

use App\Models\Customer;

interface ICustomerRepository
{
    public function persist(Customer $customer);
    
    public function findByEmail(string $email);

    public function findById(int $id);

    public function delete(Customer $customer);

    public function find(int $id);

    public function factory(array $data): Customer;

}