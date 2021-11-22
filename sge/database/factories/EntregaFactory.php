<?php

namespace Database\Factories;

use App\Models\Entrega;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntregaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $json = '{
            "customer": {
              "id": 0,
              "name": "'.$this->faker->name.'",
              "email": "'.$this->faker->email.'",
              "birth_date": "2021-11-22T01:06:53.462Z"
            },
            "origin_adress": {
              "street": "'.$this->faker->streetAddress().'",
              "number": 120,
              "city": "'.$this->faker->city.'",
              "state": "PE",
              "country": "BR",
              "active": true
            },
            "destination_adress": {
              "street": "'.$this->faker->streetAddress().'",
              "number": 250,
              "city": "'.$this->faker->city.'",
              "state": "SP",
              "country": "BR",
              "active": true
            },
            "supplier": {
              "id": 0,
              "name": "string",
              "email": "string"
            },
            "unity": "string",
            "weight": 100,
            "height": 200,
            "width": 300,
            "length": 400
        }';

        return [
            'codigo_rastreamento' => uniqid('BE'),
            'dados_pedido' => json_decode($json),
            'status_id' => Entrega::AGUARDANDO,
            'rota_atual_id' => null,
            'data_entrada' => Carbon::now(),
            'previsao_entrega' => Carbon::now(),
        ];
    }
}
