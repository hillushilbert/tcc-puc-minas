<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roteiro extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'roteiro';

    protected $fillable = [
        'entrega_id',
        'roteiro_anterior_id',
        'roteiro_proximo_id',
        'de',
        'de_cd_id',
        'para',
        'para_cd_id',
        'iniciado',
        'concluido',
    ];
}
