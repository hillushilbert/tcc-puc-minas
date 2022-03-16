<?php

namespace App\Application;

class Path
{
    public $node1;
    public $node2;
    public $distance;

    public function __construct(Node $node1,Node $node2)
    {
        $this->node1 = $node1;
        $this->node2 = $node2;
    }


    public function getDistance()
    {
        $value = $this->calcDistance();
        return $value;
    }

    private function calcDistance()
    {
        static $dados;

        if(empty($dados)){
            $dados = $this->loadMatriz();
        }

        return $dados[$this->node1->name][$this->node2->name];
    }

    private function loadMatriz()
    {
        $columns = [
            '','SE','PA','MG','RR','DF','MS','MT','PR','SC','CE','GO','PB','AP','AL','AM','RN','TO','RS','RO','PE','AC','RJ','BA','MA','SP','PI','ES'
        ];

        $data = [];

        $filaname = storage_path('app/matriz_distancia.csv');
        $handle = fopen($filaname,'r');
        $contadorLinha = 0;
        while(!feof($handle))
        {
            $buffer = fgets($handle,4096);
            $return = explode(';',$buffer);
            foreach($return as $idx=>$value)
            {
                if($contadorLinha == 0) continue;
                
                if(empty($columns[$contadorLinha]) && empty($columns[$idx]))
                continue;
                
                $ufOrigiem = $columns[$contadorLinha];
                $ufDestino = $columns[$idx];

                if($ufDestino == '') continue;

                if(!empty($data[$ufOrigiem][$ufDestino]))
                $data[$ufOrigiem][$ufDestino] = intval(trim($value));
            }
            $contadorLinha++;
        }
        return $data;
    }
}