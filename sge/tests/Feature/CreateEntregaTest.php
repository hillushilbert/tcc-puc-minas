<?php

namespace Tests\Feature;

use App\Application\Roteirizacao;
use App\Models\Entrega;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateEntregaTest extends TestCase
{
    use WithFaker;
    // use DatabaseTransactions;
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_entrega()
    {
        $entrega = Entrega::factory()->make();
        $roteirizacao = new Roteirizacao();
        $roteirizacao->make($entrega);
        // dump($entrega->dados_pedido);
        $this->assertNotEmpty($entrega->dados_pedido['origin_adress']);
        $this->assertNotEmpty($entrega->dados_pedido['destination_adress']);
    }
}
