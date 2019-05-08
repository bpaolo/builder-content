<?php

use Illuminate\Database\Seeder;
use App\Element;

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
			'template_id' => '1', 
			'base' => '0', 
			'name' => 'element2', 
			'description' => 'lista não ordenada', 
			'element' => '', 
			'updated_at' => NULL, 
			'created_at' => NULL, 
			'cantent' => NULL, 
			'content' => '<ul>
							<li>item 1</li> 
						    <li>item 2</li> 
						    <li>item 3</li> 
						    <li>item 4</li>
						  </ul>', 
			'maquineta_id' => '1', 
			'position' => NULL,
        ]);

        Element::create([
			'template_id' => '1', 
			'base' => '0', 
			'name' => 'element4', 
			'description' => 'lista ordenada', 
			'element' => '', 
			'updated_at' => NULL, 
			'created_at' => NULL, 
			'cantent' => NULL, 
			'content' => ' <ol> 
						    <li>item 1</li> 
						    <li>item 2</li> 
						    <li>item 3</li> 
						    <li>item 4</li> 
						    </ol>', 
			'maquineta_id' => '1', 
			'position' => NULL,
        ]); 

        Element::create([
			'template_id' => '1', 
			'base' => '0', 
			'name' => 'element5', 
			'description' => 'texto', 
			'element' => '', 
			'updated_at' => NULL, 
			'created_at' => NULL, 
			'cantent' => NULL, 
			'content' => 'A área de Gestão de Tecnologias em Educação , da Fundação Carlos Alberto Vanzolini (FCAV), foi criada em 2000 com o compromisso de atender a um dos maiores desafios contemporâneos: apoiar as iniciativas que permitam ampliar a oferta de uma educação de qualidade a um maior número de pessoas. A GTE desenvolve pesquisas aplicadas, realiza estudos e atua na área de gestão de projetos e de operações, articulando competências em tecnologia e em educação.', 
			'maquineta_id' => '1', 
			'position' => NULL,
        ]); 

        Element::create([
			'template_id' => '1', 
			'base' => '0', 
			'name' => 'element6', 
			'description' => 'imagem', 
			'element' => '', 
			'updated_at' => NULL, 
			'created_at' => NULL, 
			'cantent' => NULL, 
			'content' => ' clique no ícone de imagem do editor e escolha sua figura', 
			'maquineta_id' => '1', 
			'position' => NULL,
        ]); 

        Element::create([
			'template_id' => '1', 
			'base' => '0', 
			'name' => 'element7', 
			'description' => 'box', 
			'element' => '', 
			'updated_at' => NULL, 
			'created_at' => NULL, 
			'cantent' => NULL, 
			'content' => '	>>dica, atenção, importante, saiba-mais, reflexao, livro, questao</br>
							>>digite o texto do box</br>', 
			'maquineta_id' => '1', 
			'position' => NULL,
        ]); 

        Element::create([
			'template_id' => '1', 
			'base' => '0', 
			'name' => 'element8', 
			'description' => 'acordeon', 
			'element' => '', 
			'updated_at' => NULL, 
			'created_at' => NULL, 
			'cantent' => NULL, 
			'content' => '	>>título</br>
							>>conteúdo do texto</br>', 
			'maquineta_id' => '1', 
			'position' => NULL,
        ]); 

        Element::create([
			'template_id' => '1', 
			'base' => '0', 
			'name' => 'element9', 
			'description' => 'aba', 
			'element' => '', 
			'updated_at' => NULL, 
			'created_at' => NULL, 
			'cantent' => NULL, 
			'content' => '	>>título</br>
							>>conteúdo do texto</br>', 
			'maquineta_id' => '1', 
			'position' => NULL,
        ]); 

        Element::create([
			'template_id' => '1', 
			'base' => '0', 
			'name' => 'element11', 
			'description' => 'carrossel', 
			'element' => '', 
			'updated_at' => NULL, 
			'created_at' => NULL, 
			'cantent' => NULL, 
			'content' => '	>>título</br>
							>>conteúdo do texto</br>', 
			'maquineta_id' => '1', 
			'position' => NULL,
        ]); 

                
    }
}
# , , , , , , , , , , 


