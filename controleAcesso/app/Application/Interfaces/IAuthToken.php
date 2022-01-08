<?php 

namespace App\Application\Interfaces;

use Illuminate\Http\Request;
use App\Models\Order;

interface IAuthToken {

    public function execute(Request $request) : \Illuminate\Http\Client\Response;
}
