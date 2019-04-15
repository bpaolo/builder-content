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
        if($dataElement->base == 284 || $dataElement->base == 325 || $dataElement->base == 357){
            
            //$remover = preg_replace("/<p>/","", $request->content);
            $partes  = explode("&gt;&gt;",$request->content);

            //unset($partes[0]);
            foreach ($partes as $key => $value) {

                if(!empty($value)){
                    $accordion[$key] = $value;

                   
                }
            }
            
            //tratar sujeira de estilo
            $input_array = $accordion;
            
            //lista de elementos removidos do accordion
            $vowels = array("<p><strong>","<strong><p>", "</strong></p>", "</p>","<p>" ,"\r","\n");
            $content = str_replace($vowels, "", $input_array);

            //remover elementos vazios
            $key = array_search("", $content);
                if($key == ""){
                    unset($content[$key]);
                }

            $contentElement = array_chunk($content, 2);
            $str = null;

            if($dataElement->base == 325){
               
                $str = $this->aba($contentElement);

            }

            //carrossel
            if($dataElement->base == 357){
               
                $str = $this->carousel($contentElement);

            }
            
            if($dataElement->base == 284){
                foreach ($contentElement as $value) {
                   
                    $str .= '<button class="accordion">'.$value[0].'</button><div class="panel"><p>'.$value[1].'</p></div>';
                }

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
        if( $dataElement->base != 2   AND 
            $dataElement->base != 186 AND 
            $dataElement->base != 284 AND 
            $dataElement->base != 325 AND
            $dataElement->base != 357 ){
            
            $str = $request->content; 
        }

        
        $vowels = array("\r","\n");
        $strSemQuebras = str_replace($vowels, "", $str);


        $model->updateElement($request->elementId,$strSemQuebras);
        return redirect('/home/admin/template/edit/'.$request->templateId);
        
    }

    public function accordion($texto){

        
        $accordion .= '<button class="accordion">'.$tema.'</button><div class="panel"><p>'.$content.'</p>  
    </div>';  
    }

    public function aba($input){
        $abaSection = null;
        $abaSection .= '<div class="bs-example"><ul class="nav nav-tabs">';

        $key = 0;
        foreach ($input as $key => $value) {
            if($key == 0){
                $abaSection .= '<li class="active"><a data-toggle="tab" href="#section'.$key.'">
                        '.$value[0].'</a></li>';                
            }else{

            $abaSection .= '<li><a data-toggle="tab" href="#section'.$key.'">
                        '.$value[0].'</a></li>';
            }            
            $key++;
        }
                
        $abaSection .= '</ul><div class="tab-content">';

        $key2 = 0;
        foreach ($input as $key2 => $value) {

            if($key2 == 0){
                $abaSection .= '<div id="section'.$key2.'" class="tab-pane fade in active"><p>'.$value[1].'</p></div>';
            }
                
            $abaSection .= '<div id="section'.$key2.'" class="tab-pane fade"><p>'.$value[1].'</p></div>';
            $key2++;
        }
            $abaSection .= '</div></div>';


            return $abaSection;
       
    }


    public function carousel($input){
        $carousel = null;
        $carousel .= '<div class="container">
           
          <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">';

            $key = 0;
            foreach ($input as $key => $value) {
             
                if($key == 0){
                    $carousel .=   '<li data-target="#myCarousel" data-slide-to="'.$key.'" class="active"></li>';
                }else{
                  $carousel .= '<li data-target="#myCarousel" data-slide-to="'.$key.'"></li>';
                }
            }  
            $carousel .= '</ol>';

            
            $carousel .= '<div class="carousel-inner">';

            $key2 = 0;
            foreach ($input as $key2 => $value) {
                if($key2 == 0){  
                    $carousel .= '<div class="item active"><div class="desc">'.$value[1].'</div><img src="'.$value[0].'" alt="Los Angeles" style="width:100%;"></div>';
                }else{                
                    $carousel .= '<div class="item"><div class="desc">'.$value[1].'</div><img src="'.$value[0].'" alt="Los Angeles" style="width:100%;"></div>';
                }    
            }
            $carousel .= '</div>';

            
            $carousel .= '<a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span><span class="sr-only">Previous</span></a><a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span><span class="sr-only">Next</span></a></div></div>';

            return $carousel;
    }

    public function getContentBytemplateIdElementiId($templateId, $elementId){

        $model = new Content();
        $result = $model->getContentBytemplateIdElementiId($templateId, $elementId);
        return $result;
    }


    
}
