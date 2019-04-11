<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Template;
use App\Models\Element;
use App\Models\Content;



class TemplateController extends Controller
{
    public function index(){
    	return view('admin.Template.index');
    }

    public function addTemplate($maquinetaId, $name, $template, $modulo_id){
    	return addTemplate($maquinetaId, $name, $template, $modulo_id);
    }

    public function edit($id){

        $element  = new Element();
        $content  = new Content();

        $result = $this->getTemplateById($id)[0];

        $getAllElements      = $element->getElementByTemplateId($id); 
        $getAllContents      = $content->getAllContentBytemplateId($id);
        $component = null;

        foreach ($getAllElements as $value) {
                //adiciona o conteudo ao elemento
            if(!empty($value->content)){
                $ElementAndContent = str_replace('$content', $value->element, $value->content);
                $component .= $ElementAndContent;
            }else{
                $component .= $value->element;
            }

                
                
        }
        

        foreach ($getAllElements as $key => $value) {
                
                $key++;
                //$component['elementos'][$key] = $value->element;  
                $string  = $result->template;

                $result->template = str_replace('$allElement',$component, $string);
        }

        
        //armazena os conteúdo nos elementos 
        foreach ($getAllContents as $k => $content) {
            $k++;
            $component['conteudo'][$k] = $content->content;  

            $string  = $result->template;
            $result->template = str_replace('$content'.$k,$component['conteudo'][$k], $string);

        }

        //carregar os elementos 
        $getAllElements      = $element->getAllElement();
        $result->elements = $getAllElements; 
            

        return view('admin.template.edit', compact('result')); 
    }

    public function getTemplateById($Id){

        $model = new Template();
        $result = $model->getTemplateById($Id);
        return $result;
    }

    public function getByMaquinetaId($maquinetaId){

        $model = new Template();
        $result = $model->getByMaquinetaId($maquinetaId);
        return $result;
    }

    public function getTemplateByMaquinetaId(Request $request){

        try {
            $template = $this->getByMaquinetaId($request->maquinetaId);
            return view('admin.template.list', compact('template')); 
            

        } catch (Exception $e) {
            
        }

    }

    public function getTemplateCreatedById($Id){

        $result = $this->getTemplateById($Id);
        
        return view('admin.template.edit', compact('result')); 
    }
}
