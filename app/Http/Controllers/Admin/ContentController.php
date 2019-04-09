<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Content;

class ContentController extends Controller
{
    public function index(){
    	return view('admin.Content.index');
    }

    public function add($templateId, $elementId, $content){
        return add($templateId, $elementId, $content);
    }

    public function addContent(Request $request, Content $Content){
    	//dd($request->all());
    	//auth()->user()->Content;
    	//dd(auth()->user());
    	$name = $request->name;
    	$Content->addContent($name);
    }

    public function getAllContentBytemplateId($templateId){

        $model = new Content();
        $result = $model->getAllContentBytemplateId($templateId);
        return $result;
    }



    
}
