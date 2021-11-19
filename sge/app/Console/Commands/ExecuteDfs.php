<?php

namespace App\Console\Commands;

use App\Application\Dfs;
use App\Application\Factory;
use Illuminate\Console\Command;

class ExecuteDfs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:dfs  {origem} {destino}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $origem = $this->argument('origem');
        $destino = $this->argument('destino');

        $factory = new  Factory();
        $root = $factory->run();
        //--
        $sp = $factory->getInstance($origem);
        $pe = $factory->getInstance($destino);
        $dfs = new Dfs();
        $this->info("Calculando as todas rotas");
        $dfs->execute($sp,$pe,$rotas);
        $this->info("Calculando a menor rota");
        $menosParadas = $dfs->menosParadas($rotas);
        dump($menosParadas);    
        
        $menorDistancia = $dfs->menorDistancia($rotas,$factory);
        dump($menorDistancia);    
        
        return Command::SUCCESS;
    }
}
