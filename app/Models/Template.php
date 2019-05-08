<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Template extends Model
{
	public $timestamps = false;
	
	public function add($maquinetaId, $name, $template, $modulo_id)
	{
		$this->maquineta_id 	= $maquinetaId;
		$this->name 			= $name;
		$this->template 		= $template;
		$this->modulo_id 		= $modulo_id;
		$this->save();
		$id = DB::getPdo()->lastInsertId();
		return $id;
	}

	public function getTemplateByMaquinetaId($maquinetaId)
	{
		try {
			
			$results = DB::select('select * from templates where maquineta_id = '.$maquinetaId.' AND status = 0');
			return $results;	
			

		} catch (Exception $e) {
			
		}

	}

	public function getTemplateById($Id)
	{
		try {
			
			$results = DB::select('select * from templates where id = '.$Id);
			return $results;	

		} catch (Exception $e) {
			
		}

	}

	public function getTemplateByModuleId($Id)
	{
		try {
			
			$results = DB::select('select * from templates where modulo_id = '.$Id);
			return $results;	

		} catch (Exception $e) {
			
		}

	}


	
    
}
