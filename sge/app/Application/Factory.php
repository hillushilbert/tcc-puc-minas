<?php 

namespace App\Application;

class Factory {

    protected $data;

    protected $instances = [];

    public function __construct()
    {
        $this->data = [
            'AC'=>['RO','AM'],
            'AL'=>['SE','PE','BA'],
            'AP'=>['PA',],
            'AM'=>['RO','AC','RR','PA','MT'],
            'BA'=>['ES','MG','GO','TO','MA','PI','SE','PE','AL'],
            'CE'=>['RN','PB','PE','PI',],
            'DF'=>['GO',],
            'ES'=>['BA','MG','RJ'],
            'GO'=>['MG','MS','MT','TO','BA'],
            'MA'=>['PA','TO','PI','BA'],
            'MT'=>['MS','GO','TO','PA','RO'],
            'MS'=>['PR','SP','GO','MT'],
            'MG'=>['BA','ES','RJ','SP','MS','GO'],
            'PA'=>['AP','MA','TO','MT','AM','RR'],
            'PB'=>['PE','RN','PI','CE'],
            'PR'=>['MS','SP','SC'],
            'PE'=>['PB','CE','PI','BA','AL'],
            'PI'=>['MA','CE','PE','BA','TO'],
            'RJ'=>['ES','MB','SP'],
            'RN'=>['PB','CE',],
            'RS'=>['SC',],
            'RO'=>['AC','AM','MT'],
            'RR'=>['AM','PA'],
            'SC'=>['PR','RS'],
            'SP'=>['RJ','MG','MS','PR'],
            'SE'=>['BA','AL'],
            'TO'=>['MT','PA','MA','PI','BA','GO'],
        ];
    }

    public function getInstance($name)
    {
        $instance = null;
        if(isset($this->instance[$name])){
            $instance = $this->instance[$name];
        }else{
            $instance = new Node($name);
            $this->instance[$name] = $instance;
        }
        return $instance;
    }

    public function run()
    {
        // $root = new Node('root');

        foreach ($this->data as $key => $detalhes) 
        {
            $node_key = $this->getInstance($key);
            // $root->link_to($node_key);
            foreach($detalhes as $nome)
            {
                $node1 = $this->getInstance($nome);
                $node_key->link_to($node1);
            }
        }
        
        // return $root;
    }
}