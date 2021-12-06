<?php 

namespace App\Http\Repository;

use App\Application\Dfs;
use App\Application\Factory;
use App\Http\Interfaces\IRoteiroRepository;
use App\Models\CentroDistribuicao;
use App\Models\Entrega;
use App\Models\Roteiro;

class RoteiroRepository implements IRoteiroRepository
{
    public function __construct()
    {
        
    }

    public function create(Entrega $entrega)
    {
        
        $factory = new  Factory();
        $factory->run();
        //--
        $sp = $factory->getInstance($entrega->dados_pedido['origin_adress']['state']);
        $pe = $factory->getInstance($entrega->dados_pedido['destination_adress']['state']);
        $dfs = new Dfs();
        $dfs->execute($sp,$pe,$rotas);
          
        $menorDistancia = $dfs->menorDistancia($rotas,$factory);
        $rota = $menorDistancia['rota_array'];
        $distanciaTotal =   $menorDistancia['distancia'];

        $anterior = Roteiro::create([
            'entrega_id' => $entrega->id,
            'roteiro_anterior_id' => null,
            'roteiro_proximo_id' => null,
            'de' => 'Retirada : '.$entrega->dados_pedido['origin_adress']['street'],
            'para' => '',
        ]);

        $entrega->update(['rota_atual_id'=>$anterior->id]);


        for($i=0;$i<count($rota);$i++)
        {
            if(isset($rota[$i+1]))
            {
                $no1 = $factory->getInstance($rota[$i]);
                $no2 = $factory->getInstance($rota[$i+1]);
                $cd_de = CentroDistribuicao::where('uf',$no1->name)->first();
                $cd_para = CentroDistribuicao::where('uf',$no2->name)->first();
                $atual = Roteiro::create([
                    'entrega_id' => $entrega->id,
                    'roteiro_anterior_id' => $anterior->id,
                    'roteiro_proximo_id' => null,
                    'de' => $cd_de->name,
                    'de_cd_id' => $cd_de->id,
                    'para' => $cd_para->name,
                    'para_cd_id' => $cd_para->id,
                ]);

                $anterior->update([
                    'roteiro_proximo_id'=>$atual->id,
                    'para' => $cd_de->name,
                    'para_cd_id' => $cd_de->id,
                ]);
                $anterior = $atual;
                $distanciaTotal += $no1->getPath($rota[$i+1])->getDistance();
            }
            
        }

        Roteiro::create([
            'entrega_id' => $entrega->id,
            'roteiro_anterior_id' => $atual->id,
            'roteiro_proximo_id' => null,
            'de' => $cd_para->name,
            'de_cd_id' => $cd_para->id,
            'para' => 'Entrega : '.$entrega->dados_pedido['destination_adress']['street'],
        ]);

    }
}