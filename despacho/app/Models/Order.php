<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $fillable = [
        'id',
        'unity',
        'weight',
        'height',
        'width',
        'length',
        'created_at',
        'updated_at',
    ];

    public function setCustomerAttribute($value){
        $this->attributes['customer'] = $value;
    }

    public function getCustomerAttribute(){
        return $this->attributes['customer'];
    }
}
