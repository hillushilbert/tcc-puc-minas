<?php 

namespace App\Application\Interfaces;

use App\Models\Order;

interface IFindOrder {

    public function execute($id) : Order;

    public function byCodigoRastreamento($id) : ?Order;
}
