<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Element extends Model
{
	
	public function add($templateId, $base, $name, $description, $element)
	{

		$id = DB::table('elements')->insertGetId(
		    [
		    	'template_id' => $templateId,
		    	'base' => $base,
		    	'name' => $name,
		    	'description' => $description,
		    	'element' => $element

			]
		);

		return $id;
	}

	public function getElementByMaquinetaId($maquinetaId)
	{
		try {
			
			$results = DB::select('select * from Elements where maquineta_id = '.$maquinetaId.' AND status = 0');
			return $results;	

		} catch (Exception $e) {
			
		}

	}

	public function getElementById($Id)
	{
		try {
			
			$results = DB::select('select * from Elements where id = '.$Id);
			return $results;	

		} catch (Exception $e) {
			
		}

	}

	public function getAllElement()
	{
		try {
			
			$results = DB::select('select * from Elements where base = 0');
			return $results;	

		} catch (Exception $e) {
			
		}

	}

	public function getElementByTemplateId($templateId)
	{
		try {
			
			$results = DB::select('select * from Elements where template_id = '.$templateId);
			return $results;	

		} catch (Exception $e) {
			
		}

	}
	
    
}
