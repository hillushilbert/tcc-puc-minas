<?php 

namespace App\Application\Interfaces;

use App\Http\Requests\RefreshTokenRequest;
use App\Models\Order;

interface IRefreshToken {

    public function execute(RefreshTokenRequest $request) : \Illuminate\Http\Client\Response;
}
