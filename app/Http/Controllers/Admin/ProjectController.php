<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Course;
use App\Models\Module;
use App\Models\Template;

class ProjectController extends Controller
{
    public function getProjectById($Id, Project $project){
        return $project->getProjectById($Id);
    }

    public function index(){
    	return view('admin.project.index');
    }

    public function add(){
        $p  = new Project(); 
        $result = $p->getAll();
        //dd($result);
    	return view('admin.project.add', compact('result'));
    }

    public function addProject(Request $request, Project $project){
    	
        try {
            //auth()->user()->project;
            //dd(auth()->user());
            

            $name = $request->name;
            
            $dir = preg_replace('/[^A-Za-z0-9-]/', '', $request->name);


            if(is_dir(env('APP_REPOSITORY').'/projetos/'.$dir.'/')) { 
                return back()->withError('erro');
            }
            else { 
                mkdir(env('APP_REPOSITORY').'/projetos/'.$dir.'/', 0777, true);
            }
            $project->addProject($name);

            
            
            return redirect('/home/admin/course/listProject')->with('mensagem', 'Projeto Cadastrado com sucesso!');
            
        } catch (Exception $e) {
            
        }
    }

    public function edit($Id, Course $course){
        
        $moduleModel   = new Module();
        $projectModel  = new Project();
        $templateModel = new Template();
        $dt['project'] = $projectModel->getProjectById($Id);
        $dt['project']['cursos'] = $course->getCourseByProjectId($Id);
        
        $i = 0;

        //modulo
        foreach ($dt['project']['cursos'] as $key => $value) {

             $dt['project']['cursos'][$key]->modulos = $moduleModel->getModuleByCorseId($value->id);
             
             
            //$dt['project']['cursos'][$key]
            foreach ($dt['project']['cursos'][$key]->modulos as $i => $v) {
            
               $dt['project']['cursos'][$key]->modulos[$i]->template = $templateModel->getTemplateByModuleId($v->id);
            }    
        
        } 

        $result = (object)$dt;
        
        return view('admin.project.edit', compact('result'));
        
    }
           

            	
            
}
