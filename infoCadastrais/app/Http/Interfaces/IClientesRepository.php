<?php 

namespace App\Http\Interfaces;

use App\Models\Cliente;

interface IClientesRepository {

    public function getAll();

    public function getById(string $id) : ?Cliente;

    public function save(array $requestData,int $id = null) : Cliente;
}