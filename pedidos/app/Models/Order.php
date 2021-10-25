<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

    protected $table = 'orders';
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'customer_id',
        'origin_adress_id',
        'destination_adress_id',
        'supplier_id',
        'unity',
        'weight',
        'height',
        'width',
        'length',
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer','customer_id','id');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Supplier','customer_id','id');
    }

    public function origin()
    {
        return $this->belongsTo('App\Adress','origin_adress_id','id');
    }

    public function destiny()
    {
        return $this->belongsTo('App\Adress','destination_adress_id','id');
    }

}