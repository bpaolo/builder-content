<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Element;

class ContentController extends Controller
{
    public function index(){
    	return view('admin.Content.index');
    }

    public function add($templateId, $elementId, $content){
        return add($templateId, $elementId, $content);
    }

    public function addContent(Request $request, Content $content){
    	//dd($request->all());
    	//auth()->user()->Content;
    	//dd(auth()->user());
    	$name = $request->name;
    	$content->addContent($name);
    }

    public function getAllContentBytemplateId($templateId){

        $model = new Content();
        $result = $model->getAllContentBytemplateId($templateId);
        return $result;
    }


    public function formEdit(Request $request){

       $model = new Element();

       $data['elementId'] =  $request->id;
       $data['templateId']  =  $request->templateId;

        $dataElement   = $model->getElementById($request->id);
        $modeloContent = $model->getElementById($dataElement[0]->base);
        
        $data['modelContent'] = $modeloContent[0]->content;
        $data['description'] = $modeloContent[0]->description;

       $result = (object)$data;
     return view('admin.content.formEdit', compact('result'));
    }

    public function save(Request $request, Content $content){
        
        
        $model = new Element();

        
        $dataElement = $model->getElementById($request->elementId)[0];

        //verificar se é accordion
        if($dataElement->base == 284){
            $remover = preg_replace("/<p>/","", $request->content);
            $partes  = explode("//",$remover);

            foreach ($partes as $key => $value) {

                if(!empty($value)){
                    $accordion[$key] = $value;
                   
                }
            }
            $n = count($accordion);

            //tratar sujeira de estilo
            $input_array = $accordion;

            //lista de elementos removidos do accordion
            $vowels = array("<p><strong>", "</p></strong>", "</p>","<p>" ,"\r","\n");
            $content = str_replace($vowels, "", $input_array);

            //remover elementos vazios
            $key = array_search("", $content);
                if($key == ""){
                    unset($content[$key]);
                }

            $accordionTrat = array_chunk($content, 2);
            $str = null;
            
            foreach ($accordionTrat as $value) {
               
                $str .= '<button class="accordion">'.$value[0].'</button><div class="panel"><p>'.$value[1].'</p></div>';
            }

            
        }
        
        //verificar se é lista
        if($dataElement->base == 2 || $dataElement->base == 186){

                        $content1 = str_replace("<li><strong>", "<li>", $request->content);
                        $content2 = str_replace("</strong></li>", "</li>", $content1);
                        $vowels = array("\r","\n");
                        $str = str_replace($vowels, "", $content2);
        }
        
        //regra geral
        if(($dataElement->base != 2 AND $dataElement->base != 186 AND $dataElement->base != 284)){
            
            $str = $request->content; 
        }

        
        $vowels = array("\r","\n");
        $strSemQuebras = str_replace($vowels, "", $str);


        $model->updateElement($request->elementId,$strSemQuebras);
        return redirect('/home/admin/template/edit/'.$request->templateId);
        
    }

    public function accordion($texto){

        dd($texto);
        $accordion .= '<button class="accordion">'.$tema.'</button><div class="panel"><p>'.$content.'</p>  
    </div>';  
    }

    public function getContentBytemplateIdElementiId($templateId, $elementId){

        $model = new Content();
        $result = $model->getContentBytemplateIdElementiId($templateId, $elementId);
        return $result;
    }


    
}
