<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Project;
use App\Models\Maquineta;
use App\Models\Course;
use App\Models\Template;
use App\Models\Element;
use App\Models\Content;

class ModuleController extends Controller
{
    public function index(){
    	return view('admin.module.index');
    }

    public function getModuleById($Id){
        $module = new Module();
        return $module->getModuleById($Id);
    }

    public function getModuleByCorseId($Id){
        $module = new Module();
        return $module->getModuleByCorseId($Id);
    }

    

    public function add(Request $request, Module $Module){
    	
    	try {
            //auth()->user()->Module;
            //dd(auth()->user());
            
            

            $template = new Template();
            $element  = new Element();
            $content  = new Content();

            if(!empty($request->moduleId)){
                //edit
            $moduleId = $request->moduleId;
            }else{
                //cadastrar novo modulo
            $moduleId   = $Module->addModule($request->courseId,$request->maquinetaId,$request->moduleName);
            }

            
            $dataModule = $this->getModuleById($moduleId);
            
            //cadastrar novo template
            $dataTemplate    = $template->getTemplateById($request->templateId);
            $idTemplate      = $template->add($request->maquinetaId, $request->templateName, $dataTemplate[0]->template, $dataModule[0]->id);
            

            $result = $this->getNewTemplateByTemplateId($idTemplate);


            //salvar repositorio
            $modelProject = new Project();
            $modelCourse = new Course();

            $course     = $modelCourse->getCourseById($dataModule[0]->course_id);
            $project    = $modelProject->getProjectById($course[0]->project_id);

            $courseName     = $course[0]->name;
            $moduleName     = $dataModule[0]->name;
            $projectName    = $project[0]->name;

            $dirProject = preg_replace('/[^A-Za-z0-9-]/', '', $projectName);
            $dirCourse = preg_replace('/[^A-Za-z0-9-]/', '', $courseName);
            $dirModule = preg_replace('/[^A-Za-z0-9-]/', '', $moduleName);


            if(!is_dir(env('APP_REPOSITORY').'/projetos/'.$dirProject.'/'.$dirCourse.'/'.$dirModule.'/')) { 
                mkdir(env('APP_REPOSITORY').'/projetos/'.$dirProject.'/'.$dirCourse.'/'.$dirModule.'/', 0777, true);
            }

            $path = env('APP_REPOSITORY').'/projetos/'.$dirProject.'/'.$dirCourse.'/'.$dirModule.'/';
                 
                 
            //cria arquivo html
            $namePagina = preg_replace('/[^A-Za-z0-9-]/', '', $result->name);
            $file = fopen($path.'/'.$namePagina.".html", "w");
            fwrite($file, $result->template);
            fclose($file);

            
            return redirect('/home/admin/template/edit/'.$result->id);
  

            // return view('admin.content.listContent', compact('result'));  
                
        } catch (Exception $e) {
            
        }
    }

    public function getNewTemplateByTemplateId($idTemplate){
        
        $course     = new Course();
        $project    = new Project();
        $maquineta  = new Maquineta();
        $template   = new Template();
        $element    = new Element();
        $content    = new Content();

        $result['template']     = $template->getTemplateById($idTemplate);
        $resultElement          = $element->getElementByTemplateId($idTemplate); 
        $contents               = $content->getAllContentBytemplateId($idTemplate);

        //armazena os elementos no template
            foreach ($resultElement as $key => $value) {
                $key++;

                $component['elementos'][$key] = $value->element;  

                $string  = $result['template'][0]->template;
                $result['template'][0]->template = str_replace('$element'.$key,$component['elementos'][$key], $string);

            }

            //armazena os conteúdo nos elementos 
            foreach ($contents as $k => $content) {
                $k++;
                $component['conteudo'][$k] = $content->content;  

                $string  = $result['template'][0]->template;
                $result['template'][0]->template = str_replace('$content'.$k,$component['conteudo'][$k], $string);

            }


        return (object)$result['template'][0]; 
    }

    public function listModule(Request $request, $id){
        
        try {

            $course     = new Course();
            $project    = new Project();
            $maquineta  = new Maquineta();
            $template   = new Template();
            $element    = new Element();
            $content    = new Content();
            $module    = new Module();

            $result['modulo'] = null;

            if(isset($request->modId)){
            $result['modulo']       = $module->getModuleById($request->modId);
            }


            $result['course']       = $course->getCourseById($request->id);


            $result['project']      = $project->getProjectById($result['course'][0]->project_id);
            $result['maquineta']    = $maquineta->getMaquinetaById($result['course'][0]->maquineta_id);
            $result['template']     = $template->getTemplateByMaquinetaId($result['course'][0]->maquineta_id);

            $resultElement          = $element->getElementByTemplateId($result['template'][0]->id); 
            $contents = $content->getAllContentBytemplateId($result['template'][0]->id);
            

            //armazena os elementos no template
            foreach ($resultElement as $key => $value) {
                $key++;

                $component['elementos'][$key] = $value->element;  

                $string  = $result['template'][0]->template;
                $result['template'][0]->template = str_replace('$element'.$key,$component['elementos'][$key], $string);

            }

            //armazena os conteúdo nos elementos 
            foreach ($contents as $k => $content) {
                $k++;
                $component['conteudo'][$k] = $content->content;  

                $string  = $result['template'][0]->template;
                $result['template'][0]->template = str_replace('$content'.$k,$component['conteudo'][$k], $string);

            }

            //carregar os template da view

            $result = (object)[
                'projectId'     => $result['project'][0]->id,
                'projectName'   => $result['project'][0]->name,
                'maquinetaId'   => $result['maquineta'][0]->id,
                'maquinetaName' => $result['maquineta'][0]->name,
                'courseId'      => $result['course'][0]->id,
                'courseName'    => $result['course'][0]->name,
                'moduleId'      => (isset($result['modulo'][0]->id) ? $result['modulo'][0]->id : null),
                'moduleName'    => (isset($result['modulo'][0]->name) ? $result['modulo'][0]->name : null),
                'templates'     => $result['template']
                ]; 

                       
            return view('admin.module.listModule', compact('result'));
              
        } catch (Exception $e) {
            
        }
                
    }
}
