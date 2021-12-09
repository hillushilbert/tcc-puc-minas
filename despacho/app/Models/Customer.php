<?php

namespace App\Models;

use App\Mail\OrderShipped;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Customer extends Model
{
    use HasFactory;

    public $fillable = [
        'id',
        'name',
        'birth_date',
        'email',
        'created_at',
        'updated_at',
    ];

    public function sendOrderShippedNotification(Order $order,string $codigo_rastreamento)
    {

        Mail::to($this->email)->send(new OrderShipped($order,$codigo_rastreamento));
    }
}
