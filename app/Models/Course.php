<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Course extends Model
{
	public function getCourseById($Id)
	{
		try {
			
			$results = DB::select("SELECT * FROM gte_builder.courses where id = ".$Id);

			return $results;	
		
		} catch (Exception $e) {
			
		}
		
	}

	public function addCourse($name,$projectId,$maquinetaId)
	{
		try {
				$this->name = $name;
				$this->project_id = $projectId;
				$this->maquineta_id = $maquinetaId;
				$this->save();
				$id = DB::getPdo()->lastInsertId();
				return $id;
			
		} catch (Exception $e) {
			
		}
		
				
	}

	public function getCourseByProjectIdAndMaquinetaID($projectId, $maquinetaId)
	{
		try {
			
			$results = DB::select("SELECT * FROM gte_builder.courses where project_id = ".$projectId." 
AND maquineta_id = ".$maquinetaId." Order by id desc");

			return $results->get()->toarray();	
		
		} catch (Exception $e) {
			
		}
		
	}


	public function getCourseByProjectId($Id)
	{
		try {
			
			$results = DB::select("SELECT * FROM gte_builder.courses where project_id = ".$Id);

			return $results;	
		
		} catch (Exception $e) {
			
		}
		
	}



	
    
}
