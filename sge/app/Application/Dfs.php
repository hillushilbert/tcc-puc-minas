<?php 

namespace App\Application;

class Dfs {

    /* Searching Path */
    public function execute(Node $node, Node $destiny,&$rotas = [],$path = '', $visited = array())
    {
        if($node->equals($destiny) ){
            // echo 'achou : ' . $path . '->' . $node->name . PHP_EOL;
            $rotas[] = $path . '->' . $node->name;
            return;
            // return $path . '->' . $node->name;
        }

        $visited[] = $node->name;
        $not_visited = $node->not_visited_nodes($visited);
        if (empty($not_visited)) {
            // echo 'path : ' . $path . '->' . $node->name . PHP_EOL;
            return;
        }

        foreach ($not_visited as $n) {
            $this->execute($n, $destiny,$rotas,$path . '->' . $node->name, $visited);
        }
    }

    public function menosParadas(array $rotas) : array
    {
        $return = [];
        $min = count($rotas);
        foreach($rotas as $strRota)
        {
            $aRota = explode('->',$strRota);
            $return[count($aRota)][] = $strRota;

            if($min > count($aRota)){
                $min = count($aRota);
            }
        }
        return $return[$min];
    }

    public function menorDistancia(array $rotas,Factory $factory) : array
    {
        $return = [];
        $min = 9999999999999999999999;
        foreach($rotas as $strRota)
        {
            $rota = substr($strRota,2);
            $rota = explode('->',$rota);
            $distanciaTotal = 0;
            for($i=0;$i<count($rota);$i++)
            {
                if(isset($rota[$i+1]))
                {
                    $no1 = $factory->getInstance($rota[$i]);
                    $distanciaTotal += $no1->getPath($rota[$i+1])->getDistance();
                }
                
            }

            if($distanciaTotal < $min){
                $min = $distanciaTotal;
            }

            $return[$distanciaTotal][] = $strRota;
        }
        
        return [
            'distancia' => $min,
            'rotas'=> $return[$min]
        ];
    }
}