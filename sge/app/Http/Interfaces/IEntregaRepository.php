<?php 

namespace App\Http\Interfaces;

use App\Models\Entrega;
use stdClass;

interface IEntregaRepository {

    public function create(array $order): Entrega;
}