<?php

use Illuminate\Database\Seeder;

class ElementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Element::create([
			'template_id' =>'1', 
			'base' =>'0', 
			'name' =>'element2', 
			'description' =>'Lista não ordenada', 
			'element' =>'<ul>\n$content\n</ul>', 
			'updated_at' =>NULL, 
			'created_at' =>NULL, 
			'cantent' =>NULL, 
			'content' =>'<ul>\n	<li>item</li>\n	<li>item</li>\n	<li>item</li>\n	<li>'name' =>item</li>\n</ul>', 
			'maquineta_id' =>'1', 
			'position' =>NULL,
        ]);
    }
}
# , , , , , , , , , , 


