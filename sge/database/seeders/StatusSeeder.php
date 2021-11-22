<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $status_lista = [
            'Aguardando',
            'Coletado',
            'Transito',
            'Entregue',
            'Devolvido',
        ];

        foreach($status_lista as $id=>$status)
        {
            Status::create([
                'id' => $id+1,
                'name' => $status
            ]);
        }
    }
}
