<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Template;
use App\Models\Element;
use App\Models\Content;
use App\Models\Module;
use App\Models\Project;
use App\Models\Course;



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
        $componentEdit = null;
        

        foreach ($getAllElements as $value) {
                //adiciona o conteudo ao elemento

            
            if(!empty($value->content)){
                $elementId = $value->id;
                $ElementAndContent = str_replace('$content', $value->element, $value->content);
                $component .= $ElementAndContent;
                $componentEdit .='<a href="https://localhost/gte-builder/public/home/admin/content/element/'.$elementId.'"><i class="fa fa-fw fa-edit"></i></a>'.$ElementAndContent;

                //$componentEdit .='<div onclick="window.location='.'http://google.com/'.$elementId.'">'.$value->content.'</div>';


            }else{
                $component .= $value->element;
            }

             
            

            //$result->template2 = str_replace('$content'.$k,$component['conteudo'][$k], $string);

            //'<a href="'.'sfdhsjhdfkshdfjkshd'.'">'.$teste.'</a>'; 
    
                
        }
         $result->template2 = $result->template;

        foreach ($getAllElements as $key => $value) {
                
                $key++;
                
                //$component['elementos'][$key] = $value->element;  
                $string  = $result->template;
                $string2  = $result->template2;

                $result->template = str_replace('$allElement',$component, $string);
                $result->template2 = str_replace('$allElement',$componentEdit, $string2);
                
        }

        #TODO
        //armazena os conteúdo nos elementos 
        foreach ($getAllContents as $k => $content) {
            $k++;
            $component['conteudo'][$k] = $content->content;  

            $string  = $result->template;
            $string2  = $result->template2;
            $result->template = str_replace('$content'.$k,$component['conteudo'][$k], $string);
            $result->template2 = str_replace('$content'.$k,$component['conteudo'][$k], $string2);
            
            
        }

        //carregar os elementos 
        $getAllElements      = $element->getAllElementByMaquinetaId($result->maquineta_id);
        
        $result->elements = $getAllElements; 


        //salvar repositorio
            $modelProject   = new Project();
            $modelCourse    = new Course();
            $modelModule    = new Module();

            $module     = $modelModule->getModuleById($result->modulo_id);
            $course     = $modelCourse->getCourseById($module[0]->course_id);
            $project    = $modelProject->getProjectById($course[0]->project_id);


            $courseName     = $course[0]->name;
            $moduleName     = $module[0]->name;
            $projectName    = $project[0]->name;

            $dirProject = preg_replace('/[^A-Za-z0-9-]/', '', $projectName);
            $dirCourse = preg_replace('/[^A-Za-z0-9-]/', '', $courseName);
            $dirModule = preg_replace('/[^A-Za-z0-9-]/', '', $moduleName);
        
        $path = env('APP_REPOSITORY').'/projetos/'.$dirProject.'/'.$dirCourse.'/'.$dirModule.'/';
        $namePagina = preg_replace('/[^A-Za-z0-9-]/', '', $result->name);
            $file = fopen($path.'/'.$namePagina.".html", "w");
            fwrite($file, $result->template);
            fclose($file);

            

        return view('admin.template.edit', compact('result')); 
    }

    public function getTemplateById($Id){

        $model = new Template();
        $result = $model->getTemplateById($Id);
        return $result;
    }

    public function getTemplateByModuleId($Id){
        $model = new Template();
        $result = $model->getTemplateByModuleId($Id);
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
