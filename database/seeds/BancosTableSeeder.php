<?php

use Illuminate\Database\Seeder;
use App\Models\Banco;

class BancosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itens = ['Caixa Econômica Federal', 'Banco do Brasil', 'Bradesco'];

        foreach ($itens as $key => $item) {
            Banco::create(['nome' => $item]);
        }
    }
}
