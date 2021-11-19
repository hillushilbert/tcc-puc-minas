<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentroDistribuicao extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'centro_distribuicao';

    protected $fillable = [
        'nome',
        'estado',
        'active',
    ];
}
