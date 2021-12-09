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
        'codigo_rastreamento',
    ];

    protected $appends = ['roteamento'];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer','customer_id','id');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier','customer_id','id');
    }

    public function origin()
    {
        return $this->belongsTo('App\Models\Adress','origin_adress_id','id');
    }

    public function destiny()
    {
        return $this->belongsTo('App\Models\Adress','destination_adress_id','id');
    }

    public function setRoteamentoAttribute($value)
    {
        $this->attributes['roteamento'] = $value;
    }

    public function getRoteamentoAttribute()
    {
        return $this->attributes['roteamento'] ?? null;
    }

    public function exportToJson()
    {
        $this->customer;
        $this->supplier;
        $this->origin;
        $this->destiny;
        $record = json_decode($this->toJson());
        unset($record->customer_id);
        unset($record->origin_adress_id);
        unset($record->destination_adress_id);
        unset($record->supplier_id);
        return $record;
    }

}