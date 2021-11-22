<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    const AGUARDANDO = 1;

    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'entrega';

    protected $fillable = [
        'codigo_rastreamento',
        'dados_pedido',
        'status_id',
        'rota_atual_id',
        'data_entrada',
        'previsao_entrega',
    ];

    protected $casts = [
        'dados_pedido' => 'array',
        'data_entrada' => 'date',
        'previsao_entrega' => 'date',
    ];

    /**
     * Retorna o roteiro atual da entrega
     */
    public function roteiroAtual()
    {
        return $this->belongsTo(Roteiro::class, 'rota_atual_id');
    }

    /**
     * Retorna o status atual da entrega
     */
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

        /**
     * Retorna o status atual da entrega
     */
    public function roteiro()
    {
        return $this->hasMany(Roteiro::class, 'entrega_id','id');
    }
}
