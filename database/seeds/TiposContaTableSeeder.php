<?php

use Illuminate\Database\Seeder;
use App\Models\Conta\Tipo;

class TiposContaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itens = ['Cartão de Crédito', 'Conta Bancária', 'Caixa Físico'];

        foreach ($itens as $key => $item) {
            Tipo::create(['nome' => $item]);
        }
    }
}
