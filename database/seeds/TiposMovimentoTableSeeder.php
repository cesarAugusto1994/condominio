<?php

use Illuminate\Database\Seeder;
use App\Models\Movimento\Tipo;

class TiposMovimentoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itens = ['Entrada', 'Saída'];

        foreach ($itens as $key => $item) {
            Tipo::create(['nome' => $item]);
        }
    }
}
