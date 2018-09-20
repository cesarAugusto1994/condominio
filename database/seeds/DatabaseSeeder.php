<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TiposContaTableSeeder::class);
        $this->call(TiposMovimentoTableSeeder::class);
        $this->call(BancosTableSeeder::class);
        $this->call(DespesasTableSeeder::class);

    }
}
