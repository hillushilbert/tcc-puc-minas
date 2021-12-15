<?php 

namespace App\Application\Interfaces;

use App\Http\Requests\AuthTokenRequest;
use App\Models\Order;

interface IAuthToken {

    public function execute(AuthTokenRequest $request) : \Illuminate\Http\Client\Response;
}
