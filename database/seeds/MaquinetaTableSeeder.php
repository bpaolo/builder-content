<?php

use Illuminate\Database\Seeder;
use App\Maquineta;

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


