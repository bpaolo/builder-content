<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Content extends Model
{
	public function addContent($name)
	{
		$this->name = $name;
		$this->save();
	}

	public function add($templateId, $elementId, $content)
	{
		$id = DB::table('content')->insertGetId(
		    [
		    	'template_id' 	=> $templateId,
		    	'element_id' 	=> $elementId,
		    	'content' 		=> $content
		    				]
		);

		return $id;
	}

	public function getContentByElementId($elementId)
	{
		try {
			
			$results = DB::select('select * from content where element_id = '.$elementId);
			return $results;	

		} catch (Exception $e) {
			
		}

	}

	public function getAllContentBytemplateId($templateId)
	{
		try {
			
			$results = DB::select('select * from content where template_id = '.$templateId);
			return $results;	

		} catch (Exception $e) {
			
		}

	}
    
}
