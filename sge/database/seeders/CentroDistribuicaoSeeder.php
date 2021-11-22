<?php

namespace Database\Seeders;

use App\Models\CentroDistribuicao;
use Illuminate\Database\Seeder;

class CentroDistribuicaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $centros = [
            'AC',
            'AL',
            'AP',
            'AM',
            'BA',
            'CE',
            'DF',
            'ES',
            'GO',
            'MA',
            'MT',
            'MS',
            'MG',
            'PA',
            'PB',
            'PR',
            'PE',
            'PI',
            'RJ',
            'RN',
            'RS',
            'RO',
            'RR',
            'SC',
            'SP',
            'SE',
            'TO'
        ];

        foreach($centros as $centro)
        {
            CentroDistribuicao::create([
                'name' => 'CD '.$centro,
                'uf' => $centro
            ]);
        }
    }
}
