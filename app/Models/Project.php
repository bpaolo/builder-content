<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project extends Model
{
	public function getProjectById($Id)
	{
		try {
			
			$results = DB::select("SELECT * FROM gte_builder.projects where id = ".$Id);

			return $results;	
		
		} catch (Exception $e) {
			
		}
		
	}

	public function addProject($name)
	{
		$this->name = $name;
		$this->save();
	}

	public function getProject()
	{
		try {
			
			$results = DB::select('SELECT * FROM gte_builder.projects  order by id desc limit 1');
			return $results;	
		
		} catch (Exception $e) {
			
		}
		
	}

	public function getAll()
	{
		try {
			
			$results = DB::select('SELECT * FROM gte_builder.projects  order by id asc');
			return $results;	
		
		} catch (Exception $e) {
			
		}
		
	}
    
}
