<?php 

namespace App\Application;

use App\Application\Interfaces\IStoreEntrega;
use App\Http\Interfaces\IEntregaRepository;
use App\Http\Requests\NewOrderRequest;
use App\Models\Entrega;

class StoreEntrega implements IStoreEntrega
{
    public $entregaRepository;

    public function __construct(IEntregaRepository $entregaRepository)
    {
        $this->entregaRepository = $entregaRepository;
    }

    public function execute(NewOrderRequest $request): Entrega
    {
        $entrega = $this->entregaRepository->create($request->all());

        return $entrega;
    }
}