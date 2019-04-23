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

    //edit conteudo do element    
    public function element(Request $request){

            
       $model = new Element();

       $data['elementId'] =  $request->id;
       $data['templateId']  =  $request->templateId;

        $dataElement   = $model->getElementById($request->id);

        dd($dataElement);
        $modeloContent = $model->getElementById($dataElement[0]->base);
        
        $data['modelContent'] = $modeloContent[0]->content;
        $data['description'] = $modeloContent[0]->description;

       $result = (object)$data;
     return view('admin.content.formEdit', compact('result'));
    }

    public function save(Request $request, Content $content){
        
        
        $model = new Element();

            
        $dataElement = $model->getElementById($request->elementId)[0];
        
        if($dataElement->maquineta_id == 1){

        
        //TODO
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

        }
        
        //MAQUINETA 2
        if($dataElement->maquineta_id == 2){
            $element    = $dataElement->name;
            $maquineta  = $dataElement->maquineta_id;

            $input['element'] = $element;
            $input['content'] = $request->content;
            
            $str = $this->maquineta2($input);

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




    //MAQUINETA 2
    public function maquineta2($input){

        $element = $input['element'];
        $content = $input['content'];
        
        
        if($element == 'element2'){
            $result = $this->texto_m2($content);                 
        }

        if($element == 'element12'){
            $result = $content;                 
            $result = $this->TP017_e_TP018_Diagrama_Sanfona($content,$element);
        }

        return $result;
    }


    public function BreakPart($content,$element){

        //$remover = preg_replace("/<p>/","", $request->content);
        $partes  = explode("&gt;&gt;",$content);
        
        //unset($partes[0]);
        foreach ($partes as $key => $value) {

            if(!empty($value)){
                $result[$key] = $value;

               
            }
        }

        $input_array =$result;
                
        //lista de elementos removidos do accordion
        $vowels = array("<p><strong>","<strong><p>", "</strong></p>", "</p>","<p>" ,"\r","\n");
        $content2 = str_replace($vowels, "", $input_array);

        //remover elementos vazios
        $key = array_search("", $content2);
            if($key == ""){
                unset($content2[$key]);
            }

        
        if($element == 'element12'){
            $contentElement['text'] = $content2[1];
            unset($content2[1]);
        }
        $contentElement['content'] = array_chunk($content2, 2);
        
        return $contentElement;        
    }


    public function texto_m2($content){


        $texto = null;
        $texto .= '<div class="container">'.$content.'</div>';  


        return $texto;
    }


    public function TP017_e_TP018_Diagrama_Sanfona($content,$element){
    $leanContent = $this->BreakPart($content,$element);
        
        $mp017mp18 = null;
        $key = 1;
        
        $mp017mp18 .='<div class="container">
                <p>'.$leanContent['text'].'</p>';
        $mp017mp18 .= '<h4 class="sr-only">Conteúdo dividido por Accordion</h4>
          <div class="row">
            <div class="col-sm-12">
              <div class="panel-group" id="accordion-content" role="tablist" aria-multiselectable="true">';
                
                foreach ($leanContent['content'] as $key => $value) {
                $string = substr(md5(microtime()),1,rand(8,12));
                
                $mp017mp18 .= '
                <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="panelheading'.$string.$key.'">
                    <h6 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion-content" href="#panelcollapse'.$string.$key.'" aria-expanded="true" aria-controls="panelcollapse'.$string.$key.'">
                        '.$value[0].'

                      </a>
                    </h6>
                  </div>
                  <div id="panelcollapse'.$string.$key.'" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="panelheading'.$string.$key.'">
                    <div class="panel-body">
                      '.$value[1].'
                    </div>
                  </div>
                </div>';
            }
              $mp017mp18 .= '</div>
            </div>
          </div>
        </div>';

        return $mp017mp18;

    }


    
}
