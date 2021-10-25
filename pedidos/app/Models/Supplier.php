<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model {

    use HasFactory;

    protected $table = 'suppliers';
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
   ];

    public function orders()
    {
        return $this->hasMany('App\Order','customer_id','id');
    }

}