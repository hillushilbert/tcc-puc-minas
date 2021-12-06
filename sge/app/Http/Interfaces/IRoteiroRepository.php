<?php 

namespace App\Http\Interfaces;

use App\Models\Entrega;

interface IRoteiroRepository {

    public function create(Entrega $entrega);
}