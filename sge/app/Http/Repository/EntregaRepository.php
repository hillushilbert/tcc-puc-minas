<?php 

namespace App\Http\Repository;

use App\Http\Interfaces\IEntregaRepository;
use App\Http\Interfaces\IRoteiroRepository;
use App\Models\Entrega;
use Carbon\Carbon;

class EntregaRepository implements IEntregaRepository
{
    public $roteiroRepository;

    public function __construct(IRoteiroRepository $roteiroRepository)
    {
        $this->roteiroRepository = $roteiroRepository;    
    }
    public function create(array $order): Entrega
    {
        $entrega = Entrega::create([
            'codigo_rastreamento' => uniqid('BE'),
            'dados_pedido' => $order,
            'status_id' => Entrega::AGUARDANDO,
            'rota_atual_id' => null,
            'data_entrada' => Carbon::now(),
            'previsao_entrega' => Carbon::now(),
        ]);
        $this->roteiroRepository->create($entrega);
        
        return $entrega;
    }
}