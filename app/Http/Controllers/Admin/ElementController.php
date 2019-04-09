<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Element;



class ElementController extends Controller
{
    public function index(){
    	return view('admin.element.index');
    }

    public function add(Request $request){

        $model   = new Element();
        $element = $this->getElementById($request['elementId']);
        
    	$id =  $model->add($request['templateId'], 1, $element[0]->name, $element[0]->description, $element[0]->element);

        $newElement = $this->getElementById($id);
        return redirect('/home/admin/template/edit/'.$request['templateId']);
    }


    public function getElementById($Id){

        $model  = new Element();
        $result = $model->getElementById($Id);
        return $result;
    }

    public function getAllElement(){

        $model = new Element();
        $result = $model->getAllElement();
        return $result;
    }

    public function getElementByTemplateId($templateId){

        $model = new Element();
        $result = $model->getElementByTemplateId($templateId);
        return $result;
    }

}
