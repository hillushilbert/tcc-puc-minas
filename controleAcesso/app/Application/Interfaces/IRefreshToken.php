<?php 

namespace App\Application\Interfaces;

use Illuminate\Http\Request;
use App\Models\Order;

interface IRefreshToken {

    public function execute(Request $request) : \Illuminate\Http\Client\Response;
}
