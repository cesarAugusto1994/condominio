<?php

use Illuminate\Database\Seeder;
use App\Models\Despesa;

class DespesasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itens = ['Constas de Energia', 'Contas de Água', 'Taxa do Condomínio'];

        foreach ($itens as $key => $item) {
            Despesa::create(['nome' => $item]);
        }
    }
}
