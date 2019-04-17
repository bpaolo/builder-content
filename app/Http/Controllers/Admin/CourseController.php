<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Project;
use App\Models\Maquineta;

class CourseController extends Controller
{
    public function index(){
    	return view('admin.course.index');
    }

    public function getCourseById($Id, Course $Course){
        return $Course->getCourseById($Id);
    }

    public function getCourseByProjectId($Id, Course $Course){
        return $Course->getCourseByProjectId($Id);
    }
    

    public function add(Request $request, Course $Course){
    	
    	//auth()->user()->Course;
    	//dd(auth()->user());
    	try {
        
            $name = $request->courseName;
            $projectId = $request->projectId;
            $maquinetaId = $request->maquinetaId;
            $id = $Course->addCourse($name,$projectId,$maquinetaId);  
            return redirect('/home/admin/module/listModule/'.$id);

        } catch (Exception $e) {
            
        }
    }

    public function listProject(Request $request){
        
        try {


            $project = new Project();
            $maquineta = new Maquineta();

            
            if($request->projectId){
                $project = $project->getProjectById($request->projectId)[0];
            }else{
                $project = $project->getProject()[0];
            }    
            
                                  
            $data = [
                'projectId' => $project->id,
                'projectName' => $project->name
                ]; 

            $data['maquineta']       = (object)$maquineta->list();
            
            $result = (object)$data;
            
            return view('admin.course.listProject', compact('result'));
              
        } catch (Exception $e) {
            
        }
                
    }


    public function getCourseByProjectIdAndMaquinetaID($projectID, $maquinetaId)
    {
        try {

            $course = new Course();
            return $course->getCourseByProjectIdAndMaquinetaID($projectID, $maquinetaId);
        
        } catch (Exception $e) {
            
        }
        
    }

    public function getModuleByCorseId($Id)
    {
        try {

            $course = new Course();
            return $course->getModuleByCorseId($Id);
        
        } catch (Exception $e) {
            
        }
        
    }




    
}
