<?php

use Illuminate\Database\Seeder;

class MaquinetaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Maquineta::create([
				'name' => 'Simples 3.3.7'
				        ]);
    }
}
