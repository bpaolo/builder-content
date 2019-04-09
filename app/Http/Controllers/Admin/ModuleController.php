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

    public function add(Request $request, Module $Module){
    	
    	try {
            //auth()->user()->Module;
            //dd(auth()->user());
            
            $template = new Template();
            $element  = new Element();
            $content  = new Content();

            //cadastrar novo modulo
            $moduleId   = $Module->addModule($request->courseId,$request->maquinetaId,$request->moduleName);
            $dataModule = $this->getModuleById($moduleId);

            //cadastrar novo template
            $dataTemplate    = $template->getTemplateById($request->templateId);
            $idTemplate      = $template->add($request->maquinetaId, $request->templateName, $dataTemplate[0]->template, $dataModule[0]->id);
            

            //cadastrar todos os elementos com o id do novo template
            $resultElement   = $element->getElementByTemplateId($request->templateId); 
            if (isset($resultElement)) {
            
                foreach ($resultElement as $f => $value) {
                        
                    $idElement[$f]['id'] = $element->add($idTemplate, 1, $value->name, $value->element);
                    $idElement[$f]['element_id'] = $value->id;
                    
                }
            }    

            //cadastrar todos os conteúdos nos elementos
            $resultElement          = $element->getElementByTemplateId($request->templateId); 

            if (isset($idElement)) {
                foreach ($idElement as $i => $valueElement) {
                       
                    $idcontent[$i]['id'] = $content->add($idTemplate, $valueElement['id'], 'digite o conteúdo do elemento'.$valueElement['id']);
                    
                }
            }    

            $result = $this->getNewTemplateByTemplateId($idTemplate);

            
            

            /*$result = (object)[
                'moduleId'         => $dataModule[0]->id,
                'moduleName'       => $request->moduleName,
                'templateId'       => $request->templateId,
                'templateName'     => $dataTemplate[0]->name,
                'templateNameNew'  => $request->templateName,
                'projectName'      => $request->projectName,
                'maquinetaId'      => $request->maquinetaId,
                'maquinetaName'    => $request->maquinetaName,
                'courseId'         => $request->courseId,
                'courseName'       => $request->courseName,
                'template'         => $dataTemplate[0]->template
                ]; */ 

            
            //cria arquivo html
            $file = fopen($result->name.".html", "w");
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

            

            $result['course']       = $course->getCourseById($request->id);
            $result['project']      = $project->getProjectById($result['course'][0]->project_id);
            $result['maquineta']    = $maquineta->getMaquinetaById($result['course'][0]->maquineta_id);
            $result['template']     = $template->getTemplateByMaquinetaId($result['course'][0]->maquineta_id);


            $resultElement          = $element->getElementByTemplateId(1); 
            $contents = $content->getAllContentBytemplateId(1);
            

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




                'templates'     => $result['template']
                ]; 

                         
            return view('admin.module.listModule', compact('result'));
              
        } catch (Exception $e) {
            
        }
                
    }
}
