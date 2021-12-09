<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model {

    use HasFactory;

    protected $table = 'customers';
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'birth_date',
        'cpf',
    ];

    public function orders()
    {
        return $this->hasMany('App\Order','customer_id','id');
    }

}