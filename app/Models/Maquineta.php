<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Maquineta extends Model
{
	public function getMaquinetaById($Id)
	{
		try {
			
			$results = DB::select("SELECT * FROM gte_builder.maquineta where id = ".$Id);

			return $results;	
		
		} catch (Exception $e) {
			
		}
		
	}

	public function list()
	{
		try {
			
			$results = DB::select('select * from maquineta');
			return $results;	
		
		} catch (Exception $e) {
			
		}
		
	}
    
}
