<?php

namespace App\Http\Interfaces;

use App\Models\Supplier;

interface ISupplierRepository
{
    public function persist(Supplier $supplier);
    
    public function findByEmail(string $email);

    public function findById(int $id);

    public function delete(Supplier $supplier);

    public function find(int $id);

    public function factory(array $data): Supplier;

}