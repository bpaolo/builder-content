<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Module extends Model
{
	public function getModuleById($Id)
	{
		try {
			
			$results = DB::select("SELECT * FROM gte_builder.modules where id = ".$Id);

			return $results;	
		
		} catch (Exception $e) {
			
		}
		
	}

	public function addModule($courseId,$maquinetaId,$name)
	{
		$this->name = $name;
		$this->course_id = $courseId;
		$this->maquineta_id = $maquinetaId;
		$this->save();
		$id = DB::getPdo()->lastInsertId();
		return $id;
	}

	public function getModuleByCorseId($Id)
	{
		try {
			
			$results = DB::select("SELECT * FROM gte_builder.modules where course_id = ".$Id);

			return $results;	
		
		} catch (Exception $e) {
			
		}
		
	}
    
}
